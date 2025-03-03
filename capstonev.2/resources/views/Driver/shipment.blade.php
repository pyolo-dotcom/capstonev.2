<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <title>Sidebar Menu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display:q flex;
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
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Sidebar Menu</h2>
        <ul>
            <x-drivernavbar/>
        </ul>
    </div>
    <div class="content">
        <h3>Shipment Progress</h3>
            <div class="status-container">
                <div class="status-item" id="pending-status">
                    <div class="status-number">1</div>
                    <p>Pending</p>
                </div>
                <div class="status-item" id="in-transit-status">
                    <div class="status-number">2</div>
                    <p>In Transit</p>
                </div>
                <div class="status-item" id="delivered-status">
                    <div class="status-number">3</div>
                    <p>Delivered</p>
                </div>
            </div>
            <div class="status-bar">
                <div class="progress-bar" style="position: relative;"></div>
                <i class="fa-solid fa-truck" alt="Truck"></i>
            </div>
            <div class="cargo-container">
                <div class="cargo-details">
                    <!-- Left Side: Cargo Text Details -->
                    <div class="cargo-info">
                        <h2 style="margin-left: 60%">Cargo Details</h2>
                        <p><strong>Date:</strong> 31/10/2024</p>
                        <p><strong>Plate No.:</strong> N88 7212</p>
                        <p><strong>EIR No.:</strong> LKJUIGJHB324356</p>
                        <p><strong>Container Van No.</strong> WRDFHGV46576 | 20DC</p>
                        <p><strong>Size:</strong> 20DC</p>
                        <p><strong>Shipper/Consignee:</strong> Century Pacific Food</p>
                        <p><strong>Voyage Vessel</strong> LCDM </p>
                        <p><strong>No.:</strong> 2345</p>
                        <p><strong>Pickup Location:</strong> CYVTA</p>
                        <p><strong>Delivery location:</strong> MNLP16</p>
                        <p><strong>Status:</strong> In Transit</p>
                    </div>
                    <!-- Right Side: QR Code -->
                    @include('Driver.modals.qrmodal')
                    <div id="qrModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <h2>QR CODE</h2>
                            <div id="qrCodeContainer" style="margin-left: 70px"></div>
                        </div>
                    </div>

                    <!-- Button to Generate QR Code -->
                    <button id="generateQrBtn" class="qr-btn">Generate QR Code</button>
                </div>
    </div>
</body>
</html>
