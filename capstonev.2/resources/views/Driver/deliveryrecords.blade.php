<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Records</title>
    <link rel="stylesheet" href="{{ asset('css/driver.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
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
                <select id="plateNumberSelect" style="font-size: 17px; border-radius: 8px; color: #f0f0f0; background-color: #2f4156;">
                    <option disabled selected>-- Plate Number --</option>
                    <option value="UVP 353">UVP353</option>
                    <option value="TQE 262">TQE262</option>
                    <option value="NBB 7212">NBB7212</option>
                </select>
            </div>
            <div class="top-bar">
                <button class="add-trip-btn" id="openModal">
                    <i class="bi bi-plus-circle"></i> Add Trips
                </button>
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

    <!-- Include the Trip Modal -->
    @include('Driver.modals.tripmodal')

    <script>
        var tripStoreUrl = @json(route('trips.store'));
    </script>
    <script src="{{ asset('js/driver.js') }}"></script>
</body>
</html>