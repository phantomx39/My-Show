<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(120deg, #2980b9, #8e44ad);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        #div_login {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
            padding: 30px;
        }

        #div_login h1 {
            margin: 0 0 30px;
            padding: 0;
            color: #2c3e50;
            text-align: center;
            font-size: 28px;
            font-weight: 600;
        }

        #div_login div {
            margin-bottom: 25px;
            position: relative;
        }

        .textbox {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s ease;
            outline: none;
        }

        .textbox:focus {
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.3);
        }

        #div_login input[type=submit] {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, #2980b9, #3498db);
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #div_login input[type=submit]:hover {
            background: linear-gradient(to right, #2475a7, #2980b9);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .error-message {
            color: #e74c3c;
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="post" action="">
            <div id="div_login">
                <h1>Admin Login</h1>
                <div>
                    <input type="text" class="textbox" id="txt_uname" name="txt_uname" placeholder="Enter your username" />
                </div>
                <div>
                    <input type="password" class="textbox" id="txt_pwd" name="txt_pwd" placeholder="Enter your password" />
                </div>
                <div>
                    <input type="submit" value="Login" name="but_submit" id="but_submit" />
                </div>
                <?php if(isset($error_message)): ?>
                    <div class="error-message"><?php echo $error_message; ?></div>
                <?php endif; ?>
            </div>
        </form>
    </div>
</body>

</html>

<?php
include "config.php";

if (isset($_POST['but_submit'])) {

    $uname = mysqli_real_escape_string($con, $_POST['txt_uname']);
    $password = mysqli_real_escape_string($con, $_POST['txt_pwd']);

    if ($uname != "" && $password != "") {

        $sql_query = "select count(*) as cntUser from users where username='" . $uname . "' and password='" . $password . "'";
        $result = mysqli_query($con, $sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];

        if ($count > 0) {
            $_SESSION['uname'] = $uname;
            header('Location: admin.php');
        } else {
            echo "Invalid username and password";
        }
    }
}
?>