<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cargo Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background: #fff;
            color: #2f4156;
            padding: 20px 0;
            position: fixed;
            height: 100%;
        }

               .content {
            margin-left: 260px;
            padding: 30px;
            flex-grow: 1;
            background: linear-gradient(135deg, #f8fafc 0%, #e3f2fd 100%);
            min-height: 100vh;
            width: calc(100vw - 260px);
            max-width: calc(100vw - 260px);
            border-top-left-radius: 25px;
            position: relative;
            overflow: hidden;
        }

       /* .container{
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            background-color: #F0F4F7;
            border: 2px solid #E3EEF7;
            padding: 10px;
            width: 200px;
        }*/
        
      .table-scroll-container {
  max-height: 550px; 
  margin-top: 10px;
  overflow-y: auto;
  position: relative; /* This is crucial for sticky headers to work */
  border: 1px solid #ddd; /* Adds a border to the scrollable area */
  border-radius: 8px; /* Optional: adds rounded corners */
      overflow-x: hidden;

}
        .data-table {
    width: 100%;
    border-collapse: collapse; /* A cleaner look without cell spacing */
    min-width: 800px; /* Adjust this value as needed based on your columns */
    table-layout: fixed; /* Ensures columns don't stretch in an odd way */
}

.data-table th, .data-table td {
  padding: 12px 20px;
  text-align: left; /* or right, depending on your preference */
  border-bottom: 1px solid #ddd;
  word-wrap: break-word;
  vertical-align: middle; /* <-- Add this line for vertical alignment */
}

.data-table th {
  position: sticky;
  top: 0;
  z-index: 10; /* This ensures the header stays on top of the content */
  background-color: #f4f7fa; /* Add a background color to prevent content from showing through */
}
.data-table tbody tr:hover {
    background-color: #f9fafb; /* Subtle hover effect for better user experience */
}

/* Add a line on the left side of the table for a cleaner look */
.data-table {
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
}
.data-table thead {
    border-bottom: 2px solid #ddd;
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
             position: relative;
    
        }
.header-controls h2::after {
    content: '';
    position: absolute;
    bottom: -3px; /* Adjust this to control the distance from the h2 */
    left: 0;
    width: 50px;
    height: 3px;
    background: #1d4ed8;
    transition: width 0.3s ease;
}
        .header-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
            
        }

        .header-controls h2 {
            margin: 0;
            white-space: nowrap;
            flex-shrink: 0;
            padding-bottom: 5px; /* Add some space for the line */
    border-bottom: 3px solid #e0e7ff;
        }
.table-container::-webkit-scrollbar {
    width: 10px;
}
.table-container::-webkit-scrollbar-track {
    background: transparent;
}
.table-container::-webkit-scrollbar-thumb {
    background-color: rgba(220, 220, 220, 0.7); /* Lighter gray, more transparent */
    border-radius: 5px;
}
.table-container::-webkit-scrollbar-thumb:hover {
    background-color: rgba(200, 200, 200, 0.9); /* Slightly darker on hover for contrast */
}

/* Custom scrollbar for Firefox */
.table-container {
    scrollbar-width: thin;
    scrollbar-color: rgba(100, 100, 100, 0.4) transparent;
}

      /* Container for the table */
.table-container {
    width: 100%;
    height: ;
    margin-top: 20px;
    background-color: #ffffff; /* Use a white background */
    padding: 20px; /* Increased padding */
    border-radius: 12px; /* Smooth rounded corners */
    box-shadow: 0 4px 15px rgba(0,0,0,0.05); /* Soft, subtle shadow */
    overflow: hidden;
}

/* Base table styling */
.trip-table {
    width: 100%;
    border-collapse: separate; /* Use separate for border-radius on cells if needed */
    border-spacing: 0;
    min-width: 800px;
}

/* Table header styling */
.trip-table thead th {
    background-color: #f7f9fc; /* A subtle, light header background */
    color: #555555; /* Darker text for readability */
    padding: 16px 20px; /* Generous padding */
    text-align: left;
    font-weight: 600;
    position: sticky;
    top: 0;
    font-size: 13px; /* Slightly larger font size */
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e0e0e0; /* A more defined bottom border */
}

/* Styling for table body */
.trip-table tbody {
    display: table-row-group; /* Ensures the tbody behaves as expected */
}

/* Table data cells */
.trip-table td {
    padding: 8px 20px;
    border-bottom: 1px solid #f0f0f0; /* Lighter border */
    vertical-align: middle;
    color: #444444; /* Improved text color */
    font-size: 12px;
}

/* Dynamic table row styles */
.trip-table tr {
    transition: box-shadow 0.2s ease, transform 0.2s ease, background-color 0.2s ease;
    cursor: pointer;
}



/* Aligning the last column for actions */
.trip-table th:last-child,
.trip-table td:last-child {
    text-align: right; /* Align actions to the right */
    padding-right: 24px;
}

.trip-table th:first-child,
.trip-table td:first-child {
    padding-left: 24px;
}
        
        /* End of new styles */

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

        /* New Styles for Action Buttons */
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
            border-radius: 50%;
            width: 36px;
            height: 36px;
        }

        .actions .edit-btn {
            color: #004aad;
        }

        .actions .edit-btn:hover {
            transform: scale(1.1);
            color: #003d82;
            background-color: #e6f0ff;
        }
        
        .actions .edit-btn:active {
            transform: scale(0.95);
            background-color: #cce0ff;
        }

        .actions .archive-btn {
            color: #dc3545;
        }

        .actions .archive-btn:hover {
            transform: scale(1.1);
            color: #b02a37;
            background-color: #ffe6e6;
        }
        
        .actions .archive-btn:active {
            transform: scale(0.95);
            background-color: #ffcccc;
        }
        /* End of new styles */
        
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
            width: auto;
            min-width: 120px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-position: right 10px center;
            background-size: 10px;
            cursor: pointer;
        }

       .filter-top-row {
    display: flex;
    justify-content: space-between; /* Pushes the search bar to one side and the button group to the other */
    align-items: center; /* Vertically aligns all items */
    margin-bottom: 10px;
    flex-wrap: wrap;
    gap: 15px;
}

.filter-bottom-row {
    display: flex;
    align-items: center;
    gap: 15px; /* Adds space between the buttons/selects */
    flex-wrap: wrap;
}


        .filter-bottom-row {
            justify-content: space-between;
        }

        .spaced-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-bar {
            position: relative;
            width: 300px;
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

        .showing-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .showing-controls span {
            font-size: 16px;
            color: #495057;
        }

        .filter-dropdown-container {
            position: relative;
            display: inline-block;
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
            display: inline-flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .filter-button:hover {
            background-color: #f0f0f0;
        }

        .filter-button i {
            font-size: 16px;
        }

        .filter-dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 220px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 10;
            border-radius: 8px;
            overflow: hidden;
            top: 100%;
            left: 0;
            margin-top: 5px;
        }

        .filter-dropdown-content.show {
            display: block;
        }

        .date-filter {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .date-btn {
            padding: 10px 15px;
            border: none;
            background-color: transparent;
            color: #495057;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: left;
            width: 100%;
            border-radius: 0;
        }

        .date-btn.active {
            background-color: #1f1a5c;
            color: #fff;
        }

        .date-btn:hover {
            background-color: #f1f1f1;
            color: #495057;
        }

        /* Custom Date Range Styles */
        .custom-date-container {
            padding: 10px 15px;
            border-top: 1px solid #eee;
        }

        .date-range-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .date-range-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .date-range-label {
            font-size: 14px;
            color: #495057;
            min-width: 60px;
        }

        .date-range-input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .apply-date-btn {
            width: 100%;
            padding: 8px;
            margin-top: 8px;
            background-color: #1f1a5c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .apply-date-btn:hover {
            background-color: #161245;
        }

        .export-btn {
            background-color: #f2f4f8;
            color: #495057;
            border: 1px solid #e1e5e9;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .export-btn:hover {
            background-color: #e6e9ee;
            color: #333;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        /* New Pagination Styles */
        .pagination-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding: 0px;
         
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
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
            min-width: 100px;
            font-weight: 500;
        }

        .page-btn:hover {
            background-color: #161245;
        }

        .page-btn:disabled {
            background-color: #e1e5e9;
            color: #6c757d;
            cursor: not-allowed;
        }
        /* End of new styles */

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; backdrop-filter: blur(0px); }
            to { opacity: 1; backdrop-filter: blur(8px); }
        }

        .modal-content {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            padding: 0;
            border-radius: 20px;
            width: 90%;
            max-width: 580px;
            box-shadow: 0 25px 50px rgba(31, 26, 92, 0.25),
                        0 0 0 1px rgba(255, 255, 255, 0.1),
                        inset 0 1px 0 rgba(255, 255, 255, 0.6);
            position: relative;
            max-height: 85vh;
            display: flex;
            flex-direction: column;
            transform: scale(0.9);
            animation: modalSlideIn 0.3s ease-out forwards;
            overflow: hidden;
        }

        @keyframes modalSlideIn {
            from { transform: scale(0.9) translateY(-20px); opacity: 0; }
            to { transform: scale(1) translateY(0); opacity: 1; }
        }

        .modal-header {
            background: linear-gradient(135deg, #1f1a5c, #2c3e50);
            color: white;
            padding: 25px 30px;
            border-radius: 20px 20px 0 0;
            margin: 0;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .modal-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255,255,255,0.1), transparent);
            pointer-events: none;
        }
        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            color: white;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 1;
            position: relative;
        }
        .modal-header h2::before {
            content: '\f044';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 1.2rem;
            color: #64b5f6;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }
        .modal-body {
            overflow-y: auto;
            flex-grow: 1;
            padding: 30px;
            background: linear-gradient(to bottom, #ffffff, #f8f9fa);
        }
        .modal-footer {
            padding: 20px 30px 30px;
            border: none;
            margin: 0;
            background: linear-gradient(to top, #f8f9fa, #ffffff);
        }
        .close {
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 28px;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 2;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        .close:hover {
            color: white;
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(90deg);
        }
        .modal-content form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: start;
        }
        .modal-content form > div {
            display: flex;
            flex-direction: column;
        }
        .modal-content label {
            font-weight: 600;
            color: #1f1a5c;
            margin-bottom: 8px;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .modal-content label::before {
            content: '';
            width: 3px;
            height: 16px;
            background: linear-gradient(to bottom, #1f1a5c, #1f1a5c);
            border-radius: 2px;
        }
        .modal-content select,
        .modal-content input {
            padding: 14px 18px;
            border: 2px solid #e8ecf0;
            border-radius: 12px;
            font-size: 15px;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(to bottom, #ffffff, #f8f9fa);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            font-family: 'Poppins', sans-serif;
        }
        .modal-content select:focus,
        .modal-content input:focus {
            border-color: #1f1a5c;
            outline: none;
            box-shadow: 0 0 0 3px rgba(31, 26, 92, 0.1),
                        0 4px 12px rgba(31, 26, 92, 0.15);
            background: #ffffff;
            transform: translateY(-1px);
        }
        .modal-content select:hover,
        .modal-content input:hover {
            border-color: #64b5f6;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-1px);
        }
        /* Full width fields */
        .modal-content form > div:nth-child(6),
        .modal-content form > div:nth-child(7),
        .modal-content form > div:nth-child(10),
        .modal-content form > div:nth-child(11) {
            grid-column: 1 / -1;
        }
        .modal-content button[type="submit"] {
            background: linear-gradient(135deg, #1f1a5c, #2c3e50);
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(31, 26, 92, 0.3),
                        inset 0 1px 0 rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .modal-content button[type="submit"]::before {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .modal-content button[type="submit"]:hover::before {
            opacity: 1;
        }
        .modal-content button[type="submit"]:hover {
            background: linear-gradient(135deg, #161245, #233140);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(31, 26, 92, 0.4),
                        inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        .modal-content button[type="submit"]:active {
            transform: translateY(0);
            box-shadow: 0 4px 15px rgba(31, 26, 92, 0.3),
                        inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }
        /* Responsive styles */
        @media (max-width: 768px) {
            .sidebar {
        display: none; /* Hides the sidebar completely on smaller screens */
    }
    .content {
        margin-left: 0; /* Content now takes up the full width */
        width: 100vw;
        max-width: 100vw;
        padding-top: 20px;
    }
    .header-controls {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }

    .header-controls h2 {
        border-bottom: none; /* Remove the bottom line for a cleaner mobile look */
        padding-bottom: 0;
    }

            .filter-container,
    .filter-top-row,
    .filter-bottom-row {
        flex-direction: column;
        align-items: stretch;
        width: 100%;
    }
.truck-select,
    .search-bar,
    .filter-dropdown-container,
    .export-btn {
        width: 100%;
    }
.filter-button,
    .export-btn {
        justify-content: center;
    }
            .data-table {
        font-size: 14px;
        /* You can add more specific rules here if needed */
    }
            .search-bar {
                width: 100%;
            }
            .showing-controls,
            .showing-controls select {
                flex-direction: column;
        align-items: flex-start;
                width: 100%;
            }
            .filter-dropdown-container {
                width: 100%;
            }
            .filter-button {
                width: 100%;
                justify-content: center;
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
            .modal-content {
        width: 96%;
        max-width: 96%;
        border-radius: 16px;
        max-height: 90vh;
    }
            .modal-header,
    .modal-body,
    .modal-footer {
        padding: 20px;
    }
    .modal-content form {
        grid-template-columns: 1fr;
    }

    .modal-content form > div:nth-child(6),
    .modal-content form > div:nth-child(7),
    .modal-content form > div:nth-child(10),
    .modal-content form > div:nth-child(11) {
        grid-column: auto;
    }
            .close {
                top: 18px;
                right: 22px;
                font-size: 26px;
                width: 38px;
                height: 38px;
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
     
    </div>
  </div>

  <div class="table-container">
      
    <form method="GET" action="{{ route('admin.managetrip') }}" id="filterForm">
      <div class="filter-top-row">
           <div class="search-bar">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Search records...">
      </div>
       <div class="filter-bottom-row">
        <div class="showing-controls">
          <select name="plate_no" class="truck-select" id="plateSelect">
            <option value="All Trucks">All Trucks</option>
            @foreach($plateNumbers as $plate)
            <option value="{{ $plate }}" {{ request('plate_no') == $plate ? 'selected' : '' }}>
              {{ $plate }}
            </option>
            @endforeach
          </select>
        </div>
       
          <div class="filter-dropdown-container">
            <button type="button" class="filter-button" id="filterDropdownBtn">
              <i class="fas fa-filter"></i> Filter
            </button>
            <div class="filter-dropdown-content" id="filterDropdownContent">
              <div class="date-filter">
                @foreach(['weekly' => 'Weekly', 'monthly' => 'Monthly', 'annually' => 'Annually'] as $value => $label)
                <button type="submit" name="filter" value="{{ $value }}"
                  class="date-btn {{ request('filter') == $value ? 'active' : '' }}">
                  {{ $label }}
                </button>
                @endforeach
              </div>
              <div class="custom-date-container">
                <div class="date-range-group">
                  <div class="date-range-row">
                    <span class="date-range-label">From:</span>
                    <input type="date" id="dateFrom" class="date-range-input" name="date_from"
                      value="{{ request('date_from') }}">
                  </div>
                  <div class="date-range-row">
                    <span class="date-range-label">To:</span>
                    <input type="date" id="dateTo" class="date-range-input" name="date_to"
                      value="{{ request('date_to') }}">
                  </div>
                </div>
                <button type="submit" class="apply-date-btn" name="filter" value="custom_range">
                  Apply Date Range
                </button>
              </div>
            </div>
          </div>
     
        <button class="export-btn" onclick="exportToExcel()" id="exportBtn" type="button">
          <i class="fas fa-upload me-2"></i> Export
        </button>
           </div>
      </div>
    </form>

    <div class="table-scroll-container" id="tableScrollContainer">
      <table class="trip-table" id="cargoTable">
        <thead>
          <tr>
            <th>Plate No.</th>
            <th>Date</th>
            <th>EIR No.</th>
            <th>Container Van No.</th>
            <th>Size</th>
            <th>Shipper</th>
            <th>Consignee</th>
            <th>Voyage Vessel</th>
            <th>Voyage No.</th>
            <th>Pickup Location</th>
            <th>Delivery Location</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          @if(request()->has('plate_no') || request()->has('filter') || request()->has('date_from'))
          @forelse($cargos as $cargo)
          <tr>
            <td>{{ $cargo->plate_no }}</td>
            <td>{{ $cargo->created_at->format('Y-m-d') }}</td>
            <td>{{ $cargo->eir_no }}</td>
            <td>{{ $cargo->container_van_no }}</td>
            <td>{{ $cargo->size }}</td>
            <td>{{ $cargo->shipper }}</td>
            <td>{{ $cargo->consignee }}</td>
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
                    '{{ $cargo->shipper }}',
                    '{{ $cargo->consignee }}',
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
            <td colspan="12" class="no-data">
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
</div>
</div>
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-header">
                <h2>Update Trip Record</h2>
            </div>
            <div class="modal-body">
                <form id="updateTripForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="trip_id" name="id">
                    <div>
                        <label for="update_plate_no">Plate No.:</label>
                        <select id="update_plate_no" name="plate_no" required>
                            <option disabled value="">-- Select Plate Number --</option>
                            @foreach(['UVP353', 'TQE262', 'NBB7212', 'APA3309', 'WIE914'] as $plate)
                                <option value="{{ $plate }}">{{ $plate }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="update_eir_no">EIR No.:</label>
                        <input type="text" id="update_eir_no" name="eir_no" required>
                    </div>
                    <div>
                        <label for="update_container_van_no">Container Van No.:</label>
                        <input type="text" id="update_container_van_no" name="container_van_no" required>
                    </div>
                    <div>
                        <label for="update_size">Size:</label>
                        <input type="text" id="update_size" name="size" required>
                    </div>
                    <div>
                        <label for="update_voyage_vessel">Voyage Vessel:</label>
                        <input type="text" id="update_voyage_vessel" name="voyage_vessel" required>
                    </div>
                    <div>
                        <label for="update_voyage_no">Voyage No.:</label>
                        <input type="text" id="update_voyage_no" name="voyage_no" required>
                    </div>
                    <div>
                        <label for="update_shipper">Shipper:</label>
                        <input type="text" id="update_shipper" name="shipper" required>
                    </div>
                
                    <div>
                        <label for="update_consignee">Consignee:</label>
                        <input type="text" id="update_consignee" name="consignee" required>
                    </div>
                    <div>
                        <label for="update_pickup_location">Pickup Location:</label>
                        <input type="text" id="update_pickup_location" name="pickup_location" required>
                    </div>
                    <div>
                        <label for="update_delivery_location">Delivery Location:</label>
                        <input type="text" id="update_delivery_location" name="delivery_location" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="updateTripForm" class="submit-btn">Update Trip Record</button>
            </div>
        </div>
    </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all necessary elements
        const filterForm = document.getElementById('filterForm');
        const plateSelect = document.getElementById('plateSelect');
        const dateBtns = document.querySelectorAll('.date-btn');
        const tableContainer = document.getElementById('tableScrollContainer');
        const initialMessage = document.getElementById('initialMessage');
        const exportBtn = document.getElementById('exportBtn');
        const paginationControls = document.getElementById('paginationControls');
        const searchInput = document.getElementById('searchInput');
        const dateFromInput = document.getElementById('dateFrom');
        const dateToInput = document.getElementById('dateTo');
        const filterDropdownBtn = document.getElementById('filterDropdownBtn');
        const filterDropdownContent = document.getElementById('filterDropdownContent');
        const applyDateRangeBtn = document.querySelector('.apply-date-btn'); // Get the apply button for custom range

        // Function to update the filter button text
        function updateFilterButtonText() {
            let filterText = 'Filter'; // Default text

            // Check if any of the predefined date filters are active
            let activeDateBtn = document.querySelector('.date-btn.active');
            if (activeDateBtn) {
                filterText = activeDateBtn.textContent;
            }

            // Check for custom date range filter
            if (request('filter') === 'custom_range' && request('date_from') && request('date_to')) {
                filterText = 'Custom Date';
            }

            filterDropdownBtn.innerHTML = `<i class="fas fa-filter"></i> ${filterText}`;
        }

        // Helper function to get URL parameter
        function request(name, url = window.location.href) {
            name = name.replace(/[\[\]]/g, '\\$&');
            var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        // Set default date range (today - 7 days to today)
        if (dateFromInput && dateToInput) {
            const today = new Date();
            const sevenDaysAgo = new Date();
            sevenDaysAgo.setDate(today.getDate() - 7);
            
            const formatDate = (date) => date.toISOString().split('T')[0];
            
            if (!dateFromInput.value) dateFromInput.value = formatDate(sevenDaysAgo);
            if (!dateToInput.value) dateToInput.value = formatDate(today);
        }

        // Filter dropdown toggle
        if (filterDropdownBtn && filterDropdownContent) {
            filterDropdownBtn.addEventListener('click', function(event) {
                event.stopPropagation();
                filterDropdownContent.classList.toggle('show');
            });

            document.addEventListener('click', function(event) {
                if (!filterDropdownBtn.contains(event.target) && !filterDropdownContent.contains(event.target)) {
                    filterDropdownContent.classList.remove('show');
                }
            });
        }

        // Check if filters are applied on page load
        const hasFilters = window.location.search.includes('plate_no=') || 
                            window.location.search.includes('filter=') || 
                            window.location.search.includes('date_from=');

        if (hasFilters) {
            initialMessage.style.display = 'none';
            tableContainer.style.display = 'block';
            exportBtn.style.display = 'inline-flex';
            paginationControls.style.display = 'flex';
            initializePagination();
            updateFilterButtonText(); // Update button text on page load if filters are applied
        }

        // Plate select change
        if (plateSelect && filterForm) {
            plateSelect.addEventListener('change', function() {
                filterForm.submit();
            });
        }

        // Date filter buttons
        if (dateBtns.length > 0 && filterForm) {
            dateBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    if (filterDropdownContent) {
                        filterDropdownContent.classList.remove('show');
                    }
                    // No need to manually update text here, as form submission will trigger page load and updateFilterButtonText()
                });
            });
        }

        // Apply Date Range button click
        if (applyDateRangeBtn) {
            applyDateRangeBtn.addEventListener('click', function() {
                if (filterDropdownContent) {
                    filterDropdownContent.classList.remove('show');
                }
                // The form submission from this button will cause a page reload,
                // and updateFilterButtonText() will handle setting the "Custom Date" text.
            });
        }

        // Search functionality
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('#tableBody tr');

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let shouldShow = false;

                    if (cells.length > 1) {
                        for (let i = 0; i < cells.length - 1; i++) {
                            if (cells[i].textContent.toLowerCase().includes(searchTerm)) {
                                shouldShow = true;
                                break;
                            }
                        }
                    } else if (cells.length === 1 && cells[0].textContent.toLowerCase().includes(searchTerm)) {
                        shouldShow = true;
                    }

                    row.style.display = shouldShow ? '' : 'none';
                });

                if (paginationControls && paginationControls.style.display === 'flex') {
                    initializePagination();
                }
            });
        }

        // Pagination
        function initializePagination() {
            const rowsPerPage = 10;
            const tableBody = document.getElementById('tableBody');
            if (!tableBody) return;

            const allTableRows = Array.from(tableBody.querySelectorAll('tr'));
            const rowsCurrentlyVisibleBySearch = allTableRows.filter(row =>
                row.style.display !== 'none'
            );

            const totalRows = rowsCurrentlyVisibleBySearch.length;
            const pageInfo = document.getElementById('pageInfo');
            const prevBtn = document.getElementById('prevPage');
            const nextBtn = document.getElementById('nextPage');

            if (!pageInfo || !prevBtn || !nextBtn) {
                if (paginationControls) paginationControls.style.display = 'none';
                return;
            }

            let currentPage = 1;
            const totalPages = Math.ceil(totalRows / rowsPerPage);

            function updateTableDisplay() {
                allTableRows.forEach(row => {
                    if (row.style.display !== 'none' || searchInput.value === '') {
                        row.style.display = 'none';
                    }
                });

                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                for (let i = start; i < end && i < rowsCurrentlyVisibleBySearch.length; i++) {
                    rowsCurrentlyVisibleBySearch[i].style.display = '';
                }

                const currentStartRow = totalRows === 0 ? 0 : start + 1;
                const currentEndRow = Math.min(end, totalRows);
                pageInfo.textContent = `Showing ${currentStartRow}-${currentEndRow} of ${totalRows} records`;

                prevBtn.disabled = currentPage === 1;
                nextBtn.disabled = currentPage === totalPages || totalPages === 0;

                if (totalRows === 0) {
                    if (paginationControls) paginationControls.style.display = 'none';
                } else {
                    if (paginationControls) paginationControls.style.display = 'flex';
                }
            }

            updateTableDisplay();

            prevBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    updateTableDisplay();
                    const tableScrollContainer = document.querySelector('.table-scroll-container');
                    if (tableScrollContainer) tableScrollContainer.scrollTop = 0;
                }
            });

            nextBtn.addEventListener('click', function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    updateTableDisplay();
                    const tableScrollContainer = document.querySelector('.table-scroll-container');
                    if (tableScrollContainer) tableScrollContainer.scrollTop = 0;
                }
            });
        }
    });

    function exportToExcel() {
        const table = document.getElementById('cargoTable');
        if (!table) {
            console.error("Table with ID 'cargoTable' not found. Cannot export.");
            return;
        }

        const wb = XLSX.utils.book_new();
        const wsData = [];

        // Add headers
        const headers = [];
        if (table.rows.length > 0) {
            for (let cell of table.rows[0].cells) {
                if (cell.textContent.trim() !== 'Actions') {
                    headers.push(cell.textContent.trim());
                }
            }
            wsData.push(headers);
        }

        // Add data rows
        for (let i = 1; i < table.rows.length; i++) {
            const row = table.rows[i];
            if (row.style.display === 'none') {
                continue;
            }
            const rowData = [];
            for (let j = 0; j < row.cells.length - 1; j++) {
                let cellData = row.cells[j].textContent.trim();
                if (j === 1) {
                    const dateValue = new Date(cellData);
                    if (!isNaN(dateValue)) {
                        cellData = dateValue.toISOString().split('T')[0];
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

    function openTripModal(id, plateNo, eirNo, containerVanNo, size, shipper, consignee, voyageVessel, voyageNo, pickupLocation, deliveryLocation) {
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
        const updateShipper = document.getElementById('update_shipper'); if (updateShipper) updateShipper.value = shipper;
        const updateConsignee = document.getElementById('update_consignee'); if (updateConsignee) updateConsignee.value = consignee;
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

    window.onclick = function(event) {
        const updateModal = document.getElementById('updateModal');
        if (updateModal && event.target === updateModal) {
            closeModal();
        }
    }

    // Form submission for update
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
    }

    // Archive confirmation
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

    document.addEventListener('DOMContentLoaded', function() {
        const plateSelect = document.getElementById('plateSelect');
        const filterForm = document.getElementById('filterForm');

        if (plateSelect && plateSelect.value === 'All Trucks' && !window.location.search.includes('plate_no=')) {
            filterForm.submit();
        }
    });
</script>
</body>
</html>