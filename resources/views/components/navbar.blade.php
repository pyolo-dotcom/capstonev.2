<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Navigation</title>
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

        body, html {
            height: 100%;
            margin: 0;
            overflow-x: hidden;
            background-color: #2f4156;
            overflow: hidden;
        }

        body.no-scroll {
            overflow: hidden;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 260px;
            height: 100vh;
            background: var(--secondary-color);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
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
            background: transparent;
            display: block;
            margin: 0 auto;
            padding: 15px;
            box-sizing: border-box;
            transition: all 0.3s;
            margin-top: -60px;
            margin-bottom: -30px;
        }

        .sidebar.collapsed .sidebar-logo {
            max-width: 50px;
            padding: 10px;
        }

        .sidebar-header h2 {
            color: white;
            font-size: 1.25rem;
            margin-bottom: 5px;
            transition: all 0.3s;
        }

        .sidebar-header p {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.7);
            margin-bottom: 0;
            transition: all 0.3s;
        }

        .sidebar.collapsed .sidebar-header h2,
        .sidebar.collapsed .sidebar-header p,
        .sidebar.collapsed .menu-item span {
            display: none;
        }

        .sidebar.collapsed .menu-item i {
            margin-right: 0;
            font-size: 1.2rem;
            text-align: center;
            width: 100%;
        }

        .menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .menu-item {
            color: #e7e8e2;
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
            font-size: 17px;
             font-weight: bold;
            color: #ffff;
            border-left: 5px solid var(--primary-color);
            border-radius: 0px;
            width: 245px;
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
            transition: all 0.3s ease;
        }

        .submenu.show {
            max-height: 500px;
        }

        .submenu-item {
            padding: 10px 15px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            display: block;
            font-size: 0.9rem;
            transition: all 0.3s;
            white-space: nowrap;
            width: 245px;
        }

        .submenu-item:hover,
        .submenu-item.active {
             font-size: 17px;
             font-weight: bold;
            color: #ffff;
            border-left: 3px solid var(--primary-color);
            border-radius: 0px;
            width: 245px;
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
            background-color: var(--dark-color);
            margin: 5px 0;
            transition: all 0.3s;
        }
        
        .hamburger.active div {
            background-color: var(--light-color);
        }

        .content {
            margin-left: 260px;
            padding: 25px;
            flex-grow: 1;
            background-color: #f2f2f2;
            min-height: 100vh;
            margin-top: 0px;
            -moz-border-radius-topleft: 30px;
            -moz-border-radius-bottomleft: 30px;
            transition: all 0.3s;
            overflow: ;
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
        
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }
        
        .overlay.show {
            display: block;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                left: -260px;
            }

            .sidebar.show {
                left: 0;
            }

            .sidebar.collapsed {
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
                left: 10px;
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
            <img src="/public/images/loggo.png" alt="Company Logo" class="sidebar-logo">
        </div>

        <ul class="menu">
            <li>
                <a href="{{ route('admin.deliveryrecords') }}" class="menu-item {{ request()->routeIs('admin.deliveryrecords*') ? 'active' : '' }}" id="deliverybtn">
                    <i class="bi bi-list"></i> <span>Trip Countings Records</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.managetrip') }}" class="menu-item {{ request()->routeIs('admin.managetrip*') ? 'active' : '' }}" id="tripRecordsBtn">
                    <i class="bi bi-truck"></i> <span>Manage Trip Records</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.managegps') }}" class="menu-item {{ request()->routeIs('admin.managegps*') ? 'active' : '' }}" id="gpscontrolbtn">
                    <i class="bi bi-map"></i> <span>Manage GPS Tracker</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.fuel') }}" class="menu-item {{ request()->routeIs('admin.fuel*') ? 'active' : '' }}" id="fuelManagementBtn">
                    <i class="bi bi-fuel-pump"></i> <span>Fuel Management</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.profit') }}" class="menu-item {{ request()->routeIs('admin.profit*') ? 'active' : '' }}" id="profitreportsbtn">
                    <i class="bi bi-graph-up"></i> <span>Profit Reports</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.truckdetails') }}" class="menu-item {{ request()->routeIs('admin.truckdetails*') ? 'active' : '' }}" id="trucksBtn">
                    <i class="bi bi-truck"></i> <span>Truck Details</span>
                </a>
            </li>
            <li>
                <a href="#" class="menu-item" id="settings-toggle">
                    <i class="bi bi-gear"></i> <span>Settings</span>
                    <i class="bi bi-chevron-down ms-auto dropdown-arrow"></i>
                </a>
                <ul class="submenu" id="settings-submenu">
                    <li>
                        <a href="{{ route('admin.profile') }}" class="submenu-item" id="profile-management-btn">
                            <i class="bi bi-person"></i> Profile Management
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.activeaccount') }}" class="submenu-item" id="active-account-btn">
                            <i class="bi bi-person-check"></i> Active Account
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.archive') }}" class="submenu-item" id="archivebtn">
                            <i class="bi bi-archive"></i> Archive
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.help') }}" class="submenu-item" id="helpSupportBtn">
                            <i class="bi bi-question-circle"></i> Help & Support
                        </a>
                    </li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" class="submenu-item" id="logoutBtn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-left"></i> Logout
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="content" id="content">
        <div class="overlay" id="overlay"></div>
        <div class="main-content-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const hamburger = document.getElementById('hamburger');
            const overlay = document.getElementById('overlay');

            // Toggle sidebar collapse
            function toggleSidebar() {
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('collapsed');
            }

            // Mobile sidebar toggle
            function toggleMobileSidebar() {
                sidebar.classList.toggle('show');
                hamburger.classList.toggle('active');
                overlay.classList.toggle('show');
                document.body.classList.toggle('no-scroll');
            }

            // Check screen size and set initial state
            function checkScreenSize() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('collapsed');
                    content.classList.remove('collapsed');
                    if (!sidebar.classList.contains('show')) {
                        overlay.classList.remove('show');
                        document.body.classList.remove('no-scroll');
                        hamburger.classList.remove('active');
                    }
                } else {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.classList.remove('no-scroll');
                    hamburger.classList.remove('active');
                }
            }

            // Settings dropdown toggle
            document.getElementById('settings-toggle').addEventListener('click', function(e) {
                e.preventDefault();
                const submenu = document.getElementById('settings-submenu');
                submenu.classList.toggle('show');
                const arrow = this.querySelector('.dropdown-arrow');
                arrow.classList.toggle('bi-chevron-down');
                arrow.classList.toggle('bi-chevron-up');
            });
                const currentUrl = window.location.href;
                const menuItems = document.querySelectorAll('.menu-item');
                const submenuItems = document.querySelectorAll('.submenu-item');

                menuItems.forEach(item => {
                    item.classList.remove('active');
                    if (item.href === currentUrl) {
                        item.classList.add('active');
                    }
                });

                submenuItems.forEach(item => {
                    item.classList.remove('active');
                    if (item.href === currentUrl) {
                        item.classList.add('active');
                        const submenu = item.closest('.submenu');
                        if (submenu) {
                            submenu.classList.add('show');
                            const parentMenuItem = submenu.previousElementSibling;
                            if (parentMenuItem) {
                                parentMenuItem.classList.add('active');
                                const arrow = parentMenuItem.querySelector('.dropdown-arrow');
                                if (arrow) {
                                    arrow.classList.replace('bi-chevron-down', 'bi-chevron-up');
                                }
                            }
                        }
                    }
                });
            }

            // Hamburger menu click event
            hamburger.addEventListener('click', function() {
                toggleMobileSidebar();
            });
            
            // Close sidebar when clicking outside on mobile
            overlay.addEventListener('click', function() {
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