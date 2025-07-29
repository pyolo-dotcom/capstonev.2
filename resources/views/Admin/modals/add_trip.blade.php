<div id="tripModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-header">
            <h2>Add New Trip</h2>
        </div>
        <div class="modal-body">
            <form id="tripForm">
                @csrf
                <div>
                    <label for="plate_no">Plate Number:</label>
                    <select id="plate_no" name="plate_no" required>
                        <option value="" disabled selected>-- Select Plate Number --</option>
                        @foreach($plateNumbers as $plate)
                            <option value="{{ $plate }}">{{ $plate }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="trip_type">Trip Type:</label>
                    <select id="trip_type" name="trip_type" class="form-control" required>
                    <option value="" disabled selected>-- Select Trip --</option>
                    <option value="One Way Trip">One Way Trip</option>
                    <option value="Round Trip">Round Trip</option>
                    <option value="Door-To-Door Trip">Door-To-Door Trip</option>
                </select>
                </div>

                <div>
                    <label for="num_trips">Number of Trips:</label>
                    <input type="number" id="num_trips" name="num_trips" min="1" required>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="submit" form="tripForm">Submit Trip</button>
        </div>
    </div>
</div>

<style>
    /* ENHANCED MODAL STYLING */
    #tripModal {
        display: none;
        position: fixed;
        z-index: 1100;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6); /* Darker semi-transparent background */    
    }

    #tripModal.show {
        display: flex !important;
        justify-content: center;
        align-items: center; /* Change from flex-start to center */
        padding-top: 0;
    }

    #tripModal .modal-content {
        margin: auto;
        padding: 0 !important;
        border-radius: 25px !important;
        width: 90%;
        max-width: 480px;
        position: relative;
        max-height: 100vh;
        display: flex;
        flex-direction: column;
        transform: translateY(4vh);
        overflow: hidden;
    }

    #tripModal .modal-header {
        background: linear-gradient(135deg, #1f1a5c, #2c3e50);
        color: white;
        padding: 25px 30px;
        border-radius: 20px 20px 0 0;
        margin: 0;
        border: none;
        position: relative;
        overflow: hidden;
    }

    #tripModal .modal-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1), transparent);
        pointer-events: none;
    }

    #tripModal .modal-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
        color: white;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 1;
        position: relative;
    }

    #tripModal .modal-header h2::before {
        content: '\f067';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        font-size: 1.2rem;
        color: #64b5f6;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    }

    #tripModal .modal-body {
        overflow-y: auto;
        flex-grow: 1;
        padding: 30px;
        background: linear-gradient(to bottom, #ffffff, #f8f9fa);
    }

    #tripModal .modal-footer {
        padding: 20px 30px 30px;
        border: none;
        margin: 0;
        background: linear-gradient(to top, #f8f9fa, #ffffff);
    }

    #tripModal .close {
        position: absolute;
        top: 20px;
        right: 25px;
        font-size: 28px;
        font-weight: 300;
        color: rgba(255, 255, 255, 0.8);
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 2;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    #tripModal .close:hover {
        color: white;
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(90deg);
    }

    #tripModal .modal-content form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    #tripModal .modal-content form > div {
        display: flex;
        flex-direction: column;
    }

    #tripModal .modal-content label {
        font-weight: 600;
        color: #1f1a5c;
        margin-bottom: 8px;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        position: relative;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    #tripModal .modal-content label::before {
        content: '';
        width: 3px;
        height: 16px;
        background: linear-gradient(to bottom, #1f1a5c, #1f1a5c);
        border-radius: 2px;
    }

    #tripModal .modal-content select,
    #tripModal .modal-content input {
        padding: 14px 18px;
        border: 2px solid #e8ecf0;
        border-radius: 12px;
        font-size: 15px;
        width: 100%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: linear-gradient(to bottom, #ffffff, #f8f9fa);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        font-family: 'Poppins', sans-serif;
    }

    #tripModal .modal-content select:focus,
    #tripModal .modal-content input:focus {
        border-color: #1f1a5c;
        outline: none;
        box-shadow: 
            0 0 0 3px rgba(31, 26, 92, 0.1),
            0 4px 12px rgba(31, 26, 92, 0.15);
        background: #ffffff;
        transform: translateY(-1px);
    }

    #tripModal .modal-content select:hover,
    #tripModal .modal-content input:hover {
        border-color: #64b5f6;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transform: translateY(-1px);
    }

    #tripModal .modal-content button[type="submit"] {
        background: linear-gradient(135deg, #1f1a5c, #2c3e50);
        color: white;
        border: none;
        padding: 16px 32px;
        border-radius: 12px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 
            0 4px 15px rgba(31, 26, 92, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    #tripModal .modal-content button[type="submit"]::before {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    #tripModal .modal-content button[type="submit"]:hover::before {
        opacity: 1;
    }

    #tripModal .modal-content button[type="submit"]:hover {
        background: linear-gradient(135deg, #161245, #233140);
        transform: translateY(-2px);
        box-shadow: 
            0 8px 25px rgba(31, 26, 92, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    #tripModal .modal-content button[type="submit"]:active {
        transform: translateY(0);
        box-shadow: 
            0 4px 15px rgba(31, 26, 92, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    /* Form validation styling */
    #tripModal .modal-content input:invalid,
    #tripModal .modal-content select:invalid {
        border-color: #ff96a1;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    }

    #tripModal .modal-content input:valid,
    #tripModal .modal-content select:valid {
        border-color: #3577ae;
    }

    /* Enhanced responsive design */
    @media (max-width: 1400px) {
        #tripModal .modal-content {
            max-width: 450px;
            width: 88%;
        }
    }

    @media (max-width: 1200px) {
        #tripModal .modal-content {
            max-width: 420px;
            width: 90%;
        }
        
        #tripModal .modal-header h2 {
            font-size: 1.4rem;
        }
        
        #tripModal .modal-content select,
        #tripModal .modal-content input {
            padding: 13px 16px;
            font-size: 14px;
        }
    }

    @media (max-width: 1024px) {
        #tripModal .modal-content {
            max-width: 400px;
            width: 92%;
            max-height: 85vh;
        }
        
        #tripModal .modal-body {
            padding: 25px 22px;
        }
        
        #tripModal .modal-footer {
            padding: 18px 22px 25px;
        }
    }

    @media (max-width: 992px) {
        #tripModal .modal-content {
            max-width: 380px;
            width: 94%;
        }

        #tripModal .modal-header h2 {
            font-size: 1.35rem;
        }
    }

    @media (max-width: 768px) {
        #tripModal .modal-content {
            width: 96%;
            max-width: 96%;
            margin: 8px;
            border-radius: 16px;
            max-height: 88vh;
        }

        #tripModal .modal-header {
            padding: 22px 25px;
            border-radius: 16px 16px 0 0;
        }

        #tripModal .modal-header h2 {
            font-size: 1.3rem;
            gap: 10px;
        }

        #tripModal .modal-body {
            padding: 22px 18px;
        }

        #tripModal .modal-footer {
            padding: 16px 18px 22px;
        }

        #tripModal .close {
            top: 18px;
            right: 22px;
            font-size: 26px;
            width: 38px;
            height: 38px;
        }
        
        #tripModal .modal-content form {
            gap: 14px;
        }
        
        #tripModal .modal-content select,
        #tripModal .modal-content input {
            padding: 13px 15px;
            font-size: 14px;
            border-radius: 10px;
        }
        
        #tripModal .modal-content button[type="submit"] {
            padding: 15px 28px;
            font-size: 15px;
        }
    }

    @media (max-width: 640px) {
        #tripModal .modal-content {
            width: 98%;
            max-width: 98%;
            margin: 5px;
            max-height: 92vh;
            border-radius: 14px;
        }
        
        #tripModal .modal-header {
            padding: 20px 22px;
            border-radius: 14px 14px 0 0;
        }
        
        #tripModal .modal-header h2 {
            font-size: 1.25rem;
            gap: 8px;
        }
        
        #tripModal .modal-body {
            padding: 20px 16px;
        }
        
        #tripModal .modal-footer {
            padding: 14px 16px 20px;
        }
        
        #tripModal .close {
            top: 16px;
            right: 20px;
            font-size: 24px;
            width: 36px;
            height: 36px;
        }
    }

    @media (max-width: 576px) {
        #tripModal .modal-content {
            border-radius: 12px;
            max-height: 95vh;
        }

        #tripModal .modal-header {
            padding: 18px 20px;
            border-radius: 12px 12px 0 0;
        }

        #tripModal .modal-header h2 {
            font-size: 1.2rem;
        }

        #tripModal .modal-body {
            padding: 18px 14px;
        }

        #tripModal .modal-footer {
            padding: 12px 14px 18px;
        }

        #tripModal .modal-content form {
            gap: 13px;
        }

        #tripModal .modal-content select,
        #tripModal .modal-content input {
            padding: 12px 14px;
            font-size: 14px;
        }
        
        #tripModal .modal-content label {
            font-size: 0.85rem;
            margin-bottom: 6px;
        }
        
        #tripModal .modal-content button[type="submit"] {
            padding: 14px 24px;
            font-size: 14px;
        }
        
        #tripModal .close {
            top: 14px;
            right: 18px;
            width: 34px;
            height: 34px;
            font-size: 22px;
        }
    }

    @media (max-width: 480px) {
        #tripModal .modal-content {
            width: 100%;
            max-width: 100%;
            margin: 0;
            border-radius: 0;
            max-height: 100vh;
        }
        
        #tripModal .modal-header {
            border-radius: 0;
            padding: 16px 18px;
        }
        
        #tripModal .modal-header h2 {
            font-size: 1.15rem;
        }
        
        #tripModal .modal-body {
            padding: 16px 12px;
        }
        
        #tripModal .modal-footer {
            padding: 10px 12px 16px;
        }
        
        #tripModal .close {
            top: 12px;
            right: 16px;
            width: 32px;
            height: 32px;
            font-size: 20px;
        }
        
        #tripModal .modal-content form {
            gap: 12px;
        }
        
        #tripModal .modal-content select,
        #tripModal .modal-content input {
            padding: 11px 13px;
            font-size: 13px;
            border-radius: 8px;
        }
        
        #tripModal .modal-content label {
            font-size: 0.8rem;
            margin-bottom: 5px;
        }
        
        #tripModal .modal-content button[type="submit"] {
            padding: 13px 20px;
            font-size: 13px;
            border-radius: 8px;
        }
    }

    @media (max-width: 360px) {
        #tripModal .modal-header h2 {
            font-size: 1.1rem;
        }
        
        #tripModal .modal-body {
            padding: 14px 10px;
        }
        
        #tripModal .modal-footer {
            padding: 8px 10px 14px;
        }
        
        #tripModal .modal-content select,
        #tripModal .modal-content input {
            padding: 10px 12px;
            font-size: 13px;
        }
        
        #tripModal .modal-content label {
            font-size: 0.75rem;
        }
        
        #tripModal .modal-content button[type="submit"] {
            padding: 12px 18px;
            font-size: 12px;
        }
        
        #tripModal .close {
            width: 30px;
            height: 30px;
            font-size: 18px;
        }
    }

    /* Landscape orientation adjustments for mobile */
    @media (max-height: 500px) and (orientation: landscape) {
        #tripModal .modal-content {
            max-height: 95vh;
            width: 90%;
            max-width: 600px;
        }
        
        #tripModal .modal-header {
            padding: 12px 20px;
        }
        
        #tripModal .modal-header h2 {
            font-size: 1.1rem;
        }
        
        #tripModal .modal-body {
            padding: 15px 20px;
        }
        
        #tripModal .modal-footer {
            padding: 10px 20px 15px;
        }
        
        #tripModal .modal-content form {
            gap: 12px;
        }
        
        #tripModal .close {
            top: 8px;
            right: 15px;
            width: 30px;
            height: 30px;
            font-size: 18px;
        }
    }

    /* High DPI adjustments */
    @media (-webkit-min-device-pixel-ratio: 2) {
        #tripModal .modal-content select,
        #tripModal .modal-content input {
            border-width: 1px;
        }
        
        #tripModal .modal-content label::before {
            width: 2px;
        }
    }
</style>