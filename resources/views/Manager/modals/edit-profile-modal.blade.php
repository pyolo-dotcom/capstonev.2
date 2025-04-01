<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel"><i class="fas fa-user-edit me-2"></i>Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('manager.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Profile Picture Upload -->
                    <div class="mb-4 text-center">
                        <div class="profile-picture-container mx-auto">
                            @if($user->profile_picture)
                                <img src="{{ $user->profile_picture_url }}" 
                                    alt="Profile Image" 
                                    class="profile-picture"
                                    id="modalProfilePreview">
                            @else
                                <div class="default-profile-picture" id="modalProfilePreview">
                                    <span class="initials">{{ $user->initials }}</span>
                                </div>
                            @endif
                            <label for="profile_picture" class="edit-overlay">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="profile_picture" name="profile_picture" class="d-none" onchange="previewImage(event, 'modalProfilePreview')">
                        </div>
                        @if($user->profile_picture)
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="removeProfileImageModalBtn">
                            <i class="fas fa-trash-alt me-1"></i> Remove Profile Image
                        </button>
                        <input type="hidden" id="remove_profile_image" name="remove_profile_image" value="0">
                        @endif
                    </div>

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" value="{{ $user->username }}" required>
                    </div>

                    <!-- Full Name -->
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" id="fullname" name="fullname" class="form-control" value="{{ $user->fullname }}" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>

                    <!-- Date of Birth -->
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" id="dob" name="dob" class="form-control" 
                            value="{{ $user->dob ? $user->dob->format('Y-m-d') : '' }}">
                    </div>

                    <!-- Save Changes Button -->
                    <div class="modal-footer border-top-0 px-0 pt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle remove image button in modal
        const removeBtn = document.getElementById('removeProfileImageModalBtn');
        const removeInput = document.getElementById('remove_profile_image');
        
        if (removeBtn && removeInput) {
            removeBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to remove your profile image?')) {
                    removeInput.value = '1';
                    handleProfileImageRemoval('{{ $user->initials }}');
                }
            });
        }

        // Handle form submission in modal
        const profileForm = document.getElementById('profileUpdateForm');
        if (profileForm) {
            profileForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                handleProfileFormSubmit(formData, true)
                    .then(data => {
                        if (data && data.success) {
                            // Close the modal
                            const modalElement = document.getElementById('editProfileModal');
                            if (modalElement) {
                                const modal = bootstrap.Modal.getInstance(modalElement);
                                if (modal) modal.hide();
                            }
                            // Show success message and reload
                            showAlert(data.message, 'success');
                            setTimeout(() => location.reload(), 1000);
                        }
                    });
            });
        }
    });
</script>