<?php include("inc/connect.inc.php"); ?>
<?php
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
} else {
    header("location: index.php");
}

$u_fname = "";
$u_lname = "";
$u_email = "";
$u_mobile = "";
$u_address = "";
$u_pass = "";

if (isset($_POST['signup'])) {
    // Declare variables
    $u_fname = $_POST['first_name'];
    $u_lname = $_POST['last_name'];
    $u_email = $_POST['email'];
    $u_mobile = $_POST['mobile'];
    $u_address = $_POST['signupaddress'];
    $u_pass = $_POST['password'];

    // Trimming name
    $_POST['first_name'] = trim($_POST['first_name']);
    $_POST['last_name'] = trim($_POST['last_name']);

    try {
        if (empty($_POST['first_name'])) {
            throw new Exception('Fullname cannot be empty');
        }
        if (is_numeric($_POST['first_name'][0])) {
            throw new Exception('Please write your correct name!');
        }
        if (empty($_POST['last_name'])) {
            throw new Exception('Lastname cannot be empty');
        }
        if (is_numeric($_POST['last_name'][0])) {
            throw new Exception('Lastname first character must be a letter!');
        }
        if (empty($_POST['email'])) {
            throw new Exception('Email cannot be empty');
        }
        if (empty($_POST['mobile'])) {
            throw new Exception('Mobile cannot be empty');
        }
        if (empty($_POST['password'])) {
            throw new Exception('Password cannot be empty');
        }
        if (empty($_POST['signupaddress'])) {
            throw new Exception('Address cannot be empty');
        }

        // Check if email already exists
        $e_check = mysqli_query($con, "SELECT email FROM `user` WHERE email='$u_email'");
        $email_check = mysqli_num_rows($e_check);

        if (strlen($_POST['first_name']) > 2 && strlen($_POST['first_name']) < 20) {
            if (strlen($_POST['last_name']) > 2 && strlen($_POST['last_name']) < 20) {
                if ($email_check == 0) {
                    if (strlen($_POST['password']) > 1) {
                        $d = date("Y-m-d"); // Year - Month - Day
                        $_POST['first_name'] = ucwords($_POST['first_name']);
                        $_POST['last_name'] = ucwords($_POST['last_name']);
                        $_POST['email'] = mb_convert_case($u_email, MB_CASE_LOWER, "UTF-8");
                        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

                        $result = mysqli_query($con, "INSERT INTO user (firstName, lastName, email, mobile, address, password) VALUES ('$_POST[first_name]', '$_POST[last_name]', '$_POST[email]', '$_POST[mobile]', '$_POST[signupaddress]', '$_POST[password]')");

                        // Success message
                        $success_message = '
                        <div class="signupform_content"><h2><font face="bookman">Registration successful!</font></h2>
                        <div class="signupform_text" style="font-size: 18px; text-align: center;">
                        <font face="bookman">
                            Email: ' . $u_email . '<br>
                            Your account has been created successfully!
                        </font></div></div>';
                    } else {
                        throw new Exception('Make a strong password!');
                    }
                } else {
                    throw new Exception('Email already taken!');
                }
            } else {
                throw new Exception('Lastname must be 2-20 characters!');
            }
        } else {
            throw new Exception('Firstname must be 2-20 characters!');
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<!doctype html>
<html>
<head>
    <title>Welcome to Raj Vans Ethnic Wear</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body class="home-welcome-text" style="background-image: url(image/bg.jpg);">
    <div class="homepageheader" style="position: inherit;">
        <div class="signinButton loginButton">
            <div class="uiloginbutton signinButton loginButton" style="margin-right: 40px;">
                <a style="text-decoration: none;" href="signin.php">SIGN UP</a>
            </div>
            <div class="uiloginbutton signinButton loginButton">
                <a style="text-decoration: none;" href="login.php">LOG IN</a>
            </div>
        </div>
        <div style="float: left; margin: 5px 0px 0px 23px;">
            <a href="index.php">
                <img style="height: 75px; width: 230px;" src="image/logo.jpg">
            </a>
        </div>
        <div>
            <div id="srcheader">
                <form id="newsearch" method="get" action="http://www.google.com">
                    <input type="text" class="srctextinput" name="q" size="21" maxlength="120" placeholder="Search Here...">
                    <input type="submit" value="search" class="srcbutton">
                </form>
                <div class="srcclear"></div>
            </div>
        </div>
    </div>
    <?php 
        if (isset($success_message)) {
            echo $success_message;
        } else {
            echo '
                <div class="holecontainer" style="float: right; margin-right: 36%; padding-top: 26px;">
                    <div class="container">
                        <div>
                            <div>
                                <div class="signupform_content">
                                    <h2>Sign Up Form!</h2>
                                    <div class="signupform_text"></div>
                                    <div>
                                        <form action="" method="POST" class="registration">
                                            <div class="signup_form">
                                                <div>
                                                    <td>
                                                        <input name="first_name" id="first_name" placeholder="First Name" required class="first_name signupbox" type="text" size="30" value="' . $u_fname . '" >
                                                    </td>
                                                </div>
                                                <div>
                                                    <td>
                                                        <input name="last_name" id="last_name" placeholder="Last Name" required class="last_name signupbox" type="text" size="30" value="' . $u_lname . '" >
                                                    </td>
                                                </div>
                                                <div>
                                                    <td>
                                                        <input name="email" placeholder="Enter Your Email" required class="email signupbox" type="email" size="30" value="' . $u_email . '">
                                                    </td>
                                                </div>
                                                <div>
                                                    <td>
                                                        <input name="mobile" placeholder="Enter Your Mobile" required class="email signupbox" type="text" size="30" value="' . $u_mobile . '">
                                                    </td>
                                                </div>
                                                <div>
                                                    <td>
                                                        <input name="signupaddress" placeholder="Write Your Full Address" required class="email signupbox" type="text" size="30" value="' . $u_address . '">
                                                    </td>
                                                </div>
                                                <div>
                                                    <td>
                                                        <input name="password" id="password-1" required placeholder="Enter New Password" class="password signupbox" type="password" size="30" value="' . $u_pass . '">
                                                    </td>
                                                </div>
                                                <div>
                                                    <input name="signup" class="uisignupbutton signupbutton" type="submit" value="Sign Me Up!">
                                                </div>
                                                <div class="signup_error_msg">';
            if (isset($error_message)) {
                echo $error_message;
            }
            echo '</div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        }
    ?>
</body>
</html>