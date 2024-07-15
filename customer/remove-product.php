<?php
require_once "../connect.php";

if(isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    if(isset($_SESSION[$cart_name][$product_id])) {
        unset($_SESSION[$cart_name][$product_id]);
        echo "Product removed successfully.";
    } else {
        echo "Product not found in cart.";
    }
} else {
    echo "Invalid request.";
}
?>
