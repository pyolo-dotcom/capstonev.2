<head>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<style>
/* Sidebar Styles */
.sidebar {
    width: 250px;
    background-color: #2f4156;
    color: white;
    display: flex;
    flex-direction: column;
    padding: 20px;
    height: 100vh; /* Full viewport height */
    overflow-y: auto; /* Enable vertical scrolling */
    transition: width 0.2s ease;
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
</style>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="resize-handle" id="resize-handle"></div>
    
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <h2><i>SYA</i></h2>
        <h2>Trucking Services</h2>
        <p><i>Since 2020</i></p>
    </div>

    <!-- Sidebar Menu -->
    <ul class="menu">
        <li>
            <a href="{{ route('admin.managetrip') }}" class="menu-item active" id="tripRecordsBtn">
                <i class="bi bi-truck"></i> Manage Trip Records
            </a>
        </li>
        <li>
            <a href="{{ route('admin.deliveryrecords') }}" class="menu-item" id="deliverybtn">
                <i class="bi bi-list"></i> Delivery Records
            </a>
        </li>
        <li>
            <a href="{{ route('admin.managegps') }}" class="menu-item" id="gpscontrolbtn">
                <i class="bi bi-map"></i> Manage GPS Tracker
            </a>
        </li>
        <li>
            <a href="{{ route('admin.fuel') }}" class="menu-item" id="fuelManagementBtn">
                <i class="bi bi-geo-alt"></i> Fuel Management
            </a>
        </li>
        <li>
            <a href="{{ route('admin.profit') }}" class="menu-item" id="profitreportsbtn">
                <i class="bi bi-book"></i> Profit Reports
            </a>
        </li>
        <li>
            <a href="#" class="menu-item dropdown-toggle" onclick="toggleDropdown(event)">
                <i class="bi bi-fuel-pump"></i> Settings
                <i class="bi bi-chevron-down dropdown-arrow"></i> <!-- Arrow icon -->
            </a>
            <ul class="submenu" id="settings-submenu">
                <li>
                    <a href="{{ route('admin.profile') }}" class="submenu-item" id="profile-management-btn">
                        <i class="bi bi-book"></i> Profile Management
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
            </ul>
        </li>
        <li>
            <a href="{{ route('login') }}" class="menu-item logout">
                <i class="bi bi-box-arrow-left"></i> Logout
            </a>
        </li>
    </ul>
</div>

<!-- Dropdown Toggle Script -->
<script>
    function toggleDropdown(event) {
        event.preventDefault(); // Prevent default anchor behavior
        let submenu = document.getElementById("settings-submenu");
        submenu.classList.toggle("show"); // Toggle the "show" class

        // Toggle the arrow direction
        let arrowIcon = event.currentTarget.querySelector(".dropdown-arrow");
        if (submenu.classList.contains("show")) {
            arrowIcon.classList.replace("bi-chevron-down", "bi-chevron-up");
        } else {
            arrowIcon.classList.replace("bi-chevron-up", "bi-chevron-down");
        }
    }
</script>
