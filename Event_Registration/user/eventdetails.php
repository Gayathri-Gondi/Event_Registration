<!DOCTYPE html>
<?php require_once("../connection.php");
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
    $img = $RES['img'];
}

?>
<?php
//getting the event id from account.php to print details of the clicked event
$sub = $_GET['sub']; ?>
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
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,300;1,300&display=swap"
        rel="stylesheet">
    <style>
        .card-horizontal {
            display: flex !important;
            flex: 1 1 auto !important;
        }
    </style>
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
    <?php
    //when button is submitted user gets registered, that added into database
    /*if (isset($_POST['reg'])) {
        $Result = mysqli_query($dbc, "INSERT into registered_users (id, email, eid) values(NULL, '$email', '$sub')");
    $subject = 'Registration Successful';
    $message = "You have success";

    mail($email, $subject, $message);

    }
    if ($Result) {
        $done = 2;
    }
    if ($done) {

        header("refresh");
    }
    */?>
    <div class="page-content p-5" id="content">
        <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"><i
                class="fa fa-bars mr-2"></i><small class="text-uppercase font-weight-bold">Menu</small></button>
        <h2 class="display-4 text-white">Events DashBoard</h2>
        <br>
        <div class="container">
            <div class="row gy-4">
                <div class="col">
                    <?php
                    //Retreiving and displaying event details
                    $Result = mysqli_query($dbc, "SELECT * FROM Events where id = {$sub}");
                    if ($row = mysqli_fetch_array($Result)) { ?>
                        <?php $sub = $row['id'];
                        $title = $row['name'] ?>
                        <?php
                        //disabling button if user already registered or accepted or got rejected
                        $tobi = mysqli_query($dbc, "SELECT * FROM registered_users where eid = {$sub} and email = '$email'");
                        $tow = mysqli_fetch_array($tobi);
                        $tesu = mysqli_query($dbc, "SELECT * FROM accepted where eid = {$sub} and email = '$email'");
                        $tows = mysqli_fetch_array($tesu);
                        if ($tow > 0 or $tows > 0) { ?>
                            <a class="dis" href="#" style=" text-decoration: none; color:#121123">
                            <?php } else { ?>
                                <a class="dis" href="registerevent.php?sub=<?php echo $sub ?>"
                                    style=" text-decoration: none; color:#121123"> <?php } ?>
                                <?php
                                if (isset($_POST['bck'])) {
                                    header("location:account.php");
                                } ?>
                                <div style="text-align: right;">
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="hide" id="hide" value="<?php echo $row['id'] ?>" />
                                        <button name="bck" class="bck btn btn-new my-2"><i class="fa fa-arrow-left"></i>
                                            Back</button>
                                        <br>
                                    </form>
                                </div>
                                <div class="card  h-100" style="height:45%; width:100%">
                                    <img style="height:100%;" src="../admin/uploads/<?php echo $row['img']; ?>"
                                        class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            <?php echo $row['name']; ?>
                                        </h4>
                                        <p class="card-text">
                                            <?php echo $row['description']; ?>
                                        </p>
                                        <h5 class="card-title" style="color:#7d54a4">
                                            Event Date :
                                            <?php echo $row['date']; ?>
                                        </h5>
                                        <form action="registerevent.php" method="POST">
                                            <?php
                                            //disabling button if user already registered or accepted or got rejected
                                            $Result = mysqli_query($dbc, "SELECT * FROM registered_users where eid = {$sub} and useremail = '$email'");
                                            $row = mysqli_fetch_array($Result);
                                            $resu = mysqli_query($dbc, "SELECT * FROM accepted where eid = {$sub} and email = '$email'");
                                            $rows = mysqli_fetch_array($resu);
                                            if ($row > 0 or $rows > 0) {

                                                if ($rows > 0) { ?>
                                                    <div class="text-center">
                                                        <button name="reg" class="btn btn-new btn-block" class="py-2" disabled>
                                                            <?php echo $rows['status']; ?>
                                                        </button>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="text-center">
                                                        <button name="reg" class="btn btn-new btn-block" class="py-2" disabled>
                                                            Registered
                                                        </button>
                                                    </div>
                                                <?php } ?>
                                            </form>
                                </a>
                            <?php } else { ?>

                                <div class="text-center">
                                    <button name="reg" class="btn btn-new btn-block" value="<?php $sub ?>" class="py-2">
                                        register </button>
                                </div>
                            </a>
                        <?php } ?>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col">
                <?php
                //counting total number of registration including accepted
                $Result = mysqli_query($dbc, "SELECT count('1') FROM Registered_users where eid = '$sub'");
                $row = mysqli_fetch_array($Result);
                $t = $row[0];
                ?>
                <div class="row" style="height:50px">
                    <div class="col-12 mt-3">
                        <div class="card">
                            <div class="card-horizontal">
                                <div class="img-square-wrapper">
                                    <img style="width: 120px;height: 120px;object-fit: cover;" class=""
                                        src="../profiles/profile.png" alt="Card image cap">
                                </div>
                                <div class="card-body">
                                    <br>
                                    <!-- displaying the count -->
                                    <h4 class="card-title">
                                        Total Registrations =
                                        <?php echo $t; ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
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