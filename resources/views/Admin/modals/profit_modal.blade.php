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

/* Modal Structure - Centered and modernized */
#profitModal {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.1);
    padding: 1rem;
    overflow-x: hidden;
    overflow-y: auto;
}

/* Ensure modal is centered and visible when shown */
#profitModal.show {
    display: flex !important;
    justify-content: center;
    align-items: flex-start;
    padding-top: 2rem;
}

/* Modal dialog - Fluid and responsive */
#profitModal .modal-dialog {
    margin: 0 auto;
    width: 100%;
    max-width: 800px;
    position: relative;
}

/* Modal content - Refined for better spacing and shadow */
#profitModal .modal-content {
    margin: 0;
    padding: 0;
    border-radius: 1rem !important;
    width: 100%;
    position: relative;
    max-height: calc(100vh - 4rem);
    display: flex;
    flex-direction: column;
    background: #ffffff;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    border: none;
    transform: translateY(0);
    transition: transform 0.3s ease, opacity 0.3s ease;
}

/* Modal header - Enhanced gradient and spacing */
#profitModal .modal-header {
    background: linear-gradient(135deg, #191264, #031a31);
    color: white;
    padding: 1.5rem 2rem;
    border-radius: 1rem 1rem 0 0;
    border: none;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}

/* Header decorative overlay */
#profitModal .modal-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(255, 255, 255, 0.15), transparent);
    pointer-events: none;
    border-radius: 1rem 1rem 0 0;
}

/* Modal title - Improved typography */
#profitModal .modal-title {
    margin: 0;
    font-size: clamp(1.1rem, 4vw, 1.6rem);
    font-weight: 600;
    color: #ffffff;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    z-index: 1;
    flex-wrap: wrap;
}

/* Modal body - Optimized padding and background */
#profitModal .modal-body {
    padding: clamp(1rem, 3vw, 2rem);
    background: #f8f9fa;
    border-radius: 0 0 16px 16px;
    overflow-y: auto;
    flex-grow: 1;
    min-height: 0;
}

/* Modal footer - Clean and aligned */
#profitModal .modal-footer {
    padding: clamp(1rem, 3vw, 1.5rem) clamp(1rem, 3vw, 2rem);
    border: none;
    background: #f8f9fa;
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    flex-wrap: wrap;
    border-radius: 0 0 1rem 1rem;
    flex-shrink: 0;
}

/* Form Elements - Enhanced styling */
#profitModal .form-label {
    color: #2c3e50;
    font-weight: 600;
    font-size: clamp(0.8rem, 2.5vw, 0.95rem);
    margin-bottom: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    line-height: 1.4;
}

/* Label decorative line */
#profitModal .form-label::before {
    content: '';
    width: 4px;
    height: 18px;
    background: linear-gradient(to bottom, #1f1a5c, #1f1a5c);
    border-radius: 2px;
    flex-shrink: 0;
}

/* Form inputs and selects - Consistent and modern */
#profitModal input[type="date"],
#profitModal input[type="number"],
#profitModal select,
#profitModal .form-control,
#profitModal .form-select {
    border-radius: 0.625rem;
    padding: clamp(0.75rem, 3vw, 1rem) clamp(0.875rem, 3vw, 1rem) !important;
    border: 1px solid #d1d5db !important;
    font-size: clamp(0.875rem, 3vw, 1rem) !important;
    background: #ffffff !important;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    font-family: 'Poppins', sans-serif;
    width: 100% !important;
    transition: all 0.3s ease;
    min-height: 44px;
}

/* Input focus and hover states */
#profitModal input[type="date"]:focus,
#profitModal input[type="number"]:focus,
#profitModal select:focus,
#profitModal .form-control:focus,
#profitModal .form-select:focus {
    border-color: #3B82F6 !important;
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2) !important;
    background: #ffffff !important;
}

#profitModal input[type="date"]:hover,
#profitModal input[type="number"]:hover,
#profitModal select:hover,
#profitModal .form-control:hover,
#profitModal .form-select:hover {
    border-color: #93c5fd !important;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1) !important;
}

/* Input validation states */
#profitModal input:invalid,
#profitModal select:invalid {
    border-color: #f87171 !important;
    box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.1) !important;
}

#profitModal input:valid,
#profitModal select:valid {
    border-color: #3B82F6 !important;
}

/* Readonly input styling */
#profitModal input[readonly] {
    background: #e5e7eb !important;
    cursor: not-allowed;
}

/* Button Styling - Modern and consistent */
#profitModal .btn {
    border-radius: 0.625rem !important;
    font-weight: 600;
    font-size: clamp(0.875rem, 3vw, 1rem) !important;
    padding: clamp(0.75rem, 3vw, 0.875rem) clamp(1rem, 4vw, 1.5rem) !important;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    min-height: 44px;
    text-align: center;
    white-space: nowrap;
}

/* Primary button */
#profitModal .btn-primary {
    background: linear-gradient(135deg, #221b6c, #233242);    
    border: none !important;
    color: #ffffff !important;
}

#profitModal .btn-primary:hover,
#profitModal .btn-primary:focus {
    background: linear-gradient(135deg, #112143, #161245) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

/* Secondary button */
#profitModal .btn-secondary {
    background: #6b7280 !important;
    border: none !important;
    color: #ffffff !important;
}

#profitModal .btn-secondary:hover,
#profitModal .btn-secondary:focus {
    background: #4b5563 !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Close button */
#profitModal .btn-close {
    filter: invert(1);
    opacity: 0.8;
    transition: opacity 0.3s ease;
    width: 1.5rem;
    height: 1.5rem;
}

#profitModal .btn-close:hover {
    opacity: 1;
}

/* Row and column layout - Enhanced responsiveness */
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
    flex: 0 0 auto;
    width: 100%;
    margin-bottom: 1rem;
}

/* Margin bottom adjustments */
#profitModal .mb-3 {
    margin-bottom: 1.5rem !important;
}

/* Responsive breakpoints */

/* Extra small devices (phones, less than 576px) */
@media (max-width: 575.98px) {
    #profitModal {
        padding: 0.5rem;
    }
    
    #profitModal.show {
        align-items: flex-start;
        padding-top: 1rem;
    }
    
    #profitModal .modal-content {
        border-radius: 0.75rem !important;
        max-height: calc(100vh - 2rem);
    }
    
    #profitModal .modal-header {
        padding: 1rem 1.25rem;
        border-radius: 0.75rem 0.75rem 0 0;
    }
    
    #profitModal .modal-title {
        font-size: 1.1rem;
        gap: 0.375rem;
    }
    
    #profitModal .modal-body {
        padding: 1rem 1.25rem;
    }
    
    #profitModal .modal-footer {
        padding: 1rem 1.25rem;
        gap: 0.5rem;
        flex-direction: column;
    }
    
    #profitModal .btn {
        width: 100%;
        padding: 0.875rem 1rem !important;
        font-size: 0.9rem !important;
    }
    
    #profitModal .form-label {
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
    }
    
    #profitModal .form-control,
    #profitModal .form-select {
        padding: 0.75rem 0.875rem !important;
        font-size: 0.9rem !important;
    }
    
    #profitModal .row {
        margin-right: -0.5rem;
        margin-left: -0.5rem;
    }
    
    #profitModal .col-md-4,
    #profitModal .col-md-6 {
        padding-right: 0.5rem;
        padding-left: 0.5rem;
        margin-bottom: 1rem;
    }
}

/* Small devices (landscape phones, 576px and up) */
@media (min-width: 576px) and (max-width: 767.98px) {
    #profitModal .modal-dialog {
        max-width: 540px;
    }
    
    #profitModal .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
    
    #profitModal .modal-footer {
        flex-direction: row;
        justify-content: flex-end;
    }
    
    #profitModal .btn {
        width: auto;
        min-width: 120px;
    }
}

/* Medium devices (tablets, 768px and up) */
@media (min-width: 768px) and (max-width: 991.98px) {
    #profitModal .modal-dialog {
        max-width: 720px;
    }
    
    #profitModal .col-md-4 {
        flex: 0 0 50%;
        max-width: 50%;
    }
    
    #profitModal .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

/* Large devices (desktops, 992px and up) */
@media (min-width: 992px) {
    #profitModal .modal-dialog {
        max-width: 800px;
    }
    
    #profitModal .col-md-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }
    
    #profitModal .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

/* Extra large devices (large desktops, 1200px and up) */
@media (min-width: 1200px) {
    #profitModal .modal-dialog {
        max-width: 900px;
    }
}

/* Landscape orientation adjustments for mobile */
@media (max-height: 600px) and (orientation: landscape) {
    #profitModal {
        padding: 0.25rem;
    }
    
    #profitModal.show {
        align-items: flex-start;
        padding-top: 0.5rem;
    }
    
    #profitModal .modal-content {
        max-height: calc(100vh - 1rem);
    }
    
    #profitModal .modal-header {
        padding: 0.75rem 1rem;
    }
    
    #profitModal .modal-body {
        padding: 1rem;
    }
    
    #profitModal .modal-footer {
        padding: 0.75rem 1rem;
    }
}

/* High DPI and zoom adjustments */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    #profitModal .form-control,
    #profitModal .form-select,
    #profitModal .btn {
        border-width: 0.5px;
    }
}

/* Accessibility - Reduce motion for users who prefer it */
@media (prefers-reduced-motion: reduce) {
    #profitModal .modal-content,
    #profitModal .btn,
    #profitModal .form-control,
    #profitModal .form-select {
        transition: none;
    }
}

/* Print styles */
@media print {
    #profitModal {
        display: none !important;
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