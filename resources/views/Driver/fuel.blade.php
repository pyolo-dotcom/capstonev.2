<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Fuel Manager</title>
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
.content {
    margin-left: 270px;
    padding: 20px;
    flex-grow: 1;
    flex-wrap: wrap;
}
.item {
            flex-grow: 1;
            flex-basis: 200;
        }
.chart-container {
    width: 90%;
    margin-left: 53px;
    margin-top: 20px;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

/* Plate Number Dropdown & Filter Section */
.filter-section {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

#plateNumberSelect {
    padding: 5px;
    font-size: 16px;
}

/* Time Filter Buttons */
.time-filter {
    display: flex;
    gap: 10px;
}

.time-filter-btn {
    padding: 8px 15px;
    border: none;
    background-color: #ECF0F1;
    cursor: pointer;
    font-size: 15px;
    border-radius: 5px;
    transition: 0.3s;
}

.time-filter-btn:hover {
    background-color: #BDC3C7;
}

.time-filter-btn.active {
    background-color: #1d2d3d;
    color: white;
}

/* Add Consumption Button */
.add-consumption-btn {
    display: flex;
    align-items: center;
    margin: 7px -7px;
    padding: 8px 10px;
    background-color: transparent;
    color: black;
    border: none;
    border-radius: 14px;
    font-size: 17px;
    cursor: pointer;
}
.add-consumption-btn:hover {
    background-color: #485379;
    color: white;
}
.add-consumption-btn .plus-circle {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 24px;
    height: 24px;
    margin-right: 8px;
    background-color: transparent;
    color: black;
    border-radius: 50%;
    font-size: 16px;
    font-weight: bold;
    border: 1px solid black;
}

.add-consumption-btn:hover .plus-circle {
    background-color: transparent;
    color: white;
    border: none;
}
#fuelChart {
    width: 100%;
    max-height: 1000vh;
    height: 68vh;
}
@media (max-width: 768px) {
        body {
            flex-direction: column; /* Stack sidebar and content vertically */
        }

        .sidebar {
            width: 100%; /* Full width for the sidebar */
            height: auto; /* Adjust height */
            position: relative; /* Remove fixed positioning */
        }

        .content {
            margin-left: 0; /* Remove left margin */
            padding: 10px; /* Add padding for better spacing */
        }

        .filter-section {
            flex-direction: column; /* Stack filter elements vertically */
            align-items: flex-start; /* Align items to the start */
            gap: 10px; /* Reduce gap between elements */
        }

        #plateNumberSelect {
            width: 100%; /* Full width for dropdown */
        }

        .time-filter {
            flex-wrap: wrap; /* Allow buttons to wrap */
            gap: 5px; /* Reduce gap between buttons */
        }

        .chart-container {
            width: 100%; /* Full width for the chart */
            margin-left: 0; /* Remove left margin */
            margin-top: 10px; /* Adjust top margin */
        }

        #fuelChart {
            height: 50vh; /* Adjust chart height for smaller screens */
        }
    }

    @media (max-width: 480px) {
        .time-filter-btn {
            font-size: 12px; /* Reduce button font size */
            padding: 5px 10px; /* Adjust button padding */
        }

        .add-consumption-btn {
            font-size: 14px; /* Reduce button font size */
            padding: 5px 8px; /* Adjust button padding */
        }

        .add-consumption-btn .plus-circle {
            width: 20px; /* Adjust circle size */
            height: 20px;
            font-size: 12px; /* Adjust font size */
        }
    }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Sidebar Menu</h2>
        <ul>
            <x-drivernavbar/>
        </ul>
    </div>

    <div class="content">
        <h3>Fuel Management</h3>

        <div class="filter-section">
            <label for="plateNumberSelect">Plate No.:</label>
            <select id="plateNumberSelect" name="plateNumberSelect" required>
                <option disabled selected>-- Plate Number --</option>
                <option value="UVP353">UVP353</option>
                <option value="TQE262">TQE262</option>
                <option value="NBB7212">NBB7212</option>
                <option value="APA3309">APA3309</option>
                <option value="WIE914">WIE914</option>
                <option value="all">All Trucks</option>
            </select>

            <div class="time-filter">
                <button class="time-filter-btn active" data-filter="weekly">Weekly</button>
                <button class="time-filter-btn" data-filter="monthly">Monthly</button>
                <button class="time-filter-btn" data-filter="yearly">Annually</button>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="fuelChart"></canvas>
        </div>
    </div>

    @include('Manager.modals.fuelmodal')
</body>
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
            fuelChartCanvas.style.display = 'none'; // Hide only the graph
            return;
        }

        fetch(`/fuel-analytics?plate_number=${encodeURIComponent(plateNumber)}&time_filter=${timeFilter}`)
            .then(response => response.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    console.warn("No data returned for plate number:", plateNumber);
                    updateFuelChart([], [], []);
                    fuelChartCanvas.style.display = 'none'; // Hide if no data
                    return;
                }

                let labels = data.map(item => item.date);
                let kilometers = data.map(item => item.total_km);
                let fuelUsed = data.map(item => item.total_liters);

                updateFuelChart(labels, kilometers, fuelUsed);
                fuelChartCanvas.style.display = 'block'; // Show graph when data is available
            })
            .catch(error => console.error('Error fetching fuel data:', error));
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
            fuelChartCanvas.style.display = 'none'; // Hide only the graph
        } else {
            fetchFuelData(selectedPlateNumber, selectedTimeFilter);
        }
    });

    // Handle time filter selection
    document.querySelectorAll('.time-filter-btn').forEach(button => {
        button.addEventListener('click', function () {
            if (!selectedPlateNumber || selectedPlateNumber === "-- Plate Number --") {
                return; // Prevent fetching if no plate is selected
            }

            selectedTimeFilter = this.getAttribute('data-filter');
            document.querySelectorAll('.time-filter-btn').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            fetchFuelData(selectedPlateNumber, selectedTimeFilter);
        });
    });
});

    // Add event listeners for real-time calculation
    document.getElementById('totalKm').addEventListener('input', calculateLiters);
    document.getElementById('avgKmL').addEventListener('input', calculateLiters);
function calculateLiters() {
    let totalKm = document.getElementById('totalKm').value;
    let avgKmL = document.getElementById('avgKmL').value;
    if (totalKm && avgKmL) {
        document.getElementById('totalLiters').value = (totalKm / avgKmL).toFixed(2);
    } else {
        document.getElementById('totalLiters').value = '';
    }
}

function openFuelModal() {
    document.getElementById('fuelModal').style.display = 'block';
}

function closeFuelModal() {
    document.getElementById('fuelModal').style.display = 'none';
}

function addFuelConsumption() {
    let formData = new FormData(document.getElementById('fuelForm'));

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
            alert(data.message);
            closeFuelModal();
            document.getElementById('fuelForm').reset();
        } else {
            alert('Error adding fuel consumption.');
            console.log(data);
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
</body>
</html>
