<!DOCTYPE html>
<?php require_once("connection.php"); ?>
<?php
//validating the form data
if (isset($_POST['reg'])) {
  extract($_POST);
  if (strlen($fname) < 3) {
    $error[] = 'Please Enter Atleast 3 Characters for First Name';
  }
  if (strlen($fname) > 20) {
    $error[] = 'First Name : Maximum Limit Reached, Please Enter Name with length less Than 20';
  }
  if (!preg_match("/^[A-Za-z _]*[A-Za-z ]+[A-Za-z _]*$/", $fname)) {
    $error[] = 'Invalid Entery, First Name Should not contain Digit or Special Characters';
  }
  extract($_POST);
  if (strlen($lname) < 3) {
    $error[] = 'Please Enter Atleast 3 Characters for Last Name';
  }
  if (strlen($lname) > 20) {
    $error[] = 'First Name : Maximum Limit Reached, Please Enter Name with length less Than 20';
  }
  if (!preg_match("/^[A-Za-z _]*[A-Za-z ]+[A-Za-z _]*$/", $lname)) {
    $error[] = 'Invalid Entery, Last Name Should not contain Digit or Special Characters';
  }
  if (strlen($email) > 50) {
    $error[] = 'Email : Maximum Limit Reached, Please Enter the mail ID with length less Than 50';
  }
  if ($repswd == "") {
    $error[] = 'Please Confirm The Password';
  }
  if ($repswd != $pswd) {
    $error[] = 'Passwords Do Not Match';
  }
  if (strlen($pswd) < 8) {
    $error[] = 'The Password should be atleast 8 characters long';
  }
  if (strlen($pswd) > 20) {
    $error[] = 'PassWord : Maximum Limit Reached, Please Enter Your Choice of password with length less Than 20';
  }
  $sql = "select * from Users where(number = '$number' or email = '$email');";
  $res = mysqli_query($dbc, $sql);
  if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    if ($number == $row['number']) {
      $error[] = 'Error! Number Already Registered';
    }
    if ($email == $row['email']) {
      $error[] = 'Error! Email Already Exists';
    }
  }
  //inserting register form details onto datbase if no errors 
  if (!isset($error)) {
    extract($_POST);
    $options = array("cost" >= 4);
    $password = password_hash($pswd, PASSWORD_BCRYPT, $options);
    extract($_POST);
    if (!empty($_FILES["img"]["name"])) {
      $pfp = time() . '_' . $_FILES["img"]["name"];
      $target = 'profiles/' . $pfp;
      copy($_FILES["img"]["tmp_name"], $target);
      $Result = mysqli_query($dbc, "INSERT into Users (id, fname, lname,email, number, dob, gender,password,type,img) values(NULL, '$fname', '$lname', '$email', '$number', '$dob', '$gender', '$password', '$type','$pfp')");
      if ($Result) {
        $done = 2;
      } else {
        $error[] = 'Failed! Something went wrong here';
        echo $fname, $lname, $email, $number, $dob, $gender, $password, $type;
      }
    }
    else{
      $Result = mysqli_query($dbc, "INSERT into Users (id, fname, lname,email, number, dob, gender,password,type,img) values(NULL, '$fname', '$lname', '$email', '$number', '$dob', '$gender', '$password', '$type', 'profile.png')");
      if ($Result) {
        $done = 2;
      } else {
        $error[] = 'Failed! Something went wrong';
        echo $fname, $lname, $email, $number, $dob, $gender, $password, $type;
      }
    }
  }
}
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/register.css">
  <script src="https://kit.fontawesome.com/fe6346cebe.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,300;1,300&display=swap"
    rel="stylesheet">
  <title>Event registration</title>
</head>
<!-- navbar -->
<body>
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
        <li class="nav-item active">
          <a class="nav-link" href="registration.php">Register</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link" href="userlogin.php">Login</a>
        </li>
      </ul>
    </div>
  </nav>
  <?php
  if (isset($error)) {
    foreach ($error as $error) {
      echo '<p class = "errormsg"> &#x26A0;' . $error . '</p>';
    }
  }
  ?>
  <div class="container">
    <div class="screen">
      <div class="screen__content">
        <div class="heading text-center">
          <br>
          <h2 style="color:#e0d3e8">Register</h2>
        </div>

        <?php if (isset($done)) { ?>
          <div class="text-center succmsg">
            <span style="font-size:100px;">&#9989;</span>
            <br> You have registered Successfully . <br>
            <div class="py-3 ">
              <a href="userlogin.php" class="btn btn-new" class="py-2"> login here </a>
            </div>
          </div>
        <?php } else { ?>
<!-- form -->
          <form method="POST" class="login" enctype="multipart/form-data">
            <div class="inlinefields">
              <div class="login__field ">
                <i class="login__icon fas fa-user"></i>
                <input name="fname" type="text" class="login__input" placeholder="First Name" value="<?php if (isset($error)) {
                  echo $fname;
                } ?>" required>
              </div>
              <div class="login__field">
                <i class="login__icon fas fa-user"></i>
                <input name="lname" type="text" class="login__input" placeholder="Last Name" value="<?php if (isset($error)) {
                  echo $lname;
                } ?>" required>
              </div>
            </div>
            <div class="login__field normalfield">
              <i class="login__icon fas  fa-envelope"></i>
              <input name="email" type="email" class="login__input" placeholder="Email" value="<?php if (isset($error)) {
                echo $email;
              } ?>" required>
            </div>
            <div class="login__field normalfield">
              <i class="login__icon fas fa-phone"></i>
              <input name="number" type="text" class="login__input" placeholder="Phone Number" value="<?php if (isset($error)) {
                echo $number;
              } ?>" required>
            </div>
            <div class="inlinefields">
              <div class="login__field ">
                <i class="login__icon fas fa-calendar"></i>
                <input style="color:#fff" name="dob" type="date" class="login__input" placeholder="Date of Birth"
                  required>
              </div>
              <div class="login__field">

                <select class="login__input" style="width:88%; height:40px" name="gender" id="gender">
                  <option value="female">Female</option>
                  <option value="male">Male</option>
                  <option value="no">Prefer Not To Say</option>
                </select>
              </div>
            </div>
            <div class="inlinefields">
              <div class="login__field ">
                <i class="login__icon fas fa-lock"></i>
                <input name="pswd" type="password" class="login__input" placeholder="Password" required>
              </div>
              <div class="login__field">
                <i class="login__icon fas fa-lock"></i>
                <input name="repswd" type="password" class="login__input" placeholder="Re-enter Password" required>
              </div>
            </div>
            <div class="inlinefields">
              <div class="login__field normalfield">
                <select class="login__input text-center" style="width:80%; height:40px" name="type" id="type">
                  <option value="user">User</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
              <div class="form-group"  style="width:120%; padding-top:21px; padding-right:25px;">
                <input type="file" name="img" value="" class="form-control">
              </div>
            </div>
            <button name="reg" class="button login__submit text-center" style>
              <span class="button__text">Register</span>
              <i class="button__icon fas fa-chevron-right"></i>
            </button>
          </form>
        <?php } ?>
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