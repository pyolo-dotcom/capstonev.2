<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archives Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
        
        .card-header {
            background-color: var(--secondary-color);
            color: white;
            padding: 15px 20px;
            border-bottom: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-header h3 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
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
        
        .badge {
            padding: 6px 10px;
            font-weight: 500;
            font-size: 0.75rem;
        }
        
        .actions {
            display: flex;
            gap: 8px;
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
        
        .btn-restore {
            background-color: rgba(0, 173, 12, 0.09);
            color:green;
        }
        
        .btn-restore:hover {
            background-color:rgba(22, 160, 132, 0.35);
            color: green;
        }
        
        .btn-delete {
             background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        .btn-delete:hover {
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
        
        .truck-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #dee2e6;
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
        
        .search-container {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        
        .search-input {
            flex: 1;
            max-width: 300px;
            position: relative;
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
            border-radius: 20px;
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
            
            .search-container {
                flex-direction: column;
            }
            
            .search-input {
                max-width: 100%;
            }
            
            .actions {
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
            
            .table-responsive {
                margin: 0 -15px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2>Archives Management</h2>
        </div>
        <ul>
            <x-navbar/>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h2><i class="fas fa-archive"></i>Archives Management</h2>
        </div>
        
        <!-- Search Bar -->
        <div class="search-container">
            <div class="search-input">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" class="form-control" placeholder="Search archives...">
            </div>
            <button class="btn btn-primary" id="searchBtn">
                <i class="fas fa-search me-1"></i> Search
            </button>
        </div>
        
        <!-- Archived Accounts Card -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-users"></i>Archived Accounts</h3>
            </div>
            <div class="card-body">
                @if($archivedUsers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="accountsTable">
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
                        <tbody>
                            @foreach($archivedUsers as $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->fullname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile_number }}</td>
                                <td><span class="badge bg-primary">{{ ucfirst($user->role) }}</span></td>
                                <td class="actions">
                                    <form id="restoreAccountForm{{ $user->id }}" action="{{ route('admin.archive.restore.account', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" class="btn-action btn-restore" onclick="confirmRestoreAccount({{ $user->id }}, '{{ $user->username }}')">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>
                                    <form id="deleteAccountForm{{ $user->id }}" action="{{ route('admin.archive.delete.account', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action btn-delete" onclick="confirmDeleteAccount({{ $user->id }}, '{{ $user->username }}')">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-message">
                    <i class="fas fa-folder-open"></i>
                    <h5>No archived accounts found</h5>
                    <p class="text-muted">There are currently no archived user accounts.</p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Archived Profits Card -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-chart-line"></i>Archived Profits</h3>
            </div>
            <div class="card-body">
                @if($archivedProfits->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="profitsTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Plate Number</th>
                                <th>Total Income</th>
                                <th>Total Expenses</th>
                                <th>Total Profit</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($archivedProfits as $profit)
                            <tr>
                                <td>{{ $profit->date }}</td>
                                <td>{{ $profit->plate_number }}</td>
                                <td>P {{ number_format($profit->total_income, 2) }}</td>
                                <td>P {{ number_format($profit->total_expenses, 2) }}</td>
                                <td>P {{ number_format($profit->total_profit, 2) }}</td>
                                <td class="actions">
                                    <form id="restoreProfitForm{{ $profit->id }}" action="{{ route('admin.archive.restore.profit', $profit->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" class="btn-action btn-restore" onclick="confirmRestoreProfit({{ $profit->id }}, '{{ $profit->plate_number }}')">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>
                                    <form id="deleteProfitForm{{ $profit->id }}" action="{{ route('admin.archive.delete.profit', $profit->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action btn-delete" onclick="confirmDeleteProfit({{ $profit->id }}, '{{ $profit->plate_number }}')">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-message">
                    <i class="fas fa-folder-open"></i>
                    <h5>No archived profits found</h5>
                    <p class="text-muted">There are currently no archived profit records.</p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Archived Fuel Consumption Card -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-gas-pump"></i>Archived Fuel Consumption</h3>
            </div>
            <div class="card-body">
                @if($archivedFuel->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="fuelTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Plate No.</th>
                                <th>Total KM</th>
                                <th>Avg KM/L</th>
                                <th>Total Liters</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($archivedFuel as $fuel)
                            <tr>
                                <td>{{ $fuel->date }}</td>
                                <td>{{ $fuel->plate_no }}</td>
                                <td>{{ $fuel->total_km }} km</td>
                                <td>{{ $fuel->avg_km_l }} km/L</td>
                                <td>{{ $fuel->total_liters }} L</td>
                                <td class="actions">
                                    <form id="restoreFuelForm{{ $fuel->id }}" action="{{ route('admin.archive.restore.fuel', $fuel->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" class="btn-action btn-restore" onclick="confirmRestoreFuel({{ $fuel->id }}, '{{ $fuel->plate_no }}')">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>
                                    <form id="deleteFuelForm{{ $fuel->id }}" action="{{ route('admin.archive.delete.fuel', $fuel->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action btn-delete" onclick="confirmDeleteFuel({{ $fuel->id }}, '{{ $fuel->plate_no }}')">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-message">
                    <i class="fas fa-folder-open"></i>
                    <h5>No archived fuel records found</h5>
                    <p class="text-muted">There are currently no archived fuel consumption records.</p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Archived Trips Card -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-truck"></i>Archived Trips</h3>
            </div>
            <div class="card-body">
                @if($archivedTrips->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="tripsTable">
                        <thead>
                            <tr>
                                <th>Plate No.</th>
                                <th>Date</th>
                                <th>EIR No.</th>
                                <th>Container No.</th>
                                <th>Size</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($archivedTrips as $trip)
                            <tr>
                                <td>{{ $trip->plate_no }}</td>
                                <td>{{ $trip->created_at->format('Y-m-d') }}</td>
                                <td>{{ $trip->eir_no }}</td>
                                <td>{{ $trip->container_van_no }}</td>
                                <td>{{ $trip->size }}</td>
                                <td class="actions">
                                    <form id="restoreTripForm{{ $trip->id }}" action="{{ route('admin.archive.restore.trip', $trip->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" class="btn-action btn-restore" onclick="confirmRestoreTrip({{ $trip->id }}, '{{ $trip->plate_no }}')">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>
                                    <form id="deleteTripForm{{ $trip->id }}" action="{{ route('admin.archive.delete.trip', $trip->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action btn-delete" onclick="confirmDeleteTrip({{ $trip->id }}, '{{ $trip->plate_no }}')">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="empty-message">
                    <i class="fas fa-folder-open"></i>
                    <h5>No archived trips found</h5>
                    <p class="text-muted">There are currently no archived trip records.</p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Archived Trucks Card -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-truck-moving"></i>Archived Trucks</h3>
            </div>
            <div class="card-body">
                @if($archivedTrucks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" id="trucksTable">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>CR Number</th>
                                <th>Plate Number</th>
                                <th>Owner Name</th>
                                <th>Make</th>
                                <th>Year Model</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($archivedTrucks as $truck)
                            <tr>
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
                                <td>{{ $truck->plate_number }}</td>
                                <td>{{ $truck->owner_name }}</td>
                                <td>{{ $truck->make }}</td>
                                <td>{{ $truck->year_model }}</td>
                                <td>
                                    <div class="actions">
                                        <form id="restoreTruckForm{{ $truck->id }}" action="{{ route('admin.archive.restore.truck', $truck->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="button" class="btn-action btn-restore" onclick="confirmRestoreTruck({{ $truck->id }}, '{{ $truck->plate_number }}')">
                                                <i class="fas fa-undo"></i> Restore
                                            </button>
                                        </form>
                                        <form id="deleteTruckForm{{ $truck->id }}" action="{{ route('admin.archive.delete.truck', $truck->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-action btn-delete" onclick="confirmDeleteTruck({{ $truck->id }}, '{{ $truck->plate_number }}')">
                                                <i class="fas fa-trash-alt"></i> Delete
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
                    <i class="fas fa-folder-open"></i>
                    <h5>No archived trucks found</h5>
                    <p class="text-muted">There are currently no archived truck records.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');
            
            // Search when button is clicked
            searchBtn.addEventListener('click', function() {
                performSearch();
            });
            
            // Search when Enter key is pressed
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performSearch();
                }
            });
            
            function performSearch() {
                const searchTerm = searchInput.value.trim().toLowerCase();
                if (searchTerm === '') return;
                
                // Search through all tables
                const tables = [
                    'accountsTable',
                    'profitsTable',
                    'fuelTable',
                    'tripsTable',
                    'trucksTable'
                ];
                
                let foundResults = false;
                
                tables.forEach(tableId => {
                    const table = document.getElementById(tableId);
                    if (!table) return;
                    
                    const rows = table.getElementsByTagName('tr');
                    let tableHasResults = false;
                    
                    for (let i = 1; i < rows.length; i++) { // Skip header row
                        const row = rows[i];
                        const rowText = row.textContent.toLowerCase();
                        
                        if (rowText.includes(searchTerm)) {
                            row.style.display = '';
                            tableHasResults = true;
                            foundResults = true;
                        } else {
                            row.style.display = 'none';
                        }
                    }
                    
                    // Show/hide "no results" message for this table
                    const noResultsMsg = table.parentElement.querySelector('.no-results-message');
                    if (!tableHasResults) {
                        if (!noResultsMsg) {
                            const msg = document.createElement('div');
                            msg.className = 'empty-message no-results-message';
                            msg.innerHTML = `
                                <i class="fas fa-search"></i>
                                <h5>No matching results found</h5>
                                <p class="text-muted">No records match your search criteria.</p>
                            `;
                            table.parentElement.appendChild(msg);
                        }
                    } else if (noResultsMsg) {
                        noResultsMsg.remove();
                    }
                });
                
                // Show overall message if no results found in any table
                if (!foundResults) {
                    Swal.fire({
                        title: 'No Results Found',
                        text: 'Your search did not match any archived records.',
                        icon: 'info',
                        confirmButtonColor: '#2c3e50'
                    });
                }
            }
            
            // Clear search when input is empty
            searchInput.addEventListener('input', function() {
                if (this.value.trim() === '') {
                    resetSearch();
                }
            });
            
            function resetSearch() {
                const tables = [
                    'accountsTable',
                    'profitsTable',
                    'fuelTable',
                    'tripsTable',
                    'trucksTable'
                ];
                
                tables.forEach(tableId => {
                    const table = document.getElementById(tableId);
                    if (!table) return;
                    
                    const rows = table.getElementsByTagName('tr');
                    for (let i = 1; i < rows.length; i++) {
                        rows[i].style.display = '';
                    }
                    
                    // Remove any "no results" messages
                    const noResultsMsg = table.parentElement.querySelector('.no-results-message');
                    if (noResultsMsg) {
                        noResultsMsg.remove();
                    }
                });
            }
        });
        
        // SweetAlert confirmation functions
        function showConfirmation(title, text, icon, confirmButtonText, callback) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: '#2ecc71',
                cancelButtonColor: '#e74c3c',
                confirmButtonText: confirmButtonText,
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    callback();
                }
            });
        }
        
        // Account actions
        function confirmRestoreAccount(id, username) {
            showConfirmation(
                'Restore Account?',
                `Are you sure you want to restore the account "${username}"?`,
                'question',
                'Yes, Restore',
                () => document.getElementById(`restoreAccountForm${id}`).submit()
            );
        }
        
        function confirmDeleteAccount(id, username) {
            showConfirmation(
                'Permanently Delete Account?',
                `WARNING: This will permanently delete the account "${username}". This action cannot be undone!`,
                'warning',
                'Yes, Delete Permanently',
                () => document.getElementById(`deleteAccountForm${id}`).submit()
            );
        }
        
        // Profit actions
        function confirmRestoreProfit(id, plateNumber) {
            showConfirmation(
                'Restore Profit Record?',
                `Are you sure you want to restore the profit record for plate number "${plateNumber}"?`,
                'question',
                'Yes, Restore',
                () => document.getElementById(`restoreProfitForm${id}`).submit()
            );
        }
        
        function confirmDeleteProfit(id, plateNumber) {
            showConfirmation(
                'Permanently Delete Profit Record?',
                `WARNING: This will permanently delete the profit record for plate number "${plateNumber}". This action cannot be undone!`,
                'warning',
                'Yes, Delete Permanently',
                () => document.getElementById(`deleteProfitForm${id}`).submit()
            );
        }
        
        // Fuel actions
        function confirmRestoreFuel(id, plateNumber) {
            showConfirmation(
                'Restore Fuel Record?',
                `Are you sure you want to restore the fuel record for plate number "${plateNumber}"?`,
                'question',
                'Yes, Restore',
                () => document.getElementById(`restoreFuelForm${id}`).submit()
            );
        }
        
        function confirmDeleteFuel(id, plateNumber) {
            showConfirmation(
                'Permanently Delete Fuel Record?',
                `WARNING: This will permanently delete the fuel record for plate number "${plateNumber}". This action cannot be undone!`,
                'warning',
                'Yes, Delete Permanently',
                () => document.getElementById(`deleteFuelForm${id}`).submit()
            );
        }
        
        // Trip actions
        function confirmRestoreTrip(id, plateNumber) {
            showConfirmation(
                'Restore Trip Record?',
                `Are you sure you want to restore the trip record for plate number "${plateNumber}"?`,
                'question',
                'Yes, Restore',
                () => document.getElementById(`restoreTripForm${id}`).submit()
            );
        }
        
        function confirmDeleteTrip(id, plateNumber) {
            showConfirmation(
                'Permanently Delete Trip Record?',
                `WARNING: This will permanently delete the trip record for plate number "${plateNumber}". This action cannot be undone!`,
                'warning',
                'Yes, Delete Permanently',
                () => document.getElementById(`deleteTripForm${id}`).submit()
            );
        }
        
        // Truck actions
        function confirmRestoreTruck(id, plateNumber) {
            showConfirmation(
                'Restore Truck Record?',
                `Are you sure you want to restore the truck record for plate number "${plateNumber}"?`,
                'question',
                'Yes, Restore',
                () => document.getElementById(`restoreTruckForm${id}`).submit()
            );
        }
        
        function confirmDeleteTruck(id, plateNumber) {
            showConfirmation(
                'Permanently Delete Truck Record?',
                `WARNING: This will permanently delete the truck record for plate number "${plateNumber}". This action cannot be undone!`,
                'warning',
                'Yes, Delete Permanently',
                () => document.getElementById(`deleteTruckForm${id}`).submit()
            );
        }
    </script>
</body>
</html>