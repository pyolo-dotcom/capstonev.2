<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive</title>
    <!-- Add SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        display: flex;
        background: #f5f5f5;
        min-height: 100vh;
    }

    .sidebar {
        width: 250px;
        height: 100vh;
        background: #2c3e50;
        padding: 20px;
        position: fixed;
        left: 0;
        top: 0;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar h2 {
        color: #ecf0f1;
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 10px;
        border-bottom: 1px solid #34495e;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
    }

    .sidebar ul li {
        margin-bottom: 5px;
    }

    .sidebar ul li a {
        color: #bdc3c7;
        text-decoration: none;
        display: block;
        padding: 12px 15px;
        border-radius: 5px;
        transition: all 0.3s ease;
        font-size: 15px;
    }

    .sidebar ul li a:hover {
        background: #34495e;
        color: #ecf0f1;
        transform: translateX(5px);
    }

    .content {
        margin-left: 270px;
        padding: 30px;
        flex-grow: 1;
        width: calc(100% - 270px);
    }

    .content h3 {
        color: #2c3e50;
        margin-bottom: 20px;
        font-size: 24px;
    }

    .records-Tab {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 30px 0;
        padding-bottom: 15px;
        border-bottom: 1px solid #e0e0e0;
    }

    .records-Tab button {
        background-color: transparent;
        border: none;
        color: #7f8c8d;
        padding: 10px 20px;
        margin: 0 5px;
        cursor: pointer;
        position: relative;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .records-Tab button::after {
        content: '';
        display: block;
        width: 0;
        height: 3px;
        background: #3498db;
        transition: width 0.3s;
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
    }

    .records-Tab button:hover {
        color: #2c3e50;
    }

    .records-Tab button:hover::after,
    .records-Tab button.active::after {
        width: 100%;
    }

    .records-buttons {
        display: flex;
        gap: 5px;
    }

    .records-Tab button.active {
        color: #2c3e50;
        font-weight: 600;
        font-size: 18px;
    }

    .search-bar {
        flex-grow: 1;
        display: flex;
        justify-content: flex-end;
    }

    .search-bar input {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 25px;
        width: 250px;
        outline: none;
        transition: all 0.3s ease;
        font-size: 14px;
        background-color: #f9f9f9;
    }

    .search-bar input:focus {
        border-color: #3498db;
        box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        background-color: #fff;
    }

    #archiveTitle {
        color: #2c3e50;
        margin: 20px 0;
        font-size: 22px;
        font-weight: 600;
    }

    .archive-table-container {
        margin-top: 20px;
        max-height: calc(100vh - 250px);
        overflow-y: auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .archive-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        table-layout: auto;
    }

    .archive-table th,
    .archive-table td {
        border: 1px solid #e0e0e0;
        padding: 12px 15px;
        text-align: left;
        vertical-align: middle;
    }

    .archive-table th {
        background-color: #3498db;
        color: #fff;
        text-transform: uppercase;
        font-size: 14px;
        font-weight: 600;
        position: sticky;
        top: 0;
    }

    .archive-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .archive-table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .restore-btn {
        padding: 8px 15px;
        background-color: #2ecc71;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
        margin-right: 5px;
    }

    .restore-btn:hover {
        background-color: #27ae60;
        transform: translateY(-1px);
    }

    .delete-btn {
        padding: 8px 15px;
        background-color: #e74c3c;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .delete-btn:hover {
        background-color: #c0392b;
        transform: translateY(-1px);
    }

    .action-buttons {
        display: flex;
        gap: 5px;
    }

    /* Scrollbar styling */
    .archive-table-container::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .archive-table-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .archive-table-container::-webkit-scrollbar-thumb {
        background: #bdc3c7;
        border-radius: 10px;
    }

    .archive-table-container::-webkit-scrollbar-thumb:hover {
        background: #95a5a6;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }
        
        .content {
            margin-left: 220px;
            width: calc(100% - 220px);
            padding: 15px;
        }
        
        .records-Tab {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .search-bar {
            margin-top: 15px;
            width: 100%;
        }
        
        .search-bar input {
            width: 100%;
        }
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
        <h3>Archived Page</h3>
        <div class="records-Tab">
            <div class="records-buttons">
                <button class="records-Tab-btn active" data-title="Archived Trips Records">Trip Records</button>
            </div>
            <div class="search-bar">
                <input type="text" placeholder="Search archived records..." id="archiveSearch">
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
                            <div class="action-buttons">
                                <form class="restore-form" action="{{ route('cargo.restore', $cargo->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="restore-btn">Restore</button>
                                </form>
                                <form class="delete-form" action="{{ route('cargo.delete', $cargo->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Add SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recordsTabButtons = document.querySelectorAll('.records-Tab-btn');
            const archiveTitle = document.getElementById('archiveTitle');
            
            // Tab switching functionality
            recordsTabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    recordsTabButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    archiveTitle.textContent = this.getAttribute('data-title');
                });
            });

            // Search functionality
            const archiveSearch = document.getElementById('archiveSearch');
            archiveSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                const rows = document.querySelectorAll('.archive-table tbody tr');
                
                rows.forEach(row => {
                    const cells = row.querySelectorAll('td:not(:last-child)'); // Exclude actions column
                    let rowMatches = false;
                    
                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(searchTerm)) {
                            rowMatches = true;
                        }
                    });
                    
                    row.style.display = rowMatches ? '' : 'none';
                });
            });

            // Add a slight delay to the search to improve performance
            let searchTimeout;
            archiveSearch.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const event = new Event('input');
                    this.dispatchEvent(event);
                }, 300);
            });

            // SweetAlert for restore actions
            document.querySelectorAll('.restore-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Restore Record',
                        text: 'Are you sure you want to restore this record?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#2ecc71',
                        cancelButtonColor: '#95a5a6',
                        confirmButtonText: 'Yes, restore it!',
                        cancelButtonText: 'No, cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });

            // SweetAlert for delete actions
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: 'Permanently Delete Record',
                        text: 'This action cannot be undone. Are you sure you want to delete this record permanently?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e74c3c',
                        cancelButtonColor: '#95a5a6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel',
                        dangerMode: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });

            // Check for success/error messages in session
            @if(session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonColor: '#2ecc71'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonColor: '#e74c3c'
                });
            @endif
        });
    </script>
</body>
</html>