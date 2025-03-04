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
</head>

<body>

    <div class="sidebar">
        <h2>Sidebar Menu</h2>
        <ul>
            <x-managernavbar />
        </ul>
    </div>

    <main class="main-content">
        <div class="plate-number-section">
            <select id="plateNumberSelect" style="font-size: 17px; border-radius: 8px;">
                <option disabled selected>-- Plate Number --</option>
                <option value="UVP 353">UVP353</option>
                <option value="TQE 262">TQE262</option>
                <option value="NBB 7212">NBB7212</option>
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
                    <p id="oneWayTripCount">{{ $oneWayTrip }}</p>
                    <button class="reset-btn" data-trip-type="One Way Trip">Reset</button>
                </div>
                <div class="trip-card">
                    <h3>ROUND TRIP</h3>
                    <p id="roundTripCount">{{ $roundTrip }}</p>
                    <button class="reset-btn" data-trip-type="Round Trip">Reset</button>
                </div>
                <div class="trip-card">
                    <h3>DOOR TO DOOR TRIP</h3>
                    <p id="doorToDoorTripCount">{{ $doorToDoorTrip }}</p>
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
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tripTableBody">
                @foreach($trips as $trip)
                <tr data-id="{{ $trip->id }}" data-plate="{{ $trip->plate_no }}" data-trip="{{ $trip->trip_type }}" data-num="{{ $trip->num_trips }}">
                    <td>{{ $trip->plate_no }}</td>
                    <td>{{ $trip->trip_type }}</td>
                    <td>{{ $trip->num_trips }}</td>
                    <td>{{ $trip->created_at }}</td>
                    <td>
                        <button class="update-btn" data-id="{{ $trip->id }}">Update</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </main>

    <div id="updateModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Update Trip</h2>
            <form id="updateTripForm">
                @csrf
                <input type="hidden" id="trip_id" name="trip_id">

                <label for="update_plate_no">Plate No.:</label>
                <select id="update_plate_no" name="plate_no" required>
                    <option disabled>-- Plate Number --</option>
                    <option value="UVP353">UVP353</option>
                    <option value="TQE262">TQE262</option>
                    <option value="NBB7212">NBB7212</option>
                </select>

                <label for="update_trip_type">Trip Type:</label>
                <select id="update_trip_type" name="trip_type" required>
                    <option disabled>-- Select Trip --</option>
                    <option value="One Way Trip">One Way Trip</option>
                    <option value="Round Trip">Round Trip</option>
                    <option value="Door-To-Door Trip">Door-To-Door Trip</option>
                </select>

                <label for="update_num_trips">Number of Trips:</label>
                <input type="number" id="update_num_trips" name="num_trips" min="1" required>

                <button type="submit">Update</button>
            </form>
        </div>
    </div>

    <!-- Add Trip Modal -->
    <div id="tripModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add Trip</h2>
            <form id="tripForm">
                @csrf
                <label for="plate_no">Plate No.:</label>
                <select id="plate_no" name="plate_no" required>
                    <option disabled selected>-- Plate Number --</option>
                    <option value="UVP353">UVP353</option>
                    <option value="TQE262">TQE262</option>
                    <option value="NBB7212">NBB7212</option>
                </select>

                <label for="trip_type">Trip Type:</label>
                <select id="trip_type" name="trip_type" required>
                    <option disabled selected>-- Select Trip --</option>
                    <option value="One Way Trip">One Way Trip</option>
                    <option value="Round Trip">Round Trip</option>
                    <option value="Door-To-Door Trip">Door-To-Door Trip</option>
                </select>

                <label for="num_trips">Number of Trips:</label>
                <input type="number" id="num_trips" name="num_trips" min="1" required>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        var tripStoreUrl = @json(route('trips.store'));
    </script>

    <script src="{{ asset('js/manager.js') }}"></script>
</body>

</html>
