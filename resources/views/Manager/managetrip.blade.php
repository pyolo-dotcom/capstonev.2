<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cargo Management</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('public/images/logo.jpg') }}" type="image/jpg">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins';
    }
    
    body {
        display: flex;
        min-height: 100vh;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }

    .sidebar {
        width: 250px;
        background: linear-gradient(145deg, #343a40, #2c3333);
        color: white;
        padding: 20px 0;
        position: fixed;
        height: 100%;
        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
    }

    .content {
        margin-left: 250px;
        padding: 25px;
        flex-grow: 1;
        background-color: #ffffff;
        min-height: 100vh;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        box-shadow: -6px 0 20px rgba(0, 0, 0, 0.08);
    }

    .content-header {
        background: linear-gradient(90deg, #ffffff, #f8f9fa);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
    }

    .content-header h2 {
        color: #1f1a5c;
        font-size: 1.7rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .content-header h2 i {
        color: #1d4ed8;
    }

    .table-container {
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }

    .trip-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .trip-table th {
        background-color: #1f1a5c;
        color: #fff;
        padding: 15px;
        text-align: left;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: sticky;
        top: 0;
    }

    .trip-table td {
        padding: 15px;
        border-bottom: 1px solid #e1e5e9;
        vertical-align: middle;
        color: #495057;
    }

    .trip-table tr:hover td {
        background-color: rgba(31, 26, 92, 0.08);
        transform: translateY(-1px);
    }

    .actions {
        display: flex;
        gap: 10px;
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
        padding: 0 5px;
        margin: 0;
    }

    .trip-table td:last-child {
        padding: 0;
        vertical-align: middle;
    }

    .actions button {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 18px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 44px;
        padding: 5px;
        border-radius: 5px;
    }

    .actions form {
        margin: 0;
        padding: 0;
        display: inline-flex;
        height: 100%;
    }

    .actions .edit-btn {
        color: #004aad;
        background: none;
    }

    .actions .edit-btn:hover {
        transform: scale(1.1);
        color: #003d82;
    }

    .actions .archive-btn {
        color: #dc3545;
        background: none;
    }

    .actions .archive-btn:hover {
        transform: scale(1.1);
        color: #b02a37;
    }

    .filter-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
        padding: 10px 0;
    }

    .truck-select {
        padding: 10px 15px;
        border: 2px solid #e1e5e9;
        border-radius: 10px;
        font-size: 16px;
        color: #495057;
        background-color: #fff;
        width: 200px;
        transition: border-color 0.3s ease;
    }

    .truck-select:focus {
        border-color: #1f1a5c;
        outline: none;
    }

    .date-filter {
        display: flex;
        gap: 10px;
    }

    .date-btn {
        padding: 10px 15px;
        border: 2px solid #e1e5e9;
        border-radius: 10px;
        background-color: #fff;
        color: #495057;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .date-btn.active, 
    .date-btn:hover {
        background: linear-gradient(90deg, #1f1a5c, #2c3e50);
        color: #fff;
        border-color: #1f1a5c;
    }

    .export-btn {
        background: linear-gradient(90deg, #1f1a5c, #2c3e50);
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 10px;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .export-btn:hover {
        background: linear-gradient(90deg, #161245, #233140);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .no-data {
        text-align: center;
        padding: 30px;
        color: #6c757d;
        font-style: italic;
    }

    .initial-message {
        text-align: center;
        padding: 30px;
        color: #6c757d;
        font-style: italic;
        font-size: 18px;
    }

    .table-scroll-container {
        max-height: 500px;
        overflow-y: auto;
        margin-top: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
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
        padding: 10px 18px;
        background: #1f1a5c;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .page-btn:hover {
        background: #161245;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .page-btn:disabled {
        background-color: #e1e5e9;
        color: #6c757d;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }

    .search-container {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 15px;
    }

    .search-bar {
        position: relative;
        width: 300px;
    }

    .search-bar input {
        width: 100%;
        padding: 12px 15px 12px 40px;
        border: 2px solid transparent;
        border-radius: 25px;
        font-size: 14px;
        background: linear-gradient(white, #f8f9fa);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .search-bar input:focus {
        border-color: #1f1a5c;
        box-shadow: 0 0 8px rgba(31, 26, 92, 0.2);
    }

    .search-bar input::placeholder {
        color: #6c757d;
        font-style: italic;
    }

    .search-bar i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        padding: 30px;
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        position: relative;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }

    .modal-header {
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
        margin-bottom: 15px;
    }

    .modal-body {
        overflow-y: auto;
        flex-grow: 1;
        padding-right: 10px;
    }

    .modal-footer {
        padding-top: 15px;
        border-top: 1px solid #eee;
        margin-top: 15px;
    }

    .close {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 24px;
        font-weight: bold;
        color: #aaa;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .close:hover {
        color: #333;
    }

    .modal-content h2 {
        margin-bottom: 20px;
        color: #1f1a5c;
        text-align: center;
    }

    .modal-content form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .modal-content label {
        font-weight: 500;
        color: #1f1a5c;
    }

    .modal-content select,
    .modal-content input {
        padding: 12px 15px;
        border: 2px solid #e1e5e9;
        border-radius: 6px;
        font-size: 16px;
        width: 100%;
        transition: border-color 0.3s ease;
    }

    .modal-content select:focus,
    .modal-content input:focus {
        border-color: #1f1a5c;
        outline: none;
    }

    .modal-content button[type="submit"] {
        background: linear-gradient(90deg, #1f1a5c, #2c3e50);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 6px;
        cursor: pointer;
        margin-top: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .modal-content button[type="submit"]:hover {
        background: linear-gradient(90deg, #161245, #233140);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .table-scroll-container::-webkit-scrollbar,
    .modal-body::-webkit-scrollbar {
        width: 8px;
    }

    .table-scroll-container::-webkit-scrollbar-track,
    .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .table-scroll-container::-webkit-scrollbar-thumb,
    .modal-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .table-scroll-container::-webkit-scrollbar-thumb:hover,
    .modal-body::-webkit-scrollbar-thumb:hover {
        background: #555;
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

        .search-bar {
            width: 100%;
        }

        .modal-content {
            width: 95%;
            padding: 20px;
        }
    }
</style>
</head>

<body>
    <div class="sidebar">
        <ul>
            <x-managernavbar />
        </ul>
    </div>

    <div class="content">
        <div class="content-header">
            <h2><i class="fas fa-route me-2"></i>View and Update Trip Records</h2>
        </div>
        
        <div class="table-container">
            <form method="GET" action="{{ route('manager.managetrip') }}" id="filterForm">
                <div class="filter-container">
                    <select name="plate_no" class="truck-select" id="plateSelect">
                        <option value="All Trucks">All Trucks</option>
                        <option value="" disabled>-- Plate Number --</option>
                        @foreach($plateNumbers as $plate)
                            <option value="{{ $plate }}" {{ request('plate_no') == $plate ? 'selected' : '' }}>{{ $plate }}</option>
                        @endforeach
                    </select>

                    <div class="date-filter">
                        @foreach(['weekly' => 'Weekly', 'monthly' => 'Monthly', 'annually' => 'Annually'] as $value => $label)
                            <button type="submit" name="filter" value="{{ $value }}" 
                                    class="date-btn {{ request('filter') == $value ? 'active' : '' }}" id="{{ $value }}Btn">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </form>

            <!-- Search Bar -->
            <div class="search-container">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search records...">
                </div>
            </div>

            <button class="export-btn" onclick="exportToExcel()" id="exportBtn" style="display: none;">
                <i class="fas fa-file-excel"></i> Export to Excel
            </button>

            <div class="table-scroll-container" id="tableScrollContainer" style="display: none;">
                <table class="trip-table" id="cargoTable">
                    <thead>
                        <tr>
                            <th>Plate No.</th>
                            <th>Date</th>
                            <th>EIR No.</th>
                            <th>Container Van No.</th>
                            <th>Size</th>
                            <th>Shipper/Consignee</th>
                            <th>Voyage Vessel</th>
                            <th>Voyage No.</th>
                            <th>Pickup Location</th>
                            <th>Delivery Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @if(request()->has('plate_no') || request()->has('filter'))
                            @forelse($cargos as $cargo)
                                <tr>
                                    <td>{{ $cargo->plate_no }}</td>
                                    <td>{{ $cargo->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $cargo->eir_no }}</td>
                                    <td>{{ $cargo->container_van_no }}</td>
                                    <td>{{ $cargo->size }}</td>
                                    <td>{{ $cargo->shipper_consignee }}</td>
                                    <td>{{ $cargo->voyage_vessel }}</td>
                                    <td>{{ $cargo->voyage_no }}</td>
                                    <td>{{ $cargo->pickup_location }}</td>
                                    <td>{{ $cargo->delivery_location }}</td>
                                    <td>
                                        <div class="actions">
                                            <button class="edit-btn" onclick="openTripModal(
                                                '{{ $cargo->id }}',
                                                '{{ $cargo->plate_no }}',
                                                '{{ $cargo->eir_no }}',
                                                '{{ $cargo->container_van_no }}',
                                                '{{ $cargo->size }}',
                                                '{{ $cargo->shipper_consignee }}',
                                                '{{ $cargo->voyage_vessel }}',
                                                '{{ $cargo->voyage_no }}',
                                                '{{ $cargo->pickup_location }}',
                                                '{{ $cargo->delivery_location }}'
                                            )">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        
                                            <form action="{{ route('trip.archive', $cargo->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="archive-btn">
                                                    <i class="fas fa-archive"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="no-data">
                                        No cargo records found for the selected filter
                                    </td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>    
                </table>
            </div>

            <!-- Initial message when no filters are selected -->
            <div id="initialMessage" class="initial-message">
                Please select a plate number or date filter to display cargo records
            </div>

            <!-- Pagination Controls -->
            <div class="pagination-controls" id="paginationControls">
                <div class="page-info" id="pageInfo">Showing 1-10 of 0 records</div>
                <div class="page-buttons">
                    <button class="page-btn" id="prevPage" disabled>Previous</button>
                    <button class="page-btn" id="nextPage" disabled>Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Trip Modal -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-header">
                <h2>Update Trip</h2>
            </div>
            <div class="modal-body">
                <form id="updateTripForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="trip_id" name="id">

                    <label for="update_plate_no">Plate No.:</label>
                    <select id="update_plate_no" name="plate_no" required>
                        <option disabled value="">-- Plate Number --</option>
                        @foreach(['UVP353', 'TQE262', 'NBB7212', 'APA3309', 'WIE914'] as $plate)
                            <option value="{{ $plate }}">{{ $plate }}</option>
                        @endforeach
                    </select>

                    <label for="update_eir_no">EIR No.:</label>
                    <input type="text" id="update_eir_no" name="eir_no" required>

                    <label for="update_container_van_no">Container Van No.:</label>
                    <input type="text" id="update_container_van_no" name="container_van_no" required>

                    <label for="update_size">Size:</label>
                    <input type="text" id="update_size" name="size" required>

                    <label for="update_shipper_consignee">Shipper/Consignee:</label>
                    <input type="text" id="update_shipper_consignee" name="shipper_consignee" required>

                    <label for="update_voyage_vessel">Voyage Vessel:</label>
                    <input type="text" id="update_voyage_vessel" name="voyage_vessel" required>

                    <label for="update_voyage_no">Voyage No.:</label>
                    <input type="text" id="update_voyage_no" name="voyage_no" required>

                    <label for="update_pickup_location">Pickup Location:</label>
                    <input type="text" id="update_pickup_location" name="pickup_location" required>

                    <label for="update_delivery_location">Delivery Location:</label>
                    <input type="text" id="update_delivery_location" name="delivery_location" required>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="updateTripForm" class="submit-btn">Update</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            const plateSelect = document.getElementById('plateSelect');
            const dateBtns = document.querySelectorAll('.date-btn');
            const tableContainer = document.getElementById('tableScrollContainer');
            const initialMessage = document.getElementById('initialMessage');
            const exportBtn = document.getElementById('exportBtn');
            const paginationControls = document.getElementById('paginationControls');
            const searchInput = document.getElementById('searchInput');
            
            // Check if filters are already applied (on page reload)
            const hasFilters = window.location.search.includes('plate_no=') || 
                              window.location.search.includes('filter=');
            
            if (hasFilters) {
                initialMessage.style.display = 'none';
                tableContainer.style.display = 'block';
                exportBtn.style.display = 'inline-flex';
                paginationControls.style.display = 'flex';
                initializePagination();
            }
            
            // Event listeners for filter changes
            plateSelect.addEventListener('change', function() {
                filterForm.submit();
            });
            
            dateBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    filterForm.submit();
                });
            });

            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('#tableBody tr');
                
                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let shouldShow = false;
                    
                    // Check each cell (except the last one which contains action buttons)
                    for (let i = 0; i < cells.length - 1; i++) {
                        if (cells[i].textContent.toLowerCase().includes(searchTerm)) {
                            shouldShow = true;
                            break;
                        }
                    }
                    
                    row.style.display = shouldShow ? '' : 'none';
                });

                // Update pagination after search
                if (paginationControls.style.display === 'flex') {
                    initializePagination();
                }
            });
            
            // Initialize pagination if there are filters
            function initializePagination() {
                const rowsPerPage = 10;
                const tableBody = document.getElementById('tableBody');
                // Only select visible rows for pagination
                const rows = Array.from(tableBody.querySelectorAll('tr')).filter(row => 
                    row.style.display !== 'none'
                );
                const totalRows = rows.length;
                const pageInfo = document.getElementById('pageInfo');
                const prevBtn = document.getElementById('prevPage');
                const nextBtn = document.getElementById('nextPage');
                
                let currentPage = 1;
                const totalPages = Math.ceil(totalRows / rowsPerPage);
                
                function updateTable() {
                    // Hide all rows first
                    document.querySelectorAll('#tableBody tr').forEach(row => {
                        row.style.display = 'none';
                    });
                    
                    // Calculate start and end index
                    const start = (currentPage - 1) * rowsPerPage;
                    const end = start + rowsPerPage;
                    
                    // Show rows for current page (only those that are not hidden by search)
                    for (let i = start; i < end && i < rows.length; i++) {
                        if (rows[i]) rows[i].style.display = '';
                    }
                    
                    // Update page info
                    const startRow = start + 1;
                    const endRow = Math.min(end, totalRows);
                    pageInfo.textContent = `Showing ${startRow}-${endRow} of ${totalRows} records`;
                    
                    // Update button states
                    prevBtn.disabled = currentPage === 1;
                    nextBtn.disabled = currentPage === totalPages;
                }
                
                // Initial table update
                updateTable();
                
                // Event listeners for pagination buttons
                prevBtn.addEventListener('click', function() {
                    if (currentPage > 1) {
                        currentPage--;
                        updateTable();
                        document.querySelector('.table-scroll-container').scrollTop = 0;
                    }
                });
                
                nextBtn.addEventListener('click', function() {
                    if (currentPage < totalPages) {
                        currentPage++;
                        updateTable();
                        document.querySelector('.table-scroll-container').scrollTop = 0;
                    }
                });
            }
        });

        function exportToExcel() {
            const table = document.getElementById('cargoTable');
            const clone = table.cloneNode(true);
            
            // Remove Actions column
            Array.from(clone.querySelectorAll('tr')).forEach(row => {
                if (row.cells.length > 0) row.deleteCell(row.cells.length - 1);
            });
            
            const wb = XLSX.utils.table_to_book(clone, {sheet: "Cargo Data"});
            XLSX.writeFile(wb, `Cargo_Data_${new Date().toISOString().slice(0, 10)}.xlsx`);
        }

        // Modal functions
        function openTripModal(id, plateNo, eirNo, containerVanNo, size, shipperConsignee, voyageVessel, voyageNo, pickupLocation, deliveryLocation) {
            document.getElementById('trip_id').value = id;
            
            // Set plate number
            const plateSelect = document.getElementById('update_plate_no');
            Array.from(plateSelect.options).forEach(option => {
                option.selected = option.value === plateNo;
            });
            
            // Set other fields
            document.getElementById('update_eir_no').value = eirNo;
            document.getElementById('update_container_van_no').value = containerVanNo;
            document.getElementById('update_size').value = size;
            document.getElementById('update_shipper_consignee').value = shipperConsignee;
            document.getElementById('update_voyage_vessel').value = voyageVessel;
            document.getElementById('update_voyage_no').value = voyageNo;
            document.getElementById('update_pickup_location').value = pickupLocation;
            document.getElementById('update_delivery_location').value = deliveryLocation;
            
            document.getElementById('updateModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('updateModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target === document.getElementById('updateModal')) {
                closeModal();
            }
        }

        // Form submission
        document.getElementById('updateTripForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const tripId = document.getElementById('trip_id').value;
            const formData = new FormData(this);
            
            fetch(`/manager/update-trip/${tripId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                    'X-HTTP-Method-Override': 'PUT'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success'
                    }).then(() => {
                        closeModal();
                        window.location.reload();
                    });
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'An error occurred while updating the trip.',
                    icon: 'error'
                });
            });
        });

        // Archive confirmation with SweetAlert
        document.querySelectorAll('.action-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Archive Trip Record',
                    text: 'Are you sure you want to archive this trip record?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, archive it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>