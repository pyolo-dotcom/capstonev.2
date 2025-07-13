<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - SYA Trucking Services</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
</head>
<style>
    /* Theme Colors - Unified with Login Page */
    :root {
        --primary-color: #2f4156; /* Dark Blue-Grey (main background color for the page) */
        --secondary-color: #004aad; /* Same as accent */
        --accent-color: #004aad; /* Medium Blue - Prominent */
        --light-color: #f8f9fa; /* Off-white */
        --dark-color: #212529; /* Near-black */
        --text-light: #ffffff; /* White text for buttons/contrast */
        --text-muted: #adb5bd; /* Muted light grey */
        --shadow: 0 4px 20px rgba(0, 0, 0, 0.15); /* Original shadow */
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);

        /* Specific colors for this design */
        --left-panel-bg: var(--primary-color); /* Used for body background */
        --right-panel-bg: #ffffff; /* Used for the form container */
        --input-border-default: #e0e0e0;
        --input-text-color: #333333;
        /* --- UPDATED BUTTON COLORS HERE --- */
        --button-primary-bg: #004aad; /* Changed from #222222 to #004aad */
        --button-primary-hover: #365a8c; /* Changed from #000000 to #365a8c */
        /* --- END UPDATED BUTTON COLORS --- */
        --link-color: var(--accent-color);
        --text-grey: #6c757d; /* For other muted text */
        --error-color: #dc3545;
        --error-bg-transparent: rgba(220, 53, 69, 0.08);
        --success-color: #28a745;
        --success-bg-transparent: rgba(40, 167, 69, 0.08);
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Plus Jakarta Sans', sans-serif; /* Consistent font */
    }

    html, body {
        height: 100%;
        width: 100%;
    }

    /* Body background - Reverted to original solid color */
    body {
        background-color: var(--primary-color); /* Original dark blue-grey solid color */
        color: var(--dark-color); /* Default text color, overridden by container */
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        height: 100vh;
    }

    /* Forgot Password Container - Styles like the login page's right panel (remains unchanged from last edit) */
    .forgot-password-container {
        background-color: var(--right-panel-bg); /* White background */
        padding: 3.5rem 3rem; /* Generous padding */
        border-radius: 10px;
        width: 100%;
        max-width: 420px; /* Max width for the container */
        box-shadow: 0 0 30px rgba(0,0,0,0.2); /* Prominent shadow for a floating card effect */
        position: relative; /* For positioning the logo inside */
        text-align: left; /* Align text within the container to the left */
        z-index: 10; /* Ensure it's above the body backgrounds (though simpler now) */
    }

    /* Logo within the single panel container (remains unchanged from last edit) */
    .container-logo {
        position: absolute;
        top: 1.5rem; /* Distance from the top of the container */
        right: 2rem; /* Distance from the right of the container */
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--dark-color);
        letter-spacing: 0.5px;
    }

    /* Heading for the form (remains unchanged from last edit) */
    .form-heading {
        font-size: 2.1rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: var(--dark-color);
        text-align: left;
    }

    /* Input group for labels and inputs (remains unchanged from last edit) */
    .input-group {
        margin-bottom: 1.8rem;
    }

    .input-label {
        display: block;
        font-size: 0.85rem;
        color: var(--text-grey);
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .form-input {
        width: 100%;
        padding: 1rem 1rem;
        font-size: 1rem;
        border: 1px solid var(--input-border-default);
        border-radius: 6px;
        color: var(--input-text-color);
        transition: var(--transition);
        outline: none;
    }

    .form-input:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.2);
    }

    /* Button and link group (only button colors updated) */
    .button-group {
        margin-top: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .action-button {
        width: 100%;
        padding: 1.1rem 1.5rem;
        font-size: 1rem;
        font-weight: 600;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: var(--transition);
        background-color: var(--button-primary-bg); /* Uses updated variable */
        color: var(--text-light);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 1.2rem;
    }

    .action-button:hover {
        background-color: var(--button-primary-hover); /* Uses updated variable */
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }

    .action-button:active {
        transform: translateY(1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Back to Login link (remains unchanged from last edit) */
    .back-to-login {
        display: block;
        text-align: center;
        width: 100%;
    }

    .back-to-login a {
        color: var(--link-color);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .back-to-login a:hover {
        text-decoration: underline;
    }

    /* Status messages for Laravel Blade (remains unchanged from last edit) */
    .status-message {
        font-size: 0.85rem;
        margin-top: 1.5rem;
        text-align: center;
        padding: 0.7rem;
        border-radius: 5px;
    }

    .status-message.error {
        color: var(--error-color);
        background-color: var(--error-bg-transparent);
        border: 1px solid var(--error-color);
    }

    .status-message.success {
        color: var(--success-color);
        background-color: var(--success-bg-transparent);
        border: 1px solid var(--success-color);
    }

    /* Responsive Design for smaller screens (remains unchanged from last edit) */
    @media (max-width: 768px) {
        .forgot-password-container {
            max-width: 90%; /* Allow container to be wider on small screens */
            padding: 2.5rem 1.5rem; /* Reduce padding for smaller screens */
            box-shadow: 0 0 20px rgba(0,0,0,0.15); /* Slightly less intense shadow */
        }

        .container-logo {
            position: static; /* Position normally within flow */
            margin-bottom: 1.5rem; /* Add spacing below it */
            text-align: center; /* Center the logo text */
            width: 100%;
            top: auto;
            right: auto;
            font-size: 1.1rem; /* Slightly smaller font */
        }

        .form-heading {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .action-button {
            margin-bottom: 1rem;
        }
    }
</style>
<body>
    <div class="forgot-password-container">

        <h2 class="form-heading">Forgot Password?</h2>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="input-group">
                <label for="email" class="input-label">Email address</label>
                <input type="email" id="email" name="email" placeholder="yourname@example.com" class="form-input" required autofocus>
                @error('email')
                    <div class="status-message error">{{ $message }}</div>
                @enderror
            </div>
            <div class="button-group">
                <button type="submit" class="action-button">Send OTP</button>
            </div>
        </form>

        @if (session('status'))
            <div class="status-message success">{{ session('status') }}</div>
        @endif

        <div class="back-to-login">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </div>
</body>
</html>
