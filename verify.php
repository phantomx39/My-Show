<?php
include "connection.php";
session_start();

if (isset($_POST['submit'])) {
    $movie_id = $_POST['movie_id'];
    $theatre = $_POST['theatre'];
    $type = $_POST['type'];
    $date = $_POST['date'];
    $hour = $_POST['hour'];
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $pNumber = $_POST['pNumber'];
    $email = $_POST['email'];
    
    // Generate a unique order ID
    $order_id = "ORDER" . rand(10000, 99999999);
    
    // Calculate amount based on theatre type
    $amount = 0;
    if ($theatre == "main-hall") {
        $amount = 200;
    } elseif ($theatre == "vip-hall") {
        $amount = 500;
    } elseif ($theatre == "private-hall") {
        $amount = 900;
    }
    
    // Insert booking into database
    $insert_query = "INSERT INTO bookingTable (movieID, bookingTheatre, bookingType, bookingDate, bookingTime, 
                    bookingFName, bookingLName, bookingPNumber, bookingEmail, amount, ORDERID) 
                    VALUES ('$movie_id', '$theatre', '$type', '$date', '$hour', 
                    '$fName', '$lName', '$pNumber', '$email', '$amount', '$order_id')";
    
    if (mysqli_query($con, $insert_query)) {
        // Store payment details in session
        $_SESSION['order_id'] = $order_id;
        $_SESSION['amount'] = $amount;
        $_SESSION['name'] = $fName . " " . $lName;
        $_SESSION['email'] = $email;
        
        // Redirect to demo payment page
        header("Location: demo_payment.php");
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>