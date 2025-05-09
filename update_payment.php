<?php
include "connection.php";
session_start();

if (!isset($_GET['order_id']) || !isset($_GET['status'])) {
    exit('Invalid request');
}

$order_id = $_GET['order_id'];
$status = $_GET['status'];

// Validate status
if (!in_array($status, ['success', 'cancelled'])) {
    exit('Invalid status');
}

// Update payment status in database
$payment_status = ($status === 'success') ? 'Paid' : 'Cancelled';
$update_query = "UPDATE bookingTable SET amount = CASE 
                    WHEN '$payment_status' = 'Paid' THEN amount 
                    ELSE 'Cancelled' 
                END 
                WHERE ORDERID = '$order_id'";

if (mysqli_query($con, $update_query)) {
    if ($status === 'success') {
        // For successful payments, you might want to send an email confirmation
        $email = $_SESSION['email'];
        $subject = "Booking Confirmation - Order #" . $order_id;
        $message = "Thank you for your booking!\n\n";
        $message .= "Order ID: " . $order_id . "\n";
        $message .= "Amount: ₹" . $_SESSION['amount'] . "\n";
        $message .= "Name: " . $_SESSION['name'] . "\n\n";
        $message .= "Your ticket will be available at the reception counter.";
        
        // Send email (commented out as email configuration might not be set up)
        // mail($email, $subject, $message);
    }
    echo 'success';
} else {
    echo 'error';
}
?> 