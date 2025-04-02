<!-- Create Account Modal -->
<div class="modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="createAccountModalLabel" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createAccountModalLabel">
                    <i class="fas fa-user-plus me-2"></i>Create New Account
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="create-account-form" method="POST" action="{{ route('admin.activeaccount.store') }}">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" required>
                                </div>
                                <div id="username-error" class="text-danger small mt-1 d-none">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <span>Username already exists.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fullname" class="form-label">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Enter full name" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter email" required>
                                </div>
                                <div id="email-error" class="text-danger small mt-1 d-none">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <span>Email already exists.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobile_number" class="form-label">Mobile Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" id="mobile_number" name="mobile_number" class="form-control" placeholder="Enter mobile number" required>
                                </div>
                                <div id="mobile-error" class="text-danger small mt-1 d-none">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    <span>Mobile number already exists.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" id="dob" name="dob" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role" class="form-label">Role</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                    <select id="role" name="role" class="form-select" required>
                                        <option value="" selected disabled>Select Position</option>
                                        <option value="manager">Manager</option>
                                        <option value="driver">Driver</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="driverFields" style="display: none;">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="driver_license_number" class="form-label">License Number</label>
                                    <input type="text" id="driver_license_number" name="driver_license_number" class="form-control" placeholder="Driver license number">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="license_type" class="form-label">License Type</label>
                                    <select id="license_type" name="license_type" class="form-select">
                                        <option value="" selected disabled>Select Type</option>
                                        <option value="Professional">Professional</option>
                                        <option value="Non-Professional">Non-Professional</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="license_expiry_date" class="form-label">Expiry Date</label>
                                    <input type="date" id="license_expiry_date" name="license_expiry_date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="truck_id" class="form-label">Plate Number</label>
                                    <select id="truck_id" name="truck_id" class="form-select">
                                        <option value="" selected disabled>Select Plate Number</option>
                                        <option value="UVP353">UVP353</option>
                                        <option value="TQE262">TQE262</option>
                                        <option value="NBB7212">NBB7212</option>
                                        <option value="APA3309">APA3309</option>
                                        <option value="WIE914">WIE914</option>
                                    </select>
                                    <div id="truck-error" class="text-danger small mt-1 d-none">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        <span>This truck is already assigned to another driver.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="password-error" class="alert alert-danger d-flex align-items-center mb-3 d-none">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>Passwords do not match.</div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" id="submit-button" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Create Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to safely get element
        function getElement(id) {
            const el = document.getElementById(id);
            if (!el) {
                console.error(`Element with ID ${id} not found`);
                return null;
            }
            return el;
        }
    
        // Function to handle API requests
        async function makeRequest(url) {
            try {
                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                if (!response.ok) {
                    let errorDetails = '';
                    try {
                        const errorData = await response.json();
                        errorDetails = errorData.message || JSON.stringify(errorData);
                    } catch (e) {
                        errorDetails = await response.text();
                    }
                    throw new Error(`HTTP error! status: ${response.status}, details: ${errorDetails}`);
                }
                
                return await response.json();
            } catch (error) {
                console.error('Error making request to:', url, 'Error:', error);
                return { 
                    error: true, 
                    message: error.message,
                    url: url
                };
            }
        }
    
        // Function to check field availability
        async function checkFieldAvailability(field, value, errorElement) {
            if (!errorElement) {
                console.error('Error element not found for field:', field);
                return false;
            }
    
            // Special handling for different field types
            const paramName = field === 'truck' ? 'truck' : 
                             field === 'mobile_number' ? 'mobile_number' : field;
            const url = `/check-${field}?${paramName}=${encodeURIComponent(value)}`;
            
            const data = await makeRequest(url);
            
            if (data.error) {
                console.error('Validation error for', field, ':', data.message, 'URL:', data.url);
                errorElement.textContent = 'Unable to validate this field. Please try again.';
                errorElement.classList.remove('d-none');
                return true;
            }
    
            if (data.exists || data.assigned) {
                errorElement.textContent = field === 'truck' ? 
                    'This truck is already assigned to another driver.' : 
                    field === 'mobile_number' ? 'Mobile number already exists.' :
                    `${field.charAt(0).toUpperCase() + field.slice(1)} already exists.`;
                errorElement.classList.remove('d-none');
                return true;
            } else {
                errorElement.classList.add('d-none');
                return false;
            }
        }
    
        // Function to update submit button state
        function updateSubmitButton() {
            const submitButton = getElement('submit-button');
            if (!submitButton) return;
    
            const hasError = document.querySelectorAll('.text-danger:not(.d-none)').length > 0;
            const passwordError = getElement('password-error');
            const hasPasswordError = passwordError && !passwordError.classList.contains('d-none');
            
            submitButton.disabled = hasError || hasPasswordError;
        }
    
        // Initialize modal
        const modal = getElement('createAccountModal');
        if (modal) {
            // When modal is shown
            modal.addEventListener('show.bs.modal', function() {
                const form = getElement('create-account-form');
                if (form) form.reset();
                
                document.querySelectorAll('.text-danger').forEach(el => {
                    el.classList.add('d-none');
                });
                
                const driverFields = getElement('driverFields');
                if (driverFields) driverFields.style.display = 'none';
                
                updateSubmitButton();
            });
    
            // Password visibility toggle
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('input');
                    const icon = this.querySelector('i');
                    if (!input || !icon) return;
                    
                    input.type = input.type === 'password' ? 'text' : 'password';
                    icon.classList.toggle('fa-eye-slash');
                    icon.classList.toggle('fa-eye');
                });
            });
    
            // Driver fields toggle
            const roleSelect = getElement('role');
            if (roleSelect) {
                roleSelect.addEventListener('change', function() {
                    const driverFields = getElement('driverFields');
                    if (driverFields) {
                        driverFields.style.display = this.value === 'driver' ? 'block' : 'none';
                        
                        const truckError = getElement('truck-error');
                        if (truckError) truckError.classList.add('d-none');
                        
                        updateSubmitButton();
                    }
                });
            }
    
            // Set up field validations with debounce
            function setupFieldValidation(field, minLength = 3, isEmail = false) {
                // Special case for mobile number error element
                const errorElementId = field === 'mobile_number' ? 'mobile-error' : `${field}-error`;
                const input = getElement(field);
                const errorElement = getElement(errorElementId);
                
                if (!input || !errorElement) {
                    console.error(`Missing elements for ${field} validation`);
                    return;
                }
                
                let timeout;
                input.addEventListener('input', async function() {
                    clearTimeout(timeout);
                    const value = this.value.trim();
                    
                    if (value.length < minLength || (isEmail && !value.includes('@'))) {
                        errorElement.classList.add('d-none');
                        updateSubmitButton();
                        return;
                    }
                    
                    timeout = setTimeout(async () => {
                        await checkFieldAvailability(field, value, errorElement);
                        updateSubmitButton();
                    }, 500);
                });
            }
    
            // Password validation
            const passwordInput = getElement('password');
            const confirmPassInput = getElement('password_confirmation');
            const passwordError = getElement('password-error');
            
            if (passwordInput && confirmPassInput && passwordError) {
                [passwordInput, confirmPassInput].forEach(input => {
                    input.addEventListener('input', function() {
                        const password = passwordInput.value;
                        const confirmPass = confirmPassInput.value;
                        
                        if (password && confirmPass) {
                            if (password !== confirmPass) {
                                passwordError.classList.remove('d-none');
                            } else {
                                passwordError.classList.add('d-none');
                            }
                            updateSubmitButton();
                        } else {
                            passwordError.classList.add('d-none');
                            updateSubmitButton();
                        }
                    });
                });
            }
    
            // Truck assignment validation
            const truckSelect = getElement('truck_id');
            if (truckSelect) {
                truckSelect.addEventListener('change', async function() {
                    const errorElement = getElement('truck-error');
                    const roleSelect = getElement('role');
                    
                    if (!errorElement || !roleSelect) return;
                    
                    if (roleSelect.value !== 'driver') {
                        errorElement.classList.add('d-none');
                        return;
                    }
                    
                    await checkFieldAvailability('truck', this.value, errorElement);
                    updateSubmitButton();
                });
            }
    
            // Set up all field validations
            setupFieldValidation('username');
            setupFieldValidation('email', 3, true);
            setupFieldValidation('mobile_number', 10);
    
            // Form submission
            const form = getElement('create-account-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const submitButton = getElement('submit-button');
                    if (submitButton && submitButton.disabled) {
                        e.preventDefault();
                        alert('Please fix the validation errors before submitting.');
                    }
                });
            }
        } else {
            console.error('Create Account Modal not found');
        }
    });
    </script>