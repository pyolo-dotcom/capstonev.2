<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargo QR Code</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            height: 100vh; /* Ensure the body takes the full viewport height */
            overflow: hidden; /* Prevent body from scrolling */
        }

        .sidebar {
            width: 250px;
            height: 100vh; /* Full height of the viewport */
            background: #333;
            padding: 20px;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto; /* Enable scrolling for the sidebar */
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
            margin-left: 250px; /* Adjusted to match the sidebar width */
            padding: 20px;
            flex-grow: 1;
            overflow-y: auto; /* Enable scrolling for the content area */
            height: 100vh; /* Full height of the viewport */
        }

        #cargoForm {
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Form Inputs */
        #cargoForm input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Submit Button */
        #cargoForm button {
            background: #2c3e50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        #cargoForm button:hover {
            background: #34495e;
        }

        /* QR Code Container */
        #qrCodeContainer {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <x-drivernavbar />
    </div>

    <!-- Main Content -->
    <div class="content">
        <form id="cargoForm">
            <h2 style="text-align: center;">Generate QR Code:</h2>
            <input type="text" name="plate_no" placeholder="Plate No" required>
            <input type="text" name="eir_no" placeholder="EIR No" required>
            <input type="text" name="container_van_no" placeholder="Container Van No" required>
            <input type="text" name="size" placeholder="Size" required>
            <input type="text" name="shipper_consignee" placeholder="Shipper/Consignee" required>
            <input type="text" name="voyage_vessel" placeholder="Voyage Vessel" required>
            <input type="text" name="voyage_no" placeholder="Voyage Number" required>
            <input type="text" name="pickup_location" placeholder="Pickup Location" required>
            <input type="text" name="delivery_location" placeholder="Delivery Location" required>
            <button type="submit">Generate QR Code</button>
        </form>

        <!-- QR Code Container -->
        <div id="qrCodeContainer"></div>
    </div>

    <script>
        document.getElementById("cargoForm").addEventListener("submit", function(event) {
            event.preventDefault();

            let formData = new FormData(this);

            axios.get("{{ url('/cargo/qrcode') }}", {
                    params: Object.fromEntries(formData)
                })
                .then(response => {
                    // Insert the SVG QR code as HTML
                    document.getElementById('qrCodeContainer').innerHTML = response.data;
                })
                .catch(error => console.log(error));
        });
    </script>
</body>

</html>