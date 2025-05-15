<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Archive Management</title>
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100%;
        }

        .content {
            margin-left: 250px;
            padding: 25px;
            flex-grow: 1;
            background-color: white;
            min-height: 100vh;
        }

        .content-header {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .content-header h2 {
            color: #1f1a5c;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }

        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            padding: 10px 15px;
            border: 1px solid #e1e5e9;
            border-radius: 25px;
            width: 250px;
            outline: none;
            transition: all 0.3s;
            font-size: 14px;
        }

        .search-bar input:focus {
            border-color: #1f1a5c;
        }

        .archive-table {
            width: 100%;
            border-collapse: collapse;
        }

        .archive-table th,
        .archive-table td {
            border: 1px solid #e0e0e0;
            padding: 12px 15px;
            text-align: left;
        }

        .archive-table th {
            background-color: #1f1a5c;
            color: #fff;
            font-weight: 600;
        }

        .archive-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .archive-table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .restore-btn {
            background: #2ecc71;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .restore-btn:hover {
            background: #27ae60;
            transform: translateY(-1px);
        }

        .delete-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .delete-btn:hover {
            background: #c0392b;
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
            }
            
            .content {
                margin-left: 0;
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