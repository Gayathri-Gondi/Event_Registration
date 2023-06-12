<!-- still in working -->


<!DOCTYPE html>
<?php require_once("../connection.php");
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
    if (isset($_POST['edit'])) {
        header("location:editprofile.php");
    }
    ?>
    <div class="page-content p-5" id="content">
        <button id="sidebarCollapse" type="button" class="btn btn-light bg-white rounded-pill shadow-sm px-4 mb-4"><i
                class="fa fa-bars mr-2"></i><small class="text-uppercase font-weight-bold">Menu</small></button>
        <h2 class="display-4 text-white">Your Profile</h2>
        <br>
        <div class="container">
            <div class="col">
                <?php
                $Result = mysqli_query($dbc, "SELECT * FROM Users where email= '$email'");
                if ($row = mysqli_fetch_array($Result)) { ?>
                    <div class="row" style="width:100%; height:50%">
                        <div class="col-12 mt-3" style="width:100%; height:50%">
                            <div class="card">
                                <div class="card-horizontal">
                                    <div class="img-square-wrapper">
                                        <img class="iconimg mr-3 rounded-circle img-thumbnail shaadow-sm my-1 mx-1"
                                            style="width: 120px;border-radius: 50%;height: 120px;object-fit: cover;"
                                            class="" src="../profiles/<?php echo $row['img']; ?>" alt="Card image cap">
                                            
                                    </div>
                                    <div class="card-body">

                                        <h4 class="card-title">
                                            <?php echo $row['fname'], " ", $row['lname']; ?>
                                        </h4>
                                        <p class="card-text">
                                            <?php echo "Email : " . $row['email']; ?>
                                        </p>
                                        <p class="card-text">
                                            <?php echo "Contact Number : " . $row['number']; ?>
                                        </p>
                                        <?php
                                        $bday = new DateTime($row['dob']); // Your date of birth
                                        $today = new Datetime(date('y.m.d'));
                                        $diff = $today->diff($bday);
                                        ?>
                                        <p class="card-text">
                                            <?php echo "Date Of Birth : " . $row['dob']; ?>
                                        </p>
                                        <p class="card-text">
                                            <?php echo "Age : " . $diff->y; ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <form class="mx-2 my-1" method="POST">
                                        <input type="hidden" name="hide" id="hide" value="<?php echo $row['email'] ?>" />
                                        <button name="edit" value="edit" style="width:45%" class="btn btn-new my-1"
                                            >Edit Details</button>
                                    </form>
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