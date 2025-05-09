<?php
include "connection.php";

echo "<h2>Movie Ratings Update - Final Version</h2>";

// Read the index.php file
$index_file = file_get_contents('index.php');

if ($index_file === false) {
    die("Error reading index.php file");
}

// Function to generate a random rating between 7.0 and 10.0
function generateRandomRating() {
    // Generate random number between 70 and 100
    $rating = rand(70, 100) / 10;
    // Format to one decimal place
    return number_format($rating, 1);
}

// Find and replace the rating in the echo statement
$pattern = '/echo \'<span class="rating"><i class="fas fa-star"><\/i> \d+\.\d+<\/span>\';/';
$count = 0;

$index_file = preg_replace_callback($pattern, function($matches) use (&$count) {
    $rating = generateRandomRating();
    $count++;
    return 'echo \'<span class="rating"><i class="fas fa-star"></i> ' . $rating . '</span>\';';
}, $index_file);

// Save the changes
if (file_put_contents('index.php', $index_file)) {
    echo "<p>✅ Successfully updated all movie ratings.</p>";
    echo "<p>Updated $count movie ratings with random values between 7.0 and 10.0</p>";
} else {
    echo "<p>❌ Error writing to index.php file.</p>";
}

// Display the new ratings
preg_match_all('/echo \'<span class="rating"><i class="fas fa-star"><\/i> ([0-9.]+)<\/span>\';/', $index_file, $matches);
if (!empty($matches[1])) {
    echo "<h3>New Random Ratings:</h3>";
    echo "<ul>";
    foreach ($matches[1] as $index => $rating) {
        // Add movie titles based on index
        $movieTitles = [
            "A Minecraft Movie",
            "The King of Kings",
            "Deadpool and Wolverine",
            "GODZILLA - KING OF MONSTERS",
            "X-MEN"
        ];
        $movieTitle = isset($movieTitles[$index]) ? $movieTitles[$index] : "Movie " . ($index + 1);
        echo "<li>$movieTitle: " . $rating . " ⭐</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No ratings found in the file.</p>";
}

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Clear your browser cache (press Ctrl+F5)</li>";
echo "<li>Open the homepage</li>";
echo "<li>Verify that each movie now has a unique random rating between 7.0 and 10.0</li>";
echo "</ol>";

echo "<p><a href='index.php' style='display: inline-block; padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>Go to Homepage</a></p>";
?> 