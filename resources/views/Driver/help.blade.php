<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <title>Help & Support</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100%;
        }
        
        .content {
            margin-left: 250px;
            padding: 25px;
            flex-grow: 1;
            background-color: white;
            min-height: 100vh;
        }
        
        .truck-display {
            background: #f1f3f5;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: inline-block;
            font-size: 16px;
            font-weight: 600;
            border: 1px solid #e1e5e9;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .truck-display i {
            margin-right: 12px;
            color: #495057;
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #343a40;
        }

        .help-container {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            border: 1px solid #e9ecef;
        }

        .help-section {
            margin-bottom: 30px;
        }

        .help-section h2 {
            color: #1f1a5c;
            font-size: 1.5rem;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #f1f3f5;
        }

        .help-section p {
            color: #495057;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .help-section ul {
            padding-left: 20px;
            margin-bottom: 15px;
        }

        .help-section ul li {
            margin-bottom: 8px;
            color: #495057;
        }

        .contact-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #1f1a5c;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }
            
            .content {
                margin-left: 0;
                padding: 15px;
            }
            
            .help-container {
                padding: 15px;
            }

            .header-section {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 576px) {
            .help-section h2 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <x-drivernavbar />
    </div>

    <!-- Main Content Area -->
    <div class="content">
        <!-- Header Section -->
        <div class="header-section">
            <div class="truck-display">
                <i class="fas fa-user"></i>
                <span id="assignedTruck">{{ Auth::user()->fullname ?? 'Not assigned' }}</span>
                <input type="hidden" id="plateNumber" value="{{ Auth::user()->truck_id ?? '' }}">
            </div>
        </div>

        <h2 class="section-title">HELP & SUPPORT</h2>
        
        <!-- Help Container -->
        <div class="help-container">
            <div class="help-section">
                <h2>Welcome to the System User Manual</h2>
                <p>This guide provides step-by-step instructions for managing delivery records, fuel, and shipments.</p>
            </div>

            <div class="help-section">
                <h2>Delivery Records</h2>
                <p>To add a delivery record, fill in the required details such as date, plate number, trip (one way, two way, and door to door), and number of trips.</p>
            </div>

            <div class="help-section">
                <h2>Fuel Management</h2>
                <p>Fuel tracking allows you to log fuel usage per vehicle. Navigate to Fuel Management, enter the fuel amount and vehicle ID, then save the entry.</p>
            </div>

            <div class="help-section">
                <h2>Shipment Progress</h2>
                <p>Track your shipments in real-time. Enter the shipment ID to check the status and updates.</p>
            </div>

            <div class="help-section">
                <h2>Support & Contact</h2>
                <p>If you need assistance, contact our support team:</p>
                <div class="contact-info">
                    <ul>
                        <li><i class="fas fa-envelope me-2"></i> Email: support@syaservices.com</li>
                        <li><i class="fas fa-phone me-2"></i> Phone: 09123456789</li>
                        <li><i class="fas fa-clock me-2"></i> Support Hours: 8:00 AM - 5:00 PM, Monday to Friday</li>
                    </ul>
                </div>
            </div>

            <div class="help-section">
                <h2>Rules and Regulations</h2>
                <p>All drivers must adhere to the following rules:</p>
                <ul>
                    <li>Complete daily vehicle inspection reports</li>
                    <li>Follow all traffic laws and regulations</li>
                    <li>Report any accidents or incidents immediately</li>
                    <li>Maintain proper documentation for all shipments</li>
                    <li>Submit fuel receipts and delivery reports on time</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
</body>

</html>