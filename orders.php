<?php
require "connect.php";
if (!isset($_SESSION['auth_login'])) {
    header("location: customer/login.php");
    exit;
}
$auth = $_SESSION['auth_login'];
$auth_id = $auth['id'];
?>
<?php
    $auth = $_SESSION['auth_login'];
    $auth_id = $auth['id'];
    
    // Query to retrieve orders for the logged-in customer
    $query = "SELECT * FROM orders WHERE customer_id = $auth_id ORDER BY group_order";
    $result = mysqli_query($conn, $query);
    
    $combinedRows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $groupOrder = $row['group_order'];
        if (isset($combinedRows[$groupOrder])) {
            $combinedRows[$groupOrder]['image'][] = $row['product_image'];
            $combinedRows[$groupOrder]['product_name'][] = $row['product_name'];
            $combinedRows[$groupOrder]['product_price'][] = $row['product_price'];
            $combinedRows[$groupOrder]['product_quantity'][] = $row['product_quantity'];
            $combinedRows[$groupOrder]['id'][] = $row['id'];
            $combinedRows[$groupOrder]['order_username'][] = $row['order_username'];
            $combinedRows[$groupOrder]['order_address'][] = $row['order_address'];
            $combinedRows[$groupOrder]['order_payment'][] = $row['order_payment'];
            $combinedRows[$groupOrder]['order_shipping_fee'][] = $row['order_shipping_fee'];
            $combinedRows[$groupOrder]['order_phonenumber'][] = $row['order_phonenumber'];
            $combinedRows[$groupOrder]['date_added'][] = $row['date_added'];
            $combinedRows[$groupOrder]['status'][] = $row['status'];
            $combinedRows[$groupOrder]['trackingNumber'][] = $row['trackingNumber'];
            $combinedRows[$groupOrder]['reason'][] = $row['reason'];
            $combinedRows[$groupOrder]['grandtotal'][] = $row['grandtotal'];
        } else {
            $combinedRows[$groupOrder] = [
                'image' => [$row['product_image']],
                'product_name' => [$row['product_name']],
                'product_price' => [$row['product_price']],
                'product_quantity' => [$row['product_quantity']],
                'id' => [$row['id']],
                'order_username' => [$row['order_username']],
                'order_phonenumber' => [$row['order_phonenumber']],
                'order_address' => [$row['order_address']],
                'order_payment' => [$row['order_payment']],
                'order_shipping_fee' => [$row['order_shipping_fee']],
                'date_added' => [$row['date_added']],
                'status' => [$row['status']],
                'trackingNumber' => [$row['trackingNumber']],
                'reason' => [$row['reason']],
                'grandtotal' => [$row['grandtotal']]
            ];
        }
    }
    
?>
<?php
function countStatusOneOccurrences($combinedRows) {
    $countStatusOne = 0; // Initialize counter for status 1
    foreach ($combinedRows as $groupOrder => $data) {
        if ($data['status'][0] == 1) { // Check if status is 1
            $countStatusOne++; // Increment counter for status 1
        }
    }
    return $countStatusOne;
}
$totalStatus1 = countStatusOneOccurrences($combinedRows);
?>
<?php
function countStatusTwoOccurrences($combinedRows) {
    $countStatusTwo = 0; // Initialize counter for status 2
    foreach ($combinedRows as $groupOrder => $data) {
        if ($data['status'][0] == 2) { // Check if status is 2
            $countStatusTwo++; // Increment counter for status 2
        }
    }
    return $countStatusTwo;
}
$totalStatus2 = countStatusTwoOccurrences($combinedRows);
?>

<?php
function countStatus3Occurrences($combinedRows) {
    $countStatus3 = 0; // Initialize counter for status 2
    foreach ($combinedRows as $groupOrder => $data) {
        if ($data['status'][0] == 3) { // Check if status is 2
            $countStatus3++; // Increment counter for status 2
        }
    }
    return $countStatus3;
}
$totalStatus3 = countStatus3Occurrences($combinedRows);
?>
<?php
function countStatus4Occurrences($combinedRows) {
    $countStatus4 = 0; // Initialize counter for status 2
    foreach ($combinedRows as $groupOrder => $data) {
        if ($data['status'][0] == 4) { // Check if status is 2
            $countStatus4++; // Increment counter for status 2
        }
    }
    return $countStatus4;
}
$totalStatus4 = countStatus4Occurrences($combinedRows);
?>
<?php
function countStatus5Occurrences($combinedRows) {
    $countStatus5 = 0; // Initialize counter for status 2
    foreach ($combinedRows as $groupOrder => $data) {
        if ($data['status'][0] == 5) { // Check if status is 2
            $countStatus5++; // Increment counter for status 2
        }
    }
    return $countStatus5;
}
$totalStatus5 = countStatus5Occurrences($combinedRows);
?>
<?php
$totalStatusall = $totalStatus1 + $totalStatus2 + $totalStatus3 + $totalStatus4 + $totalStatus5
?>
<?php
// Define status text array
$status = array(
    1 => "Order Placed",
    2 => "To Ship",
    3 => "To Receive",
    4 => "Completed",
    5 => "Cancelled"
);
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" />
    <title>View Orders - ICP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="style/nav.css">
    <link rel="stylesheet" href="style/footer.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</head>

<?php include 'nav.php';?>

<body>
    <!-- <a class="btn btn-info btn-sm m-3" href="product.php">Back to Orders</a> -->
    <div style="background-color: #f5f5f5">
        <br>
        <a class="back_button" href="product.php">
            <i class='bx bx-arrow-back' style='font-size:12px'></i>Back
        </a>

        <section class="">
            <style>
            .orderContainer {
                background-color: #fff;
                width: 60%;
                /* height: 650px; */
                margin: 2rem;
                padding: 1rem 1rem;
                border-radius: 1rem;
                margin: 1% auto;
                padding: 20px;
                /* border: 1px solid #888; */
                box-shadow: 0 0 50px 0 rgba(0, 0, 0, 0.2);

            }

            header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                font-size: 16px;
                /* margin-bottom: 2rem; */
                padding: 0;
            }

            h3 {
                font-size: 18px;
                font-weight: bolder;
            }

            .orderHeader {
                display: flex;
                align-items: center;
            }

            .orderHeader h3 {
                font-size: 18px;
                font-weight: bolder;
            }
            </style>
            <div class="orderContainer">
                <header>
                    <div class="orderHeader">
                        <h3>My Orders</h3>
                    </div>
                </header>
                <hr>
                <div class="container">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="OrderPlaced-tab" data-toggle="tab" href="#OrderPlaced"
                                role="tab" aria-controls="OrderPlaced" aria-selected="true">Order
                                Placed<?php if ($totalStatus1 > 0): ?><span
                                    id="num-of-notif"><?php echo $totalStatus1; ?></span><?php endif; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ToShip-tab" data-toggle="tab" href="#ToShip" role="tab"
                                aria-controls="ToShip" aria-selected="false">To
                                Ship<?php if ($totalStatus2 > 0): ?><span
                                    id="num-of-notif"><?php echo $totalStatus2; ?></span><?php endif; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="ToReceive-tab" data-toggle="tab" href="#ToReceive" role="tab"
                                aria-controls="ToReceive" aria-selected="false">To
                                Receive<?php if ($totalStatus3 > 0): ?><span
                                    id="num-of-notif"><?php echo $totalStatus3; ?></span><?php endif; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="Completed-tab" data-toggle="tab" href="#Completed" role="tab"
                                aria-controls="Completed"
                                aria-selected="false">Completed<?php if ($totalStatus4 > 0): ?><span
                                    id="num-of-notif"><?php echo $totalStatus4; ?></span><?php endif; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="Cancelled-tab" data-toggle="tab" href="#Cancelled" role="tab"
                                aria-controls="Cancelled"
                                aria-selected="false">Cancelled<?php if ($totalStatus5 > 0): ?><span
                                    id="num-of-notif"><?php echo $totalStatus5; ?></span><?php endif; ?></a>
                        </li>
                        <!-- Add more tabs as needed -->
                    </ul>


                    <div class="tab-content" id="myTabContent" style="background-color: #fff; padding: 20px 30px;">

                        <!-- OrderPlaced -->

                        <div class="tab-pane fade show active" id="OrderPlaced" role="tabpanel"
                            aria-labelledby="OrderPlaced-tab">

                            <?php if( $totalStatus1 == 0 ){?>

                            <h1 style="text-align: center; font-size: 16px; color: #a9a2a2; margin: 100px 0;">
                                <i class="fas fa-shopping-cart"></i><br>No Orders
                                Yet
                            </h1>
                            <?php }else{?>
                            <div class="row">
                                <div class="col-lg">
                                    <?php foreach ($combinedRows as $groupOrder => $data) { ?>
                                    <?php if ($data['status'][0] == 1) { ?>
                                    <div class="card mt-4">
                                        <div class="card-body p-0 table-responsive ">
                                            <div style="display: flex; justify-content: space-between;">
                                                <h4 class="p-3 mb-0"><?php echo $groupOrder; ?></h4>
                                                <h5 class="text-primary p-3 mb-0">
                                                    <?php echo $status[$data['status'][0]]; ?></h5>

                                            </div>
                                            <table class="table mb-0 text-right">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Description</th>
                                                        <th scope="col"></th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $totalSubtotal = 0; // Variable to hold total subtotal for the order
                                                        foreach ($data['product_name'] as $index => $productName) { ?>
                                                    <tr style="border-top: none;
                                        border-bottom: none;">
                                                        <td>
                                                            <img src="image/<?php echo $data['image'][$index]; ?>"
                                                                width="50" alt="<?php echo $productName; ?>"><br>
                                                        </td>
                                                        <td class="text-left">
                                                            <?php echo $productName; ?><br><br><br></td>
                                                        <td>
                                                            ₱<?php echo number_format($data['product_price'][$index], 2); ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            x<?php echo $data['product_quantity'][$index]; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php
                                    $subtotal = $data['product_price'][$index] * $data['product_quantity'][$index];
                                    echo '₱' . number_format($subtotal, 2);
                                    $totalSubtotal += $subtotal; // Add current product's subtotal to total subtotal
                                    ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <div style="display: flex; justify-content: space-between;">
                                                <div class="text-left p-3">
                                                    <span class="text-muted">Payment Method:</span>
                                                    <span
                                                        class="badge badge-success"><?php echo $data['order_payment'][0]; ?></span><br>
                                                    <span class="text-muted">Shipping Fee:</span>
                                                    <span><?php echo number_format($data['order_shipping_fee'][0], 2); ?>
                                                    </span><br>
                                                    <span class="text-muted">Order Total:</span>
                                                    <strong><?php echo number_format($data['grandtotal'][0], 2); ?></strong>
                                                </div>
                                                <a href="view_orders.php?order_id=<?php echo $groupOrder; ?>"
                                                    class="btn btn-primary btn-sm h-25">View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>


                        <div class="tab-pane fade" id="ToShip" role="tabpanel" aria-labelledby="ToShip-tab">
                            <?php if( $totalStatus2 == 0 ){?>
                            <h1 style="text-align: center; font-size: 16px; color: #a9a2a2; margin: 100px 0;">
                                <i class="fas fa-shopping-cart"></i><br>No Orders
                                Yet
                            </h1>
                            <?php }else{?>
                            <div class="row">
                                <div class="col-lg">
                                    <?php foreach ($combinedRows as $groupOrder => $data) { ?>
                                    <?php if ($data['status'][0] == 2) { ?>
                                    <div class="card mt-4">
                                        <div class="card-body p-0 table-responsive ">
                                            <div style="display: flex; justify-content: space-between;">
                                                <h4 class="p-3 mb-0"><?php echo $groupOrder; ?></h4>
                                                <h5 class="text-primary p-3 mb-0">
                                                    <?php echo $status[$data['status'][0]]; ?></h5>

                                            </div>
                                            <table class="table mb-0 text-right">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Description</th>
                                                        <th scope="col"></th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $totalSubtotal = 0; // Variable to hold total subtotal for the order
                                                        foreach ($data['product_name'] as $index => $productName) { ?>
                                                    <tr style="border-top: none;
                                        border-bottom: none;">
                                                        <td>
                                                            <img src="image/<?php echo $data['image'][$index]; ?>"
                                                                width="50" alt="<?php echo $productName; ?>"><br>
                                                        </td>
                                                        <td class="text-left">
                                                            <?php echo $productName; ?><br><br><br></td>
                                                        <td>
                                                            ₱<?php echo number_format($data['product_price'][$index], 2); ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            x<?php echo $data['product_quantity'][$index]; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php
                                    $subtotal = $data['product_price'][$index] * $data['product_quantity'][$index];
                                    echo '₱' . number_format($subtotal, 2);
                                    $totalSubtotal += $subtotal; // Add current product's subtotal to total subtotal
                                    ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <div style="display: flex; justify-content: space-between;">
                                                <div class="text-left p-3">
                                                    <span class="text-muted">Payment Method:</span>
                                                    <span
                                                        class="badge badge-success"><?php echo $data['order_payment'][0]; ?></span><br>
                                                    <span class="text-muted">Shipping Fee:</span>
                                                    <span><?php echo $data['order_shipping_fee'][0]; ?></span><br>
                                                    <span class="text-muted">Order Total:</span>
                                                    <strong><?php echo $data['grandtotal'][0]; ?></strong>
                                                </div>
                                                <a href="view_orders.php?order_id=<?php echo $groupOrder; ?>"
                                                    class="btn btn-primary btn-sm h-25">View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <div class="tab-pane fade" id="ToReceive" role="tabpanel" aria-labelledby="ToReceive-tab">
                            <?php if( $totalStatus3 == 0 ){?>
                            <h1 style="text-align: center; font-size: 16px; color: #a9a2a2; margin: 100px 0;">
                                <i class="fas fa-shopping-cart"></i><br>No Orders
                                Yet
                            </h1>
                            <?php }else{?>
                            <div class="row">
                                <div class="col-lg">
                                    <?php foreach ($combinedRows as $groupOrder => $data) { ?>
                                    <?php if ($data['status'][0] == 3) { ?>
                                    <div class="card mt-4">
                                        <div class="card-body p-0 table-responsive ">
                                            <div style="display: flex; justify-content: space-between;">
                                                <h4 class="p-3 mb-0"><?php echo $groupOrder; ?></h4>
                                                <h5 class="text-primary p-3 mb-0">
                                                    <?php echo $status[$data['status'][0]]; ?></h5>

                                            </div>
                                            <table class="table mb-0 text-right">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Description</th>
                                                        <th scope="col"></th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $totalSubtotal = 0; // Variable to hold total subtotal for the order
                                                        foreach ($data['product_name'] as $index => $productName) { ?>
                                                    <tr style="border-top: none;
                                        border-bottom: none;">
                                                        <td>
                                                            <img src="image/<?php echo $data['image'][$index]; ?>"
                                                                width="50" alt="<?php echo $productName; ?>"><br>
                                                        </td>
                                                        <td class="text-left">
                                                            <?php echo $productName; ?><br><br><br></td>
                                                        <td>
                                                            ₱<?php echo number_format($data['product_price'][$index], 2); ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            x<?php echo $data['product_quantity'][$index]; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php
                                    $subtotal = $data['product_price'][$index] * $data['product_quantity'][$index];
                                    echo '₱' . number_format($subtotal, 2);
                                    $totalSubtotal += $subtotal; // Add current product's subtotal to total subtotal
                                    ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <div style="display: flex; justify-content: space-between;">
                                                <div class="text-left p-3">
                                                    <span class="text-muted">Payment Method:</span>
                                                    <span
                                                        class="badge badge-success"><?php echo $data['order_payment'][0]; ?></span><br>
                                                    <span class="text-muted">Shipping Fee:</span>
                                                    <span><?php echo $data['order_shipping_fee'][0]; ?></span><br>
                                                    <span class="text-muted">Order Total:</span>
                                                    <strong><?php echo $data['grandtotal'][0]; ?></strong>
                                                </div>
                                                <a href="view_orders.php?order_id=<?php echo $groupOrder; ?>"
                                                    class="btn btn-primary btn-sm h-25">View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <div class="tab-pane fade" id="Completed" role="tabpanel" aria-labelledby="Completed-tab">
                            <?php if( $totalStatus4 == 0 ){?>
                            <h1 style="text-align: center; font-size: 16px; color: #a9a2a2; margin: 100px 0;">
                                <i class="fas fa-shopping-cart"></i><br>No Orders
                                Yet
                            </h1>
                            <?php }else{?>
                            <div class="row">
                                <div class="col-lg">
                                    <?php foreach ($combinedRows as $groupOrder => $data) { ?>
                                    <?php if ($data['status'][0] == 4) { ?>
                                    <div class="card mt-4">
                                        <div class="card-body p-0 table-responsive ">
                                            <div style="display: flex; justify-content: space-between;">
                                                <h4 class="p-3 mb-0"><?php echo $groupOrder; ?></h4>
                                                <h5 class="text-primary p-3 mb-0">
                                                    <?php echo $status[$data['status'][0]]; ?></h5>

                                            </div>
                                            <table class="table mb-0 text-right">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Description</th>
                                                        <th scope="col"></th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $totalSubtotal = 0; // Variable to hold total subtotal for the order
                                                        foreach ($data['product_name'] as $index => $productName) { ?>
                                                    <tr style="border-top: none;
                                        border-bottom: none;">
                                                        <td>
                                                            <img src="image/<?php echo $data['image'][$index]; ?>"
                                                                width="50" alt="<?php echo $productName; ?>"><br>
                                                        </td>
                                                        <td class="text-left">
                                                            <?php echo $productName; ?><br><br><br></td>
                                                        <td>
                                                            ₱<?php echo number_format($data['product_price'][$index], 2); ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            x<?php echo $data['product_quantity'][$index]; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php
                                    $subtotal = $data['product_price'][$index] * $data['product_quantity'][$index];
                                    echo '₱' . number_format($subtotal, 2);
                                    $totalSubtotal += $subtotal; // Add current product's subtotal to total subtotal
                                    ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <div style="display: flex; justify-content: space-between;">
                                                <div class="text-left p-3">
                                                    <span class="text-muted">Payment Method:</span>
                                                    <span
                                                        class="badge badge-success"><?php echo $data['order_payment'][0]; ?></span><br>
                                                    <span class="text-muted">Shipping Fee:</span>
                                                    <span><?php echo $data['order_shipping_fee'][0]; ?></span><br>
                                                    <span class="text-muted">Order Total:</span>
                                                    <strong><?php echo $data['grandtotal'][0]; ?></strong>
                                                </div>
                                                <a href="view_orders.php?order_id=<?php echo $groupOrder; ?>"
                                                    class="btn btn-primary btn-sm h-25">View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <div class="tab-pane fade" id="Cancelled" role="tabpanel" aria-labelledby="Cancelled-tab">
                            <?php if( $totalStatus5 == 0 ){?>
                            <h1 style="text-align: center; font-size: 16px; color: #a9a2a2; margin: 100px 0;">
                                <i class="fas fa-shopping-cart"></i><br>No Orders
                                Yet
                            </h1>
                            <?php }else{?>
                            <div class="row">
                                <div class="col-lg">
                                    <?php foreach ($combinedRows as $groupOrder => $data) { ?>
                                    <?php if ($data['status'][0] == 5) { ?>
                                    <div class="card mt-4">
                                        <div class="card-body p-0 table-responsive ">
                                            <div style="display: flex; justify-content: space-between;">
                                                <h4 class="p-3 mb-0"><?php echo $groupOrder; ?></h4>
                                                <h5 class="text-primary p-3 mb-0">
                                                    <?php echo $status[$data['status'][0]]; ?></h5>

                                            </div>
                                            <table class="table mb-0 text-right">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Description</th>
                                                        <th scope="col"></th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $totalSubtotal = 0; // Variable to hold total subtotal for the order
                                                        foreach ($data['product_name'] as $index => $productName) { ?>
                                                    <tr style="border-top: none;
                                        border-bottom: none;">
                                                        <td>
                                                            <img src="image/<?php echo $data['image'][$index]; ?>"
                                                                width="50" alt="<?php echo $productName; ?>"><br>
                                                        </td>
                                                        <td class="text-left">
                                                            <?php echo $productName; ?><br><br><br></td>
                                                        <td>
                                                            ₱<?php echo number_format($data['product_price'][$index], 2); ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            x<?php echo $data['product_quantity'][$index]; ?><br><br><br>
                                                        </td>
                                                        <td>
                                                            <?php
                                    $subtotal = $data['product_price'][$index] * $data['product_quantity'][$index];
                                    echo '₱' . number_format($subtotal, 2);
                                    $totalSubtotal += $subtotal; // Add current product's subtotal to total subtotal
                                    ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <div style="display: flex; justify-content: space-between;">
                                                <div class="text-left p-3">
                                                    <span class="text-muted">Payment Method:</span>
                                                    <span
                                                        class="badge badge-success"><?php echo $data['order_payment'][0]; ?></span><br>
                                                    <span class="text-muted">Shipping Fee:</span>
                                                    <span><?php echo $data['order_shipping_fee'][0]; ?></span><br>
                                                    <span class="text-muted">Order Total:</span>
                                                    <strong><?php echo $data['grandtotal'][0]; ?></strong>
                                                </div>
                                                <a href="view_orders.php?order_id=<?php echo $groupOrder; ?>"
                                                    class="btn btn-primary btn-sm h-25">View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <!-- Add more tab panes as needed -->
                    </div>

                </div>
            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

<?php include 'footer.php';?>
<style>
/* PROCESS STEPS */
/* @import url('https://fonts.googleapis.com/css?family=Muli&display=swap'); */

:root {
    --line-border-fill: #3FB07C;
    --line-border-empty: #bdbdbd;
    --background-fill: #57DB9E;
}

* {
    box-sizing: border-box;
}

.process_steps {
    /* background-color: rgb(223, 255, 244); */
    font-family: 'Muli', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 20vh;
    overflow: hidden;
    margin: 0;
}

.container_progress {
    text-align: center;
}

.progress-container {
    display: flex;
    justify-content: space-between;
    position: relative;
    max-width: 100%;
    width: 900px;
    margin-bottom: 2.5em;
}

.progress-container::before {
    content: "";
    position: absolute;
    top: 50%;
    left: 0;
    height: 10px;
    width: 100%;
    /* Changed from 350px to 100% */
    background-color: var(--line-border-empty);
    z-index: -1;
}

.progress_line {
    position: absolute;
    top: 50%;
    left: 0;
    width: 0;
    height: 10px;
    background-color: var(--line-border-fill);
    z-index: -1;
    transition: all .5s ease-in;
}


.step-text {
    color: transparent;
    /* Hide the text by default */
    position: absolute;
    bottom: -35px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 15px;
    width: 200px;
    font-weight: bold;
    transition: color 0.4s ease-in;
    /* Smooth transition when displaying the text */
}

.circle.active .step-text {
    color: #000;
    /* Display the text when the circle is active */
}

.step-date {
    color: transparent;
    /* Hide the date by default */
    position: absolute;
    bottom: -55px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 15px;
    width: 200px;
    transition: color 0.4s ease-in;
    /* Smooth transition when displaying the date */
}

.circle.active .step-date {
    color: #000;
    /* Display the date when the circle is active */
}

i.fas.fa-shopping-cart {
    font-size: 60px;
    padding: 20px;
    color: #00800096;
}

.circle {
    position: relative;
    font-size: 50px;
    color: var(--line-border-empty);
    background-color: #fff;
    height: 120px;
    width: 120px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 10px solid var(--line-border-empty);
    border-radius: 50%;
    transition: all .4s ease-in;
}

.circle.active {
    border-color: var(--line-border-fill);
    background-color: var(--background-fill);
    color: #fff;
    /* box-shadow: 0px 0px 31px -2px rgba(0, 105, 37, 0.62); */
}

.nav-tabs .nav-item.show .nav-link,
.nav-tabs .nav-link.active {
    color: white;
    background-color: green;
    border-color: #dee2e6 #dee2e6 #fff
}

.nav-tabs .nav-link {
    border-radius: 10px 10px 0px 0px;
    cursor: pointer;
    padding: 10px 20px;
    border: 1px solid #ccc;
    margin-right: 2px;
    border-bottom: none;
    background-color: #f1f1f1;
    color: #000;
}

#num-of-notif {
    position: absolute;
    background-color: #d03232;
    color: #fff;
    padding: 2px 7px;
    font-size: 10px;
    border-radius: 50%;
    margin-left: 6px;
    margin-top: -15px
}

.btn {
    padding: 0.6em 2em;
    background-color: var(--line-border-fill);
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin: 20px 20px 0;
}

.btn:active {
    transform: scale(0.98);
}

.btn:disabled {
    background-color: var(--line-border-empty);
    cursor: not-allowed;
}

.list-group-item.active {
    background: #ffc107;
}

/* end common class */


/* end top status */

ul.timeline {
    list-style-type: none;
    position: relative;
}

ul.timeline:before {
    content: ' ';
    background: #d4d9df;
    display: inline-block;
    position: absolute;
    left: 29px;
    width: 2px;
    height: 100%;
    z-index: 400;
}

ul.timeline>li {
    margin: 20px 0;
    padding-left: 30px;
}

ul.timeline>li:before {
    content: '\2713';
    background: #fff;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 0;
    left: 5px;
    width: 50px;
    height: 50px;
    z-index: 400;
    text-align: center;
    line-height: 50px;
    color: #d4d9df;
    font-size: 24px;
    border: 2px solid #d4d9df;
}

ul.timeline>li.active:before {
    content: '\2713';
    background: #28a745;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 0;
    left: 5px;
    width: 50px;
    height: 50px;
    z-index: 400;
    text-align: center;
    line-height: 50px;
    color: #fff;
    font-size: 30px;
    border: 2px solid #28a745;
}

/* end timeline */

.back_button {
    display: block;
    width: 120px;
    margin-top: 10px;
    margin-left: 25px;
    padding: 10px 25px 10px 25px;
    border: 2px solid rgb(246, 246, 246);
    border-radius: 30px;
    background-color: green;
    text-decoration: none;
    color: rgb(255, 255, 255);
    text-align: center;
    box-shadow: 0 3px 3px rgba(0, 0, 0, 0.3),
        inset 0 -2px 3px rgba(0, 0, 0, 0.3);
    transition: 0.5s;
}

.back_button:hover {
    background-color: rgb(255, 255, 255);
    color: green;
}
</style>

</html>