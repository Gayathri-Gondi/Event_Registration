<?php
//connecting to database
session_start();
$dbHost = 'localhost';
$dbName = 'Event_Registration';
$dbUsername = 'root';
$dbPassword = '';
$dbc = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
?>