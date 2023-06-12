<!DOCTYPE html>
<?php require_once("../connection.php");
include "../user/mail.php";
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
            display: flex;
            flex: 1 1 auto;
        }
    </style>
</head>

<body>
    <!-- sidebar -->
    <div class="vertical-nav bg-white" style="background-color: #f9f9f9 !important;" id="sidebar">
        <div class="py-4 px-3 mb-4 bg-light">
            <div class="mediaicon d-flex align-items-center">
                <img style="width: 140px;height: 140px;border-radius: 50%;object-fit: cover;"
                    src="../profiles/<?php echo $img; ?>" class="iconimg mr-3 rounded-circle img-thumbnail shaadow-sm">
                <div class="media-body">
                    <h4 class="m-0">Admin</h4>
                    <p class="font-weight-norml text-muted mb-0">
                        <?php echo $fname; ?>
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
                    Events DashBoard
                </a>
            </li>
            <li class="nav-item">
                <a href="adreq.php" class="nav-link text-dark bg-light">
                    <i class="fas fa-address-card mr-3 text-primary fa-fw"></i>
                    Admin Requests
                </a>
            </li>

            <li class="nav-item">
                <a href="acceptedusers.php" class="nav-link text-dark bg-light">
                    <i class="fas fa-user mr-3 text-primary fa-fw"></i>
                    Current Admins
                </a>
            </li>

            <ul class="nav flex-column bg-white mb-0">
                <li class="nav-item">
                    <a href="addevents.php" class="nav-link text-dark bg-light">
                        <i class="fas fa-plus mr-3 text-primary fa-fw"></i>
                        Add Events
                    </a>
                </li>

                <li class="nav-item">
                    <a href="myprofile.php" class="nav-link text-dark bg-light">
                        <i class="fas fa-user mr-3 text-primary fa-fw"></i>
                        Your Profile
                    </a>
                </li>

                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-dark bg-light">
                        <i class="fas fa-sign-out-alt mr-3 text-primary fa-fw"></i>
                        Log Out
                    </a>
                </li>
            </ul>
    </div>
    <?php
    //if button is pressed, the the user gets inserted into database as accepted
    /*$uem = $_POST['hide'];
        $em = $_POST['hidem'];
        $Resu = mysqli_query($dbc, "INSERT INTO accepted (id, email, useremail,eid, status) VALUES (NULL, '$em', '$uem', '$sub', */
    if (isset($_POST['accept'])) {
        $em = $_POST['hide'];
        $Resu = mysqli_query($dbc, "INSERT INTO accepted (id, email, eid, status) VALUES (NULL, '$em', '$sub', 'Accepted')");
    }
    if ($Resu) {
        $done = 2;
    }
    if ($done) {
        /*
        $em = $_POST['hide'];
        $pro = mysqli_query($dbc, "DELETE from registered_users where email='$em' and eid='$sub'"); */

        $ro = mysqli_query($dbc, "SELECT * from Events where id = '$sub'");
        $rob = mysqli_query($dbc, "SELECT * from Registered_users where useremail = '$em'");
        $rowsee = mysqli_fetch_array($rob);
        $rowse = mysqli_fetch_array($ro);
        $to = $rowsee['email'];
        $subject = "Update on your event " . $rowse['name'] . " registration";
        $message = "Congratulations! You successfully got accepted for the event " . $rowse['name'] . " which is taking place on " . $rowse['date'] . ". We are excited to see you at the event! Thank you for registering";
        if (send_mail($to, $subject, $message)) {
            header("refresh");
        } else {
            header("refresh");
        }


    }
    ?>
    <?php
    //if button is pressed, the the user gets inserted into database as rejected
    if (isset($_POST['reject'])) {
        $em = $_POST['hide'];
        $Resul = mysqli_query($dbc, "INSERT INTO accepted (id, email, eid, status) VALUES (NULL, '$em', '$sub', 'Rejected')");
    }
    if ($Resul) {
        $donee = 2;
    }
    if ($donee) {
        /* $em = $_POST['hide'];
        $proo = mysqli_query($dbc, "DELETE from registered_users where email='$em' and eid='$sub'"); */

        $ro = mysqli_query($dbc, "SELECT * from Events where id = '$sub'");
        $rob = mysqli_query($dbc, "SELECT * from Registered_users where useremail = '$em'");
        $rowsee = mysqli_fetch_array($rob);
        $rowse = mysqli_fetch_array($ro);
        $to = $rowsee['email'];
        $subject = "Update on your event " . $rowse['name'] . " registration";
        $message = "We are very sorry to inform you that your registration for the event " . $rowse['name'] . " which is taking place on " . $rowse['date'] . " is unsuccessful! However there are many more events which are going to take place. so, please stay engaged on our website for future events, Thank you for showing interest";
        if (send_mail($to, $subject, $message)) {
            header("refresh");
        } else {
            header("refresh");
        }
    }
    ?>
    <div class="page-content p-5" id="content">
        <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"><i
                class="fa fa-bars mr-2"></i><small class="text-uppercase font-weight-bold">Menu</small></button>
        <h2 class="display-4 text-white">Events DashBoard</h2>
        <br>
        <div class="container">
            <div class="row gy-4">

                <div class="col">
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
                    <?php
                    //Retreiving and displaying event details
                    $Result = mysqli_query($dbc, "SELECT * FROM Events where id = {$sub}");
                    if ($row = mysqli_fetch_array($Result)) { ?>
                        <?php $sub = $row['id']; ?>

                        <div class="card  h-100" style=" width:550px">
                            <img style="height:35%;" src="uploads/<?php echo $row['img']; ?>" class="card-img-top"
                                alt="...">
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
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <?php
                        //retrieving and displaying the users who registered for this specific event
                        $Result = mysqli_query($dbc, "SELECT * FROM Users where email in (select useremail from registered_users where eid = '$sub') and email not in (select email from accepted where eid = '$sub')");
                        while ($row = mysqli_fetch_array($Result)) {
                            ?>
                            <?php $uid = $row['id'];
                            $em = $row['email']; ?>
                            <div class="row" style="height:50px">

                                <div class="col-12 mt-3">
                                    <div class="card">
                                        <div class="card-horizontal">
                                            <a href="profiledetails.php?uid=<?php echo $uid ?>&eid=<?php echo $sub ?>"
                                                style="color:#9d7eb9">
                                                <div class="img-square-wrapper">
                                                    <img style="width: 120px;height: 120px;object-fit: cover;" class=""
                                                        src="../profiles/<?php echo $row['img']; ?>" alt="Card image cap">
                                                </div>
                                                <div class="card-body">
                                                    <h4 class="card-title">
                                                        <?php echo $row['fname'], " ", $row['lname']; ?>
                                                    </h4>
                                            </a>
                                            <!-- buttons form used to reject or accept users -->
                                            <form method="POST">
                                                <input type="hidden" name="hide" id="hide"
                                                    value="<?php echo $row['email'] ?>" />
                                                <button name="accept" value="accept" style="width:120px"
                                                    class="btn btn-new">Accept</button>
                                                <button name="reject" value="reject" style="width:120px"
                                                    class="btn btn-new">Reject</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php }

                    ?>
    </div>
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