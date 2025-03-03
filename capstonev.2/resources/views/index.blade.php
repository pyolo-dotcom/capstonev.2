<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trucking Services Login</title>
  <!-- Include CSS -->
  <link rel="stylesheet" href="{{ asset('css/capstone.css') }}">
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
}

.truck-image {
  width: 100%;
  height: 80%;
  object-fit: fill;
  margin-top: 40px;
  border-top-right-radius: 20%;
  border-bottom-right-radius: 20%;
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


</style>
<body>
    <!-- Left Section with Image -->
    <div class="left-section">
        <img src="{{ asset('images/truck.jpg') }}" alt="Truck Image" class="truck-image">
    </div>

    <!-- Right Section with Login Form -->
    <div class="right-section">
      <div class="header">
        <h1>The<br><span><i>SYA</i> Trucking Services</span></h1>
        <p>Since 2020</p>
      </div>

      <!-- Login Form -->
      <form method="POST" action="" class="login-form">
        @csrf
        <input type="text" name="username" placeholder="username" class="input-field" required>
        <input type="password" name="password" placeholder="password" class="input-field" required>
        <button type="submit" class="login-button">LOGIN</button>
      </form>

      <!-- Error Display -->
      @if($errors->has('login_error'))
        <p style="color: red; text-align: center;">{{ $errors->first('login_error') }}</p>
      @endif

      <!-- User Icon -->
      
    </div>
</body>
</html>
