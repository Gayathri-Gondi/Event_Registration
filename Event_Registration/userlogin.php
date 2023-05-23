<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/loginform.css">
  <script src="https://kit.fontawesome.com/fe6346cebe.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,300;1,300&display=swap"
    rel="stylesheet">
  <title>Event registration</title>
</head>

<body>

<!-- navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #212121;">
    <a class="navbar-brand" href="#">Event registration</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item ">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="registration.php">Register</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="userlogin.php">Login</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container">
    <div class="screen">
      <div class="screen__content">
        <div class="heading text-center">
          <br>
          <br>
          <br>
          <h2 style="color:#e0d3e8">Login</h2>
        </div>
        <?php
        if (isset($_GET['loginerror'])) {
          $loginerror = $_GET['loginerror'];
        }
        if (!empty($loginerror)) {
          echo '<p class ="errmsg"> invalid login credentials, please try again</p>';
        } ?>

      <!-- form -->
        <form method="POST" action="logindone.php" class="login">
          <div class="login__field ">
            <i class="login__icon fas fa-user"></i>
            <input name="email" type="email" class="login__input" placeholder="Email" value = "<?php
            if (!empty($loginerror)) {
              echo $loginerror;
            } ?>">
          </div>
          <div class="login__field">
            <i class="login__icon fas fa-lock"></i>
            <input name="password" type="password" class="login__input" placeholder="Password">
          </div>
          <button name="log" class="button login__submit">
            <span class="button__text">Log In Now</span>
            <i class="button__icon fas fa-chevron-right"></i>
          </button>
        </form>
        <div class="social-login">
          <h3>log in via</h3>
          <div class="social-icons">
            <a href="#" class="social-login__icon fab fa-instagram"></a>
            <a href="#" class="social-login__icon fab fa-facebook"></a>
            <a href="#" class="social-login__icon fab fa-twitter"></a>
          </div>
        </div>
      </div>
      <div class="screen__background">
        <span class="screen__background__shape screen__background__shape4"></span>
        <span class="screen__background__shape screen__background__shape3"></span>
        <span class="screen__background__shape screen__background__shape2"></span>
        <span class="screen__background__shape screen__background__shape1"></span>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>