<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYA Trucking Services Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
</head>
<style>
    /* Original Theme Colors (and adapted for this design) */
    :root {
        --primary-color: #2f4156; /* Dark Blue-Grey (main left panel color) */
        --secondary-color: #004aad; /* Same as accent */
        --accent-color: #004aad; /* Medium Blue - Prominent */
        --light-color: #f8f9fa; /* Off-white */
        --dark-color: #212529; /* Near-black */
        --text-light: #ffffff; /* White text */
        --text-muted: #adb5bd; /* Muted light grey */
        --shadow: 0 4px 20px rgba(0, 0, 0, 0.15); /* Original shadow */
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);

        /* Specific colors for this 'SalesSkip' inspired design */
        --left-panel-bg: var(--primary-color);
        --right-panel-bg: #ffffff;
        --input-border-default: #e0e0e0;
        --input-text-color: #333333;
        --button-primary-bg: #004aad;
        --button-primary-hover: #365a8c;
        --link-color: var(--accent-color);
        --text-grey: #6c757d;
        --error-color: #dc3545;
        --error-bg-transparent: rgba(220, 53, 69, 0.08);
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    html, body {
        height: 100%;
        width: 100%;
        overflow: hidden;
    }

    .login-wrapper {
        display: flex;
        width: 100vw;
        height: 100vh;
        box-shadow: 0 0 30px rgba(0,0,0,0.2);
    }

    /* Left Section - Blue Panel */
    .left-panel {
        flex: 0 0 50%;
        background-color: var(--left-panel-bg);
        color: var(--text-light);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 4rem 3.5rem;
        position: relative;
        overflow: hidden;

        /* --- Combined Background Layers for Diamond Pattern with Outline Trucks --- */
        background-image:
            /* Layer 1: Subtle Outline Truck Pattern */
            url("data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2240%22%20viewBox%3D%220%200%2060%2040%22%20fill%3D%22none%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%0A%20%20%3Cpath%20d%3D%22M57%2028.5V10C57%209.44772%2056.5523%209%2056%209H43L47%2013V28.5H57ZM57%2028.5V32C57%2032.5523%2056.5523%2033%2056%2033H43L40%2035L37%2033H21C20.4477%2033%2020%2032.5523%2020%2032V28.5H57ZM27%2030.5C27.5523%2030.5%2028%2030.0523%2028%2029.5C28%2028.9477%2027.5523%2028.5%2027%2028.5C26.4477%2028.5%2026%2028.9477%2026%2029.5C26%2030.0523%2026.4477%2030.5%2027%2030.5ZM43%2030.5C43.5523%2030.5%2044%2030.0523%2044%2029.5C44%2028.9477%2043.5523%2028.5%2043%2028.5C42.4477%2028.5%2042%2028.9477%2042%2029.5C42%2030.0523%2042.4477%2030.5%2043%2030.5Z%22%20stroke%3D%22rgba(255%2C255%2C255%2C0.03)%22%20stroke-width%3D%222%22%2F%3E%0A%3C%2Fsvg%3E"),
            /* Layer 2: Subtle Diamond Outline Pattern */
            linear-gradient(45deg, rgba(255,255,255,0.02) 25%, transparent 25%),
            linear-gradient(-45deg, rgba(255,255,255,0.02) 25%, transparent 25%);

        background-size:
            200px 200px, /* Truck pattern tile size (larger for "every other" effect) */
            100px 100px, /* Diamond pattern tile size */
            100px 100px;
        background-position:
            50px 50px, /* Offset trucks to subtly align within the larger grid */
            0 0, 50px 50px; /* Positions for diamond grid to form properly */
        background-repeat: repeat;
        /* --- End of Combined Background Layers --- */
    }

    /* Remove the old ::before pattern if it was present */
    .left-panel::before {
        content: none;
    }

    /* Truck background image (kept separate for blending) */
    .left-panel-background-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0.15;
        z-index: 0;
    }

    .left-panel-content {
        position: relative; /* Bring content above pattern and image */
        z-index: 1;
        padding-top: 2rem; /* Add some top padding to content for better balance */
        display: flex;
        flex-direction: column;
        align-items: flex-start; /* Align contents to the left */
        justify-content: center;
        height: 100%; /* Make content take full height for vertical centering effect */
    }

    /* REMOVED: .truck-icon styles as the icon is now in the background */


    .left-panel-greeting {
        font-size: 1.2rem;
        font-weight: 500;
        margin-bottom: 0.8rem;
        opacity: 0.9;
        color: rgba(255, 255, 255, 0.9);
    }

    .left-panel-heading {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        line-height: 1.1;
    }

    .wave-emoji {
        font-size: 3.5rem;
        vertical-align: middle;
        margin-left: 10px;
        display: inline-block;
    }

    .left-panel-subtext {
        font-size: 1.1rem;
        line-height: 1.6;
        opacity: 0.9;
        max-width: 90%;
        padding-bottom: 2rem;
    }

    .left-panel-footer {
        font-size: 0.9rem;
        opacity: 0.7;
        position: relative; /* Bring footer above background images */
        z-index: 1;
    }

    /* Right Section - White Panel (Login Form) */
    .right-panel {
        flex: 0 0 50%;
        background-color: var(--right-panel-bg);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 4rem 3rem;
        color: var(--dark-color);
        position: relative;
    }

    .right-panel-logo {
        position: absolute;
        top: 2.5rem;
        right: 3rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--dark-color);
        letter-spacing: 0.5px;
    }

    .login-form-container {
        width: 100%;
        max-width: 360px;
        text-align: left;
    }

    .welcome-heading {
        font-size: 2.1rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: var(--dark-color);
        text-align: left;
    }

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

    .login-input {
        width: 100%;
        padding: 1rem 1rem;
        font-size: 1rem;
        border: 1px solid var(--input-border-default);
        border-radius: 6px;
        color: var(--input-text-color);
        transition: var(--transition);
        outline: none;
    }

    .login-input:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.2);
    }

    .password-input-group {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(calc(50% + 0.25rem));
        color: var(--text-muted);
        cursor: pointer;
        font-size: 1rem;
        transition: var(--transition);
    }

    .password-toggle:hover {
        color: var(--accent-color);
    }

    .button-group {
        margin-top: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .login-button {
        width: 100%;
        padding: 1.1rem 1.5rem;
        font-size: 1rem;
        font-weight: 600;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: var(--transition);
        background-color: var(--button-primary-bg);
        color: var(--text-light);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 1.2rem;
    }

    .login-button:hover {
        background-color: var(--button-primary-hover);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }

    .login-button:active {
        transform: translateY(1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .forgot-password {
        display: block;
        text-align: center;
        width: 100%;
    }

    .forgot-password a {
        color: var(--link-color);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .forgot-password a:hover {
        text-decoration: underline;
    }

    .error-message {
        color: var(--error-color);
        font-size: 0.85rem;
        margin-top: 1.5rem;
        text-align: center;
        background-color: var(--error-bg-transparent);
        padding: 0.7rem;
        border-radius: 5px;
        border: 1px solid var(--error-color);
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .login-wrapper {
            flex-direction: column;
            height: auto;
            min-height: 100vh;
            box-shadow: none;
        }

        .left-panel, .right-panel {
            flex: none;
            width: 100%;
            padding: 2.5rem 1.5rem;
            border-radius: 0;
        }

        .left-panel {
            height: 45vh;
            justify-content: flex-start;
            padding-bottom: 1.5rem;

            /* Responsive background adjustments */
            background-size:
                150px 150px, /* Smaller truck tile for mobile */
                80px 80px, /* Smaller diamond tile for mobile */
                80px 80px;
            background-position:
                30px 30px, /* Adjust truck offset for mobile */
                0 0, 40px 40px; /* Adjust diamond position for mobile */
        }

        .left-panel-background-image {
            opacity: 0.1; /* Even more subtle on mobile */
        }

        .left-panel-content {
            padding-top: 0;
        }

        /* REMOVED: .truck-icon styles as the icon is now in the background */

        .left-panel-greeting {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .left-panel-heading {
            font-size: 2.5rem;
            margin-bottom: 0.8rem;
        }

        .wave-emoji {
            font-size: 2.5rem;
        }

        .left-panel-subtext {
            font-size: 0.95rem;
            max-width: 100%;
            padding-bottom: 1.5rem;
        }

        .left-panel-footer {
            padding-top: 1rem;
            font-size: 0.8rem;
        }

        .right-panel {
            min-height: 55vh;
            padding: 2.5rem 1.5rem;
        }

        .right-panel-logo {
            position: static;
            margin-bottom: 1.5rem;
            text-align: center;
            width: 100%;
            top: auto;
            right: auto;
        }

        .login-form-container {
            max-width: 100%;
            text-align: center;
        }

        .welcome-heading {
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-label {
            text-align: left;
        }

        .forgot-password {
            text-align: center;
        }

        .login-button {
            margin-bottom: 1rem;
        }
    }
</style>
<body>
    <div class="login-wrapper">
        <div class="left-panel">
            <div class="left-panel-background-image"></div>

            <div class="left-panel-content">
                <p class="left-panel-greeting">Hello, SYA Team!</p>
                <h1 class="left-panel-heading">Less paperwork. <br>More control. <span class="wave-emoji">&#128075;</span></h1>
                <p class="left-panel-subtext">
                    Stay organized and efficient with SYA Trucking Services all-in-one system.
                    Simplify records, improve coordination, and keep everything moving.
                </p>
            </div>
            <div class="left-panel-footer">
                &copy; 2023 SYA Trucking Services. All rights reserved.
            </div>
        </div>

        <div class="right-panel">
            <span class="right-panel-logo">SYA Trucking Services</span>

            <div class="login-form-container">
                <h2 class="welcome-heading">Welcome Back!</h2>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="input-group">
                        <label for="username" class="input-label">Email address</label>
                        <input type="text" id="username" name="username" placeholder="yourname@example.com" class="login-input" required>
                    </div>

                    <div class="input-group password-input-group">
                        <label for="password-field" class="input-label">Password</label>
                        <input type="password" id="password-field" name="password" placeholder="••••••••" class="login-input" required>
                        <i class="fas fa-eye password-toggle" id="toggle-password"></i>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="login-button">Login Now</button>
                        <div class="forgot-password">
                            <a href="{{ route('password.request') }}">Forgot password?</a>
                        </div>
                    </div>
                </form>

                @if($errors->has('login_error'))
                    <div class="error-message">{{ $errors->first('login_error') }}</div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show/hide password functionality
            const togglePassword = document.querySelector('#toggle-password');
            const passwordField = document.querySelector('#password-field');

            togglePassword.addEventListener('click', function() {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>
</html>
