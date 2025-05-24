<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: 'Playfair Display', sans-serif;
            background-color: #2f4156;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .otp-container {
            background-color: #3a4b60;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .otp-container h2 {
            margin-bottom: 20px;
        }
        .otp-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .otp-input {
            width: 80%;
            padding: 15px;
            margin: 10px 0;
            font-size: 18px;
            border: none;
            border-radius: 25px;
            text-align: center;
        }
        .verify-btn {
            padding: 15px;
            width: 80%;
            background-color: #004aad;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        .verify-btn:hover {
            background-color: #365a8c;
        }
        .resend-link {
            margin-top: 15px;
            color: #4da6ff;
            cursor: pointer;
        }
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <h2>OTP Verification</h2>
        <p>We've sent an OTP to your email</p>
        
        <form method="POST" action="{{ route('verify.otp') }}" class="otp-form">
            @csrf
            <input type="text" name="otp" placeholder="Enter 6-digit OTP" class="otp-input" required maxlength="6" pattern="\d{6}">
            <button type="submit" class="verify-btn">VERIFY</button>
            
            @if($errors->has('otp_error'))
                <p class="error-message">{{ $errors->first('otp_error') }}</p>
            @endif
            
            <p class="resend-link" onclick="resendOTP()">Resend OTP</p>
        </form>
    </div>

    <script>
        function resendOTP() {
            fetch('{{ route("send.otp") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    username: '{{ Session::get("otp_username") }}',
                    password: '{{ Session::get("otp_password") }}'
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert('New OTP sent to your email');
                } else {
                    alert('Failed to resend OTP');
                }
            });
        }
    </script>
</body>
</html>