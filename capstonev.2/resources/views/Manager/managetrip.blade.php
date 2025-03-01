<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Menu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display:q flex;
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
    width: 95%;
    margin-left: 20px;
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

.actions .edit-btn {
    color: black; /* Color for edit icon */
}

.actions .delete-btn {
    color: red; /* Color for delete icon */
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
            <x-managernavbar/>
        </ul>
    </div>
    <div class="content">
        <div id="trip-records" class="section">
            <div class="content-header">
                <h2>View and Update Trip Records</h2>
                <select class="driver-select" style="
                    font-size: 17px;
                    margin-left: 16px;
                    border-radius: 8px;">
                    <option disabled selected>-- Plate Number --</option>
                    <option>123</option>
                    <option>456</option>
                </select>
            </div>

            <div class="table-container">
                <table class="trip-table">
                    <thead>
                        <tr>
                            <th>Trip ID</th>
                            <th>Date</th>
                            <th>Start Location</th>
                            <th>End Location</th>
                            <th>Kilometers</th>
                            <th>Fuel Consumed</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>TRP-001</td>
                            <td>2025-01-20</td>
                            <td>Station A</td>
                            <td>Station B</td>
                            <td>120</td>
                            <td>30</td>
                            <td class="actions">
                                <button class="edit-btn"
                                    onclick="openTripModal('TRP-001', '2025-01-20', 'Station A', 'Station B', 120, 30)">
                                </button>
                                <button class="delete-btn"><i class="bi bi-trash"></i> </button>
                            </td>
                        </tr>
                        <tr>
                            <td>TRP-002</td>
                            <td>2025-02-15</td>
                            <td>Station C</td>
                            <td>Station D</td>
                            <td>80</td>
                            <td>20</td>
                            <td class="actions">
                                <button class="edit-btn"
                                    onclick="openTripModal('TRP-002', '2025-02-15', 'Station C', 'Station D', 80, 20)">
                                </button>
                                <button class="delete-btn"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Repeat for other rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
