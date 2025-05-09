<?php
include "connection.php";

echo "<h2>Video Alignment Fix v4</h2>";

// Read the index.php file
$index_file = file_get_contents('index.php');

if ($index_file === false) {
    die("Error reading index.php file");
}

// Update the CSS with adjusted vertical alignment
$css = '
<style>
.trailers-section {
    padding: 2rem 2rem 4rem;  /* Reduced top padding */
    background: linear-gradient(to right, rgba(44, 62, 80, 0.9), rgba(52, 152, 219, 0.9));
    color: white;
    width: 100%;
}

.trailers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1rem;
    width: 100%;
}

.trailers-grid-item {
    position: relative;
    width: 100%;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    aspect-ratio: 16/9;
    transform: translateY(-10px); /* Slight upward shift */
}

.video-thumbnail {
    position: relative;
    width: 100%;
    height: 100%;
    background: #000;
    cursor: pointer;
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

.video-container {
    position: absolute;
    top: -5%;  /* Move up slightly */
    left: 0;
    right: 0;
    bottom: -5%;  /* Extend bottom to maintain aspect ratio */
    width: 100%;
    height: 110%;  /* Slightly taller to account for shift */
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
    z-index: 0;
    background: #000;
    display: flex;
    align-items: flex-start;  /* Align to top */
    justify-content: center;
}

.video-wrapper {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: flex-start;  /* Align to top */
    justify-content: center;
    transform: translateY(0);  /* Reset any transform */
}

.trailer-video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100% !important;
    height: 100% !important;
    border: none !important;
    margin: 0 !important;
    padding: 0 !important;
    object-fit: cover !important;
    transform: translateY(0) !important;  /* Reset any transform */
}

.trailer-item-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1.5rem;
    background: linear-gradient(transparent, rgba(0,0,0,0.9));
    color: white;
    z-index: 2;
    text-align: center;
}

.trailer-item-info h3 {
    margin: 0;
    font-size: 1.2em;
    font-weight: 600;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.trailer-item-info i {
    font-size: 3em;
    opacity: 0.9;
    transition: transform 0.3s ease;
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

@media (max-width: 768px) {
    .trailers-grid {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .trailers-section {
        padding: 1rem 1rem 3rem;  /* Adjusted padding for mobile */
    }
    
    .trailers-grid-item {
        transform: translateY(-5px);  /* Smaller shift on mobile */
    }
}
</style>';

// Add the new CSS before </head>
$index_file = preg_replace('/<style>.*?<\/style>/s', $css, $index_file);

// Update the JavaScript with improved video handling
$new_js = '<script>
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
</script>';

// Replace the existing script
$script_pattern = '/<script>\s*document\.addEventListener\([\'"]DOMContentLoaded[\'"].*?<\/script>/s';
$index_file = preg_replace($script_pattern, $new_js, $index_file);

// Save the changes
if (file_put_contents('index.php', $index_file)) {
    echo "<p>✅ Successfully updated the video alignment with adjusted vertical position.</p>";
} else {
    echo "<p>❌ Error writing to index.php file.</p>";
}

echo "<h3>Key Changes Made:</h3>";
echo "<ol>";
echo "<li>Reduced top padding of trailers section</li>";
echo "<li>Added slight upward shift to trailer grid items</li>";
echo "<li>Adjusted video container position to start slightly higher</li>";
echo "<li>Modified alignment to favor top positioning</li>";
echo "<li>Added transform reset to prevent unwanted shifts</li>";
echo "<li>Adjusted mobile responsiveness for consistent alignment</li>";
echo "</ol>";

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo "<li>Clear your browser cache (press Ctrl+F5)</li>";
echo "<li>Open the homepage</li>";
echo "<li>Check if videos are now positioned higher</li>";
echo "<li>Verify the alignment looks good on different screen sizes</li>";
echo "</ol>";

echo "<p><a href='index.php' style='display: inline-block; padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>Go to Homepage</a></p>";
?> 