<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Accounts, Profits, and Fuel Consumption</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
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
        .table-container {
            margin-bottom: 40px;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .actions button.restore {
            background-color: #4CAF50;
            color: white;
        }
        .actions button.delete {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <ul>
            <x-navbar/>
        </ul>
    </div>

    <div class="content">
        <h2>Archived Accounts</h2>
        <div class="table-container">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Employee ID</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($archivedUsers as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td class="actions">
                            <!-- Restore Button -->
                            <form id="restoreAccountForm{{ $user->id }}" action="{{ route('admin.archive.restore.account', $user->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <button type="button" class="restore" onclick="confirmRestoreAccount({{ $user->id }})">Restore</button>
                            </form>

                            <!-- Permanent Delete Button -->
                            <form id="deleteAccountForm{{ $user->id }}" action="{{ route('admin.archive.delete.account', $user->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="delete" onclick="confirmDeleteAccount({{ $user->id }})">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h2>Archived Profits</h2>
        <div class="table-container">
            <table class="table table-bordered">
                <thead class="table-dark">
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
                            <!-- Restore Button -->
                            <form id="restoreProfitForm{{ $profit->id }}" action="{{ route('admin.archive.restore.profit', $profit->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <button type="button" class="restore" onclick="confirmRestoreProfit({{ $profit->id }})">Restore</button>
                            </form>

                            <!-- Permanent Delete Button -->
                            <form id="deleteProfitForm{{ $profit->id }}" action="{{ route('admin.archive.delete.profit', $profit->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="delete" onclick="confirmDeleteProfit({{ $profit->id }})">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h2>Archived Fuel Consumption</h2>
        <div class="table-container">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
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
                        <td>{{ $fuel->id }}</td>
                        <td>{{ $fuel->date }}</td>
                        <td>{{ $fuel->plate_no }}</td>
                        <td>{{ $fuel->total_km }}</td>
                        <td>{{ $fuel->avg_km_l }}</td>
                        <td>{{ $fuel->total_liters }}</td>
                        <td class="actions">
                            <!-- Restore Button -->
                            <form id="restoreFuelForm{{ $fuel->id }}" action="{{ route('admin.archive.restore.fuel', $fuel->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <button type="button" class="restore" onclick="confirmRestoreFuel({{ $fuel->id }})">Restore</button>
                            </form>

                            <!-- Permanent Delete Button -->
                            <form id="deleteFuelForm{{ $fuel->id }}" action="{{ route('admin.archive.delete.fuel', $fuel->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="delete" onclick="confirmDeleteFuel({{ $fuel->id }})">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Function to confirm restore action for accounts
        function confirmRestoreAccount(id) {
            if (confirm("Are you sure you want to restore this account?")) {
                document.getElementById('restoreAccountForm' + id).submit();
            }
        }

        // Function to confirm delete action for accounts
        function confirmDeleteAccount(id) {
            if (confirm("Are you sure you want to permanently delete this account?")) {
                document.getElementById('deleteAccountForm' + id).submit();
            }
        }

        // Function to confirm restore action for profits
        function confirmRestoreProfit(id) {
            if (confirm("Are you sure you want to restore this profit record?")) {
                document.getElementById('restoreProfitForm' + id).submit();
            }
        }

        // Function to confirm delete action for profits
        function confirmDeleteProfit(id) {
            if (confirm("Are you sure you want to permanently delete this profit record?")) {
                document.getElementById('deleteProfitForm' + id).submit();
            }
        }

        // Function to confirm restore action for fuel consumption
        function confirmRestoreFuel(id) {
            if (confirm("Are you sure you want to restore this fuel consumption record?")) {
                document.getElementById('restoreFuelForm' + id).submit();
            }
        }

        // Function to confirm delete action for fuel consumption
        function confirmDeleteFuel(id) {
            if (confirm("Are you sure you want to permanently delete this fuel consumption record?")) {
                document.getElementById('deleteFuelForm' + id).submit();
            }
        }
    </script>
</body>
</html>