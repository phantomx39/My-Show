<?php
session_start();
include "connection.php";

if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = $_GET['order_id'];
$query = "SELECT b.*, m.* FROM bookingTable b 
          JOIN movieTable m ON b.movieID = m.movieID 
          WHERE b.ORDERID = '$order_id'";
$result = mysqli_query($con, $query);
$booking = mysqli_fetch_assoc($result);

// Generate a ticket number
$ticketNumber = 'TKT' . rand(100000, 999999);

// Assign hall number based on theatre type
$hallNumber = '';
switch ($booking['bookingTheatre']) {
    case 'main-hall':
        $hallNumber = 'H1-' . rand(1, 5);
        break;
    case 'vip-hall':
        $hallNumber = 'VIP-' . rand(1, 3);
        break;
    case 'private-hall':
        $hallNumber = 'PVT-' . rand(1, 2);
        break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Ticket</title>
    <link rel="stylesheet" href="style/styles.css">
    <style>
        body {
            background: #f0f2f5;
            font-family: 'Arial', sans-serif;
        }
        .ticket-container {
            max-width: 850px;
            margin: 50px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .ticket-header {
            background: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .ticket-body {
            display: flex;
            padding: 20px;
        }
        .ticket-left {
            flex: 2;
            padding: 20px;
            border-right: 2px dashed #ddd;
        }
        .ticket-right {
            flex: 1;
            padding: 20px;
            background: #f8f9fa;
        }
        .movie-title {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .ticket-info {
            margin: 15px 0;
        }
        .ticket-label {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .ticket-value {
            color: #2c3e50;
            font-size: 16px;
            font-weight: bold;
        }
        .ticket-number {
            font-size: 20px;
            color: #e74c3c;
            font-weight: bold;
            padding: 10px;
            border: 2px dashed #e74c3c;
            display: inline-block;
            margin: 10px 0;
        }
        .hall-number {
            font-size: 18px;
            color: #27ae60;
            font-weight: bold;
            margin: 10px 0;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            background: white;
            border-radius: 5px;
        }
        .qr-code img {
            max-width: 150px;
        }
        .actions {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-top: 1px solid #ddd;
        }
        .btn {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-print {
            background: #3498db;
            color: white;
        }
        .btn-home {
            background: #95a5a6;
            color: white;
        }
        .ticket-note {
            font-size: 12px;
            color: #666;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="ticket-header">
            <h1>Movie Ticket</h1>
        </div>
        <div class="ticket-body">
            <div class="ticket-left">
                <div class="movie-title"><?php echo $booking['movieTitle']; ?></div>
                
                <div class="ticket-info">
                    <div class="ticket-label">Date & Time</div>
                    <div class="ticket-value">
                        <?php echo $booking['bookingDate']; ?> at <?php echo $booking['bookingTime']; ?>
                    </div>
                </div>
                
                <div class="ticket-info">
                    <div class="ticket-label">Theatre Type</div>
                    <div class="ticket-value"><?php echo ucfirst($booking['bookingTheatre']); ?></div>
                </div>
                
                <div class="ticket-info">
                    <div class="ticket-label">Hall Number</div>
                    <div class="hall-number"><?php echo $hallNumber; ?></div>
                </div>
                
                <div class="ticket-info">
                    <div class="ticket-label">Ticket Number</div>
                    <div class="ticket-number"><?php echo $ticketNumber; ?></div>
                </div>
                
                <div class="ticket-info">
                    <div class="ticket-label">Customer Name</div>
                    <div class="ticket-value">
                        <?php echo $booking['bookingFName'] . " " . $booking['bookingLName']; ?>
                    </div>
                </div>
            </div>
            
            <div class="ticket-right">
                <div class="qr-code">
                    <!-- Simple ASCII QR Code representation -->
                    <pre style="font-size: 8px; line-height: 8px;">
<?php
for($i = 0; $i < 15; $i++) {
    for($j = 0; $j < 15; $j++) {
        echo rand(0, 1) ? "██" : "  ";
    }
    echo "\n";
}
?>
                    </pre>
                    <div class="ticket-label">Scan for verification</div>
                </div>
                
                <div class="ticket-info">
                    <div class="ticket-label">Order ID</div>
                    <div class="ticket-value"><?php echo $booking['ORDERID']; ?></div>
                </div>
                
                <div class="ticket-info">
                    <div class="ticket-label">Amount Paid</div>
                    <div class="ticket-value">₹<?php echo $booking['amount']; ?></div>
                </div>
            </div>
        </div>
        
        <div class="actions">
            <button onclick="window.print()" class="btn btn-print">Print Ticket</button>
            <a href="index.php" class="btn btn-home">Back to Home</a>
        </div>
        
        <div class="ticket-note">
            Please present this ticket at the cinema entrance. Valid ID may be required.
        </div>
    </div>
</body>
</html> 