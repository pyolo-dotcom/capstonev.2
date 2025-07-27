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
    /* Force consistent box-sizing for modal */
    #profitModal * {
        box-sizing: border-box;
    }
    
    /* Modal Structure - More specific selectors to override conflicts */
    #profitModal .modal-content {
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        border: none;
        min-width: 0; /* Prevent shrinking */
    }
    
    #profitModal .modal-header {
        border-radius: 12px 12px 0 0;
        padding: 1.25rem 1.5rem;
        border-bottom: none;
        flex-shrink: 0;
    }
    
    #profitModal .modal-body {
        padding: 1.5rem;
        min-height: 200px; /* Prevent collapsing */
    }
    
    #profitModal .modal-title {
        font-size: 1.3rem;
        font-weight: 500;
        margin: 0;
        line-height: 1.4;
    }
    
    /* Form Elements - Force consistent sizing regardless of Bootstrap version */
    #profitModal .form-label {
        color: #2c3e50;
        margin-bottom: 0.5rem;
        display: block;
        font-weight: 600;
        font-size: 1rem;
    }
    
    /* Override ALL form inputs with specific sizing */
    #profitModal input[type="date"],
    #profitModal input[type="number"],
    #profitModal select,
    #profitModal .form-control, 
    #profitModal .form-select {
        border-radius: 8px;
        padding: 1rem 1.25rem !important;
        border: 2px solid #dee2e6 !important;
        transition: all 0.3s ease;
        width: 100% !important;
        font-size: 1.1rem !important;
        line-height: 1.5 !important;
        background-color: #fff !important;
        background-clip: padding-box;
        appearance: none;
        min-height: 60px !important;
        height: 60px !important;
        box-sizing: border-box !important;
        display: block !important;
    }
    
    #profitModal input[type="date"]:focus,
    #profitModal input[type="number"]:focus,
    #profitModal select:focus,
    #profitModal .form-control:focus, 
    #profitModal .form-select:focus {
        border-color: #3498db !important;
        box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25) !important;
        outline: 0 !important;
    }
    
    /* Force dropdown arrow for select */
    #profitModal select,
    #profitModal .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 1rem center !important;
        background-size: 16px 12px !important;
        padding-right: 3rem !important;
    }
    
    /* Ignore Bootstrap lg classes and force our sizing */
    #profitModal .form-control-lg,
    #profitModal .form-select-lg {
        font-size: 1.1rem !important;
        padding: 1rem 1.25rem !important;
        min-height: 60px !important;
        height: 60px !important;
    }
    
    /* Ensure proper column behavior */
    #profitModal .row {
        margin-right: -0.75rem;
        margin-left: -0.75rem;
        display: flex;
        flex-wrap: wrap;
    }
    
    #profitModal .col-md-4,
    #profitModal .col-md-6 {
        padding-right: 0.75rem;
        padding-left: 0.75rem;
        flex-basis: 0;
        flex-grow: 1;
        max-width: 100%;
        position: relative;
        width: 100%;
        min-height: 1px;
    }
    
    /* Responsive column widths */
    @media (min-width: 768px) {
        #profitModal .col-md-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }
        
        #profitModal .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }
    
    /* Button Styling - Force consistent appearance */
    #profitModal .btn {
        border-radius: 8px !important;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.75rem 1.5rem !important;
        font-size: 1rem !important;
        line-height: 1.5;
        text-decoration: none;
        cursor: pointer;
        min-height: 48px !important;
        box-sizing: border-box !important;
    }
    
    #profitModal .btn-primary {
        background: none !important;
        color: #1f1a5c !important;
        border: 2px solid #1f1a5c !important;
        padding: 0.75rem 1.5rem !important;
        border-radius: 8px !important;
        font-size: 1.1rem !important;
        font-weight: 700 !important;
        gap: 8px;
        white-space: nowrap;
    }
    
    #profitModal .circle-plus {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #2f4156;
        color: #2f4156;
        font-weight: bold;
        font-size: 1rem;
    }
    
    #profitModal .btn-primary:hover,
    #profitModal .btn-primary:focus {
        background-color: rgba(31, 26, 92, 0.1) !important;
        color: #1f1a5c !important;
        transform: translateY(-1px);
        border: 2px solid #1f1a5c !important;
    }
    
    #profitModal .btn-secondary {
        background-color: #95a5a6 !important;
        border: 2px solid #95a5a6 !important;
        color: #fff !important;
        padding: 0.75rem 1.5rem !important;
        font-size: 1rem !important;
    }
    
    #profitModal .btn-secondary:hover,
    #profitModal .btn-secondary:focus {
        background-color: #7f8c8d !important;
        border: 2px solid #7f8c8d !important;
        color: #fff !important;
        transform: translateY(-1px);
    }
    
    /* Modal Footer */
    #profitModal .modal-footer {
        padding: 1rem 1.5rem;
        border-top: none;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    /* Responsive Design - Force proper spacing */
    @media (max-width: 768px) {
        #profitModal .modal-dialog {
            margin: 1rem auto !important;
            max-width: calc(100vw - 2rem) !important;
        }
        
        #profitModal .modal-body {
            padding: 1.5rem !important;
        }
        
        #profitModal .col-md-4,
        #profitModal .col-md-6 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            margin-bottom: 1.5rem !important;
            padding: 0 0.75rem !important;
        }
        
        #profitModal .row > div:last-child {
            margin-bottom: 0 !important;
        }
        
        #profitModal .modal-footer {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 1rem !important;
        }
        
        #profitModal .btn {
            width: 100% !important;
            margin: 0 !important;
        }
    }
    
    /* Force Bootstrap utility classes */
    #profitModal .px-4 {
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
    }
    
    #profitModal .py-2 {
        padding-top: 0.75rem !important;
        padding-bottom: 0.75rem !important;
    }
    
    #profitModal .mb-3 {
        margin-bottom: 1.5rem !important;
    }
    
    #profitModal .fw-semibold {
        font-weight: 600 !important;
    }
    
    #profitModal .bg-light {
        background-color: #f8f9fa !important;
    }
    
    #profitModal .text-white {
        color: #fff !important;
    }
    
    #profitModal .me-2 {
        margin-right: 0.5rem !important;
    }
    
    #profitModal .border-top-0 {
        border-top: 0 !important;
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