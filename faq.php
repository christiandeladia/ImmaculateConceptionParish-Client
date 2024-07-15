<?php 
	require_once "connect.php";
	$is_customer_logged_in = isset($_SESSION['auth_login']);
?>
<?php
    $faq_query = "SELECT * FROM faq WHERE status = 'active' ORDER BY title; ";
    $faq_result = mysqli_query($conn, $faq_query);

    if ($faq_result) {
        $faq = mysqli_fetch_all($faq_result, MYSQLI_ASSOC);
    } else {
        echo "Error fetching FAQ data: " . mysqli_error($conn);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - ICP</title>
    <link rel="stylesheet" href="style/nav.css">
    <link rel="stylesheet" href="style/banner.css">
    <link rel="stylesheet" href="style/product.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>


<style>
    .search-box{
    width: 90%;
    max-width: 1000px;
  }
</style>
<?php include 'nav.php';?>
<body>
<header>
<h1 class="faq">Frequently Asked Question's</h1>
        <!-- Add this HTML block inside the <header> in your code -->
        <div class="search-box">
            <input type="text" class="search-input" id="search-input" placeholder="Search..">

            <button class="search-button" id="search-button">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <div id="search-results">
            <!-- The search results will be displayed here -->
        </div>

    </header>

    <!-- FAQ Section -->
    <div class="accordion" id="faq_section">
        
        <?php foreach ($faq as $item) { ?>
        <div class="accordion-item">
            <div class="accordion-item-header">
            <?php echo $item['title']; ?>
            </div>
            <div class="accordion-item-body">
                <div class="accordion-item-body-content">
                <?php echo $item['content']; ?>
                </div>
            </div>
        </div>
        <?php } ?>
        
        <div style="padding: 50px;"></div>
    </div>

    
</body>

<?php include 'footer.php';?>

<script src="js/accordion.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("search-input");
    const searchButton = document.getElementById("search-button");
    const searchResults = document.getElementById("search-results");
    const allHeaders = document.querySelectorAll(".accordion-item-header");

    // Function to filter accordion items based on search query
    function performSearch() {
        const query = searchInput.value.trim().toLowerCase();

        allHeaders.forEach(header => {
            const text = header.textContent.toLowerCase();
            const item = header.closest(".accordion-item");

            if (text.includes(query)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    }

    // Add an event listener for the search button and input
    searchButton.addEventListener("click", performSearch);
    searchInput.addEventListener("input", performSearch);
});
</script>
</html>