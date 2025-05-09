<?php
include "connection.php";

echo "<h2>Movie Tabs Alignment Fix</h2>";

// Read the index.php file
$index_file = file_get_contents('index.php');

if ($index_file === false) {
    die("Error reading index.php file");
}

// Update the CSS with improved tab alignment
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
    justify-content: space-between;
    gap: 1rem;
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
    margin: 0.5rem 0;
}

.book-now-btn {
    display: inline-block;
    background: #4CAF50;
    color: white;
    padding: 0.8rem 1.5rem;
    border-radius: 6px;
    text-decoration: none;
    text-align: center;
    font-weight: 500;
    transition: background-color 0.3s ease;
    border: none;
    cursor: pointer;
    width: 100%;
    margin-top: auto;
}

.book-now-btn:hover {
    background: #45a049;
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

    .book-now-btn {
        padding: 0.7rem 1.2rem;
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
    margin-top: 0.75rem;
}
</style>';

// Add the new CSS before </head>
$index_file = preg_replace('/<style>.*?<\/style>/s', $css, $index_file);

// Save the changes
if (file_put_contents('index.php', $index_file)) {
    echo "<p>✅ Successfully updated the movie tabs alignment.</p>";
} else {
    echo "<p>❌ Error writing to index.php file.</p>";
}

echo "<h3>Key Changes Made:</h3>";
echo "<ol>";
echo "<li>Standardized card sizes and spacing</li>";
echo "<li>Added consistent padding and margins</li>";
echo "<li>Improved grid layout with equal height cards</li>";
echo "<li>Enhanced responsive design for better mobile display</li>";
echo "<li>Added smooth hover effects and transitions</li>";
echo "<li>Implemented proper vertical alignment of content</li>";
echo "</ol>";

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Clear your browser cache (press Ctrl+F5)</li>";
echo "<li>Open the homepage</li>";
echo "<li>Check if all movie cards are properly aligned</li>";
echo "<li>Verify spacing between cards is consistent</li>";
echo "<li>Test responsiveness on different screen sizes</li>";
echo "</ol>";

echo "<p><a href='index.php' style='display: inline-block; padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>Go to Homepage</a></p>";
?> 