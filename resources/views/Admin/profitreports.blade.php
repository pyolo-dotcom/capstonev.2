<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profit Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SheetJS for Excel export -->
    <script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>
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
        
        /* Header button container */
        .header > div {
            display: flex;
            gap: 10px;
            width: 100%;
            justify-content: space-between;
        }
        
        /* Filter section layout */
        .filter-section {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        /* Plate filter group - align left */
        .filter-group:first-child {
            order: 1;
            margin-right: auto;
        }

        /* Time filter group - align right */
        .filter-group:nth-child(2) {
            order: 2;
            margin-left: auto;
        }

        /* Plate filter container */
        .plate-filter {
            display: flex;
            align-items: center;
        }
        
        .sidebar-brand {
            display: none;
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

        /* Modal Fixes */
        .modal {
            z-index: 1060 !important;
        }
        .modal-backdrop {
            z-index: 1050 !important;
        }
        .modal-content {
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        }
        .modal-header {
            border-bottom: 1px solid #eee;
        }
        .modal-footer {
            border-top: 1px solid #eee;
        }
        /*added*/
        .profit-btn-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: nowrap;
    gap: 10px;
}

.btn-export {
    background-color: var(--success-color);
    color: white;
    border: none;
    transition: all 0.3s ease;
}

.btn-export:hover {
    background-color: #27ae60;
    color: white;
    transform: translateY(-1px);
}

/* Optional: prevent stacking on smaller screens */
@media (max-width: 600px) {
    .profit-btn-container {
        flex-wrap: nowrap;
    }

    .btn-export,
    .btn-primary {
        flex-shrink: 0;
        white-space: nowrap;
    }
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
                width: 100%;
                position: relative;
            }
            
            .content {
                margin-left: 0;
            }
            
            .filter-section {
                flex-direction: column;
                gap: 15px;
            }
            
            .filter-group:first-child,
            .filter-group:nth-child(2) {
                order: initial;
                margin: 0;
                width: 100%;
            }
            
            .time-filter {
                justify-content: flex-start;
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

    <div class="content">
        
            <h2><i class="fas fa-chart-line me-2"></i>Profit Reports Management</h2>
            <div>
               
           
     
        
        <!-- Enhanced Filter Section -->
        <div class="filter-section">
            <div class="filter-group">
                <div class="plate-filter">
                    <label for="plateNumberSelect" class="filter-label me-2">Truck:</label>
                    <select id="plateNumberSelect" class="form-select">
                        <option value="all" selected>All Trucks</option>
                        @foreach($plateNumbers as $plateNumber)
                            <option value="{{ $plateNumber }}">{{ $plateNumber }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="filter-group">
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
        </div>
         <!--changes-->
         <div class="profit-btn-container">
    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#profitModal">
        <i class="fas fa-plus me-2"></i>Add Profit Record
    </button>
    <button class="btn btn-success btn-export" onclick="exportProfitToExcel()">
        <i class="fas fa-file-excel me-2"></i>Export to Excel
    </button>
</div>
 
        <!-- Profit Reports Card -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-table me-2"></i>Profit Reports</h3>
            </div>
            <div class="card-body">
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
                                    <button type="button" class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editProfitModal-{{ $profit->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                
                                    <form action="{{ route('admin.profit.archive', $profit->id) }}" method="POST" style="display: inline;" class="archive-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-archive">
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

    <!-- Include Modals -->
    @include('admin.modals.profit_modal')
    @foreach($profits as $profit)
        @include('admin.modals.edit_profit_modal', ['profit' => $profit])
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        // Initialize profit calculation for add modal
        document.addEventListener('DOMContentLoaded', function() {
            // Add modal calculation
            const incomeInput = document.getElementById('total_income');
            const expensesInput = document.getElementById('total_expenses');
            if (incomeInput && expensesInput) {
                incomeInput.addEventListener('input', calculateProfit);
                expensesInput.addEventListener('input', calculateProfit);
            }

            // Edit modals calculation (using event delegation)
            document.addEventListener('input', function(e) {
                if (e.target && e.target.id && e.target.id.startsWith('edit_total_income-')) {
                    const id = e.target.id.split('-')[2];
                    calculateEditProfit(id);
                }
                if (e.target && e.target.id && e.target.id.startsWith('edit_total_expenses-')) {
                    const id = e.target.id.split('-')[2];
                    calculateEditProfit(id);
                }
            });

            // Archive confirmation with SweetAlert
            document.querySelectorAll('.archive-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const form = this;
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, archive it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Show success message if present in session
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            // Show error message if present in session
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}'
                });
            @endif
        });

        function calculateProfit() {
            const income = parseFloat(document.getElementById('total_income').value) || 0;
            const expenses = parseFloat(document.getElementById('total_expenses').value) || 0;
            document.getElementById('total_profit').value = (income - expenses).toFixed(2);
        }

        function calculateEditProfit(id) {
            const income = parseFloat(document.getElementById(`edit_total_income-${id}`).value) || 0;
            const expenses = parseFloat(document.getElementById(`edit_total_expenses-${id}`).value) || 0;
            document.getElementById(`edit_total_profit-${id}`).value = (income - expenses).toFixed(2);
        }

        // Excel Export Function
        function exportProfitToExcel() {
            // Get the filtered data
            const filteredData = applyFilters();
            
            // Prepare the data for export
            const exportData = filteredData.map(profit => ({
                'Date': profit.date,
                'Plate Number': profit.plate_number,
                'Total Income': profit.total_income,
                'Total Expenses': profit.total_expenses,
                'Total Profit': profit.total_profit
            }));
            
            // Create worksheet
            const worksheet = XLSX.utils.json_to_sheet(exportData);
            
            // Create workbook
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Profit Data");
            
            // Generate filename with current date and time
            const now = new Date();
            const formattedDate = now.toISOString().slice(0, 10);
            const formattedTime = now.toTimeString().slice(0, 8).replace(/:/g, '-');
            const filename = `Profit_Reports_${formattedDate}_${formattedTime}.xlsx`;
            
            // Export the workbook
            XLSX.writeFile(workbook, filename);
            
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Export Successful',
                text: `Profit data has been exported to ${filename}`,
                timer: 3000,
                showConfirmButton: false
            });
        }

        // Initialize with weekly data
        setActiveFilter('weekly');
    </script>
</body>
</html>