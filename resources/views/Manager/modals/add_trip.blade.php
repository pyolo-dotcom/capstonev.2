<div id="tripModal" class="modal">
    <div class="modal-content">
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
                <option value="APA3309">APA3309</option>
                <option value="WIE914">WIE914</option>
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

            <button type="submit">Submit</button>
        </form>
    </div>
</div>
