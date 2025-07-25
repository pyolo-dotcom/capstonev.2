<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cargo QR Code</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
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

        .truck-display {
            background: #f1f3f5;
            padding: 15px 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: inline-block;
            font-size: 16px;
            font-weight: 600;
            border: 1px solid #dee2e6;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }
        .truck-display:hover {
            transform: translateY(-2px);
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
/* Add this to your existing <style> block, preferably near the bottom */
.form-select[type="text"] {
    -webkit-appearance: none; /* For Chrome, Safari, Edge */
    -moz-appearance: none;    /* For Firefox */
    appearance: none;         /* Standard property */
    background-image: none;   /* Remove any background image that acts as an icon */
    padding-right: 12px;      /* Adjust padding if needed after removing the icon */
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
    <div class="sidebar">
        <x-drivernavbar />
    </div>

    <div class="content">
        <div class="header-section">
            <div class="truck-display">
                <i class="fas fa-user"></i>
                <span id="assignedPlateNumber">{{ $driverName ?? 'Not assigned' }}</span>
            </div>
        </div>
<h2 class="section-title">GENERATE CARGO QR CODE</h2>

<div class="form-container">
    <form id="cargoForm">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="plate_no" class="form-label">Plate Number</label>
                    <select class="form-select" name="plate_no" id="plate_no" required>
                        <option value="">Select Plate Number</option>
                        @foreach($plateNumbers as $plate)
                            <option value="{{ $plate }}" {{ Auth::user()->truck_id == $plate ? 'selected' : '' }}>
                                {{ $plate }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
    <label for="eir_no" class="form-label">EIR No</label>
    <input type="text" id="eir_no" name="eir_no" class="form-select" placeholder="Enter EIR No">
</div>

                <div class="mb-3">
    <label for="container_van_no" class="form-label">Container Van No</label>
    <input type="text" id="container_van_no" name="container_van_no" class="form-select" placeholder="Enter Container Van No">
</div>

                <div class="mb-3">
                    <label for="size" class="form-label">Size</label>
                    <select id="size" name="size" class="form-select other-select" data-other-id="size_other">
                        <option value="">Select Size</option>
                        <option value="20ft">20ft</option>
                        <option value="40ft">40ft</option>
                        <option value="others">Others</option>
                    </select>
                    <input type="text" id="size_other" class="form-control mt-2 other-input" style="display: none;" placeholder="Please specify Size">
                </div>

                <div class="mb-3">
                    <label for="shipper_consignee" class="form-label">Shipper/Consignee</label>
                    <input type="text" id="shipper_consignee" name="shipper_consignee" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="voyage_vessel" class="form-label">Voyage Vessel</label>
                    <select id="voyage_vessel" name="voyage_vessel" class="form-select other-select" data-other-id="voyage_vessel_other">
                        <option value="">Select Vessel</option>
                        <option value="Vessel A">Vessel A</option>
                        <option value="Vessel B">Vessel B</option>
                        <option value="others">Others</option>
                    </select>
                     <input type="text" id="voyage_vessel_other" class="form-control mt-2 other-input" style="display: none;" placeholder="Please specify Vessel">
                </div>
<div class="mb-3">
    <label for="voyage_no" class="form-label">Voyage No</label>
    <input type="text" id="voyage_no" name="voyage_no" class="form-select" placeholder="Enter Voyage No">
</div>

                <div class="mb-3">
                    <label for="pickup_location" class="form-label">Pick-up Location</label>
                    <select id="pickup_location" name="pickup_location" class="form-select other-select" data-other-id="pickup_location_other">
                        <option value="">Select Pick-up Location</option>
                        <option value="Depot A">Depot A</option>
                        <option value="Depot B">Depot B</option>
                        <option value="others">Others</option>
                    </select>
                     <input type="text" id="pickup_location_other" class="form-control mt-2 other-input" style="display: none;" placeholder="Please specify Pick-up Location">
                </div>

                <div class="mb-3">
                    <label for="delivery_location" class="form-label">Delivery Location</label>
                    <select id="delivery_location" name="delivery_location" class="form-select other-select" data-other-id="delivery_location_other">
                        <option value="">Select Delivery Location</option>
                        <option value="Warehouse A">Warehouse A</option>
                        <option value="Warehouse B">Warehouse B</option>
                        <option value="others">Others</option>
                    </select>
                     <input type="text" id="delivery_location_other" class="form-control mt-2 other-input" style="display: none;" placeholder="Please specify Delivery Location">
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" id="generateBtn">Generate QR</button>
                <button type="button" onclick="clearSavedFormData()" class="btn btn-secondary">Clear</button>
            </div>
        </div>
    </form>
</div>

      <div class="modal fade" id="qrCodeContainer" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="qrCodeModalLabel">Generated QR Code</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <div id="qrCodeImage"></div> </div>
    </div>
  </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        // Function to save form data, now handling 'others' option
        function saveFormData() {
            const getSelectValue = (selectId) => {
                const select = document.getElementById(selectId);
                // Check if the select element has the 'other-select' class
                if (select.classList.contains('other-select') && select.value === 'others') {
                    const otherInput = document.getElementById(select.dataset.otherId);
                    return otherInput ? otherInput.value.trim() : '';
                }
                return select.value;
            };

            const formData = {
                plate_no: document.getElementById('plate_no').value,
                eir_no: document.getElementById('eir_no').value,
                container_van_no: document.getElementById('container_van_no').value,
                size: getSelectValue('size'), // Updated to use helper
                shipper_consignee: document.getElementById('shipper_consignee').value.trim(),
                voyage_vessel: getSelectValue('voyage_vessel'),
                voyage_no: document.getElementById('voyage_no').value,
                pickup_location: getSelectValue('pickup_location'),
                delivery_location: getSelectValue('delivery_location')
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

                    // Show Bootstrap modal
                    const qrModal = new bootstrap.Modal(document.getElementById('qrCodeContainer'));
                    qrModal.show();

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

            // Setup for 'Others' option dropdowns
            document.querySelectorAll('.other-select').forEach(selectElement => {
                const otherInput = document.getElementById(selectElement.dataset.otherId);
                if (!otherInput) return;

                selectElement.addEventListener('change', function() {
                    if (this.value === 'others') {
                        otherInput.style.display = 'block';
                    } else {
                        otherInput.style.display = 'none';
                        otherInput.value = '';
                    }
                });
            });

            const savedData = localStorage.getItem('cargoFormData');
            if (savedData) {
                const formData = JSON.parse(savedData);

                // Helper function to restore select/other input state
                const restoreSelectValue = (selectId, savedValue) => {
                    if (!savedValue) return;
                    const select = document.getElementById(selectId);

                    // Check if it's a select with an "others" option
                    if (select.classList.contains('other-select')) {
                        const otherInput = document.getElementById(select.dataset.otherId);
                        let isOther = true;

                        for (let option of select.options) {
                            if (option.value === savedValue) {
                                select.value = savedValue;
                                isOther = false;
                                break;
                            }
                        }

                        if (isOther) {
                            select.value = 'others';
                            if (otherInput) {
                                otherInput.value = savedValue;
                                otherInput.style.display = 'block';
                            }
                        }
                    } else {
                        // For standard select elements
                        select.value = savedValue;
                    }
                };

                // Restore all fields except plate_no if user has an assigned truck
                const plateNoInput = document.getElementById('plate_no');
                const assignedPlateNo = "{{ Auth::user()->truck_id }}";

                if (assignedPlateNo) {
                    plateNoInput.value = assignedPlateNo;
                } else if (formData.plate_no) {
                    plateNoInput.value = formData.plate_no;
                }

                // Restore other fields
                restoreSelectValue('eir_no', formData.eir_no);
                restoreSelectValue('container_van_no', formData.container_van_no);
                restoreSelectValue('size', formData.size); // Updated to use helper
                document.getElementById('shipper_consignee').value = formData.shipper_consignee || '';
                restoreSelectValue('voyage_vessel', formData.voyage_vessel);
                restoreSelectValue('voyage_no', formData.voyage_no);
                restoreSelectValue('pickup_location', formData.pickup_location);
                restoreSelectValue('delivery_location', formData.delivery_location);

                // Regenerate QR code if there was one
                if (Object.keys(formData).length > 1 && formData.plate_no) { // Check if form is not empty
                     generateQRCode();
                }
            }

            // Disable generate button if no plate number is assigned
            const generateBtn = document.getElementById('generateBtn');
            const plateNo = document.getElementById('plate_no').value;

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

                    // Manually hide all 'other' input fields
                    document.querySelectorAll('.other-input').forEach(input => {
                        input.style.display = 'none';
                    });

                    const modalEl = document.getElementById('qrCodeContainer');
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) {
                        modalInstance.hide();
                    }

                    // Reset plate number to assigned value if it exists
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
