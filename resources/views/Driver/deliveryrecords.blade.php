<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Records</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        }

        .content {
            margin-left: 270px;
            padding: 20px;
            flex-grow: 1;
            transition: margin-left 0.2s ease;
        }

        .content.collapsed {
            margin-left: 80px;
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

        /* Responsive Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .sidebar.collapsed {
                width: 60px;
            }

            .sidebar ul li {
                padding: 10px;
            }

            .sidebar ul li a {
                font-size: 14px;
            }

            .sidebar-header h2 {
                font-size: 16px;
            }

            .sidebar-header p {
                font-size: 10px;
            }

            .content {
                margin-left: 200px;
            }

            .content.collapsed {
                margin-left: 60px;
            }

            .trip-card {
                flex: 1 1 calc(50% - 30px);
                margin-left: 10px;
                margin-right: 10px;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 150px;
            }

            .sidebar.collapsed {
                width: 60px;
            }

            .sidebar ul li {
                padding: 8px;
            }

            .sidebar ul li a {
                font-size: 12px;
            }

            .sidebar-header h2 {
                font-size: 14px;
            }

            .sidebar-header p {
                font-size: 8px;
            }

            .content {
                margin-left: 150px;
            }

            .content.collapsed {
                margin-left: 60px;
            }

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
    <x-drivernavbar />

    <!-- Main Content -->
    <main class="content">
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

    function openTrackingWindow() {
        let trackingWindow = window.open('/tracking', 'TruckTracking', 'width=300,height=200');
    }
    window.onload = function() {
        openTrackingWindow();
    };
</script>
<script src="{{ asset('js/driver.js') }}"></script>
</body>

</html>
