<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Records</title>
<<<<<<< HEAD
=======
    <link rel="stylesheet" href="{{ asset('css/deliverynav.css') }}">
>>>>>>> origin/piolo
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<<<<<<< HEAD
    <style>
        * {
=======
</head>
<style>
    * {
>>>>>>> origin/piolo
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
<<<<<<< HEAD
            display: flex;
=======
            display: q flex;
>>>>>>> origin/piolo
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
<<<<<<< HEAD

        .content {
            margin-left: 270px;
            padding: 20px;
            flex-grow: 1;
        }

        .main-content {
            margin-left: 230px;
            /* Adjusted to fit sidebar */
            padding: 20px;
            width: calc(100% - 230px);
        }

        /* Top Bar */
        .top-bar {
            display: flex;
            justify-content: flex-end; /* Change to flex-end */
            align-items: center;
            margin-bottom: 20px;
        }

        .add-trip-btn {
            background: #1f1a5c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 17px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-left: 10px;
            margin-top: -1.5rem;
            margin-right: 0;
        }

        .add-trip-btn i {
            font-size: 15px;
        }

        .trip-card {
            flex: 1;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            min-width: 25vw;
            height: 180px;
            margin-left: 10px;
        }

        .trip-card h3 {
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .trip-card p {
            font-size: 125px;
            font-weight: 700;
        }

        .trips-overview {
            margin-bottom: 20px;
        }

        .trips-overview h2 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .trip-summary {
            display: flex;
            gap: 15px;
            justify-content: flex-start;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .trip-card {
                flex: 1 1 calc(50% - 30px);
                margin-left: 10px;
                margin-right: 10px;
            }
        }

        @media (max-width: 480px) {
            .trip-card {
                flex: 1 1 100%;
                margin-left: 0;
                margin-right: 0;
            }
        }
    </style>
</head>

<div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <h2><i>SYA</i>TRUCKING SERVICES</h2>
        <nav>
            <ul>
                <x-drivernavbar />
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="plate-number-section">
            <select id="plateNumberSelect" style="font-size: 17px; border-radius: 8px; margin-left: 10px;">
                <option disabled selected>-- Plate Number --</option>
                <option value="UVP 353">UVP353</option>
                <option value="TQE 262">TQE262</option>
                <option value="NBB 7212">NBB7212</option>
                <option value="APA 3309">APA3309</option>
                <option value="WIE 914">WIE914</option>
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
</div>
@include('Driver.modals.drivermodal')
<script>
    var tripStoreUrl = @json(route('trips.store'));

=======
</style>

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
            <option value="APA 3309">APA3309</option>
            <option value="WIE 914">WIE914</option>
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
        <option value="UVP 353">UVP353</option>
            <option value="TQE 262">TQE262</option>
            <option value="NBB 7212">NBB7212</option>
            <option value="APA 3309">APA3309</option>
            <option value="WIE 914">WIE914</option>
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
>>>>>>> origin/piolo
    function openTrackingWindow() {
        let trackingWindow = window.open('/tracking', 'TruckTracking', 'width=300,height=200');
    }
    window.onload = function() {
        openTrackingWindow();
    };
</script>
<script src="{{ asset('js/driver.js') }}"></script>
</body>
<<<<<<< HEAD

</html>
=======
</html>
>>>>>>> origin/piolo
