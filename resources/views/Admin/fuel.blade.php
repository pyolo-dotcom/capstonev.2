
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fuel Management - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="{{ asset('/public/images/logo.jpg') }}" type="image/jpg">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- SheetJS for Excel export -->
    <script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins';
        }
        
     

        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100%;
        }
/* General Layout */
body {
    font-family: 'Inter', sans-serif;
    background-color: #f2f4f8;
    margin: 0;
    padding: 0;
}

.content {
    margin-left: 250px;
    padding: 25px;
    flex-grow: 1;
    background-color: white;
    min-height: 100vh;
}

.content-header {
    background: none !important;

    border-radius: 8px;
    box-shadow: none !important;
    margin-bottom: 40px;
        margin-top: 0!important;
}


.table-container {
    background: none !important;
    border-radius: 8px;
    box-shadow: none !important;


}

.filter-container {
 display: flex;
    align-items: center;
    margin-bottom: 10px;
    flex-wrap: wrap;
    gap: 15px;
    
}

.truck-select {
    padding: 10px 15px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-size: 14px;
    color: #333;
    background-color: #fcfcfc;
    width: 90px;
    appearance: none;
    background-repeat: no-repeat;
    background-position: right 8px center;
    background-size: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.filter-dropdown-wrapper {
    position: relative;
    display: inline-block; /* Helps wrap content and define position context */
}
/* Assuming .filter-dropdown is the clickable element that opens your filter */
.filter-dropdown {
    touch-action: manipulation; /* Add this line */
    /* ... your existing styles for .filter-dropdown ... */
}

/* If you have other clickable elements that show/hide content on tap,
   consider adding it to them as well, e.g.: */
.filter-category-item { /* If this is also a clickable filter item */
    touch-action: manipulation;
}

/* If your dropdown menu itself (the container that appears) can also be tapped
   and you want to prevent default browser behavior on it: */
.dropdown-menu {
    touch-action: manipulation;
}

.filter-toggle-button i {
    color: white; /* Icon color for the main Filter button */
}

.filter-toggle-button:hover {
    background-color: #e0e2e5!important;
}

.filter-dropdown-content {
    display: none; /* Hidden by default, toggled by JS */
    position: absolute;
    top: calc(100% + 10px); /* Position 10px below the button */
    right: 0; /* Align to the right edge of the filter-dropdown-wrapper */
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* Deeper shadow for dropdown */
    padding: 15px; /* Overall padding for the dropdown content */
    min-width: 200px; /* Adjust as needed */
    flex-direction: column; /* Stack items vertically within the dropdown */
    gap: 8px; /* Space between buttons */
    z-index: 1000; /* Ensure it's on top */
    opacity: 0; /* For fade-in animation */
    transform: translateY(-10px); /* Start slightly above for slide-down */
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.filter-dropdown-content.show {
    display: flex; /* Or 'block' if flex not desired for internal layout */
    opacity: 1;
    transform: translateY(0);
}

.filter-dropdown-content .date-btn {
    width: 100%; /* Make them full width within the dropdown */
    justify-content: flex-start; /* Align text to the left */
    background: #f8f9fa; /* Light background for inactive dropdown items */
    padding: 10px 15px; /* Consistent padding for dropdown items */
    border-radius: 8px; /* Rounded corners for each item */
    box-shadow: none; /* No individual button shadow within the dropdown */
    font-size: 14px;
    white-space: nowrap; /* Prevent text wrapping within button */
    color: #495057; /* Default text color for dropdown items */
    font-weight: 500;
    text-align: left; /* Ensure text alignment for the buttons */
    cursor: pointer; /* Add pointer cursor */
}
.filter-dropdown-content .date-btn.active {
    background: #e6f0ff !important; /* Light blue background when active */
    color: #007bff;
}

.filter-dropdown-content .date-btn:not(.active):hover {
    background-color: #e9ecef !important; /* Slightly darker on hover */
    color: #333;
}

/* Specific styling for the 'Custom' date button within the dropdown */
.filter-dropdown-content .date-btn[data-filter="custom"] {
    color: #6c757d; /* Icon and text color for custom button */
}

.custom-date-container { /* This class is now on the popup div */
    display: none; /* Hidden by default, shown by JS */
    position: absolute;
    /* Position it near the filter-dropdown-wrapper (its sibling) */
    top: calc(100% + 10px); /* 10px below the filter-dropdown-wrapper */
    right: 0; /* Align with the right edge of the filter-dropdown-wrapper */

    background: #ffffff; /* White background for the popup box */
    border-radius: 10px; /* Rounded corners for the popup box */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* Shadow for the popup box */
    padding: 15px; /* Internal padding for the popup box */
    min-width: 250px; /* Adjust width as needed for inputs and button */
    flex-direction: column; /* Stack inputs and button vertically */
    gap: 10px; /* Space between inputs, "to" span, and apply button */
    z-index: 1001; /* Higher z-index to appear on top of main dropdown */
    opacity: 0; /* For fade-in animation */
    transform: translateY(-10px); /* Start slightly above for slide-down */
    transition: opacity 0.3s ease, transform 0.3s ease;
    align-items: center; /* Center the input fields and button horizontally */
    box-sizing: border-box; /* Include padding in the element's total width and height */
}

.custom-date-container.show {
    display: flex;
    opacity: 1;
    transform: translateY(0);
}

/* Styles for inputs and button within the custom date popup */
.custom-date-input {
    width: 100%; /* Full width within the popup */
    padding: 8px 12px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    font-size: 14px;
    color: #495057;
    box-sizing: border-box;
}

.custom-date-container span {
    color: #6c757d;
    font-size: 14px;
    text-align: center; /* Ensure "to" is centered */
    width: 100%; /* Occupy full width for centering if flex-direction is column */
}

.custom-date-btn {
    padding: 8px 15px;
    border: none;
    border-radius: 8px;
    background-color: #28a745; /* Green for apply */
    color: white;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s;
    width: 100%; /* Full width within the popup */
}

.custom-date-btn:hover {
    background-color: #218838;
}

.date-filter-dropdown {
    position: absolute;
    /* Adjust top/left/right as needed relative to your toggle button */
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    border-radius: 8px;
    padding: 10px;
    display: none; /* Hidden by default */
    /* Remove flex-direction and gap from here for now,
       we'll control layout of its children with individual styles or inner flexbox */
}
.date-filter-dropdown.show {
    display: block; /* Use block to allow children to stack naturally or be flexed inside */
}

.date-btn {
    background-color: #e0e0e0;
    border: none;
    padding: 10px 15px;
    text-align: center;
    text-decoration: none;
    display: block; /* Make them block-level to stack vertically */
    width: 100%; /* Take full width of parent */
    margin-bottom: ; /* Space between buttons */
    font-size: 14px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}
/* Styles for the filter toggle button outside the dropdown */
.filter-toggle-button {
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

.filter-toggle-button:hover {
    background-color: #0056b3;
}
/* Export Button */
.export-button { /* Changed from .export-btn-wrapper for clarity as per HTML */
    /* No margin-top needed here as it's part of the flex container */
}

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

.export-btn i {
    color: #28a745; /* Green icon for export */
    font-size: 15px;
}

.export-btn:hover {
    background-color: #e6e9ee; /* Slightly darker gray on hover */
    color: #333;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Toggle Buttons (Show Chart/Show Table) */
.button-row-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-end; /* Aligns toggle buttons at the bottom */
    margin-bottom: 0; /* Adjust as per image spacing */
    flex-wrap: wrap;
    gap: 15px; /* Gap for wrap */
}

.toggle-buttons {
    display: flex;
    margin-bottom: -1px; /* Overlap with chart/table container border */
}

.toggle-btn {
    background-color: #e9ecef;
    border: 1px solid #dee2e6;
    border-bottom: none;
    outline: none;
    cursor: pointer;
    padding: 14px 20px;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s;
    font-size: 1rem;
    border-radius: 8px 8px 0 0;
    flex-shrink: 0;
    text-align: center;
    color: #495057;
    white-space: nowrap;
    font-weight: 500;
}

.toggle-btn:hover {
    background-color: #d0d0d0;
}

.toggle-btn.active {
       background-color: #f8f9fa;
    border-color: #3498db;
    border-bottom: 1px solid #ffffff;
    color: #3498db;
    font-weight: bold;
    position: relative;
    z-index: 1;
}

/* Chart Container */
.chart-container {
    width: 100%;
    margin-top: 0; /* Remove top margin as it's now controlled by button-row-container */
    background-color: #fff;
    padding: 20px;
    border-radius: 0 0 10px 10px; /* Rounded bottom corners */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border: 1px solid #dee2e6; /* Border to match toggle buttons */
    border-top: none; /* No top border, as toggle buttons handle it */
}

#fuelChart {
    width: 100%;
    height: 400px;
}

/* Table Styles */
.table-scroll-container {
    max-height: 500px;
    overflow-y: auto;
    margin-top: 0; /* No margin top here */
    border: 1px solid #e0e0e0;
    border-radius: 0 0 8px 8px; /* Rounded bottom corners */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Consistent shadow */
    background-color: #fff;
    border-top: none; /* No top border */
}


.fuel-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.fuel-table th {
    background-color: #f8f9fa; /* Lighter header background as per common design patterns */
    color: #6c757d; /* Darker text */
    padding: 12px 15px;
    text-align: left;
    font-weight: 600;
    position: sticky;
    top: 0;
    font-size: 12px; /* Smaller font for headers */
    text-transform: uppercase; /* Uppercase headers */
    letter-spacing: 0.5px;
    border-bottom: 1px solid #e1e5e9; /* Separator for header */
}

.fuel-table th:last-child {
    text-align: center;
}

.fuel-table td {
    padding: 10px 15px; /* Slightly less padding for rows */
    border-bottom: 1px solid #e9ecef; /* Lighter border for rows */
    vertical-align: middle;
    color: #495057;
    font-size: 13px; /* Slightly smaller font for table data */
}

.fuel-table tr:last-child td {
    border-bottom: none;
}

.fuel-table tr:hover td {
    background-color: #fcfcfc; /* Very light highlight on hover */
}


.actions {
    display: flex;
    gap: 5px; /* Smaller gap between action buttons */
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
    height: 30px; /* Smaller button height */
    width: auto; /* Allow width to adjust to content */
    padding: 0 8px; /* Padding for text */
    margin: 0;
    border-radius: 4px; /* Slightly rounded for actions */
    transition: all 0.2s;
    font-size: 13px; /* Smaller font for action text */
    font-weight: 500;
}

.actions button {
    border: none;
    cursor: pointer;
    background-color: transparent; /* Default transparent */
}

.actions form {
    margin: 0;
    padding: 0;
    display: inline-flex;
    height: 100%;
}

.actions .edit-btn {
    color: #007bff; /* Blue for edit */
    background-color: rgba(0, 123, 255, 0.1);
}

.actions .edit-btn:hover {
    background-color: rgba(0, 123, 255, 0.2);
    transform: translateY(-1px);
}

.actions .archive-btn {
    color: #dc3545; /* Red for archive */
    background-color: rgba(220, 53, 69, 0.1);
}

.actions .archive-btn:hover {
    background-color: rgba(220, 53, 69, 0.2);
    transform: translateY(-1px);
}


.pagination-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    padding: 10px 0;
    border-top: 1px solid #e9ecef;
    padding-top: 15px;
}

.page-info {
    font-size: 13px;
    color: #6c757d;
}

.page-buttons {
    display: flex;
    gap: 8px;
}

.page-btn {
    padding: 6px 12px;
    background-color: #f8f9fa;
    color: #495057;
    border: 1px solid #e1e5e9;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
    transition: all 0.2s;
    font-weight: 500;
}

.page-btn:hover:not(:disabled) {
    background-color: #e9ecef;
    color: #333;
    border-color: #d1d5da;
}

.page-btn:disabled {
    background-color: #f1f3f5;
    color: #adb5bd;
    cursor: not-allowed;
    border-color: #e9ecef;
}

.no-data {
    text-align: center;
    padding: 30px;
    color: #6c757d;
    font-style: italic;
}

/* For the chart/table toggle, the H4 and button-row-container alignment */
h4 {
    margin-bottom: 10px;
    color: #1f1a5c;
    font-size: 1.2rem;
    font-weight: 600;
}
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
            }
             .btn-container {
        flex-wrap: nowrap;
    }
            .content {
                margin-left: 0;
            }
            
            .filter-container {
                flex-direction: column;
            }
            
            .date-filter {
                flex-wrap: wrap; /* Allow buttons to wrap */
                justify-content: center;
            }
            
            .date-btn {
                flex-grow: 1;
                flex-wrap: wrap; /* Allow buttons to wrap */
                justify-content: center;
            }

            .custom-date-container {
                display: none; /* Hidden by default, controlled by JS */
                position: absolute; /* Position below date-filter */
                bottom: 100%; /* Start just below the date-filter */
                left: 300px; /* Approximate position under Custom button */
                background: #ffffff; /* Match date-filter background */
                padding: 8px;
                border-radius: 8px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08); /* Subtle shadow */
                display: flex;
                align-items: center;
                gap: 8px;
                opacity: 0; /* For fade-in effect */
                transform: translateY(-10px); /* Start slightly above for slide-down */
                transition: opacity 0.3s ease, transform 0.3s ease;
                z-index: 10;
            }

            .custom-date-input {
                width: calc(50% - 5px);
            }
            .custom-date-btn {
                width: 100%;
                margin-top: 8px;
            }
        }

        @media (max-width: 600px) {
            .btn-container {
                flex-wrap: nowrap;
            }

            .add-consumption-btn,
            .export-btn {
                flex-shrink: 0;
            }

            .date-btn {
        font-size: 13px;
        padding: 6px 8px;
    }

    .custom-date-input {
        width: 100%; /* Full width on very small screens */
        margin-bottom: 8px;
    }

    .custom-date-container {
        flex-direction: column; /* Stack vertically */
        align-items: stretch;
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



        

        <div class="button-row-container">
            <div class="toggle-buttons">
                <button id="showChartBtn" class="toggle-btn active">Fuel Chart</button>
                <button id="showTableBtn" class="toggle-btn">Fuel Table</button>
            </div>
            
    <div class="table-container">
        <div class="filter-container">
            <div style="display: flex; align-items: center; gap: 8px;">
                <label for="plateNumberSelect"></label>
                <select id="plateNumberSelect" name="plateNumberSelect" class="truck-select" required>
                   <!-- <option disabled selected>-- Plate Number --</option>-->
                    <option value="all">All Trucks</option>
                    @foreach($plateNumbers as $plate)
                        <option value="{{ $plate }}">{{ $plate }}</option>
                    @endforeach
                </select>
            </div>

         <div style="position: relative; display: inline-block;"> <div class="filter-dropdown-wrapper">
        <button class="date-btn filter-toggle-button" id="toggleDateFilterButton">
            <i class="fas fa-filter"></i> Filter
        </button>

        <div class="date-filter filter-dropdown-content" id="dateFilterDropdown">
            <button class="date-btn active time-filter-btn" data-filter="weekly">Weekly</button>
            <button class="date-btn time-filter-btn" data-filter="monthly">Monthly</button>
            <button class="date-btn time-filter-btn" data-filter="yearly">Annually</button>
            <button class="date-btn time-filter-btn" data-filter="custom"><i class="fas fa-cog"></i>Custom</button>
        </div>
    </div>

    <div class="custom-date-container" id="customDateContainer">
        <input type="date" id="startDate" class="custom-date-input">
        <span>to</span>
        <input type="date" id="endDate" class="custom-date-input">
        <button class="custom-date-btn" id="applyCustomDate">Apply</button>
    </div>
</div>
                <div class="export-button"> 
                <button class="export-btn" onclick="exportToExcel()">
                   <i class="fas fa-upload me-2"></i> Export
                </button>
           </div>
            </div>
            </div>
            
            
        </div>
        <div class="chart-container" id="fuelChartContainer">
            <canvas id="fuelChart"></canvas>
        </div>


        <div class="table-scroll-container" id="fuelTableContainer" style="display: none;">
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
    document.addEventListener('DOMContentLoaded', function () {
        // --- Existing Chart/Table Toggle Logic ---
        const showChartBtn = document.getElementById('showChartBtn');
        const showTableBtn = document.getElementById('showTableBtn');
        const fuelChartContainer = document.getElementById('fuelChartContainer');
        const fuelTableContainer = document.getElementById('fuelTableContainer');

        function showChart() {
            fuelChartContainer.style.display = 'block';
            fuelTableContainer.style.display = 'none';
            showChartBtn.classList.add('active');
            showTableBtn.classList.remove('active');
        }

        function showTable() {
            fuelTableContainer.style.display = 'block';
            fuelChartContainer.style.display = 'none';
            showTableBtn.classList.add('active');
            showChartBtn.classList.remove('active');
        }

        showChartBtn.addEventListener('click', showChart);
        showTableBtn.addEventListener('click', showTable);

        showChart(); // Initially show the chart


        // --- Existing Fuel Management and Filtering Logic ---
        let fuelChart = null;
        let currentPage = 1;
        const rowsPerPage = 10;
        let filteredData = [];
        let allData = [];
        let selectedTimeFilter = 'weekly'; // Default filter
        let selectedPlateNumber = "-- Plate Number --"; // Default plate number - IMPORTANT: Match your initial dropdown state

        // --- References for the filter dropdown UI elements ---
        const toggleDateFilterButton = document.getElementById('toggleDateFilterButton');
        const dateFilterDropdown = document.getElementById('dateFilterDropdown');
        const customDateContainer = document.getElementById('customDateContainer');
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');
        const applyCustomDateButton = document.getElementById('applyCustomDate');
        const timeFilterButtons = dateFilterDropdown.querySelectorAll('.time-filter-btn');
        const plateNumberSelect = document.getElementById('plateNumberSelect'); // Added plate number select ref
        // --- END REFERENCES ---

        // NEW STATE VARIABLE: Tracks if custom container was just closed by an outside click
        // This is crucial for the "second click anywhere" logic.
        let customContainerWasHiddenByOutsideClick = false;


        // Initialize allData with the current table rows
        const rows = Array.from(document.querySelectorAll('#fuelTableBody tr'));
        allData = rows.map(row => {
            const cells = row.cells;
            return {
                id: row.querySelector('.edit-btn') ? row.querySelector('.edit-btn').getAttribute('onclick').match(/editFuel\((\d+)\)/)[1] : null, // Handle cases where edit-btn might not be present
                date: new Date(cells[0].textContent),
                dateString: cells[0].textContent,
                plate_no: cells[1].textContent,
                total_km: parseFloat(cells[2].textContent.replace(/,/g, '')), // Handle commas
                avg_km_l: parseFloat(cells[3].textContent.replace(/,/g, '')), // Handle commas
                fuel_price: parseFloat(cells[5].textContent.replace(/,/g, '')), // Handle commas
                total_liters: parseFloat(cells[4].textContent.replace(/,/g, '')), // Handle commas
                total_cost: parseFloat(cells[6].textContent.replace(/,/g, '')), // Handle commas
                element: row
            };
        });

        // Initialize pagination
        initializePagination();

        let ctxFuelChart = document.getElementById('fuelChart').getContext('2d'); // Renamed to avoid conflict if any
        let fuelChartCanvas = document.getElementById('fuelChart');
        fuelChartCanvas.style.display = 'none'; // Hide the graph (canvas) initially

        // Set default dates for custom date range
        const today = new Date();
        const oneWeekAgo = new Date();
        oneWeekAgo.setDate(today.getDate() - 7);

        if (startDateInput && endDateInput) {
            startDateInput.valueAsDate = oneWeekAgo;
            endDateInput.valueAsDate = today;
        }


        // --- Dropdown Toggle Logic - Fixed Version ---
        if (toggleDateFilterButton && dateFilterDropdown && customDateContainer) {
            toggleDateFilterButton.addEventListener('click', function (event) {
                event.stopPropagation();
                
                // Always close custom container when toggling main dropdown
                customDateContainer.classList.remove('show');
                
                // Toggle main dropdown visibility
                dateFilterDropdown.classList.toggle('show');
                
                // Reset the outside click flag
                customContainerWasHiddenByOutsideClick = false;
                
                // Highlight active filter button when dropdown opens
                if (dateFilterDropdown.classList.contains('show')) {
                    timeFilterButtons.forEach(btn => {
                        btn.classList.toggle(
                            'active', 
                            btn.getAttribute('data-filter') === selectedTimeFilter
                        );
                    });
                }
            });
        }


        // --- Listener for clicks WITHIN the main dateFilterDropdown (Weekly, Monthly, Annually, Custom buttons, or empty space) ---
        if (dateFilterDropdown && customDateContainer) {
            dateFilterDropdown.addEventListener('click', function(event) {
                const clickedElement = event.target;
                const clickedBtn = event.target.closest('.time-filter-btn'); // Get the actual button element

                // Step 1: Handle clicks on the time filter buttons themselves
                if (clickedBtn) {
                    event.stopPropagation(); // ESSENTIAL: Prevent these clicks from bubbling up to the document listener for now.
                                             // This ensures the main dropdown *stays open* when a filter is selected, if needed.

                    if (!selectedPlateNumber || selectedPlateNumber === "-- Plate Number --") {
                        Swal.fire({ icon: 'info', title: 'Select Plate Number', text: 'Please select a plate number first.' });
                        return;
                    }

                    selectedTimeFilter = clickedBtn.getAttribute('data-filter');
                    timeFilterButtons.forEach(btn => btn.classList.remove('active'));
                    clickedBtn.classList.add('active');

                    if (selectedTimeFilter === 'custom') {
                        customDateContainer.classList.add('show');
                        console.log("Custom button clicked. Showing customDateContainer.");
                        // DO NOT filter or fetch data here. Wait for "Apply".
                    } else {
                        customDateContainer.classList.remove('show'); // Hide custom if non-custom filter is selected
                        console.log(`Filter ${selectedTimeFilter} clicked. Hiding customDateContainer.`);

                        // For non-custom filters, apply immediately
                        currentPage = 1;
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
                        // For "All Trucks", fetchFuelData will use the locally filtered 'allData'
                        // For specific plate numbers, it will still fetch from the server.
                        fetchFuelData(selectedPlateNumber, selectedTimeFilter); // Fetch data for chart

                        // Close the main filter dropdown after selecting a non-custom filter
                        dateFilterDropdown.classList.remove('show');
                    }
                    customContainerWasHiddenByOutsideClick = false; // Reset flag as action was internal
                    return; // Stop processing this event further for filter buttons
                }

                // Step 2: Handle clicks on empty space within dateFilterDropdown when customDateContainer is open
                // This covers "click once (anywhere in the surface but not in the input date)" for *internal* clicks.
                if (customDateContainer.classList.contains('show') && !customDateContainer.contains(clickedElement)) {
                    customDateContainer.classList.remove('show'); // Hide ONLY the custom date container
                    // DO NOT stopPropagation() here. Let this event bubble up to the document listener.
                    // The document listener will see that the click was *inside* dateFilterDropdown,
                    // and thus will NOT close dateFilterDropdown (as per its `return` logic).
                    // This achieves "filter dropdown content is remaining open while the custom date is close" for internal clicks.
                    console.log("Clicked empty space inside dateFilterDropdown. Hiding custom container only.");
                    customContainerWasHiddenByOutsideClick = false; // Reset because this was an internal close
                }
                // If customDateContainer is not open, or click was inside customDateContainer, nothing happens here.
            });
        }

// --- PREVENT CLICKS INSIDE CUSTOM CONTAINER ELEMENTS FROM BUBLING UP ---
        // This is crucial. Clicks on these elements should *never* close the main dropdown or custom container immediately.
        if (startDateInput) {
            startDateInput.addEventListener('click', function(event) {
                event.stopPropagation();
                console.log("startDateInput clicked. Stopping propagation.");
            });
        }
        if (endDateInput) {
            endDateInput.addEventListener('click', function(event) {
                event.stopPropagation();
                console.log("endDateInput clicked. Stopping propagation.");
            });
        }
        if (applyCustomDateButton) {
            applyCustomDateButton.addEventListener('click', function(event) {
                event.stopPropagation(); // Crucial: Stop click from bubbling up.
                console.log("Apply button clicked. Processing custom date filter and closing both dropdowns.");

                if (!selectedPlateNumber || selectedPlateNumber === "-- Plate Number --") {
                    Swal.fire({
                        icon: 'info',
                        title: 'Select Plate Number',
                        text: 'Please select a plate number first to apply custom date filter.'
                    });
                    return;
                }

                const startDate = startDateInput.value;
                const endDate = endDateInput.value;

                if (!startDate || !endDate) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Please select both start and end dates',
                    });
                    return;
                }

                if (new Date(startDate) > new Date(endDate)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Start date cannot be after end date',
                    });
                    return;
                }

                // --- APPLY FILTERING LOGIC HERE FOR CUSTOM DATE ---
                currentPage = 1;

                let filteredByPlate = [];
                if (selectedPlateNumber === "all") {
                    filteredByPlate = [...allData];
                } else {
                    filteredByPlate = allData.filter(item => item.plate_no === selectedPlateNumber);
                }

                filteredData = filterDataByCustomDate(filteredByPlate, startDate, endDate);

                if (filteredData.length > 0) {
                    document.getElementById('paginationControls').style.display = 'flex';
                    updateTable();
                } else {
                    document.getElementById('paginationControls').style.display = 'none';
                    hideAllData();
                }

                // For "All Trucks", fetchFuelData will use the locally filtered 'allData'
                // For specific plate numbers, it will still fetch from the server.
                fetchFuelData(selectedPlateNumber, 'custom', startDate, endDate); // Fetch data for chart

                // After applying, hide custom container and main dropdown (common UX behavior for 'Apply')
                customDateContainer.classList.remove('show');
                dateFilterDropdown.classList.remove('show');
                customContainerWasHiddenByOutsideClick = false; // Reset flag
            });
        }
        // --- END PREVENT CLICKS ---


        // *** THE REFINED DOCUMENT CLICK LISTENER - Handles all "outside" clicks ***
        document.addEventListener('click', function (event) {
            // First, determine if the click was *inside* our controlled dropdown areas.
            const isClickInsideToggleBtn = toggleDateFilterButton && toggleDateFilterButton.contains(event.target);
            const isClickInsideMainDropdown = dateFilterDropdown && dateFilterDropdown.contains(event.target);

            // Scenario 1: Click was inside the toggle button or inside the main dropdown content.
            // In these cases, we explicitly *do not* close the main dropdown here.
            // Internal event listeners (like on timeFilterButtons or empty space in dateFilterDropdown)
            // are responsible for their specific actions (e.g., showing/hiding custom, selecting filters).
            if (isClickInsideToggleBtn || isClickInsideMainDropdown) {
                console.log("Document click: Click is within the toggle button or main dropdown. No closing action from document listener.");
                customContainerWasHiddenByOutsideClick = false; // Reset flag if interacting internally
                return; // Stop processing this click from the document listener.
            }

            // If we reach here, the click was genuinely *outside* both the toggle button and the entire dateFilterDropdown.

            // Scenario 2: Main dropdown is open, and custom container is also open.
            // This is the "first click anywhere (outside main dropdown)" to hide ONLY custom.
            if (dateFilterDropdown && dateFilterDropdown.classList.contains('show') && customDateContainer && customDateContainer.classList.contains('show')) {
                customDateContainer.classList.remove('show'); // Hide ONLY the custom date container
                customContainerWasHiddenByOutsideClick = true; // Set flag: custom was just hidden by an outside click
                console.log("Document click: Custom container was open, click outside main dropdown. Hiding CUSTOM ONLY. Flag set for next click.");
                return; // Crucial: Do NOT close the main dropdown yet.
            }

            // Scenario 3: Main dropdown is open, custom container is NOT open (or was just hidden by the previous outside click).
            // This is the "second click anywhere" or a direct outside click when custom was already hidden.
            if (dateFilterDropdown && dateFilterDropdown.classList.contains('show') && (!customDateContainer || !customDateContainer.classList.contains('show'))) {
                   // Check if the previous action was an outside click that hid the custom container.
                   // This ensures the "second click anywhere" behavior for the main dropdown.
                if (customContainerWasHiddenByOutsideClick) {
                    dateFilterDropdown.classList.remove('show'); // Close the main dropdown
                    console.log("Document click: Main dropdown open, custom was just hidden (second click). Hiding MAIN DROPDOWN.");
                } else {
                    // This covers the case where the main dropdown is open, custom is not,
                    // and this is the *first* true outside click on the main dropdown itself (no custom to hide first).
                    dateFilterDropdown.classList.remove('show');
                    console.log("Document click: Main dropdown open, custom NOT visible (first click). Hiding MAIN DROPDOWN.");
                }
                customContainerWasHiddenByOutsideClick = false; // Reset flag after closing main dropdown
                return;
            }

            // If none of the above, main dropdown is already closed or not relevant.
            customContainerWasHiddenByOutsideClick = false; // Ensure flag is false if nothing happened
        });
        // *** END REFINED DOCUMENT CLICK LISTENER ***


        function fetchFuelData(plateNumber, timeFilter, startDate = null, endDate = null) {
            if (!plateNumber || plateNumber === "-- Plate Number --") {
                if (fuelChartCanvas) fuelChartCanvas.style.display = 'none';
                return;
            }

            // Handle "all" plate number locally from `allData`
            if (plateNumber === "all") {
                let filtered = allData;

                if (timeFilter === 'custom' && startDate && endDate) {
                    filtered = filterDataByCustomDate(allData, startDate, endDate);
                } else {
                    filtered = filterDataByTimeRange(allData, timeFilter);
                }

                const { data: aggregatedData, plateNumbers } = aggregateDataByDate(filtered);
                updateFuelChart(
                    aggregatedData.map(item => item.dateString),
                    aggregatedData.map(item => item.total_km),
                    aggregatedData.map(item => item.total_liters),
                    plateNumbers
                );
                if (fuelChartCanvas) fuelChartCanvas.style.display = 'block';
            } else {
                // Original logic for individual plate numbers (fetching from server)
                let url = `/fuel-analytics?plate_number=${encodeURIComponent(plateNumber)}&time_filter=${timeFilter}`;

                if (timeFilter === 'custom' && startDate && endDate) {
                    url += `&start_date=${startDate}&end_date=${endDate}`;
                }

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (!Array.isArray(data) || data.length === 0) {
                            updateFuelChart([], [], []);
                            if (fuelChartCanvas) fuelChartCanvas.style.display = 'none';
                            return;
                        }

                        let labels = data.map(item => item.date);
                        let kilometers = data.map(item => item.total_km);
                        let fuelUsed = data.map(item => item.total_liters);

                        updateFuelChart(labels, kilometers, fuelUsed);
                        if (fuelChartCanvas) fuelChartCanvas.style.display = 'block';
                    })
                    .catch(error => console.error('Error fetching fuel data:', error));
            }
        }

        // Helper function to aggregate data for "all" trucks by date
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

            // Ensure plateNumbers array is in the same order as aggregatedData
            const sortedAggregatedData = Object.values(dateMap).sort((a, b) => new Date(a.dateString) - new Date(b.dateString));
            const plateNumbers = sortedAggregatedData.map(item => Array.from(plateNumbersMap[item.dateString]).join(', '));

            return {
                data: sortedAggregatedData,
                plateNumbers: plateNumbers
            };
        }


        function updateFuelChart(labels, kilometers, fuelUsed, plateNumbers = []) {
            if (fuelChart) {
                fuelChart.destroy();
            }

            const isAllTrucks = selectedPlateNumber === "all";

            fuelChart = new Chart(ctxFuelChart, { // Use renamed context variable
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

            return filtered.sort((a, b) => b.date - a.date);
        }

        function filterDataByCustomDate(data, startDate, endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);

            end.setHours(23, 59, 59, 999); // Set end date to end of day

            return data.filter(item => {
                const itemDate = new Date(item.date);
                return itemDate >= start && itemDate <= end;
            }).sort((a, b) => b.date - a.date);
        }

        // Initialize pagination with proper event listeners
        function initializePagination() {
            // Set initial filteredData based on selectedPlateNumber and selectedTimeFilter
            let initialFilteredByPlate = [];
            if (selectedPlateNumber === "all" || selectedPlateNumber === "-- Plate Number --") {
                initialFilteredByPlate = [...allData];
            } else {
                initialFilteredByPlate = allData.filter(item => item.plate_no === selectedPlateNumber);
            }
            // For initial load, apply the default 'weekly' filter to the selected plate data
            filteredData = filterDataByTimeRange(initialFilteredByPlate, selectedTimeFilter);

            updateTable();

            const prevPageBtn = document.getElementById('prevPage');
            const nextPageBtn = document.getElementById('nextPage');

            if (prevPageBtn) {
                prevPageBtn.addEventListener('click', goToPreviousPage);
            }
            if (nextPageBtn) {
                nextPageBtn.addEventListener('click', goToNextPage);
            }
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

            document.querySelectorAll('#fuelTableBody tr').forEach(row => {
                row.style.display = 'none'; // Hide all rows first
            });

            paginatedData.forEach(item => {
                if (item.element) { // Ensure the element exists before trying to display it
                    item.element.style.display = ''; // Show only current page rows
                }
            });

            updatePaginationControls();
        }

        function updatePaginationControls() {
            const totalPages = Math.ceil(filteredData.length / rowsPerPage);
            const startItem = filteredData.length > 0 ? (currentPage - 1) * rowsPerPage + 1 : 0;
            const endItem = Math.min(currentPage * rowsPerPage, filteredData.length);

            const pageInfo = document.getElementById('pageInfo');
            const prevPageBtn = document.getElementById('prevPage');
            const nextPageBtn = document.getElementById('nextPage');

            if (pageInfo) {
                pageInfo.textContent = `Showing ${startItem}-${endItem} of ${filteredData.length} records`;
            }
            if (prevPageBtn) {
                prevPageBtn.disabled = currentPage === 1;
            }
            if (nextPageBtn) {
                nextPageBtn.disabled = currentPage === totalPages || totalPages === 0;
            }
        }

        // Handle plate number selection
        if (plateNumberSelect) {
            plateNumberSelect.addEventListener('change', function () {
                selectedPlateNumber = this.value.trim();
                currentPage = 1; // Reset to first page on plate number change

                if (selectedPlateNumber === "-- Plate Number --") {
                    hideAllData();
                    if (fuelChartCanvas) fuelChartCanvas.style.display = 'none';
                    if (fuelChart) fuelChart.destroy(); // Destroy chart if no plate is selected
                    return;
                }

                let filteredByPlate = [];
                if (selectedPlateNumber === "all") {
                    filteredByPlate = [...allData];
                } else {
                    filteredByPlate = allData.filter(item => item.plate_no === selectedPlateNumber);
                }

                // Apply time filter based on current `selectedTimeFilter` state
                if (selectedTimeFilter === 'custom') {
                    const startDate = startDateInput ? startDateInput.value : null;
                    const endDate = endDateInput ? endDateInput.value : null;

                    if (startDate && endDate) { // Check if dates are already set (from a previous "Apply" action)
                        filteredData = filterDataByCustomDate(filteredByPlate, startDate, endDate);
                    } else {
                        // If custom is selected but dates are not yet applied, show all for the selected plate
                        filteredData = filteredByPlate;
                    }
                } else {
                    // For non-custom filters, apply immediately
                    filteredData = filterDataByTimeRange(filteredByPlate, selectedTimeFilter);
                }

                if (filteredData.length > 0) {
                    document.getElementById('paginationControls').style.display = 'flex';
                    updateTable();
                } else {
                    document.getElementById('paginationControls').style.display = 'none';
                    hideAllData();
                }

                // Always fetch/update chart data when plate number changes
                if (selectedTimeFilter === 'custom') {
                    const startDate = startDateInput ? startDateInput.value : null;
                    const endDate = endDateInput ? endDateInput.value : null;
                    // Only fetch chart data for custom if dates are provided
                    if (startDate && endDate) {
                        fetchFuelData(selectedPlateNumber, selectedTimeFilter, startDate, endDate);
                    } else {
                        // If custom is chosen but dates aren't applied yet, don't show a chart
                        if (fuelChartCanvas) fuelChartCanvas.style.display = 'none';
                        if (fuelChart) fuelChart.destroy();
                    }
                } else {
                    fetchFuelData(selectedPlateNumber, selectedTimeFilter);
                }
            });

            // Trigger change event on load to populate initial data based on default selection
            plateNumberSelect.dispatchEvent(new Event('change'));
        }
    }); // End of combined DOMContentLoaded listener

    // --- Global functions (outside DOMContentLoaded, as they are called by events or other functions) ---

    function hideAllData() {
        document.querySelectorAll('#fuelTableBody tr').forEach(row => {
            row.style.display = 'none';
        });
        const paginationControls = document.getElementById('paginationControls');
        if (paginationControls) paginationControls.style.display = 'none';
    }

    function openFuelModal() {
        const fuelModal = document.getElementById('fuelModal');
        if (fuelModal) fuelModal.style.display = 'block';
    }

    function closeFuelModal() {
        const fuelModal = document.getElementById('fuelModal');
        if (fuelModal) fuelModal.style.display = 'none';
    }

    function addFuelConsumption() {
        const fuelForm = document.getElementById('fuelForm');
        if (!fuelForm) {
            console.error("Fuel form not found.");
            return;
        }

        let formData = new FormData(fuelForm);

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
                fuelForm.reset();
                setTimeout(() => window.location.reload(), 2000);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Error adding fuel consumption.',
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

        const updateFuelModal = document.getElementById('updateFuelModal');
        if (updateFuelModal) updateFuelModal.style.display = 'block';
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
        const table = document.getElementById('fuelTable');
        if (!table) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Fuel table not found for export.',
            });
            return;
        }

        const tableClone = table.cloneNode(true);
        const actionHeaderIndex = 7; // Assuming 'Actions' is the 8th column (0-indexed 7)

        const headerRow = tableClone.querySelector('thead tr');
        if (headerRow && headerRow.cells.length > actionHeaderIndex) {
            headerRow.deleteCell(actionHeaderIndex);
        }

        const dataRows = tableClone.querySelectorAll('tbody tr');
        dataRows.forEach(row => {
            if (row.cells.length > actionHeaderIndex) {
                row.deleteCell(actionHeaderIndex);
            }
        });

        const worksheet = XLSX.utils.table_to_sheet(tableClone);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Fuel Data");

        const now = new Date();
        const formattedDate = now.toISOString().slice(0, 10);
        const formattedTime = now.toTimeString().slice(0, 8).replace(/:/g, '-');
        const filename = `Fuel_Data_${formattedDate}_${formattedTime}.xlsx`;

        XLSX.writeFile(workbook, filename);

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