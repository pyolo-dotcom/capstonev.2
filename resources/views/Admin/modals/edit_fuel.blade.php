<div id="editFuelModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('editFuelModal').style.display='none'">&times;</span>
        <h2 class="modal-title">Edit Fuel Consumption</h2>
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
                <select id="editPlateNo" name="plate_no" class="form-control" required>
                    <option value="">Select Plate Number</option>
                    <option value="UVP353">UVP353</option>
                    <option value="TQE262">TQE262</option>
                    <option value="NBB7212">NBB7212</option>
                    <option value="APA3309">APA3309</option>
                    <option value="WIE914">WIE914</option>
                </select>
            </div>

            <div class="form-group">
                <label for="editTotalKm">Total KM:</label>
                <input type="number" id="editTotalKm" name="total_km" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="editAvgKmL">Avg KM/L:</label>
                <input type="number" step="0.1" id="editAvgKmL" name="avg_km_l" class="form-control" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('editFuelModal').style.display='none'">Cancel</button>
            </div>
        </form>
    </div>
</div>

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
        background-color: rgba(0, 0, 0, 0.5);
        overflow: auto;
        animation: fadeIn 0.3s;
    }

    .modal-content {
        background-color: #f8f9fa;
        margin: 10% auto;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 500px;
        position: relative;
    }

    .close {
        position: absolute;
        right: 20px;
        top: 15px;
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.3s;
    }

    .close:hover {
        color: #333;
    }

    .modal-title {
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #495057;
    }

    .form-control {
        width: 100%;
        padding: 10px 15px;
        font-size: 16px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        background-color: #fff;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-control:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 1em;
    }

    /* Button Styles */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-primary {
        background-color: #3490dc;
        color: white;
    }

    .btn-primary:hover {
        background-color: #227dc7;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    /* Animation */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .modal-content {
            margin: 20% auto;
            width: 90%;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submission
    document.getElementById('editFuelForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const id = document.getElementById('editFuelId').value;
        
        fetch(`/admin/fuel/update/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-HTTP-Method-Override': 'PUT'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                setTimeout(() => window.location.reload(), 2000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while updating fuel data.',
            });
        });
    });
});

function editFuel(id) {
    fetch(`/admin/fuel/edit/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                document.getElementById('editFuelId').value = data.id;
                document.getElementById('editDate').value = data.date;
                document.getElementById('editPlateNo').value = data.plate_no;
                document.getElementById('editTotalKm').value = data.total_km;
                document.getElementById('editAvgKmL').value = data.avg_km_l;

                let modal = document.getElementById('editFuelModal');
                modal.style.display = "block";
            } else {
                console.error("No data found for ID:", id);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No data found for this record.',
                });
            }
        })
        .catch(error => {
            console.error('Error fetching fuel data:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to fetch fuel data.',
            });
        });
}
</script>