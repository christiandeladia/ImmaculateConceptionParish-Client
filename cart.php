<?php
require "connect.php";
if (!isset($_SESSION['auth_login'])) {
    header("location: customer/login.php");
    exit;
}

$auth = $_SESSION['auth_login'];
$cart_name = 'cart-' . $auth['id'] . '-cart';

$count = 0;
foreach ($_SESSION[$cart_name] as $key => $dish) {
	$product_quantity = $dish['product_quantity'];
	$product_price = $dish['product_price'];
	$subtotal = $product_quantity * $product_price; // Calculate the subtotal
	$count += $subtotal; // Add to the total count
}
if (!isset($_SESSION[$cart_name])) {
    $_SESSION[$cart_name] = [];
}

// Check if the "Remove All" button was clicked
if (isset($_POST['remove_all'])) {
    // Clear the cart by setting it to an empty array
    $_SESSION[$cart_name] = [];
}

// Handle quantity updates
if (isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['new_quantity'];

    // Check if the new quantity is valid (non-negative)
    if ($new_quantity >= 0) {
        // Update the quantity in the cart session variable
        $_SESSION[$cart_name][$product_id]['product_quantity'] = $new_quantity;
    }
}

// Handle checkout
if (isset($_POST['cart_checkout'])) {
    // Connect to your database
    require "connect.php";

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
$total_quantity = 0;
foreach ($_SESSION[$cart_name] as $key => $dish) {
	$product_quantity = $dish['product_quantity'];
	$total_quantity += $product_quantity;
}


?>
<!-- The rest of your HTML code remains the same -->

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" />
    <title>CART</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- <link rel="stylesheet" href="../style/addtocart.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
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

.quantity {
    display: flex;
    align-items: center;
}

.quantity input {
    height: 30px;
    font-size: 1rem;
    width: 70px;
    text-align: center;
    margin: 0 5px;
}

.quantity button {
    height: 30px;
    font-size: 0.7rem;
}





/* notification style */
.notifications-container {
    width: 100%;
    height: auto;
    font-size: 0.875rem;
    line-height: 1.25rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.flex {
    display: flex;
}

.flex-shrink-0 {
    flex-shrink: 0;
}

.alert {
    background-color: rgb(254 252 232);
    border-left-width: 4px;
    border-color: rgb(250 204 21);
    border-radius: 0.375rem;
    padding: 1rem;
}

.alert-svg {
    height: 1.25rem;
    width: 1.25rem;
    color: rgb(250 204 21);
}

.alert-prompt-wrap {
    margin-left: 0.75rem;
    color: rgb(202 138 4);
}

.alert-prompt-wrap p {
    margin: 0;
}

.alert-prompt-link {
    font-weight: 500;
    color: rgb(141, 56, 0);
    text-decoration: underline;
}

.alert-prompt-link:hover {
    color: rgb(202 138 4);
}
</style>
<?php include 'nav.php';?>

<body>

    <!-- <a class="btn btn-info btn-sm m-3" href="product.php">Back to Products</a> -->
    <br>
    <a class="back_button" href="product.php">
        <i class='bx bx-arrow-back' style='font-size:12px'></i>Back
    </a>

    

    <div class="container" style="background-color: #fff; padding: 20px; min-height: 300px;">

    <?php if ($total_quantity === 5) { ?>
        <div class="notifications-container">
            <div class="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 alert-svg">
                            <path clip-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                fill-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="alert-prompt-wrap">
                        <p class="text-sm text-yellow-700">
                            You can only purchase 5 items per transaction.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

        <div class="row">
            <div class="col-md-6">
                <h2>Cart (<?php echo $total_quantity; ?>)</h2>
                <span></span>
            </div>
            <?php if( $count != 0 ){?>
            <div class="col-md-6 text-right">
                <form action="" method="POST" onsubmit="return confirm('Are you sure you want to remove all?');">
                    <button type="submit" name="remove_all" class="btn btn-danger btn-sm">Remove All</button>
                </form>
            </div>
            <?php }?>
        </div>


        <section class="container mt-3">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th> <!-- New column for quantity -->
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
				$count = 0;
				foreach ($_SESSION[$cart_name] as $key => $dish) {
					$product_quantity = $dish['product_quantity'];
					$product_price = $dish['product_price'];
					$subtotal = $product_quantity * $product_price; // Calculate the subtotal
					$count += $subtotal; // Add to the total count
			?>

                    <tr>
                        <td>
                            <img src="image/<?php echo $dish['product_image']; ?>"
                                style="width: 3rem; height: 3rem; border-radius: 5px;">
                            <strong><?php echo $dish['product_name']; ?></strong>
                        </td>
                        <td class="align-middle">
                            <div class="quantity">
                                <button class="minus btn btn-primary minus-btn" data-product-id="<?php echo $key; ?>"><i
                                        class="fa fa-minus"></i></button>
                                <input type="text" class="quantity_label form-control"
                                    value="<?php echo $dish['product_quantity']; ?>" readonly>
                                <button class="plus btn btn-primary plus-btn" data-product-id="<?php echo $key; ?>"><i
                                        class="fa fa-plus"></i></button>
                            </div>

                        </td>
                        <td class="align-middle">₱ <?php echo number_format($dish['product_price'], 2); ?></td>
                        <td class="align-middle">₱ <?php echo number_format($subtotal, 2); ?></td>
                        <!-- Display the subtotal -->
                        <td class="align-middle">
                            <form action="customer/addtocart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $key; ?>">
                                <input type="hidden" name="product_name" value="<?php echo $dish['product_name']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $dish['product_image']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $dish['product_price']; ?>">
                                <input type="hidden" name="product_quantity"
                                    value="<?php echo $dish['product_quantity']; ?>">
                                <input type="hidden" class="max-stock" value="<?php echo $dish['product_stock']; ?>">

                                <input type="submit" name="product_remove" class="btn btn-danger btn-sm"
                                    value="Remove" />
                            </form>
                        </td>
                    </tr>
                    <?php } ?>

                    <?php if( $count == 0 ){?>

                    <tr>
                        <td colspan="5" class="text-center p-2"><code>No order yet</code></td>
                    </tr>
                    <?php }else{?>

                    <tr>
                        <td class="align-middle"><strong>Total</strong></td>
                        <td></td>
                        <td></td>
                        <td class="align-middle"><strong><span id="total">₱<?php echo number_format($count, 2); ?>
                                </span></strong></td>
                        <td class="align-middle">
                            <!-- <form action="managecart.php" method="POST" >
							<input type="hidden" value="true" name="cart_checkout" />
							<button class="btn btn-success btn-sm" >Checkout</button>
						</form> -->
                            <a class="btn btn-success btn-sm" href="checkout.php">Checkout</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>

    </div>
    <script>
    $(document).ready(function() {
        // Get the total quantity from PHP
        var totalQuantity = <?php echo $total_quantity; ?>;

        // Function to update the plus buttons based on total quantity
        function updatePlusButtons() {
            if (totalQuantity >= 5) {
                $(".plus").prop('disabled', true); // Disable plus buttons
            } else {
                $(".plus").prop('disabled', false); // Enable plus buttons
            }
        }

        // Call the function initially to set the buttons
        updatePlusButtons();


        $(".plus").click(function() {
            var productId = $(this).data("product-id");
            var quantityInput = $(this).parent().find(".quantity_label");
            var currentQuantity = parseInt(quantityInput.val());
            var newQuantity = currentQuantity + 1;

            // Check if the new quantity exceeds available stock
            var maxStock = parseInt($(this).closest('tr').find(".max-stock").val());
            if (newQuantity <= maxStock) {
                quantityInput.val(newQuantity);

                // Update the cart on the server when the quantity changes
                updateCart(productId, newQuantity);
            } else {
                alert("Exceeds available stock!");
            }
        });

        $(".minus").click(function() {
            var productId = $(this).data("product-id");
            var quantityInput = $(this).parent().find(".quantity_label");
            var currentQuantity = parseInt(quantityInput.val());
            var newQuantity = currentQuantity - 1;

            if (newQuantity >= 0) {
                quantityInput.val(newQuantity);

                if (newQuantity === 0) {
                    // If quantity becomes zero, remove the product from the cart
                    removeProduct(productId);
                } else {
                    // Update the cart on the server when the quantity changes
                    updateCart(productId, newQuantity);
                }
            }
        });

        function removeProduct(productId) {
            $.ajax({
                url: "customer/remove-product.php", // Replace with the actual URL to remove the product
                method: "POST",
                data: {
                    product_id: productId
                },
                success: function(response) {
                    // Handle the server's response if needed
                    // Reload the page after successful removal
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle any errors or display an error message
                }
            });
        }
        // Function to update the cart on the server using AJAX
        function updateCart(productId, newQuantity) {
            $.ajax({
                url: "customer/update-cart.php", // Replace with the actual URL to update the cart
                method: "POST",
                data: {
                    product_id: productId,
                    new_quantity: newQuantity
                },
                success: function(response) {
                    // Handle the server's response if needed
                    // Reload the page after successful update
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle any errors or display an error message
                }
            });
        }
    });
    </script>


    <script>
    // JavaScript function to display an alert
    function displayAlert() {
        alert("You can only have a maximum of 5 products in your cart.");
    }
    </script>
</body>
<?php include 'footer.php';?>

</html>