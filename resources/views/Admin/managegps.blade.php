<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <title>Truck Tracking</title>
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
        .map-container {
            height: 400px;
            width: 90%;
            margin-left: 53px;
            background-color: #e0e0e0;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .driver-details {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .driver {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            flex: 1;
            min-width: 200px;
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="sidebar">
        <h2>Sidebar Menu</h2>
        <ul>
            <x-navbar/>
        </ul>
    </div>

    <div class="content">
        <div id="gps-control">
            <h3>GPS Control</h3>
            <div id="live-trucks">
                <h4>Live Trucks</h4>
                <div class="map-container" id="map"></div>
            </div>
        </div>
    </div>

    <script>
var map;
var markers = {}; // Store markers by truck_id

// Initialize Google Maps
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: { lat: 15.48, lng: 120.94 } // Default location in Nueva Ecija
    });

    // Start fetching truck locations every 5 seconds
    updateLocation();
    setInterval(updateLocation, 5000);
}

// Fetch and update truck locations
function updateLocation() {
    fetch('/get-locations')
        .then(response => response.json())
        .then(data => {
            console.log("🔄 Updated truck locations:", data);

            // Remove markers that are no longer active
            for (let truckId in markers) {
                if (!data.some(truck => truck.truck_id === truckId)) {
                    markers[truckId].setMap(null);
                    delete markers[truckId];
                }
            }

            data.forEach(truck => {
                let position = { lat: parseFloat(truck.latitude), lng: parseFloat(truck.longitude) };

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

                    let infoWindow = new google.maps.InfoWindow();
                    markers[truck.truck_id].addListener('click', () => {
                        infoWindow.setContent(`
                            <b>Driver:</b> ${truck.fullname}<br>
                            <b>Truck ID:</b> ${truck.truck_id}<br>
                            <b>Latitude:</b> ${truck.latitude}<br>
                            <b>Longitude:</b> ${truck.longitude}
                        `);
                        infoWindow.open(map, markers[truck.truck_id]);
                    });

                } else {
                    markers[truck.truck_id].setPosition(position);
                }
            });
        })
        .catch(error => console.error("❌ Error fetching truck locations:", error));
}
</script>
</body>
</html>