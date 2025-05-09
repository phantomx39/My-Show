<?php
include "connection.php";

echo "<h2>Button Alignment Fix</h2>";

// Read the index.php file
$index_file = file_get_contents('index.php');

if ($index_file === false) {
    die("Error reading index.php file");
}

// Update the CSS with improved button alignment
$css = '
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
</style>';

// Add the new CSS before </head>
$index_file = preg_replace('/<style>.*?<\/style>/s', $css, $index_file);

// Save the changes
if (file_put_contents('index.php', $index_file)) {
    echo "<p>✅ Successfully updated the button alignment.</p>";
} else {
    echo "<p>❌ Error writing to index.php file.</p>";
}

echo "<h3>Key Changes Made:</h3>";
echo "<ol>";
echo "<li>Positioned buttons absolutely at the bottom of cards</li>";
echo "<li>Standardized button height and padding</li>";
echo "<li>Added proper spacing above buttons</li>";
echo "<li>Improved button hover effects</li>";
echo "<li>Enhanced button text alignment</li>";
echo "<li>Made buttons flush with card bottom corners</li>";
echo "</ol>";

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Clear your browser cache (press Ctrl+F5)</li>";
echo "<li>Open the homepage</li>";
echo "<li>Verify all Book Now buttons are perfectly aligned</li>";
echo "<li>Check button spacing and hover effects</li>";
echo "<li>Test on different screen sizes</li>";
echo "</ol>";

echo "<p><a href='index.php' style='display: inline-block; padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>Go to Homepage</a></p>";
?> 