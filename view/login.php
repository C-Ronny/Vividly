<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");  // Redirect to the homepage or dashboard
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vividly | Login</title>
    <link rel="stylesheet" href="../assets/css/login.css" >    
  </head>

  <body>
    <!-- Nav Bar -->
    <nav class="nav-bar">
      <h2 id="vividly-logo"><a href="../index.php">Vividly</a></h2>

      <div class="nav-center">
        <div><a href="login.php">Log In</a></div>
        <div><a href="register.php">Sign Up</a></div>
        <a href="#"><img src="../assets/images/bg1.jpg"></a>
      </div>
    </nav>

    <div class="container">
      <form  method="POST" enctype="multipart/form-data" id="form" action="../actions/login_user.php">
        <h1 class="Welcome">Vividly</h1>
        <br>
        <h2>Login</h2>
        <input id="email" type="email" placeholder="Email" name="email">
        <br>
        <br>
        <input id="password" type="password" placeholder="Password" name="psw">

        <p>New to Vividly? <a href="register.php">Create an Account</a></p>

        <button type="submit">Log In</button>
      </form>
    </div>


    <script>
      document.getElementById('form').addEventListener('submit', function(e) {
          e.preventDefault();

          // Validation
          let isValid = true;

          // Email Validation
          let email = document.getElementById('email').value;
          if (email === '') {
              showErrorMessage('email', 'Please enter your email');
              isValid = false;
          }

          // Password Validation
          let password = document.getElementById('password').value;
          let passwordRegEx = /^(?=.*[A-Z])(?=.*\d{3,})(?=.*[!@#$%^&*()_\-+=\[\]{}|\\:;'",.<>?/`~])[A-Za-z\d!@#$%^&*()_\-+=$begin:math:display$$end:math:display${}|\\:;'",.<>?/`~]{8,}$/;
          if (!passwordRegEx.test(password)) {
              showErrorMessage('password', 'Invalid Password');
              isValid = false;
          }

          // Submit form if valid
          if (isValid) {
              e.target.submit();
          }
      });

      // Error message function
      function showErrorMessage(fieldID, message) {
          let field = document.getElementById(fieldID);
          let existingError = field.nextElementSibling;
          if (existingError && existingError.classList.contains('error')) {
              existingError.innerText = message;
          } else {
              let errorMessage = document.createElement('div');
              errorMessage.classList.add('error');
              errorMessage.style.color = 'red';
              errorMessage.innerText = message;
              field.parentNode.insertBefore(errorMessage, field.nextSibling);
          }
      }
    </script>
  </body>
</html>