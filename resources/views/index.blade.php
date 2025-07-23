<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYA Trucking Services Login</title>
         <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="{{ asset('public/images/logo.jpg') }}" type="image/jpg">
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
    font-family: 'Poppins';
}

html, body {
    height: 100%;
    width: 100%;
    overflow: hidden; /* Keep overflow hidden for desktop layout */
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

    /* --- Combined Background Layers for Diamond Pattern with Outline Trucks --- */
    /* This background is for the *panel itself*, behind everything else */
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

/* Truck background image (kept separate for blending) - this is the *very subtle* one */
.left-panel-background-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    opacity: 0.05; /* Made even more subtle to avoid conflict */
    z-index: 0;
    background-image: url('/images/sya2.png'); /* This one is for the overall panel BG */
}


.left-panel-content {
    /* THIS IS THE MAIN IMAGE BEHIND THE TEXT */
    background-image: url('/images/sya2.png');
    background-repeat: no-repeat;
    background-position: center top; /* Center horizontally, top vertically */
    background-size: 80%; /* Start with 80% for desktop */
    position: relative;
    z-index: 1; /* Ensure content is above the subtle panel background */
    padding-top: 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center; /* Center content vertically */
    height: 100%;
    text-align: center;
}


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
    margin-top: 20%; /* Adjusted for desktop view to position text relative to image */
    line-height: 1.1;
    text-align: center;
    width: 100%;
    align-self: center;
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
    position: relative;
    z-index: 1;
    text-align: center;
    padding-bottom: 1rem;
}

/* Right Section - White Panel (Login Form) */
.right-panel {
    flex: 0 0 50%;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
   /* background-image: url('/public/images/sya3.png');*/ /* Keep this commented or remove if not used */

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
    margin: auto;
}

.welcome-heading {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 1rem;
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
    /* For screens between 992px and 769px, keep the horizontal layout
       Adjust fonts and padding for a better fit on smaller laptops/large tablets */

    .left-panel, .right-panel {
        padding: 3rem 2rem; /* Slightly reduced padding from desktop default */
    }

    .left-panel-background-image {
        opacity: 0.05; /* Maintain subtlety */
    }

    .left-panel-content {
        background-size: 90%; /* Slightly larger for better visibility */
        background-position: center 0; /* Adjust position to prevent top cut-off, or try 'top' */
    }

    .left-panel-heading {
        font-size: 3rem; /* Smaller heading */
        margin-top: 25%; /* Adjusted for this range */
    }

    .wave-emoji {
        font-size: 3rem; /* Smaller emoji */
    }

    .left-panel-subtext {
        font-size: 1rem; /* Slightly smaller subtext */
        padding-bottom: 1.5rem; /* Reduced bottom padding */
    }

    .right-panel-logo {
        top: 2rem; /* Adjust logo position */
        right: 2rem; /* Adjust logo position */
        font-size: 1.2rem; /* Slightly smaller logo text */
    }

    .login-form-container {
        max-width: 340px; /* Slightly smaller max-width for the form */
    }

    .welcome-heading {
        font-size: 1.6rem; /* Smaller welcome heading */
    }

    .login-input {
        padding: 0.9rem 0.9rem; /* Slightly smaller input padding */
        font-size: 0.95rem; /* Slightly smaller input font */
    }

    .login-button {
        padding: 1rem 1.2rem; /* Slightly smaller button padding */
        font-size: 0.95rem; /* Slightly smaller button font */
    }

    .input-group {
        margin-bottom: 1.5rem; /* Reduced margin */
    }

    div[style*="display: flex; align-items: center; margin-bottom: 1.5rem; justify-content: flex-start;"] {
        /* No change needed here, it stays flex-start for side-by-side */
    }
}

@media (max-width: 768px) {
    /* At 768px and below, switch to vertical layout */
    html, body {
        overflow-y: auto; /* Allow scrolling on smaller screens */
    }

    .login-wrapper {
        flex-direction: column; /* This is the key change for vertical layout */
        height: auto; /* Allow height to adjust based on content */
        min-height: 100vh;
        box-shadow: none;
        overflow-y: auto; /* IMPORTANT for mobile to allow scrolling the whole login page */
    }

    .left-panel, .right-panel {
        flex: none; /* Reset flex-grow/shrink */
        width: 100%; /* Take full width */
        padding: 2rem 1.5rem; /* Consistent padding */
        border-radius: 0;
    }

    .left-panel {
        height: 40vh; /* Reduced height to give more space to the right panel */
        min-height: 250px; /* Ensure a minimum height */
        justify-content: flex-start; /* Align content to the top */
        padding-bottom: 1.5rem;
        text-align: center; /* Center the text content */

        /* Responsive background adjustments for the pattern */
        background-size:
            150px 150px, /* Smaller truck tile for mobile */
            80px 80px, /* Smaller diamond tile for mobile */
            80px 80px;
        background-position:
            30px 30px, /* Adjust truck offset for mobile */
            0 0, 40px 40px; /* Adjust diamond position for mobile */
    }

    .left-panel-background-image {
        opacity: 0.05; /* Even more subtle background */
    }

    .left-panel-content {
        padding-top: 0;
        height: auto; /* Let content dictate height, flex will center */
        justify-content: center; /* Center text and elements vertically */
        padding-left: 1rem;
        padding-right: 1rem;
        
        /* ADJUSTMENT HERE for the main image */
        background-size: contain; /* Ensure the whole image is always visible */
        background-position: center; /* Center it horizontally and vertically */
    }

    .left-panel-greeting {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .left-panel-heading {
        font-size: 2.2rem;
        margin-top: 0; /* No top margin, let flexbox handle positioning */
        margin-bottom: 0.8rem;
        padding: 0 0.5rem;
    }
    
    .wave-emoji {
        font-size: 2.2rem;
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
        min-height: 60vh; /* Adequate height for the form */
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

    .input-label {
        text-align: left;
    }

    .forgot-password {
        text-align: center;
    }

    .login-button {
        margin-bottom: 1rem;
    }

    div[style*="display: flex; align-items: center; margin-bottom: 1.5rem; justify-content: flex-start;"] {
        justify-content: center !important;
    }
}

@media (max-width: 480px) {
    .left-panel {
        height: 35vh;
        min-height: 180px;
        padding: 1.5rem 1rem;
    }

    .left-panel-content {
        /* ADJUSTMENT HERE for the main image */
        background-size: contain; /* Ensure the whole image is always visible */
        background-position: center; /* Center it horizontally and vertically */
    }

    .left-panel-heading {
        font-size: 1.8rem;
        margin-top: 0; /* Consistent with 768px */
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
        min-height: 65vh; /* Adjusted for very small screens */
        padding: 1.5rem 1rem;
    }

    .right-panel-logo {
        font-size: 1.1rem;
    }

    .welcome-heading {
        font-size: 1.4rem;
        margin-bottom: 1rem;
    }

    .input-label,
    .login-input {
        font-size: 0.85rem;
        padding: 0.9rem;
    }

    .input-group {
        margin-bottom: 1.2rem;
    }

    .login-button {
        font-size: 0.9rem;
        padding: 0.9rem;
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
                <h2 class="welcome-heading">Let’s get back to work!

</h2>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="input-group">
                        <label for="username" class="input-label">Username</label>
                        <input type="text" id="username" name="username" placeholder="username" class="login-input" required>
                    </div>

                    <div class="input-group password-input-group">
                        <label for="password-field" class="input-label">Password</label>
                        <input type="password" id="password-field" name="password" placeholder="••••••••" class="login-input" required>
                        <i class="fas fa-eye password-toggle" id="toggle-password"></i>
                    </div>

                        <div style="display: flex; align-items: center; margin-bottom: 1.5rem; justify-content: flex-start;">
                        <input type="checkbox" id="remember" name="remember" style="margin-right: 0.5rem; accent-color: var(--button-primary-bg); width: 16px; height: 16px; cursor: pointer;">
                        <label for="remember" class="input-label" style="margin-bottom: 0; cursor: pointer;">Remember me</label>
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

      // Remember me functionality - save username to localStorage
      const rememberCheckbox = document.getElementById('remember');
      const usernameInput = document.querySelector('input[name="username"]');

      // Check if username was saved
      const savedUsername = localStorage.getItem('rememberedUsername');
      if (savedUsername) {
        usernameInput.value = savedUsername;
        rememberCheckbox.checked = true;
      }

      // Save username when form is submitted if remember me is checked
      document.querySelector('.login-form').addEventListener('submit', function() {
        if (rememberCheckbox.checked) {
          localStorage.setItem('rememberedUsername', usernameInput.value);
        } else {
          localStorage.removeItem('rememberedUsername');
        }
      });
    </script>
</body>
</html>
