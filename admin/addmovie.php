<?php
include "config.php";

// Check user login or not
if (!isset($_SESSION['uname'])) {
    header('Location: index.php');
}

// logout
if (isset($_POST['but_logout'])) {
    session_destroy();
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="../img/logo.png">
    <link rel="stylesheet" href="../style/styles.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <?php
    $sql = "SELECT * FROM bookingTable";
    $bookingsNo = mysqli_num_rows(mysqli_query($con, $sql));
    $messagesNo = mysqli_num_rows(mysqli_query($con, "SELECT * FROM feedbackTable"));
    $moviesNo = mysqli_num_rows(mysqli_query($con, "SELECT * FROM movieTable"));
    ?>
    
    <?php include('header.php'); ?>

    <div class="admin-container">

        <?php include('sidebar.php'); ?>
        <div class="admin-section admin-section2">
            <div class="admin-section-column">


                <div class="admin-section-panel admin-section-panel2">
                    <div class="admin-panel-section-header">
                        <h2>Movies</h2>
                        <i class="fas fa-film" style="background-color: #4547cf"></i>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input placeholder="Title" type="text" name="movieTitle" required>
                        <input placeholder="Genre" type="text" name="movieGenre" required>
                        <input placeholder="Duration" type="number" name="movieDuration" required>
                        <input placeholder="Release Date" type="date" name="movieRelDate" required>
                        <input placeholder="Director" type="text" name="movieDirector" required>
                        <input placeholder="Actors" type="text" name="movieActors" required>
                        <label>Price</label>
                        <input placeholder="Main Hall" type="text" name="mainhall" required><br />
                        <input placeholder="Vip-Hall" type="text" name="viphall" required><br />
                        <input placeholder="Private Hall" type="text" name="privatehall" required><br />
                        <br>
                        <label>YouTube Trailer URL</label>
                        <input placeholder="e.g. https://www.youtube.com/watch?v=..." type="url" name="trailerUrl"><br />
                        <label>Add Poster</label>
                        <input type="file" name="movieImg" accept="image/*">
                        <button type="submit" value="submit" name="submit" class="form-btn">Add Movie</button>
                        <?php
                        if (isset($_POST['submit'])) {
                            // Handle file upload
                            $target_dir = "../img/";
                            $target_file = $target_dir . basename($_FILES["movieImg"]["name"]);
                            $uploadOk = 1;
                            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                            
                            // Check if image file is actual image or fake image
                            if(isset($_POST["submit"])) {
                                $check = getimagesize($_FILES["movieImg"]["tmp_name"]);
                                if($check !== false) {
                                    $uploadOk = 1;
                                } else {
                                    echo "<script>alert('File is not an image.');</script>";
                                    $uploadOk = 0;
                                }
                            }
                            
                            // Check file size
                            if ($_FILES["movieImg"]["size"] > 500000) {
                                echo "<script>alert('Sorry, your file is too large.');</script>";
                                $uploadOk = 0;
                            }
                            
                            // Allow certain file formats
                            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                            && $imageFileType != "gif" ) {
                                echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
                                $uploadOk = 0;
                            }
                            
                            // If everything is ok, try to upload file
                            if ($uploadOk == 1) {
                                if (move_uploaded_file($_FILES["movieImg"]["tmp_name"], $target_file)) {
                                    // Store the path relative to the root directory
                                    $movieImg = "img/" . basename($_FILES["movieImg"]["name"]);
                                    
                                    // Prepare the trailer URL (use NULL if empty)
                                    $trailerUrl = !empty($_POST["trailerUrl"]) ? "'" . mysqli_real_escape_string($con, $_POST["trailerUrl"]) . "'" : "NULL";
                                    
                                    // First, check if the trailerUrl column exists
                                    $check_column = mysqli_query($con, "SHOW COLUMNS FROM movieTable LIKE 'trailerUrl'");
                                    if (mysqli_num_rows($check_column) == 0) {
                                        // Column doesn't exist, create it
                                        $alter_query = "ALTER TABLE movieTable ADD COLUMN trailerUrl VARCHAR(255) DEFAULT NULL AFTER movieActors";
                                        mysqli_query($con, $alter_query);
                                    }

                                    $insert_query = "INSERT INTO movieTable (
                                        movieImg,
                                        movieTitle,
                                        movieGenre,
                                        movieDuration,
                                        movieRelDate,
                                        movieDirector,
                                        movieActors,
                                        trailerUrl,
                                        mainhall,
                                        viphall,
                                        privatehall
                                    ) VALUES (
                                        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                                    )";

                                    // Use prepared statement to prevent SQL injection
                                    $stmt = mysqli_prepare($con, $insert_query);
                                    if ($stmt) {
                                        mysqli_stmt_bind_param($stmt, 'sssssssssss',
                                            $movieImg,
                                            $_POST["movieTitle"],
                                            $_POST["movieGenre"],
                                            $_POST["movieDuration"],
                                            $_POST["movieRelDate"],
                                            $_POST["movieDirector"],
                                            $_POST["movieActors"],
                                            $_POST["trailerUrl"],
                                            $_POST["mainhall"],
                                            $_POST["viphall"],
                                            $_POST["privatehall"]
                                        );
                                        
                                        $rs = mysqli_stmt_execute($stmt);
                                        if ($rs) {
                                            echo "<script>alert('Successfully added movie');
                                                window.location.href='addmovie.php';</script>";
                                        } else {
                                            echo "<script>alert('Database Error: " . mysqli_error($con) . "');</script>";
                                        }
                                        mysqli_stmt_close($stmt);
                                    } else {
                                        echo "<script>alert('Error preparing statement: " . mysqli_error($con) . "');</script>";
                                    }
                                } else {
                                    echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
                                }
                            }
                        }
                        ?>
                    </form>
                </div>
                <div class="admin-section-panel admin-section-panel2">
                    <div class="admin-panel-section-header">
                        <h2>Recent Movies</h2>
                        <i class="fas fa-film" style="background-color: #4547cf"></i>
                    </div>

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <th>MovieID</th>
                            <th>MovieTitle</th>
                            <th>Movie_Genre</th>
                            <th>Release_date</th>
                            <th>Director</th>
                            <th>More</th>
                            
                        </tr>
                        <tbody>
                            <?php
                            $host = "localhost:3308"; /* Host name */
                            $user = "root"; /* User */
                            $password = ""; /* Password */
                            $dbname = "cinema_db"; /* Database name */

                            $con = mysqli_connect($host, $user, $password, $dbname);
                            $select = "SELECT * FROM `movietable`";
                            $run = mysqli_query($con, $select);
                            while ($row = mysqli_fetch_array($run)) {
                                $ID = $row['movieID'];
                                $title = $row['movieTitle'];
                                $genere = $row['movieGenre'];
                                $releasedate = $row['movieRelDate'];
                                $movieactor = $row['movieDirector'];
                            ?>
                                <tr align="center">
                                    <td><?php echo $ID; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $genere; ?></td>
                                    <td><?php echo $releasedate; ?></td>
                                    <td><?php echo $movieactor; ?></td>
                                    <td>
                                        <a href="deletemovie.php?id=<?php echo $row['movieID']; ?>" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="../scripts/jquery-3.3.1.min.js "></script>
    <script src="../scripts/owl.carousel.min.js "></script>
    <script src="../scripts/script.js "></script>
</body>

</html>