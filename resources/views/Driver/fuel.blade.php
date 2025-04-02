<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fuel Consumption</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            min-height: 100vh;
            background-color: #f5f5f5;
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
            padding: 20px;
            flex-grow: 1;
            background-color: #fff;
            min-height: 100vh;
        }
        
        .truck-display {
            background: #f8f9fa;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: inline-block;
            font-size: 16px;
            font-weight: bold;
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .truck-display i {
            margin-right: 10px;
            color: #495057;
        }
        
        .time-filter {
            margin-bottom: 25px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .time-btn {
            padding: 10px 20px;
            border: none;
            background: #e9ecef;
            cursor: pointer;
            border-radius: 6px;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 500;
        }
        
        .time-btn:hover {
            background: #dee2e6;
        }
        
        .time-btn.active {
            background: #1f1a5c;
            color: white;
        }
        
        .chart-container {
            width: 100%;
            height: 500px;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            position: relative;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-size: 18px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
        }
        
        .loading-spinner {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        
        @media (max-width: 992px) {
            .sidebar {
                width: 220px;
            }
            .content {
                margin-left: 220px;
            }
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
            .chart-container {
                height: 400px;
                padding: 15px;
            }
        }
        
        @media (max-width: 576px) {
            .truck-display {
                width: 100%;
                text-align: center;
            }
            .time-filter {
                justify-content: center;
            }
            .time-btn {
                padding: 8px 15px;
                font-size: 13px;
            }
            .chart-container {
                height: 350px;
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
        <!-- Truck Display (No Dropdown) -->
        <div class="truck-display">
            <i class="fas fa-truck"></i>
            <span id="assignedTruck">{{ Auth::user()->truck_id ?? 'Not assigned' }}</span>
        </div>

        <!-- Time Period Filters -->
        <div class="time-filter">
            <button class="time-btn active" data-filter="weekly">Weekly</button>
            <button class="time-btn" data-filter="monthly">Monthly</button>
            <button class="time-btn" data-filter="yearly">Yearly</button>
        </div>

        <!-- Chart Container -->
        <div class="chart-container">
            <canvas id="fuelChart"></canvas>
            <div class="no-data" id="noDataMessage">
                <i class="fas fa-info-circle fa-2x mb-3"></i>
                <p>No fuel consumption data available</p>
            </div>
            <div class="loading-spinner" id="loadingSpinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const truckId = $('#assignedTruck').text().trim();
        let fuelChart = null;
        let currentFilter = 'weekly';
        const ctx = document.getElementById('fuelChart');
        const noDataMessage = document.getElementById('noDataMessage');
        const loadingSpinner = document.getElementById('loadingSpinner');

        // Initialize the page
        initializeFuelPage();

        function initializeFuelPage() {
            // Hide chart initially
            ctx.style.display = 'none';
            noDataMessage.style.display = 'none';
            loadingSpinner.style.display = 'none';

            // If truck is assigned, load initial data
            if (truckId !== 'Not assigned') {
                loadFuelData(truckId, currentFilter);
            } else {
                showNoDataMessage();
                Swal.fire({
                    icon: 'warning',
                    title: 'No Truck Assigned',
                    text: 'You need to be assigned a truck to view fuel data',
                });
            }

            // Set up event listeners
            setupEventListeners();
        }

        function setupEventListeners() {
            // Time filter button clicks
            $('.time-btn').click(function() {
                if (truckId === 'Not assigned') return;
                
                $('.time-btn').removeClass('active');
                $(this).addClass('active');
                currentFilter = $(this).data('filter');
                loadFuelData(truckId, currentFilter);
            });
        }

        function loadFuelData(truckId, filter) {
            showLoadingState();

            $.ajax({
                url: '/fuel-analytics',
                method: 'GET',
                data: {
                    plate_number: truckId.replace(/\s+/g, ''),
                    time_filter: filter
                },
                success: function(response) {
                    if (response && response.length > 0) {
                        updateChart(response);
                    } else {
                        showNoDataMessage();
                    }
                },
                error: function(xhr) {
                    console.error('Error loading fuel data:', xhr.responseText);
                    if (xhr.status === 404) {
                        showNoDataMessage();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load fuel data. Please try again later.',
                        });
                        showNoDataMessage();
                    }
                },
                complete: function() {
                    hideLoadingState();
                }
            });
        }

        function updateChart(data) {
            const labels = data.map(item => {
                // Format date based on filter
                const date = new Date(item.date);
                if (currentFilter === 'yearly') {
                    return date.toLocaleDateString('en-US', {month: 'short'});
                } else if (currentFilter === 'monthly') {
                    return date.toLocaleDateString('en-US', {day: 'numeric', month: 'short'});
                }
                return date.toLocaleDateString('en-US', {weekday: 'short', day: 'numeric'});
            });
            
            const kilometers = data.map(item => item.total_km);
            const fuelUsed = data.map(item => item.total_liters);

            // Destroy previous chart if exists
            if (fuelChart) {
                fuelChart.destroy();
            }

            // Create new chart
            fuelChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Distance (KM)',
                            data: kilometers,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        },
                        {
                            label: 'Fuel Used (L)',
                            data: fuelUsed,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false
                            }
                        }
                    }
                }
            });

            // Show the chart
            ctx.style.display = 'block';
            noDataMessage.style.display = 'none';
        }

        function showLoadingState() {
            ctx.style.display = 'none';
            noDataMessage.style.display = 'none';
            loadingSpinner.style.display = 'block';
        }

        function hideLoadingState() {
            loadingSpinner.style.display = 'none';
        }

        function showNoDataMessage() {
            ctx.style.display = 'none';
            noDataMessage.style.display = 'block';
        }
    });
    </script>
</body>
</html>