<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>
    <title>Cargo Management</title>
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
            padding: 30px;
            flex-grow: 1;
        }

        .content-header {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }

        .content-header h2 {
            color: #2f4156;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .trip-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .trip-table th {
            background-color: #2f4156;
            color: #fff;
            padding: 12px 15px;
            text-align: left;
            font-weight: 500;
            position: sticky;
            top: 0;
        }

        .trip-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #dadada;
            vertical-align: middle;
        }

        .trip-table tr:last-child td {
            border-bottom: none;
        }

        .trip-table tr:hover td {
            background-color: rgba(0, 74, 173, 0.05);
        }

        .actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            align-items: center;
        }

        .actions button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.2s;
            padding: 5px;
        }

        .actions .edit-btn {
            color: #004aad;
        }

        .actions .edit-btn:hover {
            transform: scale(1.1);
            color: #003d82;
        }

        .actions .archive-btn {
            color: #dc3545;
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
        }

        .truck-select {
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #dadada;
            background-color: #2f4156;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .date-filter {
            display: flex;
            gap: 10px;
        }

        .date-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            background-color: #dadada;
            color: #333;
            font-size: 16px;
            cursor: pointer;
        }

        .date-btn.active, .date-btn:hover {
            background-color: #004aad;
            color: #fff;
        }

        .export-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 15px;
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

        /* Table scroll container */
        .table-scroll-container {
            max-height: 500px;
            overflow-y: auto;
            margin-top: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }

        /* Pagination controls */
        .pagination-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding: 10px 0;
            display: none; /* Initially hidden */
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
            background-color: #2f4156;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
        }

        .page-btn:hover {
            background-color: #004aad;
        }

        .page-btn:disabled {
            background-color: #dadada;
            color: #6c757d;
            cursor: not-allowed;
        }

        /* Modal Styles */
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
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
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
        }

        .close:hover {
            color: #333;
        }

        .modal-content h2 {
            margin-bottom: 20px;
            color: #2f4156;
            text-align: center;
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .modal-content label {
            font-weight: bold;
            color: #2f4156;
        }

        .modal-content select,
        .modal-content input {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
        }

        .modal-content button[type="submit"] {
            background-color: #004aad;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        /* Custom scrollbar for table and modal */
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

            .modal-content {
                width: 95%;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>Sidebar Menu</h2>
        <ul>
            <x-managernavbar />
        </ul>
    </div>

    <div class="content">
        <div class="content-header">
            <h2>View and Update Trip Records</h2>
        </div>
        
        <div class="table-container">
            <form method="GET" action="{{ route('manager.managetrip') }}" id="filterForm">
                <div class="filter-container">
                    <select name="plate_no" class="truck-select" id="plateSelect">
                        <option disabled selected>-- Plate Number --</option>
                        <option value="">All Trucks</option>
                        @foreach(['UVP 353', 'TQE 262', 'NBB 7212', 'APA 3309', 'WIE 914'] as $plate)
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
                                    <td class="actions">
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

                                        <form action="{{ route('trip.archive', $cargo->id) }}" method="POST" class="action-form">
                                            @csrf
                                            <button type="submit" class="archive-btn">
                                                <i class="fas fa-archive"></i>
                                            </button>
                                        </form>
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
                        @foreach(['UVP 353', 'TQE 262', 'NBB 7212', 'APA 3309', 'WIE 914'] as $plate)
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
            
            // Initialize pagination if there are filters
            function initializePagination() {
                const rowsPerPage = 10;
                const tableBody = document.getElementById('tableBody');
                const rows = Array.from(tableBody.querySelectorAll('tr'));
                const totalRows = rows.length;
                const pageInfo = document.getElementById('pageInfo');
                const prevBtn = document.getElementById('prevPage');
                const nextBtn = document.getElementById('nextPage');
                
                let currentPage = 1;
                const totalPages = Math.ceil(totalRows / rowsPerPage);
                
                function updateTable() {
                    // Hide all rows
                    rows.forEach(row => row.style.display = 'none');
                    
                    // Calculate start and end index
                    const start = (currentPage - 1) * rowsPerPage;
                    const end = start + rowsPerPage;
                    
                    // Show rows for current page
                    for (let i = start; i < end && i < totalRows; i++) {
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
    </script>
</body>
</html>