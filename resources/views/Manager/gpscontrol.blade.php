<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Truck Tracking System</title>
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="{{ asset('public/images/logo.jpg') }}" type="image/jpg">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins';
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

        #last-updated {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .map-container {
            height: 600px;
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .truck-list {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <x-managernavbar />
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
        var map;
        var markers = {};
        var pusher = null;
        var channel = null;
        
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 15.48, lng: 120.94},
                zoom: 10
            });
            
            // Initialize Pusher for real-time updates
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
                
                channel = pusher.subscribe('tracking');
                channel.bind('location.updated', function(data) {
                    updateConnectionStatus('realtime');
                    updateTruckPosition(data);
                });
                
                updateConnectionStatus('realtime');
            } catch (e) {
                console.error('Pusher initialization failed:', e);
                updateConnectionStatus('polling');
            }
            
            // Initial load and periodic updates
            loadTruckData();
            setInterval(loadTruckData, 1000); // Changed from 5000 to 1000
        }
        
        function loadTruckData() {
            fetch('/get-locations')
                .then(response => response.json())
                .then(data => {
                    updateLastUpdated();
                    updateTruckList(data);
                    data.forEach(truck => updateTruckPosition(truck));
                })
                .catch(error => {
                    console.error('Error loading truck data:', error);
                    updateConnectionStatus('error');
                });
        }
        
        function updateTruckPosition(truck) {
            if (!truck.latitude || !truck.longitude) return;
            
            const position = {
                lat: parseFloat(truck.latitude),
                lng: parseFloat(truck.longitude)
            };
            
            if (!markers[truck.truck_id]) {
                markers[truck.truck_id] = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: `${truck.fullname} (Truck ${truck.truck_id})`,
                    icon: {
                        url: "http://maps.google.com/mapfiles/kml/shapes/truck.png",
                        scaledSize: new google.maps.Size(40, 40)
                    }
                });
                
                // Add info window
                const infoWindow = new google.maps.InfoWindow({
                    content: getTruckInfoContent(truck)
                });
                
                markers[truck.truck_id].addListener('click', () => {
                    infoWindow.open(map, markers[truck.truck_id]);
                });
            } else {
                markers[truck.truck_id].setPosition(position);
            }
        }
        
        function updateTruckList(trucks) {
            const container = document.getElementById('truck-items');
            
            if (!trucks || trucks.length === 0) {
                container.innerHTML = '<p>No active trucks found</p>';
                return;
            }
            
            let html = '';
            trucks.forEach(truck => {
                html += `
                    <div class="truck-item">
                        <div>
                            <strong>${truck.fullname}</strong><br>
                            Truck ID: ${truck.truck_id}<br>
                            Distance: ${parseFloat(truck.total_distance || 0).toFixed(2)} km
                        </div>
                        <div class="button-group">
                            <button class="btn btn-sm btn-primary" onclick="focusOnTruck('${truck.truck_id}')">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="resetDistance('${truck.truck_id}')">
                                <i class="fas fa-undo"></i>
                            </button>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }
        
        function focusOnTruck(truckId) {
            if (markers[truckId]) {
                map.setCenter(markers[truckId].getPosition());
                map.setZoom(15);
            }
        }
        
        function resetDistance(truckId) {
            Swal.fire({
                title: 'Reset Distance?',
                text: "This will reset the total distance to 0 for this truck.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, reset it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/manager/reset-distance/${truckId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Reset!',
                                'Distance has been reset.',
                                'success'
                            );
                            loadTruckData();
                        } else {
                            Swal.fire(
                                'Error!',
                                'Failed to reset distance.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire(
                            'Error!',
                            'Failed to reset distance.',
                            'error'
                        );
                    });
                }
            });
        }
        
        function updateConnectionStatus(status) {
            const element = document.getElementById('connection-status');
            element.className = `connection-status ${status}`;
            
            switch(status) {
                case 'realtime':
                    element.textContent = 'Real-time (WebSocket)';
                    break;
                case 'polling':
                    element.textContent = 'Using Polling (5s interval)';
                    break;
                case 'error':
                    element.textContent = 'Connection Error';
                    break;
            }
        }
        
        function updateLastUpdated() {
            const now = new Date();
            document.getElementById('last-updated').textContent = 
                `Last updated: ${now.toLocaleTimeString()}`;
        }
        
        function getTruckInfoContent(truck) {
            return `
                <div style="min-width: 200px">
                    <h4>${truck.fullname}</h4>
                    <p><strong>Truck ID:</strong> ${truck.truck_id}</p>
                    <p><strong>License:</strong> ${truck.driver_license_number || 'N/A'}</p>
                    <p><strong>Location:</strong> ${truck.latitude}, ${truck.longitude}</p>
                    <p><strong>Distance:</strong> ${parseFloat(truck.total_distance || 0).toFixed(2)} km</p>
                    <p><strong>Speed:</strong> ${parseFloat(truck.speed || 0).toFixed(2)} km/h</p>
                    <div class="button-group">
                        <button class="btn btn-sm btn-primary" onclick="focusOnTruck('${truck.truck_id}')">
                            <i class="fas fa-search"></i> Focus
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="resetDistance('${truck.truck_id}')">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </div>
            `;
        }
    </script>
</body>
</html>