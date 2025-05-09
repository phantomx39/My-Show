<?php
session_start();
require_once 'connection.php';

if (!isset($_SESSION['phone'])) {
    header("Location: login.php");
    exit();
}

$phone = $_SESSION['phone'];
$query = "SELECT b.*, m.movieTitle, m.movieImg 
          FROM bookingtable b 
          LEFT JOIN movietable m ON b.movieID = m.movieID 
          WHERE b.bookingPNumber = ?
          ORDER BY b.`DATE-TIME` DESC";

$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "s", $phone);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Bookings - My Show</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="style/styles_new.css">
</head>

<body>
    <section class="brand-heading">
        <div class="brand-content">
            <span class="brand-decoration">★</span>
            <h1>My <span class="show-text">Show</span></h1>
            <span class="brand-decoration">★</span>
        </div>
        <div class="brand-subtitle">Your Premier Movie Destination</div>
        <div class="brand-accent"></div>
    </section>

    <nav class="navbar">
        <div class="nav-links">
            <a href="index.php"><i class="fas fa-home"></i><span>Home</span></a>
            <a href="index.php#movies"><i class="fas fa-film"></i><span>Movies</span></a>
            <a href="my_bookings.php" class="active"><i class="fas fa-ticket-alt"></i><span>My Bookings</span></a>
        </div>
    </nav>

    <main class="bookings-page">
        <div class="bookings-section">
            <h1>My Bookings</h1>
            
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="bookings-container">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($booking = mysqli_fetch_assoc($result)): ?>
                        <div class="booking-card">
                            <div class="booking-poster">
                                <img src="<?php echo $booking['movieImg']; ?>" alt="<?php echo $booking['movieTitle']; ?>">
                            </div>
                            <div class="booking-details">
                                <div class="booking-header">
                                    <div class="ticket-number">
                                        <span class="label">Ticket #</span>
                                        <span class="number"><?php echo str_pad($booking['bookingID'], 6, '0', STR_PAD_LEFT); ?></span>
                                    </div>
                                    <div class="booking-id">
                                        <span class="label">Booking ID:</span>
                                        <span class="number"><?php echo $booking['ORDERID']; ?></span>
                                    </div>
                                </div>
                                <h3><?php echo $booking['movieTitle']; ?></h3>
                                <div class="booking-info">
                                    <div class="date-time">
                                        <i class="fas fa-calendar"></i>
                                        <span class="date"><?php echo $booking['bookingDate']; ?></span>
                                    </div>
                                    <div class="date-time">
                                        <i class="fas fa-clock"></i>
                                        <span class="time"><?php echo $booking['bookingTime']; ?></span>
                                    </div>
                                    <div class="date-time">
                                        <i class="fas fa-film"></i>
                                        <span><?php echo ucfirst($booking['bookingTheatre']); ?></span>
                                    </div>
                                    <div class="date-time">
                                        <i class="fas fa-ticket-alt"></i>
                                        <span><?php echo strtoupper($booking['bookingType']); ?></span>
                                    </div>
                                </div>
                                <div class="booking-status">
                                    <p class="booking-date">Booked on: <?php echo date('d M Y, h:i A', strtotime($booking['DATE-TIME'])); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-bookings">
                        <i class="fas fa-ticket-alt"></i>
                        <h3>No Bookings Found</h3>
                        <p>You haven't made any bookings yet.</p>
                        <a href="index.php#movies" class="book-now-btn">Book Now</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>My Show</h3>
                <p>Your ultimate destination for movie tickets booking</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php#movies">Movies</a></li>
                    <li><a href="my_bookings.php">My Bookings</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Connect With Us</h3>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 My Show. All rights reserved.</p>
        </div>
    </footer>
</body>
</html> 