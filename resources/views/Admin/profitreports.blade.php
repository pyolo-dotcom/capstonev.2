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
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <x-navbar/>
        </ul>
    </div>

    <div class="content">
        <div class="header-buttons">
            <button class="tab-button" id="weeklyFilter">WEEKLY</button>
            <button class="tab-button" id="monthlyFilter">MONTHLY</button>
            <button class="tab-button" id="yearlyFilter">YEARLY</button>
        </div>

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
        </div>

        <div class="table-container">
            @include('Admin.modals.profit_modal')
            @foreach($profits as $profit)
                @include('Admin.modals.edit_profit_modal', ['profit' => $profit])
            @endforeach

            <table id="profitTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Plate Number</th>
                        <th>Total Income</th>
                        <th>Total Expenses</th>
                        <th>Total Profit</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($profits as $profit)
                    <tr data-id="{{ $profit->id }}">
                        <td>{{ $profit->date }}</td>
                        <td>{{ $profit->plate_number }}</td>
                        <td>P {{ number_format($profit->total_income, 2) }}</td>
                        <td>P {{ number_format($profit->total_expenses, 2) }}</td>
                        <td>P {{ number_format($profit->total_profit, 2) }}</td>
                        <td>
                            <!-- Edit Button -->
                            <a href="#" class="edit-btn" onclick="openEditModal({{ $profit->id }}, '{{ $profit->date }}', '{{ $profit->plate_number }}', {{ $profit->total_income }}, {{ $profit->total_expenses }}, {{ $profit->total_profit }})">
                                <i class="bi bi-pencil-square"></i> edit
                            </a>
                        
                            <!-- Archive Button -->
                            <form action="{{ route('admin.profit.archive', $profit->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="archive-btn" onclick="return confirm('Are you sure you want to archive this record?')">
                                    <i class="bi bi-archive"></i> archive
                                </button>
                            </form>
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
        const profitData = @json($profits);
        const ctx = document.getElementById('profitChart').getContext('2d');
        let profitChart;

        function renderChart(filteredData) {
            const labels = filteredData.map(profit => profit.date);
            const incomeData = filteredData.map(profit => profit.total_income);
            const expensesData = filteredData.map(profit => profit.total_expenses);
            const profitDataSet = filteredData.map(profit => profit.total_profit);

            if (profitChart) {
                profitChart.destroy();
            }

            profitChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'Total Income', data: incomeData, backgroundColor: 'rgba(54, 162, 235, 0.7)' },
                        { label: 'Total Expenses', data: expensesData, backgroundColor: 'rgba(75, 192, 192, 0.7)' },
                        { label: 'Total Profit', data: profitDataSet, backgroundColor: 'rgba(153, 102, 255, 0.7)' }
                    ]
                },
                options: { responsive: true, scales: { y: { beginAtZero: true } } }
            });
        }

        document.getElementById('plateNumberSelect').addEventListener('change', function() {
            const selectedPlateNumber = this.value;
            const rows = document.querySelectorAll('#profitTable tbody tr');
            const filteredData = [];

            rows.forEach(row => {
                const plateNumberCell = row.querySelector('td:nth-child(2)');
                if (plateNumberCell) {
                    const plateNumber = plateNumberCell.textContent.trim();
                    if (selectedPlateNumber === 'all' || plateNumber === selectedPlateNumber) {
                        row.style.display = '';
                        if (selectedPlateNumber !== 'all') {
                            const profitId = row.getAttribute('data-id');
                            const profit = profitData.find(p => p.id == profitId);
                            if (profit) {
                                filteredData.push(profit);
                            }
                        }
                    } else {
                        row.style.display = 'none';
                    }
                }
            });

            if (selectedPlateNumber === 'all') {
                renderChart(profitData);
            } else {
                renderChart(filteredData);
            }
        });

        // Initial chart render
        renderChart(profitData);

        // Function to open edit modal and populate data
        function openEditModal(id, date, plateNumber, totalIncome, totalExpenses, totalProfit) {
            document.getElementById('editProfitModal').style.display = 'block';
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_date').value = date;
            document.getElementById('edit_plate_number').value = plateNumber;
            document.getElementById('edit_total_income').value = totalIncome;
            document.getElementById('edit_total_expenses').value = totalExpenses;
            document.getElementById('edit_total_profit').value = totalProfit;
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target == document.getElementById('editProfitModal')) {
                document.getElementById('editProfitModal').style.display = 'none';
            }
        });

        // Close modal when clicking the close button
        document.querySelector('#editProfitModal .close').addEventListener('click', function() {
            document.getElementById('editProfitModal').style.display = 'none';
        });
    </script>
</body>
</html>