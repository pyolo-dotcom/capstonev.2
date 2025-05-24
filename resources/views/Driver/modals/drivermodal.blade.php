<div id="tripModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add Trip</h2>
        <form id="tripForm">
            @csrf
            <!-- Hidden plate number field that uses the driver's assigned plate -->
            <input type="hidden" id="plate_no" name="plate_no" value="{{ Auth::user()->truck_id ?? '' }}">

            <!-- Display the assigned plate number (read-only) -->
            <div class="form-group">
                <label for="display_plate">Plate No.:</label>
                <div class="plate-display">
                    <i class="fas fa-truck"></i>
                    <span id="display_plate">{{ Auth::user()->truck_id ?? 'Not assigned' }}</span>
                </div>
            </div>

            <div class="form-group">
                <label for="trip_type">Trip Type:</label>
                <select id="trip_type" name="trip_type" required>
                    <option disabled selected>-- Select Trip --</option>
                    <option value="One Way Trip">One Way Trip</option>
                    <option value="Round Trip">Round Trip</option>
                    <option value="Door-To-Door Trip">Door-To-Door Trip</option>
                </select>
            </div>

            <div class="form-group">
                <label for="num_trips">Number of Trips:</label>
                <input type="number" id="num_trips" name="num_trips" min="1" required>
            </div>

            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>
</div>

<style>
    .modal {
        display: none; /* Hidden by default */
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        padding: 25px;
        border-radius: 10px;
        width: 90%;
        max-width: 400px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .modal-content h2 {
        margin-bottom: 20px;
        color: #2c3e50;
        text-align: center;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 5px;
        color: #34495e;
    }

    .plate-display {
        display: flex;
        align-items: center;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .plate-display i {
        margin-right: 10px;
        color: #3498db;
    }

    .modal-content select,
    .modal-content input[type="number"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }

    .submit-btn {
        width: 100%;
        padding: 12px;
        background-color: #2980b9;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 20px;
        transition: background-color 0.3s;
    }

    .submit-btn:hover {
        background-color: #3498db;
    }

    .submit-btn:disabled {
        background-color: #95a5a6;
        cursor: not-allowed;
    }

    /* Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 28px;
        font-weight: bold;
        color: #7f8c8d;
        cursor: pointer;
        transition: color 0.3s;
    }

    .close:hover {
        color: #e74c3c;
    }

    @media (max-width: 480px) {
        .modal-content {
            width: 95%;
            padding: 20px 15px;
        }
    }
</style>

<script>
    // This will be handled by the main driver.js file
    document.addEventListener('DOMContentLoaded', function() {
        const plateNumber = '{{ Auth::user()->truck_id ?? '' }}';
        if (!plateNumber) {
            document.querySelector('.submit-btn').disabled = true;
        }
    });
</script>