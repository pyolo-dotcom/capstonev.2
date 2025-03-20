<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <x-managernavbar/>
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
var distances = {}; // Store total distances

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: { lat: 15.48, lng: 120.94 } // Default location
    });

    updateLocation();
    updateDistances();
    setInterval(updateLocation, 5000);
    setInterval(updateDistances, 60000); // Update every 1 minute
}

function updateLocation() {
    fetch('/get-locations')
        .then(response => response.json())
        .then(data => {
            console.log("🔄 Updated truck locations:", data);

            data.forEach(truck => {
                let position = { lat: parseFloat(truck.latitude), lng: parseFloat(truck.longitude) };

                if (!markers[truck.truck_id]) {
                    // Create a new marker if it doesn't exist
                    markers[truck.truck_id] = new google.maps.Marker({
                        position: position,
                        map: map,
                        title: `${truck.fullname} (Truck ${truck.truck_id})`,
                        icon: {
                            url: "http://maps.google.com/mapfiles/kml/shapes/truck.png",
                            scaledSize: new google.maps.Size(40, 40)
                        }
                    });

                    // Create an InfoWindow
                    let infoWindow = new google.maps.InfoWindow();

                    // Add click event listener
                    markers[truck.truck_id].addListener('click', () => {
                        let distance = parseFloat(truck.total_distance) || 0; // Ensure it's a number
                        infoWindow.setContent(`
                            Driver: ${truck.fullname} <br>
                            Plate Number: ${truck.truck_id} <br>
                            Latitude: ${truck.latitude} <br>
                            Longitude: ${truck.longitude} <br>
                            Total Distance: ${distance.toFixed(2)} km
                        `);
                        infoWindow.open(map, markers[truck.truck_id]);
                    });

                } else {
                    // Update existing marker position
                    markers[truck.truck_id].setPosition(position);
                }
            });
        })
        .catch(error => console.error("❌ Error fetching truck locations:", error));
}

// Fetch and update truck distances
function updateDistances() {
    fetch('/get-truck-distance')
        .then(response => response.json())
        .then(data => {
            console.log("📏 Updated truck distances:", data);

            data.forEach(truck => {
                distances[truck.truck_id] = parseFloat(truck.total_distance) || 0;
            });
        })
        .catch(error => console.error("❌ Error fetching truck distances:", error));
}
</script>
</body>
</html>