<!-- Add this to your Admin.modals.profit_modal -->
<div class="modal fade" id="profitModal" tabindex="-1" aria-labelledby="profitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="profitModalLabel">Add Profit Record</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="profitForm" action="{{ route('admin.profit.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="plate_number" class="form-label">Plate Number</label>
                            <select class="form-select" id="plate_number" name="plate_number" required>
                                <option value="">Select Truck</option>
                                <option value="UVP353">UVP353</option>
                                <option value="TQE262">TQE262</option>
                                <option value="NBB7212">NBB7212</option>
                                <option value="APA3309">APA3309</option>
                                <option value="WIE914">WIE914</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="total_income" class="form-label">Total Income (P)</label>
                            <input type="number" step="0.01" class="form-control" id="total_income" name="total_income" required>
                        </div>
                        <div class="col-md-4">
                            <label for="total_expenses" class="form-label">Total Expenses (P)</label>
                            <input type="number" step="0.01" class="form-control" id="total_expenses" name="total_expenses" required>
                        </div>
                        <div class="col-md-4">
                            <label for="total_profit" class="form-label">Total Profit (P)</label>
                            <input type="number" step="0.01" class="form-control" id="total_profit" name="total_profit" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Record</button>
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
    function calculateProfit() {
        let income = parseFloat(document.getElementById('total_income').value) || 0;
        let expenses = parseFloat(document.getElementById('total_expenses').value) || 0;
        let profit = income - expenses;
        document.getElementById('total_profit').value = profit.toFixed(2);
    }

    document.getElementById('openModal').addEventListener('click', function() {
        document.getElementById('addProfitModal').style.display = 'block';
    });

    document.querySelector('.close').addEventListener('click', function() {
        document.getElementById('addProfitModal').style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target == document.getElementById('addProfitModal')) {
            document.getElementById('addProfitModal').style.display = 'none';
        }
    });
</script>