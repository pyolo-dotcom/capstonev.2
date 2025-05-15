<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cargo QR Code</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
        
        .truck-display {
            background: #f1f3f5;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: inline-block;
            font-size: 16px;
            font-weight: 600;
            border: 1px solid #e1e5e9;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .truck-display i {
            margin-right: 12px;
            color: #495057;
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #343a40;
        }

        .form-container {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            border: 1px solid #e9ecef;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        .form-control, .form-select {
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #1f1a5c;
            box-shadow: 0 0 0 0.25rem rgba(31, 26, 92, 0.25);
        }

        .btn-primary {
            background-color: #1f1a5c;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: #161245;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-danger:hover {
            background-color: #bb2d3b;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .qr-container {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            text-align: center;
            margin-top: 25px;
            border: 1px solid #e9ecef;
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
            
            .form-container {
                padding: 15px;
            }
        }

        @media (max-width: 576px) {
            .btn-primary, .btn-danger {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <x-drivernavbar />
    </div>

    <!-- Main Content Area -->
    <div class="content">
        <!-- Truck Display -->
        <div class="truck-display">
            <i class="fas fa-truck"></i>
            <span id="assignedPlateNumber">{{ Auth::user()->truck_id ?? 'Not assigned' }}</span>
        </div>

        <h2 class="section-title">GENERATE CARGO QR CODE</h2>
        
        <!-- Form Container -->
        <div class="form-container">
            <form id="cargoForm">
                <div class="mb-3">
                    <label for="plate_no" class="form-label">Plate Number</label>
                    <input type="text" class="form-control" name="plate_no" id="plate_no" 
                           value="{{ Auth::user()->truck_id ?? '' }}" 
                           {{ Auth::user()->truck_id ? 'readonly' : '' }} required>
                </div>
                
                <div class="mb-3">
                    <label for="eir_no" class="form-label">EIR No</label>
                    <input type="text" class="form-control" name="eir_no" id="eir_no" placeholder="Enter EIR No" required>
                </div>
                
                <div class="mb-3">
                    <label for="container_van_no" class="form-label">Container Van No</label>
                    <input type="text" class="form-control" name="container_van_no" id="container_van_no" placeholder="Enter Container Van No" required>
                </div>
                
                <div class="mb-3">
                    <label for="size" class="form-label">Size</label>
                    <input type="text" class="form-control" name="size" id="size" placeholder="Enter Size" required>
                </div>
                
                <div class="mb-3">
                    <label for="shipper_consignee" class="form-label">Shipper/Consignee</label>
                    <input type="text" class="form-control" name="shipper_consignee" id="shipper_consignee" placeholder="Enter Shipper/Consignee" required>
                </div>
                
                <div class="mb-3">
                    <label for="voyage_vessel" class="form-label">Voyage Vessel</label>
                    <input type="text" class="form-control" name="voyage_vessel" id="voyage_vessel" placeholder="Enter Voyage Vessel" required>
                </div>
                
                <div class="mb-3">
                    <label for="voyage_no" class="form-label">Voyage Number</label>
                    <input type="text" class="form-control" name="voyage_no" id="voyage_no" placeholder="Enter Voyage Number" required>
                </div>
                
                <div class="mb-3">
                    <label for="pickup_location" class="form-label">Pickup Location</label>
                    <input type="text" class="form-control" name="pickup_location" id="pickup_location" placeholder="Enter Pickup Location" required>
                </div>
                
                <div class="mb-3">
                    <label for="delivery_location" class="form-label">Delivery Location</label>
                    <input type="text" class="form-control" name="delivery_location" id="delivery_location" placeholder="Enter Delivery Location" required>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-danger me-md-2" onclick="clearSavedFormData()">
                        <i class="fas fa-trash-alt me-1"></i> Clear Form
                    </button>
                    <button type="submit" class="btn btn-primary" id="generateBtn" {{ !Auth::user()->truck_id ? 'disabled' : '' }}>
                        <i class="fas fa-qrcode me-1"></i> Generate QR Code
                    </button>
                </div>
            </form>
        </div>

        <!-- QR Code Container -->
        <div id="qrCodeContainer" class="qr-container" style="display: none;">
            <h5 class="mb-3">Generated QR Code</h5>
            <div id="qrCodeImage"></div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <script>
        // Save form data to localStorage whenever any input changes
        document.getElementById('cargoForm').addEventListener('input', function() {
            saveFormData();
        });

        // Form submission handler
        document.getElementById("cargoForm").addEventListener("submit", function(event) {
            event.preventDefault();
            
            // Check if plate number is assigned
            const plateNo = document.getElementById('plate_no').value;
            if (!plateNo || plateNo === 'Not assigned') {
                Swal.fire({
                    title: 'No Plate Number Assigned',
                    text: 'You cannot generate QR codes without an assigned plate number',
                    icon: 'error',
                    confirmButtonColor: '#1f1a5c'
                });
                return;
            }
            
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
            
            // Show loading state
            Swal.fire({
                title: 'Generating QR Code',
                html: 'Please wait...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            axios.get("{{ url('/cargo/qrcode') }}", {
                    params: formData
                })
                .then(response => {
                    Swal.close();
                    document.getElementById('qrCodeImage').innerHTML = response.data;
                    document.getElementById('qrCodeContainer').style.display = 'block';
                    
                    // Scroll to QR code
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
                
                // Restore all fields except plate_no if user has an assigned truck
                const plateNoInput = document.getElementById('plate_no');
                const assignedPlateNo = "{{ Auth::user()->truck_id }}";
                
                if (assignedPlateNo) {
                    plateNoInput.value = assignedPlateNo;
                } else if (formData.plate_no) {
                    plateNoInput.value = formData.plate_no;
                }
                
                // Restore other fields
                document.getElementById('eir_no').value = formData.eir_no || '';
                document.getElementById('container_van_no').value = formData.container_van_no || '';
                document.getElementById('size').value = formData.size || '';
                document.getElementById('shipper_consignee').value = formData.shipper_consignee || '';
                document.getElementById('voyage_vessel').value = formData.voyage_vessel || '';
                document.getElementById('voyage_no').value = formData.voyage_no || '';
                document.getElementById('pickup_location').value = formData.pickup_location || '';
                document.getElementById('delivery_location').value = formData.delivery_location || '';
                
                // Regenerate QR code if there was one
                if (formData.plate_no) {
                    generateQRCode();
                }
            }
            
            // Disable generate button if no plate number is assigned
            const generateBtn = document.getElementById('generateBtn');
            const plateNo = "{{ Auth::user()->truck_id }}";
            
            if (!plateNo) {
                generateBtn.disabled = true;
                generateBtn.title = 'You need an assigned plate number to generate QR codes';
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
                    document.getElementById('qrCodeContainer').style.display = 'none';
                    
                    // Reset plate number to assigned value
                    const plateNoInput = document.getElementById('plate_no');
                    const assignedPlateNo = "{{ Auth::user()->truck_id }}";
                    if (assignedPlateNo) {
                        plateNoInput.value = assignedPlateNo;
                    }
                    
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