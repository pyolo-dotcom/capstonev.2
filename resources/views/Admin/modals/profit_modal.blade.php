<div id="addProfitModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add Profit</h2>
        <form action="{{ route('admin.profit.store') }}" method="POST">
            @csrf
            <label for="date">Date:</label>
            <input type="date" name="date" required>
            
            <label for="plate_number">Plate Number:</label>
            <select id="plateNumber" name="plate_number" required>
                <option disabled selected>-- Plate Number --</option>
                <option value="UVP353">UVP353</option>
                <option value="TQE262">TQE262</option>
                <option value="NBB7212">NBB7212</option>
                <option value="APA3309">APA3309</option>
                <option value="WIE914">WIE914</option>
            </select>

            <label for="total_income">Total Income:</label>
            <input type="number" id="total_income" name="total_income" step="0.01" required oninput="calculateProfit()">
            
            <label for="total_expenses">Total Expenses:</label>
            <input type="number" id="total_expenses" name="total_expenses" step="0.01" required oninput="calculateProfit()">
            
            <label for="total_profit">Total Profit:</label>
            <input type="text" id="total_profit" name="total_profit" readonly>

            <button type="submit">Save Profit</button>
        </form>
    </div>
</div>

<!-- Add Profits Button -->
<button id="openModal" class="tab-button">+ Add Profits</button>

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