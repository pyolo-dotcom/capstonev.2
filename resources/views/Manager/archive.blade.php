<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Menu</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        display: flex;
        background: #f5f5f5;
    }

    .sidebar {
        width: 250px;
        height: 100vh;
        background: #333;
        padding: 20px;
        position: fixed;
        left: 0;
        top: 0;
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
        padding: 15px;
        border-bottom: 1px solid #444;
    }

    .sidebar ul li a {
        color: #fff;
        text-decoration: none;
        display: block;
        transition: 0.3s;
    }

    .sidebar ul li a:hover {
        background: #555;
        padding-left: 10px;
    }

    .content {
        margin-left: 270px;
        padding: 20px;
        flex-grow: 1;
    }

    .records-Tab {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 40px;
        margin-bottom: 20px;
    }

    .records-Tab button {
        background-color: transparent;
        border: none;
        color: black;
        padding: 10px 20px;
        margin: 0 10px;
        cursor: pointer;
        position: relative;
        font-size: 16px;
    }

    .records-Tab button::after {
        content: '';
        display: block;
        width: 0;
        height: 2px;
        background: black;
        transition: width 0.3s;
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
    }

    .records-Tab button:hover::after,
    .records-Tab button.active::after {
        width: 100%;
    }

    .records-buttons {
        display: flex;
        gap: 10px;
    }

    .records-Tab button.active {
        font-size: 25px;
        font-weight: bold;
    }

    .search-bar {
        flex-grow: 1;
        display: flex;
        justify-content: flex-end;
    }

    .search-bar input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 200px;
    }

    .archive-table-container {
        margin-top: 20px;
        max-height: calc(100vh - 200px);
        overflow-y: auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* ✅ Fixed Table Styles */
    .archive-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
    }

    .archive-table th,
    .archive-table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    .archive-table th {
        background-color: #333;
        color: #fff;
        text-transform: uppercase;
    }

    .archive-table tbody tr:hover {
        background-color: #f5f5f5;
    }

    /* ✅ Styled Restore Button */
    .restore-btn {
        padding: 8px 12px;
        background-color: green;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .restore-btn:hover {
        background-color: darkgreen;
    }
    .delete-btn {
    padding: 8px 12px;
    background-color: red;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.delete-btn:hover {
    background-color: darkred;
}
</style>
</head>
<body>
    <div class="sidebar">
        <h2>Sidebar Menu</h2>
        <ul>
            <x-managernavbar />
        </ul>
    </div>
    <div class="content">
        <h3>Archive Trips</h3>
        <div class="records-Tab">
            <div class="records-buttons">
                <button class="records-Tab-btn active" data-title="Archived Trips Records">Trip Records</button>
                <button class="records-Tab-btn" data-title="Archived Fuel Records">Fuel Records</button>
                <button class="records-Tab-btn" data-title="Archived Profit Reports">Profit Reports</button>
                <button class="records-Tab-btn" data-title="Archived Accounts">Accounts</button>
            </div>
            <div class="search-bar">
                <input type="text" placeholder="Search..." id="archiveSearch">
            </div>
        </div>
        <h3 id="archiveTitle">Archived Trips Records</h3>
        <div class="archive-table-container">
    <table class="archive-table">
        <thead>
            <tr>
                <th>Plate No.</th>
                <th>EIR No.</th>
                <th>Container Van No.</th>
                <th>Size</th>
                <th>Shipper/Consignee</th>
                <th>Voyage Vessel</th>
                <th>Pickup Location</th>
                <th>Delivery Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($archivedCargos as $cargo)
            <tr>
                <td>{{ $cargo->plate_no }}</td>
                <td>{{ $cargo->eir_no }}</td>
                <td>{{ $cargo->container_van_no }}</td>
                <td>{{ $cargo->size }}</td>
                <td>{{ $cargo->shipper_consignee }}</td>
                <td>{{ $cargo->voyage_vessel }}</td>
                <td>{{ $cargo->pickup_location }}</td>
                <td>{{ $cargo->delivery_location }}</td>
                <td>
                    <form action="{{ route('cargo.restore', $cargo->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="restore-btn">Restore</button>
                    </form>
                    <form action="{{ route('cargo.delete', $cargo->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this record permanently?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</body>
<script>
    const recordsTabButtons = document.querySelectorAll('.records-Tab-btn');
    const archiveTitle = document.getElementById('archiveTitle');
    recordsTabButtons.forEach(button => {
        button.addEventListener('click', function () {
            recordsTabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            archiveTitle.textContent = this.getAttribute('data-title');
        });
    });

    // Handle search functionality
    const archiveSearch = document.getElementById('archiveSearch');
    archiveSearch.addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.archive-table tbody tr');
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(searchTerm));
            row.style.display = match ? '' : 'none';
        });
    });
    
</script>

</html>