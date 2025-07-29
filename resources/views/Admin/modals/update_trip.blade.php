<div id="updateModal" class="modal">
    <!-- Remove the inline style display:none -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 class="modal-title">Update Trip</h2>
        <form id="updateTripForm" class="modal-form">
            @csrf
            <input type="hidden" id="trip_id" name="trip_id">

            <div class="form-group">
                <label for="update_plate_no">Plate No.:</label>
                <select id="update_plate_no" name="plate_no" class="form-control" required>
                    <option value="" disabled selected>-- Select Plate Number --</option>
                    @foreach($plateNumbers as $plate)
                        <option value="{{ $plate }}">{{ $plate }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="update_trip_type">Trip Type:</label>
                <select id="update_trip_type" name="trip_type" class="form-control" required>
                    <option disabled>-- Select Trip --</option>
                    <option value="One Way Trip">One Way Trip</option>
                    <option value="Round Trip">Round Trip</option>
                    <option value="Door-To-Door Trip">Door-To-Door Trip</option>
                </select>
            </div>

            <div class="form-group">
                <label for="update_num_trips">Number of Trips:</label>
                <input type="number" id="update_num_trips" name="num_trips" class="form-control" min="1" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<style>
    #updateModal {
        display: none;
        position: fixed;
        z-index: 1100;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
    }

    /* When modal is shown */
    #updateModal.show {
        display: flex !important;
        justify-content: center;
        align-items: center;
        padding-top: 0;
    }

    #updateModal .modal-content {
        margin: auto; /* Add this */
        background: #fff;
        padding: 0 !important;
        border-radius: 25px !important;
        width: 90%;
        max-width: 480px;
        position: relative;
        max-height: 100vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(31, 26, 92, 0.25);
        transform: translateY(4vh); /* Add this */
    }

    #updateModal .modal-title {
        background: linear-gradient(135deg, #1f1a5c, #2c3e50);
        color: white;
        padding: 25px 30px;
        border-radius: 20px 20px 0 0;
        margin: 0;
        border: none;
        position: relative;
        overflow: hidden;
    }

    #updateModal .close {
        position: absolute;
        top: 20px;
        right: 25px;
        font-size: 28px;
        font-weight: 300;
        color: rgba(255, 255, 255, 0.8);
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 2;
    }

    #updateModal .close:hover {
        color: white;
        transform: rotate(90deg);
    }

    #updateModal .modal-form {
        padding: 30px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        background: linear-gradient(to bottom, #ffffff, #f8f9fa);
    }

    #updateModal .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    #updateModal .form-group label {
        font-weight: 600;
        color: #1f1a5c;
        font-size: 0.9rem;
    }

    #updateModal .form-control {
        padding: 14px 18px;
        border: 2px solid #e8ecf0;
        border-radius: 12px;
        font-size: 15px;
        width: 100%;
        transition: all 0.3s ease;
    }

    #updateModal .form-control:focus {
        border-color: #1f1a5c;
        outline: none;
        box-shadow: 0 0 0 3px rgba(31, 26, 92, 0.1);
    }

    #updateModal .form-actions {
        margin-top: 20px;
    }

    #updateModal .btn-primary {
        background: linear-gradient(135deg, #1f1a5c, #2c3e50);
        color: white;
        border: none;
        padding: 16px 32px;
        border-radius: 12px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
    }

    #updateModal .btn-primary:hover {
        background: linear-gradient(135deg, #161245, #233140);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(31, 26, 92, 0.4);
    }

    @media (max-width: 768px) {
        #updateModal .modal-content {
            width: 95%;
            margin: auto; /* Change this from margin: 10px */
        }
    }
</style>