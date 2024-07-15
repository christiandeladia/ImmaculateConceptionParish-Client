<?php
require_once "../connect.php";

function updateProductStock($pdo, $product_name, $product_quantity) {
    // Prepare SQL statement to update product stock
    $sql = "UPDATE inventory 
            SET product_stock = product_stock - ? 
            WHERE product_name = ?";
    $stmt = $pdo->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->execute([$product_quantity, $product_name]);

    // Check if the update was successful
    if ($stmt->rowCount() > 0) {
        // Check if the product stock is 0 and update status
        $sql_check_stock = "SELECT product_stock FROM inventory WHERE product_name = ?";
        $stmt_check_stock = $pdo->prepare($sql_check_stock);
        $stmt_check_stock->execute([$product_name]);
        $stock = $stmt_check_stock->fetchColumn();

        if ($stock === 0) {
            // Update status to 'Out of Stock'
            $sql_update_status = "UPDATE inventory SET status = 'Out of Stock' WHERE product_name = ?";
            $stmt_update_status = $pdo->prepare($sql_update_status);
            $stmt_update_status->execute([$product_name]);
        }

        return true; // Stock updated successfully
    } else {
        return false; // Failed to update stock
    }
}
// Check if checking out
if (isset($_POST['cart_checkout'])) {
    session_start(); // Start session if not already started

    $auth = $_SESSION['auth_login'];
    $cart_name = 'cart-' . $auth['id'] . '-cart';

    // Create cart if not exists
    if (!isset($_SESSION[$cart_name])) {
        $_SESSION[$cart_name] = [];
    }

    // Extract order details from POST data
    $order_username = $_POST['order_username'];
    $order_phonenumber = $_POST['order_phonenumber'];
    $order_address = $_POST['order_address'];
    $order_shipping_fee = $_POST['order_shipping_fee'];
    $grandtotal = $_POST['grandtotal'];
    $payment_method = "Cash on Delivery";
    $order_courier = "J&T Express";
    $status = "1";
    $group_order = "PICP" . uniqid();
    $auth_id = $auth['id'];

    foreach ($_SESSION[$cart_name] as $cart) {
        extract($cart);
    
        // Calculate grand total
        $subtotal = $product_price * $product_quantity;
        $grand_total += $subtotal;
    
        // Insert order details into orders table
        $sql = "INSERT INTO orders (order_username, order_phonenumber, order_address, order_courier, group_order, customer_id, product_name, product_price, product_quantity, product_image, order_payment, order_shipping_fee, grandtotal, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$order_username, $order_phonenumber, $order_address, $order_courier, $group_order, $auth_id, $product_name, $product_price, $product_quantity, $product_image, $payment_method, $order_shipping_fee, $grandtotal, $status]);
        $order_id = $pdo->lastInsertId();
    
        // Decrease product stock
        updateProductStock($pdo, $product_name, $product_quantity);
    }
    

    // Clear the cart after checkout
    unset($_SESSION[$cart_name]);

    header("location: ../checkout_reciept.php?group_order=$group_order");
    exit;
}

// Remove item and go back to the customer panel
if (isset($product_id)) {
    unset($_SESSION[$cart_name][$product_id]);
    header("location: index.php");
    exit;
}

// Put the item into the cart
if (isset($product_add)) {
    array_push($_SESSION[$cart_name], [
        "name" => $product_name,
        "price" => $product_price,
        "image" => $product_image
    ]);

    $_SESSION['alert'] = "Product added";
}

// Redirect back
header("location: ../index.php");
?>
