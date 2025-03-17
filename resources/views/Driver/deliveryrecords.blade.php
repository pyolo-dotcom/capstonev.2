<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Records</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
        }

        .content {
            padding: 20px;
            flex-grow: 1;
            transition: margin-left 0.2s ease;
        }

        /* Top Bar */
        .top-bar {
            display: flex;
            justify-content: flex-end;
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
            margin-top: -2rem; /* Adjust margin based on your layout */
        }

        .add-trip-btn i {
            font-size: 15px;
        }

        .trip-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            min-width: 200px; /* Set minimum width */
            height: 180px;
            margin: 7px; /* Uniform margin */
            flex: 1 1 calc(33.333% - 20px); /* Standard for three in a row */
        }

        .trip-card h3 {
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .trip-card p {
            font-size: 100px;
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
            flex-wrap: wrap; /* Allow wrapping on small screens */
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .add-trip-btn {
                font-size: 14px;
                padding: 8px 10px;
            }

            .trip-card {
                flex: 1 1 calc(50% - 20px); /* Two in a row on medium screens */
            }
        }

        @media (max-width: 576px) {
            .trip-card {
                flex: 1 1 100%; /* Stacks vertically on small screens */
                margin-bottom: 15px; /* Extra spacing between cards */
            }

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                margin-top: 10px; /* Adjust margin */
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid d-flex">
        <!-- Sidebar -->
        <x-drivernavbar />

        <!-- Main Content -->
        <main class="content flex-grow-1">
            <div class="plate-number-section mb-2">
                <select id="plateNumberSelect" class="form-control" style="font-size: 17px; border-radius: 8px; width: 190px;">
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

    @include('Driver.modals.drivermodal')
    <script>
        var tripStoreUrl = @json(route('trips.store'));

        function openTrackingWindow() {
            let trackingWindow = window.open('/tracking', 'TruckTracking', 'width=300,height=200');
        }
        window.onload = function () {
            openTrackingWindow();
        };
    </script>
    <script src="{{ asset('js/driver.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
