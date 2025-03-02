<!-- Modal Structure -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 style="margin-bottom: 20px;">Update Trip Record</h2>
        <form id="editForm">
            <div class="form-row">
                <div class="form-group">
                    <label for="tripId">Plate No.:</label>
                    <input type="text" id="tripId" name="tripId" readonly>
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="eirNo">EIR No.:</label>
                    <input type="text" id="eirNo" name="eirNo">
                </div>
                <div class="form-group">
                    <label for="containerVanNo">Container Van No.:</label>
                    <input type="text" id="containerVanNo" name="containerVanNo">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="size">Size:</label>
                    <input type="text" id="size" name="size">
                </div>
                <div class="form-group">
                    <label for="shipperConsignee">Shipper/Consignee:</label>
                    <input type="text" id="shipperConsignee" name="shipperConsignee">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="voyageVessel">Voyage Vessel:</label>
                    <input type="text" id="voyageVessel" name="voyageVessel">
                </div>
                <div class="form-group">
                    <label for="no">No.:</label>
                    <input type="text" id="no" name="no">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="pickupLocation">Pickup Location:</label>
                    <input type="text" id="pickupLocation" name="pickupLocation">
                </div>
                <div class="form-group">
                    <label for="deliveryLocation">Delivery Location:</label>
                    <input type="text" id="deliveryLocation" name="deliveryLocation">
                </div>
            </div>
            <div class="form-row">
                <button type="button" onclick="addRecord()">Add</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Styles -->
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #f0f0f0;
        margin: 5% auto;
        padding: 20px;
        border: none;
        width: 50%;
        border-radius: 10px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .form-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .form-group {
        flex: 1;
        margin-right: 10px;
    }

    .form-group:last-child {
        margin-right: 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        color: #2f4156;
        font-size: 17px;
    }

    .form-group input {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: none;
        background-color: white;
    }

    .form-row:last-child {
        justify-content: center;
    }

    .form-row button {
        padding: 10px 20px;
        background-color: #004aad;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .form-row button:hover {
        background-color: #003a8c;
    }
</style>

<!-- Modal Script -->
<script>
    // Get the modal
    var modal = document.getElementById("editModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Function to open the modal and populate the form
    function openTripModal(tripId, date, eirNo, containerVanNo, size, shipperConsignee, voyageVessel, no, pickupLocation, deliveryLocation) {
        document.getElementById('tripId').value = tripId;
        document.getElementById('date').value = date;
        document.getElementById('eirNo').value = eirNo;
        document.getElementById('containerVanNo').value = containerVanNo;
        document.getElementById('size').value = size;
        document.getElementById('shipperConsignee').value = shipperConsignee;
        document.getElementById('voyageVessel').value = voyageVessel;
        document.getElementById('no').value = no;
        document.getElementById('pickupLocation').value = pickupLocation;
        document.getElementById('deliveryLocation').value = deliveryLocation;
        modal.style.display = "block";
    }

    // Function to handle the add button click
    function addRecord() {
        // Add your logic to handle the add action
        alert('Record added successfully!');
        modal.style.display = "none";
    }
</script>