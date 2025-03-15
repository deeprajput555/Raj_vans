<?php
include("inc/connect.inc.php");
session_start();

// Redirect if already logged in
if (isset($_SESSION['user_login'])) {
    header("location: index.php");
    exit();
}

$emails = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $user_login = mysqli_real_escape_string($con, $_POST['email']);
        $user_login = mb_convert_case($user_login, MB_CASE_LOWER, "UTF-8");
        $entered_password = mysqli_real_escape_string($con, $_POST['password']); // Get user entered password

        // Check if user exists
        $query = "SELECT id, password FROM user WHERE email='$user_login'";
        $result = mysqli_query($con, $query);

        if (!$result) {
            die("Query Failed: " . mysqli_error($con));
        }

        if (mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $stored_hashed_password = $user_data['password']; // Fetch hashed password from DB

            // Verify password
            if (password_verify($entered_password, $stored_hashed_password)) {
                // ✅ Password is correct, log in user
                $_SESSION['user_login'] = $user_data['id'];
                setcookie('user_login', $user_login, time() + (365 * 24 * 60 * 60), "/");

                // Redirect if order number is provided
                if (isset($_REQUEST['ono'])) {
                    $ono = mysqli_real_escape_string($con, $_REQUEST['ono']);
                    header("location: orderform.php?poid=" . $ono);
                } else {
                    header("location: index.php");
                }
                exit();
            } else {
                // ❌ Incorrect password
                $error_message = "Invalid Email or Password.";
            }
        } else {
            $error_message = "Invalid Email or Password.";
        }
    } else {
        $error_message = "Please fill in all fields.";
    }
}
?>


<!doctype html>
<html>
<head>
    <title>Welcome to Raj Vans Ethnic Wear</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body class="home-welcome-text" style="background-image: url(image/bg-1.jpg);">
    <div class="homepageheader">
        <div class="signinButton loginButton">
            <div class="uiloginbutton signinButton loginButton" style="margin-right: 40px;">
                <a style="text-decoration: none; color: #fff;" href="signin.php">SIGN IN</a>
            </div>
            <div class="uiloginbutton signinButton loginButton">
                <a style="text-decoration: none; color: #fff;" href="login.php">LOG IN</a>
            </div>
        </div>
        <div style="float: left; margin: 5px 0px 0px 23px;">
            <a href="index.php">
                <img style="height: 75px; width: 230px;" src="image/logo.jpg">
            </a>
        </div>
        <div id="srcheader">
            <form id="newsearch" method="get" action="search.php">
                <input type="text" class="srctextinput" name="keywords" size="21" maxlength="120" placeholder="Search Here...">
                <input type="submit" value="search" class="srcbutton">
            </form>
            <div class="srcclear"></div>
        </div>
    </div>

    <div class="holecontainer" style="float: right; margin-right: 36%; padding-top: 110px;">
        <div class="container">
            <div class="signupform_content">
                <h2>Login Form</h2>
                <form action="" method="POST" class="registration">
                    <div class="signup_form">
                        <input name="email" placeholder="Enter Your Email" required class="email signupbox" type="email" value="<?php echo $emails; ?>">
                        <input name="password" placeholder="Enter Password" required class="password signupbox" type="password">
                        <input name="login" class="uisignupbutton signupbutton" type="submit" value="Log In">
                        
                        <div style="float: right;">
                            <a class="forgetpass" href="forgetpass.php"><span>Forget your password?</span></a>
                        </div>

                        <?php if (!empty($error_message)): ?>
                            <div class="signup_error_msg">
                                <p style="color: red;"><?php echo $error_message; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
