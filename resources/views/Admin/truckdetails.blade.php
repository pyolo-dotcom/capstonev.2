<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truck Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('public/images/logo.jpg') }}" type="image/jpg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
            --table-header-bg: #f4f7fa;
            --table-border-color: #e9ecef;
            --table-row-hover: #f8fafc;
            --dark-text: #343a40;
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
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #343a40, #2c3e50);
            color: white;
            padding: 1rem 0;
            position: fixed;
            height: 100%;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .main-content {
            margin-left: 250px;
            padding: 1rem;
            flex-grow: 1;
            background-color: #ffffff;
            min-height: 100vh;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            box-shadow: -2px 0 8px rgba(0, 0, 0, 0.05);
            transition: margin-left 0.3s ease;
        }

        .main-content.full-width {
            margin-left: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e9ecef;
        }

        .header h2 {
            color: var(--secondary-color);
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
        }

        .header h2::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }

        .btn-primary {
            background: none !important;
            color: var(--primary-color) !important;
            border: 1px solid transparent !important;
            padding: 0.4rem 0.8rem !important;
            border-radius: 8px !important;
            font-size: 1rem !important;
            font-weight: 600 !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.4rem !important;
            transition: all 0.3s ease !important;
            white-space: nowrap !important;
            text-decoration: none;
        }

        .btn-primary:hover {
            background: #f1f5f9 !important;
            color: #1d4ed8 !important;
            border-color: var(--primary-color) !important;
            transform: translateY(-2px);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            overflow: hidden;
            background: #ffffff;
        }

        .card-body {
            padding: 0.75rem;
        }

        .alert {
            border-radius: 6px;
            padding: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.9rem;
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid var(--table-border-color);
            max-height: calc(100vh - 200px);
            margin-bottom: 1rem;
            background: #ffffff;
        }

        .table {
            margin-bottom: 0;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #ffffff;
            table-layout: auto;
        }

        .table thead th {
            background-color: var(--table-header-bg);
            color: var(--dark-text);
            border-bottom: 1.5px solid var(--table-border-color);
            font-weight: 600;
            padding: 0.6rem 0.8rem;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1;
            font-size: 0.9rem;
        }

        .table thead th:first-child {
            border-top-left-radius: 10px;
        }

        .table thead th:last-child {
            border-top-right-radius: 10px;
        }

        .table tbody td {
            padding: 0.6rem 0.8rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--table-border-color);
            font-size: 0.85rem;
            color: var(--dark-text);
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: var(--table-row-hover);
        }

        .truck-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid var(--table-border-color);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            display: block;
            margin: 0 auto;
        }

        .image-placeholder {
            width: 50px;
            height: 50px;
            background-color: var(--table-header-bg);
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
            border: 1px dashed var(--table-border-color);
            font-size: 1.2rem;
            margin: 0 auto;
        }

        .circle-plus {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: bold;
            font-size: 0.8rem;
            background: none;
        }

        .kebab-menu-container {
            position: relative;
            display: inline-block;
            margin: 0 auto;
        }

        .kebab-menu-toggle {
            padding: 0.3rem 0.6rem;
            font-size: 0.85rem;
            border: none;
            background: none;
            color: var(--dark-text);
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.2s;
        }

        .kebab-menu-toggle:hover {
            background-color: #e9ecef;
        }

        .action-btns {
            display: none;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 100%;
            z-index: 10;
            flex-direction: row;
            background-color: #ffffff;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
            border-radius: 6px;
            padding: 0.4rem;
            gap: 0.4rem;
            white-space: nowrap;
        }

        .action-btns.show {
            display: flex;
        }

        .action-btns .btn-action {
            padding: 0.4rem 0.6rem;
            font-size: 0.85rem;
            border-radius: 5px;
            transition: all 0.2s;
        }

        .btn-view {
            color: var(--primary-color);
            border: none;
        }

        .btn-view:hover {
            background-color: #e7f3fe;
            color: #1d4ed8;
        }

        .btn-edit {
            color: var(--success-color);
            border: none;
        }

        .btn-edit:hover {
            background-color: #e8f5e9;
            color: #1b5e20;
        }

        .btn-archive {
            color: var(--danger-color);
            border: none;
        }

        .btn-archive:hover {
            background-color: #fee5e3;
            color: #b91c1c;
        }

        .empty-message {
            padding: 2rem;
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .empty-message i {
            font-size: 2rem;
            margin-bottom: 0.75rem;
            color: #dee2e6;
        }

        .truck-image-lg {
            max-width: 100%;
            max-height: 250px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            display: block;
            margin: 0 auto;
        }

        .search-container {
            margin: 0.75rem 0;
            display: flex;
            gap: 0.5rem;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-input {
            position: relative;
            max-width: 280px;
            width: 100%;
            margin-left: auto;
        }

        .search-input input {
            padding: 0.5rem 0.8rem 0.5rem 2.2rem;
            border-radius: 18px;
            border: 1px solid var(--secondary-color);
            background: #ffffff;
            font-size: 0.9rem;
            color: var(--dark-text);
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            width: 100%;
        }

        .search-input input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
            background: #ffffff;
        }

        .search-input i {
            position: absolute;
            left: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-color);
            font-size: 1rem;
            pointer-events: none;
            opacity: 0.7;
        }

        .swal2-icon.swal2-warning {
            border-color: var(--warning-color) !important;
            color: var(--warning-color) !important;
        }

        .swal2-icon.swal2-warning .swal2-icon-content {
            font-size: 2em !important;
        }

        .swal2-title {
            font-weight: 600 !important;
            color: #333 !important;
        }

        .swal2-html-container {
            color: #666 !important;
            margin-bottom: 1em !important;
        }

        .swal2-confirm {
            background-color: var(--danger-color) !important;
            color: white !important;
            font-weight: 600 !important;
            padding: 0.4rem 1rem !important;
            border-radius: 5px !important;
        }

        .swal2-cancel {
            background-color: #95a5a6 !important;
            color: white !important;
            font-weight: 600 !important;
            padding: 0.4rem 1rem !important;
            border-radius: 5px !important;
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.full-width {
                margin-left: 0;
            }

            .header {
                position: relative;
            }

            .header::before {
                content: '\f0c9';
                font-family: 'Font Awesome 6 Free';
                font-weight: 900;
                font-size: 1.5rem;
                color: var(--secondary-color);
                cursor: pointer;
                position: absolute;
                left: 0.5rem;
                top: 50%;
                transform: translateY(-50%);
                display: block;
            }

            .table-responsive {
                max-height: calc(100vh - 220px);
            }
        }

        @media (max-width: 768px) {
            .search-container {
                flex-direction: column;
                gap: 0.75rem;
                align-items: stretch;
            }

            .search-input {
                max-width: 100%;
                margin: 0;
            }

            .search-input input {
                font-size: 0.85rem;
                padding-left: 2rem;
            }

            .search-input i {
                font-size: 0.9rem;
                left: 0.7rem;
            }

            .table-responsive {
                margin: 0 -0.5rem;
                max-height: calc(100vh - 250px);
            }

            .table thead th,
            .table tbody td {
                padding: 0.5rem 0.6rem;
                font-size: 0.8rem;
            }

            .truck-image,
            .image-placeholder {
                width: 45px;
                height: 45px;
            }

            .circle-plus {
                width: 18px;
                height: 18px;
                font-size: 0.7rem;
            }

            .btn-primary {
                font-size: 0.95rem !important;
                padding: 0.35rem 0.7rem !important;
            }

            .action-btns {
                gap: 0.3rem;
            }

            .action-btns .btn-action {
                padding: 0.35rem 0.5rem;
                font-size: 0.8rem;
            }

            .card-body {
                padding: 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.5rem;
                border-radius: 8px;
            }

            .header h2 {
                font-size: 1.25rem;
            }

            .header::before {
                font-size: 1.2rem;
            }

            .table thead th,
            .table tbody td {
                padding: 0.4rem 0.5rem;
                font-size: 0.75rem;
            }

            .truck-image,
            .image-placeholder {
                width: 40px;
                height: 40px;
            }

            .search-input input {
                padding: 0.4rem 0.7rem 0.4rem 1.8rem;
                font-size: 0.8rem;
            }

            .search-input i {
                font-size: 0.8rem;
                left: 0.6rem;
            }

            .empty-message {
                padding: 1.5rem;
                font-size: 0.85rem;
            }

            .empty-message i {
                font-size: 1.5rem;
            }

            .action-btns {
                padding: 0.3rem;
            }

            .kebab-menu-toggle {
                padding: 0.2rem 0.5rem;
            }

            .card {
                margin-bottom: 1rem;
            }

            .alert {
                font-size: 0.8rem;
                padding: 0.5rem;
            }
        }

        @media (max-width: 360px) {
            .table thead th,
            .table tbody td {
                padding: 0.3rem 0.4rem;
                font-size: 0.7rem;
            }

            .btn-primary {
                font-size: 0.85rem !important;
                padding: 0.3rem 0.6rem !important;
            }

            .circle-plus {
                width: 16px;
                height: 16px;
                font-size: 0.6rem;
            }

            .search-input {
                max-width: 100%;
            }

            .search-input input {
                font-size: 0.75rem;
                padding-left: 1.6rem;
            }

            .search-input i {
                font-size: 0.7rem;
                left: 0.5rem;
            }

            .header h2 {
                font-size: 1.1rem;
            }

            .header::before {
                font-size: 1rem;
            }

            .action-btns .btn-action {
                padding: 0.3rem 0.4rem;
                font-size: 0.75rem;
            }

            .truck-image-lg {
                max-height: 200px;
            }
        }

        @media (max-width: 320px) {
            .table thead th,
            .table tbody td {
                padding: 0.25rem 0.3rem;
                font-size: 0.65rem;
            }

            .truck-image,
            .image-placeholder {
                width: 35px;
                height: 35px;
            }

            .search-container {
                gap: 0.5rem;
            }

            .btn-primary {
                font-size: 0.8rem !important;
                padding: 0.25rem 0.5rem !important;
            }

            .circle-plus {
                width: 14px;
                height: 14px;
                font-size: 0.55rem;
            }

            .empty-message {
                padding: 1rem;
                font-size: 0.8rem;
            }

            .empty-message i {
                font-size: 1.2rem;
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
            
        <div class="search-container m-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTruckModal">
                <span class="circle-plus">+</span> Add Truck
            </button>
            <div class="search-input">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" class="form-control" placeholder="Search by plate number...">
            </div>
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
                                    <div class="kebab-menu-container">
                                        <button class="kebab-menu-toggle" type="button" aria-expanded="false" aria-label="More options">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="action-btns">
                                            <button class="btn-action btn-view" data-bs-toggle="modal" data-bs-target="#viewTruckModal{{ $truck->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#editTruckModal{{ $truck->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn-action btn-archive" onclick="confirmArchive({{ $truck->id }})">
                                                <i class="fas fa-archive"></i>
                                            </button>
                                            <form id="archive-form-{{ $truck->id }}" action="{{ route('admin.truckdetails.destroy', $truck->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('click', function(event) {
            const kebabMenuToggle = event.target.closest('.kebab-menu-toggle');
            const kebabMenuContainer = event.target.closest('.kebab-menu-container');

            document.querySelectorAll('.action-btns.show').forEach(menu => {
                const currentMenuContainer = menu.closest('.kebab-menu-container');
                if (currentMenuContainer !== kebabMenuContainer) {
                    menu.classList.remove('show');
                    currentMenuContainer.querySelector('.kebab-menu-toggle').setAttribute('aria-expanded', 'false');
                }
            });

            if (kebabMenuToggle) {
                const actionBtns = kebabMenuContainer.querySelector('.action-btns');
                actionBtns.classList.toggle('show');
                const isExpanded = actionBtns.classList.contains('show');
                kebabMenuToggle.setAttribute('aria-expanded', isExpanded);
            }

            // Toggle sidebar on hamburger click
            if (event.target.closest('.header::before') || event.target.closest('.header')) {
                const sidebar = document.querySelector('.sidebar');
                const mainContent = document.querySelector('.main-content');
                sidebar.classList.toggle('active');
                mainContent.classList.toggle('full-width');
            }
        });

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

        function confirmArchive(truckId) {
            Swal.fire({
                title: 'Are you sure?',
                html: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Yes, archive it!',
                cancelButtonText: 'Cancel',
                customClass: {
                    icon: 'swal2-warning-custom'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('archive-form-' + truckId).submit();
                }
            });
        }
    </script>
</body>
</html>