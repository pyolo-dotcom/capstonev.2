<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fuel Management</title>
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        .content-header {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .content-header h2 {
            color: #1f1a5c;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }

        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .filter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .truck-select {
            padding: 8px 15px;
            border: 1px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            color: #495057;
            background-color: #fff;
            width: 200px;
        }

        .date-filter {
            display: flex;
            gap: 10px;
        }

        .date-btn {
            padding: 8px 15px;
            border: 1px solid #e1e5e9;
            border-radius: 8px;
            background-color: #fff;
            color: #495057;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .date-btn.active, 
        .date-btn:hover {
            background-color: #1f1a5c;
            color: #fff;
            border-color: #1f1a5c;
        }

        .export-btn {
            background: #1f1a5c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
            transition: all 0.3s;
        }

        .export-btn:hover {
            background: #161245;
            transform: translateY(-1px);
        }

        .chart-container {
            width: 100%;
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        #fuelChart {
            width: 100%;
            height: 400px;
        }

        
        .add-consumption-btn {
            background: none;
    color: #1f1a5c;
    border: none;
    padding: 8px 15px;
    border-radius: 8px;
    font-size: 1.2rem;
    font-weight:800;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
    white-space: nowrap;
        }
  .circle-plus {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border:2px solid #2f4156;
    color: #2f4156;
    font-weight: bold;
    font-size: 1rem;
}
        .add-consumption-btn:hover {
             background: rgba(1, 31, 139, 0.05);
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
            }
            
            .content {
                margin-left: 0;
            }
            
            .filter-container {
                flex-direction: column;
            }
            
            .date-filter {
                width: 100%;
            }
            
            .date-btn {
                flex-grow: 1;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <x-managernavbar />
        </ul>
    </div>

    <div class="content">
        <div class="content-header">
            <h2><i class="fas fa-gas-pump me-2"></i>Fuel Management</h2>
        </div>
        
        <div class="table-container">
            <div class="filter-container">
                <div style="display: flex; align-items: center; gap: 8px;">
                    
                    <select id="plateNumberSelect" name="plateNumberSelect" class="truck-select" required>
                        <option disabled selected>-- Plate Number --</option>
                        <option value="all">All Trucks</option>
                        @foreach($plateNumbers as $plate)
                            <option value="{{ $plate }}">{{ $plate }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="date-filter">
                    <button class="date-btn active time-filter-btn" data-filter="weekly">Weekly</button>
                    <button class="date-btn time-filter-btn" data-filter="monthly">Monthly</button>
                    <button class="date-btn time-filter-btn" data-filter="yearly">Annually</button>
                </div>
            </div>

            <button class="add-consumption-btn" onclick="openFuelModal()" id="addConsumptionBtn">
                <span class="circle-plus">+</span> Add Consumption
            </button>

            <div class="chart-container">
                <canvas id="fuelChart"></canvas>
            </div>
        </div>
    </div>

    @include('manager.modals.fuelmodal')

<script>
let fuelChart = null;
document.addEventListener('DOMContentLoaded', function () {
    let ctx = document.getElementById('fuelChart').getContext('2d');
    let fuelChartCanvas = document.getElementById('fuelChart'); 
    let selectedTimeFilter = 'weekly';
    let selectedPlateNumber = null;

    // Hide the graph (canvas) initially
    fuelChartCanvas.style.display = 'none';

    function fetchFuelData(plateNumber, timeFilter) {
        if (!plateNumber || plateNumber === "-- Plate Number --") {
            fuelChartCanvas.style.display = 'none';
            Swal.fire({
                icon: 'info',
                title: 'No Plate Selected',
                text: 'Please select a plate number to view fuel data',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        fetch(`/fuel-analytics?plate_number=${encodeURIComponent(plateNumber)}&time_filter=${timeFilter}`)
            .then(response => response.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    fuelChartCanvas.style.display = 'none';
                    Swal.fire({
                        icon: 'info',
                        title: 'No Data Available',
                        text: `No fuel data found for ${plateNumber} in the selected time period`,
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }

                let labels = data.map(item => item.date);
                let kilometers = data.map(item => item.total_km);
                let fuelUsed = data.map(item => item.total_liters);

                updateFuelChart(labels, kilometers, fuelUsed);
                fuelChartCanvas.style.display = 'block';
            })
            .catch(error => {
                console.error('Error fetching fuel data:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load fuel data. Please try again.',
                    confirmButtonColor: '#d33'
                });
            });
    }

    function updateFuelChart(labels, kilometers, fuelUsed) {
        if (fuelChart) {
            fuelChart.destroy();
        }

        fuelChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Kilometers (KM)',
                        data: kilometers,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        yAxisID: 'y1'
                    },
                    {
                        label: 'Fuel Consumption (L)',
                        data: fuelUsed,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        yAxisID: 'y2'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Kilometers (KM)'
                        }
                    },
                    y2: {
                        beginAtZero: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Liters (L)'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                }
            }
        });
    }

    // Handle plate number selection
    document.getElementById('plateNumberSelect').addEventListener('change', function () {
        selectedPlateNumber = this.value.trim();
        
        if (selectedPlateNumber === "-- Plate Number --") {
            fuelChartCanvas.style.display = 'none';
        } else {
            fetchFuelData(selectedPlateNumber, selectedTimeFilter);
        }
    });

    // Handle time filter selection
    document.querySelectorAll('.date-btn').forEach(button => {
        button.addEventListener('click', function() {
            if (!selectedPlateNumber || selectedPlateNumber === "-- Plate Number --") {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Plate Selected',
                    text: 'Please select a plate number first',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            // Remove active class from all buttons
            document.querySelectorAll('.date-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to clicked button
            this.classList.add('active');
            
            // Get the filter value from data-filter attribute
            selectedTimeFilter = this.getAttribute('data-filter');
            fetchFuelData(selectedPlateNumber, selectedTimeFilter);
        });
    });
});

function openFuelModal() {
    document.getElementById('fuelModal').style.display = 'block';
}

function closeFuelModal() {
    document.getElementById('fuelModal').style.display = 'none';
}

function addFuelConsumption() {
    let formData = new FormData(document.getElementById('fuelForm'));
    
    // Show loading indicator
    Swal.fire({
        title: 'Processing...',
        html: 'Adding fuel consumption data',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('/fuel-consumption', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                confirmButtonColor: '#3085d6'
            }).then(() => {
                closeFuelModal();
                document.getElementById('fuelForm').reset();
                // Refresh the chart if a plate number is selected
                const selectedPlate = document.getElementById('plateNumberSelect').value;
                if (selectedPlate && selectedPlate !== "-- Plate Number --") {
                    const timeFilter = document.querySelector('.time-filter-btn.active').getAttribute('data-filter');
                    fetchFuelData(selectedPlate, timeFilter);
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Failed to add fuel consumption',
                confirmButtonColor: '#d33'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An unexpected error occurred. Please try again.',
            confirmButtonColor: '#d33'
        });
    });
}
</script>
</body>
</html>