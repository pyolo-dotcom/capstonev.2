<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Navigation</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
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
            overflow-x: hidden;
            background-color: #f5f7fa;
        }
        
        .sidebar {
            width: 250px;
            height: 100vh;
            background: var(--secondary-color);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar.collapsed {
            width: 70px;
        }
        
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
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
        }
        
        .menu {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            height: calc(100% - 120px);
        }
        
        .menu-item {
            color:#ffffff;
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
            transition: all 0.3s ease;
        }
        
        .submenu.show {
            max-height: 300px;
        }
        
        .submenu-item {
            padding: 10px 15px;
            color: #ffffff;
            text-decoration: none;
            display: block;
            font-size: 0.9rem;
            transition: all 0.3s;
            white-space: nowrap;
        }
        
        .submenu-item:hover,
        .submenu-item.active {
            color: white;
            background: rgba(255,255,255,0.05);
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
            }
            
            .sidebar.show {
                left: 0;
                width: 250px;
            }
            
            .sidebar.collapsed {
                left: -250px;
                width: 70px;
            }
            
            .sidebar.collapsed.show {
                left: 0;
                width: 70px;
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
                <a href="{{ route('driver.deliveryrecords') }}" class="menu-item" id="deliverybtn">
                    <i class="bi bi-list"></i> <span>Trip Countings Records</span>
                </a>
            </li>
            <li>
                <a href="{{ route('driver.fuel') }}" class="menu-item" id="fuelManagementBtn">
                    <i class="bi bi-fuel-pump"></i> <span>Fuel Management</span>
                </a>
            </li>
            <li>
                <a href="{{ route('driver.shipment') }}" class="menu-item" id="shipmentProgressBtn">
                    <i class="bi bi-truck"></i> <span>Shipment Progress</span>
                </a>
            </li>
            <li>
                <a href="#" class="menu-item" id="settings-toggle">
                    <i class="bi bi-gear"></i> <span>Settings</span>
                    <i class="bi bi-chevron-down ms-auto dropdown-arrow"></i>
                </a>
                <ul class="submenu" id="settings-submenu">
                    <li>
                        <a href="{{ route('driver.profile') }}" class="submenu-item" id="profile-management-btn">
                            <i class="bi bi-person"></i> Profile Management
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('driver.helpdriver') }}" class="submenu-item" id="helpSupportBtn">
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