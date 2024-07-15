<?php  
    require_once "connect.php";
    $is_customer_logged_in = isset($_SESSION['auth_login']);
?>
<?php
    if ( isset($_SESSION['auth_login']) ) {

		$auth = $_SESSION['auth_login'];
		$auth_id = $auth['id'];
        $auth_full_name = $auth['first_name'] . $auth['last_name'];
		$cart_name = 'cart-' . $auth['id'] . '-cart';
        
		if (!isset($_SESSION[$cart_name])) {
			$_SESSION[$cart_name] = [];
		}

		extract($_POST);

		if (isset($cart_checkout)) {
			$sql = "SELECT () AS 'id'";
			$result = mysqli_query($db, $sql);
			$group_order = mysqli_fetch_assoc($result)['id'];
			$group_order = explode('-', $group_order);
			$group_order = $group_order[0];

			foreach ($_SESSION[$cart_name] as $key => $cart) {
				extract($cart);
				$sql = "INSERT INTO `orders`(`group_order`, `customer_id`, `product_name`, `product_price`, `product_description`, `product_dimension`, `product_stock`, `product_image`)
						VALUES(?, ?, ?, ?, ?, ?, ?, ?);";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$group_order, $auth_id, $name, $price, $description, $dimension, $stock, $image]);
			}

			unset($_SESSION[$cart_name]);
			header("location: orders.php");
			exit;
		}

		if (isset($product_id)) {
			// unset($_SESSION[$cart_name][$product_id]);
			header("location: index.php");
			exit;
		}

		// if (isset($product_add)) {
		// 	array_push($_SESSION[$cart_name], [
		// 		"product_name" => $product_name,
		// 		"product_price" => $product_price,
		// 		"product_image" => $product_image,
        //         "product_description" => $product_description,
        //         "product_dimension" => $product_dimension,
        //         "product_stock" => $product_stock
		// 	]);

		// 	$_SESSION['alert'] = "Product added";
		// }
        if (isset($_POST['buy_now'])) {
            array_push($_SESSION[$buy_now], [
				"product_name" => $product_name,
				"product_price" => $product_price,
				"product_image" => $product_image,
                "product_description" => $product_description,
                "product_dimension" => $product_dimension,
                "product_stock" => $product_stock
			]);

			$_SESSION['alert'] = "Product added s";
        
        }
        $total_quantity = 0;
        foreach ($_SESSION[$cart_name] as $key => $dish) {
            $product_quantity = $dish['product_quantity'];
            $total_quantity += $product_quantity;
        }
        // Count the total number of orders
        $auth_id = $auth['id'];
        $sql = "SELECT * FROM `orders` WHERE `customer_id` = ? ORDER BY date_added DESC;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$auth_id]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $totalOrders = count($orders);

	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>
    <link rel="stylesheet" href="style/product_view.css">
    <!-- <link rel="stylesheet" href="style/product.css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

</head>

<style>
/* .product_button {
        display: inline-block;
        margin-right: 10px; 
    }

    .add_button {
        
    }

    .buy_button {
        width: 60%;
    }
    .view_addtocartForm{
        width: 40%;
    }
    .view_buynowForm{
        width: 60%;
    } */
.purchase-info {
    display: flex;
    margin: 15px auto 0 auto;
    width: 90%;
    text-align: center;
}

.purchase-info .product_button .adds_button {
    display: inline-block;
    color: #039103;
    background-color: #03910317;
    border: green;
    margin-right: 5px;
    max-height: 50px;
    min-width: 150px;
    border-radius: 5px;
    font-size: 15px;
    border: 3px solid;
    cursor: pointer;
    text-align: center;
    padding: 10px 10px;
}

.purchase-info .product_button .buys_button {
    /* display: inline-block; */
    visibility: hidden;
    color: #ffff;
    background-color: green;
    /* border: #910503; */
    margin-left: 5px;
    max-height: 50px;
    min-width: 250px;
    border-radius: 5px;
    font-size: 15px;
    border: 3px solid #03910317;
    cursor: pointer;
    text-align: center;
    padding: 10px 10px
}

.back_button {
    display: block;
    width: 100px;
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

<body>
    <?php include "nav.php" ?>

    <a class="back_button" href="javascript:void(0);" onclick="goBack()">
        <i class='bx bx-arrow-back' style='font-size:12px'></i>Back
    </a>

    <script>
    function goBack() {
        window.history.back();
    }
    </script>

    <div class="card-wrapper">
        <div class="card">
            <?php if (isset($_GET['product_id'])) :
                // Retrieve the product details from the database using the product_id
                $product_id = $_GET['product_id'];
                // You should use a prepared statement to prevent SQL injection
                $query = "SELECT * FROM inventory WHERE product_id = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$product_id]);
                $item = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($item) : ?>
            <!-- card left -->
            <div class="product-imgs">
                <!-- ... (image showcase and selection code) ... -->
                <div class="img-display">
                    <div class="img-showcase">
                        <img src="image/<?php echo $item['product_image']; ?>" alt="shoe image">
                        <img src="image/<?php echo $item['product_image']; ?>" alt="shoe image">
                        <img src="image/<?php echo $item['product_image']; ?>" alt="shoe image">
                        <img src="image/<?php echo $item['product_image']; ?>" alt="shoe image">
                    </div>
                </div>
                <!-- <div class="img-select">
                            <div class="img-item">
                                <a href="#" data-id="1">
                                    <img src="image/<?php echo $item['product_image']; ?>" alt="shoe image">
                                </a>
                            </div>
                            <div class="img-item">
                                <a href="#" data-id="2">
                                    <img src="image/<?php echo $item['product_image']; ?>" alt="shoe image">
                                </a>
                            </div>
                            <div class="img-item">
                                <a href="#" data-id="3">
                                    <img src="image/<?php echo $item['product_image']; ?>" alt="shoe image">
                                </a>
                            </div>
                            <div class="img-item">
                                <a href="#" data-id="4">
                                    <img src="image/<?php echo $item['product_image']; ?>" alt="shoe image">
                                </a>
                            </div>
                        </div> -->
            </div>

            <!-- card right -->

            <div class="product-content">

                <h3 class="product-title"><?= $item['product_name'] ?></h3>
                <div class="product-rating">
                    <!-- Add star rating or other relevant product information -->
                </div>
                <div class="product-price">
                    <h1 class="price">₱ <span><?php echo number_format($item['product_price'], 2); ?></span></h1>
                </div>
                <div class="product-detail">
                    <p>Elevate your space with our Patron Saint Figurine. Handcrafted with precision, it
                        embodies divine protection and guidance. Made from durable resin, it features intricate details
                        and stands 8 inches tall. Perfect for gifting or personal devotion.</p>
                    <ul>
                        <li><i class='fa fa-check-circle'></i> Description:
                            <span><?= $item['product_description'] ?></span>
                        </li>
                        <li><i class='fa fa-check-circle'></i> Stock: <span><?php echo $item['product_stock']; ?> pieces
                                available</span></li>
                        <li><i class='fa fa-check-circle'></i> Dimension:
                            <span><?php echo $item['product_dimension']; ?></span>
                        </li>
                        <li><i class='fa fa-check-circle'></i> Category: <span>Chibi Saints</span></li>
                        <li><i class='fa fa-check-circle'></i> Shipping Area: <span>Nationwide</span></li>
                        <li><i class='fa fa-check-circle'></i> Shipping Fee:
                            <span>to Luzon- 40pesos <br>to Visayas- 80pesos <br> to Mindanao - 120pesos</span>
                        </li>
                    </ul>
                </div>
                <?php else : ?>
                <p>Product not found.</p>
                <?php endif;
                    else : ?>
                <p>Invalid request.</p>
                <?php endif; ?>
                <hr>
                <div class="purchase-info">


                    <form class="view_buynowForm" id="addToCartForm" action="buy_now.php" method="POST">
                        <input type="hidden" name="product_name" value="<?php echo $item['product_name']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $item['product_image']; ?>">
                        <input type="hidden" name="product_description"
                            value="<?php echo $item['product_description']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $item['product_price']; ?>">

                        <?php if ($is_customer_logged_in) { ?>
                        <div class="product_button">
                            <input type="submit" name="buy_now" class="buys_button" value="Buy Now" />
                        </div>
                        <?php } else { ?>
                        <div class="product_button">
                            <a href="customer/login.php" class="buys_button">Buy Now</a>
                        </div>
                        <?php } ?>
                    </form>

                    <form class="view_addtocartForm" id="addToCartForm" action="customer/addtocart.php" method="POST">
                        <input type="hidden" name="product_name" value="<?php echo $item['product_name']; ?>"></input>
                        <input type="hidden" name="product_image" value="<?php echo $item['product_image']; ?>"></input>
                        <input type="hidden" name="product_description"
                            value="<?php echo $item['product_description']; ?>"></input>
                        <input type="hidden" name="product_price" value="<?php echo $item['product_price']; ?>"></input>
                        <input type="hidden" name="product_stock" value="<?php echo $item['product_stock']; ?>"></input>
                        <?php if ( $is_customer_logged_in) { ?>
                        <div class="product_button">
                            <input type="submit" name="product_add" class="adds_button" id="add-article"
                                value="Add to cart" />
                        </div>
                        <?php } else { ?>
                        <div class="product_button">
                            <a href="customer/login.php" class="adds_button">Add to Cart</a>
                        </div>
                        <?php } ?>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <?php include "footer.php" ?>
    <script src="js/cart.js"></script>
    <script>
    const imgs = document.querySelectorAll('.img-select a');
    const imgBtns = [...imgs];
    let imgId = 1;

    imgBtns.forEach((imgItem) => {
        imgItem.addEventListener('click', (event) => {
            event.preventDefault();
            imgId = imgItem.dataset.id;
            slideImage();
        });
    });

    function slideImage() {
        const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;

        document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
    }

    window.addEventListener('resize', slideImage);
    </script>
</body>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Select the "Add to cart" button
    const addToCartButtons = document.querySelectorAll(".adds_button");

    // Add event listener to handle button click for each "Add to cart" button
    addToCartButtons.forEach(function(button) {
        button.addEventListener("click", function(event) {
            // Count the total number of items in the cart
            var totalQuantity = <?php echo $total_quantity; ?>;

            // If the total quantity is 5, display an alert and prevent further addition
            if (totalQuantity === 5) {
                event.preventDefault(); // Prevent the default click behavior
                alert('You can only purchase 5 items per transaction!');
                window.location.href = 'cart.php'; // Redirect to products.php
            }
        });
    });
});
</script>

</html>