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

// Haversine formula to calculate distance
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
            return; // Exit loop if successful
        } catch (error) {
            console.error(`❌ Attempt ${attempt + 1} failed for truck ${truckId}:`, error);
        }
    }

    console.error("❌ Failed to update truck after multiple attempts.");
}

// Function to track driver location
navigator.geolocation.watchPosition(
    async position => {
        let latitude = position.coords.latitude;
        let longitude = position.coords.longitude;
        let accuracy = position.coords.accuracy; // Accuracy in meters

        console.log(`📍 GPS Accuracy: ${accuracy} meters`);
        
        if (accuracy > 50) { // Ignore low-accuracy readings
            console.warn("⚠️ GPS accuracy too low, skipping update.");
            return;
        }

        let lastLocation = await getFromDB("latestLocation");
        let totalDistance = await getFromDB("totalDistance") || 0;

        if (lastLocation) {
            let distance = haversine(lastLocation.latitude, lastLocation.longitude, latitude, longitude);
            if (distance > 0.01) { // Ignore small movements to prevent false tracking
                totalDistance += distance;
            }
        }

        await updateDB({ latitude, longitude }, totalDistance);
        
        let truckId = "{{ Auth::user()->truck_id ?? '' }}".trim();
        sendLocation(truckId, latitude, longitude, totalDistance);
    },
    error => console.error("❌ Geolocation error:", error),
    { enableHighAccuracy: true, maximumAge: 0, timeout: 10000 }
);
    </script>
</body>
</html>
