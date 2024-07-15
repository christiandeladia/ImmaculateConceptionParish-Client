<?php 
    require_once "../connect.php";
    $is_customer_logged_in = isset($_SESSION['auth_login']);
?>
<?php
    if ( isset($_SESSION['auth_login']) ) {
		$auth = $_SESSION['auth_login'];
        $auth_full_name = $auth['first_name'] . $auth['last_name'];
}
?>
<html>

<head>
    <title>Services</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="./styles/services.css">
    <link rel="stylesheet" href="../style/nav.css">
    <link rel="stylesheet" href="../style/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css'>
</head>
<div class="navtop">
    <div class="navcenter">
        <a href="../index.php">
            <img class="logo" src="../image/logo.png" alt="Logo" />
        </a>
        <div class="topnav">
            <div class="topnav-left">
                <a href="../index.php">Home</a>
                <a href="../product.php">Products</a>
                <a href="services_forms/index.php">Services</a>
                <a href="../about.php">About</a>
                <a href="#">Notification</a>
            </div>

            <div class="topnav-right">
                <?php if( !$is_customer_logged_in ){ ?>
                <a class="border_signup" href="customer/signup.php">Sign Up</a>
                <a class="border_login" href="customer/login.php"> Log In </a>
                <?php } ?>
                <!-- <a href="cart.php"><i class="bx bx-cart"></i></a> -->

                <div class="dropdown" <?php echo !$is_customer_logged_in ? "style='display: none;'" : ""; ?>>
                    <button class="dropbtn"><i class="fa fa-user"></i> <?php echo $auth_full_name; ?>
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="#">My Profile</a>
                        <a href="#">Send Donations</a>
                        <a href="customer/logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="certificate" class="modal">
    <div class="modal-content">
        <span class="close1 close">&times;</span>
        <h2 id="certificate">Certificate Request</h2>
        <div class="bttn">
            <a class="button button1" href="#">Wedding</a>
            <a class="button button2" href="#">Baptism</a>
            <a class="button button3" href="#">Funeral</a>
        </div>
    </div>
</div>

<div id="application" class="modal">
    <div class="modal-content">
        <span class="close2 close">&times;</span>
        <h2 id="application">Application Form</h2>
        <div class="bttn">
            <a class="button button1" href="./user_form/baptismal_form.php">Baptismal</a>
            <a class="button button2" href="./user_form/funeral_form.php">Funeral</a>
            <a class="button button3" href="./user_form/wedding_form.php">Wedding</a>
            <a class="button button4" href="./user_form/blessing_form.php">Blessing</a>
            <a class="button button5" href="./user_form/sickcall_form.ph">Sick Call</a>
        </div>
    </div>
</div>

<div class="outer-container">
    <div class="calendar1">
        <!-- <select id="service" name="service" required>
        <option value="option1">Select Service</option>
        <option value="option2">Wedding</option>
        <option value="option3">Funeral</option>
        <option value="option1">Baptismal</option>
        <option value="option2">Sickcall</option>
    </select>
    <input type="text" name="q" placeholder="Search..."/>
</input> -->
        <!-- <iframe src="https://calendar.google.com/calendar/embed?src=yourcalendar%40example.com" width="105%" height="500" frameborder="0" scrolling="no"></iframe> -->
    </div>

    <div class="inner-container">
        <div class="buttons">
            <h2 id="button-title"> FORM </h2>
            <a href="#" class="button buttonC" data-modal-id="certificate">Request for Certificate</a>
            <a href="#" class="button buttonA" data-modal-id="application">Application Form</a>
        </div>
    </div>
</div>
<script src="./js/modal.js"></script>
<?php include '../footer.php';?>
</html>