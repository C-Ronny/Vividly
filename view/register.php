<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vividly | Register</title>
  <link rel="stylesheet" href="register.css">
</head>
<body>

  <!-- Nav Bar -->
  <nav class="nav-bar">
        <h2 id="vividly-logo"><a href="../user_pages/landingpage.php">Vividly</a></h2>

        

        <div class="nav-center">
          <div><a href="login.php">Log In</a></div>
          <div><a href="register.php">Sign Up</a></div>
          <a href="profile.php"><img src="../../assets/images/bg1.jpg"></a>
        </div>

    </nav>

  <div class="container">
    <form  method="POST" enctype="multipart/form-data" id="form" action="register_user.php">
      <h1 class="Welcome">Vividly</h1>
      <br>
      <h2>Sign Up</h2>
      <input id="firstname" type="text" placeholder="Firstname" name="fname">
      <br>
      <br>
      <input id="lastname" type="text" placeholder="Lastname" name="lname">
      <br>
      <br>
      <input id="email" type="email" placeholder="Email" name="email">
      <br>
      <br>
      <input id="password" type="password" placeholder="Password" name="psw">
      <br>
      <br>
      
      <input id="repassword" type="password" placeholder=" Confirm Password" name="psw-confirm">

      <p>Already got an account? <a id="sign" href="login.php">Login</a></p>

      <button type="submit">Sign Up</button>
    </form>
  </div>

  <script>     
    document.getElementById('form').addEventListener('submit', function(event) {
        event.preventDefault(); 
        
        // Remove existing error messages
        document.querySelectorAll('.error').forEach(error => error.remove());

        let isValid = true;

        // First Name Validation
        let firstName = document.getElementById('firstname').value;
        if (firstName === '') {
            showErrorMessage('firstname', 'Please enter your first name');
            isValid = false;
        }

        // Last Name Validation
        let lastName = document.getElementById('lastname').value;
        if (lastName === '') {          
            showErrorMessage('lastname', 'Please enter your last name');
            isValid = false;
        }

        // Email Validation
        let email = document.getElementById('email').value;
        let emailRegEx = /^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailRegEx.test(email)) {
            showErrorMessage('email', 'Invalid Email');
            isValid = false;
        }

        // Password validation
        let password = document.getElementById('password').value;
        let confirmPassword = document.getElementById('repassword').value;
        let passwordRegEx = /^(?=.*[A-Z])(?=.*\d.*\d.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{}|\\:;'",.<>?/`~])[A-Za-z\d!@#$%^&*()_\-+=$begin:math:display$$end:math:display${}|\\:;'",.<>?/`~]{8,}$/;

        if (!passwordRegEx.test(password)) {
            showErrorMessage('password', 'Invalid Password! Password must contain at least 8 characters, 1 uppercase letter, 3 digits, and 1 special character');
            
            isValid = false;
        }

        if (password !== confirmPassword) {
            showErrorMessage('repassword', 'Passwords do not match');
            isValid = false;
        }

        if (isValid) {
            event.target.submit(); // Allow form submission if valid
        }
    });

    function showErrorMessage(fieldId, message) {
        let field = document.getElementById(fieldId);
        let error = document.createElement('div');
        error.classList.add('error');
        error.style.color = 'red';
        error.innerText = message;
        field.parentNode.insertBefore(error, field.nextSibling);
    }
  </script> 

</body>
</html>