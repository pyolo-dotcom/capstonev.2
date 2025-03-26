<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profit Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            display: flex;
            background-color: #f5f7fa;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            height: 100vh;
            background: var(--secondary-color);
            padding: 20px 0;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        
        .sidebar-brand {
            padding: 0 20px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        
        .sidebar-brand h2 {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        
        .sidebar ul li a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: all 0.3s;
            font-size: 0.95rem;
            border-left: 3px solid transparent;
        }
        
        .sidebar ul li a:hover, 
        .sidebar ul li a.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left: 3px solid var(--primary-color);
            padding-left: 17px;
        }
        
        .sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 25px;
            width: calc(100% - 250px);
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .header h2 {
            color: var(--secondary-color);
            font-weight: 600;
            margin: 0;
            font-size: 1.8rem;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 30px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
        }
        
        .card-header {
            background-color: var(--secondary-color);
            color: white;
            padding: 16px 25px;
            border-bottom: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-header h3 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 500;
        }
        
        .table-responsive {
            overflow-x: auto;
            border-radius: 0 0 10px 10px;
        }
        
        .table {
            margin-bottom: 0;
            width: 100%;
        }
        
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: var(--dark-color);
            padding: 12px 15px;
        }
        
        .table tbody tr {
            transition: all 0.2s;
        }
        
        .table tbody tr:hover {
            background-color: rgba(0,0,0,0.03);
        }
        
        .table td {
            padding: 12px 15px;
            vertical-align: middle;
        }
        
        .badge {
            padding: 6px 10px;
            font-weight: 500;
            font-size: 0.75rem;
        }
        
        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .btn-action {
            padding: 6px 12px;
            font-size: 0.85rem;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }
        
        .btn-edit {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }
        
        .btn-edit:hover {
            background-color: #2980b9;
            color: white;
            transform: translateY(-1px);
        }
        
        .btn-archive {
            background-color: var(--warning-color);
            color: white;
            border: none;
        }
        
        .btn-archive:hover {
            background-color: #e67e22;
            color: white;
            transform: translateY(-1px);
        }
        
        .empty-message {
            padding: 40px;
            text-align: center;
            color: #6c757d;
        }
        
        .empty-message i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #dee2e6;
        }
        
        /* Enhanced Filter Section */
        .filter-section {
            background-color: white;
            padding: 18px 25px;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 25px;
        }
        
        .filter-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .filter-label {
            font-weight: 600;
            color: var(--secondary-color);
            margin-right: 8px;
            font-size: 0.95rem;
        }
        
        .time-filter {
            display: flex;
            gap: 8px;
            background: #f8f9fa;
            padding: 6px;
            border-radius: 10px;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .time-filter-btn {
            padding: 10px 22px;
            border: none;
            background-color: transparent;
            cursor: pointer;
            font-size: 0.95rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            color: var(--dark-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .time-filter-btn:hover {
            background-color: #e9ecef;
        }
        
        .time-filter-btn.active {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
            transform: translateY(-1px);
        }
        
        .plate-filter {
            display: flex;
            align-items: center;
            margin-left: auto;
        }
        
        #plateNumberSelect {
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 0.95rem;
            min-width: 200px;
            background-color: white;
            transition: all 0.3s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        #plateNumberSelect:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }
        
        .chart-container {
            margin-top: 20px;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .filter-section {
                gap: 15px;
            }
            
            .time-filter-btn {
                padding: 8px 15px;
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }
            
            .sidebar-brand h2 {
                display: none;
            }
            
            .sidebar ul li a span {
                display: none;
            }
            
            .sidebar ul li a i {
                margin-right: 0;
                font-size: 1.2rem;
            }
            
            .main-content {
                margin-left: 70px;
                width: calc(100% - 70px);
                padding: 15px;
            }
            
            .filter-section {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
                padding: 15px;
            }
            
            .plate-filter {
                margin-left: 0;
            }
            
            .time-filter {
                flex-wrap: wrap;
                justify-content: stretch;
            }
            
            .time-filter-btn {
                flex: 1 1 100px;
                text-align: center;
                justify-content: center;
                padding: 10px;
            }
            
            #plateNumberSelect {
                width: 100%;
            }
            
            .header h2 {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .actions {
                flex-direction: column;
                gap: 6px;
            }
            
            .btn-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2>Profit Reports</h2>
        </div>
        <ul>
            <x-navbar/>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h2><i class="fas fa-chart-line me-2"></i>Profit Reports Management</h2>
        </div>
        
        <!-- Enhanced Filter Section -->
        <div class="filter-section">
            <div class="filter-group">
                <span class="filter-label">Time Period:</span>
                <div class="time-filter">
                    <button class="time-filter-btn active" id="weeklyFilter">
                        <i class="fas fa-calendar-week me-1"></i> Weekly
                    </button>
                    <button class="time-filter-btn" id="monthlyFilter">
                        <i class="fas fa-calendar-alt me-1"></i> Monthly
                    </button>
                    <button class="time-filter-btn" id="yearlyFilter">
                        <i class="fas fa-calendar me-1"></i> Yearly
                    </button>
                </div>
            </div>
            
            <div class="plate-filter">
                <label for="plateNumberSelect" class="filter-label me-2">Truck:</label>
                <select id="plateNumberSelect" class="form-select">
                    <option value="all" selected>All Trucks</option>
                    <option value="UVP353">UVP353</option>
                    <option value="TQE262">TQE262</option>
                    <option value="NBB7212">NBB7212</option>
                    <option value="APA3309">APA3309</option>
                    <option value="WIE914">WIE914</option>
                </select>
            </div>
        </div>
        
        <!-- Profit Reports Card -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-table me-2"></i>Profit Reports</h3>
            </div>
            <div class="card-body">
                @include('Admin.modals.profit_modal')
                @foreach($profits as $profit)
                    @include('Admin.modals.edit_profit_modal', ['profit' => $profit])
                @endforeach

                @if($profits->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="profitTable">
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
                                <td class="actions">
                                    <button type="button" class="btn-action btn-edit" 
                                        onclick="openEditModal({{ $profit->id }}, '{{ $profit->date }}', '{{ $profit->plate_number }}', {{ $profit->total_income }}, {{ $profit->total_expenses }}, {{ $profit->total_profit }})">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                
                                    <form action="{{ route('admin.profit.archive', $profit->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-archive" onclick="return confirm('Are you sure you want to archive this record?')">
                                            <i class="fas fa-archive"></i> Archive
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-message">
                    <i class="fas fa-folder-open"></i>
                    <h5>No profit records found</h5>
                    <p class="text-muted">There are currently no profit records available.</p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Profit Analysis Chart -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-chart-bar me-2"></i>Profit Analysis</h3>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="profitChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const profitData = @json($profits);
        const ctx = document.getElementById('profitChart').getContext('2d');
        let profitChart;
        let currentFilter = 'weekly'; // Default to weekly
        let currentPlateFilter = 'all';

        // Function to filter data by time period
        function filterByTimePeriod(data, period) {
            const now = new Date();
            const currentDate = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            
            return data.filter(profit => {
                const profitDate = new Date(profit.date);
                
                switch(period) {
                    case 'weekly':
                        const oneWeekAgo = new Date(currentDate);
                        oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);
                        return profitDate >= oneWeekAgo;
                        
                    case 'monthly':
                        const oneMonthAgo = new Date(currentDate);
                        oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
                        return profitDate >= oneMonthAgo;
                        
                    case 'yearly':
                        const oneYearAgo = new Date(currentDate);
                        oneYearAgo.setFullYear(oneYearAgo.getFullYear() - 1);
                        return profitDate >= oneYearAgo;
                        
                    default:
                        return true; // 'all' - no time filter
                }
            });
        }

        // Function to filter data by plate number
        function filterByPlateNumber(data, plateNumber) {
            if (plateNumber === 'all') return data;
            return data.filter(profit => profit.plate_number === plateNumber);
        }

        // Function to apply all filters
        function applyFilters() {
            let filteredData = [...profitData];
            
            // Apply time filter
            filteredData = filterByTimePeriod(filteredData, currentFilter);
            
            // Apply plate number filter
            filteredData = filterByPlateNumber(filteredData, currentPlateFilter);
            
            return filteredData;
        }

        // Function to update the table display
        function updateTableDisplay(filteredData) {
            const rows = document.querySelectorAll('#profitTable tbody tr');
            const visibleIds = filteredData.map(profit => profit.id.toString());
            
            rows.forEach(row => {
                const rowId = row.getAttribute('data-id');
                row.style.display = visibleIds.includes(rowId) ? '' : 'none';
            });
        }

        // Function to render the chart
        function renderChart(filteredData) {
            // Sort data by date ascending
            filteredData.sort((a, b) => new Date(a.date) - new Date(b.date));
            
            const labels = filteredData.map(profit => {
                const date = new Date(profit.date);
                
                switch(currentFilter) {
                    case 'weekly':
                        return date.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' });
                    case 'monthly':
                        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                    case 'yearly':
                        return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short' });
                    default:
                        return profit.date;
                }
            });
            
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
                        { 
                            label: 'Total Income', 
                            data: incomeData, 
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        { 
                            label: 'Total Expenses', 
                            data: expensesData, 
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        { 
                            label: 'Total Profit', 
                            data: profitDataSet, 
                            backgroundColor: 'rgba(153, 102, 255, 0.7)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: { 
                    responsive: true, 
                    scales: { 
                        y: { 
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'P ' + value.toLocaleString();
                                }
                            }
                        } 
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += 'P ' + context.raw.toLocaleString();
                                    return label;
                                },
                                afterLabel: function(context) {
                                    // Show full date in tooltip
                                    const dataIndex = context.dataIndex;
                                    const fullDate = new Date(filteredData[dataIndex].date);
                                    return 'Date: ' + fullDate.toLocaleDateString('en-US', { 
                                        year: 'numeric', 
                                        month: 'long', 
                                        day: 'numeric' 
                                    });
                                }
                            }
                        }
                    }
                }
            });
        }

        // Filter by plate number
        document.getElementById('plateNumberSelect').addEventListener('change', function() {
            currentPlateFilter = this.value;
            const filteredData = applyFilters();
            updateTableDisplay(filteredData);
            renderChart(filteredData);
        });

        // Time filter buttons
        document.getElementById('weeklyFilter').addEventListener('click', function() {
            setActiveFilter('weekly');
        });

        document.getElementById('monthlyFilter').addEventListener('click', function() {
            setActiveFilter('monthly');
        });

        document.getElementById('yearlyFilter').addEventListener('click', function() {
            setActiveFilter('yearly');
        });

        function setActiveFilter(filter) {
            currentFilter = filter;
            
            // Update button states
            document.querySelectorAll('.time-filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Add animation to active button
            const activeBtn = document.getElementById(filter + 'Filter');
            activeBtn.classList.add('active');
            activeBtn.style.transform = 'scale(1.05)';
            setTimeout(() => {
                activeBtn.style.transform = 'scale(1)';
            }, 200);
            
            // Apply filters
            const filteredData = applyFilters();
            updateTableDisplay(filteredData);
            renderChart(filteredData);
        }

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

        // Initialize with weekly data
        setActiveFilter('weekly');
    </script>
</body>
</html>