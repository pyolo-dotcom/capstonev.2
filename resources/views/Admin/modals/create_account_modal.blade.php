<!-- Create Account Modal -->
<div class="modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="createAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 10px; padding: 40px;">
            <div class="modal-header" style="border-bottom: none;">
                <h5 class="modal-title" id="createAccountModalLabel">Create New Account</h5>
                <button type="button" class="close-button" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <form id="create-account-form" method="POST" action="{{route ('addaccount')}}">
                    @csrf
                    @method('POST')

                    <div class="form-group">
                        <input type="text" id="username" name="username" class="form-control input-box" placeholder="Username" required>
                    </div>

                    <div class="form-group">
                        <input type="text" id="fullname" name="fullname" class="form-control input-box" placeholder="Fullname" required>
                    </div>

                    <div class="form-group">
                        <input type="email" id="email" name="email" class="form-control input-box" placeholder="Enter Email" required>
                    </div>

                    <div class="form-group">
                        <input type="date" id="dob" name="dob" class="form-control input-box input-size" required>
                    </div>

                    <div class="form-group">
                        <select id="role" name="role" class="form-control input-box input-size" required>
                            <option value="">Select Position</option>
                            <option value="driver">Driver</option>
                            <option value="manager">Manager</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="password" id="password" name="password" class="form-control input-box" placeholder="Enter Password" required>
                    </div>

                    <div class="form-group">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control input-box" placeholder="Confirm Password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 submit-button">Create Account</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-content {
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        position: relative;
        text-align: center;
        width: 100%;
    }

    .close-button {
        position: absolute;
        top: -50px; /* Move higher */
        right: -15px;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: #000;
}

    .close-button:hover {
        color: #ff0000;
}


    .input-box {
        border-radius: 20px;
        padding: 10px;
        margin: 5px 0;
        width: 100%;
    }

    .input-size {
        height: 45px; /* Ensuring same height as the other input fields */
    }

    .submit-button {
        border-radius: 20px;
        background-color: #004aad;
        border: none;
        color: white;
        padding: 10px;
        margin-top: 10px;
    }

    .submit-button:hover {
        background-color: #00308f;
    }
</style>