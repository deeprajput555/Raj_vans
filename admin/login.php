<?php
include("../inc/connect.inc.php");
session_start();

if (isset($_SESSION['admin_login'])) {
    header("location: index.php");
    exit();
}

$error_message = "";

if (isset($_POST['login']))  
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $admin_email = mb_convert_case($_POST['email'], MB_CASE_LOWER, "UTF-8");
        $password_login = $_POST['password'];

        // Connect to the Shop database and fetch admin data
        $stmt = $con->prepare("SELECT id, password FROM Shop.admin WHERE email = ?");
        $stmt->bind_param("s", $admin_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            $admin_data = $result->fetch_assoc();
            if ($password_login === $admin_data['password']) {
				{	
                $_SESSION['admin_login'] = $admin_data['id'];
                setcookie('admin_login', $admin_data['id'], time() + (365 * 24 * 60 * 60), "/");
                header("location: index.php");
                exit();
            }
        }
        $error_message = '<div class="error">Invalid email or password.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Raj Vans Ethnic Wear - Admin Login</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body style="background-image: url(../image/bg-1.jpg);">
    <div class="homepageheader">
        <div class="signinButton loginButton">
            <div class="uiloginbutton signinButton loginButton">
                <a href="login.php">LOG IN</a>
            </div>
        </div>
        <div style="float: left; margin: 5px 0px 0px 23px;">
            <a href="index.php">
                <img style="height: 75px; width: 230px;" src="../image/logo.jpg" alt="Raj Vans Ethnic Wear">
            </a>
        </div>
    </div>
    <div class="holecontainer" style="margin: auto; text-align: center; padding-top: 110px;">
        <div class="container">
            <div class="signupform_content">
                <h2>Admin Login - Raj Vans Ethnic Wear</h2>
                <div class="signup_error_msg"><?= $error_message ?></div>
                <form action="" method="POST" class="registration">
                    <div class="signup_form">
                        <input name="email" placeholder="Enter Your Email" required class="email signupbox" type="email">
                        <input name="password" required placeholder="Enter Password" class="password signupbox" type="password">
                        <input name="login" class="uisignupbutton signupbutton" type="submit" value="Log In">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>