<?php 
session_start();
include "connection.php";
$sql = "SELECT * FROM movieTable";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movies - My Show</title>
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
            <div class="brand-left">
                <h1>My <span class="show-text">Show</span></h1>
            </div>
            <nav class="navbar">
                <div class="nav-links">
                    <a href="index.php"><i class="fas fa-home"></i><span>Home</span></a>
                    <a href="movies.php" class="active"><i class="fas fa-film"></i><span>Movies</span></a>
                    <a href="my_bookings.php"><i class="fas fa-ticket-alt"></i><span>My Bookings</span></a>
                </div>
            </nav>
        </div>
        <p class="brand-subtitle">Your Premier Movie Destination</p>
    </section>

    <main>
        <section class="movies-page">
            <h1>All Movies</h1>
            <div class="movies-grid">
                <?php
                if ($result = mysqli_query($con, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<div class="movie-card">';
                            echo '<div class="movie-poster">';
                            echo '<img src="' . $row['movieImg'] . '" alt="' . $row['movieTitle'] . '">';
                            echo '<div class="movie-overlay">';
                            echo '<div class="movie-details">';
                            echo '<h3>' . $row['movieTitle'] . '</h3>';
                            echo '<p class="genre">' . $row['movieGenre'] . '</p>';
                            echo '<p class="duration"><i class="far fa-clock"></i> ' . $row['movieDuration'] . '</p>';
                            echo '<p class="release"><i class="far fa-calendar-alt"></i> ' . $row['movieRelDate'] . '</p>';
                            echo '<a href="booking.php?id=' . $row['movieID'] . '" class="book-now">Book Now</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                        mysqli_free_result($result);
                    } else {
                        echo '<div class="no-movies">';
                        echo '<p>No movies available at the moment.</p>';
                        echo '</div>';
                    }
                } else {
                    echo "ERROR: Could not execute $sql. " . mysqli_error($con);
                }
                mysqli_close($con);
                ?>
            </div>
        </section>
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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="movies.php">Movies</a></li>
                    <li><a href="my_bookings.php">My Bookings</a></li>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="scripts/script.js"></script>
</body>

</html> 