<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <a href="#"><i class="fa fa-facebook"></i></a> -->
    <!-- ... (your head section remains the same) ... -->
</head>

<body>

    <?php
require_once "connect.php";
$is_customer_logged_in = isset($_SESSION['auth_login']);

if (isset($_POST['query'])) {
    $searchQuery = $_POST['query'];

    // Perform a database query to search for items based on the query
    $sql = "SELECT * FROM inventory WHERE product_name LIKE :query";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':query', '%' . $searchQuery . '%', PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($results)) {
        // Display the search results with the same design as the product listings
        foreach ($results as $item) {
            $output = <<<HTML
            <div class="row article-holder">
                <div class="column">
                    <div class="item article-box">
                        <div class="img-box">
                            <img class="article-img" src="image/{$item['product_image']}" alt="ICP Products">
                        </div>
                        <div class="details">
                            <h2>{$item['product_name']}<br><span>{$item['product_description']}</span></h2>
                            
                            <div class="price-container">
                            <div class="price">₱ {$item['product_price']}.00</div>
                            <div class="sold">0 sold</div>
                            </div>
                            <label>Dimension</label>
                            <ul>
                                <li>{$item['product_dimension']}</li>
                            </ul>
                            <label>Stock</label>
                            <ul>
                                <li>{$item['product_stock']} available</li>
                                <li></li>
                                <li></li>
                            </ul>
                            <form class="addToCartForm" id="addToCartForm" action="customer/addtocart.php" method="POST">
                                <input type="hidden" name="product_name" value="{$item['product_name']}">
                                <input type="hidden" name="product_image" value="{$item['product_image']}">
                                <input type="hidden" name="product_description" value="{$item['product_description']}">
                                <input type="hidden" name="product_price" value="{$item['product_price']}">
HTML;

if ($is_customer_logged_in) {
    $output .= <<<HTML
        <div class="product_button">
            <input type="submit" name="product_add" class="add_button" id="add-article" value="Add to cart" />
            <a href="product_view.php?product_id={$item['product_id']}" class="view_button">View</a>
        </div>
HTML;
} else {
    $output .= <<<HTML
        <div class="product_button">
            <a href="customer/login.php" name="product_add" class="add_button" id="add-article">Add to cart</a>
            <a href="product_view.php?product_id={$item['product_id']}" class="view_button">View</a>
        </div>
HTML;
}

            $output .= <<<HTML
                            </form>
                        </div>
                    </div>
                </div>
            </div>
HTML;

            echo $output;
        }
    } else {
        echo '<div class="no-results">No results found.</div>';
    }
}
?>

</body>

</html>