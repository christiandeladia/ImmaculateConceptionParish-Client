<?php
require "connect.php";
if (!isset($_SESSION['auth_login'])) {
header("location: customer/login.php");
exit;
}
$auth = $_SESSION['auth_login'];
$cart_name = 'cart-' . $auth['id'] . '-cart';
if (!isset($_SESSION[$cart_name])) {
$_SESSION[$cart_name] = [];
} 
/// Handle checkout
if (isset($_POST['cart_checkout'])) {
// Connect to your database
foreach ($_SESSION[$cart_name] as $product_id => $item) {
$product_quantity = $item['product_quantity'];
// Decrease product stock
if (!decreaseProductStock($product_id, $product_quantity, $connection)) {
// Handle the case where decreasing stock fails
// You can display an error message or take appropriate action here.
continue; // Skip to next product
}
// Insert a new order or update an existing one
$order_query = "INSERT INTO orders (user_id, product_id, product_quantity) VALUES ('" . $auth['id'] . "', '$product_id', '$product_quantity') ON DUPLICATE KEY UPDATE product_quantity = product_quantity + VALUES(product_quantity)";
if (mysqli_query($connection, $order_query)) {
// Order successfully placed, remove the product from the cart
unset($_SESSION[$cart_name][$product_id]);
} else {
// Handle the case where the order couldn't be placed
// You can display an error message or take appropriate action here.
}
}
// Function to decrease product stock
function decreaseProductStock($product_id, $quantity, $connection) {
$update_query = "UPDATE inventory SET product_stock = product_stock - $quantity WHERE product_id = $product_id";
$update_result = mysqli_query($connection, $update_query);

// Handle the case where stock update fails
if (!$update_result) {
return false;
}
return true;
}
}?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>CHECKOUT - ICP</title>
    <link rel="icon" type="image/x-icon" href="image/favicon.ico">
    <link rel="stylesheet" href="style/checkout.css">
    <link rel="stylesheet" href="style/nav.css">
    <link rel="stylesheet" href="style/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </style>
</head>
<?php include 'nav.php';?>

<body style="background-color: #red;">
    <?php
if ( isset($_SESSION['auth_login']) ) {
$auth = $_SESSION['auth_login'];
$auth_full_name = $auth['first_name'] . $auth['last_name'];
}
?>
    <br>
    <a class="back_button" href="cart.php">
        <i class='bx bx-arrow-back' style='font-size:12px'></i>Back
    </a>
    <h1>Check out</h1>
    <div class="container">
        <div style="max-height: 660px; overflow-y: auto; width: 60%;">
            <h2>Product Ordered</h2>
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
                    <?php
                    $coupon = 20;
                    $count = 0;
                    $total_quantity = 0;
                    foreach ($_SESSION[$cart_name] as $key => $item) {
                        $product_quantity = $item['product_quantity'];
                        $product_price = $item['product_price'];
                        $subtotal = $product_quantity * $product_price; // Calculate the subtotal
                        $count += $subtotal; // Add to the total count
                        $shipping_fee = 0;
                        // $grandtotal = $count - $coupon;
                        $total_quantity += $product_quantity;

                        echo '<tr>';
                        echo '<td><img src="image/'.$item["product_image"].'" height="100" alt="'.$item["product_name"].'"></td>';
                        echo '<td>'.$item['product_name'].'</td>';
                        echo '<td>₱ ' . number_format($item['product_price'], 2) . '</td>';
                        echo '<td>
                        '.$item['product_quantity'].'
                        </td>';
                        echo '<td>₱ '.number_format($subtotal, 2).'</td>';
                        echo '</tr>';
                    } ?>
                    <?php if( $count == 0 ){?>
                    <tr>
                        <td colspan="5" class="text-center p-2"><code>Your cart is empty.</code></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
        <div class="form-wapper">
            <div class="form-body">
                <form method="POST" action="customer/managecart.php" onsubmit="return validateForm()">
                    <div class="address-card">
                        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #63656b;">
                            <span class="title"><i class='fa fa-map-marker'></i> Delivery Address</span>
                            <a href="modal_checkout.php" class="change" id="changeAddressButton">
                                <i class='fa fa-exchange'></i> Change
                            </a>
                        </div>
                        <?php
                        $selected_address = null;
                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selected_address'])) {
                            try {
                                $selected_address = json_decode($_POST['selected_address'], true, 512, JSON_THROW_ON_ERROR);
                        ?>
                        <div class="description_contact">
                            <input type="text" name='order_username'
                                value="<?php echo $selected_address['first_name'] . ' ' . $selected_address['last_name'] ?>"
                                style="display: none;">
                            <input type="text" name='order_phonenumber'
                                value="<?php echo $selected_address['mobile_number'] ?>" style="display: none;">
                            <input type="text" name='order_address' value="<?php echo $selected_address['street'] ?>, <?php echo $selected_address['city'] ?>, <?php echo $selected_address['province'] ?>,
                            <?php echo $selected_address['region'] ?>, <?php echo $selected_address['zip_code'] ?>"
                                style="display: none;">
                            <input type="text" name='order_shipping_fee'
                                value="<?php echo $selected_address['shipping_fee'] ?>" style="display: none;">

                            <?php echo $selected_address['first_name'] . ' ' . $selected_address['last_name'] ?> |
                            <?php echo $selected_address['mobile_number'] ?>
                        </div>

                        <div class="description_address"><?php echo $selected_address['street'] ?>,
                            <?php echo $selected_address['city'] ?></div>
                        <div class="description_address"><?php echo $selected_address['province'] ?>,
                            <?php echo $selected_address['region'] ?>, <?php echo $selected_address['zip_code'] ?>
                        </div>
                        <?php
                            } catch (JsonException $e) {
                        ?>
                        <div class="description_contact ">Error: Failed to decode address data</div>
                        <?php
                            }
                        } else {
                        ?>
                        <div class="description_contact ">No Address Selected</div>
                        <?php } ?>
                    </div>
                    <br>
                    <div class="address-card">
                        <div style="display: flex; justify-content: space-between;">
                            <span class="title"><i class='fa fa-credit-card'></i> Payment Method</span>
                        </div>
                        <hr>
                        <div class="description_address ">Cash on Delivery (Default)</div>
                        <br>
                        <div style="display: flex; justify-content: space-between;">
                            <span class="title"><i class="fa fa-truck"></i> Courier</span>
                        </div>
                        <hr>
                        <div class="description_address ">J&T (Default)</div>
                    </div>
                    <br>
                    <!-- <div class="address-card">
                        <div style="display: flex; justify-content: space-between;">
                            <span class="title"><i class='fa fa-ticket'></i> Apply coupons</span>
                        </div>
                        <hr>
                        <div class="form">
                            <input type="text" placeholder="Apply your coupons here" class="input_field"
                                id="couponInput">
                            <button type="button" class="change" onclick="applyCoupon()">
                                <i class='fa fa-plus'></i> Apply
                            </button>
                        </div>
                    </div> -->
                    <?php
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $key => $value) {
                            $product_id = $value['product_id'];
                            echo '<input type="hidden" name="product_id[]" value="'.$product_id.'">';
                        }
                    }
                    ?>

                    <?php
                    $grandtotal = $count;
                    if ($selected_address !== null && isset($selected_address['shipping_fee'])) {
                        $grandtotal += $selected_address['shipping_fee'];
                    }
                    if(isset($_SESSION[$cart_name]) && !empty($_SESSION[$cart_name])) {
                        echo '<br><hr><br><div style="display: flex; justify-content: space-between;">
                        <p class="fees" style="font-weight: 900;">Quantity:</p>
                        <p class="fees">'.$total_quantity.' item/s</p>
                    </div>';
                    echo '<br><div style="display: flex; justify-content: space-between;">
                        <p class="fees" style="font-weight: 900;">Order Subtotal:</p>
                        <p class="fees">₱ '.number_format($count, 2).'</p>
                    </div>';
                    
                    if ($selected_address !== null && isset($selected_address['shipping_fee'])) {
                        echo '<br><div style="display: flex; justify-content: space-between;">
                            <p class="fees" style="font-weight: 900;">Shipping Fee:</p>
                            <p class="fees">₱ '.number_format($selected_address['shipping_fee'], 2).'</p>
                        </div>';
                    } else {
                        echo '<br><div style="display: flex; justify-content: space-between;">
                            <p class="fees" style="font-weight: 900;">Shipping Fee:</p>
                            <p class="fees">₱ 0.00</p>
                        </div>';
                    }
                    // echo '<div style="display: flex; justify-content: space-between;">
                    //             <p class="fees">Coupon:</p>
                    //             <p id="discountDisplay" class="fees">₱0.00</p>
                    //         </div>';
                    echo '<br><div style="display: flex; justify-content: space-between;">
                        <p class="total" style="font-size:20px; font-weight: 900;">Total Payment:</p>
                        <p class="total"><b>₱ '.number_format($grandtotal, 2).'</b></p>
                    </div>';
                    echo '<input type="hidden" name="grandtotal" value="'.$grandtotal.'">';
                        }
                    ?>
                    <input type="hidden" value="true" name="cart_checkout" />
                    <button class="order_button">Place Order</button>
                </form>
            </div>
        </div>
    </div>

</body>
<?php include 'footer.php';?>
<script>
document.getElementById('placeOrderButton').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default form submission
    var form = document.querySelector('form');
    form.action = 'send_checkout.php';
    form.method = 'get';
    form.submit();
    setTimeout(function() {
        form.action = 'customer/managecart.php';
        form.method = 'post';
        form.submit();
    }, 1000); // Delay to ensure the first submission has completed
});
</script>
<script>
function updateShippingFee() {
    var region = "<?php echo isset($selected_address['region']) ? $selected_address['region'] : ''; ?>";
    var shippingFee = 0;
    var mainRegion = region.match(/Region \w+/);
    if (mainRegion) {
        mainRegion = mainRegion[0];
    }

    switch (mainRegion.toLowerCase()) {
        case "Region II (Ilocos Region)":
            shippingFee = 60;
            break;
        case "region ii":
            shippingFee = 80;
            break;
        default:
            shippingFee = 120;
            break;
    }
    document.getElementById("shipping-fee-display").innerHTML = '₱ ' + shippingFee.toFixed(2);
    var changeAddressButton = document.getElementById('changeAddressButton');
    changeAddressButton.innerHTML = noAddressSelected ? '<i class="fas fa-check-circle"></i> Select' :
        '<i class="fas fa-exchange-alt"></i> Change';
}
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var changeAddressButton = document.getElementById('changeAddressButton');
    var noAddressSelected = <?php echo (isset($_POST['selected_address']) ? 'false' : 'true'); ?>;
    changeAddressButton.innerHTML = noAddressSelected ? '<i class="fa fa-check-circle"></i> Select' :
        '<i class="fa fa-exchange"></i> Change';
});
</script>
<script>
function validateForm() {
    var addressSelected = <?php echo json_encode(isset($_POST['selected_address'])); ?>;
    if (!addressSelected) {
        alert("Please select an address before placing the order.");
        return false;
    }
    // Ask for confirmation
    var confirmed = confirm(
        "Are you sure you want to place the order? This transaction cannot be cancelled once confirm.");
    return confirmed;
}
</script>
<script>
function calculateShippingFee() {
    var regionInput = document.getElementById("order_address").value;

    var shippingFee;
    if (regionInput.includes("Ilocos Region") || regionInput.includes("MIMAROPA")) {
        shippingFee = 0;
    } else if (regionInput.includes("Cagayan Valley")) {
        shippingFee = 0;
    } else {
        shippingFee = 0;
    }
    document.getElementById("shipping_fee").innerHTML = "Shipping Fee: " + shippingFee + " pesos";
}
</script>
<script>
function applyCoupon() {
    var couponInput = document.getElementById('couponInput').value;
    var discountValue = 0;
    var total = <?php echo $count; ?>;
    var grandtotal;

    if (couponInput === 'ICP0FF20') {
        discountValue = <?php echo $coupon; ?>;
        grandtotal = total - discountValue;
    } else {
        grandtotal = total;
    }
    document.getElementById('discountDisplay').innerHTML = '- ₱ ' + discountValue.toFixed(2);
    document.getElementById('totalPayment').innerHTML = '₱ ' + grandtotal.toFixed(2);
}
</script>

</html>
<style>
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

/* ADDRESS CARD */
.address-card {
    width: 100%;
    padding: 1rem;
    background-color: #fff;
    border: 1px solid #63656b;
    border-radius: 10px;
    box-shadow: 20px 20px 30px rgba(0, 0, 0, .05);
}

.title {
    font-weight: 900;
    font-size: 16px;
    color: #63656b;
    /* line-height: 0.25rem; */
}

.description_contact {
    font-weight: 600;
    margin-top: 1rem;
    font-size: 17px;
    line-height: 1.25rem;
    color: #63656b;
}

.description_address {
    font-size: 17px;
    line-height: 1.25rem;
    color: #63656b;
}

.description a {
    --tw-text-opacity: 1;
    color: rgb(59 130 246);
}

.change {
    margin-bottom: 2px;
    font-size: 0.75rem;
    line-height: 1rem;
    background-color: #258d36;
    font-weight: 500;
    border-radius: 0.5rem;
    color: #fff;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
    padding-top: 0.425rem;
    padding-bottom: 0.425rem;
    border: none;
    transition: all .15s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    /* Remove underline */
}


.change:hover {
    background-color: rgb(55 65 81);
}

.change:focus {
    outline: 2px solid transparent;
    outline-offset: 2px;
}

/* Promo */
.coupontitle {
    width: 100%;
    height: 40px;
    position: relative;
    display: flex;
    align-items: center;
    padding-left: 20px;
    border-bottom: 1px solid #efeff3;
    font-weight: 700;
    font-size: 11px;
    color: #63656b;
}

.input_field {
    width: 60%;
    height: 36px;
    padding: 0 0 0 12px;
    border-radius: 5px;
    outline: none;
    border: 1px solid #e5e5e5;
    filter: drop-shadow(0px 1px 0px #efefef) drop-shadow(0px 1px 0.5px rgba(239, 239, 239, 0.5));
    transition: all 0.3s cubic-bezier(0.15, 0.83, 0.66, 1);
}

.input_field:focus {
    border: 1px solid transparent;
    box-shadow: 0px 0px 0px 2px #242424;
    background-color: transparent;
}
</style>