<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYA Trucking Services Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css">
    <link rel="icon" href="{{ asset('public/images/logo.jpg') }}" type="image/jpg">
</head>
<style>
/*=============== VARIABLES CSS ===============*/
:root {
    /* Original SYA Colors */
    --primary-color: #2f4156;
    --secondary-color: #004aad;
    --accent-color: #004aad;
    --light-color: #f8f9fa;
    --dark-color: #212529;
    --text-light: #ffffff;
    --text-muted: #adb5bd;
    --shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);

    /* Modern Login Colors (matching tutorial style) */
    --first-color: #004aad;
    --first-color-alt: #2f4156;
    --title-color: #212529;
    --white-color: #ffffff;
    --text-color: #6c757d;
    --body-color: #f8f9fa;
    --container-color: #ffffff;

    /* Specific colors for panels */
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

    /*========== Font and typography ==========*/
    --body-font: "Montserrat", system-ui;
    --big-font-size: 1.5rem;
    --normal-font-size: .938rem;
    --small-font-size: .813rem;
    --tiny-font-size: .688rem;

    /*========== Font weight ==========*/
    --font-regular: 400;
    --font-medium: 500;
    --font-semi-bold: 600;

    /*========== z index ==========*/
    --z-tooltip: 10;
    --z-fixed: 100;
}

/*========== Responsive typography ==========*/
@media screen and (min-width: 1150px) {
    :root {
        --big-font-size: 3rem;
        --normal-font-size: 1rem;
        --small-font-size: .875rem;
        --tiny-font-size: .75rem;
    }
}

/*=============== BASE ===============*/
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body,
input,
button {
    font-family: var(--body-font);
    font-size: var(--normal-font-size);
}

html, body {
    height: 100%;
    width: 100%;
    overflow: hidden;
    background-color: var(--body-color);
    color: var(--text-color);
}

input,
button {
    border: none;
    outline: none;
}

a {
    text-decoration: none;
}

img {
    display: block;
    max-width: 100%;
    height: auto;
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
    position: relative;
    overflow: hidden;
    background-size:
        200px 200px,
        100px 100px,
        100px 100px;
    background-position:
        50px 50px,
        0 0, 50px 50px;
    background-repeat: repeat;
}

.left-panel::before {
    content: none;
}

.left-panel-background-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    opacity: 0.05;
    z-index: 0;
    background-image: url('/images/sya2.png');
}

.left-panel-content {
    background-image: url('/images/sya2.png');
    background-repeat: no-repeat;
    background-position: center top;
    background-size: 80%;
    position: relative;
    z-index: 1;
    padding-top: 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    text-align: center;
}

.left-panel-greeting {
    font-size: 1.2rem;
    font-weight: var(--font-medium);
    margin-bottom: 0.8rem;
    opacity: 0.9;
    color: rgba(255, 255, 255, 0.9);
}

.left-panel-heading {
    font-size: var(--big-font-size);
    font-weight: 700;
    margin-bottom: 1rem;
    margin-top: 20%;
    line-height: 1.1;
    text-align: center;
    width: 100%;
    align-self: center;
    color: var(--white-color);
}

.wave-emoji {
    font-size: var(--big-font-size);
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
    color: rgba(255, 255, 255, 0.9);
}

.left-panel-footer {
    font-size: var(--small-font-size);
    opacity: 0.7;
    position: relative;
    z-index: 1;
    text-align: center;
    padding-bottom: 1rem;
    color: rgba(255, 255, 255, 0.7);
}

/* Right Section - Modern Login Form */
.right-panel {
    flex: 0 0 50%;
    background: linear-gradient(135deg, var(--container-color) 0%, var(--light-color) 100%);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 4rem 3rem;
    color: var(--dark-color);
    position: relative;
    overflow: hidden;
}

.right-panel::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 20%, rgba(0, 74, 173, 0.03) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(47, 65, 86, 0.02) 0%, transparent 50%),
        linear-gradient(135deg, transparent 0%, rgba(0, 74, 173, 0.01) 50%, transparent 100%);
    z-index: 0;
}

.right-panel-logo {
    position: absolute;
    top: 2.5rem;
    right: 3rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.3rem;
    font-weight: var(--font-semi-bold);
    color: var(--title-color);
    letter-spacing: 0.5px;
    z-index: 2;
}

.login-form-container {
    width: 100%;
    max-width: 360px;
    text-align: left;
    margin: auto;
    position: relative;
    z-index: 2;
}

.welcome-heading {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 2rem;
    color: var(--title-color);
    text-align: left;
}

/* Modern Animated Input Groups */
.input-group {
    margin-bottom: 1.8rem;
}

.login__box {
    position: relative;
    display: flex;
    align-items: center;
    background-color: var(--container-color);
    border-radius: 1rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
}

.login-input {
    background: none;
    width: 100%;
    padding: 1.5rem 2.5rem 1.5rem 1.25rem;
    font-weight: var(--font-semi-bold);
    border: 3px solid transparent;
    border-radius: 1rem;
    z-index: 1;
    transition: border-color .4s;
    color: var(--title-color);
    font-size: var(--normal-font-size);
}

.login-input:autofill {
    transition: background-color 6000s, color 6000s;
}

.input-label {
    position: absolute;
    left: 1.25rem;
    font-weight: var(--font-semi-bold);
    transition: transform .4s, font-size .4s, color .4s;
    color: var(--text-color);
    pointer-events: none;
}

/* Password input group styling */
.password-input-group {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 1rem;
    font-size: 1.25rem;
    transition: color .4s;
    color: var(--text-color);
    cursor: pointer;
    z-index: 10;
}

.password-toggle:hover {
    color: var(--first-color);
}

/* Input focus move up label */
.login-input:focus ~ .input-label {
    transform: translateY(-12px);
    font-size: var(--tiny-font-size);
}

.login-input:focus {
    padding-block: 2rem 1rem;
}

/* Input focus sticky top label */
.login-input:not(:placeholder-shown).login-input:not(:focus) ~ .input-label {
    transform: translateY(-12px);
    font-size: var(--tiny-font-size);
}

.login-input:not(:placeholder-shown).login-input:not(:focus) {
    padding-block: 2rem 1rem;
}

/* Input focus color */
.login-input:focus {
    border-color: var(--first-color);
}

.login-input:focus ~ .input-label,
.login-input:focus ~ .password-toggle {
    color: var(--first-color);
}

/* Remember me checkbox styling */
.remember-group {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    justify-content: flex-start;
}

.remember-group input[type="checkbox"] {
    margin-right: 0.5rem;
    accent-color: var(--first-color);
    width: 16px;
    height: 16px;
    cursor: pointer;
}

.remember-group label {
    margin-bottom: 0;
    cursor: pointer;
    font-size: var(--small-font-size);
    font-weight: var(--font-medium);
    color: var(--text-color);
}

.button-group {
    margin-top: 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.login-button {
    width: 100%;
    display: inline-flex;
    justify-content: center;
    background-color: var(--first-color);
    color: var(--white-color);
    font-weight: var(--font-semi-bold);
    padding-block: 1.5rem;
    border-radius: 4rem;
    margin-block: 1rem;
    cursor: pointer;
    transition: background-color .4s, box-shadow .4s, transform .4s;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    overflow: hidden;
}

.login-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: all 0.6s;
}

.login-button:hover::before {
    left: 100%;
}

.login-button:hover {
    background-color: var(--first-color-alt);
    box-shadow: 0 8px 24px hsla(208, 92%, 32%, .3);
    transform: translateY(-2px);
}

.login-button:active {
    transform: translateY(0);
}

.forgot-password {
    display: block;
    text-align: center;
    width: 100%;
}

.forgot-password a {
    color: var(--first-color);
    text-decoration: none;
    font-size: var(--small-font-size);
    font-weight: var(--font-semi-bold);
    transition: color .4s;
}

.forgot-password a:hover {
    color: var(--first-color-alt);
    text-decoration: underline;
}

.error-message {
    color: var(--error-color);
    font-size: var(--small-font-size);
    margin-top: 1.5rem;
    text-align: center;
    background-color: var(--error-bg-transparent);
    padding: 0.7rem;
    border-radius: 5px;
    border: 1px solid var(--error-color);
}

/* Responsive Design */
@media (max-width: 992px) {
    .left-panel, .right-panel {
        padding: 3rem 2rem;
    }

    .left-panel-background-image {
        opacity: 0.05;
    }

    .left-panel-content {
        background-size: 90%;
        background-position: center 0;
    }

    .left-panel-heading {
        margin-top: 25%;
    }

    .right-panel-logo {
        top: 2rem;
        right: 2rem;
        font-size: 1.2rem;
    }

    .login-form-container {
        max-width: 340px;
    }

    .welcome-heading {
        font-size: 1.6rem;
    }

    .login-input {
        padding: 1.3rem 2.2rem 1.3rem 1rem;
        font-size: 0.95rem;
    }

    .input-group {
        margin-bottom: 1.5rem;
    }
}

@media (max-width: 768px) {
    html, body {
        overflow-y: auto;
    }

    .login-wrapper {
        flex-direction: column;
        height: auto;
        min-height: 100vh;
        box-shadow: none;
        overflow-y: auto;
    }

    .left-panel, .right-panel {
        flex: none;
        width: 100%;
        padding: 2rem 1.5rem;
        border-radius: 0;
    }

    .left-panel {
        height: 40vh;
        min-height: 250px;
        justify-content: flex-start;
        padding-bottom: 1.5rem;
        text-align: center;
        background-size:
            150px 150px,
            80px 80px,
            80px 80px;
        background-position:
            30px 30px,
            0 0, 40px 40px;
    }

    .left-panel-background-image {
        opacity: 0.05;
    }

    .left-panel-content {
        padding-top: 0;
        height: auto;
        justify-content: center;
        padding-left: 1rem;
        padding-right: 1rem;
        background-size: contain;
        background-position: center;
    }

    .left-panel-greeting {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .left-panel-heading {
        font-size: 2.2rem;
        margin-top: 0;
        margin-bottom: 0.8rem;
        padding: 0 0.5rem;
    }

    .left-panel-subtext {
        font-size: 0.95rem;
        max-width: 100%;
        padding-bottom: 1.5rem;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    .left-panel-footer {
        padding-top: 1rem;
        font-size: 0.8rem;
        padding-bottom: 1rem;
    }

    .right-panel {
        min-height: 60vh;
        height: auto;
        padding: 2rem 1.5rem;
        background-image: none;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
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
        width: 100%;
        max-width: 380px;
        padding: 0 1rem;
        text-align: left;
    }

    .welcome-heading {
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .input-group {
        margin-bottom: 1.5rem;
    }

    .remember-group {
        justify-content: center !important;
    }

    .forgot-password {
        text-align: center;
    }

    .login-button {
        margin-bottom: 1rem;
    }
}

@media (max-width: 480px) {
    .left-panel {
        height: 35vh;
        min-height: 180px;
        padding: 1.5rem 1rem;
    }

    .left-panel-content {
        background-size: contain;
        background-position: center;
    }

    .left-panel-heading {
        font-size: 1.8rem;
        margin-top: 0;
        padding: 0 0.5rem;
    }

    .left-panel-subtext {
        font-size: 0.85rem;
        padding: 0 0.5rem 1rem;
    }

    .left-panel-footer {
        font-size: 0.75rem;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }

    .right-panel {
        min-height: 65vh;
        padding: 1.5rem 1rem;
    }

    .right-panel-logo {
        font-size: 1.1rem;
    }

    .welcome-heading {
        font-size: 1.4rem;
        margin-bottom: 1rem;
    }

    .login-input {
        padding: 1.2rem 2rem 1.2rem 1rem;
        font-size: 0.85rem;
    }

    .input-group {
        margin-bottom: 1.2rem;
    }

    .login-button {
        font-size: 0.9rem;
        padding-block: 1.2rem;
        margin-bottom: 0.8rem;
    }

    .forgot-password a {
        font-size: 0.8rem;
    }

    .error-message {
        font-size: 0.8rem;
        padding: 0.7rem;
    }
}
</style>
<body>
    <div class="login-wrapper">
        <div class="left-panel">
            <div class="left-panel-background-image"></div>

            <div class="left-panel-content">
                <h1 class="left-panel-heading">  <br></h1>
                <p class="left-panel-subtext">
                    SYA: Driving Our Collective Success.
                </p>
            </div>
            <div class="left-panel-footer">
                &copy; 2023 SYA Trucking Services. All rights reserved.
            </div>
        </div>

        <div class="right-panel">
            <div class="login-form-container">
                <h2 class="welcome-heading">Let's get back to work!</h2>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="input-group">
                        <div class="login__box">
                            <input type="text" id="username" name="username" placeholder=" " class="login-input" required>
                            <label for="username" class="input-label">Username</label>
                        </div>
                    </div>

                    <div class="input-group password-input-group">
                        <div class="login__box">
                            <input type="password" id="password-field" name="password" placeholder=" " class="login-input" required>
                            <label for="password-field" class="input-label">Password</label>
                            <i class="ri-eye-fill password-toggle" id="toggle-password"></i>
                        </div>
                    </div>

                    <div class="remember-group">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
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
            // Modern password toggle functionality (matching tutorial style)
            const passwordAccess = (loginPass, loginEye) => {
                const input = document.getElementById(loginPass),
                      iconEye = document.getElementById(loginEye)
                      
                iconEye.addEventListener('click', () => {
                    // Change password to text
                    input.type === 'password' ? input.type = 'text' : input.type = 'password'
                    
                    // Icon change
                    iconEye.classList.toggle('ri-eye-fill')
                    iconEye.classList.toggle('ri-eye-off-fill')
                })
            }
            passwordAccess('password-field','toggle-password')

            // Remember me functionality
            const rememberCheckbox = document.getElementById('remember');
            const usernameInput = document.querySelector('input[name="username"]');

            // Check if username was saved (only if localStorage is available)
            try {
                const savedUsername = localStorage.getItem('rememberedUsername');
                if (savedUsername) {
                    usernameInput.value = savedUsername;
                    rememberCheckbox.checked = true;
                }
            } catch (e) {
                // localStorage not available, skip this functionality
            }

            // Save username when form is submitted if remember me is checked
            document.querySelector('form').addEventListener('submit', function() {
                try {
                    if (rememberCheckbox.checked) {
                        localStorage.setItem('rememberedUsername', usernameInput.value);
                    } else {
                        localStorage.removeItem('rememberedUsername');
                    }
                } catch (e) {
                    // localStorage not available, skip this functionality
                }
            });
        });
    </script>
</body>
</html>