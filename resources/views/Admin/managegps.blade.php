<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage GPS</title>
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #333;
            padding: 20px;
            position: fixed;
            left: 0;
            top: 0;
        }
        .sidebar h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 15px;
            border-bottom: 1px solid #444;
        }
        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: block;
            transition: 0.3s;
        }
        .sidebar ul li a:hover {
            background: #555;
            padding-left: 10px;
        }
        .content {
            margin-left: 270px;
            padding: 20px;
            flex-grow: 1;
        }
        #map {
            height: 500px;
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Sidebar Menu</h2>
        <ul>
            <x-navbar/>
        </ul>
    </div>
    <div class="content">
        <h1>Manage GPS Tracker</h1>
        <div id="map"></div>
    </div>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbsQ9Ffb7Sv5jsXDQeQTXQeDTSv6QyOF4"></script>
    <script>
        let map;
        let marker;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 14.5995, lng: 120.9842 }, // Default location (Manila)
                zoom: 12
            });

            fetchGpsData();
            setInterval(fetchGpsData, 5000); // Auto-refresh every 5 seconds
        }

        function fetchGpsData() {
            fetch('/api/gps-data')
                .then(response => response.json())
                .then(data => {
                    const position = { lat: parseFloat(data.latitude), lng: parseFloat(data.longitude) };
                    if (marker) {
                        marker.setPosition(position); // Update marker position
                    } else {
                        marker = new google.maps.Marker({
                            position: position,
                            map: map
                        });
                    }
                    map.setCenter(position); // Center map to the new position
                });
        }

        window.onload = initMap;
    </script>
</body>
</html>