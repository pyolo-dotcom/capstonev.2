<!-- Modal Structure -->
 <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

 <style>
/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
    font-family:'Poppins';
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 25px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    position: absolute;
    right: 20px;
    top: 10px;
}

.close:hover,
.close:focus {
    color: #333;
    text-decoration: none;
}

/* Form Styles */
#fuelForm {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.form-group label {
    font-weight: 500;
    color: #333;
}

.form-group input,
.form-group select {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #4a90e2;
    box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
}

.form-row {
    margin-top: 10px;
    display: flex;
    justify-content: flex-end;
}

button {
    background-color: #4a90e2;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #3a7bc8;
}

input[readonly] {
    background-color: #f5f5f5;
    cursor: not-allowed;
}


/*added*/
/* Container to hold the two columns */
.form-columns {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
}

/* Each column takes about 50% */
.form-column {
    flex: 1;
    min-width: 250px;
}

/* Stretch the button row across both columns */
.form-row {
    width: 100%;
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
}

/* Optional: make it responsive */
@media (max-width: 768px) {
    .form-columns {
        flex-direction: column;
    }
}



/* Responsive adjustments */
@media (max-width: 768px) {
    .modal-content {
        width: 90%;
        margin: 10% auto;
    }
}
</style>

<div id="fuelModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeFuelModal()">&times;</span>
        <h2 style="margin-bottom: 20px;">Add Consumption</h2>
       <form id="fuelForm">
    @csrf
    <div class="form-columns">
        <!-- LEFT COLUMN (4 fields) -->
        <div class="form-column">
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="plateNo">Plate No.:</label>
                <select id="plateNo" name="plateNo" required>
                    <option disabled selected>-- Plate Number --</option>
                    @foreach($plateNumbers as $plate)
                        <option value="{{ $plate }}">{{ $plate }}</option>
                    @endforeach
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
        </div>

        <!-- RIGHT COLUMN (3 fields) -->
        <div class="form-column">
            <div class="form-group">
                <label for="fuelPrice">Fuel Price per Liter:</label>
                <input type="number" id="fuelPrice" name="fuelPrice" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="totalLiters">Total Liters (Auto-calculated):</label>
                <input type="text" id="totalLiters" name="totalLiters" readonly>
            </div>
            <div class="form-group">
                <label for="totalCost">Total Cost (Auto-calculated):</label>
                <input type="number" id="totalCost" name="totalCost" readonly step="0.01">
            </div>
        </div>
    </div>

    <!-- BUTTON ROW -->
    <div class="form-row">
        <button type="button" onclick="addFuelConsumption()">Add</button>
    </div>
</form>

<!-- Modal Script -->
<script>
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
    document.getElementById('fuelPrice').addEventListener('input', calculateCost);
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

        calculateCost(); // Recalculate cost after updating liters
    }

    function calculateCost() {
        let totalLiters = parseFloat(document.getElementById('totalLiters').value);
        let fuelPrice = parseFloat(document.getElementById('fuelPrice').value);

        if (totalLiters && fuelPrice) {
            document.getElementById('totalCost').value = (totalLiters * fuelPrice).toFixed(2);
        } else {
            document.getElementById('totalCost').value = '';
        }
    }

    function openFuelModal() {
        document.getElementById('fuelModal').style.display = 'block';
    }

    function closeFuelModal() {
        document.getElementById('fuelModal').style.display = 'none';
    }

function addFuelConsumption() {
    // Get form values
    const form = document.getElementById('fuelForm');
    const formData = {
        date: form.date.value,
        plateNo: form.plateNo.value,
        totalKm: parseFloat(form.totalKm.value),
        avgKmL: parseFloat(form.avgKmL.value),
        totalLiters: parseFloat(form.totalLiters.value),
        fuelPrice: parseFloat(form.fuelPrice.value),
        totalCost: parseFloat(form.totalCost.value),
        _token: document.querySelector('meta[name="csrf-token"]').content
    };

    fetch('/fuel-consumption', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': formData._token
        },
        body: JSON.stringify(formData)
    })
    .then(async response => {
        // First check if the response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            throw new Error(`Expected JSON but got: ${text.substring(0, 100)}...`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert(data.message);
            closeFuelModal();
            form.reset();
            window.location.reload();
        } else {
            alert('Error: ' + (data.message || 'Failed to add fuel consumption'));
            console.error(data.errors || data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Server error occurred. Please check console for details.');
    });
}

</script>