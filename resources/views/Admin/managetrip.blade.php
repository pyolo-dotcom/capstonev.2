<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cargo Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="{{ asset('/public/images/logo.jpg') }}" type="image/jpg">
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
    padding: 20px;
    flex-grow: 1;
    transition: all 0.3s;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    /* This should prevent anything from escaping its horizontal bounds */
    overflow-x: hidden;
}
.table-scroll-container {
    overflow-x: auto!important;
    -webkit-overflow-scrolling: touch; /* Improves scrolling on iOS devices */
    width: 100%; /* Ensures the container takes full available width */
    margin-top: 20px; /* Add some space above the table if needed */
    margin-bottom: 20px; /* Add some space below the table if needed */
}
        

        .content-header {
            background:none!important;
            border-radius: none!important;
            margin-bottom: 0;
        }

        .content-header h2 {
            color: #1f1a5c;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }
.header-controls {
    display: flex;
    justify-content: space-between; /* Pushes items to opposite ends */
    align-items: center; /* Vertically aligns items in the middle */
    flex-wrap: wrap; /* Allows items to wrap on smaller screens */
    gap: 20px; /* Adds space between items when they wrap */
    margin-bottom: 20px; /* Add some space below this header section */
}

/* Ensure the h2 inside header-controls doesn't have conflicting margins if any */
.header-controls h2 {
    margin: 0; /* Remove default margin that might push it around */
    white-space: nowrap; /* Prevent the title from wrapping prematurely */
    flex-shrink: 0; /* Prevent the title from shrinking if space is tight */
}

       .table-container {
    width: 100%; /* Use 100% without !important unless absolutely necessary */
    margin-top: 0;
    background-color: none!important;
    padding: 20px; /* This padding reduces the available width for its children */
  
    border-top: none;
}


        .trip-table {
       
    width: 100%!important;
    border-collapse: collapse;
     min-width: 800px!important
    min-width: fit-content; /* Alternative: Let table be as wide as its content */
}


        .trip-table th {
          background-color: #f8f9fa;
    color: #6c757d;
    padding: 12px 15px;
    text-align: left;
    font-weight: 600;
    position: sticky;
    top: 0;
    font-size: 12px;          

    text-transform: uppercase;
    letter-spacing: 0.1px;
    border-bottom: 1px solid #e1e5e9;
        }

        .trip-table td {
              padding: 10px 15px;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
    color: #495057;
    font-size: 12px;

        }

        .trip-table tr:hover td {
            background-color: rgba(31, 26, 92, 0.05);
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
            font-size: 16px;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
        }

        .actions form {
            margin: 0;
            padding: 0;
            display: inline-flex;
            height: 100%;
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

 
        /* Original .filter-container - keeping for reference but it's not directly used for the main layout now */
        .filter-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        /* Original .truck-select from user's original CSS - modified for visual to match 'Show' dropdown in image */
        .truck-select {
            padding: 8px 15px;
            border: 1px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            color: #495057;
            background-color: #fff;
            width: auto; /* Changed to auto to fit content naturally */
            min-width: 120px; /* Ensures a minimum width */
            appearance: none; /* Removes default dropdown arrow */
            -webkit-appearance: none;
            -moz-appearance: none;
            /* Custom arrow for dropdown - same as before */
          
            background-position: right 10px center;
            background-size: 10px;
            cursor: pointer;
        }

       

        .filter-top-row {
    display: flex
;
    
    align-items: flex-end;
    margin-bottom: 0;
    flex-wrap: wrap;
    gap: 15px;        }

        .filter-bottom-row {
            justify-content: space-between; /* Align Filter dropdown to left, Export button to right */
        }

        /* Existing Shared spacing utility (no change) */
        .spaced-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Existing Search Bar - remains largely the same, but HTML position changed */
        .search-bar {
            position: relative;
            width: 300px; /* Keep fixed width as per original CSS */
        }

        .search-bar input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .search-bar i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        /* New: Container for "Showing" label and plate select dropdown */
        .showing-controls {
            display: flex;
            align-items: center;
            gap: 10px; /* Space between "Showing" text and the dropdown */
        }

        .showing-controls span {
            font-size: 16px;
            color: #495057;
        }

        /* New: Filter button and its dropdown container */
        .filter-dropdown-container {
            position: relative;
            display: inline-block; /* Allows width to shrink to content and positioning of dropdown */
        }

        .filter-button {
           padding: 10px 15px;
    border: 1px solid #ddd;
    background-color: #f0f2f5;
    color: #555;
    font-size: 15px;
    cursor: pointer;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
    display: inline-flex
;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
        }

        .filter-button:hover {
            background-color: #f0f0f0;
        }

        .filter-button i {
            font-size: 16px; /* Icon size */
        }

        .filter-dropdown-content {
            display: none; /* Hidden by default, toggled by JS */
            position: absolute;
            background-color: #fff;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 10; /* Ensure it appears above other content */
            border-radius: 8px;
            overflow: hidden; /* Ensures rounded corners are applied */
            top: 100%; /* Position directly below the button */
            left: 0; /* Align with the button's left edge */
            margin-top: 5px; /* Small gap between button and dropdown */
        }

        /* Class added by JS to show the dropdown */
        .filter-dropdown-content.show {
            display: block;
        }

        /* Existing Date Filters - adjusted to stack vertically inside dropdown */
        .date-filter {
            display: flex;
            flex-direction: column; /* Stack buttons vertically in dropdown */
            gap: 0; /* Remove gap between buttons, they will take full width */
        }

        /* Existing .date-btn - adjusted for appearance within the dropdown */
        .date-btn {
            padding: 10px 15px; /* Slightly more padding for dropdown items */
            border: none; /* No individual borders for buttons in dropdown */
            background-color: transparent; /* Transparent background by default */
            color: #495057;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: left; /* Align text to the left within the dropdown */
            width: 100%; /* Make buttons take full width of dropdown */
            border-radius: 0; /* No border-radius for individual items in dropdown */
        }

        .date-btn.active {
            background-color: #1f1a5c;
            color: #fff;
        }

        .date-btn:hover {
            background-color: #f1f1f1;
            color: #495057; /* Ensure text color is readable on hover */
        }

        /* Existing Export Button (no change) */
        .export-btn {
           background-color: #f2f4f8;
    color: #495057;
    border: 1px solid #e1e5e9;
    padding: 10px 15px;
    border-radius: 8px;
    font-size: 14px;
    display: inline-flex
;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .export-btn:hover {
            background-color: #e6e9ee; /* Slightly darker gray on hover */
    color: #333;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Responsive adjustments (no change from previous refined version) */
        @media (max-width: 768px) {
            .filter-top-row,
            .filter-bottom-row {
                flex-direction: column;
                align-items: flex-start; /* Align items to left in column layout */
            }

            .search-bar {
                width: 100%;
            }

            .showing-controls,
            .showing-controls select { /* Adjust select width inside controls */
                width: 100%;
            }

            .filter-dropdown-container {
                width: 100%;
            }

            .filter-button {
                width: 100%;
                justify-content: center; /* Center content in button */
            }

            .filter-dropdown-content {
                width: 100%;
                left: 0;
                right: 0;
            }

            .export-btn {
                width: 100%;
                justify-content: center;
            }
        }
/*end*/


 

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
            border-radius: 8px;
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
            color: #1f1a5c;
            text-align: center;
        }

        .modal-content form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .modal-content label {
            font-weight: bold;
            color: #1f1a5c;
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
            background-color: #1f1a5c;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
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
            <x-navbar />
        </ul>
    </div>

   <div class="content">
<div class="content-header">
    <div class="header-controls">
        <h2><i class="fas fa-route me-2"></i>View and Update Trip Records</h2>
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search records...">
        </div>
    </div>
</div>
    <div class="table-container">
        <form method="GET" action="{{ route('admin.managetrip') }}" id="filterForm">
            <div class="filter-top-row">
                <div class="showing-controls">
                     <select name="plate_no" class="truck-select" id="plateSelect">
                        <option value="All Trucks">All Trucks</option>
                       <!-- <option value="" disabled>-- Plate Number --</option>-->
                       
                        @foreach($plateNumbers as $plate)
                            <option value="{{ $plate }}" {{ request('plate_no') == $plate ? 'selected' : '' }}>
                                {{ $plate }}
                            </option>
                        @endforeach
                    </select>
               

            <div class="filter-bottom-row">
                <div class="filter-dropdown-container"> <button type="button" class="filter-button" id="filterDropdownBtn">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <div class="filter-dropdown-content" id="filterDropdownContent">
                        <div class="date-filter"> @foreach(['weekly' => 'Weekly', 'monthly' => 'Monthly', 'annually' => 'Annually'] as $value => $label)
                                <button type="submit" name="filter" value="{{ $value }}"
                                        class="date-btn {{ request('filter') == $value ? 'active' : '' }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
 </div>
                
               
            </div>
                <button class="export-btn" onclick="exportToExcel()" id="exportBtn" type="button">
                  <i class="fas fa-upload me-2"></i> Export
                </button>
            </div>
        </form>
        
      
                    
           

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
                                        
                                            <form action="{{ route('admin.archive.trip', $cargo->id) }}" method="POST" class="d-inline">
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
                        @foreach($plateNumbers as $plate)
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
        // Get all necessary elements, with safety checks
        const filterForm = document.getElementById('filterForm');
        const plateSelect = document.getElementById('plateSelect');
        const dateBtns = document.querySelectorAll('.date-btn');
        const tableContainer = document.getElementById('tableScrollContainer');
        const initialMessage = document.getElementById('initialMessage');
        const exportBtn = document.getElementById('exportBtn');
        const paginationControls = document.getElementById('paginationControls');
        const searchInput = document.getElementById('searchInput');

        // New elements for the filter dropdown
        const filterDropdownBtn = document.getElementById('filterDropdownBtn');
        const filterDropdownContent = document.getElementById('filterDropdownContent');

        // --- Filter Dropdown Toggle Logic ---
        if (filterDropdownBtn && filterDropdownContent) {
            filterDropdownBtn.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevent the document click listener from immediately closing it
                filterDropdownContent.classList.toggle('show'); // Toggle the 'show' class
            });

            // Close dropdown if a click occurs outside of it
            document.addEventListener('click', function(event) {
                // Check if the click was outside both the button and the dropdown content
                if (!filterDropdownBtn.contains(event.target) && !filterDropdownContent.contains(event.target)) {
                    filterDropdownContent.classList.remove('show');
                }
            });
        }

        // --- Initial Load Visibility (based on server-side filters) ---
        // This checks if plate_no or filter parameters are present in the URL
        const hasFilters = window.location.search.includes('plate_no=') || window.location.search.includes('filter=');

        if (hasFilters) {
            initialMessage.style.display = 'none';
            tableContainer.style.display = 'block';
            exportBtn.style.display = 'inline-flex';
            paginationControls.style.display = 'flex';
            initializePagination(); // Initialize pagination as data is present
        }

        // --- Event Listeners for Server-Side Filter Changes (Form Submission) ---

        // Plate Select (Truck Select) change - triggers form submission
        if (plateSelect && filterForm) {
            plateSelect.addEventListener('change', function() {
                filterForm.submit(); // Submits the form to the server
            });
        }

        // Date Filter Buttons (Weekly, Monthly, Annually) click - triggers form submission
        if (dateBtns.length > 0 && filterForm) {
            dateBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // When a date button is clicked, it submits the form.
                    // We also want to close the dropdown if it's open.
                    if (filterDropdownContent) {
                        filterDropdownContent.classList.remove('show');
                    }
                    // The button's `type="submit"` will handle the form submission.
                });
            });
        }

        // --- Client-Side Search Functionality ---
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('#tableBody tr');

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let shouldShow = false;

                    // Iterate through cells, excluding the last one (Actions column)
                    // Check for valid cells length to prevent errors
                    if (cells.length > 1) {
                        for (let i = 0; i < cells.length - 1; i++) {
                            if (cells[i].textContent.toLowerCase().includes(searchTerm)) {
                                shouldShow = true;
                                break;
                            }
                        }
                    } else if (cells.length === 1 && cells[0].textContent.toLowerCase().includes(searchTerm)) {
                         // Case for only one cell, check that
                         shouldShow = true;
                    }

                    row.style.display = shouldShow ? '' : 'none';
                });

                // Re-initialize pagination to reflect the new set of visible rows after search
                if (paginationControls && paginationControls.style.display === 'flex') {
                    initializePagination();
                }
            });
        }

        // --- Pagination Initialization ---
        function initializePagination() {
            const rowsPerPage = 10; // This value is static. Adjust if plateSelect should control it.
            const tableBody = document.getElementById('tableBody');
            if (!tableBody) return; // Exit if table body isn't found

            // Get all table rows, then filter to get only those currently visible (not hidden by search)
            const allTableRows = Array.from(tableBody.querySelectorAll('tr'));
            const rowsCurrentlyVisibleBySearch = allTableRows.filter(row =>
                row.style.display !== 'none'
            );

            const totalRows = rowsCurrentlyVisibleBySearch.length;
            const pageInfo = document.getElementById('pageInfo');
            const prevBtn = document.getElementById('prevPage');
            const nextBtn = document.getElementById('nextPage');

            // If any critical pagination element is missing, hide controls and exit
            if (!pageInfo || !prevBtn || !nextBtn) {
                if (paginationControls) paginationControls.style.display = 'none';
                return;
            }

            let currentPage = 1; // Always start at page 1 when pagination is re-initialized
            const totalPages = Math.ceil(totalRows / rowsPerPage);

            function updateTableDisplay() {
                // First, hide all rows that are not already hidden by client-side search.
                // This ensures we start with a clean slate for pagination display.
                allTableRows.forEach(row => {
                    // Only hide if it's currently visible or if search is empty (meaning it's "eligible" for pagination)
                    if (row.style.display !== 'none' || searchInput.value === '') {
                        row.style.display = 'none';
                    }
                });

                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                // Display only the rows for the current page from the `rowsCurrentlyVisibleBySearch` array
                for (let i = start; i < end && i < rowsCurrentlyVisibleBySearch.length; i++) {
                    rowsCurrentlyVisibleBySearch[i].style.display = ''; // Show this row
                }

                // Update page information text
                const currentStartRow = totalRows === 0 ? 0 : start + 1;
                const currentEndRow = Math.min(end, totalRows);
                pageInfo.textContent = `Showing ${currentStartRow}-${currentEndRow} of ${totalRows} records`;

                // Update pagination button states (disabled/enabled)
                prevBtn.disabled = currentPage === 1;
                nextBtn.disabled = currentPage === totalPages || totalPages === 0;

                // Dynamically show/hide pagination controls based on total rows
                if (totalRows === 0) {
                    if (paginationControls) paginationControls.style.display = 'none';
                } else {
                    if (paginationControls) paginationControls.style.display = 'flex';
                }
            }

            // Initial call to update table display based on current page
            updateTableDisplay();

            // Event listeners for pagination buttons
            prevBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    updateTableDisplay();
                    const tableScrollContainer = document.querySelector('.table-scroll-container');
                    if (tableScrollContainer) tableScrollContainer.scrollTop = 0; // Scroll to top on page change
                }
            });

            nextBtn.addEventListener('click', function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    updateTableDisplay();
                    const tableScrollContainer = document.querySelector('.table-scroll-container');
                    if (tableScrollContainer) tableScrollContainer.scrollTop = 0; // Scroll to top on page change
                }
            });
        }
    }); // End DOMContentLoaded

    // --- Export to Excel Function ---
    // Made global because it's called via `onclick` in HTML
    function exportToExcel() {
        const table = document.getElementById('cargoTable');
        if (!table) {
            console.error("Table with ID 'cargoTable' not found. Cannot export.");
            return;
        }

        const wb = XLSX.utils.book_new();
        const wsData = [];

        // Add headers (from the first row of the table)
        const headers = [];
        if (table.rows.length > 0) {
            for (let cell of table.rows[0].cells) {
                // Exclude 'Actions' column from export
                if (cell.textContent.trim() !== 'Actions') {
                    headers.push(cell.textContent.trim());
                }
            }
            wsData.push(headers);
        }

        // Add data rows (only visible rows)
        for (let i = 1; i < table.rows.length; i++) {
            const row = table.rows[i];
            // Only export rows that are currently displayed (not hidden by search or pagination)
            if (row.style.display === 'none') {
                continue;
            }
            const rowData = [];
            // Iterate through cells, excluding the last one (Actions column)
            for (let j = 0; j < row.cells.length - 1; j++) {
                let cellData = row.cells[j].textContent.trim();

                // Special formatting for date column (assuming it's at index 1)
                if (j === 1) { // Adjust this index if your date column is different
                    const dateValue = new Date(cellData);
                    if (!isNaN(dateValue)) {
                        cellData = dateValue.toISOString().split('T')[0]; // Format to YYYY-MM-DD
                    }
                }
                rowData.push(cellData);
            }
            wsData.push(rowData);
        }

        const ws = XLSX.utils.aoa_to_sheet(wsData);
        XLSX.utils.book_append_sheet(wb, ws, 'Cargo Records');
        XLSX.writeFile(wb, 'cargo_records.xlsx');
    }

    // --- Modal Functions ---
    // Made global because they are called via `onclick` in HTML
    function openTripModal(id, plateNo, eirNo, containerVanNo, size, shipperConsignee, voyageVessel, voyageNo, pickupLocation, deliveryLocation) {
        const tripIdInput = document.getElementById('trip_id');
        if (tripIdInput) tripIdInput.value = id;

        const plateSelectUpdate = document.getElementById('update_plate_no');
        if (plateSelectUpdate) {
            Array.from(plateSelectUpdate.options).forEach(option => {
                option.selected = option.value === plateNo;
            });
        }

        const updateEirNo = document.getElementById('update_eir_no'); if (updateEirNo) updateEirNo.value = eirNo;
        const updateContainerVanNo = document.getElementById('update_container_van_no'); if (updateContainerVanNo) updateContainerVanNo.value = containerVanNo;
        const updateSize = document.getElementById('update_size'); if (updateSize) updateSize.value = size;
        const updateShipperConsignee = document.getElementById('update_shipper_consignee'); if (updateShipperConsignee) updateShipperConsignee.value = shipperConsignee;
        const updateVoyageVessel = document.getElementById('update_voyage_vessel'); if (updateVoyageVessel) updateVoyageVessel.value = voyageVessel;
        const updateVoyageNo = document.getElementById('update_voyage_no'); if (updateVoyageNo) updateVoyageNo.value = voyageNo;
        const updatePickupLocation = document.getElementById('update_pickup_location'); if (updatePickupLocation) updatePickupLocation.value = pickupLocation;
        const updateDeliveryLocation = document.getElementById('update_delivery_location'); if (updateDeliveryLocation) updateDeliveryLocation.value = deliveryLocation;

        const updateModal = document.getElementById('updateModal');
        if (updateModal) updateModal.style.display = 'flex';
    }

    function closeModal() {
        const updateModal = document.getElementById('updateModal');
        if (updateModal) updateModal.style.display = 'none';
    }

    // Close modal when clicking outside (using window.onclick, make sure it's not overridden elsewhere)
    window.onclick = function(event) {
        const updateModal = document.getElementById('updateModal');
        // Ensure updateModal exists and the click target is the modal background itself
        if (updateModal && event.target === updateModal) {
            closeModal();
        }
    }

    // Form submission for update (inside DOMContentLoaded recommended, but global for consistency with your original)
    const updateTripForm = document.getElementById('updateTripForm');
    if (updateTripForm) {
        updateTripForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const tripId = document.getElementById('trip_id').value;
            const formData = new FormData(this);

            fetch(`/admin/update-trip/${tripId}`, {
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
                        window.location.reload(); // Reload page to show updated data
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
    }

    // Archive confirmation with SweetAlert
    document.querySelectorAll('.action-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission initially

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
                    this.submit(); // If confirmed, submit the form
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const plateSelect = document.getElementById('plateSelect');
        const filterForm = document.getElementById('filterForm');

        // Submit the form if "All Trucks" is selected and no filter is applied
        if (plateSelect && plateSelect.value === 'All Trucks' && !window.location.search.includes('plate_no=')) {
            filterForm.submit();
        }
    });
</script>
</body>
</html>