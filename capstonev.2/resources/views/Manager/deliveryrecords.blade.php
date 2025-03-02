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
            display: q flex;
            background-color: #f0f0f0
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

        /* Delivery Records */
        #delivery-records {
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: start;
            /* Align items to the top of each grid cell */
        }

        h3 {
            font-size: 20px;
            padding: 0;
            margin: 0;
        }

        #delivery-records .large-card {
            grid-column: span 2;
            text-align: center;
            justify-self: start;
            border-radius: 10px;
        }

        #delivery-records .sections-header {
            width: 100%;
        }

        #delivery-records .card-container {
            display: flex;
            gap: 20px;
            width: 100%;
        }

        /* Style for the individual small cards */
        .card {
            position: relative;
            width: 100%;
            height: 150px;
            background: #ffffff;
            border: none;
            border-radius: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            text-align: center;
            padding-top: 20px;
        }

        /* Place the small cards in the first row */
        #delivery-records .card:nth-child(1) {
            grid-column: 1;
            grid-row: 1;
        }

        #delivery-records .card:nth-child(2) {
            grid-column: 2;
            grid-row: 1;
        }

        #delivery-records .card:nth-child(3) {
            grid-column: 3;
            grid-row: 1;
        }

        /* Style for the Total Trip heading */
        .section-header {
            grid-column: 1 / 4;
            /* Span all three columns */
            grid-row: 2;
            /* Place it in the second row */
            margin-top: 10px;
            text-align: left;
            /* Align text to the left */
        }

        .section-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: normal;
            margin-bottom: -10px;
        }

        .large-card {
            grid-column: 1 / 4;
            grid-row: 3;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-start;
            width: 93%;
            height: 305px;
            padding: 20px;
            background-color: #ffffff;
            margin-top: 15px;
            position: relative;
        }

        .large-card h2 {
            flex: 1;
            margin: 0;
            font-weight: normal;
            text-align: center;
            min-width: 0;
            white-space: nowrap;
        }

        .card-header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 22px;
            color: #2f4156;
        }

        .card h3 {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            margin: 0;
            font-size: 22px;
            font-weight: normal;
        }

        .reset {
            color: red;
            border: none;
            background-color: transparent;
            font-size: 1.2rem;
            position: absolute;
            bottom: 10px;
            right: 10px;
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
        <div id="delivery-records" class="section">
            <div class="sections-header">
                <select class="plate-select" style="
                    font-size: 20px;
                    margin-left: 0;
                    border-radius: 8px;
                    color: #f0f0f0;
                    background-color: #2f4156;
                    margin-bottom: 0;">
                    <option disabled selected id="select">Plate Number</option>
                    <option>12</option>
                    <option>34</option>
                    <option>56</option>
                    <option>78</option>
                    <option>91</option>
                </select>
                <div class="section-header">
                    <h2>Total Counts</h2>
                </div>
            </div>
            <div class="card-container">
                <div class="card">
                    <h3>One Way Trip</h3>
                </div>
                <div class="card">
                    <h3>Round Trip</h3>
                </div>
                <div class="card">
                    <h3>Door To Door Trip</h3>
                </div>
            </div>

            <!-- Add the Total Trip heading here -->
            <div class="section-header" style="margin-bottom: -15px;">
                <h2>Total Trip</h2>
            </div>

            <!-- Your large card -->
            <div class="card-container large-card-container">
                <div class="card large-card">
                    <h2>One Way Trip</h2>
                    <button class="reset">Reset</button>
                </div>
                <div class="card large-card">
                    <h2>Round Trip</h2>
                    <button class="reset">Reset</button>
                </div>
                <div class="card large-card">
                    <h2>Door-To-Door Trip</h2>
                    <button class="reset">Reset</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>