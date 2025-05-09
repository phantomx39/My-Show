<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    
    $query = "SELECT bookingID, bookingPNumber, bookingFName FROM bookingtable WHERE bookingPNumber = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $phone);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['user_id'] = $row['bookingID'];
        $_SESSION['phone'] = $row['bookingPNumber'];
        $_SESSION['name'] = $row['bookingFName'];
        header("Location: my_bookings.php");
        exit();
    } else {
        $error = "No bookings found with this phone number";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - My Show</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;800&family=Cormorant+Garamond:wght@400;500;600&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/styles_new.css">
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <a href="index.php">My Show</a>
        </div>
        <div class="nav-links">
            <a href="index.php"><i class="fas fa-home"></i><span>Home</span></a>
        </div>
    </div>

    <div class="login-container">
        <div class="login-box">
            <h2><i class="fas fa-ticket-alt"></i> View My Bookings</h2>
            <?php if($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> Phone Number</label>
                    <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" placeholder="Enter your phone number" required>
                    <small style="color: var(--dark-gray);">Enter the phone number you used while booking</small>
                </div>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-search"></i> Find My Bookings
                </button>
            </form>
        </div>
    </div>
</body>
</html> 