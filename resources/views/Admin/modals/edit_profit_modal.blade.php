<!-- Add this to your Admin.modals.edit_profit_modal (for each profit record) -->
<div class="modal fade" id="editProfitModal-{{ $profit->id }}" tabindex="-1" aria-labelledby="editProfitModalLabel-{{ $profit->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editProfitModalLabel-{{ $profit->id }}">Edit Profit Record</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProfitForm-{{ $profit->id }}" action="{{ route('admin.profit.update', $profit->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $profit->id }}">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_date-{{ $profit->id }}" class="form-label">Date</label>
                            <input type="date" class="form-control" id="edit_date-{{ $profit->id }}" name="date" value="{{ $profit->date }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_plate_number-{{ $profit->id }}" class="form-label">Plate Number</label>
                            <select class="form-select" id="edit_plate_number-{{ $profit->id }}" name="plate_number" required>
                                <option value="UVP353" {{ $profit->plate_number == 'UVP353' ? 'selected' : '' }}>UVP353</option>
                                <option value="TQE262" {{ $profit->plate_number == 'TQE262' ? 'selected' : '' }}>TQE262</option>
                                <option value="NBB7212" {{ $profit->plate_number == 'NBB7212' ? 'selected' : '' }}>NBB7212</option>
                                <option value="APA3309" {{ $profit->plate_number == 'APA3309' ? 'selected' : '' }}>APA3309</option>
                                <option value="WIE914" {{ $profit->plate_number == 'WIE914' ? 'selected' : '' }}>WIE914</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="edit_total_income-{{ $profit->id }}" class="form-label">Total Income (P)</label>
                            <input type="number" step="0.01" class="form-control" id="edit_total_income-{{ $profit->id }}" name="total_income" value="{{ $profit->total_income }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_total_expenses-{{ $profit->id }}" class="form-label">Total Expenses (P)</label>
                            <input type="number" step="0.01" class="form-control" id="edit_total_expenses-{{ $profit->id }}" name="total_expenses" value="{{ $profit->total_expenses }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_total_profit-{{ $profit->id }}" class="form-label">Total Profit (P)</label>
                            <input type="number" step="0.01" class="form-control" id="edit_total_profit-{{ $profit->id }}" name="total_profit" value="{{ $profit->total_profit }}" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }
    .modal-content {
        background: white;
        margin: 15% auto;
        padding: 20px;
        border-radius: 10px;
        width: 30%;
        text-align: center;
    }
    .close {
        color: red;
        float: right;
        font-size: 28px;
        cursor: pointer;
    }
    input, select {
        width: 100%;
        padding: 8px;
        margin: 5px 0;
    }
    button {
        background: #0056b3;
        color: white;
        padding: 10px;
        border: none;
        cursor: pointer;
    }
</style>

<script>
    // Function to calculate profit for edit modal
    function calculateEditProfit() {
    let income = parseFloat(document.getElementById('edit_total_income').value) || 0;
    let expenses = parseFloat(document.getElementById('edit_total_expenses').value) || 0;
    let profit = income - expenses;
    document.getElementById('edit_total_profit').value = profit.toFixed(2);
    }


    // Function to open edit modal and populate data
    function openEditModal(id, date, plateNumber, totalIncome, totalExpenses, totalProfit) {
        document.getElementById('editProfitModal').style.display = 'block';
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_date').value = date;
        document.getElementById('edit_plate_number').value = plateNumber;
        document.getElementById('edit_total_income').value = totalIncome;
        document.getElementById('edit_total_expenses').value = totalExpenses;
        document.getElementById('edit_total_profit').value = totalProfit;
    }

    // Add event listeners to edit buttons
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.getAttribute('data-id');
            const date = row.querySelector('td:nth-child(1)').innerText;
            const plateNumber = row.querySelector('td:nth-child(2)').innerText;
            const totalIncome = parseFloat(row.querySelector('td:nth-child(3)').innerText.replace('P ', ''));
            const totalExpenses = parseFloat(row.querySelector('td:nth-child(4)').innerText.replace('P ', ''));
            const totalProfit = parseFloat(row.querySelector('td:nth-child(5)').innerText.replace('P ', ''));
            openEditModal(id, date, plateNumber, totalIncome, totalExpenses, totalProfit);
        });
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target == document.getElementById('editProfitModal')) {
            document.getElementById('editProfitModal').style.display = 'none';
        }
    });

    // Close modal when clicking the close button
    document.querySelector('#editProfitModal .close').addEventListener('click', function() {
        document.getElementById('editProfitModal').style.display = 'none';
    });
</script>