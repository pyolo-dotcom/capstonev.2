<link rel="stylesheet" href="{{ asset('css/driver.css') }}">
<li><a href="{{route ('driver.deliveryrecords')}}">Delivery Records</a></li>
<li><a href="{{route ('driver.fuel')}}">Fuel Management</a></li>
<li><a href="{{route ('driver.shipment')}}">Shipment Progress</a></li>
<ul>
    <li>
        <a class="menu-item" onclick="toggleDropdown(event)">
            <i class="bi bi-fuel-pump"></i> Settings
            <i class="bi bi-chevron-down dropdown-arrow"></i> <!-- Arrow icon -->
        </a>
        <ul class="submenu" id="settings-submenu">
            <li><a href="{{route ('driver.profile')}}" class="submenu-item"><i class="bi bi-book"></i> Profile Management</a></li>
            <li><a href="{{route ('driver.helpdriver')}}" class="submenu-item"><i class="bi bi-question-circle"></i> Help & Support</a></li>
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