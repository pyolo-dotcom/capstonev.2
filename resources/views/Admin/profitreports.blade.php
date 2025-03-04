<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profit Reports</title>
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            background: #f8f9fa;
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
        .header-buttons {
            display: flex;
            gap: 15px;
        }
        .tab-button {
            padding: 10px 20px;
            border: none;
            background: #0056b3;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .table-container {
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #f4f4f4;
        }
        .chart-container {
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Sidebar Menu</h2>
        <ul>
            <x-navbar/>
        </ul>
    </div>

    <div class="content">
        <div class="header-buttons">
            <button class="tab-button">WEEKLY</button>
            <button class="tab-button">MONTHLY</button>
            <button class="tab-button">YEARLY</button>
        </div>

        <div class="table-container">
            <button class="tab-button">+ Add Profits</button>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Total Income</th>
                        <th>Total Expenses</th>
                        <th>Total Profit</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($profits as $profit)
                    <tr>
                        <td>{{ $profit->date }}</td>
                        <td>P {{ number_format($profit->income, 2) }}</td>
                        <td>P {{ number_format($profit->expenses, 2) }}</td>
                        <td>P {{ number_format($profit->profit, 2) }}</td>
                        <td>
                            <a href="#"><i class="bi bi-pencil-square"></i> edit</a>
                            <a href="#"><i class="bi bi-archive"></i> archive</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="chart-container">
            <h3>Profit Analysis</h3>
            <canvas id="profitChart"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('profitChart').getContext('2d');
        const profitChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['1', '2', '3', '4'],
                datasets: [
                    {
                        label: 'Total Income',
                        data: [5, 10, 15, 20],
                        backgroundColor: 'rgba(54, 162, 235, 0.7)'
                    },
                    {
                        label: 'Total Expenses',
                        data: [4, 9, 14, 18],
                        backgroundColor: 'rgba(75, 192, 192, 0.7)'
                    },
                    {
                        label: 'Total Profit',
                        data: [3, 8, 12, 15],
                        backgroundColor: 'rgba(153, 102, 255, 0.7)'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>
