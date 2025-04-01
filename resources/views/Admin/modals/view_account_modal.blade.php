<!-- View Account Modal -->
<div class="modal fade" id="viewAccountModal" tabindex="-1" aria-labelledby="viewAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewAccountModalLabel">
                    <i class="fas fa-user-circle me-2"></i>Account Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted">Username</h6>
                            <p id="view-username" class="fs-5"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted">Full Name</h6>
                            <p id="view-fullname" class="fs-5"></p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted">Email</h6>
                            <p id="view-email" class="fs-5"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted">Mobile Number</h6>
                            <p id="view-mobile" class="fs-5"></p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted">Date of Birth</h6>
                            <p id="view-dob" class="fs-5"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h6 class="text-muted">Role</h6>
                            <p id="view-role" class="fs-5"></p>
                        </div>
                    </div>
                </div>
                
                <div id="view-driver-fields">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <h6 class="text-muted">License Number</h6>
                                <p id="view-license-number" class="fs-5"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <h6 class="text-muted">License Type</h6>
                                <p id="view-license-type" class="fs-5"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <h6 class="text-muted">Expiry Date</h6>
                                <p id="view-license-expiry" class="fs-5"></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <h6 class="text-muted">Plate Number</h6>
                                <p id="view-truck-id" class="fs-5"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>