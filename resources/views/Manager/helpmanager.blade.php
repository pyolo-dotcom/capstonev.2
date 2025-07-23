<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <title>Help & Support</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .sidebar {
            width: 250px;
            background: #2f4156;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100%;
        }

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

        .section-title {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: #0f172a;
        }

        .help-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .help-section {
            margin-bottom: 40px; /* Added to space out help sections */
        }

        .help-section h2 {
            color: #1d4ed8;
            font-size: 1.4rem;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e0e7ff;
            font-weight: 600;
        }

        .help-section p,
        .help-section ul li,
        .help-section ol li {
            color: #334155;
            line-height: 1.7;
            font-size: 15px;
        }

        .help-section ul,
        .help-section ol {
            padding-left: 20px;
            margin-bottom: 15px;
        }

        .contact-support {
            padding: 20px 24px;
            background-color: #ecf5ff;
            border-left: 5px solid #3b82f6;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            color: #1e3a8a;
            font-family: 'Poppins', sans-serif;
            margin-top: 30px; /* Added to space from previous content */
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

        .rules-section {
            padding: 20px 24px;
            background-color: #fdfbea;
            border-left: 5px solid #facc15;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            color: #78350f;
            font-family: 'Poppins', sans-serif;
            margin-top: 30px; /* Added to space from contact-support */
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
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <x-managernavbar />
    </div>

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
                        <li>Complete daily vehicle inspection reports</li>
                        <li>Follow all traffic laws and regulations</li>
                        <li>Report any accidents or incidents immediately</li>
                        <li>Maintain proper documentation for all shipments</li>
                        <li>Submit fuel receipts and delivery reports on time</li>
                    </ul>
                </div>
            </section>
        </div>
    </div>

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