<div class="modal fade" id="updateLicenseModal" tabindex="-1" aria-labelledby="updateLicenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateLicenseModalLabel"><i class="fas fa-id-card me-2"></i>Update Driver License</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateLicenseForm" action="{{ route('driver.profile.update-license') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Dynamic alerts will be inserted here -->
                    <div id="licenseUpdateAlerts"></div>

                    <!-- Driver's License Number -->
                    <div class="mb-3">
                        <label for="driver_license_number" class="form-label">Driver's License Number</label>
                        <input type="text" id="driver_license_number" name="driver_license_number" 
                            class="form-control" value="{{ $user->driver_license_number }}" required>
                        <div class="invalid-feedback" id="driver_license_number_error"></div>
                    </div>

                    <!-- License Expiry Date -->
                    <div class="mb-3">
                        <label for="license_expiry_date" class="form-label">License Expiry Date</label>
                        <input type="date" id="license_expiry_date" name="license_expiry_date" 
                            class="form-control" value="{{ $user->license_expiry_date ? $user->license_expiry_date->format('Y-m-d') : '' }}" required>
                        <div class="invalid-feedback" id="license_expiry_date_error"></div>
                    </div>

                    <!-- License Type -->
                    <div class="mb-4">
                        <label for="license_type" class="form-label">License Type</label>
                        <input type="text" id="license_type" name="license_type" 
                            class="form-control" value="{{ $user->license_type }}" required>
                        <div class="invalid-feedback" id="license_type_error"></div>
                    </div>

                    <!-- Save Changes Button -->
                    <div class="modal-footer border-top-0 px-0 pt-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="submitLicenseUpdate">
                            <i class="fas fa-save me-2"></i>Update License
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submission with AJAX
    const form = document.getElementById('updateLicenseForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Reset error states
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            document.getElementById('licenseUpdateAlerts').innerHTML = '';
            
            const submitBtn = document.getElementById('submitLicenseUpdate');
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
                    document.getElementById('licenseUpdateAlerts').appendChild(alertDiv);
                    
                    // Close modal after 2 seconds
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('updateLicenseModal'));
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
                    document.getElementById('licenseUpdateAlerts').appendChild(alertDiv);
                }
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update License';
            });
        });
    }
});
</script>