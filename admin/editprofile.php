<!DOCTYPE html>
<?php require_once("../connection.php"); ?>
<?php
if (!isset($_SESSION["login_sess"])) {
    header("location:../userlogin.php");
}
$email = $_SESSION["login_email"];
$findresult = mysqli_query($dbc, "SELECT * FROM Users WHERE email = '$email'");
if ($RES = mysqli_fetch_array($findresult)) {
    $fname = $RES['fname'];
    $lname = $RES['lname'];
    $email = $RES['email'];
    $pimg = $RES['img'];
    $num = $RES['number'];
    $uid = $RES['id'];
}
?>
<html>
<?php
//validating the form data
if (isset($_POST['edit'])) {
    extract($_POST);
    if (strlen($efname) < 3) {
        $error[] = 'Please Enter Atleast 3 Characters for First Name';
    }
    if (strlen($efname) > 20) {
        $error[] = 'First Name : Maximum Limit Reached, Please Enter Name with length less Than 20';
    }
    if (!preg_match("/^[A-Za-z _]*[A-Za-z ]+[A-Za-z _]*$/", $efname)) {
        $error[] = 'Invalid Entery, First Name Should not contain Digit or Special Characters';
    }
    extract($_POST);
    if (strlen($elname) < 3) {
        $error[] = 'Please Enter Atleast 3 Characters for Last Name';
    }
    if (strlen($elname) > 20) {
        $error[] = 'First Name : Maximum Limit Reached, Please Enter Name with length less Than 20';
    }
    if (!preg_match("/^[A-Za-z _]*[A-Za-z ]+[A-Za-z _]*$/", $elname)) {
        $error[] = 'Invalid Entery, Last Name Should not contain Digit or Special Characters';
    }
    if (strlen($eemail) > 50) {
        $error[] = 'Email : Maximum Limit Reached, Please Enter the mail ID with length less Than 50';
    }

    $sql = "select * from Users where id!='$uid' and number = '$num' and email = '$email';";
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

        if (!empty($_FILES["img"]["name"])) {
            $pfp = time() . '_' . $_FILES["img"]["name"];
            $target = '../profiles/' . $pfp;
            copy($_FILES["img"]["tmp_name"], $target);
            unlink("../profiles/<?php echo $pimg; ?>");
            $Result = mysqli_query($dbc, "UPDATE Users SET fname='$efname', lname='$elname', number='$ecnum', img='$pfp' WHERE number = '$num'");
            if ($Result) {
                header("location:myprofile.php");
            } else {
                $error[] = 'Failed! Something went wrong here';
                echo $efname, $elname, $eemail, $ecnum;
            }
        } else {
            $Result = mysqli_query($dbc, "UPDATE Users SET fname='$efname', lname='$elname', number='$ecnum' WHERE number = '$num'");
            if ($Result) {
                header("location:myprofile.php");
            } else {
                $error[] = 'Failed! Something went wrong';
                echo mysqli_error($dbc);
            }
        }
    }
}
?>

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
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label> First Name : </label>
                                                <input type="text" name="efname" class="form-control" value="<?php
                                                echo $row['fname']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label> Last Name : </label>
                                                <input type="text" name="elname" class="form-control" value="<?php
                                                echo $row['lname']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label> Email : </label>
                                                <input type="text" name="eemail" class="form-control" value="<?php
                                                echo $row['email']; ?>" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label> Contact Number : </label>
                                                <input type="text" name="ecnum" class="form-control" value="<?php
                                                echo $row['number']; ?>" required>
                                            </div>
                                            <button name="img" style="width:45%" class="del btn btn-new my-2"><i
                                                    class="fa fa-camera"> <input name="img" type="file" /></i></button>
                                            <button name="rpw" style="width:45%" class="del btn btn-new my-2"><i
                                                    class="fa fa-key"></i> Change Password</button>
                                            <div class="text-center py-3">
                                                <button name="edit" style="width:100%" class="edit btn btn-new my-2">Save
                                                    Changes</button>
                                            </div>
                                        </form>
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