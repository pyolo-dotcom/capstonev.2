<!-- resources/views/Admin/modals/edit_fuel.blade.php -->

<div id="editFuelModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('editFuelModal').style.display='none'">&times;</span>
        <h2>Edit Fuel Consumption</h2>
        <form id="editFuelForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="editFuelId" name="id">

            <div class="form-group">
                <label for="editDate">Date:</label>
                <input type="date" id="editDate" name="date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="editPlateNo">Plate No:</label>
                <input type="text" id="editPlateNo" name="plateNo" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="editTotalKm">Total KM:</label>
                <input type="number" id="editTotalKm" name="totalKm" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="editAvgKmL">Avg KM/L:</label>
                <input type="number" step="0.1" id="editAvgKmL" name="avgKmL" class="form-control" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-primary">Update</button>
                <button type="button" class="btn-secondary" onclick="document.getElementById('editFuelModal').style.display='none'">Cancel</button>
            </div>
        </form>
    </div>
</div>
<style>
    /* Specific styles for the edit_fuel modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        overflow: auto; /* Enable scrolling if content exceeds viewport height */
    }
    .modal-content {
        background-color: white;
        margin: 5% auto; /* Adjust margin to center the modal */
        padding: 20px;
        border: 1px solid #888;
        width: 30%;
        border-radius: 10px;
        max-height: 90vh; /* Limit modal height to 90% of viewport height */
        overflow-y: auto; /* Enable scrolling inside modal if content exceeds height */
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
    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    .btn-primary {
        background-color: #3498db;
        border: none;
        color: white;
        padding: 10px 20px;
        cursor: pointer;
    }
    .btn-secondary {
        background-color: #6c757d;
        border: none;
        color: white;
        padding: 10px 20px;
        cursor: pointer;
    }
</style>

<script>
    // Function to update fuel data
    function updateFuel() {
        const id = document.getElementById('editId').value;
        const data = {
            date: document.getElementById('editDate').value,
            plateNo: document.getElementById('editPlateNo').value,
            totalKm: document.getElementById('editTotalKm').value,
            avgKmL: document.getElementById('editAvgKmL').value,
        };

        fetch(`/admin/fuel/update/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close the modal and reload the page to reflect changes
                closeEditFuelModal();
                location.reload();
            }
        })
        .catch(error => console.error('Error updating fuel data:', error));
    }
</script>