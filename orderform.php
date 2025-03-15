<?php include("inc/connect.inc.php"); ?>
<?php 

if (isset($_REQUEST['poid'])) {
    $poid = mysqli_real_escape_string($con, $_REQUEST['poid']);
} else {
    header('location: index.php');
    exit();
}

ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
    $user = "";
    header("location: login.php?ono=" . $poid);
    exit();
} else {
    $user = $_SESSION['user_login'];
    $stmt = $con->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $get_user_email = $result->fetch_assoc();

    $uname_db = $get_user_email['firstName'];
    $ulast_db = $get_user_email['lastName'];
    $uemail_db = $get_user_email['email'];
    $umob_db = $get_user_email['mobile'];
    $uadd_db = $get_user_email['address'];
    $stmt->close();
}

$stmt = $con->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("s", $poid);
$stmt->execute();
$getposts = $stmt->get_result();

$id = $pName = $price = $description = $picture = $item = $category = $available = '';

if ($getposts->num_rows) {
    $row = $getposts->fetch_assoc();
    $id = $row['id'];
    $pName = $row['pName'];
    $price = $row['price'];
    $description = $row['description'];
    $picture = $row['picture'];
    $item = $row['item'];
    $category = $row['category'];
    $available = $row['available'];
}
$stmt->close();

// Order
if (isset($_POST['order'])) {
    $mbl = $_POST['mobile'];
    $addr = $_POST['address'];
    $quan = $_POST['Quantity'];
    $del = $_POST['Delivery'];

    try {
        if (empty($mbl)) {
            throw new Exception('Mobile cannot be empty');
        }
        if (empty($addr)) {
            throw new Exception('Address cannot be empty');
        }
        if (empty($quan)) {
            throw new Exception('Quantity cannot be empty');
        }
        if (empty($del)) {
            throw new Exception('Type of Delivery cannot be empty');
        }

        $d = date("Y-m-d"); // Year - Month - Day

        $stmt = $con->prepare("INSERT INTO orders (uid, pid, quantity, oplace, mobile, odate, delivery) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissss", $user, $poid, $quan, $addr, $mbl, $d, $del);
        if ($stmt->execute()) {
            $success_message = '
            <div class="signupform_content">
            <h2><font face="bookman"></font></h2>
            <script>
            alert("We will call you for confirmation very soon");
            </script>
            <div class="signupform_text" style="font-size: 18px; text-align: center;">
            <font face="bookman">
            </font></div></div>
            ';
        }
        $stmt->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Raj Vans Ethnic Wear</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="background-image: url(image/bg-1.jpg);">
    <div class="homepageheader">
        <div class="signinButton loginButton">
            <div class="uiloginbutton signinButton loginButton" style="margin-right: 40px;">
                <?php 
                    if ($user != "") {
                        echo '<a style="text-decoration: none; color: #fff;" href="logout.php">LOG OUT</a>';
                    } else {
                        echo '<a style="text-decoration: none; color: #fff;" href="signin.php">SIGN IN</a>';
                    }
                ?>
            </div>
            <div class="uiloginbutton signinButton loginButton" style="">
                <?php 
                    if ($user != "") {
                        echo '<a style="text-decoration: none; color: #fff;" href="profile.php?uid=' . $user . '">Hi ' . $uname_db . '</a>';
                    } else {
                        echo '<a style="text-decoration: none; color: #fff;" href="login.php">LOG IN</a>';
                    }
                ?>
            </div>
        </div>
        <div style="float: left; margin: 5px 0px 0px 23px;">
            <a href="index.php">
                <img style="height: 75px; width: 230px;" src="image/logo.jpg">
            </a>
        </div>
        <div class="">
            <div id="srcheader">
                <form id="newsearch" method="get" action="search.php">
                    <input type="text" class="srctextinput" name="keywords" size="21" maxlength="120" placeholder="Search Here...">
                    <input type="submit" value="search" class="srcbutton">
                </form>
                <div class="srcclear"></div>
            </div>
        </div>
    </div>
    <div class="categolis">
        <table>
            <tr>
                <th><a href="OurProducts/Jacket.php" style="text-decoration: none;color:#040403 ;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Jacket</a></th>
                <th><a href="OurProducts/Kurta.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Kurta</a></th>
                <th><a href="OurProducts/Mala.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Mala</a></th>
                <th><a href="OurProducts/Mojadi.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Mojadi</a></th>
                <th><a href="OurProducts/Safa_dupatta.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Safa_dupatta</a></th>
                <th><a href="OurProducts/Sherwani.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Sherwani</a></th>
                <th><a href="OurProducts/Shortkurta.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Shortkurta</a></th>
            </tr>
        </table>
    </div>
    <div class="holecontainer" style="padding: 20px 15%">
        <div class="container signupform_content">
            <div>
                <div style="float: right;">
                    <?php 
                        if (isset($success_message)) {
                            echo $success_message;
                            echo '<h3 style="color:#169E8F;font-size:45px;"> Payment&Delivery </h3>';

                            $stmt = $con->prepare("SELECT * FROM user WHERE id = ?");
                            $stmt->bind_param("s", $user);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $get_user_email = $result->fetch_assoc();
                            $uname_db = $get_user_email['firstName'];
                            $ulast_db = $get_user_email['lastName'];
                            $uemail_db = $get_user_email['email'];
                            $umob_db = $get_user_email['mobile'];
                            $uadd_db = $get_user_email['address'];
                            $stmt->close();

                            echo '<h3 style="color:black;font-size:25px;"> First Name: </h3>';
                            echo '<span style="color:#34ce6c;font-size:25px;">' . $uname_db . '</span>';
                            echo '<h3 style="color:black;font-size:25px;"> Last Name: </h3>';
                            echo '<span style="color:#34ce6c;font-size:25px;">' . $ulast_db . '</span>';
                            echo '<h3 style="color:black;font-size:25px;"> Email: </h3>'; 
                            echo '<span style="color:#34ce6c;font-size:25px;">' . $uemail_db . '</span>';
                            echo '<h3 style="color:black;font-size:25px;"> Contact Number: </h3>';
                            echo '<span style="color:#34ce6c;font-size:25px;">' . $umob_db . '</span>';
                            echo '<h3 style="color:black;font-size:25px;"> Home Address: </h3>';
                            echo '<span style="color:#34ce6c;font-size:25px;">' . $uadd_db . '</span>';
                            
                            $del = $_POST['Delivery'];
                            echo '<h3 style="color:black;font-size:25px;">Types of Delivery:</h3>';
                            echo '<span style="color:#34ce6c;font-size:25px;">' . $del . '</span>';
                            $quan = $_POST['Quantity'];
                            echo '<h3 style="color:black;font-size:25px;"> Quantity: </h3>';
                            echo '<span style="color:#34ce6c;font-size:25px;">' . $quan . '</span>';
                            
                            echo '<h3 style="color:#169E8F;font-size:45px;"> Total: Php ' . ($quan * $price) . ' Php</h3>';
                        } else {
                            echo '
                            <div class="">
                                <div class="signupform_text"></div>
                                <div>
                                    <form action="" method="POST" class="registration">
                                        <div class="signup_form">
                                            <h3 style="color:red;font-size:18px; padding: 5px;">Accepting CashOnDelivery Only</h3>
                                            <div>
                                                <td>
                                                    <input name="fullname" placeholder="your name" required="required" class="email signupbox" type="text" size="30" value="' . $uname_db . '">
                                                </td>
                                            </div>
                                            <div>
                                                <td>
                                                    <input name="lastname" placeholder="Your last name" required="required" class="email signupbox" type="text" size="30" value="' . $ulast_db . '">
                                                </td>
                                            </div>
                                            <div>
                                                <td>
                                                    <input name="mobile" placeholder="Your mobile number" required="required" class="email signupbox" type="text" size="30" value="' . $umob_db . '">
                                                </td>
                                            </div>
                                            <div>
                                                <td>
                                                    <input name="address" id="password-1" required="required" placeholder="Write your full address" class="password signupbox" type="text" size="30" value="' . $uadd_db . '">
                                                </td>
                                            </div>
                                            <div>
                                                <td>
                                                    <font style="italic" family="arial" size="5px" color="#169e">
                                                        Types of Delivery <br>
                                                        <input name="Delivery" required="required" value="Express Delivery +100php upon cash on delivery" type="radio" placeholder="Mode Of Payment"> Express Delivery </br>
                                                        <input name="Delivery" type="radio" value="Standard Delivery" required="required" placeholder="Mode Of Payment"> Standard Delivery </br>
                                                    </font>
                                                </td>
                                            </div>
                                            <div>
                                                <td>
                                                    <input name="Quantity" required="required" type="number" min="1" class="password signupbox" placeholder="Quantity">
                                                </td>
                                            </div>
                                            <div>
                                                <input name="order" class="uisignupbutton signupbutton" type="submit" value="Confirm Order">
                                            </div>
                                            <div class="signup_error_msg">'; ?>
                                                <?php 
                                                    if (isset($error_message)) {
                                                        echo $error_message;
                                                    }
                                                ?>
                                            <?php echo '</div>
                                        </div>
                                    </form>
                                </div>
                            </div>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <div style="float: left; font-size: 23px;">
            <div>
			<?php
if (!empty($category) && !empty($id) && !empty($item) && !empty($picture) && !empty($pName) && !empty($price)) {
    // Sanitize output
    $category = htmlspecialchars($category);
    $id = htmlspecialchars($id);
    $item = htmlspecialchars($item);
    $picture = htmlspecialchars($picture);
    $pName = htmlspecialchars($pName);
    $price = htmlspecialchars($price);

    // Correct image path (make sure the folder structure matches)
    $imagePath = "image/product/$item/$picture";

    // Check if the image file exists (avoid broken image links)
    if (!file_exists($imagePath)) {
        $imagePath = "image/product/default.jpg"; // Use a default image if missing
    }

    echo '
    <ul style="float: left;">
        <li style="float: left; padding: 0px 25px 25px 25px;">
            <div class="home-prodlist-img">
                <a href="' . $category . '/view_product.php?pid=' . $id . '">
                    <img src="' . $imagePath . '" class="home-prodlist-imgi" alt="Product Image">
                </a>
                <div style="text-align: center; padding: 0 0 6px 0;">
                    <span style="font-size: 15px;">' . $pName . '</span><br> 
                    <strong>Price:</strong> ' . $price . ' Php
                </div>
            </div>
        </li>
    </ul>';
} else {
    echo '<p style="color: red; font-weight: bold;">Product details are not available.</p>';
}
?>

</html>