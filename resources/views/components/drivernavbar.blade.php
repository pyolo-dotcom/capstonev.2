<head>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<!-- Update the CSS -->
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        display: flex;
        overflow: hidden;
    }

    .sidebar {
        width: 250px;
        height: 100vh;
        background: #2f4156;
        color: white;
        padding: 20px;
        position: fixed;
        left: 0;
        top: 0;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        transition: width 0.2s ease;
    }

    .sidebar.collapsed {
        width: 90px; /* Adjust for smaller screens */
    }

    .sidebar h2, .sidebar-header p {
        display: block; /* Always show texts */
    }

    .sidebar h2 {
        color: #fff;
        text-align: center;
        margin-bottom: 20px;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
    }

    .sidebar ul li {
        padding: 10px;
        margin-left: -20px;
        border-bottom: 1px solid #444;
    }

    .sidebar ul li a {
        color: #fff;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: 0.3s;
    }

    .sidebar ul li a:hover {
        background: #555;
        padding-left: 10px;
    }

    /* Custom Scrollbar */
    .sidebar::-webkit-scrollbar {
        width: 8px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 4px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    /* Sidebar Header */
    .sidebar-header {
        text-align: center;
    }

    .sidebar-header h2 {
        font-size: 18px;
        margin: 0;
        font-family: "Playfair Display", serif;
    }

    .sidebar-header p {
        font-size: 12px;
        margin-top: 3px;
        margin-bottom: 20px;
        color: #a8dadc;
    }

    /* Menu Styles */
    .menu {
        list-style: none;
        padding: 0;
        margin: 0;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .menu li {
        margin: 13px 0;
        position: relative;
    }

    .menu a {
        text-decoration: none;
        color: white;
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .menu a i {
        margin-right: 10px;
    }

    .menu a.active,
    .menu a:hover {
        background-color: gray;
    }

    .menu .logout {
        margin-top: auto;
    }

    /* Dropdown & Submenu */
    .menu .dropdown-toggle.active {
        background-color: darkgray;
    }

    .submenu {
        display: none;
        padding-left: 20px;
    }

    .submenu.show {
        display: block;
    }

    .submenu-item {
        padding: 10px;
        color: #333;
        display: block;
        transition: background-color 0.3s;
    }

    .submenu-item:hover {
        background-color: #f0f0f0;
        color: #007bff;
    }

    .submenu-item.active {
        background-color: #007bff;
        color: white;
    }

    .submenu .submenu-item:hover,
    .submenu .submenu-item.active {
        background-color: #5a697d;
    }

    /* Content Styles */
    .content {
        margin-left: 250px; /* Space for the sidebar */
        padding: 20px;
        flex-grow: 1;
        transition: margin-left 0.2s ease;
    }

    .content.collapsed {
        margin-left: 60px; /* Space for the collapsed sidebar */
    }

    .hamburger {
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        margin-bottom: 20px;
    }

    .hamburger div {
        width: 30px;
        height: 3px;
        background-color: white;
        margin: 5px 0;
        transition: 0.4s;
    }

    /* Responsive Sidebar */
    @media (max-width: 768px) {
        .sidebar {
            width: 200px; /* Adjust sidebar width */
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar ul li {
            padding: 10px;
        }

        .sidebar ul li a {
            font-size: 14px;
        }

        .sidebar-header h2 {
            font-size: 16px;
        }

        .sidebar-header p {
            font-size: 10px;
        }

        .content {
            margin-left: 200px; /* Adjust content margin */
        }

        .content.collapsed {
            margin-left: 60px; /* Margin for collapsed state */
        }
    }

    @media (max-width: 480px) {
        .sidebar {
            width: 210px; /* Further reduce width for mobile */
        }

        .sidebar.collapsed {
            width: 60px;
        }

        .sidebar ul li {
            padding: 8px;
        }

        .sidebar ul li a {
            font-size: 12px;
        }

        .sidebar-header h2 {
            font-size: 14px;
        }

        .sidebar-header p {
            font-size: 8px;
        }

        .content {
            margin-left: 150px; /* Adjust content margin */
        }

        .content.collapsed {
            margin-left: 60px; /* Margin for collapsed state */
        }
    }
</style>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="resize-handle" id="resize-handle"></div>

    <!-- Hamburger Menu -->
    <div class="hamburger" id="hamburger">
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <h2><i>SYA</i></h2>
        <h2>Trucking Services</h2>
        <p><i>Since 2020</i></p>
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
                <i class="bi bi-geo-alt"></i> <span>Fuel Management</span>
            </a>
        </li>
        <li>
            <a href="{{ route('driver.shipment') }}" class="menu-item" id="shipmentProgressBtn">
                <i class="bi bi-truck"></i> <span>Shipment Progress</span>
            </a>
        </li>
        <li>
            <a href="#" class="menu-item dropdown-toggle" id="settings-toggle">
                <i class="bi bi-fuel-pump"></i> <span>Settings</span>
            </a>
            <ul class="submenu" id="settings-submenu">
                <li>
                    <a href="{{ route('driver.profile') }}" class="submenu-item" id="profile-management-btn">
                        <i class="bi bi-book"></i> Profile Management
                    </a>
                </li>
                <li>
                    <a href="{{ route('driver.helpdriver') }}" class="submenu-item" id="helpSupportBtn">
                        <i class="bi bi-question-circle"></i> Help & Support
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('login') }}" class="menu-item logout">
                <i class="bi bi-box-arrow-left"></i> <span>Logout</span>
            </a>
        </li>
    </ul>
</div>

<!-- Script for Dropdown and Active Classes -->
<script>
    // Function to toggle the dropdown
    document.getElementById('settings-toggle').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default link behavior
        const submenu = document.getElementById('settings-submenu');
        const arrowIcon = this.querySelector('.dropdown-arrow');

        // Toggle the visibility of the submenu
        submenu.classList.toggle('show');

        // Toggle arrow icon
        if (submenu.classList.contains('show')) {
            arrowIcon.classList.replace('bi-chevron-down', 'bi-chevron-up');
        } else {
            arrowIcon.classList.replace('bi-chevron-up', 'bi-chevron-down');
        }
    });

    // Function to set the active class on the correct menu item
    function setActiveMenuItem() {
        const currentUrl = window.location.href; // Get the current URL
        const menuItems = document.querySelectorAll('.menu-item'); // Get all menu items
        const submenuItems = document.querySelectorAll('.submenu-item'); // Get all submenu items

        // Check main menu items
        menuItems.forEach(item => {
            if (item.href === currentUrl) {
                item.classList.add('active'); // Apply active class
            } else {
                item.classList.remove('active'); // Remove active class
            }
        });

        // Check submenu items
        submenuItems.forEach(item => {
            if (item.href === currentUrl) {
                item.classList.add('active'); // Apply active class
                const submenu = document.getElementById('settings-submenu');
                submenu.classList.add('show'); // Open submenu if item is active
                const arrowIcon = document.querySelector('#settings-toggle .dropdown-arrow');
                arrowIcon.classList.replace('bi-chevron-down', 'bi-chevron-up'); // Update arrow icon
            } else {
                item.classList.remove('active'); // Remove active class
            }
        });
    }

    // Call the function when the page loads
    document.addEventListener('DOMContentLoaded', setActiveMenuItem);

    // Function to toggle the sidebar
    document.getElementById('hamburger').addEventListener('click', function () {
        const sidebar = document.getElementById('sidebar');
        const content = document.querySelector('.content');
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('collapsed');
    });
</script>
