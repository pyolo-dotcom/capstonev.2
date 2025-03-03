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
            display: q flex;
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

        .fuel-stats {
            display: flex;
            justify-content: space-around;
            background: #2f4156;
            color: white;
            padding: 10px;
            border-radius: 40px;
            margin-bottom: 10px;
            margin-left: -40px;
        }

        .stat {
            text-align: center;
        }

        .chart-container {
            width: 95%;
            height: 70vh;
            margin-top: 40px;
            background: transparent;
            /* Ensure visibility */
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Ensure the canvas takes up the full container */
        .chart-container canvas {
            width: 100% !important;
            max-width: 100%;
            display: block;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>Sidebar Menu</h2>
        <ul>
            <x-drivernavbar />
        </ul>
    </div>
    <div class="content">
        <div class="fuel-stats">
            <div class="stat">
                <h3>Total Kilometers</h3>
                <p>379 KL</p>
            </div>
            <div class="stat">
                <h3>Total Fuel Consumed</h3>
                <p>30L</p>
            </div>
            <div class="stat">
                <h3>Avg Fuel Efficiency</h3>
                <p>6.7 km/L</p>
            </div>
        </div>
        <div class="chart-container">
            <canvas id="fuelChart"></canvas>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('fuelChart').getContext('2d');
        document.getElementById('fuelChart').height = 400;  // Ensure height is set here
        var fuelChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [0, 50, 100, 150, 200, 250, 300, 340],
                datasets: [{
                    label: 'Fuel Consumption (liters)',
                    data: [0, 5, 10, 15, 20, 25, 30, 35],
                    borderColor: 'green',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                responsive: true, // Ensure it resizes correctly
                maintainAspectRatio: false,  // Ensure the canvas resizes to fill the parent container
            }
        });
    });
</script>

</html>