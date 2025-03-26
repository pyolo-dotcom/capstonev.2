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

        /* Add this to your existing CSS */

        .content {
            margin-left: 270px;
            padding: 20px;
            flex-grow: 1;
            max-width: 100%;
            /* Ensure content doesn't exceed the viewport width */
        }

        .content h1,
        .content h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .content p,
        .content ul {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .content ul {
            padding-left: 20px;
            /* Add indentation for list items */
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 0;
                /* Remove left margin for mobile view */
                padding: 10px;
                /* Add padding for better spacing */
            }

            .content h1 {
                font-size: 20px;
                /* Adjust font size for smaller screens */
            }

            .content h2 {
                font-size: 18px;
                /* Adjust font size for smaller screens */
            }

            .content p,
            .content ul {
                font-size: 14px;
                /* Adjust font size for smaller screens */
            }
        }

        @media (max-width: 480px) {
            .content h1 {
                font-size: 18px;
                /* Further reduce font size for very small screens */
            }

            .content h2 {
                font-size: 16px;
                /* Further reduce font size for very small screens */
            }

            .content p,
            .content ul {
                font-size: 12px;
                /* Further reduce font size for very small screens */
            }
        }
    </style>
</head>

<body>

    <x-drivernavbar />

    <div class="content">
        <h1>Welcome to the System User Manual</h1>
        <p>This guide provides step-by-step instructions for managing delivery records, fuel, and shipments.</p>

        <h2>Delivery Records</h2>
        <p>To add a delivery record, fill in the required details such as date, plate number, trip (one way, two way,
            and door to door), and number of trips.</p>

        <h2>Fuel Management</h2>
        <p>Fuel tracking allows you to log fuel usage per vehicle. Navigate to Fuel Management, enter the fuel amount
            and vehicle ID, then save the entry.</p>

        <h2>Shipment Progress</h2>
        <p>Track your shipments in real-time. Enter the shipment ID to check the status and updates.</p>

        <h2>Support & Contact</h2>
        <p>If you need assistance, contact our support team:</p>
        <ul>
            <li>Email: support@syaservices.com</li>
            <li>Phone: 09123456789</li>
        </ul>

        <h2>Rules and Regulations</h2>
        <p>...</p>
    </div>
</body>

</html>
