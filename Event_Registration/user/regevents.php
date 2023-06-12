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
        
        <br>
        <!-- retrieving and displaying user registered events -->
        <?php $query = "SELECT * FROM Events where id in (SELECT eid FROM registered_users where email='$email'  and email not in (SELECT email from accepted where accepted.eid = registered_users.eid)) ";
        $query_run = mysqli_query($dbc, $query);

        if (mysqli_num_rows($query_run) > 0) {
            $c = 1;
            ?>
        
        <h2 class="display-4 text-white">Registered Events</h2>
            <div class="container">
                <div class="row gy-4">
                    <?php foreach ($query_run as $row) { ?>
                        <?php $sub = $row['id']; ?>
                        <div class="col-sm-6 col-lg-3 py-2" >
                            <a href="eventdetails.php?sub=<?php echo $sub ?>" style=" text-decoration: none; color:#121123">
                                <div class="card h-100" style="height:100%">
                                    <img style="height:35%" src="../admin/uploads/<?php echo $row['img']; ?>"
                                        class="card-img-top" alt="...">
                                    <div class="card-body" >
                                        <h4 class="card-title">
                                            <?php echo $row['name']; ?>
                                        </h4>
                                        <p class="card-text">
                                            <?php $text=substr($row['description'],0,70).'...';
                                            echo $text; ?>
                                        </p> 
                                        <h5 class="card-title" style="color:#7d54a4">
                                            Event Date :
                                            <?php echo $row['date']; ?>
                                        </h5>
                                        <!-- Button for user to view more -->
                                        <div class="text-center">
                                            <button name="reg" class="btn btn-new btn-block" class="py-2"> View More </button>
                                        </div>
                                    </div>
                                </div>
                        </div></a>
                        <br>
                    <?php } ?>
                </div>
            </div>
            <!-- retrieving and displaying events user got accepted into -->
        <?php }
        $query = "SELECT * FROM Events where id in (SELECT eid FROM accepted where email='$email' and status='Accepted')";
        $query_run = mysqli_query($dbc, $query);
        if(mysqli_num_rows($query_run) > 0)
            {
            $c = 1;
        ?>
        <h2 class="display-4 text-white">Registration Accepted Events</h2>
            <div class="container">
                <div class="row gy-4">
                    <?php foreach ($query_run as $row) { ?>
         
                        <?php $sub = $row['id']; ?>
                        <div class="col-sm-6 col-lg-3 py-2" >
                            <a href="eventdetails.php?sub=<?php echo $sub ?>" style=" text-decoration: none; color:#121123">
                                <div class="card h-100" style="height:100%">
                                    <img style="height:35%" src="../admin/uploads/<?php echo $row['img']; ?>"
                                        class="card-img-top" alt="...">
                                    <div class="card-body" >
                                        <h4 class="card-title">
                                            <?php echo $row['name']; ?>
                                        </h4>
                                        <p class="card-text">
                                            <?php $text=substr($row['description'],0,70).'...';
                                            echo $text; ?>
                                        </p> 
                                        <h5 class="card-title" style="color:#7d54a4">
                                            Event Date :
                                            <?php echo $row['date']; ?>
                                        </h5>
                                        <!-- Button for user to view more -->
                                        <div class="text-center">
                                            <button name="reg" class="btn btn-new btn-block" class="py-2"> View More </button>
                                        </div>
                                    </div>
                                </div>
                        </div></a>
                        <br>
                    <?php } ?>
                </div>
            </div>
            <!-- retrieving and displaying events user got rejected -->
        <?php }
        $query = "SELECT * FROM Events where id in (SELECT eid FROM accepted where email='$email' and status='Rejected')";
        $query_run = mysqli_query($dbc, $query);
        if(mysqli_num_rows($query_run) > 0)
        {
            $c = 1;
        ?>
        <h2 class="display-4 text-white">Registration Rejected Events</h2>
            <div class="container">
                <div class="row gy-4">
                    <?php foreach ($query_run as $row) { ?>
        
                        <?php $sub = $row['id']; ?>
                        <div class="col-sm-6 col-lg-3 py-2" >
                            <a href="eventdetails.php?sub=<?php echo $sub ?>" style=" text-decoration: none; color:#121123">
                                <div class="card h-100" style="height:100%">
                                    <img style="height:35%" src="../admin/uploads/<?php echo $row['img']; ?>"
                                        class="card-img-top" alt="...">
                                    <div class="card-body" >
                                        <h4 class="card-title">
                                            <?php echo $row['name']; ?>
                                        </h4>
                                        <p class="card-text">
                                            <?php $text=substr($row['description'],0,70).'...';
                                            echo $text; ?>
                                        </p> 
                                        <h5 class="card-title" style="color:#7d54a4">
                                            Event Date :
                                            <?php echo $row['date']; ?>
                                        </h5>
                                        <!-- Button for user to view more -->
                                        <div class="text-center">
                                            <button name="reg" class="btn btn-new btn-block" class="py-2"> View More </button>
                                        </div>
                                    </div>
                                </div>
                        </div></a>
                        <br>
                    <?php } ?>
                </div>
            </div> <?php } ?>
            <!-- retrieving and displaying past events -->
        <?php 
        $query = "SELECT * FROM deleted_events where id in (SELECT eid FROM accepted where email='$email')";
        $query_run = mysqli_query($dbc, $query);
        if(mysqli_num_rows($query_run) > 0)
        {
            $c = 1;
        ?>
        <h2 class="display-4 text-white">Past Events</h2>
            <div class="container">
                <div class="row gy-4">
                    <?php foreach ($query_run as $row) { ?>
                        <?php $sub = $row['id']; ?>
                        <div class="col-sm-6 col-lg-3 py-2" >
                                <div class="card h-100" style="height:100%">
                                    <img style="height:35%" src="../admin/uploads/<?php echo $row['img']; ?>"
                                        class="card-img-top" alt="...">
                                    <div class="card-body" >
                                        <h4 class="card-title">
                                            <?php echo $row['name']; ?>
                                        </h4>
                                        <p class="card-text">
                                            <?php $text=substr($row['description'],0,70).'...';
                                            echo $text; ?>
                                        </p> 
                                        <h5 class="card-title" style="color:#7d54a4">
                                            Event Date :
                                            <?php echo $row['date']; ?>
                                        </h5>
                                        <!-- Button for user to view more -->
                                        <div class="text-center">
                                            <button name="reg" class="btn btn-new btn-block" class="py-2" disabled> View More </button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <br>
                    <?php } ?>
                </div>
            </div> <?php }
             if($c!=1){?>
                <h2 class="display-4 text-white">No Registered events</h2>
                <?php } ?>

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