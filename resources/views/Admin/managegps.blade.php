<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Truck Tracking System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100%;
        }

        .content {
            margin-left: 250px;
            padding: 25px;
            flex-grow: 1;
            background-color: white;
            min-height: 100vh;
        }

        .content-header {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-header h2 {
            color: #1f1a5c;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }

        .map-container {
            height: 600px;
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .truck-info {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .truck-list {
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .truck-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .truck-item:last-child {
            border-bottom: none;
        }

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
        
        /* Button Styles */
        .button-group {
            display: flex;
            gap: 5px;
            margin-top: 10px;
        }
        
        .btn {
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
            text-align: center;
            flex: 1;
        }
        
        .btn-primary {
            background-color: #3498db;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
        }
        
        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #c0392b;
        }
        
        .btn-sm {
            padding: 5px 8px;
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
            }
            
            .content {
                margin-left: 0;
            }
            
            .map-container {
                height: 400px;
            }
            
            .button-group {
                flex-direction: column;
                gap: 3px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <x-navbar />
        </ul>
    </div>

    <div class="content">
        <div class="content-header">
            <h2><i class="fas fa-truck me-2"></i>Live Truck Tracking</h2>
            <div id="last-updated">Last updated: --:--:--</div>
        </div>

        <div class="map-container" id="map"></div>

        <div class="truck-list" id="truck-list">
            <h3>Active Trucks</h3>
            <div id="truck-items">
                <p>Loading truck data...</p>
            </div>
        </div>
    </div>

    <div id="connection-status" class="connection-status polling">
        Connecting...
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
    <script>
        // Global variables
        let map;
        const markers = {};
        const infoWindows = {};
        let updateInterval;
        let firstLoad = true;
        let pusher = null;
        let echoChannel = null;
        let lastUpdateTime = null;

        // Initialize the map
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                mapTypeId: 'roadmap',
                styles: [{
                    "featureType": "poi",
                    "stylers": [{ "visibility": "off" }]
                }]
            });

            // Try to connect via WebSockets first
            setupWebSocketConnection();
            
            // Initial load via AJAX
            updateTruckLocations();
        }

        // Set up WebSocket connection
        function setupWebSocketConnection() {
            try {
                pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                    cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                    encrypted: true,
                    authEndpoint: '/broadcasting/auth',
                    auth: {
                        headers: {
                            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                        }
                    }
                });

                echoChannel = pusher.subscribe('tracking');
                
                echoChannel.bind('location.updated', (data) => {
                    updateConnectionStatus('realtime');
                    updateLastUpdatedTime();
                    
                    // Update the specific truck that changed
                    updateTruckOnMap(data.location);
                    
                    // Also update the truck list
                    updateTruckListItem(data.location);
                });

                echoChannel.bind('pusher:subscription_succeeded', () => {
                    updateConnectionStatus('realtime');
                    console.log('WebSocket connected successfully');
                });

                echoChannel.bind('pusher:subscription_error', (status) => {
                    console.error('WebSocket subscription error:', status);
                    fallbackToPolling();
                });

            } catch (e) {
                console.error('WebSocket setup failed:', e);
                fallbackToPolling();
            }
        }

        // Fall back to polling if WebSockets fail
        function fallbackToPolling() {
            updateConnectionStatus('polling');
            
            // Clear any existing interval
            if (updateInterval) clearInterval(updateInterval);
            
            // Set up polling every second
            updateInterval = setInterval(updateTruckLocations, 1000);
            
            // Do an immediate update
            updateTruckLocations();
        }

        // Update connection status display
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

        // Fetch and update truck locations via AJAX
        function updateTruckLocations() {
            fetch('/get-live-locations', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                cache: 'no-cache'
            })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (!Array.isArray(data)) {
                        throw new Error('Invalid data format');
                    }

                    updateLastUpdatedTime();
                    
                    if (data.length === 0) {
                        document.getElementById('truck-items').innerHTML = '<p>No active trucks found</p>';
                        return;
                    }

                    updateTruckList(data);
                    data.forEach(updateTruckOnMap);
                })
                .catch(error => {
                    console.error('Error fetching truck locations:', error);
                    updateConnectionStatus('error');
                    
                    // Retry after 2 seconds if there's an error
                    setTimeout(updateTruckLocations, 2000);
                });
        }

        // Update truck on map
        function updateTruckOnMap(truck) {
            if (!truck?.latitude || !truck?.longitude) return;

            const position = {
                lat: parseFloat(truck.latitude),
                lng: parseFloat(truck.longitude)
            };

            // Auto-center on first load
            if (firstLoad) {
                map.setCenter(position);
                map.setZoom(15);
                firstLoad = false;
            }

            if (!markers[truck.truck_id]) {
                createNewMarker(truck, position);
            } else {
                updateExistingMarker(truck, position);
            }
        }

        // Create new marker
        function createNewMarker(truck, position) {
            markers[truck.truck_id] = new google.maps.Marker({
                position: position,
                map: map,
                title: `${truck.fullname || 'Driver'} (${truck.truck_id})`,
                icon: {
                    url: "http://maps.google.com/mapfiles/kml/shapes/truck.png",
                    scaledSize: new google.maps.Size(40, 40),
                    anchor: new google.maps.Point(20, 20)
                }
            });

            infoWindows[truck.truck_id] = new google.maps.InfoWindow({
                content: buildInfoWindowContent(truck)
            });

            markers[truck.truck_id].addListener('click', () => {
                Object.values(infoWindows).forEach(iw => iw.close());
                infoWindows[truck.truck_id].open(map, markers[truck.truck_id]);
            });
        }

        // Update existing marker
        function updateExistingMarker(truck, position) {
            if (!markers[truck.truck_id]) return;
            
            // Only update if position has changed
            const currentPos = markers[truck.truck_id].getPosition();
            if (currentPos && 
                currentPos.lat() === position.lat && 
                currentPos.lng() === position.lng) {
                return;
            }

            // Smooth animation for marker movement
            const numSteps = 10;
            let step = 0;
            const oldPosition = markers[truck.truck_id].getPosition();
            const latStep = (position.lat - oldPosition.lat()) / numSteps;
            const lngStep = (position.lng - oldPosition.lng()) / numSteps;
            
            function animateMarker() {
                if (step >= numSteps) {
                    markers[truck.truck_id].setPosition(position);
                    return;
                }
                
                const newPos = {
                    lat: oldPosition.lat() + (latStep * step),
                    lng: oldPosition.lng() + (lngStep * step)
                };
                
                markers[truck.truck_id].setPosition(newPos);
                step++;
                requestAnimationFrame(animateMarker);
            }
            
            animateMarker();
            
            // Update info window content if data has changed
            const currentContent = infoWindows[truck.truck_id].getContent();
            const newContent = buildInfoWindowContent(truck);
            if (currentContent !== newContent) {
                infoWindows[truck.truck_id].setContent(newContent);
            }
        }

        // Build info window content
        function buildInfoWindowContent(truck) {
            const distance = parseFloat(truck.total_distance) || 0;
            const speed = Math.max(0, parseFloat(truck.speed) || 0); // Ensure speed is never negative
            return `
                <div style="min-width: 200px">
                    <h4 style="margin: 0 0 10px 0;">${truck.fullname || 'Driver'}</h4>
                    <p style="margin: 5px 0;"><strong>Plate No:</strong> ${truck.truck_id}</p>
                    <p style="margin: 5px 0;"><strong>Distance:</strong> ${distance.toFixed(2)} km</p>
                    <p style="margin: 5px 0;"><strong>Speed:</strong> ${speed.toFixed(2)} km/h</p>
                    <div class="button-group">
                        <button class="btn btn-primary" onclick="focusOnTruck('${truck.truck_id}')">
                            Focus
                        </button>
                        <button class="btn btn-danger" onclick="resetDistance('${truck.truck_id}')">
                            Reset
                        </button>
                    </div>
                </div>
            `;
        }

        // Update truck list
        function updateTruckList(trucks) {
            const container = document.getElementById('truck-items');
            
            // Only update if data has changed
            const currentHtml = container.innerHTML;
            const newHtml = trucks.map(truck => {
                const distance = parseFloat(truck.total_distance) || 0;
                const speed = parseFloat(truck.speed) || 0;
                return `
                    <div class="truck-item">
                        <div>
                            <strong>${truck.truck_id}</strong> - ${truck.fullname || 'Driver'}
                            <div style="font-size: 0.8em; color: #666;">
                                ${distance.toFixed(2)} km | ${speed.toFixed(2)} km/h
                            </div>
                        </div>
                        <div>
                            <div class="button-group">
                                <button class="btn btn-primary btn-sm" onclick="focusOnTruck('${truck.truck_id}')">
                                    Focus
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="resetDistance('${truck.truck_id}')">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            if (currentHtml !== newHtml) {
                container.innerHTML = newHtml || '<p>No active trucks found</p>';
            }
        }

        // Update individual truck in list
        function updateTruckListItem(truck) {
            const items = document.querySelectorAll('.truck-item');
            let found = false;
            
            items.forEach(item => {
                if (item.textContent.includes(truck.truck_id)) {
                    const distance = parseFloat(truck.total_distance) || 0;
                    const speed = parseFloat(truck.speed) || 0;
                    const newHtml = `
                        <div>
                            <strong>${truck.truck_id}</strong> - ${truck.fullname || 'Driver'}
                            <div style="font-size: 0.8em; color: #666;">
                                ${distance.toFixed(2)} km | ${speed.toFixed(2)} km/h
                            </div>
                        </div>
                        <div>
                            <div class="button-group">
                                <button class="btn btn-primary btn-sm" onclick="focusOnTruck('${truck.truck_id}')">
                                    Focus
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="resetDistance('${truck.truck_id}')">
                                    Reset
                                </button>
                            </div>
                        </div>
                    `;
                    
                    // Only update if content has changed
                    if (item.innerHTML !== newHtml) {
                        item.innerHTML = newHtml;
                    }
                    found = true;
                }
            });
            
            // If truck not found in list, add it
            if (!found && truck.truck_id) {
                updateTruckLocations(); // Refresh the whole list
            }
        }

        // Update last updated time
        function updateLastUpdatedTime() {
            const now = new Date();
            const options = { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit',
                hour12: true 
            };
            document.getElementById('last-updated').textContent = 
                `Last updated: ${now.toLocaleTimeString('en-PH', options)}`;
        }

        // Global functions
        window.focusOnTruck = function(truck_id) {
            if (markers[truck_id]) {
                map.setCenter(markers[truck_id].getPosition());
                map.setZoom(17);
                infoWindows[truck_id].open(map, markers[truck_id]);
            }
        };

        window.resetDistance = function(truck_id) {
            Swal.fire({
                title: "Reset Distance?",
                text: "This will reset the total distance to 0 for this truck",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, reset it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/reset-distance/' + truck_id, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Reset failed');
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire("Reset!", "Distance has been reset to 0.", "success");
                            
                            // Update the specific truck's distance to 0 in the UI
                            if (markers[truck_id]) {
                                const content = infoWindows[truck_id].getContent();
                                const newContent = content.replace(
                                    /<strong>Distance:<\/strong> [0-9.]+ km/,
                                    '<strong>Distance:</strong> 0.00 km'
                                );
                                infoWindows[truck_id].setContent(newContent);
                            }
                            
                            // Update in the list
                            const items = document.querySelectorAll('.truck-item');
                            items.forEach(item => {
                                if (item.textContent.includes(truck_id)) {
                                    const html = item.innerHTML.replace(
                                        /[0-9.]+ km \|/,
                                        '0.00 km |'
                                    );
                                    item.innerHTML = html;
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Error resetting distance:", error);
                        Swal.fire("Error", "Failed to reset distance.", "error");
                    });
                }
            });
        };

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (updateInterval) clearInterval(updateInterval);
            if (pusher) pusher.disconnect();
        });
    </script>
</body>
</html>