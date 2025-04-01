<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archives Management</title>
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
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .table tbody tr {
            transition: all 0.2s;
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
            padding: 5px 10px;
            font-size: 0.8rem;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-restore {
            background-color: var(--success-color);
            color: white;
            border: none;
        }
        
        .btn-restore:hover {
            background-color: #27ae60;
            color: white;
        }
        
        .btn-delete {
            background-color: var(--danger-color);
            color: white;
            border: none;
        }
        
        .btn-delete:hover {
            background-color: #c0392b;
            color: white;
        }
        
        .empty-message {
            padding: 30px;
            text-align: center;
            color: #6c757d;
        }
        
        .empty-message i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #dee2e6;
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
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2>Archives</h2>
        </div>
        <ul>
            <x-navbar/>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h2><i class="fas fa-archive me-2"></i>Archives Management</h2>
        </div>
        
        <!-- Archived Accounts Card -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-users me-2"></i>Archived Accounts</h3>
            </div>
            <div class="card-body">
                @if($archivedUsers->count() > 0)
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
                                        <button type="button" class="btn-action btn-restore" onclick="confirmRestoreAccount({{ $user->id }})">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>
                                    <form id="deleteAccountForm{{ $user->id }}" action="{{ route('admin.archive.delete.account', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action btn-delete" onclick="confirmDeleteAccount({{ $user->id }})">
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
                <h3><i class="fas fa-chart-line me-2"></i>Archived Profits</h3>
            </div>
            <div class="card-body">
                @if($archivedProfits->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
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
                                        <button type="button" class="btn-action btn-restore" onclick="confirmRestoreProfit({{ $profit->id }})">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>
                                    <form id="deleteProfitForm{{ $profit->id }}" action="{{ route('admin.archive.delete.profit', $profit->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action btn-delete" onclick="confirmDeleteProfit({{ $profit->id }})">
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
                <h3><i class="fas fa-gas-pump me-2"></i>Archived Fuel Consumption</h3>
            </div>
            <div class="card-body">
                @if($archivedFuel->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
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
                                        <button type="button" class="btn-action btn-restore" onclick="confirmRestoreFuel({{ $fuel->id }})">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>
                                    <form id="deleteFuelForm{{ $fuel->id }}" action="{{ route('admin.archive.delete.fuel', $fuel->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action btn-delete" onclick="confirmDeleteFuel({{ $fuel->id }})">
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
                <h3><i class="fas fa-truck me-2"></i>Archived Trips</h3>
            </div>
            <div class="card-body">
                @if($archivedTrips->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
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
                                        <button type="button" class="btn-action btn-restore" onclick="confirmRestoreTrip({{ $trip->id }})">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>
                                    <form id="deleteTripForm{{ $trip->id }}" action="{{ route('admin.archive.delete.trip', $trip->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action btn-delete" onclick="confirmDeleteTrip({{ $trip->id }})">
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
                <h3><i class="fas fa-truck-moving me-2"></i>Archived Trucks</h3>
            </div>
            <div class="card-body">
                @if($archivedTrucks->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>CR Number</th>
                                <th>Plate Number</th>
                                <th>Owner Name</th>
                                <th>Make</th>
                                <th>Year Model</th>
                                <th style="width: 220px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($archivedTrucks as $truck)
                            <tr>
                                <td>
                                    @if($truck->image_path)
                                        <img src="{{ $truck->image_url }}" 
                                            alt="Truck {{ $truck->plate_number }}"
                                            class="truck-image" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <div style="width: 60px; height: 60px; background-color: #f8f9fa; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #6c757d; border: 1px dashed #dee2e6;">
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
                                            <button type="button" class="btn-action btn-restore" onclick="confirmRestoreTruck({{ $truck->id }})">
                                                <i class="fas fa-undo"></i> Restore
                                            </button>
                                        </form>
                                        <form id="deleteTruckForm{{ $truck->id }}" action="{{ route('admin.archive.delete.truck', $truck->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-action btn-delete" onclick="confirmDeleteTruck({{ $truck->id }})">
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
    <script>
        // Confirmation functions
        function confirmAction(id, message, formId) {
            if (confirm(message)) {
                document.getElementById(formId + id).submit();
            }
        }

        // Account actions
        function confirmRestoreAccount(id) {
            confirmAction(id, "Are you sure you want to restore this account?", "restoreAccountForm");
        }
        function confirmDeleteAccount(id) {
            confirmAction(id, "Are you sure you want to permanently delete this account?", "deleteAccountForm");
        }

        // Profit actions
        function confirmRestoreProfit(id) {
            confirmAction(id, "Are you sure you want to restore this profit record?", "restoreProfitForm");
        }
        function confirmDeleteProfit(id) {
            confirmAction(id, "Are you sure you want to permanently delete this profit record?", "deleteProfitForm");
        }

        // Fuel actions
        function confirmRestoreFuel(id) {
            confirmAction(id, "Are you sure you want to restore this fuel consumption record?", "restoreFuelForm");
        }
        function confirmDeleteFuel(id) {
            confirmAction(id, "Are you sure you want to permanently delete this fuel consumption record?", "deleteFuelForm");
        }

        // Trip actions
        function confirmRestoreTrip(id) {
            confirmAction(id, "Are you sure you want to restore this trip?", "restoreTripForm");
        }
        function confirmDeleteTrip(id) {
            confirmAction(id, "Are you sure you want to permanently delete this trip?", "deleteTripForm");
        }

        // Truck actions
        function confirmRestoreTruck(id) {
            confirmAction(id, "Are you sure you want to restore this truck?", "restoreTruckForm");
        }
        function confirmDeleteTruck(id) {
            confirmAction(id, "Are you sure you want to permanently delete this truck?", "deleteTruckForm");
        }
    </script>
</body>
</html>