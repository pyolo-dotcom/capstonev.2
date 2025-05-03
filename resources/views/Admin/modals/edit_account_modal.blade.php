<!-- Edit Account Modal -->
<div class="modal fade" id="editArchiveModal" tabindex="-1" aria-labelledby="editArchiveModalLabel" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editArchiveModalLabel">
                    <i class="fas fa-user-edit me-2"></i>Edit Account
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editArchiveForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div id="modalContent">
                        <!-- Dynamic content will be inserted here -->
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg submit-button">
                            <i class="fas fa-save me-2"></i>Update Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Function to format date for input[type="date"]
    function formatDateForInput(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return dateString;
        
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Function to validate Philippine mobile number
    function validatePhilippineMobileNumber(number) {
        const cleaned = number.replace(/\D/g, '');
        return /^09\d{9}$/.test(cleaned) || /^639\d{9}$/.test(cleaned);
    }

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
    async function checkFieldAvailability(field, value, errorElement, currentValue = '') {
        if (!errorElement) {
            console.error('Error element not found for field:', field);
            return false;
        }

        if (value === currentValue) {
            errorElement.classList.add('d-none');
            return false;
        }

        if (field === 'mobile_number' && !validatePhilippineMobileNumber(value)) {
            errorElement.textContent = 'Please enter a valid Philippine mobile number (09XXXXXXXXX or +639XXXXXXXXX)';
            errorElement.classList.remove('d-none');
            return true;
        }

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
        const submitButton = document.querySelector('.submit-button');
        if (!submitButton) return;

        const hasError = document.querySelectorAll('.text-danger:not(.d-none)').length > 0;
        submitButton.disabled = hasError;
    }

    // Edit button click handler
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            const username = button.getAttribute('data-username');
            const fullname = button.getAttribute('data-fullname');
            const email = button.getAttribute('data-email');
            let mobile_number = button.getAttribute('data-mobile_number');
            const dob = formatDateForInput(button.getAttribute('data-dob'));
            const role = button.getAttribute('data-role');
            const licenseNumber = button.getAttribute('data-license-number');
            const licenseType = button.getAttribute('data-license-type');
            const licenseExpiry = formatDateForInput(button.getAttribute('data-license-expiry'));
            const truckId = button.getAttribute('data-truck-id');

            // Format mobile number for display
            if (mobile_number && mobile_number.startsWith('63')) {
                mobile_number = '+63' + mobile_number.substring(2);
            } else if (mobile_number && mobile_number.startsWith('9')) {
                mobile_number = '0' + mobile_number;
            }

            document.getElementById('editArchiveModalLabel').textContent = 'Edit Account';
            
            // Show loading state
            document.getElementById('modalContent').innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading account details...</p>
                </div>
            `;

            // Fetch the edit form data
            fetch(`/admin/activeaccount/${id}/edit-form`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('modalContent').innerHTML = `
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username" class="form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" id="username" name="username" class="form-control" value="${data.user.username}" required>
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
                                        <input type="text" id="fullname" name="fullname" class="form-control" value="${data.user.fullname}" required>
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
                                        <input type="email" id="email" name="email" class="form-control" value="${data.user.email}" required>
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
                                        <input type="text" id="mobile_number" name="mobile_number" class="form-control" 
                                               placeholder="e.g. 09123456789" value="${data.user.mobile_number || ''}" required>
                                    </div>
                                    <div id="mobile-error" class="text-danger small mt-1 d-none">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        <span>Mobile number already exists or is invalid. Philippine format: 09XXXXXXXXX or +639XXXXXXXXX</span>
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
                                        <input type="date" id="dob" name="dob" class="form-control" value="${data.user.dob}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role" class="form-label">Role</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        <select id="role" name="role" class="form-select" required>
                                            <option value="manager" ${data.user.role === 'manager' ? 'selected' : ''}>Manager</option>
                                            <option value="driver" ${data.user.role === 'driver' ? 'selected' : ''}>Driver</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="driverFields" style="${data.user.role === 'driver' ? 'display:block' : 'display:none'}">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="driver_license_number" class="form-label">License Number</label>
                                        <input type="text" id="driver_license_number" name="driver_license_number" class="form-control" 
                                               value="${data.user.driver_license_number || ''}" ${data.user.role === 'driver' ? 'required' : ''}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="license_type" class="form-label">License Type</label>
                                        <select id="license_type" name="license_type" class="form-select" ${data.user.role === 'driver' ? 'required' : ''}>
                                            <option value="" selected disabled>Select Type</option>
                                            <option value="Professional" ${data.user.license_type === 'Professional' ? 'selected' : ''}>Professional</option>
                                            <option value="Non-Professional" ${data.user.license_type === 'Non-Professional' ? 'selected' : ''}>Non-Professional</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="license_expiry_date" class="form-label">Expiry Date</label>
                                        <input type="date" id="license_expiry_date" name="license_expiry_date" class="form-control" 
                                               value="${data.user.license_expiry_date || ''}" ${data.user.role === 'driver' ? 'required' : ''}>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="truck_id" class="form-label">Plate Number</label>
                                        <select id="truck_id" name="truck_id" class="form-select" ${data.user.role === 'driver' ? 'required' : ''}>
                                            <option value="" selected disabled>Select Plate Number</option>
                                            ${data.trucks.map(truck => `
                                                <option value="${truck.plate_number}" ${data.user.truck_id === truck.plate_number ? 'selected' : ''}>
                                                    ${truck.plate_number}
                                                </option>
                                            `).join('')}
                                        </select>
                                        <div id="truck-error" class="text-danger small mt-1 d-none">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            <span>This truck is already assigned to another driver.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    // Set up field validations
                    function setupFieldValidation(field, minLength = 3, isEmail = false, currentValue = '') {
                        const errorElementId = field === 'mobile_number' ? 'mobile-error' : `${field}-error`;
                        const input = getElement(field);
                        const errorElement = getElement(errorElementId);
                        
                        if (!input || !errorElement) return;
                        
                        let timeout;
                        input.addEventListener('input', async function() {
                            clearTimeout(timeout);
                            const value = this.value.trim();
                            
                            if (value === currentValue) {
                                errorElement.classList.add('d-none');
                                updateSubmitButton();
                                return;
                            }
                            
                            if (value.length < minLength || (isEmail && !value.includes('@'))) {
                                errorElement.classList.add('d-none');
                                updateSubmitButton();
                                return;
                            }
                            
                            timeout = setTimeout(async () => {
                                await checkFieldAvailability(field, value, errorElement, currentValue);
                                updateSubmitButton();
                            }, 500);
                        });
                    }

                    // Mobile number input formatting
                    const mobileInput = getElement('mobile_number');
                    if (mobileInput) {
                        mobileInput.addEventListener('input', function(e) {
                            let value = this.value.replace(/\D/g, '');
                            
                            if (value.startsWith('63')) {
                                value = '+63' + value.substring(2);
                            }
                            else if (value.startsWith('9') && value.length > 1) {
                                value = '09' + value.substring(1);
                            }
                            
                            const maxLength = value.startsWith('+') ? 13 : 11;
                            if (value.length > maxLength) {
                                value = value.substring(0, maxLength);
                            }
                            
                            this.value = value;
                        });
                    }

                    // Toggle driver fields based on role selection
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
                            
                            await checkFieldAvailability('truck', this.value, errorElement, data.user.truck_id);
                            updateSubmitButton();
                        });
                    }

                    // Set up all field validations with current values
                    setupFieldValidation('username', 3, false, data.user.username);
                    setupFieldValidation('email', 3, true, data.user.email);
                    setupFieldValidation('mobile_number', 11, false, data.user.mobile_number);
                })
                .catch(error => {
                    console.error('Error loading edit form:', error);
                    document.getElementById('modalContent').innerHTML = `
                        <div class="alert alert-danger">
                            Failed to load account details. Please try again.
                        </div>
                    `;
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
            document.querySelector('.submit-button').innerHTML = `
                <i class="fas fa-check me-2"></i>Yes, Archive Account
            `;
            document.querySelector('.submit-button').classList.remove('btn-primary');
            document.querySelector('.submit-button').classList.add('btn-danger');

            document.getElementById('editArchiveForm').action = `/admin/activeaccount/${id}`;
            document.getElementById('editArchiveForm').querySelector('input[name="_method"]').value = 'DELETE';
        });
    });
});
</script>