<!DOCTYPE html>
<?php require_once("../connection.php");
include "mail.php";
//session used for users to stay logged in until log out 
if (!isset($_SESSION["login_sess"])) {
    header("location:../userlogin.php");
}
$email = $_SESSION["login_email"];
$findresult = mysqli_query($dbc, "SELECT * FROM Users WHERE email = '$email'");
if ($RES = mysqli_fetch_array($findresult)) {
    $fname = $RES['fname'];
    $lname = $RES['lname'];
    $email = $RES['email'];
    $number = $RES['number'];
    $img = $RES['img'];
}
$sub = $_GET['sub'];
?>

<html>

<head>
    <title>Event registration</title>
    <meta charset="utf-8">
    <script src="https://kit.fontawesome.com/fe6346cebe.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/sidebar.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/register.css">

    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,300;1,300&display=swap"
        rel="stylesheet">
</head>

<body>
    <!-- sidebar -->
    <div class="vertical-nav bg-white" style="background-color: #f9f9f9 !important;" id="sidebar">
        <div class="py-4 px-3 mb-4 bg-light">
            <div class="mediaicon d-flex align-items-center">
                <img style="width: 130px;height: 130px;border-radius: 50%;object-fit: cover;"
                    src="../profiles/<?php echo $img; ?>" class="iconimg mr-3 rounded-circle img-thumbnail shaadow-sm">
                <div class="media-body" style="word-break: break-all;">
                    <h5 class="m-0">
                        <?php echo $fname ?>
                    </h5>
                    <p class="font-weight-norml text-muted mb-0">
                        <?php echo $email; ?>
                    </p>
                </div>
            </div>
        </div>
        <div>
            <p class="text-gray font-weight-bold text-uppercase px-3 small pb-4 mb-0">DashBoard</p>
        </div>
        <ul class="nav flex-column bg-white mb-0">
            <li class="nav-item">
                <a href="account.php" class="nav-link text-dark bg-light">
                    <i class="fas fa-boxes mr-3 text-primary fa-fw"></i>
                    Current Events
                </a>
            </li>

            <li class="nav-item">
                <a href="regevents.php" class="nav-link text-dark bg-light">
                    <i class="fas fa-address-card mr-3 text-primary fa-fw"></i>
                    Registered Events
                </a>
            </li>

            <li class="nav-item">
                <a href="profiledetails.php" class="nav-link text-dark bg-light">
                    <i class="fas fa-user mr-3 text-primary fa-fw"></i>
                    Profile
                </a>
            </li>

            <ul class="nav flex-column bg-white mb-0">

                <li class="nav-item">
                    <a href="../admin/logout.php" class="nav-link text-dark bg-light">
                        <i class="fas fa-sign-out-alt mr-3 text-primary fa-fw"></i>
                        Log Out
                    </a>
                </li>
            </ul>
    </div>
    <div class="page-content p-5" id="content">
        <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"><i
                class="fa fa-bars mr-2"></i><small class="text-uppercase font-weight-bold">Menu</small></button>
        <h2 class="display-4 text-white">Events DashBoard</h2>
        <?php
        //validating the form data
        if (isset($_POST['reg'])) {
            extract($_POST);
            $dobo = $dob1;
            $diff = (date('Y') - date('Y', strtotime($dobo)));
            if ($diff >= '18') {
                extract($_POST);
                $Result = mysqli_query($dbc, "INSERT into registered_users(id, fname, lname,email,useremail, Phnom, dob, eid) values(NULL, '$fname1', '$lname1', '$email1', '$email' , '$number1','$dob1', '$sub')");
                if ($Result) {
                    $to = $email1;
                    $subject = "Registration successful";
                    $ro = mysqli_query($dbc, "SELECT * from Events where id = '$sub'");
                    $rowse = mysqli_fetch_array($ro);
                    $message = "You registered successfully for the event " . $rowse['name'] . " which is taking place on " . $rowse['date'] . ". Please await for admin approval regarding your attendance of the event. Thank you for registering";
                    if (send_mail($to, $subject, $message)) {
                        header("location:regevents.php");
                    } else {
                        header("location:account.php");
                    }
                    
                    
                } else {
                    printf("Errormessage: %s\n", mysqli_error($dbc));
                }
            } else {
                echo "age should be greater than 18";
            }
        }
        ?>
        <br>
        <div class="screen" style="height:420px">
            <div class="screen__content">
                <!-- form -->
                <form method="POST" class="login" enctype="multipart/form-data">
                    <div class="inlinefields">
                        <div class="login__field ">
                            <i class="login__icon fas fa-user"></i>
                            <input name="fname1" type="text" class="login__input" placeholder="First Name" value="<?php
                            echo $fname;
                            ?>" required>
                        </div>
                        <div class="login__field">
                            <i class="login__icon fas fa-user"></i>
                            <input name="lname1" type="text" class="login__input" placeholder="Last Name" value="<?php
                            echo $lname; ?>" required>
                        </div>
                    </div>
                    <div class="login__field normalfield">
                        <i class="login__icon fas  fa-envelope"></i>
                        <input name="email1" type="email" class="login__input" placeholder="Email" value="<?php
                        echo $email;
                        ?>" required>
                    </div>
                    <div class="login__field normalfield">
                        <i class="login__icon fas fa-phone"></i>
                        <input name="number1" type="text" class="login__input" placeholder="Phone Number" value="<?php
                        echo $number;
                        ?>" required>
                    </div>
                    <div class="login__field ">
                        <i class="login__icon fas fa-calendar"></i>
                        <input style="color:#fff" name="dob1" type="date" class="login__input"
                            placeholder="Date of Birth" required>
                    </div>
                    <br>

                    <button name="reg" class="button login__submit text-center" style>
                        <span class="button__text">Register</span>
                        <i class="button__icon fas fa-chevron-right"></i>
                    </button>
                </form>
            </div>
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
    <script src="../menubutton.js"></script>
</body>

</html>