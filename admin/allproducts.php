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

<!doctype html>
<html>
<head>
	<title>Welcome to Raj Vans Ethnic Wear</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body class="home-welcome-text" style="background-image: url(../image/homebackgrndimg2.png);">
	<div class="homepageheader">
		<div class="signinButton loginButton">
			<div class="uiloginbutton signinButton loginButton" style="margin-right: 40px;">
				<?php if ($user!="") { echo '<a style="text-decoration: none;color: #fff;" href="logout.php">LOG OUT</a>'; } ?>
			</div>
			<div class="uiloginbutton signinButton loginButton">
				<?php 
					if ($user!="") {
						echo '<a style="text-decoration: none;color: #fff;" href="login.php">Hi '.$uname_db.'</br><span style="color: #de2a74">'.$utype_db.'</span></a>';
					} else {
						echo '<a style="text-decoration: none;color: #fff;" href="login.php">LOG IN</a>';
					}
				?>
			</div>
		</div>
		<div style="float: left; margin: 5px 0px 0px 23px;">
			<a href="index.php"><img style="height: 75px; width: 230px;" src="../image/logo.jpg"></a>
		</div>
	</div>

	<div class="categolis">
		<table>
			<tr>
				<th><a href="index.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color:#e6b7b8;border-radius: 12px;">Home</a></th>
			</tr>
		</table>
	</div>

	<div>
		<form action="editproduct.php" method="GET">
			<table class="rightsidemenu">
				<tr style="font-weight: bold;" colspan="11" bgcolor="#4DB849">
					<th>Select</th>
					<th>Id</th>
					<th>P Name</th>
					<th>Description</th>
					<th>Price</th>
					<th>Piece</th>
					<th>Available</th>
					<th>Category</th>
					<th>Type</th>
					<th>Item</th>
					<th>P Code</th>
					<th>Image</th>
				</tr>

				<?php
				$query = "SELECT * FROM products ORDER BY id DESC";
				$run = mysqli_query($con, $query);
				while ($row = mysqli_fetch_assoc($run)) {
					$id = $row['id'];
					$pName = substr($row['pName'], 0, 50);
					$descri = $row['description'];
					$price = $row['price'];
					$piece = $row['piece'];
					$available = $row['available'];
					$category = $row['category'];
					$type = $row['type'];
					$item = $row['item'];
					$pCode = $row['pCode'];
					$picture = $row['picture'];
				?>

				<tr>
					<td><input type="checkbox" name="selected_products[]" value="<?php echo $id; ?>"></td>
					<td><?php echo $id; ?></td>
					<td><?php echo $pName; ?></td>
					<td><?php echo $descri; ?></td>
					<td><?php echo $price; ?></td>
					<td><?php echo $piece; ?></td>
					<td><?php echo $available; ?></td>
					<td><?php echo $category; ?></td>
					<td><?php echo $type; ?></td>
					<td><?php echo $item; ?></td>
					<td><?php echo $pCode; ?></td>
					<td><img src="../image/product/<?php echo $item; ?>/<?php echo $picture; ?>" style="height: 75px; width: 75px;"></td>
				</tr>
				<?php } ?>
			</table>

			<br>
			<input type="submit" value="Edit Selected" style="padding: 10px; background-color: #4DB849; color: white; border: none; border-radius: 5px; cursor: pointer;">
		</form>
	</div>
</body>
</html>
