<!DOCTYPE html>
<html lang="en">
<?php
$id = $_GET['id'];
//conditions
if ((!$_GET['id'])) {
    echo "<script>alert('You are Not Suppose to come Here Directly');window.location.href='index.php';</script>";
}
include "connection.php";
$movieQuery = "SELECT * FROM movieTable WHERE movieID = $id";
$movieImageById = mysqli_query($con, $movieQuery);
$row = mysqli_fetch_array($movieImageById);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Book <?php echo $row['movieTitle']; ?> Now</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="style/booking_new.css">
</head>

<body>
    <div class="booking-panel">
        <div class="booking-panel-section1">
            <h1>RESERVE YOUR TICKET</h1>
        </div>
        <div class="booking-panel-section2" onclick="window.history.go(-1); return false;">
            <i class="fas fa-2x fa-times"></i>
        </div>
        
        <div class="booking-panel-content">
            <div class="movie-box">
                <?php
                echo '<img src="' . $row['movieImg'] . '" alt="' . $row['movieTitle'] . '">';
                ?>
            </div>
            
            <div class="movie-details">
                <div class="title"><?php echo $row['movieTitle']; ?></div>
                
                <div class="movie-information">
                    <table>
                        <tr>
                            <td>GENRE</td>
                            <td><?php echo $row['movieGenre']; ?></td>
                        </tr>
                        <tr>
                            <td>DURATION</td>
                            <td><?php echo $row['movieDuration']; ?></td>
                        </tr>
                        <tr>
                            <td>RELEASE DATE</td>
                            <td><?php echo $row['movieRelDate']; ?></td>
                        </tr>
                        <tr>
                            <td>DIRECTOR</td>
                            <td><?php echo $row['movieDirector']; ?></td>
                        </tr>
                        <tr>
                            <td>ACTORS</td>
                            <td><?php echo $row['movieActors']; ?></td>
                        </tr>
                    </table>
                </div>
                
                <div class="booking-form-container">
                    <form action="verify.php" method="POST">
                        <select name="theatre" required>
                            <option value="" disabled selected>Select Theatre</option>
                            <option value="main-hall">Main Hall</option>
                            <option value="vip-hall">VIP Hall</option>
                            <option value="private-hall">Private Hall</option>
                        </select>

                        <select name="type" required>
                            <option value="" disabled selected>Select Type</option>
                            <option value="3d">3D</option>
                            <option value="2d">2D</option>
                            <option value="imax">IMAX</option>
                            <option value="7d">7D</option>
                        </select>

                        <select name="date" required>
                            <option value="" disabled selected>Select Date</option>
                            <option value="15-5">May 15, 2025</option>
                            <option value="16-5">May 16, 2025</option>
                            <option value="17-5">May 17, 2025</option>
                            <option value="18-5">May 18, 2025</option>
                            <option value="19-5">May 19, 2025</option>
                            <option value="20-5">May 20, 2025</option>
                        </select>

                        <select name="hour" required>
                            <option value="" disabled selected>Select Time</option>
                            <option value="09-00">09:00 AM</option>
                            <option value="12-00">12:00 PM</option>
                            <option value="15-00">03:00 PM</option>
                            <option value="18-00">06:00 PM</option>
                            <option value="21-00">09:00 PM</option>
                            <option value="24-00">12:00 AM</option>
                        </select>

                        <input placeholder="First Name" type="text" name="fName" required>
                        <input placeholder="Last Name" type="text" name="lName">
                        <input placeholder="Phone Number" type="tel" name="pNumber" required>
                        <input placeholder="Email" type="email" name="email" required>
                        <input type="hidden" name="movie_id" value="<?php echo $id; ?>">

                        <div class="payment-info">
                            <h3>Payment Information</h3>
                            <select name="payment_method" required>
                                <option value="" disabled selected>Select Payment Method</option>
                                <option value="paytm">Paytm</option>
                                <option value="upi">UPI</option>
                            </select>
                            
                            <div id="upi-details" style="display: none;">
                                <input placeholder="UPI ID" type="text" name="upi_id">
                            </div>
                        </div>

                        <button type="submit" value="save" name="submit" class="form-btn">
                            <i class="fas fa-ticket-alt"></i> Book Ticket
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('select[name="payment_method"]').addEventListener('change', function() {
            const upiDetails = document.getElementById('upi-details');
            if (this.value === 'upi') {
                upiDetails.style.display = 'block';
            } else {
                upiDetails.style.display = 'none';
            }
        });
    </script>
</body>
</html>