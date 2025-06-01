<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Accounts</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
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
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        
        .btn-success {
          background: none;
        color: #1f1a5c;
        border: none;
        padding: 8px 15px;
        border-radius: 8px;
        font-size: 1.2rem;
        font-weight:800;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        white-space: nowrap;
    }

button.btn.btn-success {
    background: transparent !important;
    color: #1f1a5c !important;
    border: none !important;
    font-size: 1.2rem !important;
    font-weight: 600 !important;
}
button.btn.btn-success:hover {
    background-color: rgba(0, 0, 0, 0.1) !important;
      
}
 
  .circle-plus {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border:2px solid #2f4156;
    color: #2f4156;
    font-weight: bold;
    font-size: 1rem;
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
            text-align: center;
            vertical-align: middle;
        }
        
        .table tbody td {
            padding: 12px 20px;
            vertical-align: middle;
            text-align: center;
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
            border: none;
            border-radius: 5px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
            white-space: nowrap;
        }
        
        
        .btn-view {
           background-color: rgba(0, 173, 12, 0.09);
            color:green;
        }
        
        .btn-view:hover {
            background-color:rgba(22, 160, 132, 0.35);
            color: green;
        }
        
        .btn-edit {
            background-color: rgba(0, 74, 173, 0.1);
            color: #004aad;
        }
        
        .btn-edit:hover {
             background-color: rgba(0, 74, 173, 0.2);
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .btn-archive {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        .btn-archive:hover {
             background-color: rgba(220, 53, 69, 0.2);
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
            justify-content: center;
            flex-wrap: nowrap;
        }

        .badge {
            padding: 6px 10px;
            font-weight: 500;
            border-radius: 4px;
        }
        
        .search-container {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            align-items: center;
        }
        
        .search-input {
            flex: unset;
            max-width: 300px;
            position: relative;
            margin-left: auto;
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
            
            .action-btns {
                flex-wrap: wrap;
                gap: 4px;
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
            <h2>Active Accounts</h2>
        </div>
        <ul>
            <x-navbar/>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h2><i class="fas fa-users"></i> Active Accounts</h2>
            
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
                
                <!-- Search Bar -->
                <div class="search-container m-3">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createAccountModal">
                <span class="circle-plus">+</span> Create New Account
            </button>
                    <div class="search-input">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search by username...">
                    </div>

                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover" id="accountsTable">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Mobile Number</th>
                                <th>Role</th>
                                <th style="min-width: 220px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="active-accounts-body">
                            @foreach($users as $user)
                            <tr class="account-row">
                                <td class="username">{{ $user->username }}</td>
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
    @include('admin.modals.view_account_modal')
    @include('admin.modals.edit_account_modal')
    @include('admin.modals.create_account_modal')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const rows = document.querySelectorAll('.account-row');
                    
                    rows.forEach(row => {
                        const username = row.querySelector('.username').textContent.toLowerCase();
                        if (username.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

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