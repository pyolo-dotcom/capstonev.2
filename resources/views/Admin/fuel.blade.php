<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fuel Management - Admin</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- SheetJS for Excel export -->
    <script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>
    <style>
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

        .add-consumption-btn:hover {
            background: #161245;
            transform: translateY(-1px);
        }

        /* Improved Table Styles */
        .table-scroll-container {
            max-height: 500px;
            overflow-y: auto;
            margin-top: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }

        .fuel-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .fuel-table th {
            background-color: #1f1a5c;
            color: #fff;
            padding: 12px 15px;
            text-align: left;
            font-weight: 500;
            position: sticky;
            top: 0;
        }

        .fuel-table th:last-child {
            text-align: center;
        }

        .fuel-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e1e5e9;
            vertical-align: middle;
            color: #495057;
        }

        .fuel-table td:last-child {
            text-align: center;
            padding: 8px;
        }

        .actions {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
            white-space: nowrap;
            padding: 0;
            margin: 0;
            height: 100%;
        }

        .actions button, .actions form {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 0 12px;
            margin: 0;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .actions button {
            border: none;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 36px;
            gap: 6px;
            font-weight: 500;
        }

        .actions form {
            margin: 0;
            padding: 0;
            display: inline-flex;
            height: 100%;
        }

        .actions .edit-btn {
            background-color: rgba(0, 74, 173, 0.1);
            color: #004aad;
        }

        .actions .edit-btn:hover {
            background-color: rgba(0, 74, 173, 0.2);
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .actions .archive-btn {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .actions .archive-btn:hover {
            background-color: rgba(220, 53, 69, 0.2);
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .pagination-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding: 10px 0;
        }

        .page-info {
            font-size: 14px;
            color: #6c757d;
        }

        .page-buttons {
            display: flex;
            gap: 10px;
        }

        .page-btn {
            padding: 8px 15px;
            background-color: #1f1a5c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
        }

        .page-btn:hover {
            background-color: #161245;
        }

        .page-btn:disabled {
            background-color: #e1e5e9;
            color: #6c757d;
            cursor: not-allowed;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #6c757d;
            font-style: italic;
        }

        .btn-container {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
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

            .btn-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <x-navbar />
        </ul>
    </div>

    <div class="content">
        <div class="content-header">
            <h2><i class="fas fa-gas-pump me-2"></i>Fuel Management</h2>
        </div>
        
        <div class="table-container">
            <div class="filter-container">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <label for="plateNumberSelect" style="margin-right: 5px;">Plate No.:</label>
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

            <div class="btn-container">
                <button class="add-consumption-btn" onclick="openFuelModal()" id="addConsumptionBtn">
                    <i class="fas fa-plus"></i> Add Consumption
                </button>
                <button class="export-btn" onclick="exportToExcel()">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </button>
            </div>

            <div class="chart-container">
                <canvas id="fuelChart"></canvas>
            </div>

            <div class="table-scroll-container">
                <table class="fuel-table" id="fuelTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Plate No.</th>
                            <th>Total KM</th>
                            <th>Avg KM/L</th>
                            <th>Total Liters</th>
                            <th>Fuel Price</th>
                            <th>Total Cost</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="fuelTableBody">
                        @foreach($fuelData as $data)
                        <tr>
                            <td>{{ $data->date }}</td>
                            <td>{{ $data->plate_no }}</td>
                            <td>{{ number_format($data->total_km, 2) }}</td>
                            <td>{{ number_format($data->avg_km_l, 2) }}</td>
                            <td>{{ number_format($data->total_liters, 2) }}</td>
                            <td>{{ number_format($data->fuel_price, 2) }}</td>
                            <td>{{ number_format($data->total_cost, 2) }}</td>
                            <td>
                                <div class="actions">
                                    <button class="edit-btn" onclick="editFuel({{ $data->id }})" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                                    
                                    <form id="archiveForm{{ $data->id }}" action="{{ route('admin.fuel.archive', $data->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="archive-btn" onclick="confirmArchive({{ $data->id }})" title="Archive">
                                            <i class="fas fa-archive"></i> Archive
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-controls" id="paginationControls">
                <div class="page-info" id="pageInfo">Showing 1-10 of {{ $fuelData->count() }} records</div>
                <div class="page-buttons">
                    <button class="page-btn" id="prevPage" disabled>Previous</button>
                    <button class="page-btn" id="nextPage">Next</button>
                </div>
            </div>
        </div>
    </div>

    @include('admin.modals.fuelmodal')
    @include('admin.modals.edit_fuel')

    <script>
        let fuelChart = null;
        let currentPage = 1;
        const rowsPerPage = 10;
        let filteredData = [];
        let allData = [];
        let selectedTimeFilter = 'weekly';
        let selectedPlateNumber = null;

        document.addEventListener('DOMContentLoaded', function () {
            // Initialize allData with the current table rows
            const rows = Array.from(document.querySelectorAll('#fuelTableBody tr'));
            allData = rows.map(row => {
                const cells = row.cells;
                return {
                    id: row.querySelector('.edit-btn').getAttribute('onclick').match(/editFuel\((\d+)\)/)[1],
                    date: new Date(cells[0].textContent),
                    dateString: cells[0].textContent,
                    plate_no: cells[1].textContent,
                    total_km: parseFloat(cells[2].textContent.replace(',', '')),
                    avg_km_l: parseFloat(cells[3].textContent.replace(',', '')),
                    total_liters: parseFloat(cells[4].textContent.replace(',', '')),
                    fuel_price: parseFloat(cells[5].textContent.replace(',', '')),
                    total_cost: parseFloat(cells[6].textContent.replace(',', '')),
                    element: row
                };
            });

            // Initialize pagination
            initializePagination();
            
            let ctx = document.getElementById('fuelChart').getContext('2d');
            let fuelChartCanvas = document.getElementById('fuelChart'); 

            // Hide the graph (canvas) initially
            fuelChartCanvas.style.display = 'none';

            function fetchFuelData(plateNumber, timeFilter) {
                if (!plateNumber || plateNumber === "-- Plate Number --") {
                    fuelChartCanvas.style.display = 'none';
                    return;
                }

                // For "All Trucks", we'll aggregate the data from our existing dataset
                if (plateNumber === "all") {
                    const filtered = filterDataByTimeRange(allData, timeFilter);
                    const { data: aggregatedData, plateNumbers } = aggregateDataByDate(filtered);
                    updateFuelChart(
                        aggregatedData.map(item => item.dateString),
                        aggregatedData.map(item => item.total_km),
                        aggregatedData.map(item => item.total_liters),
                        plateNumbers
                    );
                    fuelChartCanvas.style.display = 'block';
                } else {
                    // For individual trucks, fetch from server
                    fetch(`/fuel-analytics?plate_number=${encodeURIComponent(plateNumber)}&time_filter=${timeFilter}`)
                        .then(response => response.json())
                        .then(data => {
                            if (!Array.isArray(data) || data.length === 0) {
                                updateFuelChart([], [], []);
                                fuelChartCanvas.style.display = 'none';
                                return;
                            }

                            let labels = data.map(item => item.date);
                            let kilometers = data.map(item => item.total_km);
                            let fuelUsed = data.map(item => item.total_liters);

                            updateFuelChart(labels, kilometers, fuelUsed);
                            fuelChartCanvas.style.display = 'block';
                        })
                        .catch(error => console.error('Error fetching fuel data:', error));
                }
            }

            function aggregateDataByDate(data) {
                const dateMap = {};
                const plateNumbersMap = {};
                
                data.forEach(item => {
                    const dateStr = item.dateString;
                    if (!dateMap[dateStr]) {
                        dateMap[dateStr] = {
                            dateString: dateStr,
                            total_km: 0,
                            total_liters: 0
                        };
                        plateNumbersMap[dateStr] = new Set();
                    }
                    dateMap[dateStr].total_km += item.total_km;
                    dateMap[dateStr].total_liters += item.total_liters;
                    plateNumbersMap[dateStr].add(item.plate_no);
                });
                
                // Convert sets to comma-separated strings
                const plateNumbers = Object.values(dateMap).map((item, index) => {
                    const dateStr = item.dateString;
                    return Array.from(plateNumbersMap[dateStr]).join(', ');
                });
                
                return {
                    data: Object.values(dateMap).sort((a, b) => new Date(a.dateString) - new Date(b.dateString)),
                    plateNumbers: plateNumbers
                };
            }

            function updateFuelChart(labels, kilometers, fuelUsed, plateNumbers = []) {
                if (fuelChart) {
                    fuelChart.destroy();
                }

                const isAllTrucks = selectedPlateNumber === "all";
                
                fuelChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Kilometers (KM)',
                                data: kilometers,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 2,
                                tension: 0.3,
                                yAxisID: 'y1',
                                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                                pointRadius: 5,
                                pointHoverRadius: 7
                            },
                            {
                                label: 'Fuel Consumption (L)',
                                data: fuelUsed,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 2,
                                tension: 0.3,
                                yAxisID: 'y2',
                                pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                                pointRadius: 5,
                                pointHoverRadius: 7
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    afterLabel: function(context) {
                                        if (isAllTrucks && plateNumbers[context.dataIndex]) {
                                            return `Plate: ${plateNumbers[context.dataIndex]}`;
                                        }
                                        return '';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y1: {
                                beginAtZero: true,
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Kilometers (KM)'
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
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

            function filterDataByTimeRange(data, timeFilter) {
                const now = new Date();
                let filtered = [...data];
                
                if (timeFilter === 'weekly') {
                    const oneWeekAgo = new Date(now);
                    oneWeekAgo.setDate(now.getDate() - 7);
                    filtered = filtered.filter(item => item.date >= oneWeekAgo);
                } else if (timeFilter === 'monthly') {
                    const oneMonthAgo = new Date(now);
                    oneMonthAgo.setMonth(now.getMonth() - 1);
                    filtered = filtered.filter(item => item.date >= oneMonthAgo);
                } else if (timeFilter === 'yearly') {
                    const oneYearAgo = new Date(now);
                    oneYearAgo.setFullYear(now.getFullYear() - 1);
                    filtered = filtered.filter(item => item.date >= oneYearAgo);
                }
                
                // Sort by date (newest first)
                return filtered.sort((a, b) => b.date - a.date);
            }

            // Initialize pagination with proper event listeners
            function initializePagination() {
                filteredData = [...allData];
                updateTable();
                
                // Add event listeners to pagination buttons
                document.getElementById('prevPage').addEventListener('click', goToPreviousPage);
                document.getElementById('nextPage').addEventListener('click', goToNextPage);
            }

            function goToPreviousPage() {
                if (currentPage > 1) {
                    currentPage--;
                    updateTable();
                }
            }

            function goToNextPage() {
                const totalPages = Math.ceil(filteredData.length / rowsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    updateTable();
                }
            }

            function updateTable() {
                const startIndex = (currentPage - 1) * rowsPerPage;
                const endIndex = startIndex + rowsPerPage;
                const paginatedData = filteredData.slice(startIndex, endIndex);
                
                // Hide all rows first
                document.querySelectorAll('#fuelTableBody tr').forEach(row => {
                    row.style.display = 'none';
                });
                
                // Show only the rows for the current page
                paginatedData.forEach(item => {
                    item.element.style.display = '';
                });
                
                updatePaginationControls();
            }

            function updatePaginationControls() {
                const totalPages = Math.ceil(filteredData.length / rowsPerPage);
                const startItem = (currentPage - 1) * rowsPerPage + 1;
                const endItem = Math.min(currentPage * rowsPerPage, filteredData.length);
                
                document.getElementById('pageInfo').textContent = `Showing ${startItem}-${endItem} of ${filteredData.length} records`;
                document.getElementById('prevPage').disabled = currentPage === 1;
                document.getElementById('nextPage').disabled = currentPage === totalPages || totalPages === 0;
            }

            // Handle plate number selection
            document.getElementById('plateNumberSelect').addEventListener('change', function () {
                selectedPlateNumber = this.value.trim();
                currentPage = 1;
                
                if (selectedPlateNumber === "-- Plate Number --") {
                    hideAllData();
                    fuelChartCanvas.style.display = 'none';
                    return;
                }

                let filteredByPlate = [];
                if (selectedPlateNumber === "all") {
                    filteredByPlate = [...allData];
                } else {
                    filteredByPlate = allData.filter(item => item.plate_no === selectedPlateNumber);
                }
                
                // Apply time filter
                filteredData = filterDataByTimeRange(filteredByPlate, selectedTimeFilter);
                
                if (filteredData.length > 0) {
                    document.getElementById('paginationControls').style.display = 'flex';
                    updateTable();
                } else {
                    document.getElementById('paginationControls').style.display = 'none';
                    hideAllData();
                }
                
                // Always fetch/update chart data when plate number changes
                fetchFuelData(selectedPlateNumber, selectedTimeFilter);
            });

            // Handle time filter selection
            document.querySelectorAll('.time-filter-btn').forEach(button => {
                button.addEventListener('click', function () {
                    if (!selectedPlateNumber || selectedPlateNumber === "-- Plate Number --") {
                        return;
                    }

                    selectedTimeFilter = this.getAttribute('data-filter');
                    document.querySelectorAll('.time-filter-btn').forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    currentPage = 1;
                    
                    // Re-filter the data with the new time range
                    let filteredByPlate = [];
                    if (selectedPlateNumber === "all") {
                        filteredByPlate = [...allData];
                    } else {
                        filteredByPlate = allData.filter(item => item.plate_no === selectedPlateNumber);
                    }
                    
                    filteredData = filterDataByTimeRange(filteredByPlate, selectedTimeFilter);
                    
                    if (filteredData.length > 0) {
                        document.getElementById('paginationControls').style.display = 'flex';
                        updateTable();
                    } else {
                        document.getElementById('paginationControls').style.display = 'none';
                        hideAllData();
                    }
                    
                    // Update chart with new time filter
                    fetchFuelData(selectedPlateNumber, selectedTimeFilter);
                });
            });
        });

        function hideAllData() {
            allData.forEach(item => {
                item.element.style.display = 'none';
            });
            document.getElementById('paginationControls').style.display = 'none';
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    closeFuelModal();
                    document.getElementById('fuelForm').reset();
                    setTimeout(() => window.location.reload(), 2000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error adding fuel consumption.',
                    });
                    console.log(data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while adding fuel consumption.',
                });
            });
        }

        function editFuel(id) {
            fetch(`/admin/fuel/edit/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.data) {
                        const fuelData = data.data;
                        const formattedDate = new Date(fuelData.date).toISOString().split('T')[0];
                        
                        openUpdateFuelModal({
                            id: fuelData.id,
                            date: formattedDate,
                            plateNo: fuelData.plate_no,
                            totalKm: fuelData.total_km,
                            avgKmL: fuelData.avg_km_l,
                            fuelPrice: fuelData.fuel_price,
                            totalLiters: fuelData.total_liters,
                            totalCost: fuelData.total_cost
                        });
                    } else {
                        throw new Error('Invalid data format from server');
                    }
                })
                .catch(error => {
                    console.error('Error fetching fuel data:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch fuel data: ' + error.message,
                    });
                });
        }

        function openUpdateFuelModal(consumption) {
            document.getElementById('updateId').value = consumption.id;
            document.getElementById('updateDate').value = consumption.date;
            document.getElementById('updatePlateNo').value = consumption.plateNo;
            document.getElementById('updateTotalKm').value = consumption.totalKm;
            document.getElementById('updateAvgKmL').value = consumption.avgKmL;
            document.getElementById('updateFuelPrice').value = consumption.fuelPrice;
            document.getElementById('updateTotalLiters').value = consumption.totalLiters;
            document.getElementById('updateTotalCost').value = consumption.totalCost;
            
            document.getElementById('updateFuelModal').style.display = 'block';
        }

        function confirmArchive(id) {
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
                    archiveFuel(id);
                }
            });
        }

        function archiveFuel(id) {
            fetch(`/admin/fuel/archive/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (response.ok) {
                    Swal.fire(
                        'Archived!',
                        'The fuel consumption record has been archived.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'There was an error archiving the fuel consumption record.',
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'There was an error archiving the fuel consumption record.',
                    'error'
                );
            });
        }

        function exportToExcel() {
            // Get the table element
            const table = document.getElementById('fuelTable');
            
            // Clone the table to avoid modifying the original
            const tableClone = table.cloneNode(true);
            
            // Remove the Actions column from the clone
            const actionHeaderIndex = 7; // Actions is the 8th column (0-based index 7)
            
            // Remove actions column from header
            const headerRow = tableClone.querySelector('thead tr');
            if (headerRow && headerRow.cells.length > actionHeaderIndex) {
                headerRow.deleteCell(actionHeaderIndex);
            }
            
            // Remove actions column from each data row
            const dataRows = tableClone.querySelectorAll('tbody tr');
            dataRows.forEach(row => {
                if (row.cells.length > actionHeaderIndex) {
                    row.deleteCell(actionHeaderIndex);
                }
            });
            
            // Convert the table to a worksheet
            const worksheet = XLSX.utils.table_to_sheet(tableClone);
            
            // Create a new workbook
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Fuel Data");
            
            // Generate filename with current date and time
            const now = new Date();
            const formattedDate = now.toISOString().slice(0, 10);
            const formattedTime = now.toTimeString().slice(0, 8).replace(/:/g, '-');
            const filename = `Fuel_Data_${formattedDate}_${formattedTime}.xlsx`;
            
            // Export the workbook
            XLSX.writeFile(workbook, filename);
            
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Export Successful',
                text: `Fuel data has been exported to ${filename}`,
                timer: 3000,
                showConfirmButton: false
            });
        }
    </script>
</body>
</html>