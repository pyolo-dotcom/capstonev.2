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
        @media (max-width: 768px) {
        body {
            flex-direction: column; /* Stack sidebar and content vertically */
        }

        .sidebar {
            width: 100%; /* Full width for the sidebar */
            height: auto; /* Adjust height */
            position: relative; /* Remove fixed positioning */
        }

        .content {
            margin-left: 0; /* Remove left margin */
            padding: 10px; /* Add padding for better spacing */
        }

        #cargoForm {
            width: 100%; /* Full width for the form */
            margin: 0; /* Remove auto centering */
            padding: 10px; /* Add padding for better spacing */
        }

        #cargoForm h2 {
            margin-left: 0; /* Align heading properly */
            text-align: center; /* Center the heading */
        }

        #cargoForm input {
            font-size: 14px; /* Adjust font size for smaller screens */
            padding: 8px; /* Adjust padding for inputs */
        }

        #cargoForm button {
            font-size: 14px; /* Adjust button font size */
            padding: 8px; /* Adjust button padding */
        }

        #qrCodeContainer {
            margin-top: 15px; /* Adjust spacing for QR code container */
        }
    }

    @media (max-width: 480px) {
        #cargoForm input {
            font-size: 12px; /* Further reduce font size for very small screens */
            padding: 6px; /* Adjust padding for inputs */
        }

        #cargoForm button {
            font-size: 12px; /* Further reduce button font size */
            padding: 6px; /* Adjust button padding */
        }
    }
    </style>
</head>

<body>

    <x-drivernavbar />

    <div class="content">
        <form id="cargoForm">
            <h2>Generate QR Code:</h2>
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
