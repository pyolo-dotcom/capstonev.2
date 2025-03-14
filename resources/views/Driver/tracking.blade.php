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

        // Save data to IndexedDB
        async function saveToDB(key, value) {
            let db = await openDB();
            let tx = db.transaction("tracking", "readwrite");
            let store = tx.objectStore("tracking");
            store.put({ id: key, value });
        }

        // Get data from IndexedDB
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

        // Store truck ID and CSRF Token
        let truckId = "{{ Auth::user()->truck_id ?? '' }}".trim();
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        saveToDB("truckId", truckId);
        saveToDB("csrfToken", csrfToken);

        function sendLocation(truckId, latitude, longitude) {
            fetch('/update-location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ truck_id: truckId, latitude, longitude })
            })
            .then(response => response.json())
            .then(data => console.log(`📡 Truck ${truckId} updated successfully:`, data))
            .catch(error => console.error(`❌ Error updating truck ${truckId}:`, error));
        }

        function updateDriverLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;

                    saveToDB("latestLocation", { latitude, longitude });

                    console.log(`🚀 Sending location for Truck ${truckId}:`, latitude, longitude);
                    sendLocation(truckId, latitude, longitude);
                }, error => console.error("❌ Geolocation error:", error));
            } else {
                console.error("❌ Geolocation is not supported by this browser.");
            }
        }

        setInterval(updateDriverLocation, 5000);

        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js').then(() => {
                console.log("✅ Background tracking enabled!");
            }).catch(error => {
                console.error("❌ Service worker registration failed:", error);
            });
        }
    </script>
</body>
</html>
