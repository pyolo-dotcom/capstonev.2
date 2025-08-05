<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Navigation</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap');
        
        :root {
            --primary-color: #2563eb;           /* Vivid blue */
            --primary-hover: #1d4ed8;           /* Darker blue */
            --primary-light: rgba(37, 99, 235, 0.12);
            --secondary-color: #1e293b;         /* Deep slate */
            --secondary-light: #334155;         /* Lighter slate */
            --accent-color: #fbbf24;            /* Amber accent */
            --light-color: #f1f5f9;             /* Soft light */
            --dark-color: #0f172a;              /* Very dark blue */
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.92);
            --text-muted: rgba(255, 255, 255, 0.7);
            --border-color: rgba(37, 99, 235, 0.18);
            --shadow-sm: 0 2px 4px rgba(37, 99, 235, 0.08);
            --shadow-md: 0 4px 8px rgba(37, 99, 235, 0.13);
            --shadow-lg: 0 8px 20px rgba(37, 99, 235, 0.18);
            --shadow-xl: 0 12px 30px rgba(37, 99, 235, 0.22);
            --steel-gradient: linear-gradient(145deg, #1e293b 70%, #2563eb 100%);
            --orange-gradient: linear-gradient(145deg, #fbbf24, #f59e42);
        }
        
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', Arial, sans-serif;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
            background: linear-gradient(135deg, #bdc3c7 0%, #95a5a6 100%);
            margin: 0;
            font-weight: 400;
        }
        
        .sidebar {
            width: 280px;
            height: 100vh;
            background: #1d3364;
            color: var(--text-primary);
            position: fixed;
            left: 0;
            top: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            border-right: 3px solid var(--primary-color);
        }
        
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 20%, rgba(230, 126, 34, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(243, 156, 18, 0.08) 0%, transparent 50%),
                linear-gradient(180deg, rgba(0,0,0,0.1) 0%, transparent 20%);
            pointer-events: none;
        }
        
        .sidebar.collapsed {
            width: 80px;
        }
        
        .sidebar-header {
            padding: 25px 20px;
            text-align: center;
            border-bottom: 2px solid var(--border-color);
            background: rgba(37, 99, 235, 0.18);
            position: relative;
            z-index: 2;
        }
        
        .sidebar-header h2 {
            color: #ffffff;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 5px;
            transition: all 0.3s ease;
            text-shadow: 2px 2px 8px rgba(37, 99, 235, 0.18);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .sidebar-header p {
            font-size: 0.85rem;
            color: var(--accent-color);
            margin-bottom: 0;
            transition: all 0.3s ease;
            font-weight: 500;
            font-style: italic;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }
        
        .sidebar.collapsed .sidebar-header h2,
        .sidebar.collapsed .sidebar-header p,
        .sidebar.collapsed .menu-item span {
            opacity: 0;
            transform: translateX(-8px);
        }
        
        .sidebar.collapsed .menu-item i {
            margin-right: 0;
            font-size: 1.2rem;
        }
        
        .menu {
            list-style: none;
            padding: 20px 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            height: calc(100% - 140px);
            overflow-y: auto;
            position: relative;
            z-index: 2;
        }
        
        .menu::-webkit-scrollbar {
            width: 4px;
        }
        
        .menu::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .menu::-webkit-scrollbar-thumb {
            background: rgba(37, 99, 235, 0.18);
            border-radius: 2px;
        }
        
        .menu::-webkit-scrollbar-thumb:hover {
            background: rgba(37, 99, 235, 0.28);
        }
        
        .menu-item {
            color: var(--text-secondary);
            background: transparent;
            display: flex;
            align-items: center;
            padding: 14px 20px;
            margin: 3px 12px;
            transition: all 0.2s ease;
            border-radius: 6px;
            white-space: nowrap;
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
            border: 1px solid transparent;
        }
        
        
        
        .menu-item:hover::before,
        .menu-item.active::before {
            left: 0;
        }
        
        .menu-item:hover, 
        .menu-item.active {
            color: var(--text-primary);
            background: var(--primary-light);
            border: 1px solid var(--primary-color);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.13);
        }
        
        .menu-item.active {
            background: #314b70;
            border: 1.5px solid #3248b8;
        }
        
        .menu-item i {
            margin-right: 12px;
            transition: all 0.2s ease;
            flex-shrink: 0;
            font-size: 1.1rem;
            position: relative;
            z-index: 1;
        }
        
        .menu-item span {
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
            font-family: 'Roboto', Arial, sans-serif;
        }
        
        .menu-item:hover i {
            transform: scale(1.1);
            color: #ffffff;
        }
        
        .menu-item.active i {
            color: #ffffff;
        }
        
        .dropdown-arrow {
            margin-left: auto !important;
            transition: all 0.2s ease;
            font-size: 0.8rem;
        }
        
        .submenu {
            list-style: none;
            padding: 0;
            margin: 5px 12px 0 12px;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
            background: rgba(0, 0, 0, 0.15);
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .submenu.show {
            max-height: 400px;
            padding: 8px 0;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .submenu-item {
            padding: 10px 16px;
            color: var(--text-muted);
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            white-space: nowrap;
            margin: 2px 6px;
            border-radius: 4px;
            font-weight: 400;
        }
        
        .submenu-item i {
            margin-right: 10px;
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        .submenu-item:hover,
        .submenu-item.active {
            background: rgba(37, 99, 235, 0.15);
            color: var(--primary-color);
            transform: translateX(3px);
        }
        
        .submenu-item:hover i,
        .submenu-item.active i {
            opacity: 1;
            color: var(--accent-color);
        }
        
        .logout {
            margin-top: auto;
            border-top: 2px solid var(--border-color);
            margin-top: 15px !important;
            padding-top: 15px !important;
        }
        
        .logout:hover {
            background: rgba(192, 57, 43, 0.2) !important;
            border-color: rgba(192, 57, 43, 0.4) !important;
            color: #e74c3c !important;
        }
        
        .logout:hover::before {
            background: linear-gradient(145deg, #c0392b, #a93226) !important;
        }
        
        .hamburger {
            display: none;
            cursor: pointer;
            padding: 12px;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            background: rgba(30, 41, 59, 0.97);
            border-radius: 6px;
            box-shadow: var(--shadow-md);
            transition: all 0.2s ease;
            border: 1px solid var(--primary-color);
        }
        
        .hamburger:hover {
            background: rgba(30, 41, 59, 1);
            border: 1.5px solid var(--primary-hover);
        }
        
        .hamburger div {
            width: 22px;
            height: 3px;
            background: var(--primary-color);
            margin: 4px 0;
            transition: all 0.2s ease;
            border-radius: 1px;
        }
        
        .hamburger.active div:nth-child(1) {
            transform: rotate(-45deg) translate(-5px, 6px);
        }
        
        .hamburger.active div:nth-child(2) {
            opacity: 0;
        }
        
        .hamburger.active div:nth-child(3) {
            transform: rotate(45deg) translate(-5px, -6px);
        }
        
        .content {
            margin-left: 280px;
            padding: 25px;
            flex-grow: 1;
            transition: all 0.3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .content.collapsed {
            margin-left: 80px;
        }
        
        .main-content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 8px;
            padding: 25px;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                left: -280px;
                width: 280px;
            }
            
            .sidebar.show {
                left: 0;
                box-shadow: var(--shadow-xl), 20px 0 40px rgba(0, 0, 0, 0.2);
            }
            
            .sidebar.collapsed {
                left: -280px;
                width: 80px;
            }
            
            .sidebar.collapsed.show {
                left: 0;
                width: 80px;
            }
            
            .content {
                margin-left: 0;
                width: 100%;
                padding: 20px;
            }
            
            .content.collapsed {
                margin-left: 0;
            }
            
            .hamburger {
                display: block;
            }
            
            .main-content-wrapper {
                padding: 20px;
                border-radius: 6px;
            }
        }
        
        @media (max-width: 480px) {
            .content {
                padding: 15px;
            }
            
            .main-content-wrapper {
                padding: 15px;
                border-radius: 6px;
            }
            
            .sidebar-header {
                padding: 25px 20px;
            }
            
            .sidebar-header h2 {
                font-size: 1.3rem;
            }
        }
        
        /* Simple, sturdy animations for truckers */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-15px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .menu-item {
            animation: slideIn 0.2s ease-out forwards;
        }
        
        .menu-item:nth-child(1) { animation-delay: 0.05s; }
        .menu-item:nth-child(2) { animation-delay: 0.1s; }
        .menu-item:nth-child(3) { animation-delay: 0.15s; }
        .menu-item:nth-child(4) { animation-delay: 0.2s; }
        .menu-item:nth-child(5) { animation-delay: 0.25s; }
        .menu-item:nth-child(6) { animation-delay: 0.3s; }
        .menu-item:nth-child(7) { animation-delay: 0.35s; }

        .menu-item,
        .menu-item:visited,
        .menu-item:active,
        .menu-item:hover,
        .submenu-item,
        .submenu-item:visited,
        .submenu-item:active,
        .submenu-item:hover {
            text-decoration: none !important;
        }
    </style>
</head>
<body>
    <!-- Hamburger Menu (visible on mobile only) -->
    <div class="hamburger d-lg-none" id="hamburger">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <h2>SYA</h2>
            <h2>Trucking Services</h2>
            <p><i>Since 2018</i></p>
        </div>

        <!-- Sidebar Menu -->
        <ul class="menu">
            <li>
                <a href="{{ route('manager.deliveryrecords') }}" class="menu-item" id="deliverybtn">
                    <i class="bi bi-list"></i> <span>Trip Countings Records</span>
                </a>
            </li>
            <li>
                <a href="{{ route('manager.managetrip') }}"
                   class="menu-item {{ request()->routeIs('manager.managetrip') ? 'active' : '' }}" id="tripRecordsBtn">
                    <i class="bi bi-truck"></i> <span>Manage Trip Records</span>
                </a>
            </li>
            <li>
                <a href="{{ route('manager.gpscontrol') }}" class="menu-item" id="gpscontrolbtn">
                    <i class="bi bi-map"></i> <span>GPS Control</span>
                </a>
            </li>
            <li>
                <a href="{{ route('manager.qrscanner') }}" class="menu-item" id="qrScannerBtn">
                    <i class="bi bi-qr-code"></i> <span>QR Code Scanner</span>
                </a>
            </li>
            <li>
                <a href="{{ route('manager.fuel') }}" class="menu-item" id="fuelManagementBtn">
                    <i class="bi bi-fuel-pump"></i> <span>Fuel Management</span>
                </a>
            </li>
            <li>
                <a href="#" class="menu-item" id="settings-toggle">
                    <i class="bi bi-gear"></i> <span>Settings</span>
                    <i class="bi bi-chevron-down ms-auto dropdown-arrow"></i>
                </a>
                <ul class="submenu" id="settings-submenu">
                    <li>
                        <a href="{{ route('manager.profile') }}" class="submenu-item" id="profile-management-btn">
                            <i class="bi bi-person"></i> Profile Management
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manager.archive') }}" class="submenu-item" id="archivebtn">
                            <i class="bi bi-archive"></i> Archive
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('manager.helpmanager') }}" class="submenu-item" id="helpSupportBtn">
                            <i class="bi bi-question-circle"></i> Help & Support
                        </a>
                    </li>
                </ul>
            </li>
            <li class="mt-auto">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" class="menu-item logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-left"></i> <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content" id="content">
        <div class="main-content-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const hamburger = document.getElementById('hamburger');
            
            // Toggle sidebar collapse
            function toggleSidebar() {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('collapsed');
            }
            
            // Mobile sidebar toggle
            function toggleMobileSidebar() {
                sidebar.classList.toggle('show');
            }
            
            // Check screen size and set initial state
            function checkScreenSize() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('collapsed');
                    sidebar.classList.remove('show');
                    content.classList.remove('collapsed');
                } else {
                    sidebar.classList.remove('show');
                }
            }
            
            // Settings dropdown toggle
            document.getElementById('settings-toggle').addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('settings-submenu').classList.toggle('show');
                const arrow = this.querySelector('.dropdown-arrow');
                arrow.classList.toggle('bi-chevron-down');
                arrow.classList.toggle('bi-chevron-up');
            });
            
            // Set active menu item based on current URL
            function setActiveMenuItem() {
                const currentUrl = window.location.href;
                const menuItems = document.querySelectorAll('.menu-item');
                const submenuItems = document.querySelectorAll('.submenu-item');
                
                menuItems.forEach(item => {
                    if (item.href === currentUrl) {
                        item.classList.add('active');
                    }
                });
                
                submenuItems.forEach(item => {
                    if (item.href === currentUrl) {
                        item.classList.add('active');
                        document.getElementById('settings-submenu').classList.add('show');
                        document.querySelector('#settings-toggle .dropdown-arrow').classList.replace('bi-chevron-down', 'bi-chevron-up');
                    }
                });
            }
            
            // Hamburger menu click event
            hamburger.addEventListener('click', function() {
                this.classList.toggle('active');
                toggleMobileSidebar();
            });
            
            // Initialize
            checkScreenSize();
            setActiveMenuItem();
            
            // Resize event listener
            window.addEventListener('resize', checkScreenSize);

            // Prevent caching of pages after logout
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    window.location.reload();
                }
            });
        });

        // Clear cache on logout
        function clearCache() {
            if ('caches' in window) {
                caches.keys().then(function(names) {
                    for (let name of names)
                        caches.delete(name);
                }); 
            }
        }
    </script>
</body>
</html>