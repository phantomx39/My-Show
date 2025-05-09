<?php
include "connection.php";

// Check database connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "<h2>Comprehensive Trailer Fix</h2>";

// Step 1: Check and fix database
echo "<h3>Step 1: Database Check</h3>";

// Check if trailerUrl column exists
$check_column = "SHOW COLUMNS FROM movieTable LIKE 'trailerUrl'";
$column_exists = mysqli_query($con, $check_column);

if (mysqli_num_rows($column_exists) == 0) {
    echo "<p>trailerUrl column does NOT exist in movieTable. Adding it now...</p>";
    
    // Add trailerUrl column
    $add_column = "ALTER TABLE `movieTable` ADD COLUMN `trailerUrl` varchar(255) DEFAULT NULL AFTER `movieActors`";
    if (mysqli_query($con, $add_column)) {
        echo "<p>Successfully added trailerUrl column to movieTable.</p>";
        
        // Update existing movies with sample trailer URLs
        $update_movies = "UPDATE `movieTable` SET 
            `trailerUrl` = 'https://www.youtube.com/watch?v=Z1BCujX3pw8' WHERE `movieID` = 1,
            `trailerUrl` = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ' WHERE `movieID` = 2,
            `trailerUrl` = 'https://www.youtube.com/watch?v=fZ_JOBCLF-I' WHERE `movieID` = 3,
            `trailerUrl` = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ' WHERE `movieID` = 4,
            `trailerUrl` = 'https://www.youtube.com/watch?v=g09a9laLh0k' WHERE `movieID` = 5,
            `trailerUrl` = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ' WHERE `movieID` = 6";
        
        if (mysqli_query($con, $update_movies)) {
            echo "<p>Successfully updated movies with sample trailer URLs.</p>";
        } else {
            echo "<p>Error updating movies with trailer URLs: " . mysqli_error($con) . "</p>";
        }
    } else {
        echo "<p>Error adding trailerUrl column: " . mysqli_error($con) . "</p>";
    }
} else {
    echo "<p>trailerUrl column already exists in movieTable.</p>";
    
    // Check if there are any trailer URLs in the database
    $trailer_sql = "SELECT movieID, movieTitle, trailerUrl FROM movieTable WHERE trailerUrl IS NOT NULL AND trailerUrl != ''";
    $trailer_result = mysqli_query($con, $trailer_sql);
    
    if (!$trailer_result) {
        echo "<p>Error querying trailers: " . mysqli_error($con) . "</p>";
    } else if (mysqli_num_rows($trailer_result) > 0) {
        echo "<p>Found " . mysqli_num_rows($trailer_result) . " movies with trailer URLs.</p>";
    } else {
        echo "<p>No movies with trailer URLs found. Adding sample URLs...</p>";
        
        // Update existing movies with sample trailer URLs
        $update_movies = "UPDATE `movieTable` SET 
            `trailerUrl` = 'https://www.youtube.com/watch?v=Z1BCujX3pw8' WHERE `movieID` = 1,
            `trailerUrl` = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ' WHERE `movieID` = 2,
            `trailerUrl` = 'https://www.youtube.com/watch?v=fZ_JOBCLF-I' WHERE `movieID` = 3,
            `trailerUrl` = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ' WHERE `movieID` = 4,
            `trailerUrl` = 'https://www.youtube.com/watch?v=g09a9laLh0k' WHERE `movieID` = 5,
            `trailerUrl` = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ' WHERE `movieID` = 6";
        
        if (mysqli_query($con, $update_movies)) {
            echo "<p>Successfully updated movies with sample trailer URLs.</p>";
        } else {
            echo "<p>Error updating movies with trailer URLs: " . mysqli_error($con) . "</p>";
        }
    }
}

// Step 2: Fix CSS
echo "<h3>Step 2: CSS Fix</h3>";

// Read the styles_new.css file
$css_file = file_get_contents('style/styles_new.css');

if ($css_file === false) {
    echo "<p>Error reading styles_new.css file</p>";
} else {
    // Find the CSS section for trailers
    $css_start = strpos($css_file, '.trailers-section {');

    if ($css_start === false) {
        echo "<p>Could not find the CSS section for trailers in styles_new.css</p>";
    } else {
        // Find the end of the trailers section (look for the next section)
        $css_end = strpos($css_file, '.site-footer {', $css_start);

        if ($css_end === false) {
            echo "<p>Could not find the end of the trailers section in styles_new.css</p>";
        } else {
            // Extract the current CSS
            $current_css = substr($css_file, $css_start, $css_end - $css_start);

            // Create the fixed CSS
            $fixed_css = '.trailers-section {
    padding: 4rem 2rem;
    background: linear-gradient(to right, rgba(44, 62, 80, 0.9), rgba(52, 152, 219, 0.9));
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    color: white;
    text-align: center;
}

.trailers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    max-width: 1400px;
    margin: 3rem auto;
}

.trailers-grid-item {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    border: 1px solid var(--glass-border);
    box-shadow: var(--glass-shadow);
    aspect-ratio: 16/9;
    height: 200px;
}

.trailers-grid-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.trailers-grid-item:hover img {
    transform: scale(1.05);
}

.trailer-item-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1.5rem;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.7) 50%, transparent 100%);
    color: white;
    transform: translateY(0);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    z-index: 2;
}

.trailer-item-info h3 {
    font-size: 1.1rem;
    margin: 0;
    font-weight: 600;
}

.trailer-item-info p {
    font-size: 0.9rem;
    opacity: 0.9;
    margin: 0;
}

.trailer-item-info i {
    color: rgba(255, 255, 255, 0.9);
    transition: transform 0.3s ease, color 0.3s ease;
}

.trailers-grid-item:hover .trailer-item-info i {
    transform: scale(1.1);
    color: var(--accent-color);
}

.trailer-video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
    z-index: 1;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.video-thumbnail.playing .trailer-video {
    opacity: 1;
    z-index: 3;
}

.video-thumbnail.playing img,
.video-thumbnail.playing .trailer-item-info {
    opacity: 0;
    pointer-events: none;
}

.no-trailers {
    padding: 2rem;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    margin: 2rem auto;
    max-width: 600px;
}

.no-trailers p {
    color: white;
    font-size: 1.1rem;
    margin: 0;
}
';

            // Replace the current CSS with the fixed version
            $new_css_file = str_replace($current_css, $fixed_css, $css_file);

            // Write the updated file
            if (file_put_contents('style/styles_new.css', $new_css_file) === false) {
                echo "<p>Error writing to styles_new.css file</p>";
            } else {
                echo "<p>Successfully updated the CSS for the trailer section</p>";
            }
        }
    }
}

// Step 3: Fix JavaScript
echo "<h3>Step 3: JavaScript Fix</h3>";

// Read the index.php file
$index_file = file_get_contents('index.php');

if ($index_file === false) {
    echo "<p>Error reading index.php file</p>";
} else {
    // Find the JavaScript section for trailers
    $js_start = strpos($index_file, '<script>
        document.addEventListener(\'DOMContentLoaded\', function() {
            const thumbnails = document.querySelectorAll(\'.video-thumbnail\');');

    if ($js_start === false) {
        echo "<p>Could not find the JavaScript section for trailers in index.php</p>";
    } else {
        // Find the end of the script tag
        $js_end = strpos($index_file, '</script>', $js_start);

        if ($js_end === false) {
            echo "<p>Could not find the end of the script tag</p>";
        } else {
            // Extract the current JavaScript
            $current_js = substr($index_file, $js_start, $js_end - $js_start);

            // Create the fixed JavaScript
            $fixed_js = '<script>
        document.addEventListener(\'DOMContentLoaded\', function() {
            const thumbnails = document.querySelectorAll(\'.video-thumbnail\');
            
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener(\'click\', function(e) {
                    e.preventDefault();
                    const iframe = this.querySelector(\'.trailer-video\');
                    const videoId = iframe.getAttribute(\'data-video-id\');
                    
                    // If already playing, stop the video
                    if (this.classList.contains(\'playing\')) {
                        this.classList.remove(\'playing\');
                        iframe.src = \'\';
                    } else {
                        // Stop any other playing videos
                        thumbnails.forEach(otherThumbnail => {
                            if (otherThumbnail.classList.contains(\'playing\')) {
                                const otherIframe = otherThumbnail.querySelector(\'.trailer-video\');
                                otherThumbnail.classList.remove(\'playing\');
                                otherIframe.src = \'\';
                            }
                        });
                        
                        // Start playing the new video
                        iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&showinfo=0`;
                        this.classList.add(\'playing\');
                    }
                });
            });
            
            // Debug information
            console.log("Trailer thumbnails found:", thumbnails.length);
            thumbnails.forEach((thumbnail, index) => {
                const videoId = thumbnail.querySelector(\'.trailer-video\').getAttribute(\'data-video-id\');
                console.log(`Thumbnail ${index + 1}: Video ID = ${videoId}`);
            });
        });
    </script>';

            // Replace the current JavaScript with the fixed version
            $new_index_file = str_replace($current_js, $fixed_js, $index_file);

            // Write the updated file
            if (file_put_contents('index.php', $new_index_file) === false) {
                echo "<p>Error writing to index.php file</p>";
            } else {
                echo "<p>Successfully updated the JavaScript for the trailer section</p>";
            }
        }
    }
}

echo "<h3>All Fixes Applied</h3>";
echo "<p>The following fixes have been applied:</p>";
echo "<ol>";
echo "<li>Database: Added trailerUrl column and sample URLs if needed</li>";
echo "<li>CSS: Updated the styling for the trailer section</li>";
echo "<li>JavaScript: Fixed the video playback functionality</li>";
echo "</ol>";
echo "<p>Please check the browser console (F12) for debugging information when you load the homepage.</p>";
echo "<p><a href='index.php'>Return to Homepage</a></p>";

mysqli_close($con);
?> 