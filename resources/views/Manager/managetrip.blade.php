<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Add SheetJS library for Excel export -->
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

        /* Original Sidebar Styles */
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

        /* Content Area Styles */
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
            overflow: auto;
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

        .trip-table th:first-child {
            border-top-left-radius: 8px;
        }

        .trip-table th:last-child {
            border-top-right-radius: 8px;
        }

        .trip-table tr:last-child td:first-child {
            border-bottom-left-radius: 8px;
        }

        .trip-table tr:last-child td:last-child {
            border-bottom-right-radius: 8px;
        }

        /* Actions Column Styles */
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
            display: flex;
            align-items: center;
            justify-content: center;
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
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.2s;
        }

        .actions .archive-btn:hover {
            transform: scale(1.1);
            color: #b02a37;
        }

        /* Filter Controls */
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
            transition: all 0.3s;
        }

        .truck-select:hover {
            background-color: #1a2a3a;
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
            transition: all 0.3s;
        }

        .date-btn:hover,
        .date-btn.active {
            background-color: #004aad;
            color: #fff;
        }

        /* Export Button */
        .export-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 15px;
        }

        .export-btn:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #6c757d;
            font-style: italic;
        }

        .action-form {
            display: inline;
            margin: 0;
            padding: 0;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .content {
                margin-left: 0;
            }
            
            .filter-container {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .date-filter {
                width: 100%;
                justify-content: space-between;
            }
            
            .date-btn {
                flex-grow: 1;
                text-align: center;
            }

            .actions {
                flex-direction: column;
                gap: 8px;
            }
        }
    </style>
</head>

<body>
    <!-- Original Sidebar -->
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
            <form method="GET" action="{{ route('manager.managetrip') }}">
                <div class="filter-container">
                    <select name="plate_no" onchange="this.form.submit()" class="truck-select">
                    <option disabled selected>-- Plate Number --</option>
                        <option value="">All Trucks</option>
                        <option value="UVP 353" {{ request('plate_no') == 'UVP 353' ? 'selected' : '' }}>UVP 353</option>
                        <option value="TQE 262" {{ request('plate_no') == 'TQE 262' ? 'selected' : '' }}>TQE 262</option>
                        <option value="NBB 7212" {{ request('plate_no') == 'NBB 7212' ? 'selected' : '' }}>NBB 7212</option>
                        <option value="APA 3309" {{ request('plate_no') == 'APA 3309' ? 'selected' : '' }}>APA 3309</option>
                        <option value="WIE 914" {{ request('plate_no') == 'WIE 914' ? 'selected' : '' }}>WIE 914</option>
                    </select>

                    <div class="date-filter">
                        <button type="submit" name="filter" value="weekly" class="date-btn {{ request('filter') == 'weekly' ? 'active' : '' }}">Weekly</button>
                        <button type="submit" name="filter" value="monthly" class="date-btn {{ request('filter') == 'monthly' ? 'active' : '' }}">Monthly</button>
                        <button type="submit" name="filter" value="annually" class="date-btn {{ request('filter') == 'annually' ? 'active' : '' }}">Annually</button>
                    </div>
                </div>
            </form>

            <button class="export-btn" onclick="exportToExcel()">
                <i class="fas fa-file-excel"></i> Export to Excel
            </button>

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
                <tbody>
    @if(request()->has('plate_no') || request()->has('filter'))
        @if($cargos->count() > 0)
            @foreach ($cargos as $cargo)
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
                        <button class="edit-btn"
                            onclick="openTripModal('{{ $cargo->id }}', '{{ $cargo->created_at }}', '{{ $cargo->eir_no }}', '{{ $cargo->container_van_no }}', '{{ $cargo->size }}', '{{ $cargo->shipper_consignee }}', '{{ $cargo->voyage_vessel }}', '{{ $cargo->voyage_no }}', '{{ $cargo->pickup_location }}', '{{ $cargo->delivery_location }}')">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>

                        <form action="{{ route('trip.archive', $cargo->id) }}" method="POST" class="action-form">
                            @csrf
                            <button type="submit" class="archive-btn" title="Archive">
                                <i class="fas fa-archive"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="11" class="no-data">No cargo records found</td>
            </tr>
        @endif
    @else
        <tr>
            <td colspan="11" class="no-data">Please select a filter to display data</td>
        </tr>
    @endif
</tbody>    
            </table>
        </div>
    </div>
    @include('Manager.modals.tripmodal')
    <script src="{{ asset('js/manager.js') }}"></script>
    
    <script>
        function exportToExcel() {
            // Clone the table to avoid modifying the original
            const table = document.getElementById('cargoTable');
            const clone = table.cloneNode(true);
            
            // Remove the Actions column (last column)
            const rows = clone.getElementsByTagName('tr');
            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].cells;
                if (cells.length > 0) {
                    rows[i].deleteCell(cells.length - 1); // Remove last cell (Actions)
                }
            }
            
            // Create a workbook from the modified table
            const wb = XLSX.utils.table_to_book(clone, {sheet: "Cargo Data"});
            
            // Generate a file name with current date
            const fileName = `Cargo_Data_${new Date().toISOString().slice(0, 10)}.xlsx`;
            
            // Export the workbook
            XLSX.writeFile(wb, fileName);
        }
    </script>
</body>
</html>