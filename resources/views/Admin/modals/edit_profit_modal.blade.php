<div id="editProfitModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Profit</h2>
        <form id="editProfitForm" action="{{ route('admin.profit.update', $profit->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" name="id" id="edit_id" value="{{ $profit->id }}">

    <label for="edit_date">Date:</label>
    <input type="date" name="date" id="edit_date" required>

    <label for="edit_plate_number">Plate Number:</label>
    <select id="edit_plate_number" name="plate_number" required>
        <option value="UVP353">UVP353</option>
        <option value="TQE262">TQE262</option>
        <option value="NBB7212">NBB7212</option>
        <option value="APA3309">APA3309</option>
        <option value="WIE914">WIE914</option>
    </select>

    <label for="edit_total_income">Total Income:</label>
    <input type="number" id="edit_total_income" name="total_income" step="0.01" required oninput="calculateEditProfit()">

    <label for="edit_total_expenses">Total Expenses:</label>
    <input type="number" id="edit_total_expenses" name="total_expenses" step="0.01" required oninput="calculateEditProfit()">

    <label for="edit_total_profit">Total Profit:</label>
    <input type="text" id="edit_total_profit" name="total_profit" readonly>

    <button type="submit">Update Profit</button>
</form>

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