<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Records</title>
    <link rel="stylesheet" href="{{ asset('css/deliverynav.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<>

    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>SYA TRUCKING SERVICES</h2>
            <p>Since 2020</p>
            <nav>
                <ul>
                    <x-drivernavbar />
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
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
            <p>0</p> <!-- This will be updated dynamically -->
        </div>
        <div class="trip-card">
            <h3>ROUND TRIP</h3>
            <p>0</p> <!-- This will be updated dynamically -->
        </div>
        <div class="trip-card">
            <h3>DOOR TO DOOR TRIP</h3>
            <p>0</p> <!-- This will be updated dynamically -->
        </div>
    </div>
</section>
        </main>
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
</div>
<script>
    var tripStoreUrl = @json(route('trips.store'));
</script>
<script src="{{ asset('js/driver.js') }}"></script>
</body>
</html>