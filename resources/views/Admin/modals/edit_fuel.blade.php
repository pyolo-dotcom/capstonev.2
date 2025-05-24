<div id="updateFuelModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeUpdateFuelModal()">&times;</span>
        <h2 style="margin-bottom: 20px;">Update Consumption</h2>
        <form id="updateFuelForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="updateId" name="id">
            <div class="form-group">
                <label for="updateDate">Date:</label>
                <input type="date" id="updateDate" name="date" required>
            </div>
            <div class="form-group">
                <label for="updatePlateNo">Plate No.:</label>
                <select id="updatePlateNo" name="plateNo" required>
                    <option disabled>-- Plate Number --</option>
                    @foreach($plateNumbers as $plate)
                        <option value="{{ $plate }}">{{ $plate }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="updateTotalKm">Total Kilometers Traveled:</label>
                <input type="number" id="updateTotalKm" name="totalKm" required>
            </div>
            <div class="form-group">
                <label for="updateAvgKmL">Average Km/L:</label>
                <input type="number" id="updateAvgKmL" name="avgKmL" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="updateFuelPrice">Fuel Price per Liter:</label>
                <input type="number" id="updateFuelPrice" name="fuelPrice" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="updateTotalLiters">Total Liters (Auto-calculated):</label>
                <input type="text" id="updateTotalLiters" name="totalLiters" readonly>
            </div>
            <div class="form-group">
                <label for="updateTotalCost">Total Cost (Auto-calculated):</label>
                <input type="number" id="updateTotalCost" name="totalCost" readonly step="0.01">
            </div>
            <div class="form-row">
                <button type="button" onclick="updateFuelConsumption()">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners to the relevant input fields
        document.getElementById('updateTotalKm').addEventListener('input', calculateTotalLitersAndCost);
        document.getElementById('updateAvgKmL').addEventListener('input', calculateTotalLitersAndCost);
        document.getElementById('updateFuelPrice').addEventListener('input', calculateTotalCost);
    });

    function calculateTotalLitersAndCost() {
        const totalKm = parseFloat(document.getElementById('updateTotalKm').value);
        const avgKmL = parseFloat(document.getElementById('updateAvgKmL').value);
        const fuelPrice = parseFloat(document.getElementById('updateFuelPrice').value);

        if (!isNaN(totalKm) && !isNaN(avgKmL)) {
            const totalLiters = totalKm / avgKmL;
            document.getElementById('updateTotalLiters').value = totalLiters.toFixed(2);

            if (!isNaN(fuelPrice)) {
                const totalCost = totalLiters * fuelPrice;
                document.getElementById('updateTotalCost').value = totalCost.toFixed(2);
            }
        }
    }

    function calculateTotalCost() {
        const totalLiters = parseFloat(document.getElementById('updateTotalLiters').value);
        const fuelPrice = parseFloat(document.getElementById('updateFuelPrice').value);

        if (!isNaN(totalLiters) && !isNaN(fuelPrice)) {
            const totalCost = totalLiters * fuelPrice;
            document.getElementById('updateTotalCost').value = totalCost.toFixed(2);
        }
    }

    function editFuel(id) {
        fetch(`/admin/fuel/edit/${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.data) {
                    const fuelData = data.data;
                    const formattedDate = new Date(fuelData.date).toISOString().split('T')[0];
                    
                    openUpdateFuelModal({
                        id: fuelData.id,
                        date: formattedDate,
                        plateNo: fuelData.plate_no,
                        totalKm: fuelData.total_km,
                        avgKmL: fuelData.avg_km_l,
                        fuelPrice: fuelData.fuel_price,
                        totalLiters: fuelData.total_liters,
                        totalCost: fuelData.total_cost
                    });
                } else {
                    throw new Error('Invalid data format from server');
                }
            })
            .catch(error => {
                console.error('Error fetching fuel data:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to fetch fuel data: ' + error.message,
                });
            });
    }

    function openUpdateFuelModal(consumption) {
        document.getElementById('updateId').value = consumption.id;
        document.getElementById('updateDate').value = consumption.date;
        document.getElementById('updatePlateNo').value = consumption.plateNo;
        document.getElementById('updateTotalKm').value = consumption.totalKm;
        document.getElementById('updateAvgKmL').value = consumption.avgKmL;
        document.getElementById('updateFuelPrice').value = consumption.fuelPrice;
        document.getElementById('updateTotalLiters').value = consumption.totalLiters;
        document.getElementById('updateTotalCost').value = consumption.totalCost;
        
        document.getElementById('updateFuelModal').style.display = 'block';
    }

    function closeUpdateFuelModal() {
        document.getElementById('updateFuelModal').style.display = 'none';
    }

    function updateFuelConsumption() {
        const id = document.getElementById('updateId').value;
        const date = document.getElementById('updateDate').value;
        const plateNo = document.getElementById('updatePlateNo').value;
        const totalKm = document.getElementById('updateTotalKm').value;
        const avgKmL = document.getElementById('updateAvgKmL').value;
        const fuelPrice = document.getElementById('updateFuelPrice').value;
        const totalLiters = document.getElementById('updateTotalLiters').value;
        const totalCost = document.getElementById('updateTotalCost').value;

        const data = {
            id,
            date,
            plateNo,
            totalKm,
            avgKmL,
            fuelPrice,
            totalLiters,
            totalCost,
            _method: 'PUT',
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        console.log('Data being sent to server:', data);

        fetch(`/admin/fuel/update/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Response from server:', data);
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Fuel consumption updated successfully',
                });
                closeUpdateFuelModal();
                // Optionally, refresh the data on the page
            } else {
                throw new Error('Failed to update fuel consumption');
            }
        })
        .catch(error => {
            console.error('Error updating fuel consumption:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to update fuel consumption: ' + error.message,
            });
        });
    }
</script>