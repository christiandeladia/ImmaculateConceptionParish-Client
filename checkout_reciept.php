<?php
// Include the connect.php file to establish a database connection
include_once "connect.php";

// Check if user is logged in
if (!isset($_SESSION['auth_login'])) {
    header("Location: index.php");
    exit; // Stop further execution
}

// Check if the 'order_id' parameter is set in the URL
if (!isset($_GET['group_order'])) {
    echo "No order ID provided.";
    exit;
}

// Sanitize the 'order_id' parameter
$auth_id = $_SESSION['auth_login']['id'];
// Set a default value for $group_order (or get it from somewhere)
$group_order = $_GET['group_order'];

// Debugging: Echo the SQL query and the sanitized order_id
$query = "SELECT * FROM `orders` WHERE `customer_id` = ? AND `group_order` = ? ORDER BY date_added DESC;";
$stmt_products = $conn->prepare($query);
$stmt_products->bind_param("is", $auth_id, $group_order);
if (!$stmt_products->execute()) {
    echo "Error executing statement: " . $stmt_products->error;
    exit;
}

$result_products = $stmt_products->get_result();

// Check if any products were found
if ($result_products->num_rows > 0) {
    // Fetch the status from the first row since it should be the same for all rows
    $row = $result_products->fetch_assoc();
    $status = $row["status"];
    $order_username = $row["order_username"];
    $date_added = $row["date_added"];
    $order_phonenumber = $row["order_phonenumber"];
    $customer_id = $row["customer_id"];
    $order_address = $row["order_address"];
    $order_payment = $row["order_payment"];
    $order_courier = $row["order_phonenumber"];
    $order_shipping_fee = $row["order_shipping_fee"];
    
    

    // Reset the result set pointer
    $result_products->data_seek(0);

    // Display the receipt using the fetched data
    ?>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Receipt</title>
        <style>
    button.btn.btn-success {
    color: #ffff;
    background-color: #039103;
    border: green;
    margin-left: 5px;
    min-height: 30px;
    min-width: 40%;
    border-radius: 5px;
    font-size: 15px;
    border: 3px solid #039103;
    cursor: pointer;
    text-align: center;
    padding: 10px 10px;
}
        </style>
    </head>
    <body style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
        <table style="max-width:670px;margin:50px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px green;">
            <thead>
                <tr>
                    <th style="text-align:left; padding-bottom: 20px;"><img style="max-width: 250px;" src="https://res.cloudinary.com/dqtbveriz/image/upload/v1711791860/logo2_bfmyws.png" alt="ICP LOGO"></th>
                    <th style="text-align:right;font-weight:1000; font"> E-INVOICE</th>
                    
                </tr>
            </thead>
            <tbody>
                <!-- Calculate and display grand total -->
                <?php
                $grand_total = 0;

                $subtotal = 0; // Initialize subtotal outside the loop
                while ($product = $result_products->fetch_assoc()) {
                    $product_quantity = $product['product_quantity'];
                    $product_price = $product['product_price'];
                    $subtotal += $product_quantity * $product_price;
                }
                $grand_total = $subtotal + $order_shipping_fee;
                ?>
                <tr>
                    <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
                        <p style="margin:0 0 10px 0;padding:0;font-size:14px; float:right;"><span style="display:block;font-weight:bold;font-size:13px">Purchased Date</span> <?= $date_added ?></p>
                        <strong>Transaction ID: </strong> <?= $group_order ?><br>
                        <strong>Shipping Fee: </strong> ₱ <?= number_format($order_shipping_fee, 2) ?><br>
                        <strong>Subtotal: </strong> ₱ <?= number_format($subtotal, 2) ?><br>
                        <strong>Grand Total: ₱ <?= number_format($grand_total, 2) ?></strong><br>
                        <strong >Status: </strong><b style="color:green;font-weight:normal;margin:0">Order Placed</b>
                        
                    </td>
                </tr>
                <tr>
                    <td style="height:20px;"></td>
                </tr>
                <!-- Loop through each product and display details -->
                <?php
                // Reset the result set pointer
                $result_products->data_seek(0);

                while ($product = $result_products->fetch_assoc()) {
                    ?>
                    <tr>
                        <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
                            <!-- Product details -->
                            <p style="font-size:14px;margin:0 0 0 0;">
                                <span style="font-weight:bold;display:inline-block;max: width 146px;"></span>
                                <img src="image/<?= $product["product_image"] ?>" alt="Product Image" style="max-width:50px; float: right;">
                            </p>
                            <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:150px">Product</span><b style="font-weight:normal;margin:0"><?= $product["product_name"] ?></b></p>
                            <p style="font-size:14px;margin:0 0 0 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Order amount</span>₱ <?= $product["product_price"] ?></p>
                            <p style="font-size:14px;margin:0 0 0 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Product Quantity</span><?= $product["product_quantity"] ?></p>
                        </td>
                    </tr>
                <?php } ?>
                <!-- Other details -->
                <tr>
                    <td style="height:35px;"></td>
                </tr>
                <tr>
                    <td style="width:50%;padding:20px;vertical-align:top">
                        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px">Name</span> <?= $order_username ?></p>
                        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">ID No.</span> <?= $customer_id ?></p>
                    </td>
                    <td style="width:50%;padding:20px;vertical-align:top">
                        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Address</span><?= $order_address ?></p>
                        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Order Payment</span><?= $order_payment ?></p>
                        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;font-size:13px;">Phone Number</span><?= $order_phonenumber ?></p>
                    </td>
                    <td>
                        <div style="margin-top: 200px;">
                        <a href="send_checkout.php?group_order=<?= $group_order ?>"><button type="button" class="btn btn-success">OK</button></a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
    </html>
    <?php
} else {
    echo "Order not found.";
}
?>
