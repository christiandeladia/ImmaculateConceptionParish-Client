<?php
require "../connect.php";
if (!isset($_SESSION['auth_login'])) {
    header("location: login.php");
    exit;
}
$auth = $_SESSION['auth_login'];
$auth_id = $auth['id'];
$cart_name = 'cart-' . $auth_id . '-cart';

# Create cart
if (!isset($_SESSION[$cart_name])) {
    $_SESSION[$cart_name] = [];
}

# Get orders
$sql = "SELECT * FROM `orders` WHERE `customer_id` = ? ORDER BY group_order, date_added DESC;"; // Grouping by group order ID
$stmt = $pdo->prepare($sql);
$stmt->execute([$auth_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count the total number of orders
$totalOrders = count($orders);

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
    <link rel="stylesheet" href="../style/nav.css">
    <link rel="stylesheet" href="../style/footer.css">

</head>
<?php include '../nav.php';?>
<body>
    <a class="btn btn-info btn-sm m-3" href="../product.php">Back to Orders</a>
    <section class="my-5">
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <!-- PRODUCT DESCRIPTION -->
                    <div class="col-lg">
                        <?php
                            $groupOrder = null;
                            $total = 0;
                            $combinedDescription = '';
                            foreach ($orders as $row) { 
                                if ($groupOrder !== $row['group_order']) {
                                    // New group order, output combined description
                                    if ($groupOrder !== null) {
                                        echo '<div class="card mt-4">
                                                <div class="card-body p-0 table-responsive ">
                                                    <div style="display: flex; justify-content: space-between;">
                                                        <h4 class="p-3 mb-0">' . $groupOrder . '</h4>
                                                        <h5 class="text-' . getStatusColor($row['status']) . ' p-3 mb-0">' . $row['status'] . '</h5>
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
                                                        <tbody>' . $combinedDescription . '</tbody>
                                                    </table>
                                                    <div style="display: flex; justify-content: space-between;">
                                                        <div class="text-left p-3">
                                                            <span class="text-muted">Payment Method:</span>
                                                            <span class="badge badge-success">' . $row['order_payment'] . '</span>
                                                            <br>
                                                            <span class="text-muted">Order Total:</span>
                                                            <strong>₱' . number_format($total, 2) . '</strong>
                                                        </div>
                                                        <a href="view_orders.php?order_id=' . $groupOrder . '" class="btn btn-primary btn-sm h-25">View</a>
                                                    </div>
                                                </div>
                                            </div>';
                                        // Reset combined description for the next group order
                                        $combinedDescription = '';
                                    }
                                    $groupOrder = $row['group_order'];
                                    $total = 0; // Reset total for the new group order
                                    $shipping_fee = 0;
                                }
                                $product_quantity = $row['product_quantity'];
                                $product_price = $row['product_price'];
                                $grandtotal = $row['grandtotal'];
                                $subtotal = $product_quantity * $product_price;
                                $shipping_fee = $grandtotal - $subtotal;
                                $total += $subtotal;
                                // Concatenate product descriptions
                                $combinedDescription .= '<tr>
                                                            <th>
                                                                <img src="../image/' . $row['product_image'] . '" alt="product" class="" width="50">
                                                            </th>
                                                            <td>' . $row['product_name'] . '</td>
                                                            <td>₱' . number_format($row['product_price'], 2) . '</td>
                                                            <td>' . $row['product_quantity'] . '</td>
                                                            <td>₱ ' . number_format($subtotal, 2) . '</td>
                                                        </tr>';
                            }

                            // Output the last group order
                            if ($groupOrder !== null) {
                                echo '<div class="card mt-4">
                                        <div class="card-body p-0 table-responsive ">
                                            <div style="display: flex; justify-content: space-between;">
                                                <h4 class="p-3 mb-0">' . $groupOrder . '</h4>
                                                <h5 class="text-' . getStatusColor($row['status']) . ' p-3 mb-0">' . $row['status'] . '</h5>
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
                                                <tbody>' . $combinedDescription . '</tbody>
                                            </table>
                                            <div style="display: flex; justify-content: space-between;">
                                                <div class="text-left p-3">
                                                    <span class="text-muted">Payment Method:</span>
                                                    <span class="badge badge-success">' . $row['order_payment'] . '</span>
                                                    <br>
                                                    <span class="text-muted">Order Total:</span>
                                                    <strong>₱' . number_format($total, 2) . '</strong>
                                                </div>
                                                <a href="view_orders.php?order_id=' . $groupOrder . '" class="btn btn-primary btn-sm h-25">View</a>
                                            </div>
                                            
                                        </div>
                                    </div>';
                            }

                            function getStatusColor($status) {
                                switch ($status) {
                                    case 'Order Placed':
                                        return 'primary';
                                    case 'Order Shipped Out':
                                        return 'info';
                                    case 'Order Received':
                                        return 'warning';
                                    case 'Order Completed':
                                        return 'success';
                                    default:
                                        return 'secondary';
                                }
                            }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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
<?php include '../footer.php';?>
</html>
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
    </style>