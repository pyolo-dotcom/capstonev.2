<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Trip Records</title>
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
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
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <x-navbar/>
        </ul>
    </div>
    <div class="main-content" id="main-content">
        <div id="trip-records" class="section" style="display: grid;">
            <div class="content-header">
                <h2>View and Update Trip Records
                <div class="fuel-tab">
                    <button class="fuel-tabs-btn active">Weekly</button>
                    <button class="fuel-tabs-btn">Monthly</button>
                    <button class="fuel-tabs-btn">Yearly</button>
                </div>
                </h2>
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
                    <thead>
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
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="delete-btn" onclick="openDeleteModal()"><i
                                        class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>TRP-002</td>
                            <td>2025-02-15</td>
                            <td>Station C</td>
                            <td>Station D</td>
                            <td>150</td>
                            <td>40</td>
                            <td class="actions">
                                <button class="edit-btn"
                                    onclick="openTripModal('TRP-002', '2025-02-15', 'Station C', 'Station D', 150, 40)">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="delete-btn" onclick="openDeleteModal()"><i
                                        class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Repeat for other rows as needed -->
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
</body>
</html>
