<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Active Accounts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            overflow-y: auto;
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
            height: 800px;
            overflow-y: auto;
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
        <div class="container">
            <div class="bahalana">
                <h2 class="text-center mb-4">Active Accounts</h2>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createAccountModal">Create New Account</button>
            </div>
            
            <div class="card p-4 shadow relative">
                <div class="table-container">
                    <table class="table text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Employee ID</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="active-accounts-body">
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->fullname}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->role}}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-primary edit-btn" 
                                            data-id="{{$user->id}}" 
                                            data-username="{{$user->username}}" 
                                            data-fullname="{{$user->fullname}}" 
                                            data-email="{{$user->email}}" 
                                            data-role="{{$user->role}}" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editArchiveModal">
                                        Edit
                                    </button>

                                    <!-- Archive Button -->
                                    <button class="btn btn-danger archive-btn" 
                                            data-id="{{$user->id}}" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editArchiveModal">
                                        Archive
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Generic Modal for Edit and Archive -->
    <div class="modal fade" id="editArchiveModal" tabindex="-1" aria-labelledby="editArchiveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 10px; padding: 40px;">
                <div class="modal-header" style="border-bottom: none;">
                    <h5 class="modal-title" id="editArchiveModalLabel">Modal Title</h5>
                    <button type="button" class="close-button" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="editArchiveForm" method="POST">
                        @csrf
                        @method('PUT') <!-- Default method, will be overridden by JavaScript -->
                        <div id="modalContent">
                            <!-- Content will be dynamically populated here -->
                        </div>
                        <button type="submit" class="btn btn-primary w-100 submit-button">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Create Account Modal -->
    @include('Admin.modals.create_account_modal')

    <script>
        // JavaScript to handle modal population and form submission
        document.addEventListener('DOMContentLoaded', function () {
            const editArchiveModal = document.getElementById('editArchiveModal');
            const editArchiveForm = document.getElementById('editArchiveForm');
            const modalTitle = document.getElementById('editArchiveModalLabel');
            const modalContent = document.getElementById('modalContent');

            // Event listener for Edit buttons
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    const username = button.getAttribute('data-username');
                    const fullname = button.getAttribute('data-fullname');
                    const email = button.getAttribute('data-email');
                    const role = button.getAttribute('data-role');

                    // Set modal title and content
                    modalTitle.textContent = 'Edit Account';
                    modalContent.innerHTML = `
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control" value="${username}" required>
                        </div>
                        <div class="form-group">
                            <label for="fullname">Full Name</label>
                            <input type="text" id="fullname" name="fullname" class="form-control" value="${fullname}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="${email}" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select id="role" name="role" class="form-control" required>
                                <option value="driver" ${role === 'driver' ? 'selected' : ''}>Driver</option>
                                <option value="manager" ${role === 'manager' ? 'selected' : ''}>Manager</option>
                                <option value="admin" ${role === 'admin' ? 'selected' : ''}>Admin</option>
                            </select>
                        </div>
                    `;

                    // Set form action and method
                    editArchiveForm.action = `/admin/activeaccount/${id}`;
                    editArchiveForm.querySelector('input[name="_method"]').value = 'PUT';
                });
            });

            // Event listener for Archive buttons
            document.querySelectorAll('.archive-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');

                    // Set modal title and content
                    modalTitle.textContent = 'Archive Account';
                    modalContent.innerHTML = `
                        <p>Are you sure you want to archive this account?</p>
                    `;

                    // Set form action and method
                    editArchiveForm.action = `/admin/activeaccount/${id}`;
                    editArchiveForm.querySelector('input[name="_method"]').value = 'DELETE';
                });
            });
        });
    </script>
</body>
</html>