<?php 
	require_once "connect.php";
	$is_customer_logged_in = isset($_SESSION['auth_login']);

    
    // $totalWeddingbanns = $WeddingbannsResult['total_group_orders'];
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
				$sql = "INSERT INTO `orders`(`group_order`, `customer_id`, `product_name`, `product_price`, `product_image`)
						VALUES(?, ?, ?, ?, ?);";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$group_order, $auth_id, $name, $price, $image]);
			}

			unset($_SESSION[$cart_name]);
			header("location: orders.php");
			exit;
		}

		if (isset($product_id)) {
			unset($_SESSION[$cart_name][$product_id]);
			header("location: index.php");
			exit;
		}

		if (isset($product_add)) {
			array_push($_SESSION[$cart_name], [
				"product_name" => $product_name,
				"product_price" => $product_price,
				"product_image" => $product_image
			]);

			$_SESSION['alert'] = "Product added";
		}

	}
?>
<?php
$sql = "SELECT COUNT(*) AS count FROM wedding_banns WHERE status = 'ongoing'";
$stmt = $pdo->prepare($sql);
$stmt->execute(); // Execute the prepared statement
$WeddingbannsResult = $stmt->fetch(PDO::FETCH_ASSOC);

$count_weddingbanns = $WeddingbannsResult['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME - ICP</title>
    <link rel="stylesheet" href="style/nav.css">
    <link rel="stylesheet" href="style/slideshow.css">
    <link rel="stylesheet" href="style/banner.css">
    <link rel="stylesheet" href="style/weddingbanns.css">
    <link rel="stylesheet" href="view_weddingbanns.php">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<style>
    /* CONTACTS */
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");



.contacts_about {
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: "Poppins", sans-serif;
}

.contact-container {
    margin-top: 45px;
    max-width: 1500px;
    width: 100%;
    margin: 0 auto;
}

:root {
    /* //....... Color ........// */
    --primary-color: #ff3c78;
    --light-black: rgba(0, 0, 0, 0.89);
    --black: #000;
    --white: #fff;
    --grey: #aaa;
}


.form {
    display: flex;
    justify-content: space-between;
    margin: 130px 0 80px 0;
}

.form .form-txt {
    flex-basis: 48%;
}

.form .form-txt h1 {
    font-weight: 600;
    color: var(--black);
    font-size: 40px;
    letter-spacing: 1.5px;
    margin: 0 0 10px 0;
    color: var(--light-black);
}

.form .form-txt span {
    color: var(--light-black);
    font-size: 14px;
}

.form .form-txt h3 {
    font-size: 22px;
    font-weight: 600;
    margin: 15px 0;
    color: var(--light-black);
}

.form .form-txt p {
    color: var(--light-black);
    font-size: 14px;
    margin: 0;
}

.form .form-details {
    flex-basis: 48%;
}


@media (max-width: 500px) {
    .form {
        display: flex;
        flex-direction: column;
    }

}

@media(min-width: 501px) and (max-width: 768px) {
    .form {
        display: flex;
        flex-direction: column;
    }

}

/* GOOGLE MAPS */
.map-wrapper {
    max-width: 800px;
    margin: 0 auto;
    padding: 40px 20px;
    background-color: #fff;
    box-shadow: 0 4px 9px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

.map-wrapper h1 {
    text-align: center;
    font-size: 28px;
    font-weight: bold;
    color: #333;
    margin-bottom: 30px;
}

.map-container {
    position: relative;
    width: 100%;
    height: 0;
    padding-bottom: 56.25%;

}

iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
    border-radius: 10px;
}
.menu {
    padding-left: 73%;
}
</style>
<?php include 'nav.php';?>

<body>
<?php include 'preloader.php'; ?>
    <!-- Slideshow Section -->
    <br>
    <div class="slideshow">
        <div class="images">
            <img class="fade" src="image/cover1.jpg" style="width:100%">
        </div>
        <div class="images">
            <img class="fade" src="image/cover2.jpg" style="width:100%">
        </div>
        <div class="images">
            <img class="fade" src="image/cover3.jpg" style="width:100%">
        </div>
        <div class="dot-container">
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>

    <!-- Featured Section -->
    <br><br>
    <!-- <div>
        <ul class="process">
            <li class="process__item animate-from-bottom__1">
                <span class="process__number"><i class="fas fa-cubes"></i></span>
                <span class="process__title">Management</span>
                <span class="process__subtitle">We manage the data of records</span>
            </li>

            <li class="process__item animate-from-bottom__2">
                <span class="process__number"><i class="fas fa-handshake"></i></span>
                <span class="process__title">Services</span>
                <span class="process__subtitle">We off services online to be more convenient</span>
            </li>

            <li class="process__item animate-from-bottom__3">
                <span class="process__number"><i class="fas fa-shopping-bag"></i></i></span>
                <span class="process__title">Products</span>
                <span class="process__subtitle">We offer products and deliver nationwide</span>
            </li>

            <li class="process__item animate-from-bottom__4">
                <span class="process__number"><i class="fas fa-code"></i></span>
                <span class="process__title">Development</span>
                <span class="process__subtitle">We analyze the requirments to develop a strategy</span>
            </li>
        </ul>
    </div> -->

    <br class="nospacemobile"><br class="nospacemobile">

    <!-- Verses Section-->
    <section id="about" class="section-verse">
        <div class="overlay">
            <div class="section-verse-inner py-5">
                <p class="mt-1">Verse of the Day:</p>
                <?php include './component/verse.php';?>
                <?php echo '<h3 class="text-2"> '.$verseOfTheDay['author'].' </h3>'; ?>
                <?php echo '<h2 class="text-5 mt-1">" '.$verseOfTheDay['quote'].' "</h2>'; ?>
            </div>
        </div>
    </section>


    <!-- weddingbanns Section -->
    <div class="nospacemobile" style="background-color: #f5f5f5">
    <div style="padding: 50px;"></div>
        <h1 style="text-align:center; color: #035d13;">Ikakasal sa Parokya</h1>
        <h4 style="text-align:center; color: #258d36;">Marriage Banns of the Proposed Marriage of:</h4>
        <hr style="width: 90%;  border: 1px solid #035d13;">
        <?php include './component/weddingbanns.php';?>
        <a class="view_button"  href= "view_weddingbanns.php">View All</a>
        <hr style="width: 90%;  border: 1px solid #035d13; margin-top: 30px;">
        <div style="padding: 50px;"></div>
    </div>



    <!-- Showcase Section -->
    <section class="section-showcase">
    <div style="padding: 0px;"></div>
        <div class="container">
            <div>
                <h1 class="showcase_title">Immaculate Conception Parish</h1>
                <p>
                    Pandi was founded in 1792. The earthquake of 1880 damaged the church and the convent constructed
                    early in the nineteenth century. They were finally destroyed by fire, with the town itself, incident
                    to an encounter between American and Filipino forces in April, 1899.
                </p>
                <a href="about.php" class="btn_readmore">Read More</a>
            </div>
            <img class="churchimage"src="image/showcase_church.png" alt="" />
        </div>
        <div style="padding: 0px;"></div>
    </section>


    <section class="contacts_about">
        <div class="contact-container">
            <form>
                <div class="form">
                    <div class="form-txt">
                        <h1>Contact Us</h1>
                        <strong>J.P Rizal St, Poblacion, Pandi, 3014 Bulacan</strong><br>
                        <a href="your_link_url_here"></ul>
                            <p>Email - <u
                                    style="text-underline-position: under; color: green;">immaculateconception1874@gmail.com</u>
                            </p>
                        </a>
                        <a href="your_link_url_here"></ul>
                            <p>Facebook - <u
                                    style="text-underline-position: under; color: green;">fb.com/immaculateconceptionparishpandi1874</u>
                            </p>
                        </a>
                        <a href="your_link_url_here"></ul>
                            <p>Contact Number - <u
                                    style="text-underline-position: under; color: green;">0916-5798-189</u></p>
                        </a>



                        <h3>Parish Office Schedule:</h3>
                        <p>MONDAYS - Parish office is closed on Mondays.</p>
                        <p>TUESDAYS TO SUNDAYS - 8:00 AM to 12:00 PM; 2:00 PM to 5:00 PM</p>

                        <h3>Schedule of Masses:</h3>
                        <li>Monday - 6:00 AM</li>
                        <li>Tuesday - 6:00 AM</li>
                        <li>Wednesday - 6:00 AM</li>
                        <li>Thursday - 6:00 AM</li>
                        <li>Friday - 6:00 AM</li>
                        <li>Saturday - 6:00 AM</li>
                        <li>Sunday - 6:00 AM, 8:00 AM, 5:00 PM</li>
                    </div>
                    <div class="form-details">
                        <div class="map-wrapper">
                            <h1>Explore Our Location</h1>
                            <div class="map-container">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3856.323117284999!2d120.95520931135269!3d14.863199870532387!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ab89e41cfb07%3A0x2f2337a16ed664d4!2sSimbahan%20ng%20Parokya%20ng%20Immaculada%20Concepcion%20-%20Pandi%2C%20Bulacan!5e0!3m2!1sen!2sph!4v1712323258198!5m2!1sen!2sph"
                                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php include 'footer.php';?>
</body>
<script src="js/slideshow.js"></script>
<script src="js/accordion.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        let itemCount = <?php echo $count_weddingbanns; ?>;

        // Select the button element
        // const viewAllButton = document.getElementById('view_button');

        // viewAllButton.addEventListener('click', function(event) {
        //     event.preventDefault();
        //     if (itemCount > 5) {
        //         console.log("View All clicked!");
        //     } else {
        //         console.log("Nothing to view!");
        //     }
        // });

        // Initial check for count
        if (itemCount > 1) {
            // If count is greater than 5, display the button
            viewAllButton.style.display = 'block';
        } else {
            // Otherwise, hide the button
            viewAllButton.style.display = 'none';
        }
    });
</script>
<style>
@media only screen and (max-width: 1024px){
    .slideshow {
        max-width: 95%;
    }
    .weddingbannsmargin {
        padding: 10px !important;
    }
    .accordionmargin {
        padding: 0px !important;
    }
    .btn_readmore {
      margin-left: 310px;
      margin-top: 40px;
    }
    .form .form-txt {
        margin-left: 20px;
    }
    .form .form-details {
        margin-right: 20px;
    }
    .column1 {
        height: 330px;
    }
}
@media only screen and (max-width: 768px){
    .slideshow {
        max-width: 99%;
    }
    .section-showcase h1 {
        font-size: 2.5rem;
    }
    .section-showcase p {
        padding-right: 50px;
        padding-left: 50px;
        text-align: justify;
        font-size: 20px;
    }
    .section-verse {
         height: 450px;
    }
    .churchimage {
        width: 620px !important;
    }
    .btn_readmore {
      margin-left: 250px;
      margin-top: 20px;
    }
    .form .form-txt {
        text-align: center;
    }
    .form .form-details {
        margin-left: 20px;
    }
}
@media only screen and (max-width: 320px){
    .nospacemobile {
        display: none;
    }
    .churchimage {
        width: 420px !important;
    }
    .section-verse {
        height: 280px;
    }
    .space {
        display: none;
    }
    .proposedmarriage {
        font-size: 10px;
    }
    .weddingbannsmargin {
        padding: 0px !important;
    }
    .view_button {
        font-size: 8px;
        margin-top: 0px;
    }
    .line {
        margin-top: 5px !important;
    }
    .container img {
        max-height: 300px;
    }
    .showcase_title {
        font-size: 17px !important; 
        margin-top: 0px;
    }
    .section-showcase .container {
        display: grid;
        grid-template-columns: 1fr;
        height: 900px;
        grid-gap: 1rem;
    }
    .btn_readmore { 
        margin-left: 5px;
        margin-top: 10px;
        font-size: 8px;
    }
    .section-showcase p {
        font-size: 10px;
        padding-right: 100px;
        padding-left: 100px;
    }
    .container {
        margin: auto;
        overflow: hidden;
        padding: 0 1rem;
        max-height: 520px;
    }   
    .faq {
        font-size: 22px;
        margin: .8rem 0;
    }
    .form .form-txt p {
        font-size: 10px;
    }
    .form {
        margin: 0px 0 0px 0;
        margin-right: 5px;
    }
    .form .form-txt h1 {
        font-size: 30px;
    }
    .form .form-txt {
        margin-left: 0px;
    }
    .slider-carousel {
        column-gap: 0px;
    }
    .responsives {
        padding: 0px;
    }
    .1x1picture  
}
</style>
</html>