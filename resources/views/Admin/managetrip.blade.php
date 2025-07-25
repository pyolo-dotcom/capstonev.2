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
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
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
            padding: 25px;
            flex-grow: 1;
            background-color: white;
            min-height: 100vh;
        }

  /* General Layout */
body {
    font-family: 'Inter', sans-serif; /* Assuming a font similar to the image */
    background-color: #f2f4f8; /* Light background for the whole page */
    margin: 0;
    padding: 0;
}

.content {
    margin-left: 250px; /* Assuming a sidebar, adjust if not present */
    padding: 25px;
    flex-grow: 1;
    background-color: white;
    min-height: 100vh;
}

.content-header {
    background: none;
    padding: 5px;
    border-radius: 8px;
    box-shadow: none;
    margin-bottom: 20px; /* Adjusted margin */
}

.content-header h2 {
    color: #1f1a5c;
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
}

/* New wrapper to organize top controls */
.top-controls-wrapper {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap; /* Allows wrapping on smaller screens */
    gap: 15px; /* Space between the main groups */
}

/* Group for "Plate No:" label and dropdown */
/* This now acts like the "Showing entries" part in the image */
.truck-select-label-group {
    display: flex;
    align-items: center;
    gap: 8px; /* Space between label and select */
    white-space: nowrap; /* Prevent label/select from wrapping */
}
.truck-label {
    font-size: 14px; /* Matches "Showing" text size */
    color: #555; /* Darker grey */
    font-weight: 500;
}
.truck-select {
    padding: 8px 12px; /* Adjusted padding */
    border: 1px solid #e0e0e0; /* Lighter border */
    border-radius: 8px; /* Rounded corners */
    font-size: 14px; /* Smaller font */
    color: #333;
    background-color: #fcfcfc; /* Very light background */
    width: 90px; /* Smaller width for "10" */
    appearance: none; /* Removes default select arrow */
     /* Custom arrow icon */
    background-repeat: no-repeat;
    background-position: right 8px center;
    background-size: 8px; /* Smaller arrow */
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05); /* Subtle shadow */
}
/* Your original .date-filter-and-export-group styles - IMPORTANT: must have position: relative; */
.date-filter-and-export-group {
    display: flex;
    align-items: center;
    gap: 15px; /* Space between filter buttons group and export button */
    position: relative; /* This is CRUCIAL for the absolute positioning of .time-filter */
}

/* NEW: Styles for the main "Filter" toggle button */
.filter-toggle-button { /* This is the new class for the toggle button */
    background-color: #007bff; /* Primary blue for main filter button */
    color: white;
    border: 1px solid #007bff;
    padding: 8px 15px;
    border-radius: 8px;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 2px 5px rgba(0, 123, 255, 0.2);
    white-space: nowrap; /* Prevent button text from wrapping */
}

.filter-toggle-button:hover {
    background-color: #0056b3;
    border-color: #0056b3;
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
}

.filter-toggle-button.active { /* Style when dropdown is open */
    background-color: #0056b3;
    border-color: #0056b3;
}

.filter-toggle-button i {
    color: #ffff; /* Icon color for the main Filter button */
}

/* CORRECTED & MERGED: Your original .time-filter styles + dropdown properties */
.time-filter {
    /* Your original styles for .time-filter (fully included): */
    gap: 5px; /* Smaller gap between individual buttons for a more compact look */
    background: #f8f9fa; /* Light background for the entire group */
    padding: 4px; /* Padding inside the group */
    border-radius: 8px; /* Rounded corners for the group */
    border: 1px solid #e0e0e0; /* Subtle border for the group */
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.03); /* Inset shadow for the group */
     
    top: calc(100% + 10px);
    /* NEW DROPDOWN PROPERTIES (merged with original styles): */
    display: none; /* Hides it by default. JS will change this to 'flex' when toggled */
    position: absolute; /* Positions it relative to its closest 'position: relative;' ancestor */
    z-index: 100; /* Ensures it appears above other content */
    top: calc(100% + 10px); /* Positions it below the date-filter-and-export-group (adjust 10px if needed) */
    right:10%!important; /* Aligns to the left of the date-filter-and-export-group */
    min-width: 350px; /* Ensures enough width for the buttons to stay horizontal */
    flex-wrap: wrap; /* Allows the buttons to wrap to the next line if the width is too small */
    justify-content: flex-start; /* Aligns buttons to the start within the dropdown */
    
}

/* Styles for individual filter buttons (date-btn) - UNCHANGED from your provided CSS */
.date-btn {
    background: #f2f4f8!important;
    padding: 7px 12px;
    border: none;
    background: none;
    box-shadow: none;
    color: #495057;
    font-size: 13px;
    cursor: pointer;
    transition: background 0.2s ease-in-out, color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border-radius: 6px;
    font-weight: 500;
}

/* Active/Hover states for individual filter buttons - UNCHANGED from your provided CSS */
.date-btn.active {
    background: #e6f0ff;
    color: #007bff;
    box-shadow: 0 1px 3px rgba(0, 123, 255, 0.1);
}

.date-btn:not(.active):hover {
    background-color: #f0f0f0;
    color: #333;
}

/* Specific styling for the 'Custom' date button - UNCHANGED from your provided CSS */
.date-btn.custom-date-btn {
    color: #6c757d;
}

.date-btn.custom-date-btn:hover {
    background-color: #f0f0f0;
}

/* Ensure controls-row-top-image has position relative too if it contains elements that need absolute positioning relative to it */
.controls-row-top-image {
    position: relative; /* Keep this to ensure any absolute children are positioned correctly */
    /* ... other existing styles ... */
}
/* Export Button */
.export-btn-wrapper {
    /* No margin-top needed here as it's part of the flex container */
}

.export-btn {
    background-color: #f2f4f8; /* Light gray background, similar to the image's export button */
    color: #495057; /* Darker text for better contrast */
    border: 1px solid #e1e5e9; /* Subtle border */
    padding: 7px 15px; /* Adjusted padding */
    border-radius: 8px; /* Rounded corners */
    font-size: 14px; /* Font size matching search button */
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); /* Subtle shadow */
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

/* Bottom Controls Row (Search Bar) */
.bottom-controls-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 15px;
}

/* Search Bar */
.search-bar-wrapper {
    /* No margin-top needed here as it's part of the flex container */
}

.search-bar {
    position: relative;
    width: 300px; /* Matches width in image */
}

.search-bar input {
    width: 100%;
    padding: 9px 15px 9px 40px; /* Adjusted padding for icon */
    border: 1px solid #e1e5e9; /* Subtle border */
    border-radius: 8px; /* Matches other rounded elements */
    font-size: 14px;
    transition: all 0.3s;
    background-color: #fcfcfc; /* Light background */
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); /* Subtle shadow */
}

.search-bar input:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    outline: none;
}

.search-bar i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 15px; /* Slightly larger icon */
}

/* Table Styles */
.table-scroll-container {
    max-height: 500px; /* Kept from original */
    overflow-y: auto;
    margin-top: 15px;
    border: 1px solid #e0e0e0; /* Subtle border around the table container */
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); /* More prominent shadow for the table container */
    background-color: #fff; /* White background for the table area */
}

.trip-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.trip-table th {
    background-color: #f8f9fa; /* Light gray header background */
    color: #6c757d; /* Darker gray text */
    padding: 12px 15px;
    text-align: left;
    font-weight: 600; /* Bolder font for headers */
    position: sticky;
    top: 0;
    font-size: 12px; /* Smaller font for headers */
    text-transform: uppercase; /* Uppercase headers */
    letter-spacing: 0.5px;
    border-bottom: 1px solid #e1e5e9; /* Separator for header */
}

.trip-table th:first-child {
    border-top-left-radius: 8px; /* Rounded corners for first header cell */
}

.trip-table th:last-child {
    border-top-right-radius: 8px; /* Rounded corners for last header cell */
}


.trip-table td {
    padding: 10px 15px; /* Slightly less padding for rows */
    border-bottom: 1px solid #e9ecef; /* Lighter border for rows */
    vertical-align: middle;
    color: #495057;
    font-size: 13px; /* Slightly smaller font for table data */
}

.trip-table tr:last-child td {
    border-bottom: none; /* No border for the last row */
}

.trip-table tr:hover td {
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
    width: 30px; /* Square buttons */
    padding: 0;
    margin: 0;
    border-radius: 4px; /* Slightly rounded for actions */
    transition: all 0.2s;
}

.trip-table td:last-child {
    padding: 0;
    vertical-align: middle;
}

.actions button {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 14px; /* Smaller icon size */
}

.actions form {
    margin: 0;
    padding: 0;
    display: inline-flex;
    height: 100%;
}

.actions .edit-btn {
    color: #007bff; /* Blue for edit */
}

.actions .edit-btn:hover {
    background-color: #e6f0ff; /* Light blue background on hover */
    transform: scale(1.05);
}

.actions .archive-btn {
    color: #dc3545; /* Red for archive */
}

.actions .archive-btn:hover {
    background-color: #ffe6e6; /* Light red background on hover */
    transform: scale(1.05);
}

/* No data and initial message */
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
    font-size: 16px; /* Slightly smaller than original for image match */
    background-color: #f8f9fa; /* Light background for the message area */
    border-radius: 8px;
    margin-top: 15px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
}

/* Pagination Controls */
.pagination-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px; /* Increased margin */
    padding: 10px 0;
    border-top: 1px solid #e9ecef; /* Separator above pagination */
    padding-top: 15px;
}

.page-info {
    font-size: 13px; /* Smaller font for info */
    color: #6c757d;
}

.page-buttons {
    display: flex;
    gap: 8px; /* Slightly smaller gap between buttons */
}

.page-btn {
    padding: 6px 12px; /* Adjusted padding */
    background-color: #f8f9fa; /* Light background */
    color: #495057; /* Darker text */
    border: 1px solid #e1e5e9; /* Subtle border */
    border-radius: 6px; /* Rounded corners */
    cursor: pointer;
    font-size: 13px; /* Smaller font */
    transition: all 0.2s;
    font-weight: 500;
}

.page-btn:hover:not(:disabled) {
    background-color: #e9ecef; /* Slightly darker on hover */
    color: #333;
    border-color: #d1d5da;
}

.page-btn:disabled {
    background-color: #f1f3f5;
    color: #adb5bd;
    cursor: not-allowed;
    border-color: #e9ecef;
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
         <div class="bottom-controls-row">
        <h2><i class="fas fa-route me-2"></i>View and Update Trip Records</h2>
         
            <div class="search-bar-wrapper">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search records...">
                </div>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.managetrip') }}" id="filterForm">
        <div class="top-controls-wrapper">
            <div class="truck-select-label-group">
                <label for="plateSelect" class="truck-label">Plate No:</label>
                <select name="plate_no" class="truck-select" id="plateSelect">
                    <option value="All Trucks">All Trucks</option>
                    @foreach($plateNumbers as $plate)
                        <option value="{{ $plate }}" {{ request('plate_no') == $plate ? 'selected' : '' }}>
                            {{ $plate }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="date-filter-and-export-group">
            <button type="button" class="date-btn filter-toggle-button" id="toggleDateFilterButton">
                <i class="fas fa-filter"></i> Filter
            </button>

            <div class="time-filter">
                <button type="submit" name="filter" value="weekly" class="date-btn {{ request('filter') == 'weekly' ? 'active' : '' }}"> Weekly
                </button>
                <button type="submit" name="filter" value="monthly" class="date-btn {{ request('filter') == 'monthly' ? 'active' : '' }}">
                        Monthly
                </button>
                <button type="submit" name="filter" value="yearly" class="date-btn {{ request('filter') == 'yearly' ? 'active' : '' }}">
                        Yearly
                </button>
                <button type="button" class="date-btn custom-date-btn"> <i class="fas fa-cog"></i> Custom
                </button>
            </div>

            <div class="export-btn-wrapper">
                <button class="export-btn export-btn-image" onclick="exportToExcel()" id="exportBtn" type="button">
                    <i class="fas fa-upload"></i> Export
                </button>
            </div>
        </div>
     <input type="hidden" name="start_date" id="hiddenStartDate">
        <input type="hidden" name="end_date" id="hiddenEndDate">
        <input type="hidden" name="filter" id="hiddenFilterType">
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

    <div id="initialMessage" class="initial-message">
        Please select a plate number or date filter to display cargo records
    </div>

    <div class="pagination-controls" id="paginationControls">
        <div class="page-info" id="pageInfo">Showing 1-10 of 0 records</div>
        <div class="page-buttons">
            <button class="page-btn" id="prevPage" disabled>Previous</button>
            <button class="page-btn" id="nextPage" disabled>Next</button>
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
    // Global variable to store all original table rows
    let allTableRows = [];

    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        const plateSelect = document.getElementById('plateSelect');

        // IMPORTANT: Select all .date-btn elements *within* the .time-filter div
        const dateBtns = document.querySelectorAll('.time-filter .date-btn');

        const tableContainer = document.getElementById('tableScrollContainer');
        const initialMessage = document.getElementById('initialMessage');
        const exportBtn = document.getElementById('exportBtn');
        const paginationControls = document.getElementById('paginationControls');
        const searchInput = document.getElementById('searchInput');

        // Elements for custom date picker
        // IMPORTANT: Select the 'Custom' button by its class within .time-filter
        const customFilterToggle = document.querySelector('.time-filter .custom-date-btn'); // Using .time-filter class as per your script
        const datePickerModal = document.getElementById('datePickerModal');
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');
        const cancelDateFilterBtn = document.getElementById('cancelDateFilter');
        const applyDateFilterBtn = document.getElementById('applyDateFilter');

        // Hidden inputs for custom date range
        const hiddenStartDateInput = document.getElementById('hiddenStartDate');
        const hiddenEndDateInput = document.getElementById('hiddenEndDate');
        const hiddenFilterTypeInput = document.getElementById('hiddenFilterType');

        // NEW: Elements for the main filter dropdown toggle
        const toggleDateFilterButton = document.getElementById('toggleDateFilterButton');
        // IMPORTANT: Select the .time-filter div (which is your dropdown content) by its class
        const filterDropdownContent = document.querySelector('.time-filter'); // Using .time-filter class as per your script


        // --- DEBUGGING HELP FOR "CANNOT DROP DOWN" ---
        console.log("toggleDateFilterButton element:", toggleDateFilterButton);
        console.log("filterDropdownContent element:", filterDropdownContent);
        // If either of these logs "null", it means the element with that ID/class is not found in your HTML.
        // Make sure your HTML has an element with id="toggleDateFilterButton" and a div with class="time-filter".
        // Also check your CSS for `.time-filter` to ensure it's not permanently hidden by a conflicting rule.
        // --- END DEBUGGING HELP ---


        // Capture all table rows once when the DOM is loaded
        const tableBody = document.getElementById('tableBody');
        if (tableBody) {
            allTableRows = Array.from(tableBody.querySelectorAll('tr'));
        }

        // Check if filters are already applied (on page reload)
        const hasFilters = window.location.search.includes('plate_no=') ||
                             window.location.search.includes('filter=');

        if (hasFilters) {
            initialMessage.style.display = 'none';
            tableContainer.style.display = 'block';
            exportBtn.style.display = 'inline-flex';
            paginationControls.style.display = 'flex';
            // On initial load with filters, initialize pagination with existing (server-filtered) rows.
            initializePagination(allTableRows);
        } else {
            // Initial pagination on page load with all rows if no server-side filters
            initializePagination(allTableRows);
        }

        // Search input event listener - MODIFIED FOR FUNCTIONALITY
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const filteredRows = allTableRows.filter(row => {
                const cells = row.querySelectorAll('td');
                let shouldShow = false;
                // Loop through cells, excluding the last one (assuming it's 'Actions')
                for (let i = 0; i < cells.length - 1; i++) {
                    if (cells[i].textContent.toLowerCase().includes(searchTerm)) {
                        shouldShow = true;
                        break;
                    }
                }
                return shouldShow;
            });

            // Now, re-initialize pagination with the *filtered* rows
            initializePagination(filteredRows);

            // Update initial message/table visibility based on search
            if (searchTerm.length > 0 && filteredRows.length > 0) {
                 initialMessage.style.display = 'none';
                 tableContainer.style.display = 'block';
                 exportBtn.style.display = 'inline-flex';
                 paginationControls.style.display = 'flex'; // Ensure pagination is visible if results
            } else if (searchTerm.length > 0 && filteredRows.length === 0) {
                 initialMessage.style.display = 'block';
                 initialMessage.textContent = 'No records found matching your search.';
                 tableContainer.style.display = 'none';
                 exportBtn.style.display = 'none';
                 paginationControls.style.display = 'none';
            } else if (searchTerm.length === 0 && !hasFilters) {
                // If search cleared and no other server-side filters
                initialMessage.style.display = 'block';
                initialMessage.textContent = 'Please use the filter options or search bar to view records.';
                tableContainer.style.display = 'none';
                exportBtn.style.display = 'none';
                paginationControls.style.display = 'none';
            } else {
                // If search cleared but other server-side filters are active, restore normal view
                initialMessage.style.display = 'none';
                tableContainer.style.display = 'block';
                exportBtn.style.display = 'inline-flex';
                paginationControls.style.display = 'flex';
            }
        });


        // NEW: Toggle main filter dropdown
        if (toggleDateFilterButton) { // Check if element exists before adding listener
            toggleDateFilterButton.addEventListener('click', function() {
                if (filterDropdownContent) { // Check if dropdown content element exists
                    filterDropdownContent.style.display = filterDropdownContent.style.display === 'flex' ? 'none' : 'flex';
                    this.classList.toggle('active');
                }
                // Ensure Custom Date modal is closed if the filter dropdown is opened
                if (datePickerModal && datePickerModal.style.display === 'flex') {
                    datePickerModal.style.display = 'none';
                }
            });
        }


        // Event listeners for filter changes (Plate No)
        plateSelect.addEventListener('change', function() {
            hiddenStartDateInput.value = '';
            hiddenEndDateInput.value = '';
            hiddenFilterTypeInput.value = '';
            filterForm.submit(); // Submitting the form will reload the page with new server-side filters
        });

        dateBtns.forEach(btn => {
            // Use a more robust check to ensure it's the specific custom button
            if (btn === customFilterToggle) { // Direct comparison of elements
                btn.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent default form submission
                    if (filterDropdownContent) {
                        filterDropdownContent.style.display = 'none'; // Close main filter dropdown
                    }
                    if (toggleDateFilterButton) {
                        toggleDateFilterButton.classList.remove('active'); // Remove active class from main button
                    }
                    if (datePickerModal) {
                        datePickerModal.style.display = 'flex'; // Show custom date modal
                    }
                });
            } else {
                // For Weekly, Monthly, Yearly buttons
                btn.addEventListener('click', function() {
                    hiddenStartDateInput.value = '';
                    hiddenEndDateInput.value = '';
                    hiddenFilterTypeInput.value = this.value;
                    filterForm.submit(); // Submitting the form will reload the page with new server-side filters
                    if (filterDropdownContent) {
                        filterDropdownContent.style.display = 'none'; // Close main filter dropdown after selection
                    }
                    if (toggleDateFilterButton) {
                        toggleDateFilterButton.classList.remove('active'); // Remove active class from main button
                    }
                });
            }
        });

        // Handle Custom Date Picker Actions (UNCHANGED logic)
        cancelDateFilterBtn.addEventListener('click', function() {
            if (datePickerModal) datePickerModal.style.display = 'none';
            startDateInput.value = '';
            endDateInput.value = '';
        });

        applyDateFilterBtn.addEventListener('click', function() {
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;

            if (startDate && endDate) {
                hiddenStartDateInput.value = startDate;
                hiddenEndDateInput.value = endDate;
                hiddenFilterTypeInput.value = 'custom';
                filterForm.submit(); // Submitting the form will reload the page with new server-side filters
                if (datePickerModal) datePickerModal.style.display = 'none';
            } else {
                Swal.fire({
                    title: 'Missing Dates!',
                    text: 'Please select both start and end dates for the custom filter.',
                    icon: 'warning',
                    confirmButtonColor: '#3085d6'
                });
            }
        });

        // Close dropdowns/modals when clicking outside (UPDATED)
        window.onclick = function(event) {
            // Check if click is outside the toggle button AND outside the dropdown content
            // AND outside the custom filter toggle button (if it's not part of the main dropdown logic)
            const isClickOutsideToggle = toggleDateFilterButton && !toggleDateFilterButton.contains(event.target);
            const isClickOutsideDropdown = filterDropdownContent && !filterDropdownContent.contains(event.target);
            const isClickOutsideCustomToggle = customFilterToggle && !customFilterToggle.contains(event.target); // Assuming customFilterToggle might also be a trigger

            if (isClickOutsideToggle && isClickOutsideDropdown && isClickOutsideCustomToggle) {
                 if (filterDropdownContent && filterDropdownContent.style.display === 'flex') {
                    filterDropdownContent.style.display = 'none';
                    if (toggleDateFilterButton) toggleDateFilterButton.classList.remove('active');
                }
            }

            // Existing modal close logic
            if (datePickerModal && event.target === datePickerModal) {
                datePickerModal.style.display = 'none';
            }
            if (document.getElementById('updateModal') && event.target === document.getElementById('updateModal')) {
                 closeModal();
            }
        }
    }); // End DOMContentLoaded


    // --- GLOBAL PAGINATION AND MODAL FUNCTIONS (DEFINED OUTSIDE DOMContentLoaded) ---

    // Modified initializePagination function to accept an array of rows to paginate
    function initializePagination(rowsToPaginate = []) { // Default to empty array if no rows are passed
        const rowsPerPage = 10;
        const tableBody = document.getElementById('tableBody');
        const paginationControls = document.getElementById('paginationControls'); // Get it here for scope

        // The `rows` variable for this specific pagination instance
        const rows = rowsToPaginate.length > 0 ? rowsToPaginate : allTableRows;

        const totalRows = rows.length;
        const pageInfo = document.getElementById('pageInfo');
        const prevBtn = document.getElementById('prevPage');
        const nextBtn = document.getElementById('nextPage');

        // Check if elements exist
        if (!tableBody || !paginationControls || !pageInfo || !prevBtn || !nextBtn) {
            console.warn("Pagination elements not found. Pagination will not initialize.");
            return;
        }

        let currentPage = 1;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        function updateTable() {
            // 1. Hide ALL original table rows to ensure a clean slate
            allTableRows.forEach(row => {
                row.style.display = 'none';
            });

            // 2. Display only the rows for the current page from the `rows` array (which are already filtered by search)
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            for (let i = start; i < end && i < rows.length; i++) {
                if (rows[i]) rows[i].style.display = '';
            }

            pageInfo.textContent = `Showing ${Math.min(start + 1, totalRows)}-${Math.min(end, totalRows)} of ${totalRows} records`;
            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages;

            // Handle no results
            if (totalRows === 0) {
                paginationControls.style.display = 'none';
                pageInfo.textContent = 'No records found.'; // Display message under table
            } else {
                paginationControls.style.display = 'flex'; // Or original display type
            }
        }
        updateTable(); // Call updateTable immediately to display the first page

        // Event listeners for pagination buttons - ATTACHED ONCE AND MANAGED
        // Using custom flags to prevent multiple listeners if initializePagination is called multiple times
        if (!prevBtn._paginationListenerAttached) {
            prevBtn._paginationListenerAttached = true;
            prevBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    updateTable();
                    document.querySelector('.table-scroll-container').scrollTop = 0;
                }
            });
        }

        if (!nextBtn._paginationListenerAttached) {
            nextBtn._paginationListenerAttached = true;
            nextBtn.addEventListener('click', function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    updateTable();
                    document.querySelector('.table-scroll-container').scrollTop = 0;
                }
            });
        }
    }


    // Export to Excel Function (MODIFIED to export only visible rows after filter/search)
    function exportToExcel() {
        const table = document.getElementById('cargoTable');
        const wb = XLSX.utils.book_new();
        const wsData = [];
        const headers = [];

        // Get headers from the first row, excluding 'Actions'
        if (table.rows.length > 0) {
            for (let cell of table.rows[0].cells) {
                if (cell.textContent.trim() !== 'Actions') {
                    headers.push(cell.textContent.trim());
                }
            }
            wsData.push(headers);
        }

        // Iterate through all original rows, but only add the ones that are currently visible
        allTableRows.forEach(row => {
            if (row.style.display !== 'none') { // Check if the row is currently visible
                const rowData = [];
                // Iterate through cells, excluding the last one (Actions)
                for (let j = 0; j < row.cells.length - 1; j++) {
                    let cellData = row.cells[j].textContent.trim();
                    // Special handling for date column (if index 1 is date)
                    if (j === 1) { // Assuming the second column (index 1) is your date
                        const dateValue = new Date(cellData);
                        if (!isNaN(dateValue)) {
                            cellData = dateValue.toISOString().split('T')[0];
                        }
                    }
                    rowData.push(cellData);
                }
                wsData.push(rowData);
            }
        });

        const ws = XLSX.utils.aoa_to_sheet(wsData);
        XLSX.utils.book_append_sheet(wb, ws, 'Cargo Records');
        XLSX.writeFile(wb, 'cargo_records.xlsx');
    }

    // Modal Functions (UNCHANGED)
    function openTripModal(id, plateNo, eirNo, containerVanNo, size, shipperConsignee, voyageVessel, voyageNo, pickupLocation, deliveryLocation) {
        document.getElementById('trip_id').value = id;
        const plateSelect = document.getElementById('update_plate_no');
        Array.from(plateSelect.options).forEach(option => {
            option.selected = option.value === plateNo;
        });
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

    document.getElementById('updateTripForm').addEventListener('submit', function(e) {
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