<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trucking Services Login</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Add favicon (optional) -->
  <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
</head>
<style>
  :root {
    --primary-color: #2f4156;
    --secondary-color: #004aad;
    --accent-color: #004aad;
    --light-color: #f8f9fa;
    --dark-color: #212529;
    --text-light: #ffffff;
    --text-muted: #adb5bd;
    --shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  }

  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, var(--primary-color) 0%, #1a2634 100%);
    height: 100vh;
    display: flex;
    overflow: hidden;
    color: var(--text-light);
  }

  /* Left Section - Carousel */
  .left-section {
    width: 50%;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 2rem;
  }

  .logo-container {
    position: absolute;
    top: 2rem;
    left: 2rem;
    z-index: 10;
  }

  .logo {
    height: 60px;
    width: auto;
  }

  .carousel-container {
    width: 100%;
    max-width: 800px;
    height: 80%;
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--shadow);
  }

  .carousel {
    width: 100%;
    height: 100%;
    position: relative;
  }

  .carousel-inner {
    width: 100%;
    height: 100%;
    position: relative;
    overflow: hidden;
    border-radius: 15px;
  }

  .carousel-item {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    transition: opacity 1.2s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .carousel-item.active {
    opacity: 1;
  }

  .carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    filter: brightness(0.8);
  }

  .carousel-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 2rem;
    background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
    color: white;
    text-align: center;
    z-index: 2;
  }

  .carousel-caption {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    margin-bottom: 1rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
  }

  .carousel-controls {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 12px;
    z-index: 5;
  }

  .carousel-control {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.5);
    cursor: pointer;
    border: none;
    padding: 0;
    transition: var(--transition);
  }

  .carousel-control.active {
    background-color: var(--accent-color);
    transform: scale(1.3);
    box-shadow: 0 0 10px rgba(0, 74, 173, 0.7);
  }

  /* Right Section - Login Form */
  .right-section {
    width: 50%;
    background: linear-gradient(135deg, var(--primary-color) 0%, #1a2634 100%);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 4rem;
    position: relative;
  }

  .login-container {
    max-width: 450px;
    width: 100%;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    padding: 3rem;
    border-radius: 15px;
    box-shadow: var(--shadow);
    text-align: center;
  }

  .header {
    margin-bottom: 2.5rem;
  }

  .header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    font-weight: 600;
    color: var(--text-light);
    margin-bottom: 0.5rem;
    line-height: 1.2;
  }

  .header span {
    color: var(--text-light); /* Changed to white */
    font-style: italic;
  }

  .header p {
    color: var(--text-muted);
    font-size: 0.9rem;
    margin-top: 0.5rem;
  }

  .login-form {
    display: flex;
    flex-direction: column;
    gap: 1.8rem;
  }

  .input-group {
    position: relative;
  }

  .input-field {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    font-size: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    transition: var(--transition);
    background-color: rgba(0, 0, 0, 0.2);
    color: var(--text-light);
  }

  .input-field::placeholder {
    color: var(--text-muted);
  }

  .input-field:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: 0 0 0 2px rgba(0, 74, 173, 0.2);
  }

  .input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
  }

  .password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    cursor: pointer;
    transition: var(--transition);
  }

  .password-toggle:hover {
    color: var(--accent-color);
  }

  .login-button {
    padding: 1rem;
    background: linear-gradient(to right, var(--accent-color), #0066cc);
    color: var(--text-light);
    font-size: 1rem;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 4px 15px rgba(0, 74, 173, 0.3);
    margin-top: 1rem;
    letter-spacing: 0.5px;
  }

  .login-button:hover {
    background: linear-gradient(to right, #0066cc, var(--accent-color));
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 74, 173, 0.4);
  }

  .login-button:active {
    transform: translateY(0);
  }

  .forgot-password {
    margin-top: 1.5rem;
    text-align: center;
  }

  .forgot-password a {
    color: var(--accent-color);
    text-decoration: none;
    font-size: 0.9rem;
    transition: var(--transition);
  }

  .forgot-password a:hover {
    text-decoration: underline;
  }

  .error-message {
    color: #ff6b6b;
    font-size: 0.9rem;
    margin-top: 1rem;
    text-align: center;
  }

  .footer {
    position: absolute;
    bottom: 1.5rem;
    width: 100%;
    text-align: center;
    color: var(--text-muted);
    font-size: 0.8rem;
    opacity: 0.8;
  }

  /* Decorative Elements */
  .decorative-circle {
    position: absolute;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(0,74,173,0.1) 0%, rgba(0,74,173,0) 70%);
    z-index: -1;
  }

  .circle-1 {
    width: 400px;
    height: 400px;
    top: -150px;
    right: -150px;
  }

  .circle-2 {
    width: 300px;
    height: 300px;
    bottom: -100px;
    left: -100px;
  }

  /* Media Query for Mobile Devices */
  @media (max-width: 768px) {
    body {
      flex-direction: column;
      height: auto;
      overflow-y: auto;
    }

    .left-section,
    .right-section {
      width: 100%;
      padding: 1.5rem;
    }

    .left-section {
      height: 40vh;
    }

    .right-section {
      height: 60vh;
    }

    .carousel-container {
      height: 100%;
    }

    .login-container {
      padding: 2rem;
      backdrop-filter: none;
      -webkit-backdrop-filter: none;
      background: rgba(47, 65, 86, 0.95);
    }

    .header h1 {
      font-size: 2rem;
    }

    .input-field {
      padding: 0.9rem 0.9rem 0.9rem 2.8rem;
    }

    .input-icon {
      left: 0.9rem;
    }

    .decorative-circle {
      display: none;
    }
  }

  /* Animation */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .login-container {
    animation: fadeIn 0.8s ease-out forwards;
  }

  @keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
    100% { transform: translateY(0px); }
  }

  .floating {
    animation: float 8s ease-in-out infinite;
  }

  /* Smooth transition for carousel */
  .carousel-item {
    will-change: opacity;
  }
</style>
<body>
  <!-- Left Section with Carousel -->
  <div class="left-section">
    <div class="logo-container">
      <!-- Optional: Add your logo here -->
      <!-- <img src="{{ asset('images/logo.png') }}" alt="SYA Trucking Logo" class="logo"> -->
    </div>
    
    <div class="carousel-container floating">
      <div class="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="{{ asset('images/truck4.jpg') }}" alt="Truck Image 1">
            <div class="carousel-overlay">
              <div class="carousel-caption">Premium Trucking Services</div>
            </div>
          </div>
          <div class="carousel-item">
            <img src="{{ asset('images/truck3.jpg') }}" alt="Truck Image 2">
            <div class="carousel-overlay">
              <div class="carousel-caption">Reliable Transportation Solutions</div>
            </div>
          </div>
          <div class="carousel-item">
            <img src="{{ asset('images/truck2.jpg') }}" alt="Truck Image 3">
            <div class="carousel-overlay">
              <div class="carousel-caption">Nationwide Coverage</div>
            </div>
          </div>
        </div>
        <div class="carousel-controls">
          <button class="carousel-control active" data-index="0"></button>
          <button class="carousel-control" data-index="1"></button>
          <button class="carousel-control" data-index="2"></button>
        </div>
      </div>
    </div>
    <div class="decorative-circle circle-1"></div>
    <div class="decorative-circle circle-2"></div>
  </div>

  <!-- Right Section with Login Form -->
  <div class="right-section">
    <div class="login-container">
      <div class="header">
        <h1><span>SYA</span> Trucking Services</h1>
        <p>Since 2020</p>
      </div>

      <!-- Login Form -->
      <form method="POST" action="{{ route('login.post') }}" class="login-form">
        @csrf
        <div class="input-group">
          <i class="fas fa-user input-icon"></i>
          <input type="text" name="username" placeholder="Username" class="input-field" required>
        </div>
        
        <div class="input-group">
          <i class="fas fa-lock input-icon"></i>
          <input type="password" name="password" id="password-field" placeholder="Password" class="input-field" required>
          <i class="fas fa-eye password-toggle" id="toggle-password"></i>
        </div>
        
        <button type="submit" class="login-button">LOGIN</button>
        
        <div class="forgot-password">
          <a href="{{ route('password.request') }}">Forgot Password?</a>
        </div>
      </form>

      <!-- Error Display -->
      @if($errors->has('login_error'))
        <div class="error-message">{{ $errors->first('login_error') }}</div>
      @endif
    </div>

    <div class="footer">
      &copy; 2023 SYA Trucking Services. All rights reserved.
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Enhanced Carousel functionality
      const items = document.querySelectorAll('.carousel-item');
      const controls = document.querySelectorAll('.carousel-control');
      let currentIndex = 0;
      const intervalTime = 5000;
      let carouselInterval;
      let isHovering = false;

      function showItem(index) {
        items.forEach(item => item.classList.remove('active'));
        controls.forEach(control => control.classList.remove('active'));
        
        items[index].classList.add('active');
        controls[index].classList.add('active');
        currentIndex = index;
      }

      function nextItem() {
        const nextIndex = (currentIndex + 1) % items.length;
        showItem(nextIndex);
      }

      function startCarousel() {
        if (!isHovering) {
          carouselInterval = setInterval(nextItem, intervalTime);
        }
      }

      function resetInterval() {
        clearInterval(carouselInterval);
        startCarousel();
      }

      // Initialize
      showItem(0);
      startCarousel();

      // Control click handlers
      controls.forEach(control => {
        control.addEventListener('click', function() {
          const index = parseInt(this.getAttribute('data-index'));
          showItem(index);
          resetInterval();
        });
      });

      // Pause on hover
      const carousel = document.querySelector('.carousel');
      carousel.addEventListener('mouseenter', () => {
        isHovering = true;
        clearInterval(carouselInterval);
      });
      
      carousel.addEventListener('mouseleave', () => {
        isHovering = false;
        resetInterval();
      });

      // Show/hide password functionality
      const togglePassword = document.querySelector('#toggle-password');
      const passwordField = document.querySelector('#password-field');

      togglePassword.addEventListener('click', function() {
        // Toggle the type attribute
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        
        // Toggle the eye icon
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });

      // Add floating animation to elements
      if (window.innerWidth > 768) {
        document.querySelector('.login-container').classList.add('floating');
      }
    });

    // Responsive adjustments
    window.addEventListener('resize', function() {
      if (window.innerWidth <= 768) {
        document.querySelector('.login-container').classList.remove('floating');
      } else {
        document.querySelector('.login-container').classList.add('floating');
      }
    });
  </script>
</body>
</html>