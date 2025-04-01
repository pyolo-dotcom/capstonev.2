<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Accounts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --info-color: #17a2b8;
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
            background-color: #f5f7fa;
        }
        
        .sidebar {
            width: 250px;
            height: 100vh;
            background: var(--secondary-color);
            padding: 20px 0;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        
        .sidebar-brand {
            padding: 0 20px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        
        .sidebar-brand h2 {
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
        }
        
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        
        .sidebar ul li a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: all 0.3s;
            font-size: 0.95rem;
            border-left: 3px solid transparent;
        }
        
        .sidebar ul li a:hover, 
        .sidebar ul li a.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left: 3px solid var(--primary-color);
            padding-left: 17px;
        }
        
        .sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
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
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .table thead th {
            background-color: var(--secondary-color);
            color: white;
            font-weight: 500;
            padding: 15px 20px;
            text-align: center;
            vertical-align: middle;
        }
        
        .table tbody td {
            padding: 12px 20px;
            vertical-align: middle;
            text-align: center;
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
            background-color: #138496;
            color: white;
            transform: translateY(-1px);
        }
        
        .btn-edit {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }
        
        .btn-edit:hover {
            background-color: #2980b9;
            color: white;
            transform: translateY(-1px);
        }
        
        .btn-archive {
            background-color: var(--danger-color);
            color: white;
            border: none;
        }
        
        .btn-archive:hover {
            background-color: #c0392b;
            color: white;
            transform: translateY(-1px);
        }
        
        .action-btns {
            display: flex;
            gap: 6px;
            justify-content: center;
        }
        
        .modal-content {
            border-radius: 10px;
            padding: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
        }
        
        .input-box {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            width: 100%;
        }
        
        .input-box:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }
        
        .submit-button {
            padding: 10px;
            border-radius: 5px;
            font-weight: 500;
            margin-top: 15px;
        }
        
        .alert {
            border-radius: 8px;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }
            
            .sidebar-brand h2 {
                display: none;
            }
            
            .sidebar ul li a span {
                display: none;
            }
            
            .sidebar ul li a i {
                margin-right: 0;
                font-size: 1.2rem;
            }
            
            .main-content {
                margin-left: 70px;
                width: calc(100% - 70px);
                padding: 15px;
            }
            
            .action-btns {
                flex-direction: column;
                gap: 4px;
            }
            
            .btn-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2>Active Accounts</h2>
        </div>
        <ul>
            <x-navbar/>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h2><i class="fas fa-users me-2"></i>Active Accounts</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createAccountModal">
                <i class="fas fa-plus me-2"></i>Create New Account
            </button>
        </div>
        
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Mobile Number</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="active-accounts-body">
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->fullname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile_number }}</td>
                                <td><span class="badge bg-primary">{{ ucfirst($user->role) }}</span></td>
                                <td>
                                    <div class="action-btns">
                                        <button class="btn-action btn-view" 
                                                data-id="{{ $user->id }}" 
                                                data-username="{{ $user->username }}" 
                                                data-fullname="{{ $user->fullname }}" 
                                                data-email="{{ $user->email }}" 
                                                data-mobile_number="{{ $user->mobile_number }}"
                                                data-dob="{{ $user->dob }}"
                                                data-role="{{ $user->role }}" 
                                                data-license-number="{{ $user->driver_license_number }}"
                                                data-license-type="{{ $user->license_type }}"
                                                data-license-expiry="{{ $user->license_expiry_date }}"
                                                data-truck-id="{{ $user->truck_id }}"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#viewAccountModal">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="btn-action btn-edit edit-btn" 
                                                data-id="{{ $user->id }}" 
                                                data-username="{{ $user->username }}" 
                                                data-fullname="{{ $user->fullname }}" 
                                                data-email="{{ $user->email }}" 
                                                data-mobile_number="{{ $user->mobile_number }}"
                                                data-dob="{{ $user->dob }}"
                                                data-role="{{ $user->role }}" 
                                                data-license-number="{{ $user->driver_license_number }}"
                                                data-license-type="{{ $user->license_type }}"
                                                data-license-expiry="{{ $user->license_expiry_date }}"
                                                data-truck-id="{{ $user->truck_id }}"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editArchiveModal">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn-action btn-archive archive-btn" 
                                                data-id="{{ $user->id }}" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editArchiveModal">
                                            <i class="fas fa-archive"></i> Archive
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Modals -->
    @include('Admin.modals.view_account_modal')
    @include('Admin.modals.edit_account_modal')
    @include('Admin.modals.create_account_modal')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // View button click handler
            document.querySelectorAll('.btn-view').forEach(button => {
                button.addEventListener('click', () => {
                    const username = button.getAttribute('data-username');
                    const fullname = button.getAttribute('data-fullname');
                    const email = button.getAttribute('data-email');
                    const mobile_number = button.getAttribute('data-mobile_number');
                    const dob = button.getAttribute('data-dob');
                    const role = button.getAttribute('data-role');
                    const licenseNumber = button.getAttribute('data-license-number');
                    const licenseType = button.getAttribute('data-license-type');
                    const licenseExpiry = button.getAttribute('data-license-expiry');
                    const truckId = button.getAttribute('data-truck-id');

                    // Format dates
                    const formattedDob = dob ? new Date(dob).toLocaleDateString() : '-';
                    const formattedExpiry = licenseExpiry ? new Date(licenseExpiry).toLocaleDateString() : '-';

                    // Set values in view modal
                    document.getElementById('view-username').textContent = username;
                    document.getElementById('view-fullname').textContent = fullname;
                    document.getElementById('view-email').textContent = email;
                    document.getElementById('view-mobile').textContent = mobile_number;
                    document.getElementById('view-dob').textContent = formattedDob;
                    document.getElementById('view-role').textContent = role.charAt(0).toUpperCase() + role.slice(1);
                    
                    // Handle driver fields
                    const driverFields = document.getElementById('view-driver-fields');
                    if (role === 'driver') {
                        driverFields.style.display = 'block';
                        document.getElementById('view-license-number').textContent = licenseNumber || '-';
                        document.getElementById('view-license-type').textContent = licenseType || '-';
                        document.getElementById('view-license-expiry').textContent = formattedExpiry;
                        document.getElementById('view-truck-id').textContent = truckId || '-';
                    } else {
                        driverFields.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>