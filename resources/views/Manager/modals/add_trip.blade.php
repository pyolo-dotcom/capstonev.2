<div id="tripModal" class="modal">
    <div class="modal-content">
        <span class="close">×</span>
        <div class="modal-header">
            <h2 class="modal-title">Add New Trip</h2>
        </div>
        <form id="tripForm" class="modal-form">
            @csrf
            <div class="form-group">
                <label for="plate_no">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="6" width="18" height="12" rx="2" stroke="currentColor" stroke-width="2" fill="none"/>
                        <path d="M7 10h10M7 14h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Plate Number
                </label>
                <select id="plate_no" name="plate_no" class="form-control" required>
                    <option value="" disabled selected>-- Select Plate Number --</option>
                    @foreach($plateNumbers as $plate)
                        <option value="{{ $plate }}">{{ $plate }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="trip_type">
                    <!-- Navigation Icon -->
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <rect x="1" y="3" width="15" height="13" />
                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8" />
                    <circle cx="5.5" cy="19.5" r="2.5" />
                    <circle cx="18.5" cy="19.5" r="2.5" />
                </svg>
                    Trip Type
                </label>
                <select id="trip_type" name="trip_type" class="form-control" required>
                    <option disabled selected>-- Select Trip --</option>
                    <option value="One Way Trip">One Way Trip</option>
                    <option value="Round Trip">Round Trip</option>
                    <option value="Door-To-Door Trip">Door-To-Door Trip</option>
                </select>
            </div>
            <div class="form-group">
                <label for="num_trips">
                    <!-- Hashtag Icon -->
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <line x1="4" y1="9" x2="20" y2="9"/>
                        <line x1="4" y1="15" x2="20" y2="15"/>
                        <line x1="10" y1="3" x2="10" y2="21"/>
                        <line x1="14" y1="3" x2="14" y2="21"/>
                    </svg>
                    Number of Trips
                </label>
                <input type="number" id="num_trips" name="num_trips" class="form-control" min="1" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <polyline points="20,6 9,17 4,12" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Submit Trip
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        
        overflow: auto;
    }

    .modal-content {
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        margin: 5% auto;
        padding: 0;
        border-radius: 20px;
        width: 90%;
        max-width: 480px;
        box-shadow: 
            0 25px 50px rgba(31, 26, 92, 0.15),
            0 0 0 1px rgba(255, 255, 255, 0.1);
        animation: slideUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        overflow: hidden;
        position: relative;
    }

    .modal-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #1f1a5c, #6e5ff1, #1c1a91, #1f1a5c);
        background-size: 300% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }

    .modal-header {
        text-align: center;
        padding: 25px 30px 10px;
        background: linear-gradient(135deg, #e2f2ff, #ffffff);
        border-bottom: 1px solid rgba(31, 26, 92, 0.08);
        position: relative;
    }

    .modal-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #1f1a5c, #7c97ed, #1f1a5c);
        border-radius: 0 0 20px 20px;
    }

    .modal-title {
        color: #1f1a5c;
        margin: 0 auto;
        font-size: 28px;
        font-weight: bold;
        letter-spacing: -1px;
        text-transform: uppercase;
        text-align: center;
        display: inline-block;
        width: 100%;
        background: linear-gradient(135deg, #1f1a5c, #463fba, #1f1a5c);
        background-size: 200% 200%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: gradientShift 4s ease-in-out infinite;
        position: relative;
    }

    .modal-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 2px;
        background: linear-gradient(90deg, transparent, #1f1a5c, transparent);
        border-radius: 2px;
    }

    .close {
        position: absolute;
        top: 20px;
        right: 20px;
        color: #374151;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        background: rgba(156, 163, 175, 0.2);
        z-index: 1001;
    }

    .close:hover {
        color: #403ca7;
        background: rgba(77, 123, 202, 0.2);
        transform: rotate(90deg);
    }

    .modal-form {
        padding: 20px 30px 30px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        position: relative;
    }

    .form-group label {
        font-weight: 600;
        color: #374151;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
    }

    .form-group label svg {
        color: #1f1a5c;
        flex-shrink: 0;
    }

    .form-control {
        padding: 14px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 15px;
        background: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .form-control:focus {
        outline: none;
        border-color: #1f1a5c;
        box-shadow: 0 0 0 3px rgba(31, 26, 92, 0.1);
        transform: translateY(-1px);
    }

    .form-control:hover {
        border-color: #d1d5db;
    }

    select.form-control {
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 16px;
        padding-right: 40px;
        appearance: none;
    }

    input[type="number"].form-control {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: textfield;
    }

    input[type="number"].form-control::-webkit-outer-spin-button,
    input[type="number"].form-control::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .form-actions {
        display: flex;
        justify-content: center;
        margin-top: 24px;
    }

    .btn {
        padding: 14px 32px;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
        background: none;
        color: inherit;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1f1a5c, #251eb6);
        color: white;
        box-shadow: 0 8px 20px rgba(31, 26, 92, 0.3);
        min-height: 48px;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1f1a5c, #4942b7);
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(31, 26, 92, 0.4);
    }

    .btn-primary:active {
        transform: translateY(0);
        box-shadow: 0 4px 12px rgba(31, 26, 92, 0.3);
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { 
            opacity: 0; 
            transform: translateY(50px) scale(0.95); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0) scale(1); 
        }
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes shimmer {
        0% { background-position: -300% 0; }
        100% { background-position: 300% 0; }
    }

    @media (max-width: 768px) {
        .modal-content {
            width: 95%;
            margin: 10% auto;
            border-radius: 16px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .modal-form {
            padding: 12px 16px 16px;
            gap: 12px;
        }
        
        .modal-header {
            padding: 25px 16px 12px;
        }
        
        .modal-title {
            font-size: 18px;
        }
        
        .form-group label {
            font-size: 13px;
        }
        
        .form-control {
            padding: 10px 12px;
            font-size: 14px;
            border-radius: 10px;
        }
        
        .form-actions {
            margin-top: 16px;
        }
        
        .btn {
            padding: 10px 20px;
            font-size: 13px;
            min-height: 44px;
            width: 100%;
            justify-content: center;
            border-radius: 10px;
        }
    }

    @media (max-width: 480px) {
        .modal-content {
            width: 100%;
            margin: 0;
            max-height: 90vh;
            border-radius: 0;
            animation: slideInFromBottom 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .modal-header {
            padding: 25px 12px 8px;
        }
        
        .modal-title {
            font-size: 16px;
        }
        
        .modal-form {
            padding: 8px 12px 12px;
            gap: 10px;
            flex-grow: 1;
        }
        
        .form-group label {
            font-size: 12px;
        }
        
        .form-control {
            padding: 8px 10px;
            font-size: 13px;
            border-radius: 8px;
        }
        
        .form-actions {
            margin-top: 12px;
        }
        
        .btn {
            padding: 8px 16px;
            font-size: 12px;
            min-height: 40px;
            width: 100%;
            justify-content: center;
            border-radius: 8px;
            line-height: 1.2;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1f1a5c, #251eb6);
            box-shadow: 0 6px 15px rgba(31, 26, 92, 0.3);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #1f1a5c, #4942b7);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(31, 26, 92, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 3px 10px rgba(31, 26, 92, 0.3);
        }
        
        .close {
            top: 12px;
            right: 12px;
            width: 36px;
            height: 36px;
            font-size: 20px;
        }
    }

    @keyframes slideInFromBottom {
        from { 
            opacity: 0; 
            transform: translateY(100%); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
</style>