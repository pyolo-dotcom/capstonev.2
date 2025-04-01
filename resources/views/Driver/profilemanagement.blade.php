<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Driver Profile Management</title>
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
            min-height: 100vh;
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
        
        .main-content {
            margin-left: 250px;
            padding: 30px;
            width: calc(100% - 250px);
            height: 100vh;
            overflow-y: auto;
        }
        
        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .profile-header h2 {
            color: var(--secondary-color);
            font-weight: 600;
            margin: 0;
        }
        
        .profile-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .profile-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .profile-picture-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin-bottom: 20px;
        }
        
        .profile-picture {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        .default-profile-picture {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #757575;
            font-size: 2.5rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .initials {
            transform: translateY(5px);
        }
        
        .edit-overlay {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--primary-color);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            opacity: 1;
            transition: all 0.3s;
        }
        
        .edit-overlay:hover {
            background: #2980b9;
            transform: scale(1.05);
        }
        
        .profile-info {
            width: 100%;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        .info-value {
            color: #555;
        }
        
        .btn-edit-profile {
            background: #2980b9 !important;
            color: white !important;
            border: none !important;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
            width: 100%;
            margin-top: 20px;
            display: block;
        }
        
        .btn-edit-profile:hover {
            background: #2980b9 !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .btn-change-password {
            background: #e67e22 !important;
            color: white !important;
            border: none !important;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
            width: 100%;
            margin-top: 15px;
            display: block;
        }
        
        .btn-change-password:hover {
            background: #e67e22 !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .btn-update-license {
            background: #148f9c !important;
            color: white !important;
            border: none !important;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
            width: 100%;
            margin-top: 15px;
            display: block;
        }
        
        .btn-update-license:hover {
            background: #148f9c !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }
        
        .modal-header {
            border-bottom: none;
            padding: 20px 25px 10px;
        }
        
        .modal-title {
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        .modal-body {
            padding: 20px 25px;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--secondary-color);
            margin-bottom: 8px;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-close {
            filter: brightness(0.5);
        }
        
        .alert {
            border-radius: 8px;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1100;
            max-width: 400px;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
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
                padding: 20px 15px;
            }
            
            .profile-picture-container {
                width: 120px;
                height: 120px;
            }
            
            .info-item {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <x-drivernavbar/>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="profile-header">
            <h2><i class="fas fa-user-circle me-2"></i>Driver Profile Management</h2>
        </div>
        
        <div class="profile-card">
            <!-- Profile Picture Section -->
            <div class="profile-picture-container">
                @if($user->profile_picture)
                    <img src="{{ $user->profile_picture_url }}" 
                        class="profile-picture"
                        id="profileImagePreview"
                        alt="Profile picture of {{ $user->fullname }}">
                @else
                    <div class="default-profile-picture" id="profileImagePreview">
                        <span class="initials">{{ $user->initials }}</span>
                    </div>
                @endif
                <div class="edit-overlay" data-bs-toggle="modal" data-bs-target="#editProfileModal" aria-label="Edit profile picture">
                    <i class="fas fa-pencil-alt"></i>
                </div>
            </div>
            
            <!-- Profile Information Section -->
            <div class="profile-info">
                <div class="info-item">
                    <span class="info-label">Username:</span>
                    <span class="info-value">{{ $user->username }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Full Name:</span>
                    <span class="info-value">{{ $user->fullname }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date of Birth:</span>
                    <span class="info-value">{{ $user->dob ? date('F j, Y', strtotime($user->dob)) : 'Not set' }}</span>
                </div>
                <!-- Driver Specific Fields -->
                <div class="info-item">
                    <span class="info-label">Driver's License:</span>
                    <span class="info-value">{{ $user->driver_license_number ?: 'Not set' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">License Expiry:</span>
                    <span class="info-value">{{ $user->license_expiry_date ? date('F j, Y', strtotime($user->license_expiry_date)) : 'Not set' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">License Type:</span>
                    <span class="info-value">{{ $user->license_type ?: 'Not set' }}</span>
                </div>
            </div>
            
            <!-- ACTION BUTTONS -->
            <button type="button" class="btn btn-edit-profile" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                <i class="fas fa-edit me-2"></i>Edit Profile
            </button>
            
            <button type="button" class="btn btn-change-password" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                <i class="fas fa-key me-2"></i>Change Password
            </button>
            
            <button type="button" class="btn btn-update-license" data-bs-toggle="modal" data-bs-target="#updateLicenseModal">
                <i class="fas fa-id-card me-2"></i>Update License
            </button>
        </div>
    </div>

    <!-- Include Modals -->
    @include('Driver.modals.edit-profile-modal')
    @include('Driver.modals.change-password-modal')
    @include('Driver.modals.update-license-modal')

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to preview uploaded image
        function previewImage(event, targetId) {
            const reader = new FileReader();
            const output = document.getElementById(targetId);
            
            if (!output) return;
            
            reader.onload = function() {
                if (output.tagName.toLowerCase() === 'div') {
                    const img = document.createElement('img');
                    img.src = reader.result;
                    img.className = 'profile-picture';
                    img.id = targetId;
                    img.alt = 'Profile picture preview';
                    output.parentNode.replaceChild(img, output);
                } else {
                    output.src = reader.result;
                }
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all modals with proper accessibility
            const modals = ['editProfileModal', 'changePasswordModal', 'updateLicenseModal'];
            
            modals.forEach(modalId => {
                const modalElement = document.getElementById(modalId);
                if (modalElement) {
                    modalElement.addEventListener('show.bs.modal', function() {
                        this.removeAttribute('aria-hidden');
                    });
                    
                    modalElement.addEventListener('hidden.bs.modal', function() {
                        this.setAttribute('aria-hidden', 'true');
                    });
                }
            });

            // Remove image handler
            const modalRemoveBtn = document.getElementById('removeProfileImageModalBtn');
            const removeInput = document.getElementById('remove_profile_image');
            
            if (modalRemoveBtn && removeInput) {
                modalRemoveBtn.addEventListener('click', function() {
                    if (confirm('Are you sure you want to remove your profile image?')) {
                        removeInput.value = '1';
                        const modalPreview = document.getElementById('modalProfilePreview');
                        if (modalPreview) {
                            modalPreview.outerHTML = `
                                <div class="default-profile-picture" id="modalProfilePreview">
                                    <span class="initials">{{ $user->initials }}</span>
                                </div>
                            `;
                        }
                    }
                });
            }
            
            // Show alerts if any
            @if(session('success'))
                showAlert('{{ session('success') }}', 'success');
            @endif
            
            @if(session('error'))
                showAlert('{{ session('error') }}', 'danger');
            @endif
        });

        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.style.position = 'fixed';
            alertDiv.style.top = '20px';
            alertDiv.style.right = '20px';
            alertDiv.style.zIndex = '1100';
            alertDiv.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.classList.remove('show');
                setTimeout(() => alertDiv.remove(), 150);
            }, 5000);
        }
    </script>
</body>
</html>