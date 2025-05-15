<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trip Countings</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
        
        .trip-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            text-align: center;
            height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 1px solid #e9ecef;
        }

        .trip-card h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .trip-card p {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1;
            margin: 0;
            color: #1f1a5c;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #343a40;
        }

        .add-trip-btn {
            background: #1f1a5c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .add-trip-btn:hover {
            background: #161245;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
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
                height: 150px;
            }
            
            .trip-card p {
                font-size: 2.5rem;
            }
            
            .header-section {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 576px) {
            .trip-card {
                height: 130px;
            }
            
            .trip-card p {
                font-size: 2rem;
            }
            
            .trip-card h3 {
                font-size: 0.9rem;
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
                <i class="fas fa-truck"></i>
                <span id="assignedPlateNumber">{{ $plateNumber ?? 'Not assigned' }}</span>
            </div>
            <button class="add-trip-btn" id="openModal">
                <i class="fas fa-plus"></i> Add Trip
            </button>
        </div>

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
            // Get the assigned plate number from the page
            const plateNumber = $('#assignedPlateNumber').text().trim();
            
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
                    if (plateNumber === 'Not assigned') {
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
            if (plateNumber && plateNumber !== 'Not assigned') {
                fetchTripCounts(plateNumber);
            }

            // Disable "Add Trip" button if no plate number is assigned
            if (plateNumber === 'Not assigned') {
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
                
                // Get the assigned plate number
                const plateNumber = $('#assignedPlateNumber').text().trim();
                
                if (plateNumber === 'Not assigned') {
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