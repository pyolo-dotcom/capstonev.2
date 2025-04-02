<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        flex-wrap: wrap;
        transition: margin-left 0.2s ease;
        max-width: 100%; /* Ensure content doesn't exceed the viewport width */
    }

        .item {
            flex-grow: 1;
            flex-basis: 200;
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

        .top-bar {
            flex-direction: column;
            align-items: flex-start;
            margin-top: 10px; /* Adjust margin */
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

        .add-trip-btn {
            font-size: 12px; /* Further reduce button font size */
            padding: 6px 8px; /* Adjust button padding */
        }

        .plate-number-section select {
            width: 100%; /* Full width for dropdown */
            font-size: 14px; /* Adjust font size */
        }
    }
    .plate-number-section {
        display: flex;
        align-items: center;
        gap: 10px; /* Add spacing between dropdown and button */
        flex-wrap: wrap; /* Allow wrapping on smaller screens */
    }

    .add-trip-btn {
        margin: 0; /* Remove unnecessary margins */
        padding: 8px 12px; /* Adjust padding for better fit */
        font-size: 14px; /* Adjust font size */
    }

    @media (max-width: 768px) {
        .plate-number-section {
            flex-direction: row; /* Ensure dropdown and button are side by side */
            justify-content: space-between; /* Add spacing between elements */
        }

        .add-trip-btn {
            font-size: 12px; /* Reduce button font size for smaller screens */
            padding: 6px 8px; /* Adjust button padding */
        }
    }

    @media (max-width: 576px) {
        .plate-number-section {
            flex-direction: column; /* Stack dropdown and button vertically on very small screens */
            align-items: flex-start; /* Align items to the start */
        }

        .add-trip-btn {
            width: 30%; /* Full width for the button */
            text-align: center; /* Center the button text */
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
                <div class="form-control" style="font-size: 17px; border-radius: 8px; width: 190px; display: flex; align-items: center; height: 38px;">
                    <i class="fas fa-truck mr-2"></i>
                    <span id="assignedPlateNumber">{{ $plateNumber ?? 'Not assigned' }}</span>
                </div>
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
