<!-- Edit Account Modal -->
<div class="modal fade" id="editAccountModal{{$user->id}}" tabindex="-1" aria-labelledby="editAccountModalLabel{{$user->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 10px; padding: 40px;">
            <div class="modal-header" style="border-bottom: none;">
                <h5 class="modal-title" id="editAccountModalLabel{{$user->id}}">Edit Account</h5>
                <button type="button" class="close-button" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <form id="edit-account-form-{{$user->id}}" method="POST" action="{{route('editaccount', $user->id)}}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <input type="text" id="username" name="username" class="form-control input-box" placeholder="Username" value="{{$user->username}}" required>
                    </div>

                    <div class="form-group">
                        <input type="text" id="fullname" name="fullname" class="form-control input-box" placeholder="Fullname" value="{{$user->fullname}}" required>
                    </div>

                    <div class="form-group">
                        <input type="email" id="email" name="email" class="form-control input-box" placeholder="Enter Email" value="{{$user->email}}" required>
                    </div>

                    <div class="form-group">
                        <input type="date" id="dob" name="dob" class="form-control input-box input-size" value="{{$user->dob}}" required>
                    </div>

                    <div class="form-group">
                        <select id="role" name="role" class="form-control input-box input-size" required>
                            <option value="">Select Position</option>
                            <option value="driver" {{$user->role == 'driver' ? 'selected' : ''}}>Driver</option>
                            <option value="manager" {{$user->role == 'manager' ? 'selected' : ''}}>Manager</option>
                        </select>
                    </div>

                    <!-- Added License Details -->
                    <div class="form-group">
                        <input type="text" id="driver_license_number" name="driver_license_number" class="form-control input-box" placeholder="Driver License Number" value="{{$user->driver_license_number}}" required>
                    </div>

                    <div class="form-group">
                        <select id="license_type" name="license_type" class="form-control input-box input-size" required>
                            <option value="">Select License Type</option>
                            <option value="Professional" {{$user->license_type == 'Professional' ? 'selected' : ''}}>Professional</option>
                            <option value="Non-Professional" {{$user->license_type == 'Non-Professional' ? 'selected' : ''}}>Non-Professional</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="date" id="license_expiry_date" name="license_expiry_date" class="form-control input-box input-size" value="{{$user->license_expiry_date}}" required>
                    </div>

                    <!-- Added Truck ID -->
                    <div class="form-group">
                        <input type="text" id="truck_id" name="truck_id" class="form-control input-box" placeholder="Plate Number" value="{{$user->truck_id}}" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 submit-button">Update Account</button>
                </form>
            </div>
        </div>
    </div>
</div>