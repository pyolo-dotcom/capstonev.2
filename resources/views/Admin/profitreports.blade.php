<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profit Reports</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="icon" href="{{ asset('/public/images/logo.jpg') }}" type="image/jpg">
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
    justify-content: flex-start;
    align-items: center;
    ;
    flex-wrap: wrap;
    gap: 15px;
        }
.filter-group{
    display: flex;
   
    align-items: center;
   /* flex-wrap: wrap;*/
    gap: 20px;
        }

      
        /* Plate filter container */
        .plate-filter {
            display: flex;
            align-items: center;
        }
        .form-control, .form-select{
            padding: 8px 12px!important;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-size: 14px;
    color: #333;
    background-color: #fcfcfc;
    width: 120px!important;
    appearance: none;
    background-repeat: no-repeat;
    background-position: right 8px center;
    background-size: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
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
    color: #6c757d;
    padding: 12px 15px;
    text-align: left;
    font-weight: 600;
    position: sticky;
    top: 0;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #e1e5e9;
        }
        
        .table tbody tr {
            transition: all 0.2s;
        }
        
        .table tbody tr:hover {
            background-color: rgba(0,0,0,0.03);
        }
        
        .table td {
          padding: 10px 15px;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
    color: #495057;
    font-size: 15px;
}
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
            background:none!important;
        }
        
        .btn-edit {
            color: green;
            border: none;
        }
        
        .btn-edit:hover {
            background-color: #2980b9;
            color: white;
            transform: translateY(-1px);
        }
        
        .btn-archive {
            color: red;
            border: none;
        }
        
        .btn-archive:hover {
            background-color: #e67e22;
            color: white;
            transform: translateY(-1px);
        }
 .container {
            padding-top: 20px; /* Add some top padding to the main container */
        }

        
        .profit-btn-container {
    display: flex;
    /*justify-content: space-between;
    align-items: flex-end;*/
    margin-bottom: 0;
    border-bottom: none;
    /* REMOVE OR CHANGE THIS LINE TO PREVENT SCROLLING */
    overflow-x: visible; /* Change from 'auto' to 'visible' */
    -webkit-overflow-scrolling: touch; /* This is only relevant if overflow is active */
    padding-left: 0;
    padding-right: 0;
    margin-left: 0;
    margin-right: 0;
    padding-bottom: 5px;
    flex-wrap: wrap; /* Add flex-wrap to ensure content wraps instead of scrolling */
    gap: 10px; /* Add a small gap if elements wrap */
}

        /* Group for left-aligned tab buttons */
        .profit-tabs {
            display: flex;
            /* No justify-content here, as items are naturally left-aligned */
            /* Gap between the tab buttons themselves */
            /* Using margin-right on .tab-button handles this, but gap is cleaner */
            gap: 2px; /* Small gap between tab buttons as per your previous style */
        }

        /* Group for right-aligned action buttons */
        .profit-actions {
            display: flex;
            gap: 20px; /* Space between action buttons */
           
        }
        
        .profit-actions .btn-add-profit { /* For "Add Profit Record" */
            color: #0d6efd; /* Bootstrap primary blue text */
            border: 1px solid #0d6efd; /* Blue border */
            padding: 0.5rem 1rem; /* Standard padding */
            border-radius: 0.25rem; /* Slightly rounded corners */
        }
        .profit-actions .btn-add-profit:hover {
            background-color: #0d6efd; /* Blue background on hover */
            color: #fff; /* White text on hover */
        }

        .profit-actions .btn-export-excel { /* For "Export to Excel" */
                background-color: #f2f4f8;
    color: #495057;
    border: 1px solid #e1e5e9;
    padding: 7px 15px;
    border-radius: 8px;
    font-size: 14px;
    display: inline-flex
;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .profit-actions .btn-export-excel:hover {
            background-color: #198754;
            color: #fff;
        }


        /* --- Tab Button Specific Styles --- */
        .tab-button {
            background-color: #e9ecef; /* Light gray for inactive buttons */
            border: 1px solid #dee2e6; /* Border for buttons */
            border-bottom: none; /* Remove bottom border for tab effect */
            outline: none; /* Remove outline on focus for cleaner look */
            cursor: pointer;
            padding: 14px 20px;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
            font-size: 1rem;
            margin-right: 2px; /* Small gap between buttons */
            border-radius: 8px 8px 0 0; /* Rounded top corners */
            flex-shrink: 0; /* Prevent buttons from shrinking */
            text-align: center;
            color: #495057;
            white-space: nowrap; /* Keep button text on one line */
        }

        .tab-button:hover:not(.active-tab-button) { /* Apply hover only if not active */
            background-color: #d6d8db; /* Darker gray on hover */
            color: #333; /* Darker text on hover */
            border-color: #c9cbce; /* Adjust border on hover */
        }

        .tab-button.active-tab-button { /* Using active-tab-button for consistency with JS */
            background-color: #f8f9fa; /* Active button background */
            border-color: #3498db; /* Active button border color */
            border-bottom: 1px solid #ffffff; /* Hide bottom border to merge with content area */
            color: #3498db; /* Active button text color */
            font-weight: bold;
            position: relative; /* For z-index to overlap content border */
            z-index: 1; /* Ensure active tab sits on top of the card border */
        }

        /* --- Card Content Styles --- */
        .card {
            border-top: 1px solid #dee2e6; /* Match inactive tab border color for continuity */
            /* Adjust margin-top to precisely align with the bottom of the tab buttons */
            /* This value might need slight tweaking based on font-size, padding, and border widths */
            margin-top: -1px; /* Overlap the tab buttons' bottom border */
            border-radius: 0.25rem; /* Standard Bootstrap card border-radius */
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 20px;
            width: 100%;
        }
        
        
        /* --- Other existing styles (from your original request) --- */
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 1.25rem;
        }
        .card-header h3 {
            margin-bottom: 0;
            font-size: 1.25rem;
            color: #343a40;
        }
        
        .empty-message {
            text-align: center;
            padding: 50px 0;
            color: #6c757d;
        }
        .empty-message i {
            font-size: 3rem;
            color: #ced4da;
            margin-bottom: 15px;
        }
        .empty-message h5 {
            margin-bottom: 10px;
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
   /* --- NEW CSS FOR DROPDOWN FILTER AND ACTIONS --- */

/* Container for the filter button and its dropdown content */
.filter-dropdown {
    position: relative; /* Crucial for absolute positioning of dropdown content */
    display: inline-block; /* Allows it to sit next to other buttons */
}

/* The main "Filter" button */
.filter-dropdown-btn {
    padding: 8px 12px;
    border: 1px solid #ddd;
    background-color: #f0f2f5;
    color: #555;
    font-size: 15px;
    cursor: pointer;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    z-index: 1; /* Ensure it's above other elements when not open */
}

.filter-dropdown-btn:hover {
    background-color: #e0e2e5;
}

.filter-dropdown-btn i {
    margin-right: 5px;
}

/* The existing time-filter div, now acting as dropdown content */
.filter-dropdown .time-filter {
    display: none; /* Hidden by default */
    position: absolute;
    background-color: #ffffff;
    border-radius: 10px;
    min-width: 200px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 100; /* Ensure it's above everything */
    gap: 8px;
    overflow: hidden;
    top: 100%; /* Position directly below the toggle button */
    right: 0; /* Align to the right of the filter button for dropdown */
    margin-top: 8px; /* Small gap below the button */
    flex-direction: column; /* Stack buttons vertically */
    padding: 15px; /* Remove original padding */
    border: 1px solid #ddd; /* Add a border to the dropdown */
    top: calc(100% + 10px);
}


/* Show the dropdown content */
.filter-dropdown.show .time-filter {
    display: flex; /* Show as flex column */
}

/* Styles for the individual time-filter-btn elements when inside the dropdown */
.filter-dropdown .time-filter .time-filter-btn {
       width: 100%;
    justify-content: flex-start;
    background: #f8f9fa;
    padding: 10px 15px;
    border-radius: 8px;
    box-shadow: none;
    font-size: 14px;
    white-space: nowrap;
    color: #495057;
    font-weight: 500;
    border-color: white!important;
}
 .top-controls-row{
     margin-left: 70%;
     gap:20px
 }
.filter-dropdown .time-filter .time-filter-btn:last-child {
    border-bottom: none; /* No border for the last item */
}

.filter-dropdown .time-filter .time-filter-btn.active {
    background-color: #e6f2fa; /* Light blue background for active dropdown item */
    color: #3498db;
    font-weight: 600;
    box-shadow: none; /* Ensure no extra shadow */
}

/* Adjustments for "Add Profit" and "Export" buttons */
.btn-add-profit-custom {
    background-color: #3498db;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 8px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    white-space: nowrap;
}
.btn-add-profit-custom:hover {
    background-color: #2980b9;
}
.circle-plus {
   display: inline-flex
;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 2px solid white!important;
    color: white!important;
    font-weight: bold;
    font-size: 1rem;
}
.btn-export-excel-custom {
       background-color: #f2f4f8;
    color: #495057;
    border: 1px solid #e1e5e9;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 14px;
    display: inline-flex
;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}
.btn-export-excel-custom:hover {
    background-color: #c0effb;
}



/* --- Custom Date Range Styles (Focus of this issue) --- */
.custom-date-range {
    display: none; /* Hidden by default, controlled by JS */
    /* Position absolute relative to the nearest positioned ancestor, which should be .filter-group.right-aligned-group */
    position: absolute;
    /* Adjust top and right as needed. 'right: 0;' aligns it to the right edge of its parent. */
    /* If you want it aligned with the Filter button, you might need 'left: auto;' or 'right: 0;' */
    /* For the image provided, it looks like it might appear directly under the "Filter" button or the "Custom" button's general area. */
    /* Let's try to align it under the filter dropdown itself or center it if needed. */
    /* For now, keeping previous values that should place it below and to the right of the filter button group. */
    top: calc(100% + 8px); /* 8px below the bottom of the filter-group.right-aligned-group (which contains Filter, Export, Add Profit buttons) */
    right: 0; /* Aligns to the right edge of its parent .filter-group.right-aligned-group */

    background: #ffffff;
    padding: 12px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    align-items: center;
    gap: 8px;
    opacity: 0;
    transform: translateY(10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
    z-index: 10001; /* Highest z-index to ensure it's on top of time-filter and table */
    white-space: nowrap; /* Prevents internal elements from wrapping unexpectedly (e.g., date inputs) */
    border: 1px solid #ddd;
    flex-wrap: wrap; /* Allows date inputs and "to" to wrap on very small screens */
    justify-content: center; /* Centers elements if they wrap */
    min-width: 280px; /* Give it a minimum width to ensure inputs fit well */
    box-sizing: border-box; /* Include padding/border in total width */
}

.custom-date-range.active {
    display: flex;
    opacity: 1;
    transform: translateY(0);
}

.custom-date-range .date-input {
    padding: 8px 10px;
    border: 1px solid #e1e5e9;
    border-radius: 6px;
    font-size: 14px;
    color: #495057;
    background-color: #fff;
    width: 130px; /* Explicit width for date inputs */
    transition: border-color 0.3s ease;
}

.custom-date-range .date-input:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
}

.custom-date-range span {
    font-size: 14px;
    color: #6c757d;
}

.custom-date-range .apply-date-btn {
    padding: 8px 15px;
    border: none;
    border-radius: 6px;
    background-color: #28a745;
    color: white;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.custom-date-range .apply-date-btn:hover {
    background-color: #218838;
    transform: translateY(-1px);
    box-shadow: 0 2px 6px rgba(40, 167, 69, 0.3);



/* Existing general styles (truncated for brevity, include all of yours) */
/* ... your existing CSS ... */

/* Some corrections for previously provided general styles to ensure coherence */
.profit-btn-container .btn {
    border-radius: 0.25rem;
    border-bottom: 1px solid var(--bs-btn-border-color);
    background-color: var(--bs-btn-bg);
    color: var(--bs-btn-color);
    margin-right: 0.5rem;
}
.profit-actions .btn-add-profit { /* For "Add Profit Record" */
    color: #0d6efd;
    border: 1px solid #0d6efd;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
}
.profit-actions .btn-add-profit:hover {
    background-color: #0d6efd;
    color: #fff;
}
.profit-actions .btn-export-excel { /* For "Export to Excel" */
    color: #198754;
    border: 1px solid #198754;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
}
.profit-actions .btn-export-excel:hover {
    background-color: #198754;
    color: #fff;
}
.btn-export { /* This style is probably for your export button outside the new structure */
    background-color: var(--success-color); /* Assuming --success-color is defined */
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
    .time-filter {
        padding: 8px; /* Reduce padding */
    }

    .time-filter-btn {
        font-size: 13px;
        padding: 6px 10px;
    }

    .custom-date-range {
        flex-direction: column; /* Stack vertically */
        align-items: stretch; /* Full width */
        gap: 6px; /* Tighter gap */
        margin-top: 8px;
    }

    .date-input {
        width: 100%; /* Full width */
        margin-bottom: 6px; /* Space between inputs */
    }

    .apply-date-btn {
        width: 100%; /* Full width */
        padding: 6px 12px;
    }

    .custom-date-range > span {
        text-align: center; /* Center "to" text */
    }
}

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .filter-section {
                gap: 15px;
            }
            
            .time-filter-btn {
                width: 100%; /* Full width for each button */
                font-size: 14px;
                padding: 8px 12px;
                text-align: center;
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
                flex-direction: column; /* Stack buttons vertically */
                align-items: stretch; /* Full width for buttons */
                gap: 6px; /* Tighter gap for compactness */
                padding: 10px;
            }

            .custom-date-range {
                position: static; /* Revert to normal flow */
                margin-top: 10px; /* Space above */
                width: 100%; /* Full width */
                flex-wrap: nowrap; /* Keep inputs and button in one line if possible */
                justify-content: space-between; /* Spread elements */
                padding: 10px; /* Match time-filter padding */
                
            }

             .date-input {
                width: 45%; /* Side by side */
                font-size: 13px;
            }

            .apply-date-btn {
                width: auto; /* Natural width */
                padding: 6px 10px;
                font-size: 13px;
            }

            .custom-date-range > span {
                font-size: 13px; /* Match input/button font size */
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
               
           
     
        
  
         <!--changes-->
        
             <div class="container mt-4">
        <div class="profit-btn-container">
            <div class="profit-tabs">
                <button class="tab-button" id="showProfitReports">
                    <i class="fas fa-table me-2"></i>Profit Reports
                </button>
                <button class="tab-button" id="showProfitAnalysis">
                    <i class="fas fa-chart-bar me-2"></i>Profit Analysis
                </button>
                </div>
                  <div class="filter-section">
    <div class="filter-group top-controls-row">
        <div class="plate-filter">
          <!--  <label for="plateNumberSelect" class="filter-label me-2">Truck:</label>-->
          
            <select id="plateNumberSelect" class="form-select">
                <option value="all" selected>All Trucks</option>
                @foreach($plateNumbers as $plateNumber)
                    <option value="{{ $plateNumber }}">{{ $plateNumber }}</option>
                @endforeach
            </select>
        </div>

        <div class="filter-group right-aligned-group">
            <div class="filter-dropdown" id="mainFilterDropdown">
                <button class="filter-dropdown-btn" id="mainFilterButton">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <div class="time-filter" id="timeFilterDropdownContent">
                    <button class="time-filter-btn" id="weeklyFilter">
                        Weekly
                    </button>
                    <button class="time-filter-btn" id="monthlyFilter">
                        Monthly
                    </button>
                    <button class="time-filter-btn" id="yearlyFilter">
                        Annually
                    </button>
                    <button class="time-filter-btn" id="customFilter">
                        <i class="fas fa-cog"></i> Custom
                    </button>
                </div>
           

            <div class="custom-date-range" id="customDateRange">
                <input type="date" id="startDate" class="date-input">
                <span>to</span>
                <input type="date" id="endDate" class="date-input">
                <button class="apply-date-btn" id="applyDateRange">
                    <i class="fas fa-check me-1"></i>Apply
                </button>
            </div>
 </div>
            <div class="profit-actions">
                <button class="btn-export-excel-custom" onclick="exportProfitToExcel()">
                    <i class="fas fa-upload me-2"></i>Export
                </button>
                <button class="btn-add-profit-custom" data-bs-toggle="modal" data-bs-target="#profitModal">
                    <span class="circle-plus">+</span> Add Profit
                </button>
            </div>
            </div>
        </div>
    </div>
    </div>
            </div>

         
        </div>

        <div id="profitReportsContent">
            <div class="card">
               <!-- <div class="card-header">
                    <h3><i class="fas fa-table me-2"></i>Profit Reports</h3>
                </div>-->
                
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
        </div>

        <div id="profitAnalysisContent" style="display: none;">
            <div class="card">
               <!-- <div class="card-header">
                    <h3><i class="fas fa-chart-bar me-2"></i>Profit Analysis</h3>
                </div>-->
                
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="profitChart"></canvas>
                        </div>
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
    <!--added-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

   <script>
    // Global variables accessible throughout the script
    const profitData = @json($profits); // Ensure $profits is passed from your Laravel controller
    const ctx = document.getElementById('profitChart').getContext('2d');
    let profitChart;
    let currentFilter = 'weekly'; // Default to weekly
    let currentPlateFilter = 'all';
    let customDateRange = null;

    // References to the new dropdown elements
    const mainFilterDropdown = document.getElementById('mainFilterDropdown');
    const mainFilterButton = document.getElementById('mainFilterButton');
    const customDateRangeEl = document.getElementById('customDateRange');

    document.addEventListener('DOMContentLoaded', function() {
        // --- Existing Tab Switching Logic ---
        const profitReportsContent = document.getElementById('profitReportsContent');
        const profitAnalysisContent = document.getElementById('profitAnalysisContent');
        const showProfitReportsButton = document.getElementById('showProfitReports');
        const showProfitAnalysisButton = document.getElementById('showProfitAnalysis');

        // Set initial visibility
        profitReportsContent.style.display = 'block';
        profitAnalysisContent.style.display = 'none';

        // Add 'active-tab-button' class to the initially visible button
        showProfitReportsButton.classList.add('active-tab-button');

        // Event listener for "Profit Reports" button
        showProfitReportsButton.addEventListener('click', function() {
            profitReportsContent.style.display = 'block';
            profitAnalysisContent.style.display = 'none';

            // Update active button styling
            showProfitReportsButton.classList.add('active-tab-button');
            showProfitAnalysisButton.classList.remove('active-tab-button');
        });

        // Event listener for "Profit Analysis" button
        showProfitAnalysisButton.addEventListener('click', function() {
            profitReportsContent.style.display = 'none';
            profitAnalysisContent.style.display = 'block';

            // Update active button styling
            showProfitAnalysisButton.classList.add('active-tab-button');
            showProfitReportsButton.classList.remove('active-tab-button');
        });

        // --- Profit Calculation for Modals (Add & Edit) ---
        const incomeInput = document.getElementById('total_income');
        const expensesInput = document.getElementById('total_expenses');
        if (incomeInput && expensesInput) {
            incomeInput.addEventListener('input', calculateProfit);
            expensesInput.addEventListener('input', calculateProfit);
        }

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

        // --- Archive Confirmation with SweetAlert ---
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

        // --- SweetAlert for Session Messages ---
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}'
            });
        @endif

        // --- NEW DROPDOWN FILTER LOGIC (Main Entry Points) ---
        // Toggle filter dropdown visibility
        if (mainFilterButton) { // Ensure button exists before adding listener
            mainFilterButton.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevent document click from immediately closing
                mainFilterDropdown.classList.toggle('show');

                // If opening, ensure custom date range is hidden unless "Custom" is the active filter
                if (mainFilterDropdown.classList.contains('show')) {
                    if (typeof currentFilter === 'undefined' || currentFilter !== 'custom') {
                        customDateRangeEl.classList.remove('active');
                    }
                } else {
                    // If closing the main dropdown, always hide custom date range
                    customDateRangeEl.classList.remove('active');
                }
            });
        }

        // Close dropdown and custom date range when clicking outside
        document.addEventListener('click', function(event) {
            if (mainFilterDropdown && customDateRangeEl) { // Ensure elements exist
                // If the click is not inside the main dropdown AND not inside the custom date range picker
                if (!mainFilterDropdown.contains(event.target) && !customDateRangeEl.contains(event.target)) {
                    mainFilterDropdown.classList.remove('show');
                    customDateRangeEl.classList.remove('active');
                }
            }
        });

        // Initialize with default weekly filter on page load.
        // This should be called after all filter elements and functions are defined.
        setActiveFilter('weekly');
    });

    // --- Filter Functions ---
    function filterByTimePeriod(data, period) {
        const now = new Date();
        const currentDate = new Date(now.getFullYear(), now.getMonth(), now.getDate());

        return data.filter(profit => {
            const profitDate = new Date(profit.date);

            if (period === 'custom' && customDateRange) {
                // Ensure dates are compared without time component for custom range to cover full days
                const startOfDay = new Date(customDateRange.start.getFullYear(), customDateRange.start.getMonth(), customDateRange.start.getDate());
                const endOfDay = new Date(customDateRange.end.getFullYear(), customDateRange.end.getMonth(), customDateRange.end.getDate());
                endOfDay.setHours(23, 59, 59, 999); // Include the whole end day

                return profitDate >= startOfDay && profitDate <= endOfDay;
            }

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
                    return true; // 'all' - no time filter, though 'all' is not an option in the new dropdown
            }
        });
    }

    function filterByPlateNumber(data, plateNumber) {
        if (plateNumber === 'all') return data;
        return data.filter(profit => profit.plate_number === plateNumber);
    }

    function applyFilters() {
        let filteredData = [...profitData];

        // Apply time filter
        filteredData = filterByTimePeriod(filteredData, currentFilter);

        // Apply plate number filter
        filteredData = filterByPlateNumber(filteredData, currentPlateFilter);

        return filteredData;
    }

    // --- Update UI Functions ---
    function updateTableDisplay(filteredData) {
        const rows = document.querySelectorAll('#profitTable tbody tr');
        const visibleIds = filteredData.map(profit => profit.id.toString());

        rows.forEach(row => {
            const rowId = row.getAttribute('data-id');
            row.style.display = visibleIds.includes(rowId) ? '' : 'none';
        });
    }

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
                case 'custom':
                    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                default:
                    return profit.date; // Fallback, though we'll always have a filter
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

    // --- Event Listeners for Filters ---
    document.getElementById('plateNumberSelect').addEventListener('change', function() {
        currentPlateFilter = this.value;
        const filteredData = applyFilters();
        updateTableDisplay(filteredData);
        renderChart(filteredData);
    });

    // Delegating events to the parent dropdown content for Weekly, Monthly, Yearly, Custom buttons
    document.getElementById('timeFilterDropdownContent').addEventListener('click', function(event) {
        const clickedBtn = event.target.closest('.time-filter-btn');
        if (clickedBtn) {
            const id = clickedBtn.id;
            if (id === 'weeklyFilter') {
                setActiveFilter('weekly');
            } else if (id === 'monthlyFilter') {
                setActiveFilter('monthly');
            } else if (id === 'yearlyFilter') {
                setActiveFilter('yearly');
            } else if (id === 'customFilter') {
                setActiveFilter('custom');
            }
        }
    });

    // Apply custom date range
    document.getElementById('applyDateRange').addEventListener('click', function() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        if (!startDate || !endDate) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please select both start and end dates'
            });
            return;
        }

        if (new Date(startDate) > new Date(endDate)) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Start date must be before end date'
            });
            return;
        }

        customDateRange = {
            start: new Date(startDate),
            end: new Date(endDate)
        };

        const filteredData = applyFilters();
        updateTableDisplay(filteredData);
        renderChart(filteredData);

        // Close the custom date range input AND the main filter dropdown after applying
        customDateRangeEl.classList.remove('active');
        mainFilterDropdown.classList.remove('show');
    });

    // --- MODIFIED setActiveFilter function ---
    function setActiveFilter(filter) {
        currentFilter = filter;

        // Remove active class from all filter buttons in the dropdown
        document.querySelectorAll('#timeFilterDropdownContent .time-filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        if (filter === 'custom') {
            customDateRangeEl.classList.add('active'); // Show the custom date range input fields

            // Set default dates (last 7 days from today) if not already set
            const endDate = new Date();
            const startDate = new Date();
            startDate.setDate(startDate.getDate() - 7);

            document.getElementById('startDate').valueAsDate = startDate;
            document.getElementById('endDate').valueAsDate = endDate;

            customDateRange = {
                start: startDate,
                end: endDate
            };

            // Add active class to the custom filter button within the dropdown
            document.getElementById('customFilter').classList.add('active');
            // Do NOT close the main dropdown here, as the user needs to interact with date inputs
        } else {
            customDateRangeEl.classList.remove('active'); // Hide the custom date range input fields
            customDateRange = null; // Reset custom date range

            // Add active class to the selected filter button within the dropdown
            const activeBtn = document.getElementById(filter + 'Filter');
            activeBtn.classList.add('active');

            // Re-apply original active button animation (if desired)
            activeBtn.style.transform = 'scale(1.05)';
            setTimeout(() => {
                activeBtn.style.transform = 'scale(1)';
            }, 200);

            // Apply filters immediately for non-custom selections
            const filteredData = applyFilters();
            updateTableDisplay(filteredData);
            renderChart(filteredData);

            // Close the main filter dropdown after selecting a non-custom filter
            mainFilterDropdown.classList.remove('show');
        }
    }

    // --- Helper Calculation Functions ---
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

    // --- Excel Export Function ---
    function exportProfitToExcel() {
        const filteredData = applyFilters();

        const exportData = filteredData.map(profit => ({
            'Date': profit.date,
            'Plate Number': profit.plate_number,
            'Total Income': profit.total_income,
            'Total Expenses': profit.total_expenses,
            'Total Profit': profit.total_profit
        }));

        const worksheet = XLSX.utils.json_to_sheet(exportData);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Profit Data");

        const now = new Date();
        const formattedDate = now.toISOString().slice(0, 10);
        const formattedTime = now.toTimeString().slice(0, 8).replace(/:/g, '-');
        const filename = `Profit_Reports_${formattedDate}_${formattedTime}.xlsx`;

        XLSX.writeFile(workbook, filename);

        Swal.fire({
            icon: 'success',
            title: 'Export Successful',
            text: `Profit data has been exported to ${filename}`,
            timer: 3000,
            showConfirmButton: false
        });
    }
</script>
</body>
</html>