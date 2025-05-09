<?php
session_start();
if (!isset($_SESSION['order_id'])) {
    header("Location: index.php");
    exit();
}

// Create a simple text representation of a QR code
function generateTextQR($size = 10) {
    $qr = '';
    for($i = 0; $i < $size; $i++) {
        for($j = 0; $j < $size; $j++) {
            $qr .= rand(0, 1) ? '██' : '  ';
        }
        $qr .= "\n";
    }
    return $qr;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Payment</title>
    <link rel="stylesheet" href="style/styles.css">
    <style>
        .payment-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        .payment-details {
            margin: 20px 0;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .qr-container {
            margin: 30px 0;
            background: #fff;
            padding: 20px;
            display: inline-block;
        }
        .qr-code {
            font-family: monospace;
            white-space: pre;
            font-size: 14px;
            line-height: 1;
            background: #fff;
            padding: 20px;
            margin: 20px auto;
            display: inline-block;
        }
        .timer {
            font-size: 24px;
            color: #e44d26;
            margin: 20px 0;
        }
        .btn {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px;
        }
        .btn:hover {
            background: #45a049;
        }
        .success-message {
            display: none;
            color: #4CAF50;
            font-size: 20px;
            margin: 20px 0;
        }
        .payment-status {
            font-size: 18px;
            margin: 20px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .payment-status.pending {
            background: #fff3cd;
            color: #856404;
        }
        .payment-status.success {
            background: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h1>Complete Your Payment</h1>
        
        <div class="payment-details">
            <h3>Payment Details</h3>
            <p><strong>Order ID:</strong> <?php echo $_SESSION['order_id']; ?></p>
            <p><strong>Amount:</strong> ₹<?php echo $_SESSION['amount']; ?></p>
            <p><strong>Name:</strong> <?php echo $_SESSION['name']; ?></p>
        </div>
        
        <div class="qr-container">
            <h3>Scan QR Code to Pay</h3>
            <div class="qr-code"><?php echo generateTextQR(); ?></div>
            <p>This is a demo QR code for visualization purposes</p>
        </div>
        
        <div class="payment-status pending" id="payment-status">
            Payment Status: Waiting for payment...
        </div>
        
        <div class="timer" id="timer">Time remaining: 5:00</div>
        
        <div id="payment-controls">
            <button class="btn" onclick="simulatePayment()">Complete Payment</button>
            <button class="btn" style="background: #dc3545;" onclick="cancelPayment()">Cancel</button>
        </div>
        
        <div id="success-message" class="success-message">
            <h2>✓ Payment Successful!</h2>
            <p>Redirecting to your ticket...</p>
        </div>
    </div>

    <script>
        // Timer functionality
        let timeLeft = 300; // 5 minutes in seconds
        const timerElement = document.getElementById('timer');
        const statusElement = document.getElementById('payment-status');
        
        const timer = setInterval(() => {
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `Time remaining: ${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft <= 0) {
                clearInterval(timer);
                cancelPayment();
            }
        }, 1000);

        // Simulate successful payment
        function simulatePayment() {
            document.getElementById('payment-controls').style.display = 'none';
            document.getElementById('success-message').style.display = 'block';
            statusElement.textContent = 'Payment Status: Payment Successful';
            statusElement.classList.remove('pending');
            statusElement.classList.add('success');
            clearInterval(timer);
            
            // Update payment status in database and redirect
            fetch('update_payment.php?order_id=<?php echo $_SESSION['order_id']; ?>&status=success')
                .then(() => {
                    setTimeout(() => {
                        window.location.href = 'payment_success.php';
                    }, 2000);
                });
        }

        // Cancel payment
        function cancelPayment() {
            fetch('update_payment.php?order_id=<?php echo $_SESSION['order_id']; ?>&status=cancelled')
                .then(() => {
                    window.location.href = 'index.php';
                });
        }
    </script>
</body>
</html> 