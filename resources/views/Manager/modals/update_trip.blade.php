<div id="updateModal" class="modal" style="display: none;">
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
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        overflow: auto;
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 25px;
        border-radius: 8px;
        width: 50%;
        max-width: 500px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        animation: modalopen 0.3s;
    }

    .modal-title {
        color: #1f1a5c;
        margin-bottom: 20px;
        text-align: center;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: #333;
    }

    .modal-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .form-control {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s;
    }

    .btn-primary {
        background-color: #1f1a5c;
        color: white;
    }

    .btn-primary:hover {
        background-color: #161245;
    }

    @keyframes modalopen {
        from {opacity: 0; transform: translateY(-50px);}
        to {opacity: 1; transform: translateY(0);}
    }

    @media (max-width: 768px) {
        .modal-content {
            width: 80%;
            margin: 20% auto;
        }
    }
</style>