<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Us - My Show</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="style/styles_new.css">
</head>

<body>
    <?php include "connection.php"; ?>
    
    <section class="brand-heading">
        <div class="brand-content">
            <div class="brand-left">
                <h1>My <span class="show-text">Show</span></h1>
            </div>
            <nav class="navbar">
                <div class="nav-links">
                    <a href="index.php"><i class="fas fa-home"></i><span>Home</span></a>
                    <a href="movies.php"><i class="fas fa-film"></i><span>Movies</span></a>
                    <a href="my_bookings.php"><i class="fas fa-ticket-alt"></i><span>My Bookings</span></a>
                </div>
            </nav>
        </div>
        <p class="brand-subtitle">Your Premier Movie Destination</p>
    </section>

    <div class="contact-wrapper">
        <main class="contact-page">
            <div class="page-header">
                <h1>Contact Us</h1>
                <p>We'd love to hear from you. Get in touch with us!</p>
            </div>
            
            <div class="contact-container">
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h3>Phone</h3>
                        <p><a href="tel:+919XX8X80XX5">+91 9XX8X80XX5</a></p>
                        <p><a href="tel:+919XX8X80XX5">+91 9XX8X80XX5</a></p>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h3>Address</h3>
                        <p>Kattankulathur, 603203<br>Chennai</p>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h3>Email</h3>
                        <p><a href="mailto:itzaayush2005@gmail.com">itzaayush2005@gmail.com</a></p>
                    </div>
                </div>
                
                <div class="map-container">
                    <iframe 
                        src="https://maps.google.com/maps?q=Kattankulathur&t=&z=13&ie=UTF8&iwloc=&output=embed" 
                        frameborder="0" 
                        scrolling="no" 
                        allowfullscreen>
                    </iframe>
                </div>

                <div class="contact-form-section">
                    <div class="form-header">
                        <h2>Send us a Message</h2>
                        <p>Fill out the form below and we'll get back to you soon.</p>
                    </div>
                    
                    <form action="" method="POST" class="contact-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="fName"><i class="fas fa-user"></i> First Name</label>
                                <input type="text" id="fName" name="fName" required>
                            </div>
                            <div class="form-group">
                                <label for="lName"><i class="fas fa-user"></i> Last Name</label>
                                <input type="text" id="lName" name="lName">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="eMail"><i class="fas fa-envelope"></i> Email Address</label>
                            <input type="email" id="eMail" name="eMail" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="feedback"><i class="fas fa-comment"></i> Your Message</label>
                            <textarea id="feedback" name="feedback" rows="6" required></textarea>
                        </div>
                        
                        <button type="submit" name="submit" class="submit-btn">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                    
                    <?php
                    if (isset($_POST['submit'])) {
                        $insert_query = "INSERT INTO 
                            feedbackTable (senderfName,
                                         senderlName,
                                         sendereMail,
                                         senderfeedback)
                            VALUES ('" . $_POST["fName"] . "',
                                    '" . $_POST["lName"] . "',
                                    '" . $_POST["eMail"] . "',
                                    '" . $_POST["feedback"] . "')";
                        $add = mysqli_query($con, $insert_query);

                        if ($add) {
                            echo "<div class='success-message'>
                                    <i class='fas fa-check-circle'></i>
                                    Message sent successfully!
                                  </div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>

    <?php include "includes/footer.php"; ?>

    <script src="scripts/jquery-3.3.1.min.js"></script>
    <script src="scripts/script.js"></script>
</body>
</html>