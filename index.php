<?php 
session_start();
include "connection.php";

// Check database connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM movieTable";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Show - Book Movie Tickets</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700;800;900&family=Cormorant+Garamond:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;800&family=Cormorant+Garamond:wght@400;500;600&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/styles_new.css">
    





<style>
.movies-section {
    padding: 4rem 2rem;
    background: linear-gradient(to right, rgba(44, 62, 80, 0.95), rgba(52, 152, 219, 0.95));
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.movies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    max-width: 1400px;
    width: 100%;
    margin: 0 auto;
    padding: 2rem;
}

.movie-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
    backdrop-filter: blur(5px);
    position: relative;
    padding-bottom: 70px; /* Space for button */
}

.movie-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
}

.movie-poster {
    width: 100%;
    aspect-ratio: 16/9;
    object-fit: cover;
    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
}

.movie-info {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.movie-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: white;
    margin: 0;
    text-align: center;
    line-height: 1.3;
}

.movie-genre {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1rem;
    text-align: center;
    margin: 0;
}

.book-now-btn {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    display: block;
    background: #4CAF50;
    color: white;
    padding: 1rem;
    text-decoration: none;
    text-align: center;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    margin: 0;
    width: 100%;
    border-radius: 0 0 12px 12px;
    font-size: 1.1rem;
    letter-spacing: 0.5px;
}

.book-now-btn:hover {
    background: #45a049;
    padding-top: 1.2rem;
}

/* Add icon alignment */
.book-now-btn i {
    margin-right: 8px;
    font-size: 1.1em;
    vertical-align: middle;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .movies-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        padding: 1rem;
    }

    .movies-section {
        padding: 2rem 1rem;
    }

    .movie-title {
        font-size: 1.25rem;
    }

    .movie-genre {
        font-size: 0.9rem;
    }

    .movie-card {
        padding-bottom: 60px; /* Slightly smaller for mobile */
    }

    .book-now-btn {
        padding: 0.8rem;
        font-size: 1rem;
    }
}

/* Equal height cards */
.movies-grid {
    align-items: stretch;
}

.movie-card {
    height: 100%;
}

/* Ensure consistent spacing */
.movie-info > * {
    margin: 0;
}

.movie-info > * + * {
    margin-top: 0.5rem;
}
</style>







<style>
.movies-section {
    padding: 4rem 2rem;
    background: linear-gradient(to right, rgba(44, 62, 80, 0.95), rgba(52, 152, 219, 0.95));
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.movies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    max-width: 1400px;
    width: 100%;
    margin: 0 auto;
    padding: 2rem;
}

.movie-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
    backdrop-filter: blur(5px);
    position: relative;
    padding-bottom: 70px; /* Space for button */
}

.movie-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
}

.movie-poster {
    width: 100%;
    aspect-ratio: 16/9;
    object-fit: cover;
    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
}

.movie-info {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.movie-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: white;
    margin: 0;
    text-align: center;
    line-height: 1.3;
}

.movie-genre {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1rem;
    text-align: center;
    margin: 0;
}

.book-now-btn {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    display: block;
    background: #4CAF50;
    color: white;
    padding: 1rem;
    text-decoration: none;
    text-align: center;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    margin: 0;
    width: 100%;
    border-radius: 0 0 12px 12px;
    font-size: 1.1rem;
    letter-spacing: 0.5px;
}

.book-now-btn:hover {
    background: #45a049;
    padding-top: 1.2rem;
}

/* Add icon alignment */
.book-now-btn i {
    margin-right: 8px;
    font-size: 1.1em;
    vertical-align: middle;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .movies-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        padding: 1rem;
    }

    .movies-section {
        padding: 2rem 1rem;
    }

    .movie-title {
        font-size: 1.25rem;
    }

    .movie-genre {
        font-size: 0.9rem;
    }

    .movie-card {
        padding-bottom: 60px; /* Slightly smaller for mobile */
    }

    .book-now-btn {
        padding: 0.8rem;
        font-size: 1rem;
    }
}

/* Equal height cards */
.movies-grid {
    align-items: stretch;
}

.movie-card {
    height: 100%;
}

/* Ensure consistent spacing */
.movie-info > * {
    margin: 0;
}

.movie-info > * + * {
    margin-top: 0.5rem;
}
</style>






<style>
.movies-section {
    padding: 4rem 2rem;
    background: linear-gradient(to right, rgba(44, 62, 80, 0.95), rgba(52, 152, 219, 0.95));
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.movies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    max-width: 1400px;
    width: 100%;
    margin: 0 auto;
    padding: 2rem;
}

.movie-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
    backdrop-filter: blur(5px);
    position: relative;
    padding-bottom: 70px; /* Space for button */
}

.movie-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
}

.movie-poster {
    width: 100%;
    aspect-ratio: 16/9;
    object-fit: cover;
    border-bottom: 2px solid rgba(255, 255, 255, 0.1);
}

.movie-info {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.movie-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: white;
    margin: 0;
    text-align: center;
    line-height: 1.3;
}

.movie-genre {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1rem;
    text-align: center;
    margin: 0;
}

.book-now-btn {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    display: block;
    background: #4CAF50;
    color: white;
    padding: 1rem;
    text-decoration: none;
    text-align: center;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    margin: 0;
    width: 100%;
    border-radius: 0 0 12px 12px;
    font-size: 1.1rem;
    letter-spacing: 0.5px;
}

.book-now-btn:hover {
    background: #45a049;
    padding-top: 1.2rem;
}

/* Add icon alignment */
.book-now-btn i {
    margin-right: 8px;
    font-size: 1.1em;
    vertical-align: middle;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .movies-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        padding: 1rem;
    }

    .movies-section {
        padding: 2rem 1rem;
    }

    .movie-title {
        font-size: 1.25rem;
    }

    .movie-genre {
        font-size: 0.9rem;
    }

    .movie-card {
        padding-bottom: 60px; /* Slightly smaller for mobile */
    }

    .book-now-btn {
        padding: 0.8rem;
        font-size: 1rem;
    }
}

/* Equal height cards */
.movies-grid {
    align-items: stretch;
}

.movie-card {
    height: 100%;
}

/* Ensure consistent spacing */
.movie-info > * {
    margin: 0;
}

.movie-info > * + * {
    margin-top: 0.5rem;
}
</style></head>

<body>
    <section class="brand-heading">
        <div class="brand-content">
            <div class="brand-left">
                <h1>My <span class="show-text">Show</span></h1>
            </div>
            <nav class="navbar">
                <div class="nav-links">
                    <a href="index.php" class="active"><i class="fas fa-home"></i><span>Home</span></a>
                    <a href="movies.php"><i class="fas fa-film"></i><span>Movies</span></a>
                    <a href="my_bookings.php"><i class="fas fa-ticket-alt"></i><span>My Bookings</span></a>
                </div>
            </nav>
        </div>
        <p class="brand-subtitle">Your Premier Movie Destination</p>
    </section>

    <main>
        <section id="movies" class="movie-show-container">
            <h1>Now Showing</h1>
            <h3>Book your favorite movie today</h3>

            <div class="movies-container">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)) {
                        // Debug information
                        echo '<!-- Debug: Image path = ' . $row['movieImg'] . ' -->';
                        
                        echo '<div class="movie-box">';
                        echo '<div class="movie-poster">';
                        
                        // Check if file exists
                        $imagePath = $row['movieImg'];
                        if (!file_exists($imagePath)) {
                            echo '<!-- Debug: Image file not found at ' . $imagePath . ' -->';
                            // Try with and without the leading slash
                            $altPath = ltrim($imagePath, '/');
                            if (file_exists($altPath)) {
                                $imagePath = $altPath;
                            }
                        }
                        
                        echo '<img src="' . $imagePath . '" alt="' . $row['movieTitle'] . '" onerror="this.src=\'img/movie-poster-1.jpg\'">';
                        echo '<div class="movie-overlay">';
                        echo '<span class="rating"><i class="fas fa-star"></i> 7.1</span>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="movie-info">';
                        echo '<h3>' . $row['movieTitle'] . '</h3>';
                        echo '<p class="genre">' . $row['movieGenre'] . '</p>';
                        echo '<a href="booking.php?id=' . $row['movieID'] . '" class="book-btn"><i class="fas fa-ticket-alt"></i> Book Now</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                    mysqli_free_result($result);
                } else {
                    echo '<div class="no-movies"><p>No movies available at the moment</p></div>';
                }
                mysqli_close($con);
                ?>
            </div>
        </section>

        <section class="services-section">
            <h1>How It Works</h1>
            <h3>Book your movie in 3 simple steps</h3>

            <div class="services-container">
                <div class="service-item">
                    <div class="service-item-icon">
                        <i class="fas fa-4x fa-film"></i>
                    </div>
                    <h2>1. Choose Movie</h2>
                    <p>Browse our vast selection of latest movies</p>
                </div>
                <div class="service-item">
                    <div class="service-item-icon">
                        <i class="fas fa-4x fa-couch"></i>
                    </div>
                    <h2>2. Select Seats</h2>
                    <p>Pick your favorite seats in the theater</p>
                </div>
                <div class="service-item">
                    <div class="service-item-icon">
                        <i class="fas fa-4x fa-ticket-alt"></i>
                    </div>
                    <h2>3. Get Tickets</h2>
                    <p>Secure your tickets and enjoy the show</p>
                </div>
            </div>
        </section>

        <section class="trailers-section">
            <h1>Latest Trailers</h1>
            <h3>Watch the latest movie trailers</h3>
            
            <div class="trailers-grid">
                <?php
                // Reopen database connection since it was closed earlier
                include "connection.php";
                if (!$con) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // First check if trailerUrl column exists
                $check_column = "SHOW COLUMNS FROM movieTable LIKE 'trailerUrl'";
                $column_exists = mysqli_query($con, $check_column);
                
                if (mysqli_num_rows($column_exists) == 0) {
                    echo '<div class="no-trailers"><p>Please run the database migration script (database/add_trailer_url.sql) to enable movie trailers.</p></div>';
                } else {
                    $trailer_sql = "SELECT movieTitle, movieImg, trailerUrl FROM movieTable WHERE trailerUrl IS NOT NULL AND trailerUrl != '' ORDER BY movieID DESC LIMIT 6";
                    $trailer_result = mysqli_query($con, $trailer_sql);

                    if (!$trailer_result) {
                        echo '<div class="no-trailers"><p>Error loading trailers: ' . mysqli_error($con) . '</p></div>';
                    } else if (mysqli_num_rows($trailer_result) > 0) {
                        while($trailer = mysqli_fetch_array($trailer_result)) {
                            $videoId = '';
                            if (!empty($trailer['trailerUrl'])) {
                                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $trailer['trailerUrl'], $matches)) {
                                    $videoId = $matches[1];
                                }
                            }

                            if (!empty($videoId)) {
                                echo '<div class="trailers-grid-item">';
                                echo '<div class="video-thumbnail" data-video-id="' . htmlspecialchars($videoId) . '">';
                                $thumbnailUrl = "https://img.youtube.com/vi/" . htmlspecialchars($videoId) . "/maxresdefault.jpg";
                                echo '<img src="' . $thumbnailUrl . '" alt="' . htmlspecialchars($trailer['movieTitle']) . '">';
                                echo '<div class="trailer-item-info">';
                                echo '<h3>' . htmlspecialchars($trailer['movieTitle']) . '</h3>';
                                echo '<i class="far fa-3x fa-play-circle"></i>';
                                echo '</div>';
                                echo '<div class="video-container"></div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    } else {
                        echo '<div class="no-trailers"><p>No trailers available at the moment</p></div>';
                    }
                    mysqli_free_result($trailer_result);
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
                    <li><a href="#">Movies</a></li>
                    <li><a href="#">Cinemas</a></li>
                    <li><a href="#">Upcoming</a></li>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="scripts/script.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    const thumbnails = document.querySelectorAll(".video-thumbnail");
    console.log("[Debug] Found", thumbnails.length, "video thumbnails");
    
    function createYouTubePlayer(videoId, container) {
        console.log("[Debug] Creating player for video ID:", videoId);
        
        // Clear any existing content
        container.innerHTML = "";
        
        // Create wrapper for precise positioning
        const wrapper = document.createElement("div");
        wrapper.className = "video-wrapper";
        
        // Create iframe with exact dimensions
        const iframe = document.createElement("iframe");
        iframe.className = "trailer-video";
        iframe.setAttribute("src", `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&showinfo=0&enablejsapi=1`);
        iframe.setAttribute("frameborder", "0");
        iframe.setAttribute("allow", "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture");
        iframe.setAttribute("allowfullscreen", "true");
        
        // Force iframe to take full size of container
        iframe.style.width = "100%";
        iframe.style.height = "100%";
        iframe.style.transform = "translateY(0)";  // Ensure no transform is applied
        
        wrapper.appendChild(iframe);
        container.appendChild(wrapper);
        
        // Log dimensions for debugging
        console.log("[Debug] Container and iframe dimensions:", {
            container: {
                width: container.offsetWidth,
                height: container.offsetHeight,
                top: container.offsetTop
            },
            wrapper: {
                width: wrapper.offsetWidth,
                height: wrapper.offsetHeight,
                top: wrapper.offsetTop
            },
            iframe: {
                width: iframe.offsetWidth,
                height: iframe.offsetHeight,
                top: iframe.offsetTop
            }
        });
        
        return iframe;
    }
    
    thumbnails.forEach((thumbnail, index) => {
        const videoId = thumbnail.getAttribute("data-video-id");
        const container = thumbnail.querySelector(".video-container");
        
        thumbnail.addEventListener("click", function(e) {
            e.preventDefault();
            console.log(`[Debug] Clicked thumbnail ${index + 1}`);
            
            if (this.classList.contains("playing")) {
                console.log("[Debug] Stopping video");
                this.classList.remove("playing");
                setTimeout(() => {
                    container.innerHTML = "";
                }, 300);
            } else {
                console.log("[Debug] Starting video");
                
                // Stop other videos
                thumbnails.forEach(other => {
                    if (other !== this && other.classList.contains("playing")) {
                        other.classList.remove("playing");
                        const otherContainer = other.querySelector(".video-container");
                        setTimeout(() => {
                            otherContainer.innerHTML = "";
                        }, 300);
                    }
                });
                
                // Create new video
                const iframe = createYouTubePlayer(videoId, container);
                this.classList.add("playing");
                
                // Additional check for dimensions and position after a short delay
                setTimeout(() => {
                    const computedStyle = window.getComputedStyle(iframe);
                    console.log("[Debug] Final iframe computed style:", {
                        width: computedStyle.width,
                        height: computedStyle.height,
                        position: computedStyle.position,
                        top: computedStyle.top,
                        transform: computedStyle.transform
                    });
                }, 100);
            }
        });
    });
});
</script>
</body>

</html>