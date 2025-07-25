<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trip Countings</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="{{ asset('public/images/logo.jpg') }}" type="image/jpg">
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
            color: #333;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(145deg, #2c3e50, #34495e);
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100%;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
        }

        .content {
            margin-left: 250px;
            padding: 25px;
            flex-grow: 1;
            background-color: #fff;
            min-height: 100vh;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            box-shadow: -4px 0 15px rgba(0, 0, 0, 0.05);
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
            transition: color 0.2s ease;
        }

        .truck-display:hover i {
            color: #1f1a5c;
        }

        .trip-card {
            background: radial-gradient(circle at 50% 0%, rgba(255, 255, 255, 0.9), rgba(248, 249, 250, 0.7));
            backdrop-filter: blur(5px);
            padding: 25px 20px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 1px solid rgba(204, 206, 206, 0.8);
            transition: transform 0.4s ease, box-shadow 0.4s ease, border 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .trip-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(31, 26, 92, 0.1) 0%, transparent 70%);
            z-index: 0;
            transition: transform 0.6s ease;
        }

        .trip-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(31, 26, 92, 0.3);
        }

        .trip-card:hover::before {
            transform: translate(20%, 20%);
        }

        .trip-card h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 1;
        }

        .trip-card p {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1;
            margin: 0;
            color: #1f1a5c;
            position: relative;
            z-index: 1;
            animation: pulse 1.5s infinite alternate;
        }

        @keyframes pulse {
            from {
                transform: scale(1);
            }
            to {
                transform: scale(1.05);
            }
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        .add-trip-btn {
            background: linear-gradient(90deg, #1f1a5c 0%, #2a236f 100%); /* Added subtle gradient */
            color: white;
            border: 1px solid #1f1a5c;
            padding: 8px 16px; /* Slightly increased padding for better proportions */
            border-radius: 10px; /* Softer, more rounded corners */
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Slightly stronger shadow */
            max-width: fit-content;
            white-space: nowrap;
            margin-bottom: 20px;
        }

        .add-trip-btn:hover {
            background: linear-gradient(90deg, #2a236f 0%, #352b8a 100%); /* Brighter gradient on hover */
            color: white;
            border-color: #2a236f; /* Matches gradient start */
            transform: translateY(-2px) scale(1.03); /* Added subtle scale for pop */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); /* Stronger shadow on hover */
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
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

            .trip-card {
                height: 160px;
                padding: 20px 15px;
            }

            .trip-card p {
                font-size: 2.2rem;
            }

            .trip-card h3 {
                font-size: 0.95rem;
                margin-bottom: 8px;
            }

            .header-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }

        @media (max-width: 576px) {
            .trip-card {
                height: 140px;
                padding: 15px 10px;
            }

            .trip-card p {
                font-size: 1.8rem;
            }

            .trip-card h3 {
                font-size: 0.9rem;
                margin-bottom: 8px;
            }
        }

        @media (max-width: 400px) {
            .trip-card {
                height: 130px;
                padding: 12px 8px;
            }

            .trip-card p {
                font-size: 1.6rem;
            }

            .trip-card h3 {
                font-size: 0.9rem;
                margin-bottom: 6px;
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
        <!-- Header Section -->
        <div class="header-section">
            <div class="truck-display">
                <i class="fas fa-user"></i>
                <span id="assignedPlateNumber" data-plate="{{ $plateNumber }}">{{ $driverName }}</span>
            </div>
        </div>
        <button class="add-trip-btn" id="openModal">
            <i class="fas fa-plus"></i> Add Trip
        </button>

        <!-- Trip Counts Section -->
        <h2 class="section-title">TOTAL COUNTS</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="trip-card">
                    <h3>ONE WAY TRIP</h3>
                    <p>0</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="trip-card">
                    <h3>ROUND TRIP</h3>
                    <p>0</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="trip-card">
                    <h3>DOOR TO DOOR TRIP</h3>
                    <p>0</p>
                </div>
            </div>
        </div>
    </div>

    @include('driver.modals.drivermodal')
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        var tripStoreUrl = @json(route('trips.store'));

        function openTrackingWindow() {
            let trackingWindow = window.open('/tracking', 'TruckTracking', 'width=300,height=200');
        }
        
        window.onload = function () {
            openTrackingWindow();
        };

        // Combined JavaScript from driver.js
        document.addEventListener("DOMContentLoaded", function () {
            // Get the assigned plate number from the data attribute
            const plateNumber = $('#assignedPlateNumber').data('plate');
            
            // Ensure modal is hidden initially
            var modal = document.getElementById("tripModal");
            if (modal) {
                modal.style.display = "none";

                // Get the close button inside the modal
                var closeBtn = modal.querySelector(".close");

                // Close modal when clicking the close button
                if (closeBtn) {
                    closeBtn.addEventListener("click", function () {
                        modal.style.display = "none"; // Hide modal
                    });
                }

                // Close modal when clicking outside the modal content
                window.addEventListener("click", function (event) {
                    if (event.target === modal) {
                        modal.style.display = "none";
                    }
                });
            }

            // Get the button that opens the modal
            var btn = document.getElementById("openModal");

            // Open modal on button click
            if (btn) {
                btn.addEventListener("click", function () {
                    // Check if plate number is assigned
                    if (plateNumber === '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'No Plate Number Assigned',
                            text: 'You cannot add trips without an assigned plate number',
                        });
                        return;
                    }
                    if (modal) {
                        modal.style.display = "flex"; // Show modal
                    }
                });
            }

            // Load initial trip counts if plate number is assigned
            if (plateNumber && plateNumber !== '') {
                fetchTripCounts(plateNumber);
            }

            // Disable "Add Trip" button if no plate number is assigned
            if (plateNumber === '') {
                $('#openModal').prop('disabled', true)
                    .css('opacity', '0.7')
                    .attr('title', 'You need an assigned plate number to add trips');
            }
        });
    
        // Function to fetch trip counts
        function fetchTripCounts(plateNo) {
            const formattedPlateNo = plateNo.replace(/\s+/g, '');
            
            $.ajax({
                url: '/get-trip-counts',
                type: 'GET',
                data: { plate_no: formattedPlateNo },
                success: function(response) {
                    $('.trip-card').eq(0).find('p').text(response.oneWayTrip || 0);
                    $('.trip-card').eq(1).find('p').text(response.roundTrip || 0);
                    $('.trip-card').eq(2).find('p').text(response.doorToDoorTrip || 0);
                },
                error: function(xhr) {
                    console.error('Error fetching trip counts:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load trip counts',
                    });
                }
            });
        }
    
        // AJAX form submission with jQuery and SweetAlert
        $(document).ready(function () {
            $('#tripForm').submit(function (e) {
                e.preventDefault(); // Prevent page reload
                
                // Get the assigned plate number from the data attribute
                const plateNumber = $('#assignedPlateNumber').data('plate');
                
                if (plateNumber === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'You cannot add trips without an assigned plate number',
                    });
                    return;
                }
    
                // Prepare form data with the assigned plate number
                const formData = {
                    plate_no: plateNumber.replace(/\s+/g, ''),
                    trip_type: $('#trip_type').val(),
                    num_trips: $('#num_trips').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                };
    
                $.ajax({
                    url: tripStoreUrl,
                    method: "POST",
                    data: formData,
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.success,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            // Refresh trip counts after successful submission
                            fetchTripCounts(plateNumber);
                            // Reset form and close modal
                            $('#tripForm')[0].reset();
                            $('#tripModal').hide();
                        });
                    },
                    error: function (xhr) {
                        let errorMessage = "Something went wrong!";
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).join('\n');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage,
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>