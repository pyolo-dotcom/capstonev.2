<!-- Add Profit Modal -->
<div class="modal fade" id="profitModal" tabindex="-1" aria-labelledby="profitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="profitModalLabel"><i class="fas fa-plus-circle me-2"></i>Add Profit Record</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="profitForm" action="{{ route('admin.profit.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label fw-semibold">Date</label>
                            <input type="date" class="form-control form-control-lg" id="date" name="date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="plate_number" class="form-label fw-semibold">Plate Number</label>
                            <select class="form-select form-select-lg" id="plate_number" name="plate_number" required>
                                <option value="">Select Truck</option>
                                @foreach($plateNumbers as $plateNumber)
                                    <option value="{{ $plateNumber }}">{{ $plateNumber }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="total_income" class="form-label fw-semibold">Total Income (₱)</label>
                            <input type="number" step="0.01" class="form-control form-control-lg" id="total_income" name="total_income" required>
                        </div>
                        <div class="col-md-4">
                            <label for="total_expenses" class="form-label fw-semibold">Total Expenses (₱)</label>
                            <input type="number" step="0.01" class="form-control form-control-lg" id="total_expenses" name="total_expenses" required>
                        </div>
                        <div class="col-md-4">
                            <label for="total_profit" class="form-label fw-semibold">Total Profit (₱)</label>
                            <input type="number" step="0.01" class="form-control form-control-lg bg-light" id="total_profit" name="total_profit" readonly>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Close
                        </button>
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fas fa-save me-2"></i>Save Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-content {
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        border: none;
    }
    
    .modal-header {
        border-radius: 12px 12px 0 0;
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .modal-title {
        font-size: 1.3rem;
        font-weight: 500;
    }
    
    .form-label {
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
    }
    
    .form-control-lg {
        font-size: 1rem;
    }
    
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
    }
    
    .btn-primary:hover {
        background-color: #2980b9;
        border-color: #2980b9;
        transform: translateY(-1px);
    }
    
    .btn-secondary {
        background-color: #95a5a6;
        border-color: #95a5a6;
    }
    
    .btn-secondary:hover {
        background-color: #7f8c8d;
        border-color: #7f8c8d;
        transform: translateY(-1px);
    }
    
    @media (max-width: 768px) {
        .modal-dialog {
            margin: 1rem auto;
        }
        
        .modal-body {
            padding: 1.25rem;
        }
        
        .row > div {
            margin-bottom: 1rem;
        }
        
        .row > div:last-child {
            margin-bottom: 0;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const incomeInput = document.getElementById('total_income');
        const expensesInput = document.getElementById('total_expenses');
        
        if (incomeInput && expensesInput) {
            incomeInput.addEventListener('input', calculateProfit);
            expensesInput.addEventListener('input', calculateProfit);
        }
        
        function calculateProfit() {
            const income = parseFloat(incomeInput.value) || 0;
            const expenses = parseFloat(expensesInput.value) || 0;
            document.getElementById('total_profit').value = (income - expenses).toFixed(2);
        }
    });
</script>