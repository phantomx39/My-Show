<?php
require_once 'connection.php';

$username = '123';
$password = '123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$query = "UPDATE users SET password = ? WHERE username = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $username);

if (mysqli_stmt_execute($stmt)) {
    echo "Password updated successfully!";
} else {
    echo "Error updating password: " . mysqli_error($con);
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?> 