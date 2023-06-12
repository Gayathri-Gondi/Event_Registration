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
        <h2 class="display-4 text-white">Add Events</h2>

        <section style="padding-top:30px">
            <div class="w-50   text-white">
                <?php
                //inserting all the event details into database if button is pressed
                if (isset($_POST["adde"])) {
                    extract($_POST);
                    $pfp = time() . '_' . $_FILES["img"]["name"];
                    $target = 'uploads/' . $pfp;
                    if (!empty($_POST['description'])) {
                        $Result = mysqli_query($dbc, "INSERT into Events (id, name, description, date, img) values(NULL, '$ename', '$description', '$date', '$pfp')");

                        if (!$Result) {
                            printf("Errormessage: %s\n", mysqli_error($dbc));
                        } else {
                            copy($_FILES['img']["tmp_name"], $target);
                            echo 'added successfully';
                        }
                    }
                }
                ?>
                <!-- Form to get event details -->
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label> Event Name : </label>
                        <input type="text" name="ename" value="" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label> Description : </label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label> Date Of Event : </label>
                        <input type="date" name="date" value="" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label> Upload Image If Any : </label>
                        <input type="file" name="img" value="" class="form-control">
                    </div>
                    <div class="text-center">
                        <button name="adde" class="btn btn-new btn-block" class="py-2"> Add </button>
                    </div>
                </form>
            </div>
        </section>
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