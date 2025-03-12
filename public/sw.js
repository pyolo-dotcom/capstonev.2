self.addEventListener('install', event => {
    self.skipWaiting();
});

self.addEventListener('activate', event => {
    console.log("📡 Background GPS Tracker Activated!");
    self.clients.claim();
});

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

// Background location update every 5 seconds
setInterval(async () => {
    let truckId = await getFromDB("truckId");
    let csrfToken = await getFromDB("csrfToken");
    let locationData = await getFromDB("latestLocation");

    if (!truckId || !csrfToken || !locationData) return;

    let { latitude, longitude } = locationData;

    fetch('/update-location', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ truck_id: truckId, latitude, longitude })
    })
    .then(response => response.json())
    .then(data => {
        console.log(`📡 [Background] Truck ${truckId} updated successfully:`, data);
    })
    .catch(error => {
        console.error(`❌ [Background] Error updating truck ${truckId}:`, error);
    });
}, 5000);
