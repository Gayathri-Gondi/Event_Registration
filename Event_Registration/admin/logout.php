<?php require_once("../connection.php");
//session will expire and user has to login again
session_destroy();
header("location:../userlogin.php");
?>