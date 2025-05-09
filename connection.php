<?php
$host = "localhost:3308";  // Host with port
$user = "root";
$password = "";
$db = "cinema_db";

$con = mysqli_connect($host, $user, $password, $db);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>  