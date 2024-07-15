<?php
  require_once "connect.php";

$id = $_GET['id'];

$query = "SELECT * FROM inventory WHERE id = ?";
$statement = $pdo->prepare($query);
$statement->execute([$id]);
$item = $statement->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $productDescription = $_POST['product_description'];
    $productPrice = $_POST['product_price'];
    $productImage = $_POST['product_image'];

    $query = "UPDATE inventory SET product_name = ?, product_description = ?, product_price = ?, product_image = ? WHERE id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$productName, $productDescription, $productPrice, $productImage, $id]);

    header('Location: admin.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title>
</head>
<body>
    <h1>Edit Item</h1>
    <form method="post">
        <label>Product Name:</label>
        <input type="text" name="product_name" value="<?php echo $item['product_name']; ?>"><br>
        <label>Description:</label>
        <textarea name="product_description"><?php echo $item['product_description']; ?></textarea><br>
        <label>Price:</label>
        <input type="number" step="0.01" name="product_price" value="<?php echo $item['product_price']; ?>"><br>
        <label>Image URL:</label>
        <input type="text" name="product_image" value="<?php echo $item['product_image']; ?>"><br>
        <button type="submit">Save</button>
    </form>
    <a href="../admin/index.php">Back to Inventory</a>
</body>
</html>
