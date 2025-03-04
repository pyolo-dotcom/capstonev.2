<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <a href="{{ route('manager.managetrip') }}">Manage Trips</a>
    <title>Sidebar Menu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: q flex;
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
        }

        .table-container {
            margin-top: 20px;
            overflow: auto;
        }

        .trip-table {
            width: 100%;
            margin-left: 0;
            border-collapse: collapse;
            border-radius: 20px;
        }

        .trip-table th,
        .trip-table td {
            border: none;
            padding: 10px;
            text-align: center;
        }

        .trip-table th {
            background-color: #dadada;
        }

        .actions button {
            background: none;
            border: none;
            cursor: pointer;
        }

        .datebutton {
            flex-grow: 1;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .date-btn {
            margin-top: -20px;
            border: none;
            font-size: 22px;
            color: black;
            background-color: transparent;
            padding: 5px;
            border-radius: 15px;
            width: 10%;
        }

        .date-btn:hover,
        .date-btn:active {
            background-color: #004aad;
            color: #f0f0f0;
        }

        .date-btn.active {
        background-color: #004aad;
        color: #f0f0f0;
    }

        .actions .edit-btn {
            color: black;
            /* Color for edit icon */
        }

        .actions .delete-btn {
            color: red;
            /* Color for delete icon */
        }

        .trip-table th:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .trip-table th:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
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
        <div id="trip-records" class="section">
            <div class="content-header">
                <h2>View and Update Trip Records</h2>
                <form method="GET" action="{{ route('manager.managetrip') }}">
    <!-- Plate Number Dropdown -->
    <select name="plate_no" onchange="this.form.submit()" style="
        display: flex;
        font-size: 17px;
        border-radius: 8px;
        color: #f0f0f0;
        background-color: #2f4156;
        font-size: 20px;
        margin-top: 20px;
        margin-bottom: -11px;">
        <option value="">All Trucks</option>
        <option value="UVP 353" {{ request('plate_no') == 'UVP 353' ? 'selected' : '' }}>UVP 353</option>
        <option value="TQE 262" {{ request('plate_no') == 'TQE 262' ? 'selected' : '' }}>TQE 262</option>
        <option value="NBB 7212" {{ request('plate_no') == 'NBB 7212' ? 'selected' : '' }}>NBB 7212</option>
        <option value="APA 3309" {{ request('plate_no') == 'APA 3309' ? 'selected' : '' }}>APA 3309</option>
        <option value="WIE 914" {{ request('plate_no') == 'WIE 914' ? 'selected' : '' }}>WIE 914</option>
    </select>

    <!-- Date Filter Buttons -->
    <div class="datebutton">
        <button type="submit" name="filter" value="weekly" class="date-btn {{ request('filter') == 'weekly' ? 'active' : '' }}">Weekly</button>
        <button type="submit" name="filter" value="monthly" class="date-btn {{ request('filter') == 'monthly' ? 'active' : '' }}">Monthly</button>
        <button type="submit" name="filter" value="annually" class="date-btn {{ request('filter') == 'annually' ? 'active' : '' }}">Annually</button>
    </div>
</form>

<table class="trip-table">
    <thead>
        <tr>
            <th>Plate No.</th>
            <th>Date</th>
            <th>EIR No.</th>
            <th>Container Van No.</th>
            <th>Size</th>
            <th>Shipper/Consignee</th>
            <th>Voyage Vessel</th>
            <th>No.</th>
            <th>Pickup Location</th>
            <th>Delivery Location</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cargos as $cargo)
            <tr>
                <td>{{ $cargo->plate_no }}</td>
                <td class="trip-date">{{ $cargo->created_at->format('Y-m-d') }}</td>
                <td>{{ $cargo->eir_no }}</td>
                <td>{{ $cargo->container_van_no }}</td>
                <td>{{ $cargo->size }}</td>
                <td>{{ $cargo->shipper_consignee }}</td>
                <td>{{ $cargo->voyage_vessel }}</td>
                <td>{{ $cargo->voyage_no }}</td>
                <td>{{ $cargo->pickup_location }}</td>
                <td>{{ $cargo->delivery_location }}</td>
                <td class="actions">
                    <!-- Edit Button -->
                    <button class="edit-btn"
                        onclick="openTripModal('{{ $cargo->id }}', '{{ $cargo->created_at }}', '{{ $cargo->eir_no }}', '{{ $cargo->container_van_no }}', '{{ $cargo->size }}', '{{ $cargo->shipper_consignee }}', '{{ $cargo->voyage_vessel }}', '{{ $cargo->voyage_no }}', '{{ $cargo->pickup_location }}', '{{ $cargo->delivery_location }}')">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    <!-- Archive Button -->
                    <form action="{{ route('trip.archive', $cargo->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="archive-btn">Archive</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
            </div>
        </div>
    </div>
    @include('Manager.modals.tripmodal')
    <script src="{{ asset('js/manager.js') }}"></script>
</body>
</html>