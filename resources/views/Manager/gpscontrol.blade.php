<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <title>Truck Tracking</title>

    <!-- SweetAlert Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        .reset-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s ease-in-out;
        }
        .reset-btn:hover {
            background-color: #cc0000;
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

                    if (!Array.isArray(data) || data.length === 0) {
                        console.warn("⚠️ No truck data received.");
                        return;
                    }

                    data.forEach(truck => {
                        if (!truck.latitude || !truck.longitude) {
                            console.warn(`⚠️ Missing location data for Truck ${truck.truck_id}`, truck);
                            return;
                        }

                        let position = {
                            lat: parseFloat(truck.latitude),
                            lng: parseFloat(truck.longitude)
                        };

                        if (!markers[truck.truck_id]) {
                            console.log(`🆕 Adding marker for Truck ${truck.truck_id}`);

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
                                let distance = parseFloat(truck.total_distance) || 0;
                                infoWindow.setContent(`
                                    Driver: ${truck.fullname} <br>
                                    Plate Number: ${truck.truck_id} <br>
                                    Latitude: ${truck.latitude} <br>
                                    Longitude: ${truck.longitude} <br>
                                    Total Distance: <span id="distance-${truck.truck_id}">${distance.toFixed(2)}</span> km <br>
                                    <button class="reset-btn" onclick="resetDistance('${truck.truck_id}')">Reset Distance</button>
                                `);
                                infoWindow.open(map, markers[truck.truck_id]);
                            });

                        } else {
                            markers[truck.truck_id].setPosition(position);
                            console.log(`🔄 Updated marker for Truck ${truck.truck_id}`);
                        }
                    });
                })
                .catch(error => console.error("❌ Error fetching truck locations:", error));
        }

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

        function resetDistance(truck_id) {
            console.log("Resetting distance for truck_id:", truck_id);

            Swal.fire({
                title: "Are you sure?",
                text: "This will reset the total distance to 0.00 km!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, reset it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/reset-distance/' + encodeURIComponent(truck_id), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ truck_id: truck_id })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById(`distance-${truck_id}`).textContent = "0.00";

                            Swal.fire(
                                "Reset Successful!",
                                "Total distance has been reset to 0.00 km.",
                                "success"
                            );
                        } else {
                            Swal.fire("Error", "Failed to reset the distance. Please try again!", "error");
                        }
                    })
                    .catch(error => {
                        console.error("❌ Error resetting distance:", error);
                        Swal.fire("Error", "Something went wrong. Please try again!", "error");
                    });
                }
            });
        }
    </script>
</body>
</html>