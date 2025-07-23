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
    <link rel="icon" href="{{ asset('public/images/logo.jpg') }}" type="image/jpg">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        text-align: center;
        height: 180px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border: 2px solid rgba(233, 236, 239, 10);
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
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2), 0 0 5px rgba(31, 26, 92, 0.3);
        position: relative;
        z-index: 1;
        animation: pulse 1.5s infinite alternate;
    }

    @keyframes pulse {
        from { transform: scale(1); }
        to { transform: scale(1.05); }
    }

    .trip-card .reset-btn {
        background: linear-gradient(90deg, #dc3545, #c82333);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 1;
    }

    .trip-card .reset-btn:hover {
        background: linear-gradient(90deg, #c82333, #bd2130);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.75rem;
        color: #2c3e50;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 8px;
    }

    .add-trip-btn {
        background: linear-gradient(45deg, #1f1a5c, #2c3e50, #34495e);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .add-trip-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s ease, height 0.6s ease;
        z-index: 0;
    }

    .add-trip-btn:hover {
        background: linear-gradient(45deg, #161245, #233140, #2c3e50);
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 20px rgba(31, 26, 92, 0.4), 0 0 12px rgba(31, 26, 92, 0.3);
    }

    .add-trip-btn:hover::before {
        width: 300%;
        height: 300%;
    }

    .add-trip-btn i {
        transition: transform 0.3s ease;
    }

    .add-trip-btn:hover i {
        transform: translateX(5px);
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .plate-number-section select {
        padding: 10px 15px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        font-size: 16px;
        color: #495057;
        background-color: #fff;
        width: 220px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .plate-number-section select:focus {
        border-color: #1f1a5c;
        box-shadow: 0 0 5px rgba(31, 26, 92, 0.3);
        outline: none;
    }

    .trip-table {
        width: 100%;
        margin-top: 35px;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        overflow: hidden;
    }

    .trip-table th, .trip-table td {
        padding: 15px 20px;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
        transition: background-color 0.2s ease;
    }

    .trip-table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #2c3e50;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .trip-table tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .trip-table tr:hover {
        background-color: #e9ecef;
    }

    .trip-table tr:last-child td {
        border-bottom: none;
    }

    .update-btn {
        background: linear-gradient(90deg, #1f1a5c, #2c3e50);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .update-btn:hover {
        background: linear-gradient(90deg, #161245, #233140);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .reset-btn {
        background: linear-gradient(90deg, #dc3545, #c82333);
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .reset-btn:hover {
        background: linear-gradient(90deg, #c82333, #bd2130);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
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
            font-size: 2.2rem;
        }
        
        .header-section {
            flex-direction: column;
            align-items: flex-start;
        }

        .plate-number-section select {
            width: 100%;
        }

        .add-trip-btn {
            padding: 12px 25px;
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .trip-card {
            height: 130px;
        }
        
        .trip-card p {
            font-size: 1.8rem;
        }
        
        .trip-card h3 {
            font-size: 0.95rem;
        }
        
        .trip-table th, .trip-table td {
            padding: 10px 15px;
            font-size: 0.9rem;
        }
        
        .update-btn, .reset-btn {
            padding: 6px 10px;
            font-size: 0.8rem;
        }

        .add-trip-btn {
            padding: 10px 20px;
            font-size: 0.95rem;
        }
    }
</style>
</head>

<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <x-managernavbar />
    </div>

    <!-- Main Content Area -->
    <div class="content">
        <!-- Header Section -->
        <div class="header-section">
            <div class="plate-number-section">
                <select id="plateNumberSelect">
                    <option value="all" selected>All Trucks</option>
                    <option value="" disabled>-- Plate Number --</option>
                    @foreach($plateNumbers as $plate)
                        <option value="{{ $plate }}">{{ $plate }}</option>
                    @endforeach
                </select>
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
                    <p id="oneWayTripCount">0</p>
                    <button class="reset-btn" data-trip-type="One Way Trip">Reset</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="trip-card">
                    <h3>ROUND TRIP</h3>
                    <p id="roundTripCount">0</p>
                    <button class="reset-btn" data-trip-type="Round Trip">Reset</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="trip-card">
                    <h3>DOOR TO DOOR TRIP</h3>
                    <p id="doorToDoorTripCount">0</p>
                    <button class="reset-btn" data-trip-type="Door-To-Door Trip">Reset</button>
                </div>
            </div>
        </div>

        <!-- Trip Table -->
        <table class="trip-table">
            <thead>
                <tr>
                    <th>Plate Number</th>
                    <th>Trip Type</th>
                    <th>Number of Trips</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tripTableBody">
                @if(count($trips) == 0)
                    <tr>
                        <td colspan="4" style="text-align: center;">No data available</td>
                    </tr>
                @else
                    @foreach ($trips as $trip)
                    <tr 
                        data-id="{{ $trip->id }}" 
                        data-plate="{{ trim(str_replace(' ', '', $trip->plate_no)) }}" 
                        data-trip="{{ $trip->trip_type }}" 
                        data-num="{{ $trip->num_trips }}"
                    >
                        <td>{{ $trip->plate_no }}</td>
                        <td>{{ $trip->trip_type }}</td>
                        <td>{{ $trip->num_trips }}</td>
                        <td>
                            <button class="update-btn" data-trip-id="{{ $trip->id }}">UPDATE</button>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    @include('manager.modals.add_trip')
    @include('manager.modals.update_trip')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var tripStoreUrl = @json(route('trips.store'));
        var tripUpdateUrl = @json(route('trips.update', ['id' => ':id']));
        var resetAllUrl = @json(route('trips.reset-all'));
        var getTripCountsUrl = @json(route('manager.get-trip-counts'));
        
        $(document).ready(function() {
            // Initialize counts with all trucks data
            updateTripCounts('all');
            
            // Handle plate number selection change
            $("#plateNumberSelect").change(function() {
                const plateNo = $(this).val();
                updateTripCounts(plateNo);
                filterTableRows(plateNo);
            });
            
            function updateTripCounts(plateNo) {
                if (!plateNo) return;
                
                $.ajax({
                    url: getTripCountsUrl,
                    type: "GET",
                    data: { 
                        plate_no: plateNo,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $("#oneWayTripCount").text(response.oneWayTrip || 0);
                        $("#roundTripCount").text(response.roundTrip || 0);
                        $("#doorToDoorTripCount").text(response.doorToDoorTrip || 0);
                    },
                    error: function(xhr) {
                        console.error("Error fetching trip counts:", xhr.responseText);
                        $("#oneWayTripCount").text("0");
                        $("#roundTripCount").text("0");
                        $("#doorToDoorTripCount").text("0");
                    }
                });
            }
            
            function filterTableRows(plateNo) {
                if (!plateNo || plateNo === 'all') {
                    // Show all rows when "All Trucks" is selected
                    $("#tripTableBody tr").show();
                    return;
                }

                const selectedPlate = plateNo.replace(/\s+/g, "").toUpperCase();
                let hasVisibleRows = false;

                $("#tripTableBody tr").each(function() {
                    if ($(this).data("id")) { // Skip the "no data" row
                        const rowPlate = $(this).data("plate").toString().replace(/\s+/g, "").toUpperCase();
                        if (rowPlate === selectedPlate) {
                            $(this).show();
                            hasVisibleRows = true;
                        } else {
                            $(this).hide();
                        }
                    }
                });

                if (!hasVisibleRows) {
                    $("#tripTableBody tr").hide();
                    $("#tripTableBody tr:first").show();
                }
            }
            
            // Handle Add Trip modal opening
            $("#openModal").click(function() {
                $("#tripModal").fadeIn();
            });
            
            // Handle update button click
            $(document).on('click', '.update-btn', function() {
                const row = $(this).closest('tr');
                const tripId = $(this).data('trip-id') || row.data('id');
                const plateNo = row.data('plate');
                const tripType = row.data('trip');
                const numTrips = row.data('num');
                
                console.log('Data to update:', {
                    tripId: tripId,
                    plateNo: plateNo,
                    tripType: tripType,
                    numTrips: numTrips
                });

                if (!tripId) {
                    Swal.fire('Error', 'Trip ID is missing!', 'error');
                    return;
                }

                $('#trip_id').val(tripId);
                $('#update_plate_no').val(plateNo);
                $('#update_trip_type').val(tripType);
                $('#update_num_trips').val(numTrips);
                $('#updateModal').fadeIn();
            });

            // Reset button functionality
            $(".reset-btn").click(function() {
                const tripType = $(this).data("trip-type");
                let plateNo = $("#plateNumberSelect").val(); 

                if (!plateNo) {
                    Swal.fire("Error", "Please select a plate number first.", "error");
                    return;
                }

                if (plateNo === 'all') {
                    Swal.fire({
                        title: "Are you sure?",
                        text: `This will reset ALL "${tripType}" trips for ALL trucks!`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, reset all!",
                        dangerMode: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: resetAllUrl,
                                type: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                                },
                                data: {
                                    trip_type: tripType
                                },
                                success: function(response) {
                                    Swal.fire("Success", response.message, "success");
                                    updateTripCounts('all');
                                    filterTableRows('all');
                                },
                                error: function(xhr) {
                                    Swal.fire("Error", xhr.responseJSON.message || "Failed to reset trips.", "error");
                                }
                            });
                        }
                    });
                    return;
                }

                plateNo = plateNo.replace(/\s+/g, "");

                Swal.fire({
                    title: "Are you sure?",
                    text: `Reset all "${tripType}" trips for ${plateNo}?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, reset it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/trips/reset",
                            type: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                            data: {
                                plate_no: plateNo,
                                trip_type: tripType
                            },
                            success: function(response) {
                                Swal.fire("Success", response.message, "success");
                                updateTripCounts(plateNo);
                                filterTableRows(plateNo);
                            },
                            error: function(xhr) {
                                Swal.fire("Error", xhr.responseJSON.message || "Failed to reset trips.", "error");
                            }
                        });
                    }
                });
            });
            
            // Modal controls
            $('.close').click(function() {
                $('.modal').fadeOut();
            });

            $(window).click(function(event) {
                if ($(event.target).hasClass('modal')) {
                    $('.modal').fadeOut();
                }
            });

            // Handle form submissions
            $("#tripForm").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: tripStoreUrl,
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    },
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.fire("Success", response.message, "success");
                        location.reload();
                    },
                    error: function(xhr) {
                        Swal.fire("Error", xhr.responseJSON.message || "Failed to add trip.", "error");
                    }
                });
            });

            $('#updateTripForm').submit(function(e) {
                e.preventDefault();
                const tripId = $('#trip_id').val();
                if (!tripId) {
                    Swal.fire('Error', 'Trip ID is missing!', 'error');
                    return;
                }

                const updateUrl = tripUpdateUrl.replace(':id', tripId);
                const formData = {
                    plate_no: $('#update_plate_no').val().trim(),
                    trip_type: $('#update_trip_type').val(),
                    num_trips: $('#update_num_trips').val(),
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'PUT'
                };

                $.ajax({
                    url: updateUrl,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        Swal.fire('Success', response.message, 'success');
                        $('#updateModal').fadeOut();
                        setTimeout(() => location.reload(), 1500);
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Failed to update trip';
                        Swal.fire('Error', errorMsg, 'error');
                    }
                });
            });
        });
    </script>
</body>
</html>