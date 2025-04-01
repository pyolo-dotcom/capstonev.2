<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargo QR Code</title>
    <!-- Add SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        html, body {
            height: 100%;
            overflow: hidden;
        }

        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #333;
            padding: 20px;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
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
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            height: 100vh;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
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
        #cargoForm input, #cargoForm select {
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

        /* Clear Button */
        #cargoForm button.clear-btn {
            background: #e74c3c;
        }

        #cargoForm button.clear-btn:hover {
            background: #c0392b;
        }

        /* QR Code Container */
        #qrCodeContainer {
            text-align: center;
            margin-top: 20px;
            padding-bottom: 40px;
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                overflow-y: visible;
            }

            .content {
                margin-left: 0;
                padding: 15px;
                height: auto;
                min-height: calc(100vh - 200px);
            }

            #cargoForm {
                width: 100%;
                margin: 0;
                padding: 10px;
            }

            #cargoForm h2 {
                margin-left: 0;
                text-align: center;
            }

            #cargoForm input, #cargoForm select {
                font-size: 14px;
                padding: 8px;
            }

            #cargoForm button {
                font-size: 14px;
                padding: 8px;
            }

            #qrCodeContainer {
                margin-top: 15px;
            }
        }

        @media (max-width: 480px) {
            #cargoForm input, #cargoForm select {
                font-size: 12px;
                padding: 6px;
            }

            #cargoForm button {
                font-size: 12px;
                padding: 6px;
            }
        }
    </style>
</head>

<body>

    <x-drivernavbar />

    <div class="content">
        <form id="cargoForm">
            <h2>Generate QR Code:</h2>
            <select name="plate_no" id="plate_no" required>
                <option value="">Select Plate No</option>
                <option value="UVP 353">UVP 353</option>
                <option value="TQE 262">TQE 262</option>
                <option value="NBB 7212">NBB 7212</option>
                <option value="APA 3309">APA 3309</option>
                <option value="WIE 914">WIE 914</option>
            </select>
            <input type="text" name="eir_no" id="eir_no" placeholder="EIR No" required>
            <input type="text" name="container_van_no" id="container_van_no" placeholder="Container Van No" required>
            <input type="text" name="size" id="size" placeholder="Size" required>
            <input type="text" name="shipper_consignee" id="shipper_consignee" placeholder="Shipper/Consignee" required>
            <input type="text" name="voyage_vessel" id="voyage_vessel" placeholder="Voyage Vessel" required>
            <input type="text" name="voyage_no" id="voyage_no" placeholder="Voyage Number" required>
            <input type="text" name="pickup_location" id="pickup_location" placeholder="Pickup Location" required>
            <input type="text" name="delivery_location" id="delivery_location" placeholder="Delivery Location" required>
            <button type="submit">Generate QR Code</button>
            <button type="button" class="clear-btn" onclick="clearSavedFormData()">Clear Form</button>
        </form>

        <div id="qrCodeContainer"></div>
    </div>

    <!-- Add SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Save form data to localStorage whenever any input changes
        document.getElementById('cargoForm').addEventListener('input', function() {
            saveFormData();
        });

        // Form submission handler
        document.getElementById("cargoForm").addEventListener("submit", function(event) {
            event.preventDefault();
            saveFormData();
            generateQRCode();
        });

        // Function to save form data
        function saveFormData() {
            const formData = {
                plate_no: document.getElementById('plate_no').value,
                eir_no: document.getElementById('eir_no').value,
                container_van_no: document.getElementById('container_van_no').value,
                size: document.getElementById('size').value,
                shipper_consignee: document.getElementById('shipper_consignee').value,
                voyage_vessel: document.getElementById('voyage_vessel').value,
                voyage_no: document.getElementById('voyage_no').value,
                pickup_location: document.getElementById('pickup_location').value,
                delivery_location: document.getElementById('delivery_location').value
            };
            localStorage.setItem('cargoFormData', JSON.stringify(formData));
        }

        // Function to generate QR code
        function generateQRCode() {
            const formData = JSON.parse(localStorage.getItem('cargoFormData') || '{}');
            
            axios.get("{{ url('/cargo/qrcode') }}", {
                    params: formData
                })
                .then(response => {
                    document.getElementById('qrCodeContainer').innerHTML = response.data;
                    document.getElementById('qrCodeContainer').scrollIntoView({ 
                        behavior: 'smooth' 
                    });
                })
                .catch(error => {
                    console.log(error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to generate QR code',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        }

        // Restore form data when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const savedData = localStorage.getItem('cargoFormData');
            if (savedData) {
                const formData = JSON.parse(savedData);
                
                // Restore all fields
                for (const [key, value] of Object.entries(formData)) {
                    const element = document.getElementById(key);
                    if (element) {
                        if (element.tagName === 'SELECT') {
                            // For dropdowns
                            for (let option of element.options) {
                                if (option.value === value) {
                                    option.selected = true;
                                    break;
                                }
                            }
                        } else {
                            // For input fields
                            element.value = value;
                        }
                    }
                }
                
                // Regenerate QR code if there was one
                if (formData.plate_no) {
                    generateQRCode();
                }
            }
        });

        // Clear form data
        function clearSavedFormData() {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will clear all form data and the QR code!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, clear it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.removeItem('cargoFormData');
                    document.getElementById('cargoForm').reset();
                    document.getElementById('qrCodeContainer').innerHTML = '';
                    document.getElementById('plate_no').selectedIndex = 0;
                    
                    Swal.fire(
                        'Cleared!',
                        'Your form has been cleared.',
                        'success'
                    );
                }
            });
        }
    </script>
</body>

</html>