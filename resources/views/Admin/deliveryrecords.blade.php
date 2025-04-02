<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Records</title>
    <link rel="stylesheet" href="{{ asset('css/devmanager.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            max-width: 500px;
            border-radius: 8px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2><i>SYA</i></h2>
        <ul>
            <x-navbar />
        </ul>
    </div>

    <main class="main-content">
        <div class="plate-number-section">
            <select id="plateNumberSelect" style="font-size: 17px; border-radius: 8px;">
                <option value="" disabled selected>-- Plate Number --</option>
                <option value="UVP353">UVP353</option>
                <option value="TQE262">TQE262</option>
                <option value="NBB7212">NBB7212</option>
                <option value="APA3309">APA3309</option>
                <option value="WIE914">WIE914</option>
            </select>
        </div>

        <div class="top-bar">
            <button class="add-trip-btn" id="openModal">Add Trip</button>
        </div>

        <section class="trips-overview">
            <h2>TOTAL COUNTS</h2>
            <div class="trip-summary">
                <div class="trip-card">
                    <h3>ONE WAY TRIP</h3>
                    <p id="oneWayTripCount">{{ $oneWayTrip ?? 0 }}</p>
                    <button class="reset-btn" data-trip-type="One Way Trip">Reset</button>
                </div>
                <div class="trip-card">
                    <h3>ROUND TRIP</h3>
                    <p id="roundTripCount">{{ $roundTrip ?? 0 }}</p>
                    <button class="reset-btn" data-trip-type="Round Trip">Reset</button>
                </div>
                <div class="trip-card">
                    <h3>DOOR TO DOOR TRIP</h3>
                    <p id="doorToDoorTripCount">{{ $doorToDoorTrip ?? 0 }}</p>
                    <button class="reset-btn" data-trip-type="Door-To-Door Trip">Reset</button>
                </div>
            </div>
        </section>

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
    </main>

    {{-- Include the modals --}}
    @include('Admin.modals.add_trip')
    @include('Admin.modals.update_trip')

    <script>
        var tripStoreUrl = @json(route('trips.store'));
        var tripUpdateUrl = @json(route('trips.update', ['id' => ':id']));
        
        $(document).ready(function() {
            // Initialize - hide all rows initially
            $("#tripTableBody tr").hide();
            
            // Load counts for the first plate number by default
            const initialPlateNo = $("#plateNumberSelect").val();
            if (initialPlateNo) {
                updateTripCounts(initialPlateNo);
            }

            // Handle plate number selection change
            $("#plateNumberSelect").change(function() {
                const plateNo = $(this).val();
                updateTripCounts(plateNo);
                filterTableRows(plateNo);
            });
            
            function updateTripCounts(plateNo) {
                if (!plateNo) return;
                
                $.ajax({
                    url: "/admin/get-trip-counts",
                    type: "GET",
                    data: { plate_no: plateNo },
                    success: function(response) {
                        $("#oneWayTripCount").text(response.oneWayTrip);
                        $("#roundTripCount").text(response.roundTrip);
                        $("#doorToDoorTripCount").text(response.doorToDoorTrip);
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
                if (!plateNo) {
                    $("#tripTableBody tr").hide();
                    $("#tripTableBody tr:first").show(); // Show "no data" row if empty
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