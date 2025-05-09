<?php
include "connection.php";

echo "<h2>Video Playback Fix v3</h2>";

// Read the index.php file
$index_file = file_get_contents('index.php');

if ($index_file === false) {
    die("Error reading index.php file");
}

// Update the CSS to fix the blank screen issue
$css = '
<style>
.trailers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
    max-width: 1400px;
    margin: 0 auto;
}

.trailers-grid-item {
    position: relative;
    width: 100%;
}

.video-thumbnail {
    position: relative;
    width: 100%;
    padding-top: 56.25%; /* 16:9 Aspect Ratio */
    background: #000;
    cursor: pointer;
    border-radius: 8px;
    overflow: hidden;
}

.video-thumbnail img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
    z-index: 1;
}

.video-thumbnail:hover img {
    transform: scale(1.05);
}

.trailer-item-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 20px;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: white;
    text-align: center;
    transition: opacity 0.3s ease;
    z-index: 2;
}

.trailer-item-info h3 {
    margin: 0 0 10px 0;
    font-size: 1.2em;
}

.trailer-item-info i {
    font-size: 2em;
    opacity: 0.9;
    transition: transform 0.3s ease;
}

.video-thumbnail:hover .trailer-item-info i {
    transform: scale(1.1);
}

.video-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
    z-index: 0;
}

.trailer-video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

/* Playing state styles */
.video-thumbnail.playing img,
.video-thumbnail.playing .trailer-item-info {
    opacity: 0;
    visibility: hidden;
    z-index: 0;
}

.video-thumbnail.playing .video-container {
    opacity: 1;
    visibility: visible;
    z-index: 3;
}
</style>';

// Add the new CSS before </head>
$index_file = preg_replace('/<style>.*?<\/style>/s', $css, $index_file);

// Update the JavaScript to handle visibility
$new_js = '<script>
document.addEventListener("DOMContentLoaded", function() {
    const thumbnails = document.querySelectorAll(".video-thumbnail");
    console.log("[Debug] Found", thumbnails.length, "video thumbnails");
    
    function createYouTubePlayer(videoId, container) {
        const iframe = document.createElement("iframe");
        iframe.setAttribute("src", `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&showinfo=0&enablejsapi=1&mute=0`);
        iframe.setAttribute("frameborder", "0");
        iframe.setAttribute("allow", "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture");
        iframe.setAttribute("allowfullscreen", "");
        iframe.classList.add("trailer-video");
        container.appendChild(iframe);
        return iframe;
    }
    
    thumbnails.forEach((thumbnail, index) => {
        const videoId = thumbnail.getAttribute("data-video-id");
        const container = thumbnail.querySelector(".video-container");
        
        console.log(`[Debug] Thumbnail ${index + 1}:`, {
            videoId: videoId,
            hasContainer: !!container
        });
        
        if (!videoId || !container) {
            console.error(`[Debug] Missing video ID or container for thumbnail ${index + 1}`);
            return;
        }
        
        thumbnail.addEventListener("click", function(e) {
            e.preventDefault();
            console.log(`[Debug] Clicked thumbnail ${index + 1} with video ID:`, videoId);
            
            if (this.classList.contains("playing")) {
                console.log("[Debug] Stopping video");
                this.classList.remove("playing");
                // Wait for the transition before removing the iframe
                setTimeout(() => {
                    container.innerHTML = "";
                }, 300);
            } else {
                console.log("[Debug] Playing video:", videoId);
                
                // Stop any other playing videos first
                thumbnails.forEach(other => {
                    if (other.classList.contains("playing")) {
                        other.classList.remove("playing");
                        const otherContainer = other.querySelector(".video-container");
                        setTimeout(() => {
                            otherContainer.innerHTML = "";
                        }, 300);
                    }
                });
                
                // Create and start the new video
                const iframe = createYouTubePlayer(videoId, container);
                this.classList.add("playing");
                
                console.log("[Debug] Video player created and playing class added");
            }
        });
    });
});
</script>';

// Replace the existing script
$script_pattern = '/<script>\s*document\.addEventListener\([\'"]DOMContentLoaded[\'"].*?<\/script>/s';
$index_file = preg_replace($script_pattern, $new_js, $index_file);

// Save the changes
if (file_put_contents('index.php', $index_file)) {
    echo "<p>✅ Successfully updated the video playback system.</p>";
    echo "<p>Fixed the blank screen issue before video playback.</p>";
} else {
    echo "<p>❌ Error writing to index.php file.</p>";
}

echo "<h3>Changes Made:</h3>";
echo "<ol>";
echo "<li>Fixed the blank screen issue by properly hiding the video container</li>";
echo "<li>Added proper z-index management for all layers</li>";
echo "<li>Improved transitions between states</li>";
echo "<li>Added visibility handling for smoother transitions</li>";
echo "</ol>";

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Clear your browser cache (press Ctrl+F5)</li>";
echo "<li>Open the homepage</li>";
echo "<li>Check that thumbnails are visible and there's no blank screen</li>";
echo "<li>Try playing and stopping videos to ensure smooth transitions</li>";
echo "</ol>";

echo "<p><a href='index.php' style='display: inline-block; padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>Go to Homepage</a></p>";
?> 