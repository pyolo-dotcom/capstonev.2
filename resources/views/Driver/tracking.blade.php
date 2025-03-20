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

    function haversine(lat1, lon1, lat2, lon2) {
        const R = 6371; // Earth's radius in km
        const toRad = angle => angle * (Math.PI / 180);
        let dLat = toRad(lat2 - lat1);
        let dLon = toRad(lon2 - lon1);
        let a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
        let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function sendLocation(truckId, latitude, longitude) {
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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

    async function updateDriverLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(async position => {
                let latitude = position.coords.latitude;
                let longitude = position.coords.longitude;
                let lastLocation = await getFromDB("latestLocation");
                let totalDistance = await getFromDB("totalDistance") || 0;

                if (lastLocation) {
                    let distance = haversine(lastLocation.latitude, lastLocation.longitude, latitude, longitude);
                    totalDistance += distance;
                }

                saveToDB("latestLocation", { latitude, longitude });
                saveToDB("totalDistance", totalDistance);

                console.log(`📍 New Location: ${latitude}, ${longitude}`);
                console.log(`🚛 Total Distance Today: ${totalDistance.toFixed(2)} km`);

                let truckId = "{{ Auth::user()->truck_id ?? '' }}".trim(); // Ensure truckId is defined
                sendLocation(truckId, latitude, longitude);
            }, error => console.error("❌ Geolocation error:", error));
        } else {
            console.error("❌ Geolocation is not supported by this browser.");
        }
    }

    function resetDistance() {
        saveToDB("totalDistance", 0);
        console.log("🔄 Total distance reset to 0 km");
    }

    setInterval(updateDriverLocation, 5000); // Update every 5 seconds
    setInterval(resetDistance, 24 * 60 * 60 * 1000); // Reset every 24 hours
</script>
</body>
</html>
