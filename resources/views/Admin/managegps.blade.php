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

        .tab-container {
            margin-bottom: 20px;
        }

        .tab-buttons {
            display: flex;
            border-bottom: 1px solid #ddd;
        }

        .tab-button {
            padding: 10px 20px;
            background: #f1f1f1;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            border-radius: 5px 5px 0 0;
            margin-right: 5px;
        }

        .tab-button.active {
            background: #3498db;
            color: white;
        }

        .tab-content {
            display: none;
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }

        .tab-content.active {
            display: block;
        }

        .status {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: 500;
        }

        .status.connected {
            background-color: #d4edda;
            color: #155724;
        }

        .status.connecting {
            background-color: #fff3cd;
            color: #856404;
        }

        .status.disconnected,
        .status.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status i {
            margin-left: 5px;
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

        <div class="tab-container">
            <div class="tab-buttons">
                <button class="tab-button active" onclick="openTab(event, 'local-tracking')">Local Tracking</button>
                <button class="tab-button" onclick="openTab(event, 'flespi-tracking')">Flespi GPS Device</button>
            </div>
            
            <!-- Local Tracking Tab -->
            <div id="local-tracking" class="tab-content active">
                <div class="map-container" id="map"></div>

                <div class="truck-list" id="truck-list">
                    <h3>Active Trucks</h3>
                    <div id="truck-items">
                        <p>Loading truck data...</p>
                    </div>
                </div>
            </div>
            
            <!-- Flespi GPS Device Tab -->
            <div id="flespi-tracking" class="tab-content">
                <div class="map-container" id="flespi-map"></div>
                
                <div class="truck-info">
                    <h3>Flespi GPS Device Information</h3>
                    <p><strong>Device ID:</strong> <span id="flespi-device-id">{{ env('FLESPI_DEVICE_ID') }} (TKSTAR TK905B)</span></p>
                    <p><strong>Status:</strong> <span id="flespi-status" class="status connecting">Connecting... <i class="fas fa-sync-alt fa-spin"></i></span></p>
                    <p><strong>Last Update:</strong> <span id="flespi-last-update">--:--:--</span></p>
                    <p><strong>Position:</strong> <span id="flespi-position">Latitude: --, Longitude: --</span></p>
                    <p><strong>Speed:</strong> <span id="flespi-speed">-- km/h</span></p>
                    <p><strong>Altitude:</strong> <span id="flespi-altitude">-- meters</span></p>
                    <p><strong>Battery:</strong> <span id="flespi-battery">--%</span></p>
                    <div class="button-group">
                        <button class="btn btn-primary" onclick="refreshFlespiData()">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                        <button class="btn btn-success" onclick="centerFlespiMap()">
                            <i class="fas fa-map-marker-alt"></i> Center Map
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="connection-status" class="connection-status polling">
            Connecting...
        </div>

        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
        <script>
        // Configuration
        const flespiConfig = {
            deviceId: {{ env('FLESPI_DEVICE_ID') }},
            token: "{{ env('FLESPI_TOKEN') }}",
            restEndpoint: "https://flespi.io/gw/devices"
        };

        // Global variables
        let map;
        let flespiMap;
        const markers = {};
        const infoWindows = {};
        let updateInterval;
        let firstLoad = true;
        let pusher = null;
        let echoChannel = null;
        let lastUpdateTime = null;
        let flespiMarker = null;
        let flespiInfoWindow = null;
        let flespiUpdateInterval = null;

        // Initialize the map
        function initMap() {
            // Initialize local tracking map
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                mapTypeId: 'roadmap',
                styles: [{
                    "featureType": "poi",
                    "stylers": [{ "visibility": "off" }]
                }]
            });

            // Initialize Flespi map
            initFlespiMap();

            // Set up local tracking
            setupWebSocketConnection();
            updateTruckLocations();
        }

        // Initialize Flespi Map
        function initFlespiMap() {
            flespiMap = new google.maps.Map(document.getElementById('flespi-map'), {
                zoom: 15,
                mapTypeId: 'roadmap',
                center: { lat: 14.5995, lng: 120.9842 }, // Default to Manila coordinates
                styles: [{
                    "featureType": "poi",
                    "stylers": [{ "visibility": "off" }]
                }]
            });

            // Create initial marker (hidden until we get data)
            flespiMarker = new google.maps.Marker({
                position: { lat: 0, lng: 0 },
                map: null, // Start with no map
                title: "Flespi GPS Device",
                icon: {
                    url: "http://maps.google.com/mapfiles/kml/shapes/truck.png",
                    scaledSize: new google.maps.Size(40, 40),
                    anchor: new google.maps.Point(20, 20)
                }
            });

            // Create info window
            flespiInfoWindow = new google.maps.InfoWindow({
                content: '<div>Loading device information...</div>'
            });

            // Marker click listener
            flespiMarker.addListener('click', () => {
                flespiInfoWindow.open(flespiMap, flespiMarker);
            });

            // Start updating position
            updateFlespiPosition();
            flespiUpdateInterval = setInterval(updateFlespiPosition, 10000); // Update every 10 seconds
        }

        // Update Flespi device position
        function updateFlespiPosition() {
            fetch('/get-flespi-location')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data) {
                        const position = {
                            lat: parseFloat(data.data.latitude),
                            lng: parseFloat(data.data.longitude)
                        };

                        // Update marker
                        updateFlespiMarker(position, data.data);

                        // Update status
                        updateFlespiStatus('Connected', 'connected');

                        // Update info display
                        updateFlespiDeviceInfo(data.data);
                    } else {
                        updateFlespiStatus('No position data', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error fetching Flespi location:', error);
                    updateFlespiStatus('Connection error', 'error');
                });
        }

        // Update Flespi marker position
        function updateFlespiMarker(position, data) {
            // Show marker if hidden
            if (!flespiMarker.getMap()) {
                flespiMarker.setMap(flespiMap);
            }

            // Smooth animation
            if (flespiMarker.getPosition()) {
                const numSteps = 10;
                let step = 0;
                const oldPosition = flespiMarker.getPosition();
                const latStep = (position.lat - oldPosition.lat()) / numSteps;
                const lngStep = (position.lng - oldPosition.lng()) / numSteps;
                
                function animateMarker() {
                    if (step >= numSteps) {
                        flespiMarker.setPosition(position);
                        return;
                    }
                    
                    const newPos = {
                        lat: oldPosition.lat() + (latStep * step),
                        lng: oldPosition.lng() + (lngStep * step)
                    };
                    
                    flespiMarker.setPosition(newPos);
                    step++;
                    requestAnimationFrame(animateMarker);
                }
                
                animateMarker();
            } else {
                flespiMarker.setPosition(position);
            }

            // Center map on first update
            if (!flespiMap.getCenter() || flespiMap.getCenter().lat() === 0) {
                flespiMap.setCenter(position);
            }

            // Update info window
            updateFlespiInfoWindow(data);
        }

        // Update Flespi info window content
        function updateFlespiInfoWindow(data) {
            const timestamp = new Date(data.timestamp);
            const batteryLevel = data.battery ? Math.round(data.battery) : '--';
            const speed = data.speed ? parseFloat(data.speed).toFixed(1) : '--';
            const altitude = data.altitude ? parseFloat(data.altitude).toFixed(1) : '--';

            const content = `
                <div style="min-width: 200px">
                    <h4 style="margin: 0 0 10px 0;">Flespi GPS Device</h4>
                    <p style="margin: 5px 0;"><strong>Device ID:</strong> ${data.device_id}</p>
                    <p style="margin: 5px 0;"><strong>Last Update:</strong> ${timestamp.toLocaleString()}</p>
                    <p style="margin: 5px 0;"><strong>Position:</strong> ${data.latitude.toFixed(6)}, ${data.longitude.toFixed(6)}</p>
                    <p style="margin: 5px 0;"><strong>Speed:</strong> ${speed} km/h</p>
                    <p style="margin: 5px 0;"><strong>Altitude:</strong> ${altitude} m</p>
                    <p style="margin: 5px 0;"><strong>Battery:</strong> ${batteryLevel}%</p>
                </div>
            `;

            flespiInfoWindow.setContent(content);
        }

        // Update Flespi device info display
        function updateFlespiDeviceInfo(data) {
            const timestamp = new Date(data.timestamp);
            document.getElementById('flespi-last-update').textContent = timestamp.toLocaleString();
            
            document.getElementById('flespi-position').textContent = 
                `Latitude: ${data.latitude.toFixed(6)}, Longitude: ${data.longitude.toFixed(6)}`;
            
            if (data.speed) {
                const speed = parseFloat(data.speed).toFixed(1);
                document.getElementById('flespi-speed').textContent = `${speed} km/h`;
            }
            
            if (data.altitude) {
                const altitude = parseFloat(data.altitude).toFixed(1);
                document.getElementById('flespi-altitude').textContent = `${altitude} meters`;
            }
            
            if (data.battery) {
                const battery = Math.round(data.battery);
                const batteryElement = document.getElementById('flespi-battery');
                batteryElement.textContent = `${battery}%`;
                
                // Color coding
                if (battery > 60) {
                    batteryElement.style.color = 'green';
                } else if (battery > 30) {
                    batteryElement.style.color = 'orange';
                } else {
                    batteryElement.style.color = 'red';
                }
            }
        }

        // Update Flespi connection status
        function updateFlespiStatus(text, type) {
            const statusElement = document.getElementById('flespi-status');
            statusElement.textContent = text;
            statusElement.className = `status ${type}`;
            
            // Add appropriate icon
            const icons = {
                connected: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                connecting: 'fa-sync-alt fa-spin',
                disconnected: 'fa-plug'
            };
            
            statusElement.innerHTML = `${text} <i class="fas ${icons[type] || 'fa-info-circle'}"></i>`;
        }

        // Manual refresh
        function refreshFlespiData() {
            updateFlespiStatus("Refreshing...", "connecting");
            updateFlespiPosition();
        }

        // Center map on marker
        function centerFlespiMap() {
            if (flespiMarker.getPosition()) {
                flespiMap.setCenter(flespiMarker.getPosition());
                flespiMap.setZoom(17);
                flespiInfoWindow.open(flespiMap, flespiMarker);
            }
        }

        // Call this when switching to Flespi tab
        function onFlespiTabOpen() {
            if (flespiMap) {
                google.maps.event.trigger(flespiMap, 'resize');
                if (flespiMarker.getPosition()) {
                    flespiMap.setCenter(flespiMarker.getPosition());
                }
            }
        }

        // Tab switching function
        function openTab(evt, tabName) {
            const tabContents = document.getElementsByClassName("tab-content");
            for (let i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove("active");
            }

            const tabButtons = document.getElementsByClassName("tab-button");
            for (let i = 0; i < tabButtons.length; i++) {
                tabButtons[i].classList.remove("active");
            }

            document.getElementById(tabName).classList.add("active");
            evt.currentTarget.classList.add("active");
            
            // Handle map resize and centering
            setTimeout(() => {
                if (tabName === 'flespi-tracking') {
                    onFlespiTabOpen();
                } else {
                    google.maps.event.trigger(map, 'resize');
                    // Center the local tracking map if needed
                    if (Object.keys(markers).length > 0) {
                        const firstMarker = markers[Object.keys(markers)[0]];
                        map.setCenter(firstMarker.getPosition());
                    }
                }
            }, 100);
        }

        // Set up WebSocket connection for local tracking
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
                    updateTruckOnMap(data.location);
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
            
            if (updateInterval) clearInterval(updateInterval);
            
            updateInterval = setInterval(updateTruckLocations, 1000);
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
            
            const currentPos = markers[truck.truck_id].getPosition();
            if (currentPos && 
                currentPos.lat() === position.lat && 
                currentPos.lng() === position.lng) {
                return;
            }

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
            
            const currentContent = infoWindows[truck.truck_id].getContent();
            const newContent = buildInfoWindowContent(truck);
            if (currentContent !== newContent) {
                infoWindows[truck.truck_id].setContent(newContent);
            }
        }

        // Build info window content
        function buildInfoWindowContent(truck) {
            const distance = parseFloat(truck.total_distance) || 0;
            const speed = Math.max(0, parseFloat(truck.speed) || 0);
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

            if (container.innerHTML !== newHtml) {
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
                    
                    if (item.innerHTML !== newHtml) {
                        item.innerHTML = newHtml;
                    }
                    found = true;
                }
            });
            
            if (!found && truck.truck_id) {
                updateTruckLocations();
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
            // First confirm the reset
            Swal.fire({
                title: "Reset Distance?",
                text: "This will reset the total distance to 0 and record fuel consumption",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, reset it!",
            }).then((confirmResult) => {
                if (confirmResult.isConfirmed) {
                    // Now prompt for fuel price
                    Swal.fire({
                        title: 'Enter Fuel Price',
                        input: 'number',
                        inputLabel: 'Current fuel price per liter',
                        inputPlaceholder: 'Enter price (e.g. 60.50)',
                        inputAttributes: {
                            step: "0.01",
                            min: "1"
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Submit',
                        showLoaderOnConfirm: true,
                        preConfirm: (price) => {
                            if (!price || isNaN(price) || price <= 0) {
                                Swal.showValidationMessage('Please enter a valid fuel price');
                                return false;
                            }
                            return price;
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((priceResult) => {
                        if (priceResult.isConfirmed) {
                            const fuelPrice = parseFloat(priceResult.value);
                            
                            // Send the request with the fuel price
                            fetch(`/reset-distance/${truck_id}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ fuel_price: fuelPrice })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(err => {
                                        throw new Error(err.message || 'Reset failed');
                                    });
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: "Success!",
                                        text: data.message,
                                        icon: "success"
                                    });
                                    
                                    // Update UI
                                    updateTruckDistanceUI(truck_id);
                                } else {
                                    Swal.fire("Error", data.message || "Failed to reset distance", "error");
                                }
                            })
                            .catch(error => {
                                Swal.fire("Error", error.message || "Failed to reset distance", "error");
                            });
                        }
                    });
                }
            });
        };

        function updateTruckDistanceUI(truck_id) {
            // Update marker info window
            if (markers[truck_id]) {
                const content = infoWindows[truck_id].getContent();
                const newContent = content.replace(
                    /<strong>Distance:<\/strong> [0-9.]+ km/,
                    '<strong>Distance:</strong> 0.00 km'
                );
                infoWindows[truck_id].setContent(newContent);
            }
            
            // Update truck list item
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

        // Cleanup on page unload
        window.addEventListener('beforeunload', () => {
            if (updateInterval) clearInterval(updateInterval);
            if (flespiUpdateInterval) clearInterval(flespiUpdateInterval);
            if (pusher) pusher.disconnect();
        });
        </script>
    </div>
</body>
</html>