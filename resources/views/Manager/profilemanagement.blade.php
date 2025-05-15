<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile Management</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
    <style>
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

        .content-header {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .content-header h2 {
            color: #1f1a5c;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }

        .profile-card {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            background: #3498db;
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
            color: #343a40;
        }
        
        .info-value {
            color: #555;
        }
        
        .btn-edit-profile {
            background: #3498db !important;
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
            background: #f39c12 !important;
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
            color: #343a40;
        }
        
        .modal-body {
            padding: 20px 25px;
        }
        
        .form-label {
            font-weight: 500;
            color: #343a40;
            margin-bottom: 8px;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-close {
            filter: brightness(0.5);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
            }
            
            .content {
                margin-left: 0;
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
            <x-managernavbar/>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="content-header">
            <h2><i class="fas fa-user-circle me-2"></i>Profile Management</h2>
        </div>
        
        <div class="profile-card">
            <!-- Profile Picture Section -->
            <div class="profile-picture-container">
                @if($user->profile_picture)
                    <img src="{{ Storage::url($user->profile_picture) }}" 
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
            </div>
            
            <!-- ACTION BUTTONS -->
            <button type="button" class="btn btn-edit-profile" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                <i class="fas fa-edit me-2"></i>Edit Profile
            </button>
            
            <button type="button" class="btn btn-change-password" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                <i class="fas fa-key me-2"></i>Change Password
            </button>
        </div>
    </div>

    <!-- Include Modals -->
    @include('manager.modals.edit-profile-modal')
    @include('manager.modals.change-password-modal')

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            const modals = ['editProfileModal', 'changePasswordModal'];
            
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
                    Swal.fire({
                        title: 'Remove Profile Picture?',
                        text: "Are you sure you want to remove your profile picture?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, remove it!',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            removeInput.value = '1';
                            const modalPreview = document.getElementById('modalProfilePreview');
                            if (modalPreview) {
                                modalPreview.outerHTML = `
                                    <div class="default-profile-picture" id="modalProfilePreview">
                                        <span class="initials">{{ $user->initials }}</span>
                                    </div>
                                `;
                            }
                            Swal.fire(
                                'Removed!',
                                'Your profile picture has been removed.',
                                'success'
                            );
                        }
                    });
                });
            }
            
            // Show alerts if any
            @if(session('success'))
                showSweetAlert('{{ session('success') }}', 'success');
            @endif
            
            @if(session('error'))
                showSweetAlert('{{ session('error') }}', 'error');
            @endif
            
            @if(session('warning'))
                showSweetAlert('{{ session('warning') }}', 'warning');
            @endif
            
            @if(session('info'))
                showSweetAlert('{{ session('info') }}', 'info');
            @endif
        });

        function showSweetAlert(message, type) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: type,
                title: message
            });
        }
    </script>
</body>
</html>