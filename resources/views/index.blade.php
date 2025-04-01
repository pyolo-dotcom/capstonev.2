<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trucking Services Login</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Add favicon (optional) -->
  <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpg">
</head>
<style>
  body {
    margin: 0;
    font-family: 'Playfair Display', sans-serif;
    background-color: #f4f4f4;
    height: 100vh;
    width: 100%;
    display: flex;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 10px;
    overflow: hidden;
  }

  .left-section {
    width: 50%;
    background-color: #2f4156;
    color: white;
    position: relative;
    overflow: hidden;
  }

  .carousel {
    width: 100%;
    height: 80%;
    position: relative;
    margin-top: 40px;
  }

  .carousel-inner {
    width: 100%;
    height: 100%;
    position: relative;
    overflow: hidden;
    border-top-right-radius: 20%;
    border-bottom-right-radius: 20%;
  }

  .carousel-item {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    transition: opacity 1s ease-in-out;
  }

  .carousel-item.active {
    opacity: 1;
  }

  .carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .carousel-controls {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 10px;
  }

  .carousel-control {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.5);
    cursor: pointer;
    border: none;
    padding: 0;
  }

  .carousel-control.active {
    background-color: white;
  }

  .right-section {
    width: 50%;
    background-color: #2f4156;
    color: white;
    padding: 20px;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center; /* centers vertically */
    align-items: center;     /* centers horizontally */
  }

  .header {
    text-align: center;
    margin-bottom: 30px;
  }

  .header h1 {
    margin: 0;
    font-size: 35px;
    line-height: 1.2;
  }

  .header span {
    font-weight: bold;
  }

  .header p {
    margin: 5px 0 20px;
    font-size: 14px;
    font-style: italic;
  }

  .login-form {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .input-field {
    width: 80%;
    padding: 10px;
    padding-left: 15px;
    font-size: 25px;
    margin: 10px 0;
    border: none;
    border-radius: 25px;
  }

  .login-button {
    padding: 20px;
    margin-top: 5px;
    border: none;
    background-color: #004aad;
    color: white;
    font-size: 18px;
    border-radius: 35px;
    cursor: pointer;
    margin-right: 54%;
  }

  .login-button:hover {
    background-color: #365a8c;
  }

  /* Media Query for Mobile Devices */
  @media (max-width: 768px) {
    body {
      flex-direction: column; /* Stack sections vertically */
      height: auto; /* Adjust height for mobile */
    }

    .left-section,
    .right-section {
      width: 100%; /* Full width for mobile */
      padding: 10px; /* Reduce padding for mobile */
    }

    .carousel {
      height: 300px; /* Fixed height for mobile */
      margin-top: 20px; /* Reduce margin for mobile */
    }

    .carousel-inner {
      border-radius: 10px; /* Adjust border radius for mobile */
    }

    .header h1 {
      font-size: 28px; /* Smaller font for mobile */
    }

    .header p {
      font-size: 12px; /* Smaller font for mobile */
    }

    .input-field {
      font-size: 16px; /* Smaller font for mobile */
      width: 90%; /* Adjust width for mobile */
    }

    .login-button {
      font-size: 16px; /* Smaller font for mobile */
      width: 90%; /* Adjust width for mobile */
      margin-right: 0; /* Remove margin for mobile */
      padding: 15px; /* Adjust padding for mobile */
    }
  }
</style>
<body>
  <!-- Left Section with Carousel -->
  <div class="left-section">
    <div class="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="{{ asset('images/truck4.jpg') }}" alt="Truck Image 1">
        </div>
        <div class="carousel-item">
          <img src="{{ asset('images/truck3.jpg') }}" alt="Truck Image 2">
        </div>
        <div class="carousel-item">
          <img src="{{ asset('images/truck2.jpg') }}" alt="Truck Image 3">
        </div>
      </div>
      <div class="carousel-controls">
        <button class="carousel-control active" data-index="0"></button>
        <button class="carousel-control" data-index="1"></button>
        <button class="carousel-control" data-index="2"></button>
      </div>
    </div>
  </div>

  <!-- Right Section with Login Form -->
  <div class="right-section">
    <div class="header">
      <h1>The<br><span><i>SYA</i> Trucking Services</span></h1>
      <p>Since 2020</p>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login.post') }}" class="login-form">
      @csrf
      <input type="text" name="username" placeholder="username" class="input-field" required>
      <input type="password" name="password" placeholder="password" class="input-field" required>
      <button type="submit" class="login-button">LOGIN</button>
      <div style="text-align: center; margin-top: 15px;">
          <a href="{{ route('password.request') }}" style="color: #4da6ff; text-decoration: none;">Forgot Password?</a>
      </div>
    </form>

    <!-- Error Display -->
    @if($errors->has('login_error'))
      <p style="color: red; text-align: center;">{{ $errors->first('login_error') }}</p>
    @endif
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const items = document.querySelectorAll('.carousel-item');
      const controls = document.querySelectorAll('.carousel-control');
      let currentIndex = 0;
      const intervalTime = 3000; // 3 seconds
      let carouselInterval;

      function showItem(index) {
        items.forEach(item => item.classList.remove('active'));
        controls.forEach(control => control.classList.remove('active'));
        
        items[index].classList.add('active');
        controls[index].classList.add('active');
        currentIndex = index;
      }

      function nextItem() {
        const newIndex = (currentIndex + 1) % items.length;
        showItem(newIndex);
      }

      // Start auto-rotation
      function startCarousel() {
        carouselInterval = setInterval(nextItem, intervalTime);
      }

      // Add click event to controls
      controls.forEach(control => {
        control.addEventListener('click', function() {
          const index = parseInt(this.getAttribute('data-index'));
          showItem(index);
          // Reset timer when manually changing slide
          clearInterval(carouselInterval);
          startCarousel();
        });
      });

      // Start the carousel
      startCarousel();

      // Pause on hover (optional)
      const carousel = document.querySelector('.carousel');
      carousel.addEventListener('mouseenter', () => {
        clearInterval(carouselInterval);
      });
      carousel.addEventListener('mouseleave', startCarousel);
    });
  </script>
</body>
</html>