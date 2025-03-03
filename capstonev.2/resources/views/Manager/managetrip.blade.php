<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                <select class="driver-select" style="
                    display: flex;
                    font-size: 17px;
                    border-radius: 8px;
                    color: #f0f0f0;
                    background-color: #2f4156;
                    font-size: 20px;
                    margin-top: 20px;
                    margin-bottom: -11px;">
                    <option disabled selected>Plate Number</option>
                    <option>123</option>
                    <option>456</option>
                </select>
                <div class="datebutton">
                    <button class="date-btn active">Weekly</button>
                    <button class="date-btn">Monthly</button>
                    <button class="date-btn">Annually</button>
                </div>
            </div>

            <div class="table-container">
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
                        <tr>
                            <td>TRP-001</td>
                            <td>2025-01-20</td>
                            <td>LKGJHB32</td>
                            <td>WDBD238</td>
                            <td>DC20</td>
                            <td>Century Pacific Food</td>
                            <td>LCDM</td>
                            <td>2345</td>
                            <td>CYVTA</td>
                            <td>MNLP16</td>
                            <td class="actions">
                                <button class="edit-btn" onclick="openTripModal('TRP-001', '2025-01-20', 'LKGJHB32', 'WDBD238', 'DC20', 'Century Pacific Food', 'LCDM', '2345', 'CYVTA', 'MNLP16')">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>TRP-002</td>
                            <td>2025-02-15</td>
                            <td>LKGJHB32</td>
                            <td>WDBD238</td>
                            <td>DC20</td>
                            <td>Century Pacific Food</td>
                            <td>LCDM</td>
                            <td>2345</td>
                            <td>CYVTA</td>
                            <td>MNLP16</td>
                            <td class="actions">
                                <button class="edit-btn" onclick="openTripModal('TRP-002', '2025-02-15', 'LKGJHB32', 'WDBD238', 'DC20', 'Century Pacific Food', 'LCDM', '2345', 'CYVTA', 'MNLP16')">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Repeat for other rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('Manager.modals.tripmodal')
</body>

</html>