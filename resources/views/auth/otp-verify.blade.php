<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification | Secure Access</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #3f37c9;
            --dark: #1b263b;
            --light: #f8f9fa;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --gray: #adb5bd;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1b263b 0%, #415a77 100%);
            color: var(--light);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .otp-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            animation: fadeIn 0.6s ease-out;
            transition: all 0.3s ease;
        }

        .otp-card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 700;
            color: white;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        h2 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
            color: white;
        }

        .subtitle {
            color: var(--gray);
            margin-bottom: 30px;
            font-size: 15px;
            line-height: 1.5;
        }

        .otp-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .otp-input-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .otp-input {
            width: 55px;
            height: 55px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            transition: all 0.3s ease;
        }

        .otp-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            transform: translateY(-2px);
        }

        .verify-btn {
            padding: 15px;
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .verify-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .verify-btn:active {
            transform: translateY(0);
        }

        .resend-section {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .resend-link {
            color: var(--success);
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .resend-link:hover {
            color: #3aa8d8;
            text-decoration: underline;
        }

        .resend-link.disabled {
            color: var(--gray);
            cursor: not-allowed;
            text-decoration: none;
        }

        .countdown {
            color: var(--gray);
            font-size: 13px;
        }

        .message {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .error-message {
            background: rgba(247, 37, 133, 0.1);
            color: var(--danger);
            border: 1px solid rgba(247, 37, 133, 0.2);
        }

        .success-message {
            background: rgba(76, 201, 240, 0.1);
            color: var(--success);
            border: 1px solid rgba(76, 201, 240, 0.2);
        }

        .icon {
            font-size: 18px;
        }

        @media (max-width: 480px) {
            .otp-card {
                padding: 30px 20px;
                border-radius: 15px;
            }
            
            .otp-input {
                width: 45px;
                height: 45px;
                font-size: 20px;
            }
            
            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="otp-card">
        <div class="logo">✓</div>
        <h2>Verify Your Identity</h2>
        <p class="subtitle">We've sent a 6-digit verification code to your email address</p>
        
        @if($errors->has('otp_error'))
            <div class="message error-message">
                <span class="icon">⚠️</span>
                <span>{{ $errors->first('otp_error') }}</span>
            </div>
        @endif
        
        <div id="successMessage" class="message success-message" style="display: none;">
            <span class="icon">✓</span>
            <span id="successText"></span>
        </div>
        
        <form method="POST" action="{{ route('verify.otp') }}" class="otp-form" id="otpForm">
            @csrf
            <div class="otp-input-container">
                <input type="text" name="otp1" class="otp-input" maxlength="1" pattern="\d" required>
                <input type="text" name="otp2" class="otp-input" maxlength="1" pattern="\d" required>
                <input type="text" name="otp3" class="otp-input" maxlength="1" pattern="\d" required>
                <input type="text" name="otp4" class="otp-input" maxlength="1" pattern="\d" required>
                <input type="text" name="otp5" class="otp-input" maxlength="1" pattern="\d" required>
                <input type="text" name="otp6" class="otp-input" maxlength="1" pattern="\d" required>
            </div>
            <input type="hidden" name="otp" id="fullOtp">
            <button type="submit" class="verify-btn">Verify & Continue</button>
            
            <div class="resend-section">
                <p>Didn't receive the code?</p>
                <span id="resendLink" class="resend-link" onclick="resendOTP()">
                    <span class="icon">↻</span>
                    <span>Resend OTP</span>
                </span>
                <span id="countdown" class="countdown"></span>
            </div>
        </form>
    </div>

    <script>
        // Auto-focus and move between OTP inputs
        const otpInputs = document.querySelectorAll('.otp-input');
        const fullOtpField = document.getElementById('fullOtp');
        const otpForm = document.getElementById('otpForm');
        
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1) {
                    if (index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                }
                
                updateFullOtp();
            });
            
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });
        
        function updateFullOtp() {
            let fullOtp = '';
            otpInputs.forEach(input => {
                fullOtp += input.value;
            });
            fullOtpField.value = fullOtp;
        }
        
        // Handle form submission
        otpForm.addEventListener('submit', function(e) {
            updateFullOtp();
            
            // Validate all fields are filled
            let allFilled = true;
            otpInputs.forEach(input => {
                if (input.value === '') {
                    allFilled = false;
                }
            });
            
            if (!allFilled) {
                e.preventDefault();
                showError('Please enter the complete 6-digit code');
            }
        });
        
        // Countdown timer for resend OTP
        let countdown = 30; // 30 seconds before allowing resend
        const resendLink = document.getElementById('resendLink');
        const countdownElement = document.getElementById('countdown');
        const successMessage = document.getElementById('successMessage');
        const successText = document.getElementById('successText');
        
        function updateCountdown() {
            if (countdown > 0) {
                resendLink.classList.add('disabled');
                countdownElement.textContent = `Resend available in ${countdown}s`;
                countdown--;
                setTimeout(updateCountdown, 1000);
            } else {
                resendLink.classList.remove('disabled');
                countdownElement.textContent = '';
            }
        }
        
        // Start the countdown when page loads
        updateCountdown();
        
        function resendOTP() {
            // Check if countdown is still active
            if (countdown > 0) return;
            
            // Disable the resend link temporarily
            resendLink.classList.add('disabled');
            
            fetch('{{ route("resend.otp") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    successText.textContent = 'New verification code sent successfully!';
                    successMessage.style.display = 'flex';
                    
                    // Hide message after 5 seconds
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 5000);
                    
                    // Reset countdown
                    countdown = 30;
                    updateCountdown();
                    
                    // Clear all OTP inputs
                    otpInputs.forEach(input => {
                        input.value = '';
                    });
                    otpInputs[0].focus();
                } else {
                    showError(data.message || 'Failed to resend verification code');
                    resendLink.classList.remove('disabled');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('An error occurred while resending the code');
                resendLink.classList.remove('disabled');
            });
        }
        
        function showError(message) {
            // Remove any existing error messages first
            const existingError = document.querySelector('.message.error-message:not([id])');
            if (existingError) {
                existingError.remove();
            }
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'message error-message';
            errorDiv.innerHTML = `<span class="icon">⚠️</span><span>${message}</span>`;
            
            const form = document.querySelector('.otp-form');
            form.parentNode.insertBefore(errorDiv, form);
            
            // Remove message after 5 seconds
            setTimeout(() => {
                errorDiv.remove();
            }, 5000);
        }
        
        // Focus first OTP input on page load
        window.addEventListener('DOMContentLoaded', () => {
            otpInputs[0].focus();
        });
    </script>
</body>
</html>