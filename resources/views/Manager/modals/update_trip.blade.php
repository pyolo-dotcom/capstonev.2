<div id="updateModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Update Trip</h2>
        <form id="updateTripForm">
            @csrf
            <input type="hidden" id="trip_id" name="trip_id">

            <label for="update_plate_no">Plate No.:</label>
            <select id="update_plate_no" name="plate_no" required>
                <option disabled>-- Plate Number --</option>
                <option value="UVP353">UVP353</option>
                <option value="TQE262">TQE262</option>
                <option value="NBB7212">NBB7212</option>
                <option value="APA3309">APA3309</option>
                <option value="WIE914">WIE914</option>
            </select>

            <label for="update_trip_type">Trip Type:</label>
            <select id="update_trip_type" name="trip_type" required>
                <option disabled>-- Select Trip --</option>
                <option value="One Way Trip">One Way Trip</option>
                <option value="Round Trip">Round Trip</option>
                <option value="Door-To-Door Trip">Door-To-Door Trip</option>
            </select>

            <label for="update_num_trips">Number of Trips:</label>
            <input type="number" id="update_num_trips" name="num_trips" min="1" required>

            <button type="submit">Update</button>
        </form>
    </div>
</div>