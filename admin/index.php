<?php include ("../inc/connect.inc.php"); ?>
<?php 
ob_start();
session_start();
if (!isset($_SESSION['admin_login'])) {
	header("location: login.php");
	$user = "";
} else {
	$user = $_SESSION['admin_login'];
	$result = mysqli_query($con, "SELECT * FROM admin WHERE id='$user'");
	$get_user_email = mysqli_fetch_assoc($result);
	$uname_db = $get_user_email['firstName'];
	$utype_db = $get_user_email['type'];
}
$search_value = "";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Raj Vans Ethnic Wear</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<script src="/js/homeslideshow.js"></script>
</head>
<body style="min-width: 980px; background-image: url(../image/bg-1.jpg);">
	<div class="homepageheader">
		<div class="signinButton loginButton">
			<div class="uiloginbutton signinButton loginButton" style="margin-right: 40px;">
				<?php 
					if ($user != "") {
						echo '<a style="text-decoration: none;color: #fff;" href="logout.php">LOG OUT</a>';
					} else {
						echo '<a style="text-decoration: none;color: #fff;" href="signin.php">SIGN IN</a>';
					}
				?>
			</div>
			<div class="uiloginbutton signinButton loginButton">
				<?php 
					if ($user != "") {
						echo '<a style="text-decoration: none;color: #fff;" href="update_admin.php">Hi '.$uname_db.'</br><span style="color: #010a0e">'.$utype_db.'</span></a>';
					} else {
						echo '<a style="text-decoration: none;color: #fff;" href="login.php">LOG IN</a>';
					}
				?>
			</div>
		</div>
		<div style="float: left; margin: 5px 0px 0px 23px;">
			<a href="index.php">
				<img style="height: 73px; width: 230px;" src="../image/logo.jpg">
			</a>
		</div>
		<div class="">
			<div id="srcheader">
				<form id="newsearch" method="get" action="search.php">
				        <input type="text" class="srctextinput" name="keywords" size="21" maxlength="120"  placeholder="Search Ethnic Wear...">
				        <input type="submit" value="Search" class="srcbutton">
				</form>
			<div class="srcclear"></div>
			</div>
		</div>
	</div>
	<div class="categolis">
		<table>
			<tr>
				<th><a href="index.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #FFD700;;border-radius: 12px;">Home</a></th>
				<th><a href="addproduct.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color:#ffd700;border-radius: 12px;">Add Product</a></th>
				<th><a href="editproduct.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #FFD700;border-radius: 12px;">Edit Product</a></th>
				<th><a href="allproducts.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #FFD700;border-radius: 12px;">All Products</a></th>
				<th><a href="orders.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #FFD700;border-radius: 12px;">Orders</a></th>
				<!-- <th><a href="DeliveryRecords.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #FFD700;border-radius: 12px;">Delivery Records</a></th> -->
				<?php 
					if($utype_db == 'admin'){
						// echo <th><a href="report.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #FFD700;border-radius: 12px;">Reports</a></th>
							echo '<th><a href="newadmin.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #FFD700;border-radius: 12px;">New Admin</a></th>';
					}
				?>
			</tr>
		</table>
	</div>
	<div class="home-welcome" style="text-align: center; padding-bottom:20px;">
		<div class="home-welcome-text">
			<h1>Welcome To Raj Vans Ethnic Wear Admin Panel</h1>
			<h2>Manage Your Ethnic Collection With Ease!</h2>
		</div>
	</div>
</body>
</html>
