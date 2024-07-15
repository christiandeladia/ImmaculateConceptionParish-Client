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

		if (isset($product_add)) {
			array_push($_SESSION[$cart_name], [
				"product_name" => $product_name,
				"product_price" => $product_price,
				"product_image" => $product_image,
                "product_description" => $product_description,
                "product_dimension" => $product_dimension,
                "product_stock" => $product_stock
			]);

			$_SESSION['alert'] = "Product added!";
		}
        $total_quantity = 0;
        foreach ($_SESSION[$cart_name] as $key => $dish) {
            $product_quantity = $dish['product_quantity'];
            $total_quantity += $product_quantity;
        }
        // Count the total number of orders
        $auth_id = $auth['id'];
        $sql = "SELECT COUNT(DISTINCT group_order) AS total_group_orders FROM `orders` WHERE `customer_id` = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$auth_id]);
        $totalOrdersResult = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalOrders = $totalOrdersResult['total_group_orders'];


	}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <link rel="stylesheet" href="style/footer.css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="style/product.css">
    <link rel="stylesheet" href="style/cart.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <title>PRODUCTS - ICP</title>
</head>

<?php include 'nav.php';?>
<style>
.alert-message {
    font-weight: bold;
    font-size: 15px;
    color: rgb(22 101 52);
    background-color: #D1FAE5;
    border: solid 1px rgb(22 101 52);
    padding: 30px;
    border-radius: 5px;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: none;
    z-index: 999;
    /* Ensure the alert is on top of other elements */
}

.product_alert {
    position: fixed;
    top: 100px;
    right: 20px;
    background-color: #D1FAE5;
    border: solid 1px rgb(22 101 52);
    color: rgb(22 101 52);
    padding: 15px;
    border-radius: 5px;
    z-index: 9999;
    font-weight: bold;
    font-size: 15px;
    display: none;
    /* Initially hidden */
}
</style>



<body>
    <?php if (isset($_SESSION['alert'])): ?>
    <div class="product_alert" id="product_alert"><?php echo $_SESSION['alert']; ?></div>
    <?php unset($_SESSION['alert']); // Unset the alert after displaying ?>
    <?php endif; ?>

    <!-- HTML for the alert message -->
    <div id="emailAlert" class="alert-message">
    </div>
    <header>
        <!-- Add this HTML block inside the <header> in your code -->
        <div class="search-box">
            <input type="text" class="search-input" id="search-input" placeholder="Search..">

            <button class="search-button" id="search-button">
                <i class="fas fa-search"></i>
            </button>
            <a class="header-cart" href="cart.php">
                <!-- <img src="https://cdn-icons-png.flaticon.com/512/263/263142.png"> -->
                <i class="fa fa-shopping-cart"
                    style="font-size:38px; text-align: center; margin: 0 4px 0 3px; color:rgb(37 141 54)"></i>
                <?php if ($is_customer_logged_in) { ?>
                <span><?php echo $total_quantity; ?></span>
                <?php } else { ?>
                <span>0</span>
                <?php } ?>
            </a>

            <a class="header-order" href="orders.php">
                <h5>My Orders</h5>
                <?php if ($is_customer_logged_in) { ?>
                <span><?php echo $totalOrders; ?></span>
                <?php } else { ?>
                <span>0</span>
                <?php } ?>
            </a>
        </div>

        <div id="search-results">
            <!-- The search results will be displayed here -->
        </div>

    </header>


    <div class="row article-holder">
        <?php
        // $query = "SELECT * FROM inventory";
        $query = "SELECT * FROM inventory WHERE status = 'available'";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $inventory_items = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($inventory_items as $item) {
        ?>
        <div class="column">
            <div class="item article-box">
                <div class="img-box">
                    <img class="article-img" src="image/<?php echo $item['product_image']; ?>" alt="ICP Products">
                </div>
                <div class="details">
                    <h2><?php echo $item['product_name']; ?><br><span><?php echo $item['product_description']; ?></span>
                    </h2>
                    <div class="price-container">
                        <div class="price">₱ <?php echo number_format($item['product_price'], 2); ?></div>
                        <!-- <div class="sold">0 sold</div> -->
                    </div>

                    <label>Dimension</label>
                    <ul>
                        <li><?php echo $item['product_dimension']; ?></li>
                    </ul>
                    <label>Stock</label>
                    <ul>
                        <li><?php echo $item['product_stock']; ?> available</li>
                        <li></li>
                        <li></li>
                    </ul>

                    <form class="addToCartForm" id="addToCartForm" action="customer/addtocart.php" method="POST">
                        <input type="hidden" name="product_name" value="<?php echo $item['product_name']; ?>"></input>
                        <input type="hidden" name="product_image" value="<?php echo $item['product_image']; ?>"></input>
                        <input type="hidden" name="product_description"
                            value="<?php echo $item['product_description']; ?>"></input>
                        <input type="hidden" name="product_price" value="<?php echo $item['product_price']; ?>"></input>
                        <input type="hidden" name="product_stock" value="<?php echo $item['product_stock']; ?>"></input>
                        <?php if ( $is_customer_logged_in) { ?>
                        <div class="product_button">
                            <input type="submit" name="product_add" class="add_button" id="add-article"
                                value="Add to cart" />
                            <a href="product_view.php?product_id=<?php echo $item['product_id']; ?>"
                                class="view_button">View</a>
                        </div>
                        <?php } else { ?>
                        <!-- <a href="customer/login.php" class="add-article">Login to add</a> -->
                        <div class="product_button">
                            <a href="customer/login.php" name="product_add" class="add_button" id="adds-article">Add to
                                cart</a>
                            <a href="product_view.php?product_id=<?php echo $item['product_id']; ?>"
                                class="view_button">View</a>
                        </div>
                        <?php } ?>
                    </form>

                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <br><br>
    <?php include 'footer.php';?>
</body>


<script src="js/cart.js"></script>
<!-- <script>
document.addEventListener("DOMContentLoaded", function() {
    const addToCartForm = document.getElementById("addToCartForm");
    const addToCartButton = document.getElementById("addToCartButton");

    addToCartButton.addEventListener("click", function() {
        
        const formData = new FormData(addToCartForm);
        const xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                
                alert("Product added to cart successfully!");
                console.log("Product added to cart successfully!");
            }
        };

        xhr.open("POST", "customer/addtocart.php", true);
        xhr.send(formData);
    });
});
</script> -->
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("search-input");
    const searchButton = document.getElementById("search-button");
    const searchResults = document.getElementById("search-results");
    const allItems = document.querySelectorAll(".column"); // Add this line to select all items

    // Function to send AJAX request and update search results
    function performSearch() {
        const query = searchInput.value.trim();

        // Hide all items initially
        allItems.forEach(item => {
            item.style.display = "none";
        });

        if (query === "") {
            // If the search input is empty, show all items from the database
            allItems.forEach(item => {
                item.style.display = "block";
            });
            searchResults.innerHTML = "";
        } else {
            // Send an AJAX request to fetch search results
            const xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle the response and display search results
                    searchResults.innerHTML = xhr.responseText;
                }
            };

            xhr.open("POST", "search.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("query=" + query);
        }
    }

    // Add an event listener for the search button and input
    searchButton.addEventListener("click", performSearch);
    searchInput.addEventListener("input", performSearch);
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Select the "Add to cart" button
    const addToCartButton = document.getElementById("adds-article");

    // Add event listener to handle click event
    addToCartButton.addEventListener("click", function() {
        // Call the addToCart() function
        addToCart();
    });
});


function showAlertMessage(message, duration) {
    const alertElement = document.getElementById("emailAlert");
    alertElement.textContent = message; // Set the message text
    alertElement.style.display = "block"; // Display the alert

    // Hide the alert after the specified duration (in milliseconds)
    setTimeout(function() {
        alertElement.style.display = "none"; // Hide the alert
    }, duration);
}

function addToCart() {
    // Perform any necessary actions here, such as adding the product to the cart

    // Show alert notification
    showAlertMessage("Product added to cart!", 2000);
}
</script>

<script>
// Get the alert element
var alertBox = document.getElementById('product_alert');
// If alert element exists, show it
if (alertBox) {
    alertBox.style.display = 'block'; // Show the alert
    // Hide the alert after 5 seconds
    setTimeout(function() {
        alertBox.style.display = 'none'; // Hide the alert
    }, 3000); // 5000 milliseconds = 5 seconds
}
</script>


<script>
document.addEventListener("DOMContentLoaded", function() {
    // Select the "Add to cart" button
    const addToCartButtons = document.querySelectorAll(".add_button");

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