<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel"><i class="fas fa-key me-2"></i>Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="adminChangePasswordForm" action="{{ route('admin.profile.change-password') }}" method="POST">
                    @csrf
                    
                    <!-- Dynamic alerts will be inserted here -->
                    <div id="passwordChangeAlerts"></div>

                    <!-- Current Password -->
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <div class="input-group">
                            <input type="password" id="current_password" name="current_password" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="current_password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback" id="current_password_error"></div>
                    </div>

                    <!-- New Password -->
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" id="new_password" name="new_password" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="new_password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="text-muted">Minimum 8 characters</small>
                        <div class="invalid-feedback" id="new_password_error"></div>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="mb-4">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="new_password_confirmation">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback" id="new_password_confirmation_error"></div>
                    </div>

                    <!-- Save Changes Button -->
                    <div class="modal-footer border-top-0 px-0 pt-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="submitPasswordChange">
                            <i class="fas fa-save me-2"></i>Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input && icon) {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        });
    });

    // Handle form submission with AJAX
    const form = document.getElementById('adminChangePasswordForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Reset error states
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            document.getElementById('passwordChangeAlerts').innerHTML = '';
            
            const submitBtn = document.getElementById('submitPasswordChange');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';
            
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show success message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success alert-dismissible fade show';
                    alertDiv.innerHTML = `
                        <i class="fas fa-check-circle me-2"></i>${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    document.getElementById('passwordChangeAlerts').appendChild(alertDiv);
                    
                    // Reset form
                    form.reset();
                    
                    // Close modal after 2 seconds
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
                        if (modal) modal.hide();
                        location.reload(); // Optional: reload to ensure all changes are reflected
                    }, 2000);
                }
            })
            .catch(error => {
                if (error.errors) {
                    // Handle validation errors
                    for (const [field, messages] of Object.entries(error.errors)) {
                        const input = document.getElementById(field);
                        const errorElement = document.getElementById(`${field}_error`);
                        
                        if (input && errorElement) {
                            input.classList.add('is-invalid');
                            errorElement.textContent = messages[0];
                        }
                    }
                } else {
                    // Show general error
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                    alertDiv.innerHTML = `
                        <i class="fas fa-exclamation-circle me-2"></i>${error.message || 'An error occurred. Please try again.'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    document.getElementById('passwordChangeAlerts').appendChild(alertDiv);
                }
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Password';
            });
        });
    }
});
</script>