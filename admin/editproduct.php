<?php 
include ("../inc/connect.inc.php"); 
ob_start();
session_start();

if (!isset($_SESSION['admin_login'])) {
    header("location: login.php");
    exit();
}

$user = $_SESSION['admin_login'];
$result = mysqli_query($con, "SELECT * FROM admin WHERE id='$user'");
$get_user_email = mysqli_fetch_assoc($result);
$uname_db = $get_user_email['firstName'];
$utype_db = $get_user_email['type'];

// Check if multiple products are selected
if (!isset($_GET['selected_products'])) {
    header("location: allproducts.php");
    exit();
}

$product_ids = $_GET['selected_products'];
$products = [];

foreach ($product_ids as $product_id) {
    $query = mysqli_query($con, "SELECT * FROM products WHERE id='$product_id'");
    $products[] = mysqli_fetch_assoc($query);
}

// Handle Product Update
if (isset($_POST['update'])) {
    foreach ($product_ids as $product_id) {
        $pname = mysqli_real_escape_string($con, $_POST['pname'][$product_id]);
        $price = mysqli_real_escape_string($con, $_POST['price'][$product_id]);
        $piece = mysqli_real_escape_string($con, $_POST['piece'][$product_id]);
        $available = mysqli_real_escape_string($con, $_POST['available'][$product_id]);
        $type = mysqli_real_escape_string($con, $_POST['type'][$product_id]);
        $item = mysqli_real_escape_string($con, $_POST['item'][$product_id]);
        $pCode = mysqli_real_escape_string($con, $_POST['code'][$product_id]);
        $descri = mysqli_real_escape_string($con, $_POST['descri'][$product_id]);
        $category = mysqli_real_escape_string($con, $_POST['category'][$product_id]);

        $update_query = "UPDATE products SET pName='$pname', price='$price', piece='$piece', description='$descri', available='$available', category='$category', type='$type', item='$item', pCode='$pCode' WHERE id='$product_id'";
        
        if (mysqli_query($con, $update_query)) {
            // Image Upload Handling
            if (!empty($_FILES['profilepic']['name'][$product_id])) {
                $profile_pic_name = $_FILES['profilepic']['name'][$product_id];
                $file_ext = pathinfo($profile_pic_name, PATHINFO_EXTENSION);
                $filename = strtotime(date('Y-m-d H:i:s')) . "." . $file_ext;
                $target_dir = "../image/product/$item/";
                
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                if (move_uploaded_file($_FILES['profilepic']['tmp_name'][$product_id], $target_dir . $filename)) {
                    mysqli_query($con, "UPDATE products SET picture='$filename' WHERE id='$product_id'");
                }
            }
        }
    }
    header("Location: allproducts.php");
    exit();
}

// Handle Product Deletion
if (isset($_POST['delete'])) {
    foreach ($product_ids as $product_id) {
        mysqli_query($con, "DELETE FROM products WHERE id='$product_id'");
    }
    header("Location: allproducts.php");
    exit();
}
?>

<!doctype html>
<html>
<head>
    <title>Edit Product - Raj Vans Ethnic Wear</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Products</h2>
        <?php if (isset($error_message)) echo "<p style='color:red;'>$error_message</p>"; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <?php foreach ($products as $product): ?>
                <fieldset style="margin-bottom: 20px; border: 1px solid #ccc; padding: 15px;">
                    <legend><b>Product ID: <?php echo $product['id']; ?></b></legend>

                    <input type="hidden" name="product_ids[]" value="<?php echo $product['id']; ?>">

                    <label>Product Name:</label>
                    <input type="text" name="pname[<?php echo $product['id']; ?>]" value="<?php echo $product['pName']; ?>" required><br>
                    
                    <label>Price:</label>
                    <input type="text" name="price[<?php echo $product['id']; ?>]" value="<?php echo $product['price']; ?>" required><br>

                    <label>Piece (unit):</label>
                    <input type="text" name="piece[<?php echo $product['id']; ?>]" value="<?php echo $product['piece']; ?>" required><br>

                    <label>Available:</label>
                    <input type="text" name="available[<?php echo $product['id']; ?>]" value="<?php echo $product['available']; ?>" required><br>

                    <label>Description:</label>
                    <input type="text" name="descri[<?php echo $product['id']; ?>]" value="<?php echo $product['description']; ?>" required><br>

                    <label>Item:</label>
                    <select name="item[<?php echo $product['id']; ?>]" required>
                        <option value="Kurta" <?php if($product['item'] == 'Kurta') echo 'selected'; ?>>Kurta</option>
                        <option value="Jacket" <?php if($product['item'] == 'Jacket') echo 'selected'; ?>>Jacket</option>
                        <option value="Shortkurta" <?php if($product['item'] == 'Shortkurta') echo 'selected'; ?>>Shortkurta</option>
                        <option value="Mala" <?php if($product['item'] == 'Mala') echo 'selected'; ?>>Mala</option>
                        <option value="Sherwani" <?php if($product['item'] == 'Sherwani') echo 'selected'; ?>>Sherwani</option>
                        <option value="Mojadi" <?php if($product['item'] == 'Mojadi') echo 'selected'; ?>>Mojadi</option>
                        <option value="safa_dupatta" <?php if($product['item'] == 'safa_dupatta') echo 'selected'; ?>>Safa_dupatta</option>
                    </select><br>

                    <label>Product Code:</label>
                    <input type="text" name="code[<?php echo $product['id']; ?>]" value="<?php echo $product['pCode']; ?>" required><br>

                    <label>Picture:</label>
                    <input type="file" name="profilepic[<?php echo $product['id']; ?>]"><br>

                    <img src="../image/product/<?php echo $product['item']; ?>/<?php echo $product['picture']; ?>" style="height: 75px; width: 75px;"><br>

                </fieldset>
            <?php endforeach; ?>

            <input type="submit" name="update" value="Update Products" style="padding: 10px; background-color: #4DB849; color: white; border: none; border-radius: 5px; cursor: pointer;">
            <input type="submit" name="delete" value="Delete Products" onclick="return confirm('Are you sure you want to delete these products?');" style="padding: 10px; background-color: red; color: white; border: none; border-radius: 5px; cursor: pointer;">
        </form>
    </div>
</body>
</html>
