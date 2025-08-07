<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Navigation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2f4156;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f5f7fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: var(--secondary-color);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            transition: all 0.3s;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            padding: 20px 10px;
            text-align: center;
            transition: all 0.3s;
        }

        .sidebar-logo {
            width: 90%;
            height: auto;
            object-fit: contain;
            background: transparent !important;
            display: block;
            margin: 0 auto;
            padding: 15px;
            box-sizing: border-box;
            transition: all 0.3s;
            margin-top: -60px;
            margin-bottom: -20px;
        }

        .sidebar.collapsed .sidebar-logo {
            max-width: 50px;
            padding: 10px;
        }

        .sidebar-header h2,
        .sidebar-header p {
            display: block;
            color: white;
            font-size: 1.25rem;
            margin-bottom: 5px;
            transition: all 0.3s;
        }

        .sidebar.collapsed .sidebar-header h2,
        .sidebar.collapsed .sidebar-header p,
        .sidebar.collapsed .menu-item span,
        .sidebar.collapsed .dropdown-arrow {
            display: none;
        }

        .sidebar.collapsed .menu-item i {
            margin-right: 0;
            font-size: 1.2rem;
        }

        .menu-container {
            flex-grow: 1;
            overflow-y: auto;
            padding-bottom: 10px;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .menu-container::-webkit-scrollbar {
            display: none;
        }

        .menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            height: auto;
        }

        .menu-item {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            transition: all 0.3s;
            border-left: 3px solid transparent;
            white-space: nowrap;
        }
        
        .menu-item:hover,
        .menu-item.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left: 3px solid var(--primary-color);
        }

        .menu-item i {
            margin-right: 10px;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .submenu {
            list-style: none;
            padding-left: 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
            background: rgba(0,0,0,0.1);
        }

        .submenu.show {
            max-height: 300px;
        }
        
        .submenu-item {
            padding: 10px 15px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .submenu-item:hover,
        .submenu-item.active {
            color: white;
            background: rgba(255,255,255,0.05);
        }

        .dropdown-arrow {
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .submenu.show .dropdown-arrow {
            transform: rotate(180deg);
        }

        .hamburger {
            display: none;
            cursor: pointer;
            padding: 15px;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1100;
        }

        .hamburger div {
            width: 25px;
            height: 3px;
            background-color: var(--secondary-color);
            margin: 5px 0;
            transition: all 0.3s;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
            transition: all 0.3s;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            position: relative;
        }

        .content.collapsed {
            margin-left: 70px;
        }

        .main-content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
                width: 250px;
            }

            .sidebar.show {
                left: 0;
            }

            .sidebar.collapsed, .sidebar.collapsed.show {
                left: -70px;
            }

            .content {
                margin-left: 0;
                width: 100%;
            }

            .content.collapsed {
                margin-left: 0;
            }

            .hamburger {
                display: block;
            }

            body.menu-open {
                overflow: hidden;
            }
        }
    </style>
</head>
<body>
    <div class="hamburger d-lg-none" id="hamburger">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="/images/loggo.png" alt="Company Logo" class="sidebar-logo">
        </div>
        
        <div class="menu-container">
            <ul class="menu" id="menu-list">
                <li>
                    <a href="{{ route('manager.deliveryrecords') }}" class="menu-item {{ request()->routeIs('manager.deliveryrecords*') ? 'active' : '' }}" id="deliverybtn">
                        <i class="bi bi-list"></i> <span>Trip Countings Records</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('manager.managetrip') }}" class="menu-item {{ request()->routeIs('manager.managetrip*') ? 'active' : '' }}" id="tripRecordsBtn">
                    <i class="bi bi-truck"></i> <span>Manage Trip Records</span>
                </a>
                </li>
                <li>
                    <a href="{{ route('manager.gpscontrol') }}" class="menu-item {{ request()->routeIs('manager.gpscontrol*') ? 'active' : '' }}" id="gpscontrolbtn">
                        <i class="bi bi-map"></i> <span>GPS Control</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('manager.qrscanner') }}" class="menu-item {{ request()->routeIs('manager.qrscanner*') ? 'active' : '' }}" id="qrScannerBtn">
                        <i class="bi bi-qr-code"></i> <span>QR Code Scanner</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('manager.fuel') }}" class="menu-item {{ request()->routeIs('manager.fuel*') ? 'active' : '' }}" id="fuelManagementBtn">
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
                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a href="#" class="submenu-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-left"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <div class="content" id="content">
        <div class="main-content-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const hamburger = document.getElementById('hamburger');
            const settingsToggle = document.getElementById('settings-toggle');
            const settingsSubmenu = document.getElementById('settings-submenu');
            const body = document.body;

            // Mobile sidebar toggle
            function toggleMobileSidebar() {
                sidebar.classList.toggle('show');
                body.classList.toggle('menu-open');
            }
            
            // Close sidebar
            function closeSidebar() {
                sidebar.classList.remove('show');
                body.classList.remove('menu-open');
                hamburger.classList.remove('active');
            }

            // Check screen size and set initial state
            function checkScreenSize() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('collapsed');
                    document.getElementById('content').classList.remove('collapsed');
                } else {
                    closeSidebar();
                }
            }
            
            // Settings dropdown toggle
            settingsToggle.addEventListener('click', function(e) {
                e.preventDefault();
                settingsSubmenu.classList.toggle('show');
            });
            
            // Set active menu item based on current URL
            function setActiveMenuItem() {
                const currentUrl = window.location.href;
                const menuItems = document.querySelectorAll('.menu-item');
                const submenuItems = document.querySelectorAll('.submenu-item');
                
                
                
                submenuItems.forEach(item => {
                    item.classList.remove('active');
                    if (item.href === currentUrl) {
                        item.classList.add('active');
                        settingsSubmenu.classList.add('show');
                    }
                });
            }
            
            // Hamburger menu click event
            hamburger.addEventListener('click', function() {
                toggleMobileSidebar();
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    const isClickInsideSidebar = sidebar.contains(event.target);
                    const isClickOnHamburger = hamburger.contains(event.target);
                    if (!isClickInsideSidebar && !isClickOnHamburger && sidebar.classList.contains('show')) {
                        closeSidebar();
                    }
                }
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