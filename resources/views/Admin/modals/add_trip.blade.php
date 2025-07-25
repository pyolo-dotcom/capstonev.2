<div id="tripModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 class="modal-title">Add New Trip</h2>
        <form id="tripForm" class="modal-form">
            @csrf
            <div class="form-group">
                <label for="plate_no">Plate No.:</label>
                <select id="plate_no" name="plate_no" class="form-control" required>
                    <option value="" disabled selected>-- Select Plate Number --</option>
                    @foreach($plateNumbers as $plate)
                        <option value="{{ $plate }}">{{ $plate }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="trip_type">Trip Type:</label>
                <select id="trip_type" name="trip_type" class="form-control" required>
                    <option disabled selected>-- Select Trip --</option>
                    <option value="One Way Trip">One Way Trip</option>
                    <option value="Round Trip">Round Trip</option>
                    <option value="Door-To-Door Trip">Door-To-Door Trip</option>
                </select>
            </div>

            <div class="form-group">
                <label for="num_trips">Number of Trips:</label>
                <input type="number" id="num_trips" name="num_trips" class="form-control" min="1" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* Import Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

/* Import Font Awesome for icons */
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css');

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(8px);
    font-family: 'Poppins', sans-serif;
    overflow: auto;
    animation: fadeIn 0.3s ease-in-out;
}

.modal-content {
    background: linear-gradient(145deg, #ffffff, #e8edff);
    margin: 8% auto;
    padding: 30px;
    border-radius: 20px;
    width: 90%;
    max-width: 480px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
    border: 1px solid rgba(106, 90, 205, 0.2);
    position: relative;
    animation: modalopen 0.4s ease-out;
    overflow: hidden;
}

.modal-title {
    color: #2a2a72;
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 20px;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    position: relative;
}

.modal-title::before {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #6a5acd, #483d8b);
    border-radius: 2px;
}

.close {
    color: #777;
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 28px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    line-height: 40px;
    border-radius: 50%;
}

.close:hover {
    color: #6a5acd;
    transform: rotate(90deg);
    background: rgba(106, 90, 205, 0.1);
}

.modal-form {
    display: flex;
    flex-direction: column;
    gap: 25px;
    padding-top: 10px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    position: relative;
}

.form-group label {
    font-size: 15px;
    color: #333;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-group label::before {
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    color: #6a5acd;
    font-size: 16px;
}

.form-group label[for="plate_no"]::before {
    content: '\f0d1'; /* Truck icon for Plate No. */
}

.form-group label[for="trip_type"]::before {
    content: '\f5b0'; /* Route icon for Trip Type */
}

.form-group label[for="num_trips"]::before {
    content: '\f01e'; /* Repeat icon for Number of Trips */
}

.form-control {
    padding: 14px 45px 14px 15px;
    border: 1px solid #d0d7e5;
    border-radius: 30px;
    font-size: 16px;
    background: #f9fbff;
    transition: all 0.3s ease;
}

.form-control[type="number"] {
    padding: 14px 15px; /* Remove right padding for number input */
    background-image: none; /* Remove dropdown arrow for number input */
    -moz-appearance: textfield; /* Remove spinners in Firefox */
}

.form-control[type="number"]::-webkit-inner-spin-button,
.form-control[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none; /* Remove spinners in Chrome/Safari */
    margin: 0;
}

.form-control:not([type="number"]) {
    appearance: none;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path fill="%236a5acd" d="M7 10l5 5 5-5z"/></svg>');
    background-repeat: no-repeat;
    background-position: right 15px center;
    background-size: 12px;
}

.form-control:focus {
    outline: none;
    border-color: #6a5acd;
    box-shadow: 0 0 0 5px rgba(106, 90, 205, 0.15);
    background-color: #fff;
}

.form-control:invalid {
    border-color: #ff6b6b;
}

.form-actions {
    display: flex;
    justify-content: center; /* Center the Submit button */
    margin-top: 25px;
}

.btn {
    padding: 12px 35px;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-primary {
    background: linear-gradient(90deg, #6a5acd, #483d8b);
    color: white;
    box-shadow: 0 5px 20px rgba(106, 90, 205, 0.3);
}

.btn-primary:hover {
    background: linear-gradient(90deg, #483d8b, #6a5acd);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(106, 90, 205, 0.4);
}

.btn-primary:active {
    transform: translateY(0);
    box-shadow: 0 3px 15px rgba(106, 90, 205, 0.2);
}

.btn-primary::before {
    content: '\f058'; /* Check circle icon */
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    margin-right: 8px;
}

.btn:not(.btn-primary) {
    background: linear-gradient(90deg, #e0e0e0, #d0d0d0);
    color: #333;
}

.btn:not(.btn-primary):hover {
    background: linear-gradient(90deg, #d0d0d0, #c0c0c0);
    transform: translateY(-3px);
}

@keyframes modalopen {
    from {
        opacity: 0;
        transform: scale(0.85) translateY(20px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@media (max-width: 768px) {
    .modal-content {
        width: 85%;
        margin: 12% auto;
        padding: 25px;
    }

    .modal-title {
        font-size: 20px;
    }

    .form-control {
        font-size: 15px;
        padding: 12px 40px 12px 12px;
    }

    .form-control[type="number"] {
        padding: 12px 12px;
    }

    .btn {
        padding: 10px 30px;
        font-size: 15px;
    }
}

@media (max-width: 480px) {
    .modal-content {
        width: 90%;
        margin: 15% auto;
        padding: 20px;
    }

    .close {
        top: 12px;
        right: 12px;
        font-size: 24px;
        width: 36px;
        height: 36px;
        line-height: 36px;
    }

    .modal-title {
        font-size: 18px;
    }

    .form-group label {
        font-size: 14px;
    }

    .form-control {
        font-size: 14px;
        padding: 10px 35px 10px 10px;
    }

    .form-control[type="number"] {
        padding: 10px 10px;
    }

    .btn {
        padding: 8px 25px;
        font-size: 14px;
    }
}
</style>
