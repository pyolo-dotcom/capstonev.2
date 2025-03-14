<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
            background-color: #f8f9fa;
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
        .profile-card {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .profile-picture-container {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }
        .profile-picture-container img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 3px solid #ddd;
            border-radius: 50%;
            cursor: pointer;
        }
        .profile-picture-container .edit-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 14px;
            opacity: 0;
            transition: opacity 0.3s;
            cursor: pointer;
        }
        .profile-picture-container:hover .edit-overlay {
            opacity: 1;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px;
            font-size: 16px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Menu</h2>
        <ul>
            <x-drivernavbar/>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="container mt-5 content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="profile-card text-center">
                    <!-- Profile Picture with Edit Overlay -->
                    <div class="profile-picture-container">
                        <img src="{{ asset($user->profile_picture ? 'storage/' . $user->profile_picture : 'images/profile.png') }}" 
                            alt="Profile Image" 
                            id="profileImagePreview">
                    </div>
                    
                    <!-- User Info -->
                    <h4 class="mt-3">{{ $user->fullname }}</h4>
                    <p class="text-muted">{{ $user->role }}</p>
                    <hr>

                    <!-- Display Profile Information -->
                    <div class="text-start">
                        <p><strong>Username:</strong> {{ $user->username }}</p>
                        <p><strong>Full Name:</strong> {{ $user->fullname }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Date of Birth:</strong> {{ $user->dob }}</p>
                        <p><strong>Driver's License Number:</strong> {{ $user->driver_license_number }}</p>
                        <p><strong>License Expiry Date:</strong> {{ $user->license_expiry_date }}</p>
                        <p><strong>License Type:</strong> {{ $user->license_type }}</p>
                    </div>

                    <!-- Edit Profile Button -->
                    <button type="button" class="btn btn-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        Edit Profile
                    </button>

                    <!-- Edit Driver's License Button -->
                    <button type="button" class="btn btn-info w-100 mt-3" data-bs-toggle="modal" data-bs-target="#editDriverLicenseModal">
                        Edit Driver's License
                    </button>

                    <!-- Change Password Button -->
                    <button type="button" class="btn btn-warning w-100 mt-3" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        Change Password
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Profile Update Form -->
                    <form action="{{ route('driver.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('PUT')

                        <!-- Username -->
                        <div class="form-group text-start">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control" value="{{ $user->username }}" required>
                        </div>

                        <!-- Full Name -->
                        <div class="form-group text-start">
                            <label for="fullname">Full Name</label>
                            <input type="text" id="fullname" name="fullname" class="form-control" value="{{ $user->fullname }}" required>
                        </div>

                        <!-- Email -->
                        <div class="form-group text-start">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <!-- Date of Birth -->
                        <div class="form-group text-start">
                            <label for="dob">Date of Birth</label>
                            <input type="date" id="dob" name="dob" class="form-control" value="{{ $user->dob }}">
                        </div>

                        <!-- Profile Picture Upload -->
                        <div class="form-group text-start">
                            <label for="profile_picture">Profile Picture</label>
                            <input type="file" id="profile_picture" name="profile_picture" class="form-control" onchange="previewImage(event)">
                        </div>

                        <!-- Save Changes Button -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Driver's License Modal -->
    <div class="modal fade" id="editDriverLicenseModal" tabindex="-1" aria-labelledby="editDriverLicenseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDriverLicenseModalLabel">Edit Driver's License</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Driver's License Update Form -->
                    <form action="{{ route('driver.profile.update-license') }}" method="POST" id="driverLicenseForm">
                        @csrf
                        @method('PUT')

                        <!-- Driver's License Number -->
                        <div class="form-group text-start">
                            <label for="driver_license_number">Driver's License Number</label>
                            <input type="text" id="driver_license_number" name="driver_license_number" class="form-control" value="{{ $user->driver_license_number }}">
                        </div>

                        <!-- License Expiry Date -->
                        <div class="form-group text-start">
                            <label for="license_expiry_date">License Expiry Date</label>
                            <input type="date" id="license_expiry_date" name="license_expiry_date" class="form-control" value="{{ $user->license_expiry_date }}">
                        </div>

                        <!-- License Type -->
                        <div class="form-group text-start">
                            <label for="license_type">License Type</label>
                            <input type="text" id="license_type" name="license_type" class="form-control" value="{{ $user->license_type }}">
                        </div>

                        <!-- Save Changes Button -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Change Password Form -->
                    <form action="{{ route('driver.profile.change-password') }}" method="POST" id="changePasswordForm">
                        @csrf
                        @method('PUT')

                        <!-- Display Validation Errors -->
                        <div id="errorContainer" class="alert alert-danger" style="display: none;"></div>

                        <!-- Current Password -->
                        <div class="form-group text-start">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="form-control" required>
                        </div>

                        <!-- New Password -->
                        <div class="form-group text-start">
                            <label for="new_password">New Password</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" required>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="form-group text-start">
                            <label for="new_password_confirmation">Confirm New Password</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                        </div>

                        <!-- Save Changes Button -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Image Preview and Form Handling -->
    <script>
        // Function to preview uploaded image
        function previewImage(event) {
            const reader = new FileReader();
            const output = document.getElementById('profileImagePreview');
            reader.onload = function() {
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        // Function to handle the Change Password form submission
        document.getElementById('changePasswordForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            const errorContainer = document.getElementById('errorContainer');
            errorContainer.style.display = 'none'; // Hide error container initially

            // Submit the form via AJAX
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw err;
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // If successful, close the modal and show a success message
                    const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
                    modal.hide(); // Close the modal using Bootstrap's JavaScript API
                    alert(data.message); // Show a success message
                    window.location.reload(); // Optional: Reload the page to reflect changes
                } else {
                    // If there are errors, display them in the modal
                    errorContainer.innerHTML = data.message || 'An error occurred. Please try again.';
                    errorContainer.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorContainer.innerHTML = error.message || 'An error occurred. Please try again.';
                errorContainer.style.display = 'block';
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>