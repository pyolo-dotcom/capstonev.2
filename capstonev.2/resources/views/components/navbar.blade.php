<style>
    /* Hide submenu by default */
    .submenu {
        display: none;
        list-style: none;
        padding-left: 20px;
    }

    /* Show submenu when active */
    .submenu.show {
        display: block;
    }

    .menu-item {
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 200px;
        padding: 10px;
    }

    .submenu-item {
        display: block;
        text-decoration: none;
        color: #333;
    }

    .submenu-item:hover {
        background-color: #ddd;
    }

    form {
        margin-top: auto;
    }
</style>

<li><a href="{{route ('admin.deliveryrecords')}}">Delivery Records</a></li>
<li><a href="{{route ('admin.managetrip')}}">Manage Trip Records</a></li>
<li><a href="{{route ('admin.managegps')}}">Manage GPS Tracker</a></li>
<li><a href="{{route ('admin.fuel')}}">Fuel Management</a></li>
<li><a href="{{route ('admin.profit')}}">Profit Report</a></li>
<ul>
    <li>
        <a class="menu-item" onclick="toggleDropdown(event)">
            <i class="bi bi-fuel-pump"></i> Settings
            <i class="bi bi-chevron-down dropdown-arrow"></i> <!-- Arrow icon -->
        </a>
        <ul class="submenu" id="settings-submenu">
            <li><a href="{{route ('admin.profile')}}" class="submenu-item"><i class="bi bi-book"></i> Profile Management</a></li>
            <li><a href="{{route ('admin.activeaccount')}}" class="submenu-item"><i class="bi bi-person-check"></i> Active Account</a></li>
            <li><a href="{{route ('admin.archive')}}" class="submenu-item"><i class="bi bi-archive"></i> Archive</a></li>
            <li><a href="{{route ('admin.help')}}" class="submenu-item"><i class="bi bi-question-circle"></i> Help & Support</a></li>
        </ul>
    </li>
</ul>
<form action="{{}}">
    <button type="submit" >Log-Out</button>
</form>


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