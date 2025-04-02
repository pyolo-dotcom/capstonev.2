<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Background GPS Tracker</title>
</head>
<body>
    <h3>Tracking in Progress...</h3>
    <p id="status">Fetching location...</p>

    <script>
        // Open IndexedDB
        function openDB() {
            return new Promise((resolve, reject) => {
                let request = indexedDB.open("TrackingDB", 1);
                request.onupgradeneeded = event => {
                    let db = event.target.result;
                    if (!db.objectStoreNames.contains("tracking")) {
                        db.createObjectStore("tracking", { keyPath: "id" });
                    }
                };
                request.onsuccess = event => resolve(event.target.result);
                request.onerror = event => reject(event.target.error);
            });
        }

        async function saveToDB(key, value) {
            let db = await openDB();
            let tx = db.transaction("tracking", "readwrite");
            let store = tx.objectStore("tracking");
            store.put({ id: key, value });
        }

        async function getFromDB(key) {
            let db = await openDB();
            let tx = db.transaction("tracking", "readonly");
            let store = tx.objectStore("tracking");
            return new Promise((resolve, reject) => {
                let request = store.get(key);
                request.onsuccess = () => resolve(request.result ? request.result.value : null);
                request.onerror = () => reject(request.error);
            });
        }

        // Function to update multiple IndexedDB values in one transaction
        async function updateDB(location, distance) {
            let db = await openDB();
            let tx = db.transaction("tracking", "readwrite");
            let store = tx.objectStore("tracking");
            store.put({ id: "latestLocation", value: location });
            store.put({ id: "totalDistance", value: distance });
            return tx.complete;
        }

        // Calculate distance between two coordinates in meters
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371e3; // Earth's radius in meters
            const φ1 = lat1 * Math.PI / 180; // φ, λ in radians
            const φ2 = lat2 * Math.PI / 180;
            const Δφ = (lat2 - lat1) * Math.PI / 180;
            const Δλ = (lon2 - lon1) * Math.PI / 180;

            const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                      Math.cos(φ1) * Math.cos(φ2) *
                      Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            return R * c; // Distance in meters
        }

        // Function to send location to backend
        async function sendLocation(truckId, latitude, longitude, totalDistance) {
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            for (let attempt = 0; attempt < 3; attempt++) { // Retry up to 3 times
                try {
                    let response = await fetch('/update-location', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ 
                            truck_id: truckId, 
                            latitude, 
                            longitude,
                            total_distance: totalDistance
                        })
                    });

                    let data = await response.json();
                    console.log(`📡 Truck ${truckId} updated successfully:`, data);
                    document.getElementById('status').textContent = `Tracking active - Last update: ${new Date().toLocaleTimeString()}`;
                    return; // Exit loop if successful
                } catch (error) {
                    console.error(`❌ Attempt ${attempt + 1} failed for truck ${truckId}:`, error);
                    document.getElementById('status').textContent = `Error updating location (attempt ${attempt + 1})`;
                }
            }

            console.error("❌ Failed to update truck after multiple attempts.");
            document.getElementById('status').textContent = "Failed to update location after multiple attempts";
        }

        // Function to track driver location
        navigator.geolocation.watchPosition(
            async position => {
                let latitude = position.coords.latitude;
                let longitude = position.coords.longitude;
                let accuracy = position.coords.accuracy; // Accuracy in meters

                console.log(`📍 GPS Accuracy: ${accuracy} meters`);
                document.getElementById('status').textContent = `GPS accuracy: ${Math.round(accuracy)} meters`;
                
                if (accuracy > 50) { // Ignore low-accuracy readings
                    console.warn("⚠️ GPS accuracy too low, skipping update.");
                    document.getElementById('status').textContent = "Waiting for better GPS accuracy...";
                    return;
                }

                let lastLocation = await getFromDB("latestLocation");
                let totalDistance = await getFromDB("totalDistance") || 0;

                if (lastLocation) {
                    let distanceMeters = calculateDistance(
                        lastLocation.latitude, 
                        lastLocation.longitude, 
                        latitude, 
                        longitude
                    );

                    console.log(`📏 Distance moved: ${distanceMeters.toFixed(2)} meters`);

                    if (distanceMeters >= 1) { // Only update if moved at least 1 meter
                        totalDistance += distanceMeters;
                        await updateDB({ latitude, longitude }, totalDistance);
                        
                        let truckId = "{{ Auth::user()->truck_id ?? '' }}".trim();
                        if (truckId) {
                            await sendLocation(truckId, latitude, longitude, totalDistance);
                        } else {
                            console.error("No truck ID found");
                            document.getElementById('status').textContent = "Error: No truck ID assigned";
                        }
                    } else {
                        console.log("🚫 Movement less than 1 meter, skipping update");
                        document.getElementById('status').textContent = "Movement detected (<1m), waiting for significant movement...";
                    }
                } else {
                    // First time recording location
                    await updateDB({ latitude, longitude }, totalDistance);
                    let truckId = "{{ Auth::user()->truck_id ?? '' }}".trim();
                    if (truckId) {
                        await sendLocation(truckId, latitude, longitude, totalDistance);
                    }
                }
            },
            error => {
                console.error("❌ Geolocation error:", error);
                document.getElementById('status').textContent = `Error: ${error.message}`;
            },
            { 
                enableHighAccuracy: true, 
                maximumAge: 0, 
                timeout: 10000 
            }
        );
    </script>
</body>
</html>