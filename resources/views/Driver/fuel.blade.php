<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fuel Consumption</title>
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
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
            padding: 25px;
            flex-grow: 1;
            background-color: white;
            min-height: 100vh;
        }
        
        .truck-display {
            background: #f1f3f5;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: inline-block;
            font-size: 16px;
            font-weight: 600;
            border: 1px solid #e1e5e9;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .truck-display i {
            margin-right: 12px;
            color: #495057;
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #343a40;
        }

        .time-filter {
            margin-bottom: 30px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .time-btn {
            padding: 10px 22px;
            border: none;
            background: #e9ecef;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .time-btn:hover {
            background: #dee2e6;
            transform: translateY(-1px);
        }
        
        .time-btn.active {
            background: #1f1a5c;
            color: white;
            box-shadow: 0 4px 8px rgba(31, 26, 92, 0.2);
        }

        .card {
            border-radius: 10px;
            border: 1px solid #e9ecef;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        .card-body {
            padding: 30px;
            position: relative;
            min-height: 550px;
        }

        .no-data {
            text-align: center;
            padding: 50px;
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

        .chart-container {
            width: 100%;
            height: 100%;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
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
            
            .card-body {
                padding: 20px;
                min-height: 400px;
            }

            .header-section {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 576px) {
            .time-btn {
                flex: 1 0 calc(50% - 6px);
            }
            
            .card-body {
                min-height: 350px;
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
        <!-- Header Section -->
        <div class="header-section">
            <div class="truck-display">
                <i class="fas fa-user"></i>
                <span id="assignedTruck">{{ $driverName ?? 'Not assigned' }}</span>
                <input type="hidden" id="plateNumber" value="{{ $plateNumber ?? '' }}">
            </div>
        </div>

        <h2 class="section-title">FUEL CONSUMPTION ANALYTICS</h2>

        <!-- Time Period Filters -->
        <div class="time-filter">
            <button class="time-btn active" data-filter="weekly">
                <i class="fas fa-calendar-week me-2"></i>Weekly
            </button>
            <button class="time-btn" data-filter="monthly">
                <i class="fas fa-calendar-alt me-2"></i>Monthly
            </button>
            <button class="time-btn" data-filter="yearly">
                <i class="fas fa-calendar me-2"></i>Yearly
            </button>
        </div>

        <!-- Chart Card -->
        <div class="card">
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="fuelChart"></canvas>
                </div>
                <div class="no-data" id="noDataMessage">
                    <i class="fas fa-info-circle fa-3x mb-4" style="color: #adb5bd;"></i>
                    <h5 style="color: #6c757d;">No fuel consumption data available</h5>
                </div>
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const plateNumber = $('#plateNumber').val().trim();
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

            if (plateNumber !== '') {
                loadFuelData(plateNumber, currentFilter);
            } else {
                showNoDataMessage();
                Swal.fire({
                    icon: 'warning',
                    title: 'Walang Nakatalang Trak',
                    text: 'Kailangan mong magkaroon ng nakatalagang trak para makita ang fuel data',
                    confirmButtonColor: '#1f1a5c'
                });
            }

            // Set up event listeners
            setupEventListeners();
        }

        function setupEventListeners() {
            // Time filter button clicks
            $('.time-btn').click(function() {
                if (plateNumber === '') return;
                
                $('.time-btn').removeClass('active');
                $(this).addClass('active');
                currentFilter = $(this).data('filter');
                loadFuelData(plateNumber, currentFilter);  // Gamitin ang plateNumber sa halip na truckId
            });
        }

        function loadFuelData(plateNumber, filter) {
            showLoadingState();

            $.ajax({
                url: '/fuel-analytics',
                method: 'GET',
                data: {
                    plate_number: plateNumber,  // Tanggalin ang replace method
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
                            confirmButtonColor: '#1f1a5c'
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
                const date = new Date(item.date);
                switch(currentFilter) {
                    case 'yearly':
                        return date.toLocaleDateString('en-US', {month: 'short', year: 'numeric'});
                    case 'monthly':
                        return date.toLocaleDateString('en-US', {day: 'numeric', month: 'short'});
                    default: // weekly
                        return date.toLocaleDateString('en-US', {weekday: 'short', month: 'short', day: 'numeric'});
                }
            });
            
            const kilometers = data.map(item => item.total_km);
            const fuelUsed = data.map(item => item.total_liters);

            // Destroy previous chart if exists
            if (fuelChart) {
                fuelChart.destroy();
            }

            // Create new chart with only Distance and Fuel Used
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
                            borderRadius: 4,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Fuel Used (L)',
                            data: fuelUsed,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            borderRadius: 4,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxRotation: 45,
                                minRotation: 45
                            }
                        },
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Distance (KM)'
                            },
                            grid: {
                                drawOnChartArea: true
                            },
                            beginAtZero: true
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Fuel (L)'
                            },
                            grid: {
                                drawOnChartArea: false
                            },
                            beginAtZero: true
                        }
                    },
                    animation: {
                        duration: 1000
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