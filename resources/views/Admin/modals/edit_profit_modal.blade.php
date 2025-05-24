<!-- Edit Profit Modal -->
<div class="modal fade" id="editProfitModal-{{ $profit->id }}" tabindex="-1" aria-labelledby="editProfitModalLabel-{{ $profit->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editProfitModalLabel-{{ $profit->id }}"><i class="fas fa-edit me-2"></i>Edit Profit Record</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProfitForm-{{ $profit->id }}" action="{{ route('admin.profit.update', $profit->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $profit->id }}">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_date-{{ $profit->id }}" class="form-label fw-semibold">Date</label>
                            <input type="date" class="form-control form-control-lg" id="edit_date-{{ $profit->id }}" name="date" value="{{ $profit->date }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_plate_number-{{ $profit->id }}" class="form-label fw-semibold">Plate Number</label>
                            <select class="form-select form-select-lg" id="edit_plate_number-{{ $profit->id }}" name="plate_number" required>
                                @foreach($plateNumbers as $plateNumber)
                                    <option value="{{ $plateNumber }}" {{ $profit->plate_number == $plateNumber ? 'selected' : '' }}>{{ $plateNumber }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="edit_total_income-{{ $profit->id }}" class="form-label fw-semibold">Total Income (₱)</label>
                            <input type="number" step="0.01" class="form-control form-control-lg" id="edit_total_income-{{ $profit->id }}" name="total_income" value="{{ $profit->total_income }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_total_expenses-{{ $profit->id }}" class="form-label fw-semibold">Total Expenses (₱)</label>
                            <input type="number" step="0.01" class="form-control form-control-lg" id="edit_total_expenses-{{ $profit->id }}" name="total_expenses" value="{{ $profit->total_expenses }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="edit_total_profit-{{ $profit->id }}" class="form-label fw-semibold">Total Profit (₱)</label>
                            <input type="number" step="0.01" class="form-control form-control-lg bg-light" id="edit_total_profit-{{ $profit->id }}" name="total_profit" value="{{ $profit->total_profit }}" readonly>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Close
                        </button>
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="fas fa-save me-2"></i>Update Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Calculate profit when editing
        document.addEventListener('input', function(e) {
            if (e.target && e.target.id && e.target.id.startsWith('edit_total_income-')) {
                const id = e.target.id.split('-')[2];
                calculateEditProfit(id);
            }
            if (e.target && e.target.id && e.target.id.startsWith('edit_total_expenses-')) {
                const id = e.target.id.split('-')[2];
                calculateEditProfit(id);
            }
        });

        function calculateEditProfit(id) {
            const income = parseFloat(document.getElementById(`edit_total_income-${id}`).value) || 0;
            const expenses = parseFloat(document.getElementById(`edit_total_expenses-${id}`).value) || 0;
            document.getElementById(`edit_total_profit-${id}`).value = (income - expenses).toFixed(2);
        }
    });
</script>