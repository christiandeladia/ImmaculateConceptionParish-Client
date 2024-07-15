<?php
// Start a session (if not already started)
require_once "../connect.php";

// Check if the request is coming via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the product_id and new_quantity are provided in the POST data
    if (isset($_POST['product_id']) && isset($_POST['new_quantity'])) {
        // Sanitize and validate the input
        $product_id = intval($_POST['product_id']);
        $new_quantity = intval($_POST['new_quantity']);

        // Ensure the product_id is valid and non-negative
        if ($product_id >= 0) {
            // Get the current user's cart from the session
            $auth = $_SESSION['auth_login'];
            $cart_name = 'cart-' . $auth['id'] . '-cart';

            // Check if the product exists in the cart
            if (isset($_SESSION[$cart_name][$product_id])) {
                // Update the product's quantity in the cart
                $_SESSION[$cart_name][$product_id]['product_quantity'] = $new_quantity;

                // Respond with a success message (you can customize this as needed)
                echo "Cart updated successfully";
            } else {
                // Product not found in the cart
                // Respond with an error message or appropriate status
                echo "Product not found in the cart";
            }
        } else {
            // Invalid product_id
            // Respond with an error message or appropriate status
            echo "Invalid product ID";
        }
    } else {
        // Invalid or missing POST data
        // Respond with an error message or appropriate status
        echo "Invalid POST data";
    }
} else {
    // Request method is not POST
    // Respond with an error message or appropriate status
    echo "Invalid request method";
}
?>
