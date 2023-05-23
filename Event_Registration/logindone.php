<?php
require_once("connection.php");
//Checking whether login button is pressed
if (isset($_POST['log'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    //query to check if email is valid
    $query = "select * from Users where email = '$email'";
    $RES = mysqli_query($dbc, $query);
    $NROW = mysqli_num_rows($RES);
    if ($NROW == 1) {
        $row = mysqli_fetch_assoc($RES);
        //checking if password matches
        if (password_verify($password, $row['password'])) {
            //checking wether it's user/admin
            if ($row['type'] == 'user') {
                $_SESSION["login_sess"] = "1";
                $_SESSION["login_email"] = $row['email'];
                header("location:user/account.php");
            } else {
                //checking wether it's admin
                $query = "select * from admin where email = '$email'";
                $RES = mysqli_query($dbc, $query);
                $NROW = mysqli_num_rows($RES);
                if ($NROW == 1) {
                    $_SESSION["login_sess"] = "1";
                    $_SESSION["login_email"] = $row['email'];
                    header("location:admin/account.php");
                } else {
                    echo 'pending request';
                }
            }
            //redirecting back to login page with errors if emails not found
        } else {
            header("location:userlogin.php?loginerror=" . $email);
        }
    } else {
        header("location:userlogin.php?loginerror=" . $email);
    }
}
?>