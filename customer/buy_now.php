<?php
require "../connect.php";

if (!isset($_SESSION['auth_login'])) {
    header("location: login.php");
    exit;
}

$auth = $_SESSION['auth_login'];
?>
<?php
if (isset($_POST['buy_now'])) {
    $product_name = $_POST['product_name'];
    $product_image = $_POST['product_image'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $status = "Order Placed";

    // Now you can use these variables as needed in your buy_now.php file
    // ...
}
?>
<?php
// Initialize variables
$product_name = '';
$product_image = '';
$product_description = '';
$product_price = '';
$count = 0;
$total_quantity = 0;
$shipping_fee = 60;
$grandtotal = 0;

// Check if the form has been submitted
if (isset($_POST['buy_now'])) {
    // Assign values from the form to variables
    $product_name = $_POST['product_name'];
    $product_image = $_POST['product_image'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];

    // Calculate subtotal and update other variables as needed
    $product_quantity = 1; // Assuming quantity is 1 for the "buy now" scenario
    $subtotal = $product_quantity * $product_price;
    $count += $subtotal;
    $total_quantity += $product_quantity;
    $grandtotal = $count + $shipping_fee;
}
?>

<!-- Your HTML code remains unchanged -->



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>CHECKOUT - ICP</title>
    <link rel="icon" type="image/x-icon" href="../image/favicon.ico">
    <link rel="stylesheet" href="../style/nav.css">
    <link rel="stylesheet" href="../style/checkout.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </style>
</head>

<style>
  .back_button {
display: block;
  width: 120px;
  margin-top: 10px;
  margin-left: 25px;
  padding:10px 25px 10px 25px;
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

<body style="background-color: #red;">

    <?php
if ( isset($_SESSION['auth_login']) ) {
    $auth = $_SESSION['auth_login'];
    $auth_full_name = $auth['first_name'] . $auth['last_name'];
}
?>

    <div class="navtop">
        <div class="navcenter">
            <a href="../index.php">
                <img class="logo" src="../image/logo2.png" alt="Logo" />
            </a>
            <div class="topnav">
                <div class="topnav-left">
                    <a href="../index.php">Home</a>
                    <a href="../product.php">Products</a>
                    <a href="../services.php">Services</a>
                    <a href="../about.php">About</a>
                    <a href="#">Notification</a>
                </div>

                <div class="topnav-right">
                    <div class="dropdown">
                        <button class="dropbtn"><i class="fa fa-user-circle-o"></i> <?php echo $auth_full_name; ?>
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content">
                            <a href="#">My Profile</a>
                            <a href="../donation.php">Send Donations</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <br>
    <a class="back_button" href="javascript:void(0);" onclick="goBack()">
    <i class='bx bx-arrow-back' style='font-size:12px'></i>Back
</a>

<script>
    function goBack() {
        window.history.back();
    }
</script>


    <h1>Check out</h1>
    <div class="container">

        <div style="max-height: 660px; overflow-y: auto; width: 60%;">
            <h2>Product Ordered</h2>

            <?php if ($count > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                        <td><img src="../image/<?php echo $product_image; ?>" height="100"
                                alt="<?php echo $product_name; ?>"></td>
                        <td><?php echo $product_name; ?></td>
                        <td>₱ <?php echo number_format($product_price, 2); ?></td>
                        <td><?php echo $total_quantity; ?></td>
                        <td>₱ <?php echo number_format($count, 2); ?></td>
                    </tr>
                </tbody>
            </table>

            <?php } else { ?>
            <p>Your cart is empty.</p>
            <?php } ?>
            </tbody>
            </table>
        </div>

        <div class="form-wapper">
            <div class="form-header">
                <h2>Delivery Address</h2>
            </div>
            <div class="form-body">
                <form method="POST" action="managecart.php">
                    <div class="input-wrapper">
                        <label for="order_username">Complete Name:</label>
                        <input type="text" name="order_username" required>
                    </div>


                    <div class="input-wrapper">
                        <label for="order_phonenumber">Contact Number:</label>
                        <input type="number" name="order_phonenumber" required>
                    </div>

                    <div class="input-wrapper">
                        <label for="order_address">Complete Address:</label>
                        <input type="text" name="order_address" required>
                    </div>
                    <div class="input-wrapper">
                        <div class="select-wrapper">
                            <label for="order_payment">Payment Option:</label>
                            <select class="selects" name="order_payment" id="order_payment" required>
                                <option value="cash">Cash on Delivery</option>
                                <option value="online">Online Payment</option>
                                <!-- Add more payment options as needed -->
                            </select>
                        </div>

                        <div class="select-wrapper">
                            <label for="order_courier">Courier:</label>
                            <select class="selects" name="order_courier" id="order_courier" required>
                                <option value="lbc">LBC</option>
                                <option value="jnt">J&T</option>
                            </select>
                        </div>
                    </div>

                    <hr>
                    <br>
                    <div style="display: flex; justify-content: space-between;">
                        <p class="fees">Order Subtotal:</p>
                        <p class="fees">₱<?php echo number_format($count, 2);?> </p>
                    </div>

                    <div style="display: flex; justify-content: space-between;">
                        <p class="fees">Quantity:</p>
                        <p class="fees"><?php echo $total_quantity; ?> items</p>
                    </div>

                    <div style="display: flex; justify-content: space-between;">
                        <p class="fees">Shipping Fee(default):</p>
                        <p class="fees">₱ <?php echo number_format($shipping_fee, 2); ?></p>
                    </div>

                    <div style="display: flex; justify-content: space-between;">
                        <p class="total" style="font-size:20px;">Total Payment:</p>
                        <p class="total"><b>₱ <?php echo number_format($grandtotal, 2); ?></b></p>
                    </div>

                    <input type="hidden" value="true" name="cart_checkout" />
                    <button class="order_button">Place Order</button>
                </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>