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
        .map-container {
    height: 350px;
    width: 90%;
    margin-left: 53px;
    background-color: #e0e0e0;
    border-radius: 30px;
    margin-bottom: 20px;
}

.driver-details {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
    gap: 20px;
}

.driver {
    background-color: #f9f9f9;
    border: none;
    padding: 10px;
    border-radius: 5px;
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
        <div id="gps-control" class="section">
            <h3>GPS Control</h3>
            <div id="live-trucks">
                <h4>Live Trucks</h4>
                <div class="map-container">
                    <!-- Map-like area with location pins -->
                </div>
                <div class="driver-details">
                    <div class="driver">
                        <p><strong>Name: Reginald Apelado</p></strong>
                        <p>Speed: 50 km/h</p>
                        <p>Coordinates: (40.7542, -34.756)</p>
                    </div>
                    <div class="driver">
                        <p><strong>Name: Piolo Dionisio</p></strong>
                        <p>Speed: 50 km/h</p>
                        <p>Coordinates: (40.7542, -34.756)</p>
                    </div>
                    <div class="driver">
                        <p><strong>Name: John Carlo C.</p></strong>
                        <p>Speed: 50 km/h</p>
                        <p>Coordinates: (40.7542, -34.756)</p>
                    </div>
                    <div class="driver">
                        <p><strong>Name: Noriel Salonga</p></strong>
                        <p>Speed: 50 km/h</p>
                        <p>Coordinates: (40.7542, -34.756)</p>
                    </div>
                    <div class="driver">
                        <p><strong>Name: Jaira Braza</p></strong>
                        <p>Speed: 50 km/h</p>
                        <p>Coordinates: (40.7542, -34.756)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
