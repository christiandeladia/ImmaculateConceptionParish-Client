<?php
require "../connect.php";
if (!isset($_SESSION['auth_login'])) {
    header("location: login.php");
    exit;
}

$auth = $_SESSION['auth_login'];
$cart_name = 'cart-' . $auth['id'] . '-cart';

if (!isset($_SESSION[$cart_name])) {
    $_SESSION[$cart_name] = [];
} 

// Handle checkout
if (isset($_POST['cart_checkout'])) {
    // Connect to your database
    require "../connect.php";

    // Iterate through the cart and insert/update records in the orders table
    foreach ($_SESSION[$cart_name] as $product_id => $item) {
        $product_quantity = $item['product_quantity'];

        // Insert a new order or update an existing one
        $query = "INSERT INTO orders (user_id, product_id, product_quantity) VALUES ('" . $auth['id'] . "', '" . $product_id . "', '" . $product_quantity . "') ON DUPLICATE KEY UPDATE product_quantity = product_quantity + VALUES(product_quantity)";

        if (mysqli_query($connection, $query)) {
            // Order successfully placed, remove the product from the cart
            unset($_SESSION[$cart_name][$product_id]);
        } else {
            // Handle the case where the order couldn't be placed
            // You can display an error message or take appropriate action here.
        }
    }
}
?>
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
    <a class="back_button" href="index.php">
        <i class='bx bx-arrow-back' style='font-size:12px'></i>Back
    </a>
    <!-- <a class="back_button" href="javascript:void(0);" onclick="goBack()">
        <i class='bx bx-arrow-back' style='font-size:12px'></i>Back
    </a>
    <script>
    function goBack() {
        window.history.back();
    }
    </script> -->

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
				$count = 0;
                $total_quantity = 0;
				foreach ($_SESSION[$cart_name] as $key => $dish) {
					$product_quantity = $dish['product_quantity'];
					$product_price = $dish['product_price'];
					$subtotal = $product_quantity * $product_price; // Calculate the subtotal
					$count += $subtotal; // Add to the total count
                    $shipping_fee = 60;
                    $grandtotal = $count + $shipping_fee;
                    $total_quantity += $product_quantity;

                    echo '<tr>';
                    echo '<td><img src="../image/'.$dish["product_image"].'" height="100" alt="'.$dish["product_name"].'"></td>';
                    echo '<td>'.$dish['product_name'].'</td>';
                    echo '<td>₱ ' . number_format($dish['product_price'], 2) . '</td>';
                    echo '<td>
                    '.$dish['product_quantity'].'
                    </td>';
                    echo '<td>₱ '.number_format($subtotal, 2).'</td>';
                    echo '</tr>';
                }
                
            ?>
                    <?php if( $count == 0 ){?>
                    <tr>
                        <td colspan="5" class="text-center p-2"><code>Your cart is empty.</code></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>

        <div class="form-wapper">
            <!-- <div class="form-header">
                <h2>Order Form</h2>
            </div> -->
            <div class="form-body">
                <form method="POST" action="managecart.php" onsubmit="return validateForm()">

                    <div class="address-card">
                        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #63656b;">
                            <span class="title"><i class='fa fa-map-marker'></i> Delivery Address</span>
                            <a href="../modal_checkout.php" class="change" id="changeAddressButton">
                                <i class='fa fa-exchange'></i> Change
                            </a>
                        </div>

                        <?php
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

                            <!-- <input type="text" id='order_address' name='order_address' value="<?php echo $selected_address['region'] ?>" oninput="calculateShippingFee()"> -->

                            <?php echo $selected_address['first_name'] . ' ' . $selected_address['last_name'] ?> |
                            <?php echo $selected_address['mobile_number'] ?>
                        </div>
                        <div class="description_address"><?php echo $selected_address['street'] ?>,
                            <?php echo $selected_address['city'] ?></div>
                        <div class="description_address"><?php echo $selected_address['province'] ?>,
                            <?php echo $selected_address['region'] ?>, <?php echo $selected_address['zip_code'] ?></div>
                        <?php
                        } catch (JsonException $e) {
                            ?>
                        <div class="description_contact ">Error: Failed to decode address data</div>
                        <?php
                            }
                        } else {
                        ?>
                        <div class="description_contact ">No Address Selected</div>
                        <?php
                        }
                        ?>
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
                    <div class="address-card">
                        <div style="display: flex; justify-content: space-between;">
                            <span class="title"><i class='fa fa-ticket'></i> Apply coupons</span>
                        </div>
                        <hr>
                        <div class="form">
                            <input type="text" placeholder="Apply your coupons here" class="input_field">
                            <button class="change">
                                <i class='fa fa-plus'></i> Apply
                            </button>
                        </div>
                    </div>


                    <?php
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $key => $value) {
                            $product_id = $value['product_id'];
                            echo '<input type="hidden" name="product_id[]" value="'.$product_id.'">';
                        }
                    }
                    ?>

                    <?php
                    if(isset($_SESSION[$cart_name]) && !empty($_SESSION[$cart_name])) {

                      echo '<br><hr><br><div style="display: flex; justify-content: space-between;">
                        <p class="fees">Order Subtotal:</p>
                        <p class="fees">₱ '.number_format($count, 2).'</p>
                      </div>';
                      echo '<div style="display: flex; justify-content: space-between;">
                        <p class="fees">Quantity:</p>
                        <p class="fees">'.$total_quantity.' items</p>
                      </div>';
                      echo '<div style="display: flex; justify-content: space-between;">
                        <p class="fees">Shipping Fee(default):</p>
                        <p class="fees">₱ '.number_format($shipping_fee, 2).'</p>
                      </div>';
                    //   echo '<div style="display: flex; justify-content: space-between;">
                    //     <label class="fees">Shipping Fee:</label>
                    //     <p class="fees" id="shipping-fee-display">₱ <span id="shipping-fee">0.00</span></p>
                    // </div>';
                      echo '<div style="display: flex; justify-content: space-between;">
                        <p class="total" style="font-size:20px;">Total Payment:</p>
                        <p class="total"><b>₱ '.number_format($grandtotal, 2).'</b></p>
                      </div>';
                        }
                    ?>
                    <input type="hidden" value="true" name="cart_checkout" />
                    <button class="order_button">Place Order</button>
                </form>
            </div>
        </div>
    </div>
    </div>
</body>
<script>
function updateShippingFee() {
    var region = "<?php echo isset($selected_address['region']) ? $selected_address['region'] : ''; ?>";
    var shippingFee = 0;

    // Extract main region name
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
            // Add cases for other regions as needed
        default:
            // Default shipping fee if region is not specified or unknown
            shippingFee = 120;
            break;
    }

    document.getElementById("shipping-fee-display").innerHTML = '₱ ' + shippingFee.toFixed(2);


    // Get the changeAddressButton element
    var changeAddressButton = document.getElementById('changeAddressButton');

    // Set the inner HTML of the changeAddressButton
    changeAddressButton.innerHTML = noAddressSelected ? '<i class="fas fa-check-circle"></i> Select' :
        '<i class="fas fa-exchange-alt"></i> Change';
}
</script>


<script>
document.addEventListener("DOMContentLoaded", function() {
    var changeAddressButton = document.getElementById('changeAddressButton');

    // Check if an address is selected or not
    var noAddressSelected = <?php echo (isset($_POST['selected_address']) ? 'false' : 'true'); ?>;

    // Set button text based on whether an address is selected or not
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
    return true;
}
</script>


<script>
function calculateShippingFee() {
    var regionInput = document.getElementById("order_address").value;

    var shippingFee;

    if (regionInput.includes("Ilocos Region") || regionInput.includes("MIMAROPA")) {
        shippingFee = 60;
    } else if (regionInput.includes("Cagayan Valley")) {
        shippingFee = 100;
    } else {
        shippingFee = 120;
    }

    document.getElementById("shipping_fee").innerHTML = "Shipping Fee: " + shippingFee + " pesos";
}
</script>

</html>