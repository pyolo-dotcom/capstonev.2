<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Archive Management</title>
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins';
    }
    
    body {
        display: flex;
        min-height: 100vh;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    }

    .sidebar {
        width: 250px;
        background: linear-gradient(145deg, #343a40, #2c3333);
        color: white;
        padding: 20px 0;
        position: fixed;
        height: 100%;
        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
    }

    .content {
        margin-left: 250px;
        padding: 25px;
        flex-grow: 1;
        background-color: #ffffff;
        min-height: 100vh;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        box-shadow: -6px 0 20px rgba(0, 0, 0, 0.08);
    }

    .content-header {
        background: linear-gradient(90deg, #ffffff, #f8f9fa);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        display: flex;
        align-items: center;
    }

    .content-header h2 {
        color: #1f1a5c;
        font-size: 1.7rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .content-header h2 i {
        color: #1d4ed8;
    }

    .table-container {
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }

    .filter-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .search-bar {
        flex-grow: 1;
        display: flex;
        justify-content: flex-end;
    }

    .search-bar input {
        padding: 12px 15px;
        border: 2px solid transparent;
        border-radius: 25px;
        width: 250px;
        outline: none;
        font-size: 14px;
        background: linear-gradient(white, #f8f9fa);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .search-bar input:focus {
        border-color: #1f1a5c;
        box-shadow: 0 0 8px rgba(31, 26, 92, 0.2);
    }

    .search-bar input::placeholder {
        color: #6c757d;
        font-style: italic;
    }

    .archive-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .archive-table th,
    .archive-table td {
        border: 1px solid #e0e0e0;
        padding: 15px;
        text-align: left;
        transition: background-color 0.3s ease;
    }

    .archive-table th {
        background-color: #1f1a5c;
        color: #fff;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .archive-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .archive-table tbody tr:hover {
        background-color: #e9ecef;
        transform: translateY(-2px);
    }

    .action-buttons {
        display: flex;
        gap: 10px;
    }

    .restore-btn {
        background: linear-gradient(90deg, #2ecc71, #27ae60);
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .restore-btn:hover {
        background: linear-gradient(90deg, #27ae60, #219653);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .delete-btn {
        background: linear-gradient(90deg, #e74c3c, #c0392b);
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .delete-btn:hover {
        background: linear-gradient(90deg, #c0392b, #a93226);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            position: relative;
        }
        
        .content {
            margin-left: 0;
            padding: 15px;
        }
        
        .content-header {
            padding: 15px;
            margin-bottom: 20px;
        }

        .content-header h2 {
            font-size: 1.5rem;
        }

        .filter-container {
            flex-direction: column;
        }
        
        .search-bar {
            width: 100%;
        }
        
        .search-bar input {
            width: 100%;
        }

        .archive-table {
            display: block;
            overflow-x: auto;
        }

        .archive-table th,
        .archive-table td {
            min-width: 120px;
        }
    }

    @media (max-width: 576px) {
        .content-header h2 {
            font-size: 1.3rem;
        }

        .search-bar input {
            padding: 10px 12px;
            font-size: 13px;
        }

        .archive-table th,
        .archive-table td {
            padding: 10px;
            font-size: 13px;
        }

        .restore-btn, .delete-btn {
            padding: 8px 12px;
            font-size: 12px;
        }
    }
</style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <x-managernavbar />
        </ul>
    </div>

    <div class="content">
        <div class="content-header">
            <h2><i class="fas fa-archive me-2"></i>Archive Management</h2>
        </div>
        
        <div class="table-container">
            <div class="filter-container">
                <div class="search-bar">
                    <input type="text" placeholder="Search archived records..." id="archiveSearch">
                </div>
            </div>

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
    </div>
    
    <!-- SweetAlert JS -->
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