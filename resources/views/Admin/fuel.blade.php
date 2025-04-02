<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Fuel Management</title>
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            background-color: #f5f5f5;
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
            width: calc(100% - 270px);
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
        .filter-section {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        #plateNumberSelect {
            padding: 8px 12px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ddd;
            min-width: 150px;
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
        .add-consumption-btn {
            display: flex;
            align-items: center;
            margin: 7px -7px;
            padding: 8px 16px;
            background-color: #3498DB;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: 0.3s;
        }
        .add-consumption-btn:hover {
            background-color: #2980B9;
        }
        .add-consumption-btn .plus-circle {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 20px;
            height: 20px;
            margin-right: 8px;
            background-color: white;
            color: #3498DB;
            border-radius: 50%;
            font-size: 14px;
            font-weight: bold;
        }
        #fuelChart {
            width: 100%;
            max-height: 1000vh;
            height: 68vh;
        }
        
        /* Improved Table Container */
        .table-container {
            max-height: 500px;
            overflow-y: auto;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            width: 100%;
        }
        
        /* Improved Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }
        
        th, td {
            padding: 12px 15px;
            border: 1px solid #eee;
            text-align: left;
            word-wrap: break-word;
            vertical-align: middle;
        }
        
        th {
            background-color: #f8f9fa;
            position: sticky;
            top: 0;
            font-weight: 600;
            color: #333;
        }
        
        /* Column Widths */
        th:nth-child(1), td:nth-child(1) { min-width: 120px; } /* Date */
        th:nth-child(2), td:nth-child(2) { min-width: 100px; } /* Plate No */
        th:nth-child(3), td:nth-child(3) { min-width: 90px; text-align: right; }  /* Total KM */
        th:nth-child(4), td:nth-child(4) { min-width: 90px; text-align: right; }  /* Avg KM/L */
        th:nth-child(5), td:nth-child(5) { min-width: 100px; text-align: right; }  /* Total Liters */
        th:nth-child(6), td:nth-child(6) { min-width: 180px; } /* Actions */
        
        /* Improved Actions Cell */
        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: nowrap;
            justify-content: flex-start;
        }
        
        .actions button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            white-space: nowrap;
            min-width: 70px;
            transition: all 0.2s ease;
        }
        
        .actions button.edit {
            background-color: #4CAF50;
            color: white;
        }
        
        .actions button.edit:hover {
            background-color: #3e8e41;
        }
        
        .actions button.archive {
            background-color: #f44336;
            color: white;
        }
        
        .actions button.archive:hover {
            background-color: #d32f2f;
        }
        
        .actions form {
            margin: 0;
            display: inline;
        }
        
        /* Row hover effect */
        tbody tr:hover {
            background-color: #f9f9f9;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-top: 1px solid #eee;
        }
        
        .pagination button {
            padding: 6px 12px;
            margin: 0 5px;
            cursor: pointer;
            border: 1px solid #ddd;
            background: #f8f8f8;
            border-radius: 4px;
            transition: 0.3s;
        }
        
        .pagination button:hover {
            background-color: #e9e9e9;
        }
        
        .pagination button.active {
            background: #3498DB;
            color: white;
            border-color: #3498DB;
        }
        
        .pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .pagination-info {
            margin: 0 15px;
            font-size: 14px;
        }
        
        /* No Data Message */
        .no-data {
            text-align: center;
            padding: 30px;
            font-style: italic;
            color: #777;
            background-color: #f9f9f9;
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

        <div class="table-container">
            <table id="fuelTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Plate No.</th>
                        <th>Total KM</th>
                        <th>Avg KM/L</th>
                        <th>Total Liters</th>
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
                        <td class="actions">
                            <button class="edit" onclick="editFuel({{ $data->id }})">Edit</button>
                            <form id="archiveForm{{ $data->id }}" action="{{ route('admin.fuel.archive', $data->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="archive" onclick="confirmArchive({{ $data->id }})">Archive</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="noDataMessage" class="no-data">Please select a plate number to view data</div>
        </div>

        <div class="pagination" id="paginationControls" style="display: none;">
            <button id="prevPage">Previous</button>
            <span id="pageInfo" class="pagination-info">Page 1 of 1</span>
            <button id="nextPage">Next</button>
        </div>

        <div class="chart-container">
            <canvas id="fuelChart"></canvas>
        </div>
    </div>

    @include('Admin.modals.fuelmodal')
    @include('Admin.modals.edit_fuel')

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
                    id: row.querySelector('.edit').getAttribute('onclick').match(/editFuel\((\d+)\)/)[1],
                    date: new Date(cells[0].textContent),
                    dateString: cells[0].textContent,
                    plate_no: cells[1].textContent,
                    total_km: parseFloat(cells[2].textContent.replace(',', '')),
                    avg_km_l: parseFloat(cells[3].textContent.replace(',', '')),
                    total_liters: parseFloat(cells[4].textContent.replace(',', '')),
                    element: row
                };
            });

            // Hide all data initially
            hideAllData();
            
            // Set up event listeners for pagination
            document.getElementById('prevPage').addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    updateTable();
                }
            });
            
            document.getElementById('nextPage').addEventListener('click', () => {
                const totalPages = Math.ceil(filteredData.length / rowsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    updateTable();
                }
            });

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
                    const aggregatedData = aggregateDataByDate(filtered);
                    updateFuelChart(
                        aggregatedData.map(item => item.dateString),
                        aggregatedData.map(item => item.total_km),
                        aggregatedData.map(item => item.total_liters)
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
                
                data.forEach(item => {
                    const dateStr = item.dateString;
                    if (!dateMap[dateStr]) {
                        dateMap[dateStr] = {
                            dateString: dateStr,
                            total_km: 0,
                            total_liters: 0
                        };
                    }
                    dateMap[dateStr].total_km += item.total_km;
                    dateMap[dateStr].total_liters += item.total_liters;
                });
                
                return Object.values(dateMap).sort((a, b) => new Date(a.dateString) - new Date(b.dateString));
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
                    document.getElementById('noDataMessage').style.display = 'none';
                    document.getElementById('paginationControls').style.display = 'flex';
                    updateTable();
                } else {
                    document.getElementById('noDataMessage').textContent = 'No data available for the selected filter';
                    document.getElementById('noDataMessage').style.display = 'block';
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
                    
                    // Re-filter the data with the new time range
                    let filteredByPlate = [];
                    if (selectedPlateNumber === "all") {
                        filteredByPlate = [...allData];
                    } else {
                        filteredByPlate = allData.filter(item => item.plate_no === selectedPlateNumber);
                    }
                    
                    filteredData = filterDataByTimeRange(filteredByPlate, selectedTimeFilter);
                    
                    if (filteredData.length > 0) {
                        document.getElementById('noDataMessage').style.display = 'none';
                        document.getElementById('paginationControls').style.display = 'flex';
                        updateTable();
                    } else {
                        document.getElementById('noDataMessage').textContent = 'No data available for the selected filter';
                        document.getElementById('noDataMessage').style.display = 'block';
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
            document.getElementById('noDataMessage').style.display = 'block';
            document.getElementById('paginationControls').style.display = 'none';
        }

        function updateTable() {
            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;
            const paginatedData = filteredData.slice(startIndex, endIndex);
            
            // Hide all rows first
            allData.forEach(item => {
                item.element.style.display = 'none';
            });
            
            // Show only the rows for the current page
            paginatedData.forEach(item => {
                item.element.style.display = '';
            });
            
            updatePagination();
        }
        
        function updatePagination() {
            const totalPages = Math.ceil(filteredData.length / rowsPerPage);
            document.getElementById('pageInfo').textContent = `Page ${currentPage} of ${totalPages}`;
            document.getElementById('prevPage').disabled = currentPage === 1;
            document.getElementById('nextPage').disabled = currentPage === totalPages || totalPages === 0;
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
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.getElementById('editFuelId').value = data.id;
                        document.getElementById('editDate').value = data.date;
                        document.getElementById('editPlateNo').value = data.plate_no;
                        document.getElementById('editTotalKm').value = data.total_km;
                        document.getElementById('editAvgKmL').value = data.avg_km_l;

                        let modal = document.getElementById('editFuelModal');
                        modal.style.display = "block";
                    } else {
                        console.error("No data found for ID:", id);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No data found for this record.',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching fuel data:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch fuel data.',
                    });
                });
        }

        window.onclick = function(event) {
            let modal = document.getElementById('editFuelModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
            
            let fuelModal = document.getElementById('fuelModal');
            if (event.target == fuelModal) {
                fuelModal.style.display = "none";
            }
        };

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
                    document.getElementById('archiveForm' + id).submit();
                }
            });
        }
    </script>
</body>
</html>