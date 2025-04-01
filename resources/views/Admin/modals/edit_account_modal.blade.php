<!-- Edit/Archive Modal -->
<div class="modal fade" id="editArchiveModal" tabindex="-1" aria-labelledby="editArchiveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editArchiveModalLabel">Edit Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editArchiveForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div id="modalContent">
                        <!-- Dynamic content will be inserted here -->
                    </div>
                    <div id="modalFooter">
                        <button type="submit" class="btn btn-primary w-100 submit-button mt-3">Update Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Edit button click handler
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            const username = button.getAttribute('data-username');
            const fullname = button.getAttribute('data-fullname');
            const email = button.getAttribute('data-email');
            const mobile_number = button.getAttribute('data-mobile_number');
            const dob = button.getAttribute('data-dob');
            const role = button.getAttribute('data-role');
            const licenseNumber = button.getAttribute('data-license-number');
            const licenseType = button.getAttribute('data-license-type');
            const licenseExpiry = button.getAttribute('data-license-expiry');
            const truckId = button.getAttribute('data-truck-id');

            document.getElementById('editArchiveModalLabel').textContent = 'Edit Account';
            document.getElementById('modalContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control input-box" value="${username}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fullname">Full Name</label>
                            <input type="text" id="fullname" name="fullname" class="form-control input-box" value="${fullname}" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control input-box" value="${email}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobile_number">Mobile Number</label>
                            <input type="text" id="mobile_number" name="mobile_number" class="form-control input-box" value="${mobile_number}" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" id="dob" name="dob" class="form-control input-box" value="${dob}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select id="role" name="role" class="form-control input-box" required>
                                <option value="admin" ${role === 'admin' ? 'selected' : ''}>Admin</option>
                                <option value="manager" ${role === 'manager' ? 'selected' : ''}>Manager</option>
                                <option value="driver" ${role === 'driver' ? 'selected' : ''}>Driver</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div id="driverFields" style="${role === 'driver' ? 'display:block' : 'display:none'}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="driver_license_number">License Number</label>
                                <input type="text" id="driver_license_number" name="driver_license_number" class="form-control input-box" value="${licenseNumber || ''}" ${role === 'driver' ? 'required' : ''}>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="license_type">License Type</label>
                                <select id="license_type" name="license_type" class="form-control input-box" ${role === 'driver' ? 'required' : ''}>
                                    <option value="">Select Type</option>
                                    <option value="Professional" ${licenseType === 'Professional' ? 'selected' : ''}>Professional</option>
                                    <option value="Non-Professional" ${licenseType === 'Non-Professional' ? 'selected' : ''}>Non-Professional</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="license_expiry_date">Expiry Date</label>
                                <input type="date" id="license_expiry_date" name="license_expiry_date" class="form-control input-box" value="${licenseExpiry || ''}" ${role === 'driver' ? 'required' : ''}>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="truck_id">Plate Number</label>
                                <input type="text" id="truck_id" name="truck_id" class="form-control input-box" value="${truckId || ''}" ${role === 'driver' ? 'required' : ''}>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Update footer button for edit mode
            document.getElementById('modalFooter').innerHTML = `
                <button type="submit" class="btn btn-primary w-100 submit-button mt-3">
                    <i class="fas fa-save me-2"></i>Update Account
                </button>
            `;

            // Toggle driver fields based on role selection
            document.getElementById('role').addEventListener('change', function() {
                const driverFields = document.getElementById('driverFields');
                if (this.value === 'driver') {
                    driverFields.style.display = 'block';
                    document.getElementById('driver_license_number').required = true;
                    document.getElementById('license_type').required = true;
                    document.getElementById('license_expiry_date').required = true;
                    document.getElementById('truck_id').required = true;
                } else {
                    driverFields.style.display = 'none';
                    document.getElementById('driver_license_number').required = false;
                    document.getElementById('license_type').required = false;
                    document.getElementById('license_expiry_date').required = false;
                    document.getElementById('truck_id').required = false;
                }
            });

            document.getElementById('editArchiveForm').action = `/admin/activeaccount/${id}`;
            document.getElementById('editArchiveForm').querySelector('input[name="_method"]').value = 'PUT';
        });
    });

    // Archive button click handler
    document.querySelectorAll('.archive-btn').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            document.getElementById('editArchiveModalLabel').textContent = 'Archive Account';
            document.getElementById('modalContent').innerHTML = `
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Are you sure you want to archive this account?
                </div>
            `;
            
            // Update footer button for archive mode
            document.getElementById('modalFooter').innerHTML = `
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary w-50" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-danger w-50">
                        <i class="fas fa-check me-2"></i>Yes
                    </button>
                </div>
            `;

            document.getElementById('editArchiveForm').action = `/admin/activeaccount/${id}`;
            document.getElementById('editArchiveForm').querySelector('input[name="_method"]').value = 'DELETE';
        });
    });
});
</script>