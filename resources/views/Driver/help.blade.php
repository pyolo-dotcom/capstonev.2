<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <title>Help & Support</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
       * {
        font-family: 'Poppins';

    margin: 0;
    padding: 0;
    box-sizing: border-box;
   
}

body {
    display: flex;
    min-height: 100vh;
    background-color: #f4f6f8;
  
}

/* Sidebar */
.sidebar {
    width: 250px;
    background: #2f4156;
    color: white;
    padding: 20px 0;
    position: fixed;
    height: 100%;
}

/* Main Content */
.content {
    margin-left: 250px;
    padding: 30px;
    flex-grow: 1;
    background-color: #ffffff;
    min-height: 100vh;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    box-shadow: -4px 0 12px rgba(0, 0, 0, 0.05);
}

/* Header Section */
.truck-display {
    display: inline-flex;       /* Make it shrink to fit content */
    align-items: center;
    gap: 8px;
    padding: 6px 12px;
    border-radius: 6px;
    background-color: #f1f1f1;
    font-weight: 500;
    width: fit-content;         /* Key: only take as much space as needed */
    max-width: 100%;            /* don't stretch full width */
    margin-bottom: 15px;
}

.truck-display i {
    margin-right: 10px;
}

/* Section Title */
.section-title {
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 2rem;
    color: #0f172a;
}

/* Help Container */
.help-container {
    background: #ffffff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
}

/* Help Sections */
.help-section {
    margin-bottom: 40px;
}

.help-section h2 {
    color: #1d4ed8;
    font-size: 1.4rem;
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 2px solid #e0e7ff;
    font-weight: 600;
}

.help-section p {
    color: #334155;
    line-height: 1.7;
    margin-bottom: 15px;
    font-size: 15px;
}

.help-section ul {
    padding-left: 20px;
    margin-bottom: 15px;
}

.help-section ul li {
    margin-bottom: 10px;
    color: #475569;
    font-size: 15px;
    position: relative;
}

.help-section ul li::before {
    content: "•";
    color: #3b82f6;
    font-size: 18px;
    position: absolute;
    left: -15px;
    top: 1px;
}

.rules-section {
    padding: 20px 24px;
    background-color: #fdfbea;
    border-left: 5px solid #facc15;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    color: #78350f;
    font-family: 'Poppins', sans-serif;
}

.rules-section h5 {
    margin-bottom: 10px;
    font-size: 18px;
    color: #b45309;
}

.rules-section ul {
    list-style-type: disc;
    padding-left: 20px;
    margin: 10px 0 0 0;
}

.rules-section li {
    margin-bottom: 8px;
    font-size: 15px;
}


/* Contact Info Box */
.contact-support {
    padding: 20px 24px;
    background-color: #ecf5ff;
    border-left: 5px solid #3b82f6;
    border-radius: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    color: #1e3a8a;
    font-family: 'Poppins', sans-serif;
}

.contact-support h5 {
    margin-bottom: 10px;
    font-size: 18px;
    color: #1d4ed8;
}

.contact-support ul {
    list-style-type: none;
    padding-left: 0;
    margin: 10px 0 0 0;
}

.contact-support li {
    margin-bottom: 8px;
    font-size: 15px;
}


/* Responsive Adjustments */
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        position: relative;
        height: auto;
    }

    .content {
        margin-left: 0;
        padding: 20px;
    }

    .help-container {
        padding: 20px;
    }
}

@media (max-width: 576px) {
    .help-section h2 {
        font-size: 1.2rem;
    }

    .section-title {
        font-size: 1.3rem;
    }
}

    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <x-drivernavbar />
    </div>

    <!-- Content -->
    <div class="content">
    <h1 class="section-title">Help & Support</h1>

    <!-- Header -->
    <div class="truck-display">
        <i class="fas fa-user"></i>
        <span>{{ Auth::user()->fullname ?? 'Not assigned' }}</span>
    </div>

    <!-- Help Cards -->
    <div class="row">
        <!-- Card 1: Trip Records -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Trip Countings</h5>
                    <p class="card-text">
                        Keep track of your total trips, including one-way, round-trip, and door-to-door deliveries.
                    </p>
                    <div class="read-more-content d-none">
                        <p>
                            You can easily add your trips whenever you complete a delivery. The total count updates in real-time and is visible to the Admin and Operations Manager, who use this data to calculate your pay.
                        </p>
                        <p><strong>How to:</strong></p>
                        <ol>
                            <li>Click the "Add Trip" button on your dashboard.</li>
                            <li>Select the trip type (one-way, round-trip, or door-to-door).</li>
                            <li>Enter the number of trips completed.</li>
                            <li>Submit to update your total trip counts.</li>
                        </ol>
                    </div>
                    <button class="btn btn-sm btn-link p-0" onclick="toggleReadMore(this)">Read More</button>
                </div>
            </div>
        </div>


        <!-- Card 2: Fuel Management -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Fuel Management</h5>
                    <p class="card-text">Track your fuel usage and see simple visual analytics of your fuel consumption patterns.</p>
                    <div class="read-more-content d-none">
                        <p>Access reports on your truck’s fuel consumption over time with the visual chart showing how much fuel is used on different trips and periods, helping you monitor efficiency and identify any unusual fuel usage patterns that might need attention.</p>
                    </div>
                    <button class="btn btn-sm btn-link p-0" onclick="toggleReadMore(this)">Read More</button>
                </div>
            </div>
        </div>

        <!-- Card 3: SHipment progress -->
        <div class="col-md-6 mb-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Shipment Progress</h5>
            <p class="card-text">
                This feature lets you fill out shipment details like cargo description, destination, and delivery date, then generate a unique QR code for that shipment.
            </p>
            <div class="read-more-content d-none">
                <p>
                    To start a shipment, fill in the form with all necessary cargo details. When you submit, the system generates a QR code linked to this shipment. Share this QR with the Operations Manager so they can scan and update delivery statuses efficiently.
                </p>
                <p><strong>How to:</strong></p>
                <ol>
                    <li>Go to the Shipment Progress page.</li>
                    <li>Fill out the shipment form with cargo information and delivery details.</li>
                    <li>Submit the form to generate a QR code.</li>
                    <li>Provide the QR code to the Operations Manager for scanning and tracking.</li>
                </ol>
            </div>
            <button class="btn btn-sm btn-link p-0" onclick="toggleReadMore(this)">Read More</button>
        </div>
    </div>
</div>


        <!-- Card 4: User Roles -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">User Roles</h5>
                    <p class="card-text">Understand what each user can and cannot do.</p>
                    <div class="read-more-content d-none">
                        <ul class="mb-1">
                            <li><strong>Admin:</strong> Full access to trucks location, reports, users, settings</li>
                            <li><strong>Operations Manager:</strong> Full access to trucks location, manage trip logs and QR scans</li>
                            <li><strong>Driver:</strong> View/update trips, fuel logs, and profile</li>
                        </ul>
                    </div>
                    <button class="btn btn-sm btn-link p-0" onclick="toggleReadMore(this)">Read More</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Info -->
    <div class="contact-support mb-4">
        <h5>Contact Support</h5>
        <p>If you need assistance, contact our support team:</p>
        <ul>
            <li>📧<strong>Email:</strong> support@syaservices.com</li>
            <li>📱<strong>Phone:</strong> 09123456789</li>
            <li>🕗<strong>Support Hours:</strong> 8:00 AM - 5:00 PM, Monday to Friday</li>
        </ul>
    </div>

    <!-- Rules -->
    <!-- Rules and Regulations -->
    <div class="rules-section">
    <h5>Rules and Regulations</h5>
    <ul>
        <li>Complete daily vehicle inspection reports</li>
        <li>Follow all traffic laws and regulations</li>
        <li>Report any accidents or incidents immediately</li>
        <li>Maintain proper documentation for all shipments</li>
        <li>Submit fuel receipts and delivery reports on time</li>
    </ul>
    </div>

</div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleReadMore(button) {
        const content = button.previousElementSibling;
        content.classList.toggle("d-none");
        button.innerText = content.classList.contains("d-none") ? "Read More" : "Show Less";
    }

</script>
</body>
</html>
