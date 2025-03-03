<!-- filepath: /c:/Users/john carlo cervantes/Downloads/capstone.2/capstonev.2/resources/views/Driver/modals/tripmodal.blade.php -->
<div id="tripModal" class="modall" style="display: none">
    <div class="modall-content">
        <span class="close">&times;</span>
        <h2>Add Trip</h2>
        <form id="tripForm">
            @csrf
            <label for="plate_no">Plate No.:</label>
            <select id="plate_no" name="plate_no" required>
                <option disabled selected>-- Plate Number --</option>
                <option value="UVP353">UVP353</option>
                <option value="TQE262">TQE262</option>
                <option value="NBB7212">NBB7212</option>
            </select>

            <label for="trip_type">Trip Type:</label>
            <select id="trip_type" name="trip_type" required>
                <option disabled selected>-- Select Trip --</option>
                <option value="One Way Trip">One Way Trip</option>
                <option value="Round Trip">Round Trip</option>
                <option value="Door-To-Door Trip">Door-To-Door Trip</option>
            </select>

            <label for="num_trips">Number of Trips:</label>
            <input type="number" id="num_trips" name="num_trips" min="1" required>

            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>
</div>

<style>
        /* Modal Styling */
    .modall {
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Background blur */
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .modall-content {
        background: white;
        padding: 20px;
        border-radius: 8px;
        width: 400px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        text-align: left;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .modall-content h2 {
        margin-bottom: 15px;
    }
    
    .modall-content form {
        display: flex;
        flex-direction: column;
        width: 100%;
    }
    
    .modall-content label {
        font-weight: bold;
        margin-top: 10px;
    }
    
    .modall-content select, 
    .modall-content input {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    
    .submit-btn {
        background-color: #0047ab;
        color: white;
        border: none;
        padding: 10px;
        margin-top: 15px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    
    .submit-btn:hover {
        background-color: #00338d;
    }
    
    /* Close Button */
    .close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
    }
</style>