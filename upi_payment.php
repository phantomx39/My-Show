<?php
session_start();
if (!isset($_SESSION['qr_filename'])) {
    header("Location: booking.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPI Payment</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
    <div class="payment-container">
        <h1>Complete Your Payment</h1>
        <div class="payment-details">
            <p>Order ID: <?php echo $_SESSION['order_id']; ?></p>
            <p>Amount: ₹<?php echo $_SESSION['amount']; ?></p>
        </div>
        
        <div class="qr-container">
            <h2>Scan QR Code to Pay</h2>
            <img src="<?php echo $_SESSION['qr_filename']; ?>" alt="UPI Payment QR Code">
            <p>Scan this QR code using any UPI app to complete your payment</p>
        </div>
        
        <div class="payment-status">
            <p>Payment Status: <span id="payment-status">Pending</span></p>
            <button onclick="checkPaymentStatus()">Check Payment Status</button>
        </div>
    </div>

    <script>
        function checkPaymentStatus() {
            // In a real implementation, you would make an AJAX call to check payment status
            // For demo purposes, we'll simulate a successful payment after 5 seconds
            setTimeout(() => {
                document.getElementById('payment-status').textContent = 'Completed';
                window.location.href = 'reciept.php?order_id=<?php echo $_SESSION['order_id']; ?>';
            }, 5000);
        }
    </script>
</body>
</html> 