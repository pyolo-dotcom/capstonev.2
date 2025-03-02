<!-- Modal Structure -->
<div id="fuelModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeFuelModal()">&times;</span>
        <h2 style="margin-bottom: 20px;">Add Consumption</h2>
        <form id="fuelForm">
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date">
            </div>
            <div class="form-group">
                <label for="plateNo">Plate No.:</label>
                <select id="plateNo" name="plateNo">
                    <option value="123">123</option>
                    <option value="456">456</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="form-group">
                <label for="totalKm">Total Kilometers Traveled:</label>
                <input type="number" id="totalKm" name="totalKm">
            </div>
            <div class="form-group">
                <label for="avgKmL">Average Km/L:</label>
                <input type="number" id="avgKmL" name="avgKmL">
            </div>
            <div class="form-group">
                <label for="totalLiters">Total Liters:</label>
            </div>
            <div class="form-row">
                <button type="button" onclick="addFuelConsumption()">Add</button>
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
        width: 35%;
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

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        color: #2f4156;
        font-size: 17px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
        border: none;
        border-radius: 5px;
    }

    .form-row {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .form-row button {
        padding: 10px 20px;
        background-color: #004aad;
        color: #fff;
        border: none;
        font-size: 16px;
        border-radius: 20px;
        cursor: pointer;
    }

    .form-row button:hover {
        background-color: #003a8c;
    }
</style>

<!-- Modal Script -->
<script>
    function openFuelModal() {
        document.getElementById('fuelModal').style.display = 'block';
    }

    function closeFuelModal() {
        document.getElementById('fuelModal').style.display = 'none';
    }

    function addFuelConsumption() {
        // Add your logic to handle the add action
        alert('Fuel consumption added successfully!');
        closeFuelModal();
    }
</script>