<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editProfileModalLabel"><i class="fas fa-user-edit me-2"></i>Edit Profile</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm" action="{{ route('driver.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Profile Picture Upload -->
                    <div class="mb-4 text-center">
                        <div class="profile-picture-container mx-auto">
                            @if($user->profile_picture)
                                <img src="{{ $user->profile_picture_url }}" 
                                    alt="Profile picture of {{ $user->fullname }}" 
                                    class="profile-picture"
                                    id="modalProfilePreview">
                            @else
                                <div class="default-profile-picture" id="modalProfilePreview">
                                    <span class="initials">{{ $user->initials }}</span>
                                </div>
                            @endif
                            <label for="profile_picture" class="edit-overlay" aria-label="Change profile picture">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="profile_picture" name="profile_picture" class="d-none" 
                                   onchange="previewImage(event, 'modalProfilePreview')" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif">
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
                        <input type="text" id="username" name="username" class="form-control" 
                               value="{{ $user->username }}" required>
                        <div class="invalid-feedback" id="username_error"></div>
                    </div>

                    <!-- Full Name -->
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" id="fullname" name="fullname" class="form-control" 
                               value="{{ $user->fullname }}" required>
                        <div class="invalid-feedback" id="fullname_error"></div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" 
                               value="{{ $user->email }}" required>
                        <div class="invalid-feedback" id="email_error"></div>
                    </div>

                    <!-- Date of Birth -->
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" id="dob" name="dob" class="form-control" 
                               value="{{ $user->dob ? $user->dob->format('Y-m-d') : '' }}">
                        <div class="invalid-feedback" id="dob_error"></div>
                    </div>

                    <!-- Save Changes Button -->
                    <div class="modal-footer border-top-0 px-0 pt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="submitProfileUpdate">
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
    const modalRemoveBtn = document.getElementById('removeProfileImageModalBtn');
    const removeInput = document.getElementById('remove_profile_image');
    
    if (modalRemoveBtn && removeInput) {
        modalRemoveBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to remove your profile image?')) {
                removeInput.value = '1';
                
                // Update the preview
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

    // Handle form submission with AJAX
    const form = document.getElementById('editProfileForm');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Reset error states
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            
            const submitBtn = document.getElementById('submitProfileUpdate');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
            
            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                // Check if response is JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    const text = await response.text();
                    throw new Error('Server returned non-JSON response: ' + text);
                }

                const data = await response.json();

                if (!response.ok) {
                    // Handle validation errors
                    if (data.errors) {
                        for (const [field, messages] of Object.entries(data.errors)) {
                            const input = document.getElementById(field);
                            const errorElement = document.getElementById(`${field}_error`);
                            
                            if (input && errorElement) {
                                input.classList.add('is-invalid');
                                errorElement.textContent = messages[0];
                            }
                        }
                        throw new Error('Validation failed');
                    }
                    throw new Error(data.message || 'Server returned an error');
                }

                // Success case
                const modal = bootstrap.Modal.getInstance(document.getElementById('editProfileModal'));
                if (modal) modal.hide();
                
                showAlert(data.message || 'Profile updated successfully', 'success');
                setTimeout(() => location.reload(), 1000);
                
            } catch (error) {
                console.error('Error:', error);
                showAlert(error.message || 'An error occurred. Please try again.', 'danger');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Save Changes';
            }
        });
    }
});
</script>