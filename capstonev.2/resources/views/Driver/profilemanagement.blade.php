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
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Sidebar Menu</h2>
        <ul>
            <x-drivernavbar/>
        </ul>
    </div>
    <div class="content">
        <div class="profile-container">
            <!-- Left Side: Profile Picture & Personal Information -->
            <div class="profile-left">
                <div class="profile-picture-holder">
                    <button class="profile-button">
                        <img src="https://via.placeholder.com/150" alt="Profile Picture" class="profile-picture">
                    </button>
                </div>
                <div class="driver-name">
                    <h2>Reginald Apellado</h2>
                    <p>Driver's name</p>
                </div>
                <div class="personal-info">
                    <h2>Personal Information</h2>
                    <p><strong>Birthdate:</strong> March 19, 1995</p>
                    <p><strong>Gender:</strong> Male</p>
                    <p><strong>Contact Number:</strong> 09123456789</p>
                    <p><strong>Email:</strong> apellado@gmail.com</p>
                    <p><strong>Address:</strong> Cabanatuan, Nueva Ecija</p>
                </div>
            </div>

            <!-- Right Side: License Information -->
            <div class="info-right">
                <div class="license-info">
                    <h2>License Information</h2>
                    <p><strong>Driver's License Number:</strong> D123456789</p>
                    <p><strong>License Expiry Date:</strong> April 10, 2026</p>
                    <p><strong>License Type:</strong> Professional</p>
                    <p><strong>Issued By:</strong> Land Transportation Office</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
