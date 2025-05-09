<?php
session_start();
if (!isset($_SESSION['order_id'])) {
    header("Location: index.php");
    exit();
}

include "connection.php";

// Get booking details from database
$order_id = $_SESSION['order_id'];
$query = "SELECT * FROM bookingTable WHERE ORDERID = '$order_id'";
$result = mysqli_query($con, $query);
$booking = mysqli_fetch_assoc($result);

// Get movie details
$movie_query = "SELECT * FROM movieTable WHERE movieID = '{$booking['movieID']}'";
$movie_result = mysqli_query($con, $movie_query);
$movie = mysqli_fetch_assoc($movie_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="style/styles.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .success-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 40px 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        .success-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #28a745;
            position: relative;
            animation: scaleIn 0.3s ease-in-out;
        }
        .success-icon:before,
        .success-icon:after {
            content: '';
            position: absolute;
            background: white;
        }
        .success-icon:before {
            width: 40px;
            height: 8px;
            transform: rotate(45deg);
            left: 17px;
            top: 37px;
        }
        .success-icon:after {
            width: 20px;
            height: 8px;
            transform: rotate(-45deg);
            left: 28px;
            top: 40px;
        }
        .booking-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: left;
        }
        .movie-details {
            margin-top: 20px;
            padding: 15px;
            background: #e9ecef;
            border-radius: 8px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 5px 0;
            border-bottom: 1px dashed #ddd;
        }
        .detail-label {
            color: #666;
            font-weight: bold;
        }
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
            transition: background 0.3s;
        }
        .btn-ticket {
            background: #007bff;
            color: white;
        }
        .btn-home {
            background: #6c757d;
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
        }
        @keyframes scaleIn {
            0% { transform: scale(0); }
            100% { transform: scale(1); }
        }
        .success-message {
            color: #28a745;
            font-size: 24px;
            margin: 20px 0;
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon"></div>
        <h1 class="success-message">Payment Successful!</h1>
        <p>Thank you for your booking. Your transaction has been completed successfully.</p>
        
        <div class="booking-details">
            <h3>Booking Details</h3>
            <div class="detail-row">
                <span class="detail-label">Order ID:</span>
                <span><?php echo $booking['ORDERID']; ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Amount Paid:</span>
                <span>₹<?php echo $booking['amount']; ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Name:</span>
                <span><?php echo $booking['bookingFName'] . " " . $booking['bookingLName']; ?></span>
            </div>
            
            <div class="movie-details">
                <h4>Movie Information</h4>
                <div class="detail-row">
                    <span class="detail-label">Movie:</span>
                    <span><?php echo $movie['movieTitle']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Theatre:</span>
                    <span><?php echo ucfirst($booking['bookingTheatre']); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span><?php echo $booking['bookingDate']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Time:</span>
                    <span><?php echo $booking['bookingTime']; ?></span>
                </div>
            </div>
        </div>

        <p>An email confirmation has been sent to <?php echo $booking['bookingEmail']; ?></p>

        <div class="button-group">
            <a href="view_ticket.php?order_id=<?php echo $booking['ORDERID']; ?>" class="btn btn-ticket">View Ticket</a>
            <a href="index.php" class="btn btn-home">Back to Home</a>
        </div>
    </div>
</body>
</html> 