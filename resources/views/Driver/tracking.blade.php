<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Live Truck Tracking</title>
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{
            font-family:'Poppins';
               }
        body { font-family: Arial; max-width: 600px; margin: 0 auto; padding: 20px; }
        #status { padding: 10px; margin: 10px 0; background: #f0f0f0; }
        .success { background: #d4edda; }
        .error { background: #f8d7da; }
        .connection-status {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 15px;
            border-radius: 5px;
            background: #f8f9fa;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            font-size: 14px;
        }
        .connection-status.realtime {
            background: #d4edda;
            color: #155724;
        }
        .connection-status.polling {
            background: #fff3cd;
            color: #856404;
        }
        .connection-status.error {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h2>Live Truck Tracking</h2>
    <div id="status">Initializing GPS...</div>
    <div>
        <p>Latitude: <span id="latitude">0</span></p>
        <p>Longitude: <span id="longitude">0</span></p>
        <p>Accuracy: <span id="accuracy">0</span> meters</p>
        <p>Speed: <span id="speed">0</span> km/h</p>
        <p>Distance: <span id="distance">0</span> km</p>
    </div>
    <div id="connection-status" class="connection-status polling">Using Polling</div>

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        const truckId = "{{ Auth::user()->truck_id ?? 'TEST_TRUCK' }}";
        let watchId = null;
        let lastPosition = null;
        let totalDistance = 0;
        let updateInterval = null;
        let lastUpdateTime = null;

        // Initialize Pusher for real-time updates
        try {
            const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                encrypted: true
            });

            const channel = pusher.subscribe('tracking');
            channel.bind('location.updated', function(data) {
                if (data.truck_id === truckId) {
                    updateConnectionStatus('realtime');
                }
            });
        } catch (e) {
            console.error('Pusher initialization failed:', e);
        }

        function updateConnectionStatus(status) {
            const element = document.getElementById('connection-status');
            element.className = `connection-status ${status}`;
            
            switch(status) {
                case 'realtime':
                    element.textContent = 'Real-time (WebSocket)';
                    break;
                case 'polling':
                    element.textContent = 'Using Polling (1s interval)';
                    break;
                case 'error':
                    element.textContent = 'Connection Error';
                    break;
            }
        }

        function updateStatus(message, isError = false) {
            const status = document.getElementById('status');
            status.textContent = message;
            status.className = isError ? 'error' : 'success';
            console.log(message);
        }

        async function updatePosition(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const acc = position.coords.accuracy;
            let spd = position.coords.speed ? Math.max(0, position.coords.speed * 3.6) : 0; // Convert m/s to km/h and ensure non-negative

            document.getElementById('latitude').textContent = lat.toFixed(6);
            document.getElementById('longitude').textContent = lng.toFixed(6);
            document.getElementById('accuracy').textContent = acc.toFixed(2);
            document.getElementById('speed').textContent = spd.toFixed(2);

            // Calculate distance if we have a previous position
            if (lastPosition) {
                const distance = calculateDistance(
                    lastPosition.coords.latitude,
                    lastPosition.coords.longitude,
                    lat,
                    lng
                );
                totalDistance += distance;
                document.getElementById('distance').textContent = totalDistance.toFixed(4);
            }

            lastPosition = position;
            lastUpdateTime = new Date();

            try {
                const response = await fetch('/update-location', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        truck_id: truckId,
                        latitude: lat,
                        longitude: lng,
                        total_distance: totalDistance,
                        speed: spd,
                        timestamp: lastUpdateTime.toISOString()
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.message || 'Server error');
                }

                const data = await response.json();
                updateStatus(`Updated at ${new Date().toLocaleTimeString()}`);
                console.log('Server response:', data);
            } catch (error) {
                let errorMessage = error.message;
                
                if (errorMessage.includes('500')) {
                    errorMessage = 'Server error - please try again later';
                }
                
                updateStatus(`Error: ${errorMessage}`, true);
                console.error('Error details:', error);
            }
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Earth radius in km
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a = 
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
                Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
            return R * c;
        }

        function deg2rad(deg) {
            return deg * (Math.PI/180);
        }

        function handleError(error) {
            let message = 'Error: ';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    message += "Location access denied";
                    break;
                case error.POSITION_UNAVAILABLE:
                    message += "Location unavailable";
                    break;
                case error.TIMEOUT:
                    message += "Request timed out";
                    break;
                default:
                    message += error.message;
            }
            updateStatus(message, true);
            updateConnectionStatus('error');
        }

        if (navigator.geolocation) {
            updateStatus("Getting location...");
            
            navigator.geolocation.getCurrentPosition(
                position => {
                    updatePosition(position);
                    watchId = navigator.geolocation.watchPosition(
                        updatePosition,
                        handleError,
                        {
                            enableHighAccuracy: true,
                            maximumAge: 0,
                            timeout: 5000
                        }
                    );
                    
                    // Fallback polling in case WebSockets fail
                    updateInterval = setInterval(() => {
                        if (lastPosition) {
                            updatePosition(lastPosition);
                        }
                    }, 1000);
                },
                handleError,
                {
                    enableHighAccuracy: true,
                    timeout: 10000
                }
            );
        } else {
            updateStatus("Geolocation not supported", true);
        }

        window.addEventListener('beforeunload', () => {
            if (watchId) navigator.geolocation.clearWatch(watchId);
            if (updateInterval) clearInterval(updateInterval);
        });
    </script>
</body>
</html>