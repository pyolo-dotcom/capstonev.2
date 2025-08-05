<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Code Scanner</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="{{ asset('/public/images/logo.jpg') }}" type="image/jpg">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins';
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100%;
        }

        .content {
            margin-left: 250px;
            padding: 25px;
            flex-grow: 1;
            background-color: white;
            min-height: 100vh;
        }

        .scanner-container {
            margin-top: 30px;
            width: 100%;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #reader {
            width: 100%;
            max-width: 400px;
            aspect-ratio: 1 / 1;
            height: auto;
            min-height: 250px;
            margin: auto;
            border: 3px solid #2c3e50;
            border-radius: 10px;
            background: #000;
            box-sizing: border-box;
            display: block;
        }

        #result {
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
            color: green;
        }

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

        /* Styled alert guide */
        .alert.alert-info {
            margin-top: 30px;
            background-color: #e9f5ff;
            border: 1px solid #b6e0fe;
            border-left: 5px solid #0d6efd;
            border-radius: 6px;
            padding: 20px;
            color: #084298;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .alert.alert-info h5 {
            font-weight: 600;
            font-size: 18px;
        }

        .alert.alert-info ul {
            padding-left: 20px;
        }

        .alert.alert-info ul li {
            margin-bottom: 8px;
            font-size: 15px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .content {
                margin-left: 0;
                padding: 15px;
            }

            .scanner-container {
                max-width: 100%;
                padding: 0 10px;
            }

            #reader {
                max-width: 100%;
                min-height: 180px;
                aspect-ratio: 1 / 1;
            }

            .alert.alert-info {
                padding: 15px;
                font-size: 14px;
            }

            .alert.alert-info h5 {
                font-size: 16px;
            }

            .alert.alert-info ul li {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            #reader {
                min-height: 120px;
                max-width: 100%;
                aspect-ratio: 1 / 1;
            }
        }
    </style>
    

</head>

<body>
    <div class="sidebar">
        <ul>
            <x-managernavbar />
        </ul>
    </div>

    <div class="content">
        <div class="content-header">
            <h2><i class="fas fa-qrcode me-2"></i>QR Code Scanner</h2>
        </div>
        
        <div class="scanner-container">
            

    <!-- Scanner Card -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Scan Cargo QR Code</h2>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center mb-3">
                <button id="switchCamera" class="btn btn-primary me-2">
                    <i class="fas fa-camera"></i> Switch Camera
                </button>
                <button id="sendData" class="btn btn-success">
                    <i class="fas fa-paper-plane"></i> Send Data
                </button>
            </div>
            <div id="reader" class="mx-auto"></div>
            <div id="result" class="mt-3 text-center"></div>
        </div>
    </div>
    </div>

    <div class="alert alert-info text-start" role="alert" style="font-size: 15px; /* Consider moving this to CSS */">
        <h5 class="mb-2"><i class="fas fa-info-circle me-2"></i>About This Scanner</h5>
        <ul class="mb-0 ps-3">
            <li>This QR scanner is used to scan cargo information encoded in the QR codes.</li>
            <li>Make sure the QR code is clearly visible and fits inside the box.</li>
            <li>After scanning, the cargo details will be shown and submitted to the system.</li>
            <li>Only valid QR codes generated by the system will work.</li>
        </ul>
    </div>

    <script>
        let scanner;
        let currentCameraId = null;
        let cameras = [];
        let scannedCodes = new Set();

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
                    if (scannedCodes.has(decodedText)) {
                        console.warn("QR code already scanned:", decodedText);
                        Swal.fire({ title: 'Duplicate QR Code', text: 'This QR code has already been scanned.', icon: 'warning' });
                        return;
                    }

                    try {
                        let scannedData = JSON.parse(decodedText);
                        console.log("Processed scanned data:", scannedData);
                        
                        // Validate required fields
                        if (!scannedData.plate_no || !scannedData.eir_no || !scannedData.container_van_no || 
                            !scannedData.size || !scannedData.shipper || !scannedData.consignee || 
                            !scannedData.voyage_vessel || !scannedData.voyage_no || 
                            !scannedData.pickup_location || !scannedData.delivery_location) {
                            throw new Error("Missing required fields in QR code data");
                        }

                        document.getElementById('result').innerText = "Scanned Data: " + JSON.stringify(scannedData);
                        localStorage.setItem("scannedCargoData", JSON.stringify(scannedData));
                        scannedCodes.add(decodedText);
                        sendScannedData(scannedData);
                    } catch (error) {
                        console.error("Error processing scanned data:", error);
                        Swal.fire({ 
                            title: 'Error', 
                            text: 'Invalid QR code format: ' + error.message, 
                            icon: 'error' 
                        });
                    }
                },
                (error) => {
                    console.warn("QR Scan failed:", error);
                }
            ).catch(err => {
                console.error("QR Scanner failed to start:", err);
                Swal.fire({ 
                    title: 'Scanner Error', 
                    text: 'Failed to initialize QR scanner. Check camera permissions.', 
                    icon: 'error' 
                });
            });
        }

function sendScannedData(data) {
    // Ensure all required fields are present and properly formatted
    const postData = {
        plate_no: data.plate_no || '',
        eir_no: data.eir_no || '',
        container_van_no: data.container_van_no || '',
        size: data.size || '',
        shipper: data.shipper || '',  // Make sure this matches your backend
        consignee: data.consignee || '',  // Make sure this matches your backend
        voyage_vessel: data.voyage_vessel || '',
        voyage_no: data.voyage_no || '',
        pickup_location: data.pickup_location || '',
        delivery_location: data.delivery_location || '',
        status: 'Pending'  // Add this if your backend expects it
    };

    console.log("Sending data to server:", postData);

    // Show loading indicator
    Swal.fire({
        title: 'Processing',
        html: 'Sending cargo data...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    axios.post("{{ route('cargo.scanned') }}", postData, {
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            "Content-Type": "application/json",
            "Accept": "application/json"
        }
    })
    .then(response => {
        // Close loading indicator
        Swal.close();
        
        if (response.data.error) {
            throw new Error(response.data.error);
        }

        // Show success message with cargo details
        const cargo = response.data.cargo || response.data.data;
        let cargoDetails = `
            <div style="text-align: left;">
                <p><strong>Plate No:</strong> ${cargo.plate_no || 'N/A'}</p>
                <p><strong>EIR No:</strong> ${cargo.eir_no || 'N/A'}</p>
                <p><strong>Container Van No:</strong> ${cargo.container_van_no || 'N/A'}</p>
                <p><strong>Size:</strong> ${cargo.size || 'N/A'}</p>
                <p><strong>Shipper:</strong> ${cargo.shipper || 'N/A'}</p>
                <p><strong>Consignee:</strong> ${cargo.consignee || 'N/A'}</p>
                <p><strong>Voyage Vessel:</strong> ${cargo.voyage_vessel || 'N/A'}</p>
                <p><strong>Voyage Number:</strong> ${cargo.voyage_no || 'N/A'}</p>
                <p><strong>Pickup Location:</strong> ${cargo.pickup_location || 'N/A'}</p>
                <p><strong>Delivery Location:</strong> ${cargo.delivery_location || 'N/A'}</p>
            </div>
        `;

        Swal.fire({
            title: 'Success!',
            html: cargoDetails,
            icon: 'success',
            customClass: { popup: 'swal-wide' },
            confirmButtonText: 'OK'
        });

        // Clear the scanned data display
        document.getElementById('result').innerText = '';
        localStorage.removeItem("scannedCargoData");
    })
    .catch(error => {
        console.error("Error details:", error.response);
        let errorMessage = "Failed to store cargo details";
        
        if (error.response) {
            // Server responded with a status code that falls out of 2xx
            if (error.response.data && error.response.data.message) {
                errorMessage = error.response.data.message;
            }
            if (error.response.data && error.response.data.errors) {
                errorMessage += "\n" + Object.values(error.response.data.errors).join("\n");
            }
        } else if (error.request) {
            // Request was made but no response received
            errorMessage = "No response from server";
        } else {
            // Something happened in setting up the request
            errorMessage = error.message;
        }
        
        Swal.fire({ 
            title: 'Error', 
            text: errorMessage, 
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
}
        document.addEventListener("DOMContentLoaded", function () {
            Html5Qrcode.getCameras().then(camList => {
                if (camList.length === 0) {
                    Swal.fire({ 
                        title: 'Camera Error', 
                        text: 'No cameras found. Please check your camera permissions.', 
                        icon: 'error' 
                    });
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
                    Swal.fire({ 
                        title: 'Camera Info', 
                        text: 'Only one camera detected.', 
                        icon: 'info' 
                    });
                }
            });

            // Check for any previously scanned data in localStorage
            const savedData = localStorage.getItem("scannedCargoData");
            if (savedData) {
                try {
                    const data = JSON.parse(savedData);
                    Swal.fire({
                        title: 'Resend Data?',
                        text: 'Found previously scanned data. Would you like to send it again?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, send again',
                        cancelButtonText: 'No, discard'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            sendScannedData(data);
                        } else {
                            localStorage.removeItem("scannedCargoData");
                        }
                    });
                } catch (e) {
                    localStorage.removeItem("scannedCargoData");
                }
            }
        });
    </script>

</body>
</html>