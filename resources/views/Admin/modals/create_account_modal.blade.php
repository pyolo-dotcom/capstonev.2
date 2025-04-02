<!-- Create Account Modal -->
<div class="modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="createAccountModalLabel" aria-hidden="true">
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
                    
                    <!-- [All other form fields remain exactly the same] -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" required>
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
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobile_number" class="form-label">Mobile Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" id="mobile_number" name="mobile_number" class="form-control" placeholder="Enter mobile number" required>
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

                    <!-- Error message div - REMOVED THE INLINE STYLE -->
                    <div id="password-error" class="alert alert-danger d-flex align-items-center mb-3 d-none">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>Passwords do not match.</div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
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
        // 1. INITIALIZE MODAL - HIDE ERROR ON OPEN
        const modal = document.getElementById('createAccountModal');
        modal.addEventListener('show.bs.modal', function() {
            document.getElementById('password-error').classList.add('d-none');
        });

        // 2. PASSWORD VISIBILITY TOGGLE
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');
                input.type = input.type === 'password' ? 'text' : 'password';
                icon.classList.toggle('fa-eye-slash');
                icon.classList.toggle('fa-eye');
            });
        });

        // 3. DRIVER FIELDS TOGGLE
        function toggleDriverFields() {
            const role = document.getElementById('role').value;
            const driverFields = document.getElementById('driverFields');
            driverFields.style.display = role === 'driver' ? 'block' : 'none';
        }
        document.getElementById('role').addEventListener('change', toggleDriverFields);

        // 4. PASSWORD VALIDATION (ON SUBMIT ONLY)
        document.getElementById('create-account-form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPass = document.getElementById('password_confirmation').value;
            const errorDiv = document.getElementById('password-error');

            // Reset error state
            errorDiv.classList.add('d-none');

            // Only validate if both fields have values
            if (password && confirmPass && password !== confirmPass) {
                errorDiv.classList.remove('d-none');
                e.preventDefault();
            }
        });
    });
</script>