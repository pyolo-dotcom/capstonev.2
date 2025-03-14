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
    font-size: 14px;
    border-radius: 5px;
    transition: 0.3s;
}

.time-filter-btn:hover {
    background-color: #BDC3C7;
}

.time-filter-btn.active {
    background-color: #3498DB;
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
    background-color: white;
    color: #2f385f;
    border-radius: 50%;
    font-size: 16px;
    font-weight: bold;
    border: 1px solid black;
}
#fuelChart {
    width: 100%;
    max-height: 1000vh;
    height: 68vh;
}
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Sidebar Menu</h2>
        <ul>
            <x-managernavbar/>
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

        <button class="add-consumption-btn" onclick="openFuelModal()" id="addConsumptionBtn">
            <span class="plus-circle">+</span> Add Consumption
        </button>

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
    document.getElementById('fuelChart').height = 400;

    // Default filter
    let selectedTimeFilter = 'weekly';
    let selectedPlateNumber = 'all';

    function fetchFuelData(plateNumber, timeFilter) {
        fetch(`/fuel-analytics?plate_number=${encodeURIComponent(plateNumber)}&time_filter=${timeFilter}`)
            .then(response => response.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    console.warn("No data returned for plate number:", plateNumber);
                    updateFuelChart([], []);
                    return;
                }

                let labels = data.map(item => item.total_km);
                let fuelUsed = data.map(item => item.total_liters);

                updateFuelChart(labels, fuelUsed);
            })
            .catch(error => console.error('Error fetching fuel data:', error));
    }

    function updateFuelChart(labels, fuelUsed) {
        if (fuelChart) {
            fuelChart.destroy();
        }

        fuelChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Fuel Consumption (liters)',
                    data: fuelUsed,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Fetch initial data
    fetchFuelData(selectedPlateNumber, selectedTimeFilter);

    // Handle plate number selection
    document.getElementById('plateNumberSelect').addEventListener('change', function () {
        selectedPlateNumber = this.value.trim();
        fetchFuelData(selectedPlateNumber, selectedTimeFilter);
    });

    // Handle time filter selection
    document.querySelectorAll('.time-filter-btn').forEach(button => {
        button.addEventListener('click', function () {
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