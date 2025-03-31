<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Code Scanner</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Navbar */
        .sidebar {
            position: absolute;
            top: 0;
            left: 0;
        }

        /* Main Scanner Container */
        .scanner-container {
            margin-top: 30px;
            width: 100%;
            max-width: 500px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        #reader {
            width: 400px;
            height: 400px;
            margin: auto;
            border: 3px solid #2c3e50;
            border-radius: 10px;
        }

        #result {
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
            color: green;
        }

        /* Buttons */
        #sendData, #switchCamera {
            margin-top: 15px;
            padding: 12px;
            font-size: 16px;
            cursor: pointer;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        #sendData:hover, #switchCamera:hover {
            background-color: #1a252f;
        }

        .swal-wide {
            width: 600px !important;
        }

    </style>
</head>

<body>

    <!-- Navbar -->
    <div class="sidebar">   
        <ul>
            <x-managernavbar />
        </ul>
    </div>

    <!-- Scanner -->
    <div class="scanner-container">
        <h2>Scan Cargo QR Code</h2>
        <button id="switchCamera">Switch Camera</button>
        <div id="reader"></div>
        <div id="result"></div>
        <button id="sendData">Send Data to Server</button>
    </div>

    <script>
        let scanner;
        let currentCameraId = null;
        let cameras = [];

        function startScanner(cameraId) {
            if (scanner) {
                scanner.stop().then(() => {
                    console.log("Scanner stopped. Restarting with new camera...");
                    initializeScanner(cameraId);
                }).catch(err => console.error("Error stopping scanner:", err));
            } else {
                initializeScanner(cameraId);
            }
        }

        function initializeScanner(cameraId) {
            scanner = new Html5Qrcode("reader");
            scanner.start(
                cameraId,
                { fps: 10, qrbox: { width: 350, height: 350 }, aspectRatio: 1.0, disableFlip: true },
                (decodedText) => {
                    try {
                        let scannedData;
                        try {
                            scannedData = JSON.parse(decodedText);
                        } catch (e) {
                            if (decodedText.includes('?')) {
                                const urlParams = new URLSearchParams(decodedText.split('?')[1]);
                                scannedData = Object.fromEntries(urlParams.entries());
                            } else {
                                throw new Error("Invalid QR data format");
                            }
                        }
                        console.log("Processed scanned data:", scannedData);
                        document.getElementById('result').innerText = "Scanned Data: " + JSON.stringify(scannedData);
                        localStorage.setItem("scannedCargoData", JSON.stringify(scannedData));
                        sendScannedData(scannedData);
                    } catch (error) {
                        console.error("Error processing scanned data:", error);
                        Swal.fire({ title: 'Error', text: 'Invalid QR code format: ' + error.message, icon: 'error' });
                    }
                },
                (error) => {
                    console.warn("QR Scan failed:", error);
                }
            ).catch(err => {
                console.error("QR Scanner failed to start:", err);
                Swal.fire({ title: 'Scanner Error', text: 'Failed to initialize QR scanner. Check camera permissions.', icon: 'error' });
            });
        }

        function sendScannedData(data) {
            const postData = {
                plate_no: data.plate_no,
                eir_no: data.eir_no,
                container_van_no: data.container_van_no,
                size: data.size,
                shipper_consignee: data.shipper_consignee,
                voyage_vessel: data.voyage_vessel,
                voyage_no: data.voyage_no,
                pickup_location: data.pickup_location,
                delivery_location: data.delivery_location
            };

            console.log("Sending data to server:", postData);

            axios.post("/cargo/scanned", postData, {
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "Content-Type": "application/json"
                }
            })
            .then(response => {
                if (response.data.error) {
                    throw new Error(response.data.error);
                }

                const cargo = response.data.cargo;
                let cargoDetails = `
                    <div style="text-align: left;">
                        <p><strong>Plate No:</strong> ${cargo.plate_no || 'N/A'}</p>
                        <p><strong>EIR No:</strong> ${cargo.eir_no || 'N/A'}</p>
                        <p><strong>Container Van No:</strong> ${cargo.container_van_no || 'N/A'}</p>
                        <p><strong>Size:</strong> ${cargo.size || 'N/A'}</p>
                        <p><strong>Shipper/Consignee:</strong> ${cargo.shipper_consignee || 'N/A'}</p>
                        <p><strong>Voyage Vessel:</strong> ${cargo.voyage_vessel || 'N/A'}</p>
                        <p><strong>Voyage Number:</strong> ${cargo.voyage_no || 'N/A'}</p>
                        <p><strong>Pickup Location:</strong> ${cargo.pickup_location || 'N/A'}</p>
                        <p><strong>Delivery Location:</strong> ${cargo.delivery_location || 'N/A'}</p>
                    </div>
                `;

                Swal.fire({ title: 'Success!', html: cargoDetails, icon: 'success', customClass: { popup: 'swal-wide' } });

                localStorage.removeItem("scannedCargoData");
                document.getElementById('result').innerText = "";
            })
            .catch(error => {
                console.error("Error sending data:", error);
                Swal.fire({ title: 'Error', text: error.message || 'Failed to store cargo details', icon: 'error' });
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            Html5Qrcode.getCameras().then(camList => {
                if (camList.length === 0) {
                    Swal.fire({ title: 'Camera Error', text: 'No cameras found. Please check your camera permissions.', icon: 'error' });
                    return;
                }
                cameras = camList;
                currentCameraId = cameras[0].id;
                startScanner(currentCameraId);
            });

            document.getElementById("switchCamera").addEventListener("click", function () {
                if (cameras.length > 1) {
                    let index = cameras.findIndex(cam => cam.id === currentCameraId);
                    currentCameraId = cameras[(index + 1) % cameras.length].id;
                    startScanner(currentCameraId);
                } else {
                    Swal.fire({ title: 'Camera Info', text: 'Only one camera detected.', icon: 'info' });
                }
            });
        });
    </script>

</body>
</html>
