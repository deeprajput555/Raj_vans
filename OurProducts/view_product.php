<?php include ( "../inc/connect.inc.php" ); ?>
<?php 
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	$user = "";
}
else {
	$user = $_SESSION['user_login'];
	$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
		$get_user_email = mysqli_fetch_assoc($result);
			$uname_db = $get_user_email['firstName'];
}
if (isset($_REQUEST['pid'])) {
	
	$pid = mysqli_real_escape_string($con, $_REQUEST['pid']);
}else {
	header('location: index.php');
}


$getposts = mysqli_query($con, "SELECT * FROM products WHERE id ='$pid'") or die(mysqlI_error($con));
					if (mysqli_num_rows($getposts)) {
						$row = mysqli_fetch_assoc($getposts);
						$id = $row['id'];
						$pName = $row['pName'];
						$price = $row['price'];
						$piece=$row['piece'];
						$description = $row['description'];
						$picture = $row['picture'];
						$item = $row['item'];
						$available =$row['available'];
					}	


if (isset($_POST['addcart'])) {
	$getposts = mysqli_query($con, "SELECT * FROM cart WHERE pid ='$pid' AND uid='$user'") or die(mysqlI_error($con));
	if (mysqli_num_rows($getposts)) {
		header('location: ../mycart.php?uid='.$user.'');
	}else{
		if(mysqli_query($con, "INSERT INTO cart (uid,pid,quantity) VALUES ('$user','$pid', 1)")){
			header('location: ../mycart.php?uid='.$user.'');
		}else{
			header('location: index.php');
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>View-Prod</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<?php include ( "../inc/mainheader.inc.php" ); ?>
	<div class="categolis">
		<table>
		<tr>
				<th>
					<a href="OurProducts/Jacket.php" style="text-decoration: none;color:#040403 ;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Jacket</a>
				</th>
				<th><a href="OurProducts/Kurta.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Kurta</a></th>
				<th><a href="OurProducts/Mala.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Mala</a></th>
				<th><a href="OurProducts/Mojadi.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Mojadi</a></th>
				<th><a href="OurProducts/Safa_dupatta.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Safa_dupatta</a></th>
				<th><a href="OurProducts/Sherwani.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Sherwani</a></th>
				<th><a href="OurProducts/Shortkurta.php" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: #e6b7b8;border-radius: 12px;">Shortkurta</a></th>
			</tr>
		</table>
	</div>
	<div style="margin: 0 97px; padding: 10px">

		<?php 
			echo '
				<div style="float: left;">
				<div>
					<img src="../image/product/'.$item.'/'.$picture.'" style="height: 500px; width: 500px; padding: 2px; border: 2px solid #c7587e;">
				</div>
				</div>
				<div style="float: right;width: 40%;color: #067165;background-color: #ddd;padding: 10px;">
					<div style="">
						<h3 style="font-size: 25px; font-weight: bold; ">'.$pName.'</h3><hr>
						<h3 style="padding: 20px 0 0 0; font-size: 20px;">Price: '.$price.'Php</h3><hr>
						<h3 style="padding: 20px 0 0 0; font-size: 22px; ">Pieces:'.$piece.'</h3>
						<h3 style="padding: 20px 0 0 0; font-size: 22px; ">Description:</h3>
						<p>
							'.$description.'
						</p>

						<div>
    <h3 style="padding: 20px 0 5px 0; font-size: 20px;">Want to buy this product?</h3>
    <div id="srcheader">
        <!-- Size Selection Dropdown -->
        <label for="size">Select Size:</label>
        <select id="size" name="size" required>
            <option value="" disabled selected>Select size</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
            <option value="XXL">XXL</option>
        </select>

        <br/><br/>

        <form id="cartForm" method="post" action="">
            <input type="hidden" name="selected_size" id="selected_size_cart">
            <button type="submit" name="addcart" class="srcbutton" onclick="return setSize("selected_size_cart")>Add to cart</button>
        </form>
        
        <br/>

        <form id="orderForm" method="post" action="../orderform.php?poid=<?php echo $pid; ?>">
            <input type="hidden" name="selected_size" id="selected_size_order">
            <button type="submit" class="srcbutton" onclick="return setSize("selected_size_order")>Order Now</button>
        </form>

        <div class="srcclear"></div>
    </div>
</div>

<script>
    function setSize(hiddenInputId) {
        let selectedSize = document.getElementById("size").value;
        if (!selectedSize) {
            alert("Please select a size.");
            return false; // Prevent form submission
        }
        document.getElementById(hiddenInputId).value = selectedSize;
        return true; // Allow form submission
    }
</script>


					</div>
				</div>

			';
		?>

	</div>
</body>
</html>