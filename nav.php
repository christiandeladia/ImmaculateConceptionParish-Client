<?php 
	require_once "connect.php";
	$is_customer_logged_in = isset($_SESSION['auth_login']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation</title>
    <link rel="icon" type="image/x-icon" href="image/favicon.ico">
    <link rel="stylesheet" href="style/nav.css">
    <link rel="stylesheet" href="style/cart.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body style=" background-color: #f5f5f5">
    <?php
if ( isset($_SESSION['auth_login']) ) {
$auth = $_SESSION['auth_login'];
$auth_full_name = $auth['first_name'] . $auth['last_name'];
$auth_id = $auth['id'];
$query_client = "SELECT COUNT(*) AS client_count FROM notification_client WHERE status = 'unread' AND customer_id = $auth_id";
$query_order = "SELECT COUNT(*) AS order_count FROM notification_order WHERE status = 'unread' AND customer_id = $auth_id";

$result_client = mysqli_query($conn, $query_client);
$result_order = mysqli_query($conn, $query_order);
if ($result_client && $result_order) {
    $row_client = mysqli_fetch_assoc($result_client);
    $row_order = mysqli_fetch_assoc($result_order);
    $total_notif = $row_client['client_count'] + $row_order['order_count'];
}
}
?>
<!-- 
    <div class="chat-head" id="chatHead">
        <div class="chat-icon" onclick="toggleChat()">Chat</div>
        <div class="chat-window" id="chatWindow">
        </div>
    </div> -->
    <div class="navtop">
        <div class="navcenter">
            <a href="index.php">
                <img class="logo" src="image/logo2.png" alt="Logo" />
            </a>
            <div class="topnav">
                <div class="topnav-left">
                    <a href="index.php">Home</a>
                    <a href="product.php">Products</a>
                    <div class="dropdown">
                        <button class="dropbtn">Services
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content">
                            <a href="view_services.php">My Applications</a>
                            <a href="request.php">Request for Certificate</a>
                            <a href="apply.php">Apply for Services</a>
                        </div>
                    </div>
                    <a href="about.php">About</a>
                    <a href="notification.php"
                        <?php echo !$is_customer_logged_in ? "style='display: none;'" : ""; ?>>Notification
                        <?php if ($total_notif > 0): ?>
                        <span class="badges"><?php echo $total_notif; ?></span>
                        <?php endif; ?>
                    </a>

                </div>

                <div class="topnav-right-container">
                    <div class="topnav-right">
                        <?php if( !$is_customer_logged_in ){ ?>
                        <a class="border_signup" href="customer/signup.php">Sign Up</a>
                        <a class="border_login" href="customer/login.php"> Log In </a>
                        <?php } ?>

                        <div class="nav_profile" <?php echo !$is_customer_logged_in ? "style='display: none;'" : ""; ?>>
                            <div class="user">
                                <h3><?php echo $auth_full_name; ?></h3>
                                <p><?php echo $auth['email']; ?></p>
                            </div>
                            <div class="profile-container">
                                <div id="profileImage">
                                    K
                                </div>
                                <span class="dropdown-icon"> <i class="fas fa-angle-down"> </i></span>
                            </div>
                        </div>
                        <div class="menu">
                            <ul>
                                <li><a href="user_profile.php"><i class="fas fa-user"></i>&nbsp;Profile</a></li>
                                <li><a href="donation.php"><i class="fas fa-donate"></i>&nbsp;Donations & Support</a></li>
                                <li><a href="terms&cond.php"><i class="fas fa-shield-alt"></i>&nbsp;Terms &
                                        Conditions</a></li>
                                <li><a href="faq.php"><i class="fas fa-question"></i>&nbsp;FAQ</a></li>
                                <li><a href="customer/logout.php" style="color:red;"><i
                                            class="fas fa-sign-out-alt"></i>&nbsp;Sign Out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
let profile = document.querySelector('.nav_profile');
let menu = document.querySelector('.menu');

profile.onmouseover = function() {
    menu.classList.add('active');
}

profile.onmouseout = function() {
    menu.classList.remove('active');
}

menu.onmouseover = function() {
    menu.classList.add('active');
}

menu.onmouseout = function() {
    menu.classList.remove('active');
}
</script>

<!-- script for profile first and lastletter -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {
    var firstName = '<?php echo $auth['first_name']; ?>';
    var lastName = '<?php echo $auth['last_name']; ?>';
    var initials = firstName.charAt(0) + lastName.charAt(0);
    $('#profileImage').text(initials);
});

function toggleChat() {
    var chatWindow = document.getElementById("chatWindow");
    chatWindow.classList.toggle("active");
}
</script>

</html>
<!-- style for profile dropdown -->
<style>
.badges {
    background-color: #d50000;
    color: white;
    padding: 3px 8px;
    position: absolute;
    margin-top: -10px;
    font-size: 12px;
    border-radius: 50%;
}

nav {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 80px;
    background: #fff;
    box-shadow: 0 10px 20px rgba(0, 0, 0, .2);
    padding: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* menu toggle */

.menu-toggle {
    position: relative;
    width: 40px;
    height: 40px;
    cursor: not-allowed;
    display: flex;
    justify-content: center;
    align-items: center;
}

.menu-toggle::before {
    content: '';
    position: absolute;
    width: 24px;
    height: 4px;
    background: #000;
    box-shadow: 0 8px 0 #000,
        0 -8px 0 #000;
}

/* profile menu */

/* .nav_profile {
        position: relative;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 7px;
        cursor: pointer;
        text-align: end;
        width: 200px;
        max-height: 40px;
    }

    .nav_profile h3 {
        text-align: end;
        line-height: 1;
        margin-bottom: -10px;
        font-weight: 600;
    }

    .nav_profile p {
        line-height: 1;
        font-size: 12px;
        opacity: .6;
    } */

.nav_profile .img-box {
    position: relative;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    overflow: hidden;
}

.nav_profile .img-box img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* menu (the right one) */


.menu {
    position: absolute;
    top: calc(100% + 24px);
    width: 220px;
    min-height: 100px;
    background: #fff;
    box-shadow: 0 10px 20px rgba(0, 0, 0, .2);
    opacity: 0;
    transform: translateY(-10px);
    visibility: hidden;
    transition: 300ms;
}


.menu::before {
    content: '';
    position: absolute;
    top: -10px;
    right: 14px;
    width: 20px;
    height: 20px;
    background: #fff;
    transform: rotate(45deg);
    z-index: -1;
}

.menu.active {
    opacity: 1;
    transform: translateY(0);
    visibility: visible;
}

/* menu links */

.menu ul {
    position: relative;
    display: flex;
    flex-direction: column;
    z-index: 10;
    background: #fff;
    padding: 0;
}

.menu li:not(:last-child) .fas {
    color: rgb(0, 128, 0);
}

.menu li:last-child {
    border-top: 1px solid rgba(0, 0, 0, 0.3);

}

.menu ul li {
    list-style: none;
}

.menu ul li:hover {
    background: #eee;
    cursor: pointer;
}

.menu ul li a {
    color: #000;
    display: block;
    padding: 15px 20px;
    text-align: left;
    width: 100%;
}

.menu ul li a i {
    font-size: 1.2em;
}

/* #profileImage {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgb(37, 141, 54);
    font-size: 18px;
    color: #fff;
    text-align: center;
    line-height: 48px; 
    font-weight: bold; 
} */
.profile-container {
    position: relative;
}

#profileImage {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #002d0a;
    font-size: 18px;
    color: #fff;
    text-align: center;
    line-height: 48px;
    font-weight: bold;
    cursor: pointer;
    position: relative;
    z-index: 1;
}

.dropdown-icon {
    width: 16px;
    /* Set the same size as the height for a perfect circle */
    height: 16px;
    /* Set the same size as the width for a perfect circle */
    line-height: 16px;
    /* Set the same value as the height for centering the icon */
    position: absolute;
    bottom: 0;
    right: 0;
    z-index: 2;
    border-radius: 50%;
    background: #333;
    /* Adjust the background color as needed */
    display: flex;
    justify-content: center;
    align-items: center;
}

.dropdown-icon i {
    color: #fff;
    /* Adjust the color of the dropdown icon as needed */
    font-size: 14px;
    /* Adjust the font size of the dropdown icon as needed */
}

.chat-head {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background-color: #007bff;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 1000;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    opacity: 40%;
}

.chat-head:hover {
    opacity: 100%;
}

.chat-window {
    display: none;
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 600px;
    height: 400px;
    background-color: #f5f5f5;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    overflow: hidden;
}

.chat-window.active {
    display: block;
}

body::-webkit-scrollbar {
    width: 13px;
}

body::-webkit-scrollbar-track {
    background: transparent;
}

body::-webkit-scrollbar-thumb {
    background: #0c83435e;
    border-radius: 20px;
}

body::-webkit-scrollbar-thumb:hover {
    background: rgb(37, 141, 54);
}
</style>