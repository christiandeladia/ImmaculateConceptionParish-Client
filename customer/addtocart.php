<?php
require_once "../connect.php";
if (!isset($_SESSION['auth_login'])) {
    header("location: index.php");
    exit; // Add an exit to stop execution after redirection
}

$auth = $_SESSION['auth_login'];
$auth_id = $auth['id'];
$cart_name = 'cart-' . $auth['id'] . '-cart';

if (!isset($_SESSION[$cart_name])) {
    $_SESSION[$cart_name] = [];
}

extract($_POST);

if (isset($product_id)) {
    unset($_SESSION[$cart_name][$product_id]);
    header("location: ../cart.php");
    exit;
}

if (isset($product_add)) {
    // Check if a product with the same name is already in the cart
    $found = false;
    foreach ($_SESSION[$cart_name] as &$item) {
        if ($item['product_name'] == $product_name) {
            $found = true;
            // Check if adding another item exceeds available stock
            if ($item['product_quantity'] + 1 <= $item['product_stock']) {
                // Increase the quantity
                $item['product_quantity'] += 1;
            } else {
                $_SESSION['alert'] = "Sorry, the '$product_name' reached the maximum stock available";
                header("location: ../product.php");
                exit; // Add an exit to stop execution after redirection
            }
            break;
        }
    }
    if (!$found) {
        // If not found, add it to the cart with a quantity of 1
        array_push($_SESSION[$cart_name], [
            "product_name" => $product_name,
            "product_price" => $product_price,
            "product_stock" => $product_stock,
            "product_quantity" => 1, // Set quantity to 1
            "product_image" => $product_image
        ]);
    }

    $_SESSION['alert'] = "Product added";
    header("location: ../product.php");
    exit; // Add an exit to stop execution after redirection
}
?>
