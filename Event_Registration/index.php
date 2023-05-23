<!DOCTYPE html>
<html>

<head>
  <title>Event registration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/button.css">
  <script src="https://kit.fontawesome.com/fe6346cebe.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,300;1,300&display=swap"
    rel="stylesheet">
</head>

<body>
  <!-- NavBar for website -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #212121;">
    <a class="navbar-brand" href="#">Event registration</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="registration.php">Register</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link" href="userlogin.php">Login</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Carousel -->
  <div id="demo" class="carousel slide" data-ride="carousel">
    <ul class="carousel-indicators">
      <li data-target="#demo" data-slide-to="0" class="active"></li>
      <li data-target="#demo" data-slide-to="1"></li>
      <li data-target="#demo" data-slide-to="2"></li>
    </ul>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/code_testing.jpg" alt="Los Angeles" width="100%" height="100%">
        <div class="carousel-caption">
          <h3 class="text-dark"></h3>
          <p class="text-dark"></p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="images/design.jpg" alt="Chicago" width="100%" height="100%">
        <div class="carousel-caption">
          <h3 class="text-dark"></h3>
          <p class="text-dark"></p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="images/coding.jpg" alt="New York" width="1100" height="500">
        <div class="carousel-caption">
          <h3 class="text-dark"></h3>
          <p class="text-dark"></p>
        </div>
      </div>

    </div>
    <a class="carousel-control-prev" href="#demo" data-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#demo" data-slide="next">
      <span class="carousel-control-next-icon"></span>
    </a>
  </div>


  <!-- Register Buttons -->
  <div class="py-2 text-center">
    <button onclick="window.location.href='registration.php'" class="button-64" role="button"><span
        class="text">Register Here</span></button>
  </div>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>