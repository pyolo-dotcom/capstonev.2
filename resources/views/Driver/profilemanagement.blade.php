<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Driver Profile Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            padding: 30px;
            flex-grow: 1;
            background-color: white;
            min-height: 100vh;
        }
        
        /* Profile Header Section */
        .profile-header {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .profile-picture-section {
            flex: 0 0 200px;
        }
        
        .profile-info-section {
            flex: 1;
        }
        
        .profile-picture-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin-bottom: 15px;
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
            transition: all 0.3s;
        }
        
        .edit-overlay:hover {
            background: #2980b9;
            transform: scale(1.05);
        }
        
        .profile-name {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        
        .profile-role {
            color: #7f8c8d;
            font-size: 1rem;
            margin-bottom: 20px;
        }
        
        /* Personal Information Section */
        .personal-info {
            margin-bottom: 30px;
        }
        
        .info-item {
            margin-bottom: 8px;
        }
        
        .info-label {
            font-weight: 600;
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        .info-value {
            color: #2c3e50;
            font-size: 1rem;
        }
        
        /* License Information Section */
        .license-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #2c3e50;
            border-bottom: 2px solid #eee;
            padding-bottom: 8px;
        }
        
        .license-info {
            font-weight: 600;
            color: #2c3e50;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
        }
        
        .btn-edit-profile {
            background: #2980b9 !important;
            color: white !important;
            border: none !important;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
            flex: 1;
        }
        
        .btn-change-password {
            background: #e67e22 !important;
            color: white !important;
            border: none !important;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
            flex: 1;
        }
        
        .btn-update-license {
            background: #148f9c !important;
            color: white !important;
            border: none !important;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
            flex: 1;
        }
        
        .btn-logout {
            background: #e74c3c !important;
            color: white !important;
            border: none !important;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
            width: 100%;
            margin-top: 15px;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }
            
            .content {
                margin-left: 0;
                padding: 15px;
            }
            
            .profile-header {
                flex-direction: column;
                gap: 20px;
            }
            
            .profile-picture-section {
                flex: 0 0 auto;
                text-align: center;
            }
            
            .profile-picture-container {
                margin: 0 auto 15px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <x-drivernavbar />
    </div>

    <!-- Main Content Area -->
    <div class="content">
        <!-- Profile Header Section -->
        <div class="profile-header">
            <!-- Profile Picture Section -->
            <div class="profile-picture-section">
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
                 <!--   <div class="edit-overlay" data-bs-toggle="modal" data-bs-target="#editProfileModal" aria-label="Edit profile picture">
                        <i class="fas fa-pencil-alt"></i>
                    </div>-->
                </div>
            </div>
            
            <!-- Personal Information Section -->
            <div class="profile-info-section">
                <h1 class="profile-name">{{ $user->fullname }}</h1>
                <div class="profile-role">Driver</div>
                 <div class="info-item">
                    <span class="info-label">Username:</span>
                    <span class="info-value">{{ $user->username }}</span>
                </div>
                
                <div class="personal-info">
                    <div class="info-item">
                        <span class="info-label">Date of Birth</span>
                        <p class="info-value">{{ $user->dob ? date('F j, Y', strtotime($user->dob)) : 'Not set' }}</p>
                    </div>
                                        
                    <div class="info-item">
                        <span class="info-label">Email</span>
                        <p class="info-value">{{ $user->email }}</p>
                    </div>
          
                </div>
            </div>
        </div>
        
        <!-- License Information Section -->
        <div class="license-section">
            <h2 class="section-title">License Information</h2>
            
            <div class="info-item">
                <span class="info-label">Driver's License Number</span>
                <p class="info-value license-info">{{ $user->driver_license_number ?: 'Not set' }}</p>
            </div>
            
            <div class="info-item">
                <span class="info-label">License Expiry Date</span>
                <p class="info-value">{{ $user->license_expiry_date ? date('F j, Y', strtotime($user->license_expiry_date)) : 'Not set' }}</p>
            </div>
            
            <div class="info-item">
                <span class="info-label">License Type</span>
                <p class="info-value">{{ $user->license_type ?: 'Not set' }}</p>
            </div>
            
            <div class="info-item">
                <span class="info-label">Issued By</span>
                <p class="info-value">{{ $user->license_issued_by ?? 'Not set' }}</p>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="action-buttons">
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
        
        <!-- Logout Button -->
       
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <!-- Include Modals -->
    @include('driver.modals.edit-profile-modal')
    @include('driver.modals.change-password-modal')
    @include('driver.modals.update-license-modal')

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