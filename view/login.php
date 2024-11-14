<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="login.css" >
  <title>Vividly | Login</title>
</head>
<body>
  <!--Nav Bar-->
  <!-- <nav class="nav-bar">
    <div><a href="login.html">Log In</a></div>
    <div><a href="signup.html">Sign Up</a></div>
  </nav> -->

  <div class="container">
    <form  method="POST" enctype="multipart/form-data" id="form" action="login_user.php">
      <h1 class="Welcome">Vividly</h1>
      <br>
      <h2>Login</h2>
      <input type="email" placeholder="Email" name="eml">
      <br>
      <br>
      <input type="password" placeholder="Password" name="psw">

      <p>New to Vividly? <a href="signup.html">Create an Account</a></p>

      <button type="submit">Log In</button>
    </form>
  </div>
</body>
</html>