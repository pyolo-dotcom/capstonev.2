<!-- Create Account Modal -->
<div class="modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="createAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 10px; padding: 40px;">
            <div class="modal-header" style="border-bottom: none;">
                <h5 class="modal-title" id="createAccountModalLabel">Create New Account</h5>
                <button type="button" class="close-button" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <form id="create-account-form" method="POST" action="{{ route('admin.activeaccount.store') }}">
                    @csrf
                    @method('POST')

                    <!-- Username Field -->
                    <div class="form-group">
                        <input type="text" id="username" name="username" class="form-control input-box" placeholder="Username" required>
                    </div>

                    <!-- Full Name Field -->
                    <div class="form-group">
                        <input type="text" id="fullname" name="fullname" class="form-control input-box" placeholder="Full Name" required>
                    </div>

                    <!-- Email Field -->
                    <div class="form-group">
                        <input type="email" id="email" name="email" class="form-control input-box" placeholder="Enter Email" required>
                    </div>

                    <!-- Date of Birth Field -->
                    <div class="form-group">
                        <input type="date" id="dob" name="dob" class="form-control input-box input-size" required>
                    </div>

                    <!-- Role Selection Field -->
                    <div class="form-group">
                        <select id="role" name="role" class="form-control input-box input-size" required onchange="toggleDriverFields()">
                            <option value="">Select Position</option>
                            <option value="driver">Driver</option>
                            <option value="manager">Manager</option>
                        </select>
                    </div>

                    <!-- Driver License Fields (Hidden by Default) -->
                    <div id="driverFields" style="display: none;">
                        <!-- License Number -->
                        <div class="form-group">
                            <input type="text" id="driver_license_number" name="driver_license_number" class="form-control input-box" placeholder="Driver License Number">
                        </div>

                        <!-- License Type -->
                        <div class="form-group">
                            <select id="license_type" name="license_type" class="form-control input-box">
                                <option value="">Select License Type</option>
                                <option value="Professional">Professional</option>
                                <option value="Non-Pro">Non-Pro</option>
                            </select>
                        </div>

                        <!-- License Expiry Date -->
                        <div class="form-group">
                            <input type="date" id="license_expiry_date" name="license_expiry_date" class="form-control input-box">
                        </div>

                        <!-- Truck ID -->
                        <div class="form-group">
                            <input type="text" id="truck_id" name="truck_id" class="form-control input-box" placeholder="Plate Number">
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <input type="password" id="password" name="password" class="form-control input-box" placeholder="Enter Password" required>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="form-group">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control input-box" placeholder="Confirm Password" required>
                    </div>

                    <!-- Error message for password mismatch -->
                    <div id="password-error" class="text-danger" style="display: none;">Passwords do not match.</div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100 submit-button">Create Account</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Dynamic Role Selection -->
<script>
    function toggleDriverFields() {
        var role = document.getElementById('role').value;
        var driverFields = document.getElementById('driverFields');

        if (role === 'driver') {
            driverFields.style.display = 'block';
            document.getElementById('license_number').setAttribute('required', true);
            document.getElementById('license_type').setAttribute('required', true);
            document.getElementById('license_expiry_date').setAttribute('required', true);
            document.getElementById('truck_id').setAttribute('required', true);
        } else {
            driverFields.style.display = 'none';
            document.getElementById('license_number').removeAttribute('required');
            document.getElementById('license_type').removeAttribute('required');
            document.getElementById('license_expiry_date').removeAttribute('required');
            document.getElementById('truck_id').removeAttribute('required');
        }
    }

    // Password validation
    document.getElementById('create-account-form').addEventListener('submit', function(event) {
        var password = document.getElementById('password').value;
        var passwordConfirmation = document.getElementById('password_confirmation').value;
        var errorDiv = document.getElementById('password-error');

        if (password !== passwordConfirmation) {
            errorDiv.style.display = 'block';
            event.preventDefault(); // Prevent form submission
        } else {
            errorDiv.style.display = 'none';
        }
    });
</script>
