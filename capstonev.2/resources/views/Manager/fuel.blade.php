<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Sidebar Menu</title>
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
        .fuel-table th:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .fuel-table th:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
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
            height: 68vh
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
        <div id="fuel-management" class="section">
            <h3>Fuel Management</h3>
            <button class="add-consumption-btn" onclick="openFuelModal()" id="addConsumptionBtn">
                <span class="plus-circle">+</span>
                Add Consumption
            </button>
            <div class="chart-container">
                <canvas id="fuelChart"></canvas>
            </div>
        </div>
    </div>
    @include('Manager.modals.fuelmodal')
</body>
<script>
    let fuelChart = null;

    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('fuelChart').getContext('2d');
        document.getElementById('fuelChart').height = 400;
        fuelChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [0, 50, 100, 150, 200, 250, 300, 340],
                datasets: [{
                    label: 'Fuel Consumption (liters)',
                    data: [0, 5, 10, 15, 20, 25, 30, 35],
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
    });

    function openFuelModal() {
        document.getElementById('fuelModal').style.display = 'block';
    }

    function closeFuelModal() {
        document.getElementById('fuelModal').style.display = 'none';
    }

    function addFuelConsumption() {
        // Add your logic to handle the add action
        alert('Fuel consumption added successfully!');
        closeFuelModal();
    }
</script>
</html>