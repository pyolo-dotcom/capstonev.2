<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Truck Tracking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('/public/images/logo.jpg') }}" type="image/jpg">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            display: flex;
            min-height: 100vh;
            background: var(--secondary-color);
            overflow-x: hidden;
        }

        .sidebar {
            width: 260px;
            min-width: 260px;
            background: linear-gradient(180deg, #1a1c20 0%, #2d3436 100%);
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            overflow-y: auto;
        }

        .content {
            margin-left: 260px;
            padding: 30px;
            flex-grow: 1;
            background: linear-gradient(135deg, #f8fafc 0%, #e3f2fd 100%);
            min-height: 100vh;
            width: calc(100vw - 260px);
            max-width: calc(100vw - 260px);
            border-top-left-radius: 25px;
            position: relative;
        }

        .content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 200px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-radius: 25px 25px 0 0;
            z-index: -1;
        }

        .content-header {
            background:none!important;
            padding: 0px;
            border-radius: 20px;
            margin-bottom: 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border:none!important;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

       /* .content-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #2036a5 0%, #2239a3 100%);
        }*/

        .content-header h2 {
            color: #2d3748;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 15px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .content-header h2 i {
            color: #1e1769;
            font-size: 2rem;
            filter: drop-shadow(0 2px 4px rgba(102, 126, 234, 0.3));
        }

        #last-updated {
            background:none;
            color: blue;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 500;
            box-shadow:none;
            animation: pulse 2s infinite;
        }

      /*  @keyframes pulse {
            0% { box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); }
            50% { box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5); }
            100% { box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); }
        }*/

        .map-container {
            height: 600px;
            width: 100%;
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 2px solid rgba(255, 255, 255, 0.3);
            position: relative;
        }

        .map-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 49%, rgba(255, 255, 255, 0.1) 50%, transparent 51%);
            pointer-events: none;
            z-index: 1;
        }
/* General container for the cards */
#truck-items {
    /* The JavaScript already adds 'row' and 'g-4' for Bootstrap grid behavior */
    /* Add some top margin to separate it from other elements if needed */
    margin-top: 20px;
}

/* Wrapper for each individual truck card (handles column spacing) */
.truck-card-wrapper {
    /* The col-*-* classes already define the width and horizontal alignment */
    /* g-4 (from .row.g-4) handles the gutter (spacing) between columns */
    /* No additional styling needed here beyond what Bootstrap provides for columns */
}

/* Styles for the actual card box */
.truck-card {
    background-color: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    padding: 15px;
    height: 100%; /* Ensure all cards in a row have the same height */
    display: flex; /* Use flexbox for internal content alignment */
    flex-direction: column; /* Stack content vertically */
    justify-content: space-between; /* Push header/footer to ends, body in middle */
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.truck-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.truck-card-header {
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px solid #f0f0f0;
}

.truck-card-header .truck-plate {
    font-size: 15px;
    color: #333;
}

.truck-card-body {
    flex-grow: 1; /* Allows the body to take up available space */
    margin-bottom: 15px; /* Space between data and actions */
}

.truck-card-body .truck-data {
    font-size: 14ox;
    color: #555;
    margin: 0; /* Remove default paragraph margin */
}

.truck-card-actions .btn {
    background: none !important; /* Removes background */
    border: none !important; /* Removes border */
    box-shadow: none !important; /* Removes any lingering shadow from Bootstrap buttons */
    padding: 0; /* Remove padding to make them look more like links */
    font-size: 13px;
    /* Optional: Add a hover effect for underline or slight color change */
    text-decoration: none; /* Ensure no default underline if it's acting like a link */
}
.truck-card-actions .btn:hover {
   
       color: initial;
       text-decoration: none;
       background-color: transparent;
       box-shadow: none;
  
}
.truck-card-actions .btn-primary {
color: blue;

}
.truck-card-actions .btn-danger {
color: red;
}
/* Basic styling for the utility classes if not already defined */
.status {
    font-weight: bold;
    padding: 2px 8px;
    border-radius: 4px;
    display: inline-flex; /* Use flex to align icon and text */
    align-items: center;
    gap: 5px; /* Space between text and icon */
}

.status.connected {
    background-color: #d4edda;
    color: #155724;
}

.status.error {
    background-color: #f8d7da;
    color: #721c24;
}

.status.connecting {
    background-color: #fff3cd;
    color: #856404;
}

.connection-status {
    font-size: 0.9em;
    color: #777;
    margin-top: 10px;
}

/* Styles for map containers */
#map, #flespi-map {
    height: 600px; /* Adjust as needed */
    width: 100%;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

/* Tab button styling */
.tab-button-container {
    display: flex;
    margin-bottom: 20px;
    border-bottom: 1px solid #ddd;
}

.tab-button {
    background-color: #f1f1f1;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
    flex-grow: 1; /* Distribute space equally */
    text-align: center;
}

.tab-button:hover {
    background-color: #ddd;
}

.tab-button.active {
    background-color: #ccc;
    border-bottom: 2px solid #007bff; /* Highlight active tab */
}

.tab-content {
    display: none;
    padding: 20px 0;
}

.tab-content.active {
    display: block;
}

/* Ensure the main content area for tracking is well-structured */
.tracking-container {
    display: flex;
    gap: 20px; /* Space between map and list */
    flex-wrap: wrap; /* Allow columns to wrap on smaller screens */
}

.map-column, .list-column {
    flex: 1; /* Allow columns to grow and shrink */
    min-width: 300px; /* Minimum width before wrapping */
}

/* Optional: Improve search input styling */
.search-container {
    margin-bottom: 20px;
}
.search-container input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

  .truck-info {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            padding: 25px;
            border-radius: 20px;
            margin-top: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .truck-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        }

        .truck-info h3 {
            color: #1f2937;
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .truck-info h3::before {
            content: '🚛';
            font-size: 1.5rem;
        }

        .truck-info p {
            margin: 12px 0;
            color: #4b5563;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }

        .truck-info p:last-of-type {
            border-bottom: none;
        }

        .truck-info strong {
            color: #1f2937;
            min-width: 140px;
            display: inline-block;
        }

        .truck-list {
            margin-top: 25px;
            background:none!important;
            border-radius: 20px;
            padding: 25px;
            box-shadow:none!important;
            border: none!important;
            position: relative;
            overflow: hidden;
        }

        .truck-list h3 {
            color: #1f2937;
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .truck-list h3::before {
            content: '🚛';
            font-size: 1.5rem;
        }

        .truck-item {
            padding: 20px;
            border-bottom: 1px solid rgba(229, 231, 235, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.5) 0%, rgba(248, 250, 252, 0.5) 100%);
            margin: 10px 0;
            border-radius: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
        }

        .truck-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(180deg, #1e1769 0%, #3125d2 100%);
        }

        .truck-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(248, 250, 252, 0.8) 100%);
        }

        .truck-item:last-child {
            border-bottom: none;
        }

        .truck-item strong {
            color: #1f2937;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .truck-item div[style*="font-size: 0.8em"] {
            color: #6b7280 !important;
            font-weight: 500 !important;
            margin-top: 5px;
        }


        .connection-status {
            position: fixed;
            bottom: 30px;
            right: 30px;
            padding: 15px 25px;
            border-radius: 50px;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            font-size: 14px;
            font-weight: 600;
            z-index: 1000;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            animation: slideInUp 0.5s ease;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(100px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .connection-status.realtime {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border-color: rgba(16, 185, 129, 0.3);
        }

        .connection-status.polling {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border-color: rgba(245, 158, 11, 0.3);
        }

        .connection-status.error {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border-color: rgba(239, 68, 68, 0.3);
        }
        
        /* Enhanced Button Styles */
        .button-group {
            display: flex;
            gap: 8px;
            margin-top: 15px;
        }
        
        .btn {
            border: none;
            padding: 12px 20px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
            flex: 1;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        
        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }
        
        .btn-sm {
            padding: 8px 16px;
            font-size: 12px;
            border-radius: 10px;
        }

        .tab-container {
            margin-bottom: 30px;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid  #2239a3;
            backdrop-filter: blur(10px);
        }

        .tab-buttons {
            display: flex;
            border-bottom: 2px solid rgba(229, 231, 235, 0.3);
            margin-bottom: 0px;
            gap: 5px;
            width: 40%;
            margin-left: 20px
        }

        .tab-button {
            padding: 15px 25px;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 15px 15px 0 0;
            margin-right: 10px;
            font-weight: 600;
            color: #6b7280;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 14px;
        }

        .tab-button::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #2036a5 0%, #2239a3 100%);
            transform: scaleX(0);
            transition: transform 0.3s ease;    
        }

        .tab-button.active {
            background: linear-gradient(135deg, #2036a5 0%, #2239a3 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .tab-button.active::before {
            transform: scaleX(1);
        }

        .tab-button:hover:not(.active) {
            background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
            transform: translateY(-1px);
            color: #374151;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .tab-content.active {
            display: block;
            padding: 0px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .status {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .status.connected {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .status.connecting {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .status.disconnected,
        .status.error {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .status i {
            margin-left: 0;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .sidebar {
                width: 220px;
                min-width: 220px;
            }
            
            .content {
                margin-left: 220px;
                width: calc(100vw - 220px);
                max-width: calc(100vw - 220px);
                padding: 25px;
            }
            
            .map-container {
                height: 500px;
            }
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 200px;
                min-width: 200px;
            }
            
            .content {
                margin-left: 200px;
                width: calc(100vw - 200px);
                max-width: calc(100vw - 200px);
                padding: 20px;
            }
            
            .content-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .button-group {
                flex-direction: column;
                gap: 8px;
            }

            .tab-buttons {
                flex-wrap: wrap;
            }

            .tab-button {
                flex: 1;
                min-width: 120px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
                min-width: auto;
            }
            
            .content {
                margin-left: 0;
                padding: 15px;
                width: 100%;
                max-width: 100%;
            }
            
            .map-container {
                height: 400px;
            }
            
            .content-header h2 {
                font-size: 1.4rem;
            }

            .truck-item {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .connection-status {
                bottom: 20px;
                right: 20px;
                left: 20px;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .content {
                padding: 10px;
            }
            
            .tab-container,
            .truck-info,
            .truck-list {
                padding: 20px;
            }
            
            .content-header {
                padding: 20px;
            }

            .tab-button {
                padding: 12px 18px;
                font-size: 12px;
            }

            .btn {
                padding: 10px 16px;
                font-size: 12px;
            }
        }

        /* Loading Animation */
        @keyframes shimmer {
            0% { background-position: -200px 0; }
            100% { background-position: calc(200px + 100%) 0; }
        }

        .loading {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200px 100%;
            animation: shimmer 1.5s infinite;
        }

        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <ul>
            <x-navbar />
        </ul>
    </div>

    <div class="content">
        <div class="content-header">
            <h2><i class="fas fa-truck me-2"></i>Live Truck Tracking</h2>
            <div id="last-updated">Last updated: --:--:--</div>
        </div>
 <div class="tab-buttons">
                <button class="tab-button active" onclick="openTab(event, 'local-tracking')">Local Tracking</button>
                <button class="tab-button" onclick="openTab(event, 'flespi-tracking')">Flespi GPS Device</button>
            </div>
        <div class="tab-container">
                       <!-- Local Tracking Tab -->
            <div id="local-tracking" class="tab-content active">
                <div class="map-container" id="map"></div>
 <div class="truck-list" id="truck-list">
                    <h3>Tracked Vehicles</h3>
                    <div id="truck-items">
                        <p>Loading truck data...</p>
                    </div>
                </div>
               
            </div>
            
            <!-- Flespi GPS Device Tab -->
            <div id="flespi-tracking" class="tab-content">
                <div class="map-container" id="flespi-map"></div>
                
                <div class="truck-info">
                    <h3>Flespi GPS Device Information</h3>
                    <p><strong>Device ID:</strong> <span id="flespi-device-id">{{ env('FLESPI_DEVICE_ID') }} (TKSTAR TK905B)</span></p>
                    <p><strong>Status:</strong> <span id="flespi-status" class="status connecting">Connecting... <i class="fas fa-sync-alt fa-spin"></i></span></p>
                    <p><strong>Last Update:</strong> <span id="flespi-last-update">--:--:--</span></p>
                    <p><strong>Position:</strong> <span id="flespi-position">Latitude: --, Longitude: --</span></p>
                    
                    <div class="button-group">
                        <button class="btn btn-primary" onclick="refreshFlespiData()">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                        <button class="btn btn-success" onclick="centerFlespiMap()">
                            <i class="fas fa-map-marker-alt"></i> Center Map
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="connection-status" class="connection-status polling">
            Connecting...
        </div>

        <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
       <script>
    // Configuration
    const flespiConfig = {
        deviceId: {{ env('FLESPI_DEVICE_ID') }},
        token: "{{ env('FLESPI_TOKEN') }}",
        restEndpoint: "https://flespi.io/gw/devices"
    };

    // Global variables
    let map;
    let flespiMap;
    const markers = {};
    const infoWindows = {};
    let updateInterval;
    let firstLoad = true;
    let pusher = null;
    let echoChannel = null;
    let lastUpdateTime = null;
    let flespiMarker = null;
    let flespiInfoWindow = null;
    let flespiUpdateInterval = null;

    // Initialize the map
    function initMap() {
        // Initialize local tracking map
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            mapTypeId: 'roadmap',
            styles: [{
                "featureType": "poi",
                "stylers": [{ "visibility": "off" }]
            }]
        });

        // Initialize Flespi map
        initFlespiMap();

        // Set up local tracking
        setupWebSocketConnection();
        updateTruckLocations(); // Initial load of truck data
    }

    // Initialize Flespi Map
    function initFlespiMap() {
        flespiMap = new google.maps.Map(document.getElementById('flespi-map'), {
            zoom: 15,
            mapTypeId: 'roadmap',
            center: { lat: 14.5995, lng: 120.9842 }, // Default to Manila coordinates
            styles: [{
                "featureType": "poi",
                "stylers": [{ "visibility": "off" }]
            }]
        });

        // Create initial marker (hidden until we get data)
        flespiMarker = new google.maps.Marker({
            position: { lat: 0, lng: 0 },
            map: null, // Start with no map
            title: "Flespi GPS Device",
            icon: {
                url: "http://maps.google.com/mapfiles/kml/shapes/truck.png",
                scaledSize: new google.maps.Size(40, 40),
                anchor: new google.maps.Point(20, 20)
            }
        });

        // Create info window
        flespiInfoWindow = new google.maps.InfoWindow({
            content: '<div>Loading device information...</div>'
        });

        // Marker click listener
        flespiMarker.addListener('click', () => {
            flespiInfoWindow.open(flespiMap, flespiMarker);
        });

        // Start updating position
        updateFlespiPosition();
        flespiUpdateInterval = setInterval(updateFlespiPosition, 10000); // Update every 10 seconds
    }

    // Update Flespi device position
    function updateFlespiPosition() {
        fetch('/get-flespi-location')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    const position = {
                        lat: parseFloat(data.data.latitude),
                        lng: parseFloat(data.data.longitude)
                    };

                    // Update marker
                    updateFlespiMarker(position, data.data);

                    // Update status
                    updateFlespiStatus('Connected', 'connected');

                    // Update info display
                    updateFlespiDeviceInfo(data.data);
                } else {
                    updateFlespiStatus('No position data', 'error');
                }
            })
            .catch(error => {
                console.error('Error fetching Flespi location:', error);
                updateFlespiStatus('Connection error', 'error');
            });
    }

    // Update Flespi marker position
    function updateFlespiMarker(position, data) {
        // Show marker if hidden
        if (!flespiMarker.getMap()) {
            flespiMarker.setMap(flespiMap);
        }

        // Smooth animation
        if (flespiMarker.getPosition()) {
            const numSteps = 10;
            let step = 0;
            const oldPosition = flespiMarker.getPosition();
            const latStep = (position.lat - oldPosition.lat()) / numSteps;
            const lngStep = (position.lng - oldPosition.lng()) / numSteps;

            function animateMarker() {
                if (step >= numSteps) {
                    flespiMarker.setPosition(position);
                    return;
                }

                const newPos = {
                    lat: oldPosition.lat() + (latStep * step),
                    lng: oldPosition.lng() + (lngStep * step)
                };

                flespiMarker.setPosition(newPos);
                step++;
                requestAnimationFrame(animateMarker);
            }

            animateMarker();
        } else {
            flespiMarker.setPosition(position);
        }

        // Center map on first update
        if (!flespiMap.getCenter() || flespiMap.getCenter().lat() === 0) {
            flespiMap.setCenter(position);
        }

        // Update info window
        updateFlespiInfoWindow(data);
    }

    // Update Flespi info window content
    function updateFlespiInfoWindow(data) {
        const timestamp = new Date(data.timestamp);
        const batteryLevel = data.battery ? Math.round(data.battery) : '--';
        const speed = data.speed ? parseFloat(data.speed).toFixed(1) : '--';
        const altitude = data.altitude ? parseFloat(data.altitude).toFixed(1) : '--';

        const content = `
            <div style="min-width: 200px">
                <h4 style="margin: 0 0 10px 0;">Flespi GPS Device</h4>
                <p style="margin: 5px 0;"><strong>Device ID:</strong> ${data.device_id}</p>
                <p style="margin: 5px 0;"><strong>Last Update:</strong> ${timestamp.toLocaleString()}</p>
                <p style="margin: 5px 0;"><strong>Position:</strong> ${data.latitude.toFixed(6)}, ${data.longitude.toFixed(6)}</p>
                <p style="margin: 5px 0;"><strong>Speed:</strong> ${speed} km/h</p>
                <p style="margin: 5px 0;"><strong>Altitude:</strong> ${altitude} m</p>
                <p style="margin: 5px 0;"><strong>Battery:</strong> ${batteryLevel}%</p>
            </div>
        `;

        flespiInfoWindow.setContent(content);
    }

    // Update Flespi device info display
    function updateFlespiDeviceInfo(data) {
        const timestamp = new Date(data.timestamp);
        document.getElementById('flespi-last-update').textContent = timestamp.toLocaleString();

        document.getElementById('flespi-position').textContent =
            `Latitude: ${data.latitude.toFixed(6)}, Longitude: ${data.longitude.toFixed(6)}`;

        if (data.speed) {
            const speed = parseFloat(data.speed).toFixed(1);
            document.getElementById('flespi-speed').textContent = `${speed} km/h`;
        }

        if (data.altitude) {
            const altitude = parseFloat(data.altitude).toFixed(1);
            document.getElementById('flespi-altitude').textContent = `${altitude} meters`;
        }

        if (data.battery) {
            const battery = Math.round(data.battery);
            const batteryElement = document.getElementById('flespi-battery');
            batteryElement.textContent = `${battery}%`;

            // Color coding
            if (battery > 60) {
                batteryElement.style.color = 'green';
            } else if (battery > 30) {
                batteryElement.style.color = 'orange';
            } else {
                batteryElement.style.color = 'red';
            }
        }
    }

    // Update Flespi connection status
    function updateFlespiStatus(text, type) {
        const statusElement = document.getElementById('flespi-status');
        statusElement.textContent = text;
        statusElement.className = `status ${type}`;

        // Add appropriate icon
        const icons = {
            connected: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            connecting: 'fa-sync-alt fa-spin',
            disconnected: 'fa-plug'
        };

        statusElement.innerHTML = `${text} <i class="fas ${icons[type] || 'fa-info-circle'}"></i>`;
    }

    // Manual refresh
    function refreshFlespiData() {
        updateFlespiStatus("Refreshing...", "connecting");
        updateFlespiPosition();
    }

    // Center map on marker
    function centerFlespiMap() {
        if (flespiMarker.getPosition()) {
            flespiMap.setCenter(flespiMarker.getPosition());
            flespiMap.setZoom(17);
            flespiInfoWindow.open(flespiMap, flespiMarker);
        }
    }

    // Call this when switching to Flespi tab
    function onFlespiTabOpen() {
        if (flespiMap) {
            google.maps.event.trigger(flespiMap, 'resize');
            if (flespiMarker.getPosition()) {
                flespiMap.setCenter(flespiMarker.getPosition());
            }
        }
    }

    // Tab switching function
    function openTab(evt, tabName) {
        const tabContents = document.getElementsByClassName("tab-content");
        for (let i = 0; i < tabContents.length; i++) {
            tabContents[i].classList.remove("active");
        }

        const tabButtons = document.getElementsByClassName("tab-button");
        for (let i = 0; i < tabButtons.length; i++) {
            tabButtons[i].classList.remove("active");
        }

        document.getElementById(tabName).classList.add("active");
        evt.currentTarget.classList.add("active");

        // Handle map resize and centering
        setTimeout(() => {
            if (tabName === 'flespi-tracking') {
                onFlespiTabOpen();
            } else {
                google.maps.event.trigger(map, 'resize');
                // Center the local tracking map if needed
                if (Object.keys(markers).length > 0) {
                    const firstMarker = markers[Object.keys(markers)[0]];
                    map.setCenter(firstMarker.getPosition());
                }
            }
        }, 100);
    }

    // Set up WebSocket connection for local tracking
    function setupWebSocketConnection() {
        try {
            pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                encrypted: true,
                authEndpoint: '/broadcasting/auth',
                auth: {
                    headers: {
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                    }
                }
            });

            echoChannel = pusher.subscribe('tracking');

            echoChannel.bind('location.updated', (data) => {
                updateConnectionStatus('realtime');
                updateLastUpdatedTime();
                updateTruckOnMap(data.location);
                // --- START MODIFICATION ---
                // Original line, which would trigger a full list re-render:
                // updateTruckList([data.location]);
                // New line, to specifically update the card for the changed truck:
                updateTruckListItem(data.location);
                // --- END MODIFICATION ---
            });

            echoChannel.bind('pusher:subscription_succeeded', () => {
                updateConnectionStatus('realtime');
                console.log('WebSocket connected successfully');
            });

            echoChannel.bind('pusher:subscription_error', (status) => {
                console.error('WebSocket subscription error:', status);
                fallbackToPolling();
            });

        } catch (e) {
            console.error('WebSocket setup failed:', e);
            fallbackToPolling();
        }
    }

    // Fall back to polling if WebSockets fail
    function fallbackToPolling() {
        updateConnectionStatus('polling');

        if (updateInterval) clearInterval(updateInterval);

        updateInterval = setInterval(updateTruckLocations, 1000);
        updateTruckLocations();
    }

    // Update connection status display
    function updateConnectionStatus(status) {
        const element = document.getElementById('connection-status');
        element.className = `connection-status ${status}`;

        switch(status) {
            case 'realtime':
                element.textContent = 'Real-time (WebSocket)';
                break;
            case 'polling':
                element.textContent = 'Using Polling (1s interval)';
                break;
            case 'error':
                element.textContent = 'Connection Error';
                break;
        }
    }

    // Fetch and update truck locations via AJAX
    function updateTruckLocations() {
        fetch('/get-live-locations', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            cache: 'no-cache'
        })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (!Array.isArray(data)) {
                    throw new Error('Invalid data format');
                }

                updateLastUpdatedTime();

                if (data.length === 0) {
                    // --- START MODIFICATION ---
                    // Original line for no trucks:
                    // document.getElementById('truck-items').innerHTML = '<p>No active trucks found</p>';
                    // New line (same for no trucks, but included for clarity of change):
                    document.getElementById('truck-items').innerHTML = '<p>No active trucks found</p>';
                    // --- END MODIFICATION ---
                    return;
                }

                // --- START MODIFICATION ---
                // Original call to update the list:
                // updateTruckList(data);
                // New call to the updated function that generates cards:
                updateTruckList(data);
                // --- END MODIFICATION ---

                data.forEach(updateTruckOnMap);
            })
            .catch(error => {
                console.error('Error fetching truck locations:', error);
                updateConnectionStatus('error');
                setTimeout(updateTruckLocations, 2000);
            });
    }

    // Update truck on map
    function updateTruckOnMap(truck) {
        if (!truck?.latitude || !truck?.longitude) return;

        const position = {
            lat: parseFloat(truck.latitude),
            lng: parseFloat(truck.longitude)
        };

        if (firstLoad) {
            map.setCenter(position);
            map.setZoom(15);
            firstLoad = false;
        }

        if (!markers[truck.truck_id]) {
            createNewMarker(truck, position);
        } else {
            updateExistingMarker(truck, position);
        }
    }

    // Create new marker
    function createNewMarker(truck, position) {
        markers[truck.truck_id] = new google.maps.Marker({
            position: position,
            map: map,
            title: `${truck.fullname || 'Driver'} (${truck.truck_id})`,
            icon: {
                url: "http://maps.google.com/mapfiles/kml/shapes/truck.png",
                scaledSize: new google.maps.Size(40, 40),
                anchor: new google.maps.Point(20, 20)
            }
        });

        infoWindows[truck.truck_id] = new google.maps.InfoWindow({
            content: buildInfoWindowContent(truck)
        });

        markers[truck.truck_id].addListener('click', () => {
            Object.values(infoWindows).forEach(iw => iw.close());
            infoWindows[truck.truck_id].open(map, markers[truck.truck_id]);
        });
    }

    // Update existing marker
    function updateExistingMarker(truck, position) {
        if (!markers[truck.truck_id]) return;

        const currentPos = markers[truck.truck_id].getPosition();
        if (currentPos &&
            currentPos.lat() === position.lat &&
            currentPos.lng() === position.lng) {
            return;
        }

        const numSteps = 10;
        let step = 0;
        const oldPosition = markers[truck.truck_id].getPosition();
        const latStep = (position.lat - oldPosition.lat()) / numSteps;
        const lngStep = (position.lng - oldPosition.lng()) / numSteps;

        function animateMarker() {
            if (step >= numSteps) {
                markers[truck.truck_id].setPosition(position);
                return;
            }

            const newPos = {
                lat: oldPosition.lat() + (latStep * step),
                lng: oldPosition.lng() + (lngStep * step)
            };

            markers[truck.truck_id].setPosition(newPos);
            step++;
            requestAnimationFrame(animateMarker);
        }

        animateMarker();

        const currentContent = infoWindows[truck.truck_id].getContent();
        const newContent = buildInfoWindowContent(truck);
        if (currentContent !== newContent) {
            infoWindows[truck.truck_id].setContent(newContent);
        }
    }

    // Build info window content
    function buildInfoWindowContent(truck) {
        const distance = parseFloat(truck.total_distance) || 0;
        const speed = Math.max(0, parseFloat(truck.speed) || 0);
        return `
            <div style="min-width: 200px">
                <h4 style="margin: 0 0 10px 0;">${truck.fullname || 'Driver'}</h4>
                <p style="margin: 5px 0;"><strong>Plate No:</strong> ${truck.truck_id}</p>
                <p style="margin: 5px 0;"><strong>Distance:</strong> ${distance.toFixed(2)} km</p>
                <p style="margin: 5px 0;"><strong>Speed:</strong> ${speed.toFixed(2)} km/h</p>
                <div class="button-group">
                    <button class="btn btn-primary" onclick="focusOnTruck('${truck.truck_id}')">
                        Focus
                    </button>
                    <button class="btn btn-danger" onclick="resetDistance('${truck.truck_id}')">
                        Reset
                    </button>
                </div>
            </div>
        `;
    }

    // --- START MODIFICATION: updateTruckList function ---

    /* ORIGINAL updateTruckList function:
    function updateTruckList(trucks) {
        const container = document.getElementById('truck-items');
        const newHtml = trucks.map(truck => {
            const distance = parseFloat(truck.total_distance) || 0;
            const speed = parseFloat(truck.speed) || 0;
            return `
                <div class="truck-item" data-truck-id="${truck.truck_id}">
                    <div class="truck-info">
                        <strong>${truck.fullname || 'Driver'}</strong> (${truck.truck_id})<br>
                        Distance: ${distance.toFixed(2)} km | Speed: ${speed.toFixed(2)} km/h
                    </div>
                    <div class="truck-actions">
                        <button class="btn btn-primary btn-sm" onclick="focusOnTruck('${truck.truck_id}')">
                            Focus
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="resetDistance('${truck.truck_id}')">
                            Reset
                        </button>
                    </div>
                </div>
            `;
        }).join('');

        if (container.innerHTML !== newHtml) {
            container.innerHTML = newHtml || '<p>No active trucks found</p>';
        }
    }
    */

    // NEW updateTruckList function (generates Bootstrap cards):
    function updateTruckList(trucks) {
        const container = document.getElementById('truck-items');

        // Add Bootstrap 'row' and 'g-4' (gap) classes to the container.
        // This is crucial for Bootstrap's grid system to properly arrange the new cards.
        // Only add if not already present to avoid redundant class additions on subsequent calls.
        if (!container.classList.contains('row')) {
            container.classList.add('row', 'g-4');
        }

        const newHtml = trucks.map(truck => {
            const distance = parseFloat(truck.total_distance) || 0;
            const speed = parseFloat(truck.speed) || 0;
            // Use truck.plate_number if available, otherwise fallback to truck_id
            const plateDisplay = truck.plate_number || truck.truck_id;
            const driverDisplay = truck.fullname || 'Driver';

            // Construct the new card HTML structure
            return `
                <div class="col-lg-4 col-md-6 col-sm-12 truck-card-wrapper">
                    <div class="truck-card">
                        <div class="truck-card-header">
                            <strong class="truck-plate">${plateDisplay} - ${driverDisplay}</strong>
                        </div>
                        <div class="truck-card-body">
                            <p class="truck-data">${distance.toFixed(2)} km | ${speed.toFixed(2)} km/h</p>
                        </div>
                        <div class="truck-card-actions">
                            <button class="btn btn-primary btn-sm" onclick="focusOnTruck('${truck.truck_id}')">
                                Focus
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="resetDistance('${truck.truck_id}')">
                                Reset
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        // Only update if content has actually changed to minimize DOM manipulation
        if (container.innerHTML !== newHtml) {
            container.innerHTML = newHtml || '<p>No active trucks found</p>';
        }
    }
    // --- END MODIFICATION: updateTruckList function ---

    // --- START MODIFICATION: updateTruckListItem function ---

    /* ORIGINAL updateTruckListItem function:
       There was no dedicated `updateTruckListItem` function. Updates for individual trucks often triggered
       a full re-render of the entire list via `updateTruckList([data.location])`. This new function is
       created to specifically target and update the relevant card without re-rendering the whole list.
       The logic for updating individual items was previously handled within `updateTruckList` when it received
       a single truck, or by the generic DOM updates for `updateTruckDistanceUI`.
    */

    // NEW updateTruckListItem function (updates specific card data):
    function updateTruckListItem(truck) {
        // Find the specific truck card by iterating through all card wrappers
        // and checking if their .truck-plate element's text content includes the truck_id.
        const truckCardWrapper = Array.from(document.querySelectorAll('.truck-card-wrapper')).find(wrapper => {
            const truckPlateElement = wrapper.querySelector('.truck-plate');
            // Ensure truckPlateElement exists and its text content contains the truck_id
            return truckPlateElement && truckPlateElement.textContent.includes(truck.truck_id);
        });

        if (truckCardWrapper) {
            const distance = parseFloat(truck.total_distance) || 0;
            const speed = parseFloat(truck.speed) || 0;

            // Update the .truck-data paragraph within that specific card
            const truckDataElement = truckCardWrapper.querySelector('.truck-data');
            if (truckDataElement) {
                truckDataElement.textContent = `${distance.toFixed(2)} km | ${speed.toFixed(2)} km/h`;
            }
        } else {
            // If a truck_id isn't found (e.g., it's a new truck that just came online),
            // trigger a full update to ensure it appears in the list.
            updateTruckLocations();
        }
    }
    // --- END MODIFICATION: updateTruckListItem function ---

    // Update last updated time
    function updateLastUpdatedTime() {
        const now = new Date();
        const options = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        };
        document.getElementById('last-updated').textContent =
            `Last updated: ${now.toLocaleTimeString('en-PH', options)}`;
    }

    // Global functions
    window.focusOnTruck = function(truck_id) {
        if (markers[truck_id]) {
            map.setCenter(markers[truck_id].getPosition());
            map.setZoom(17);
            infoWindows[truck_id].open(map, markers[truck_id]);
        }
    };

    window.resetDistance = function(truck_id) {
        // First confirm the reset
        Swal.fire({
            title: "Reset Distance?",
            text: "This will reset the total distance to 0 and record fuel consumption",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, reset it!",
        }).then((confirmResult) => {
            if (confirmResult.isConfirmed) {
                // Now prompt for fuel price
                Swal.fire({
                    title: 'Enter Fuel Price',
                    input: 'number',
                    inputLabel: 'Current fuel price per liter',
                    inputPlaceholder: 'Enter price (e.g. 60.50)',
                    inputAttributes: {
                        step: "0.01",
                        min: "1"
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    showLoaderOnConfirm: true,
                    preConfirm: (price) => {
                        if (!price || isNaN(price) || price <= 0) {
                            Swal.showValidationMessage('Please enter a valid fuel price');
                            return false;
                        }
                        return price;
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((priceResult) => {
                    if (priceResult.isConfirmed) {
                        const fuelPrice = parseFloat(priceResult.value);

                        // Send the request with the fuel price
                        fetch(`/reset-distance/${truck_id}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ fuel_price: fuelPrice })
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => {
                                    throw new Error(err.message || 'Reset failed');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: "Success!",
                                    text: data.message,
                                    icon: "success"
                                });

                                // Update UI
                                updateTruckDistanceUI(truck_id);
                            } else {
                                Swal.fire("Error", data.message || "Failed to reset distance", "error");
                            }
                        })
                        .catch(error => {
                            Swal.fire("Error", error.message || "Failed to reset distance", "error");
                        });
                    }
                });
            }
        });
    };

    // --- START MODIFICATION: updateTruckDistanceUI function ---

    /* ORIGINAL updateTruckDistanceUI function:
    function updateTruckDistanceUI(truck_id) {
        // Update marker info window
        if (markers[truck_id]) {
            const content = infoWindows[truck_id].getContent();
            const newContent = content.replace(
                /<strong>Distance:<\/strong> [0-9.]+ km/,
                '<strong>Distance:</strong> 0.00 km'
            );
            infoWindows[truck_id].setContent(newContent);
        }

        // Update truck list item
        const truckItem = document.querySelector(`.truck-item[data-truck-id="${truck_id}"]`);
        if (truckItem) {
            const truckInfo = truckItem.querySelector('.truck-info');
            if (truckInfo) {
                // Assuming "Speed" part is after "Distance", we can reconstruct
                const originalText = truckInfo.textContent;
                const speedMatch = originalText.match(/Speed: ([0-9.]+) km\/h/);
                const currentSpeed = speedMatch ? speedMatch[1] : '0.00';
                truckInfo.textContent = `${truckItem.querySelector('strong').textContent} (${truck_id})\nDistance: 0.00 km | Speed: ${currentSpeed} km/h`;
            }
        }
    }
    */

    // NEW updateTruckDistanceUI function (updates specific card data after reset):
    function updateTruckDistanceUI(truck_id) {
        // Update marker info window
        if (markers[truck_id]) {
            const content = infoWindows[truck_id].getContent();
            const newContent = content.replace(
                /<strong>Distance:<\/strong> [0-9.]+ km/,
                '<strong>Distance:</strong> 0.00 km'
            );
            infoWindows[truck_id].setContent(newContent);
        }

        // Update truck list item (the card)
        // Similar to updateTruckListItem, we'll find the card wrapper using a robust method.
        const truckCardWrapper = Array.from(document.querySelectorAll('.truck-card-wrapper')).find(wrapper => {
            const truckPlateElement = wrapper.querySelector('.truck-plate');
            // Ensure truckPlateElement exists and its text content contains the truck_id
            return truckPlateElement && truckPlateElement.textContent.includes(truck_id);
        });

        if (truckCardWrapper) {
            const truckDataElement = truckCardWrapper.querySelector('.truck-data');
            if (truckDataElement) {
                // Assuming speed is still current, just update distance to 0.00 km
                const currentText = truckDataElement.textContent;
                const speedMatch = currentText.match(/\|\s*([0-9.]+\s*km\/h)/); // Capture speed including "km/h"
                const currentSpeed = speedMatch ? speedMatch[1] : '0.00 km/h'; // Extract existing speed
                truckDataElement.textContent = `0.00 km | ${currentSpeed}`;
            }
        }
    }
    // --- END MODIFICATION: updateTruckDistanceUI function ---

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        if (updateInterval) clearInterval(updateInterval);
        if (flespiUpdateInterval) clearInterval(flespiUpdateInterval);
        if (pusher) pusher.disconnect();
    });
</script>
    </div>
</body>
</html>