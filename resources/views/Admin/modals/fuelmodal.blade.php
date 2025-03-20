<!-- Modal Structure -->
<div id="fuelModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeFuelModal()">&times;</span>
        <h2 style="margin-bottom: 20px;">Add Consumption</h2>
        <form id="fuelForm">
    @csrf
    <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
    </div>
    <div class="form-group">
        <label for="plateNo">Plate No.:</label>
        <select id="plateNo" name="plateNo" required>
            <option disabled selected>-- Plate Number --</option>
            <option value="UVP353">UVP353</option>
            <option value="TQE262">TQE262</option>
            <option value="NBB7212">NBB7212</option>
            <option value="APA3309">APA3309</option>
            <option value="WIE914">WIE914</option>
        </select>
    </div>
    <div class="form-group">
        <label for="totalKm">Total Kilometers Traveled:</label>
        <input type="number" id="totalKm" name="totalKm" required>
    </div>
    <div class="form-group">
        <label for="avgKmL">Average Km/L:</label>
        <input type="number" id="avgKmL" name="avgKmL" step="0.01" required>
    </div>
    <div class="form-group">
        <label for="totalLiters">Total Liters (Auto-calculated):</label>
        <input type="text" id="totalLiters" name="totalLiters" readonly>
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
// Fixed Average KM/L values for each truck
const avgKmLValues = {
    "APA3309": 6,
    "UVP353": 5,
    "TQE262": 5.5,
    "WIE914": 5.5,
    "NBB7212": 8
};

// Add event listeners
document.getElementById('totalKm').addEventListener('input', calculateLiters);
document.getElementById('plateNo').addEventListener('change', updateAvgKmL);

function updateAvgKmL() {
    let selectedPlate = document.getElementById('plateNo').value.trim();
    
    if (selectedPlate in avgKmLValues) {
        document.getElementById('avgKmL').value = avgKmLValues[selectedPlate]; // Set fixed Average KM/L
    } else {
        document.getElementById('avgKmL').value = ''; // Clear if no plate is selected
    }
    
    calculateLiters(); // Recalculate after updating
}

function calculateLiters() {
    let totalKm = parseFloat(document.getElementById('totalKm').value);
    let avgKmLField = document.getElementById('avgKmL');
    let selectedPlate = document.getElementById('plateNo').value.trim();

    // Ensure avgKmL remains fixed from predefined values
    let avgKmL = avgKmLValues[selectedPlate] || 0;
    avgKmLField.value = avgKmL; // Force reassign the fixed value

    if (totalKm && avgKmL) {
        document.getElementById('totalLiters').value = (totalKm / avgKmL).toFixed(2);
    } else {
        document.getElementById('totalLiters').value = '';
    }
}

function openFuelModal() {
    document.getElementById('fuelModal').style.display = 'block';
}

function closeFuelModal() {
    document.getElementById('fuelModal').style.display = 'none';
}

function addFuelConsumption() {
    let formData = new FormData(document.getElementById('fuelForm'));

    fetch('/fuel-consumption', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            closeFuelModal();
            document.getElementById('fuelForm').reset();
        } else {
            alert('Error adding fuel consumption.');
            console.log(data);
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>