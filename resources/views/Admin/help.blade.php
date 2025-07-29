<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <title>Help & Support</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
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
        background: linear-gradient(135deg, #f4f6f8, #e9ecef);
    }

    .sidebar {
        width: 250px;
        background: linear-gradient(145deg, #2c3e50, #34495e);
        color: white;
        padding: 20px 0;
        position: fixed;
        height: 100%;
        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
    }

    .content {
        margin-left: 250px;
        padding: 30px;
        flex-grow: 1;
        background-color: #ffffff;
        min-height: 100vh;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        box-shadow: -6px 0 20px rgba(0, 0, 0, 0.08);
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 2.5rem;
        color: #2c3e50;
        border-bottom: 3px solid #e0e7ff;
        padding-bottom: 10px;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 50px;
        height: 3px;
        background: #1d4ed8;
        transition: width 0.3s ease;
    }

    .help-container {
        background: #ffffff;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
    }

    .help-section {
        margin-bottom: 50px;
    }

    .help-section h2 {
        color: #1d4ed8;
        font-size: 1.5rem;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e0e7ff;
        font-weight: 600;
        position: relative;
    }

    .help-section h2::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 30px;
        height: 2px;
        background: #1d4ed8;
    }

    .help-section p,
    .help-section ul li,
    .help-section ol li {
        color: #334155;
        line-height: 1.8;
        font-size: 16px;
    }

    .help-section ul,
    .help-section ol {
        padding-left: 25px;
        margin-bottom: 20px;
    }

    .card {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 12px;
    }

    .card-text {
        color: #495057;
        font-size: 15px;
        line-height: 1.6;
    }

    .read-more-content {
        margin-top: 15px;
    }

    .btn-link {
        color: #1d4ed8;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s ease;
    }

    .btn-link:hover {
        color: #1e40af;
        text-decoration: underline;
    }

    .contact-support {
        padding: 25px 30px;
        background: linear-gradient(135deg, #edf4fc, #e4ecfe);
        border-left: 6px solid #3b82f6;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        color: #1e3a8a;
        font-family: 'Poppins', sans-serif;
        margin-top: 40px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .contact-support:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    }

    .contact-support h5 {
        margin-bottom: 15px;
        font-size: 1.2rem;
        color: #1d4ed8;
        font-weight: 600;
    }

    .contact-support ul {
        list-style-type: none;
        padding-left: 0;
        margin: 15px 0 0 0;
    }

    .contact-support li {
        margin-bottom: 12px;
        font-size: 16px;
    }

    .rules-section {
        padding: 25px 30px;
        background: linear-gradient(135deg, #fdfbea, #fef3c7);
        border-left: 6px solid #facc15;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        color: #78350f;
        font-family: 'Poppins', sans-serif;
        margin-top: 40px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .rules-section:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    }

    .rules-section h5 {
        margin-bottom: 15px;
        font-size: 1.2rem;
        color: #b45309;
        font-weight: 600;
    }

    .rules-section ul {
        list-style-type: disc;
        padding-left: 25px;
        margin: 15px 0 0 0;
    }

    .rules-section li {
        margin-bottom: 12px;
        font-size: 16px;
    }

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

        .section-title {
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }

        .help-container {
            padding: 20px;
            border-radius: 15px;
        }

        .card {
            margin-bottom: 15px;
        }

        .contact-support, .rules-section {
            margin-top: 30px;
            padding: 20px;
        }
    }

    @media (max-width: 576px) {
        .content {
            padding: 15px;
        }

        .section-title {
            font-size: 1.3rem;
        }

        .help-section h2 {
            font-size: 1.3rem;
        }

        .card-title {
            font-size: 1rem;
        }

        .card-text, .contact-support li, .rules-section li {
            font-size: 14px;
        }

        .contact-support h5, .rules-section h5 {
            font-size: 1.1rem;
        }
    }
</style>
</head>

<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <x-navbar />
    </div>

    <!-- Main Content Area -->
    <div class="content">
        <h1 class="section-title">Help & Support</h1>

        <div class="help-container">
            <!-- Help Sections -->
            <section class="help-section">
                <div class="row">
                    <!-- Trip Countings -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Trip Countings</h5>
                                <p class="card-text">Monitor and manage trip submissions across all drivers, with full control over logs and filters.</p>
                                <div class="read-more-content d-none">
                                    <p>The Trip Countings page allows Operations Managers to view the total number of one-way, round-trip, and door-to-door trips submitted by all drivers. You can filter records by truck plate number for clearer tracking. A Reset button is available to clear weekly records and prepare for the next cycle.</p>
                                    <p><strong>How to Use:</strong> Navigate to Trip Countings > Use the filters by plate number > Click "Add Trip" to log entries or "Reset" to clear the data weekly.</p>
                                </div>
                                <button class="btn btn-sm btn-link p-0" onclick="toggleReadMore(this)">Read More</button>
                            </div>
                        </div>
                    </div>

                    <!-- Manage Trip Records -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Manage Trip Records</h5>
                                <p class="card-text">View, filter, and update all trip records, including scanned QR cargo entries.</p>
                                <div class="read-more-content d-none">
                                    <p>This module contains all trip data submitted by drivers. Operations Managers can filter by plate number or set date filters (weekly, monthly, annually), and search specific records for efficiency. Cargo details from scanned QR codes are also stored here for reference and verification.</p>
                                    <p><strong>How to Use:</strong> Go to Manage Trip Records > Apply filters or use search > Click on any entry to update details.</p>
                                </div>
                                <button class="btn btn-sm btn-link p-0" onclick="toggleReadMore(this)">Read More</button>
                            </div>
                        </div>
                    </div>

                    <!-- GPS Control -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">GPS Control</h5>
                                <p class="card-text">Track trucks in real-time with interactive map and truck detail overlays.</p>
                                <div class="read-more-content d-none">
                                    <p>GPS Control enables the real-time monitoring of all trucks. Each truck icon on the map shows details such as driver name, truck ID, plate number, license, location, distance, and speed. The Focus button helps zoom in on a specific truck, while Reset clears the trip's distance and computes fuel usage after setting the fuel price.</p>
                                    <p><strong>How to Use:</strong> Open GPS Control > Click on a truck icon to view details > Use Focus to locate > Input fuel price > Click Reset to compute and clear records.</p>
                                </div>
                                <button class="btn btn-sm btn-link p-0" onclick="toggleReadMore(this)">Read More</button>
                            </div>
                        </div>
                    </div>

                    <!-- QR Code Scanner -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">QR Code Scanner</h5>
                                <p class="card-text">Scan QR codes generated by drivers to log cargo shipment information.</p>
                                <div class="read-more-content d-none">
                                    <p>Operations Managers can scan QR codes generated by drivers, which contain key cargo information. Once scanned, the data is sent directly to the Trip Records module for tracking and updates.</p>
                                    <p><strong>How to Use:</strong> Launch the QR Scanner > Scan the driver’s QR code > Review auto-added record under Manage Trip Records.</p>
                                </div>
                                <button class="btn btn-sm btn-link p-0" onclick="toggleReadMore(this)">Read More</button>
                            </div>
                        </div>
                    </div>

                    <!-- Fuel Management -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Fuel Management</h5>
                                <p class="card-text">Visualize and analyze fuel consumption across all trucks using GPS data.</p>
                                <div class="read-more-content d-none">
                                    <p>Fuel Management shows visual analytics of fuel consumption based on GPS tracking data. You can filter records by date ranges such as weekly, monthly, or annually, and even use a custom date range for deeper analysis.</p>
                                    <p><strong>How to Use:</strong> Go to Fuel Management > Select a filter range or custom dates > Review bar graphs and usage summaries.</p>
                                </div>
                                <button class="btn btn-sm btn-link p-0" onclick="toggleReadMore(this)">Read More</button>
                            </div>
                        </div>
                    </div>

                    <!-- Profit Reports & Analysis -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Profit Reports & Analysis</h5>
                            <p class="card-text">Track and review profit data with table reports and visual bar graph analytics.</p>
                            <div class="read-more-content d-none">
                                <p>This module is divided into two main tabs:</p>
                                <ul>
                                    <li><strong>Profit Reports</strong> – A detailed table showing all profit records. Each entry includes the date, plate number, total income, total expenses, and the system-calculated profit. You can filter results by plate number and by date (weekly, monthly, annually, or custom ranges). A quick "Add Profit" button lets you input new entries easily.</li>
                                    <li><strong>Profit Analysis</strong> – A visual bar chart that summarizes profit trends over time. This helps admins see overall performance and spot growth patterns or issues quickly.</li>
                                </ul>
                                <p>Additionally, you can export the full profit report table to various formats (e.g., Excel, PDF) for offline access or sharing.</p>
                                <p><strong>How to Use:</strong> Navigate to the Profit Reports module > Select either the “Reports” or “Analysis” tab > Apply filters or add new records > Export data if needed.</p>
                            </div>
                            <button class="btn btn-sm btn-link p-0" onclick="toggleReadMore(this)">Read More</button>
                        </div>
                    </div>
                </div>


                <!-- Truck Details -->
                <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                    <h5 class="card-title">Truck Details</h5>
                    <p class="card-text">Manage and view all registered trucks with detailed information and actions.</p>
                    <div class="read-more-content d-none">
                        <p>The Truck Details page allows admins to keep an updated record of all trucks in the system. Each entry includes essential truck information such as Plate Number, Brand, Type, and Assigned Driver.</p>
                        <p><strong>Features:</strong></p>
                        <ul>
                        <li>Search bar to quickly find trucks by Plate Number.</li>
                        <li><strong>View</strong> – Opens full truck details, including technical info not shown in the table.</li>
                        <li><strong>Edit</strong> – Allows modification of any truck-related data.</li>
                        <li><strong>Archive</strong> – Removes the truck from the active list, but stores the record in Archives.</li>
                        <li><strong>Add Truck</strong> – Easily register new trucks into the system.</li>
                        </ul>
                        <p><strong>How to Use:</strong> Go to Truck Details > Use the search bar or add a truck > Use actions (View, Edit, Archive) to manage data.</p>
                    </div>
                    <button class="btn btn-sm btn-link p-0" onclick="toggleReadMore(this)">Read More</button>
                    </div>
                </div>
                </div>

                <!-- Active Accounts -->
                <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                    <h5 class="card-title">Active Accounts</h5>
                    <p class="card-text">Oversee and manage all user accounts created by the Admin.</p>
                    <div class="read-more-content d-none">
                        <p>The Active Accounts page lists all system users: Operations Managers and Drivers. Each record includes user role, name, contact number, and email. Driver entries also show their license details.</p>
                        <p><strong>Features:</strong></p>
                        <ul>
                        <li><strong>Create New Account</strong> – Admin can register new users by entering their role, full details, and login credentials.</li>
                        <li>Search bar to filter users quickly by name or role.</li>
                        <li><strong>View</strong> – Displays full account information.</li>
                        <li><strong>Edit</strong> – Allows updating of user data.</li>
                        <li><strong>Archive</strong> – Deactivates the user and moves the record to Archives.</li>
                        </ul>
                        <p><strong>How to Use:</strong> Go to Active Accounts > Click on “Add Account” to register a user > Use the search bar or actions (View, Edit, Archive) to manage accounts efficiently.</p>
                    </div>
                    <button class="btn btn-sm btn-link p-0" onclick="toggleReadMore(this)">Read More</button>
                    </div>
                </div>
                </div>

                    <!-- Archives -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Archives</h5>
                                <p class="card-text">Access deleted records and choose to restore or permanently remove them.</p>
                                <div class="read-more-content d-none">
                                    <p>The Archives section stores records that have been removed from active view. Managers can browse through these deleted entries and either restore them to the main system or permanently delete them if no longer needed.</p>
                                    <p><strong>How to Use:</strong> Go to Settings > Archives > Click on a record to view > Choose either "Restore" or "Permanently Delete" as needed.</p>
                                </div>
                                <button class="btn btn-sm btn-link p-0" onclick="toggleReadMore(this)">Read More</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Additional Support Sections -->
            <section class="help-section">
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

                <!-- Rules and Regulations -->
                <div class="rules-section">
                    <h5>Rules and Regulations</h5>
                    <ul>
                        <li>Reviewing and approving driver reports</li>
                        <li>Monitoring fleet performance</li>
                        <li>Generating monthly reports</li>
                        <li>Ensuring compliance with company policies</li>
                        <li>Managing driver assignments and schedules</li>
                    </ul>
                </div>
            </section>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>

    <script>
        function toggleReadMore(button) {
            const content = button.previousElementSibling;
            content.classList.toggle("d-none");
            button.innerText = content.classList.contains("d-none") ? "Read More" : "Show Less";
        }
    </script>
</body>

</html>