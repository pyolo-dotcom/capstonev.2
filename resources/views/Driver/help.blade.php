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
    background: #e0f2fe;
    color: #0369a1;
    padding: 14px 22px;
    border-radius: 12px;
    margin-bottom: 25px;
    margin-left:40px;
    display: inline-flex;
    align-items: center;
    font-size: 16px;
    font-weight: 600;
    border-left: 6px solid #0284c7;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
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

/* Contact Info Box */
.contact-info {
    background: #f1f5f9;
    padding: 18px 22px;
    border-radius: 12px;
    border-left: 5px solid #1e40af;
}

.contact-info li {
    margin-bottom: 10px;
    color: #1e293b;
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
        <!-- Header -->
        <div class="truck-display">
            <i class="fas fa-user"></i>
            <span>{{ Auth::user()->fullname ?? 'Not assigned' }}</span>
            <input type="hidden" id="plateNumber" value="{{ Auth::user()->truck_id ?? '' }}">
        </div>

        <h1 class="section-title">Help & Support</h1>

        <!-- Accordion Sections -->
        <div class="accordion" id="helpAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingIntro">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIntro">
                        <i class="fas fa-book me-2"></i> System User Manual
                    </button>
                </h2>
                <div id="collapseIntro" class="accordion-collapse collapse show" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        This guide provides step-by-step instructions for managing delivery records, fuel, and shipments.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingDelivery">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDelivery">
                        <i class="fas fa-truck me-2"></i> Delivery Records
                    </button>
                </h2>
                <div id="collapseDelivery" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        To add a delivery record, fill in the required details such as date, plate number, trip (one way, two way, or door to door), and number of trips.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFuel">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFuel">
                        <i class="fas fa-gas-pump me-2"></i> Fuel Management
                    </button>
                </h2>
                <div id="collapseFuel" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        Log fuel usage by entering the fuel amount and vehicle ID under the Fuel Management section, then save the entry.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingShipment">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShipment">
                        <i class="fas fa-shipping-fast me-2"></i> Shipment Progress
                    </button>
                </h2>
                <div id="collapseShipment" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        Track shipments in real-time by entering the shipment ID to check the status and updates.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSupport">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSupport">
                        <i class="fas fa-headset me-2"></i> Support & Contact
                    </button>
                </h2>
                <div id="collapseSupport" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        <p>If you need assistance, contact our support team:</p>
                        <div class="contact-info">
                            <ul class="mb-0">
                                <li><i class="fas fa-envelope me-2"></i>Email: support@syaservices.com</li>
                                <li><i class="fas fa-phone me-2"></i>Phone: 09123456789</li>
                                <li><i class="fas fa-clock me-2"></i>Support Hours: 8:00 AM - 5:00 PM, Mon–Fri</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingRules">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRules">
                        <i class="fas fa-gavel me-2"></i> Rules & Regulations
                    </button>
                </h2>
                <div id="collapseRules" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
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
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
