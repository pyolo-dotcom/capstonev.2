<div id="updateModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Update Trip</h2>
        <form id="updateTripForm">
            @csrf
            <input type="hidden" id="trip_id" name="trip_id">

            <label for="update_plate_no">Plate No.:</label>
            <select id="update_plate_no" name="plate_no" required>
                <option disabled value="">-- Plate Number --</option>
                <option value="UVP 353">UVP 353</option>
                <option value="TQE 262">TQE 262</option>
                <option value="NBB 7212">NBB 7212</option>
                <option value="APA 3309">APA 3309</option>
                <option value="WIE 914">WIE 914</option>
            </select>

            <label for="update_eir_no">EIR No.:</label>
            <input type="text" id="update_eir_no" name="eir_no" required>

            <label for="update_container_van_no">Container Van No.:</label>
            <input type="text" id="update_container_van_no" name="container_van_no" required>

            <label for="update_size">Size:</label>
            <input type="text" id="update_size" name="size" required>

            <label for="update_shipper_consignee">Shipper/Consignee:</label>
            <input type="text" id="update_shipper_consignee" name="shipper_consignee" required>

            <label for="update_voyage_vessel">Voyage Vessel:</label>
            <input type="text" id="update_voyage_vessel" name="voyage_vessel" required>

            <label for="update_voyage_no">Voyage No.:</label>
            <input type="text" id="update_voyage_no" name="voyage_no" required>

            <label for="update_pickup_location">Pickup Location:</label>
            <input type="text" id="update_pickup_location" name="pickup_location" required>

            <label for="update_delivery_location">Delivery Location:</label>
            <input type="text" id="update_delivery_location" name="delivery_location" required>

            <button type="submit">Update</button>
        </form>
    </div>
</div>