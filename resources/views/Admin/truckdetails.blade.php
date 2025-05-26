<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truck Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --info-color: #1abc9c;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
        }
        
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
        
        .main-content {
            margin-left: 250px;
            padding: 25px;
            width: calc(100% - 250px);
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .header h2 {
            color: var(--secondary-color);
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
       
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .card-body {
            padding: 0;
        }
        
        .alert {
            border-radius: 8px;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .table {
            margin-bottom: 0;
            width: 100%;
        }
        
        .table thead th {
            background-color: var(--secondary-color);
            color: white;
            border-bottom: none;
            font-weight: 500;
            padding: 15px 20px;
        }
        
        .table tbody td {
            padding: 12px 20px;
            vertical-align: middle;
        }
        
        .table tbody tr {
            transition: all 0.2s;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .table tbody tr:last-child {
            border-bottom: none;
        }
        
        .table tbody tr:hover {
            background-color: rgba(0,0,0,0.02);
        }
        
        .btn-action {
            padding: 6px 10px;
            font-size: 0.85rem;
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
            white-space: nowrap;
        }
        
        .btn-view {
            background-color: var(--info-color);
            color: white;
            border: none;
        }
        
        .btn-view:hover {
            background-color: #16a085;
            color: white;
        }
        
        .btn-edit {
            background-color: var(--warning-color);
            color: white;
            border: none;
        }
        
        .btn-edit:hover {
            background-color: #d35400;
            color: white;
        }
        
        .btn-archive {
            background-color: var(--danger-color);
            color: white;
            border: none;
        }
        
        .btn-archive:hover {
            background-color: #c0392b;
            color: white;
        }
        
        .empty-message {
            padding: 40px;
            text-align: center;
            color: #6c757d;
        }
        
        .empty-message i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #dee2e6;
        }
        
        .action-btns {
            display: flex;
            gap: 6px;
            flex-wrap: nowrap;
        }

        .truck-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }
        
        .truck-image-lg {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
        }
        
        .image-placeholder {
            width: 60px;
            height: 60px;
            background-color: #f8f9fa;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            border: 1px dashed #dee2e6;
        }
       /*changes*/
       .top-bar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 10px;
}

.search-container {
    display: flex;
    align-items: center;
}

.search-input {
    position: relative;
    width: 300px;
}

.search-input i {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.search-input input {
    padding-left: 35px;
}
/*end*/
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
            }
            
            .content {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }
            
            .filter-container {
                flex-direction: column;
            }
            
            .date-filter {
                width: 100%;
            }
            
            .date-btn {
                flex-grow: 1;
            }
        
            .action-btns {
                flex-wrap: wrap;
                gap: 4px;
                justify-content: center;
            }
            
            .btn-action {
                padding: 8px 12px;
                font-size: 14px;
                min-height: 36px;
            }
            
            .table thead th, 
            .table tbody td {
                padding: 12px 15px;
            }
            
            .search-container {
                flex-direction: column;
            }
            
            .search-input {
                max-width: 100%;
            }
        
            .table-responsive {
                margin: 0 -15px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2>Truck Management</h2>
        </div>
        <ul>
            <x-navbar/>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h2><i class="fas fa-truck-moving"></i>Truck Details</h2>
            
        </div>
        
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success m-3">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
                @endif
                
                @if(session('error'))
                <div class="alert alert-danger m-3">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                </div>
                @endif
                <!--changes-->
               <!-- Top Row: Add Truck (left) + Search Bar (right) -->
<div class="top-bar-container">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTruckModal">
        <i class="fas fa-plus"></i> Add Truck
    </button>

    <div class="search-container">
        <div class="search-input">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" class="form-control" placeholder="Search by plate number...">
        </div>
    </div>
</div>

                
                @if($trucks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="trucksTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>CR Number</th>
                                <th>Plate Number</th>
                                <th>Owner Name</th>
                                <th>Make</th>
                                <th>Year Model</th>
                                <th style="min-width: 220px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trucks as $truck)
                            <tr class="truck-row">
                                <td>{{ $truck->id }}</td>
                                <td>
                                    @if($truck->image_path)
                                        <img src="{{ $truck->image_url }}" 
                                             alt="Truck {{ $truck->plate_number }}"
                                             class="truck-image">
                                    @else
                                        <div class="image-placeholder">
                                            <i class="fas fa-truck"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $truck->cr_number }}</td>
                                <td class="plate-number">{{ $truck->plate_number }}</td>
                                <td>{{ $truck->owner_name }}</td>
                                <td>{{ $truck->make }}</td>
                                <td>{{ $truck->year_model }}</td>
                                <td>
                                    <div class="action-btns">
                                        <button class="btn-action btn-view" data-bs-toggle="modal" data-bs-target="#viewTruckModal{{ $truck->id }}">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editTruckModal{{ $truck->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('admin.truckdetails.destroy', $truck->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-archive" onclick="return confirm('Are you sure you want to archive this truck?')">
                                                <i class="fas fa-archive"></i> Archive
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-message">
                    <i class="fas fa-truck"></i>
                    <h4>No Trucks Found</h4>
                    <p class="text-muted">There are currently no trucks registered. Click "Add Truck" to register a new one.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    @include('admin.modals.add-truck-modal')
    @include('admin.modals.view-truck-modal')
    @include('admin.modals.edit-truck-modal')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Image preview for add form - only runs if element exists
        document.addEventListener('DOMContentLoaded', function() {
            const addImageInput = document.getElementById('image');
            if (addImageInput) {
                addImageInput.addEventListener('change', function(e) {
                    const preview = document.getElementById('imagePreview');
                    const file = e.target.files[0];
                    
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
    
            // Image preview for edit forms - only runs if elements exist
            document.querySelectorAll('.edit-image').forEach(input => {
                input.addEventListener('change', function(e) {
                    const previewId = this.dataset.preview;
                    if (previewId) {
                        const preview = document.getElementById(previewId);
                        if (preview) {
                            const file = e.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    preview.src = e.target.result;
                                }
                                reader.readAsDataURL(file);
                            }
                        }
                    }
                });
            });

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('.truck-row');
                    
                    rows.forEach(row => {
                        const plateNumber = row.querySelector('.plate-number').textContent.toLowerCase();
                        if (plateNumber.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>