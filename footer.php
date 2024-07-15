<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/footer.css">
</head>
<style>
    .horizontal-scroll-container {
    margin-top: 50px;
    position: relative;
    width: 100%;
    overflow: hidden;
    background-color: transparent;
}
    .horizontal-scroll {
width: 100%;
height: 200px;
background: url('http://mckenziedave.co.uk/1st-touch/footer_fr.png');
-webkit-animation: backgroundScroll 400s linear infinite;
animation: backgroundScroll 60s linear infinite;
background-repeat: no-repeat;
}

@-webkit-keyframes backgroundScroll {
from {background-position: 0 0;}
to {background-position: -600px 0;}
}
        
@keyframes backgroundScroll {
from {background-position: 0 0;}
to {background-position: -2000px 0;}
}

.horizontal-scroll2 {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 150px;
    background: url('http://mckenziedave.co.uk/1st-touch/footer_bg.png');
    animation: backgroundScroll2 30s linear infinite;
    background-repeat: no-repeat;
    filter: brightness(0) saturate(100%) invert(12%) sepia(59%) saturate(1295%) hue-rotate(100deg) brightness(95%) contrast(102%);
}

@-webkit-keyframes backgroundScroll2 {
from {background-position: -1000px 0;}
to {background-position: 0 0;}
}
        
@keyframes backgroundScroll2 {
from {background-position: -2000px 0;}
to {background-position: 0 0;}
}

</style>
<body>


<!--FONT AWESOME-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!--GOOGLE FONTS-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

<!--footer-->


<div class="horizontal-scroll-container">
        <div class="horizontal-scroll2"></div>
        <div class="horizontal-scroll"></div>
    </div>
<footer class="padding_2x">

    <div class="flex">
        <section class="flex-content padding_1x">
        </section>
        <section class="flex-content padding_2x">
            <img class="logo" src="image/logo_white.png" alt="Logo" />
            <br><br><br>
            <!-- <h3>Contacts</h3> -->
            <br></br>
            <div class="footer-details">
            <a href="#">
                <span><i class="fas fa-map-marker-alt"></i> Poblacion Pandi Bulacan, Philippines 3014</span>
            </a>
            <a href="#">
                <span><i class="fas fa-phone"></i>+639 123 4567</span>
            </a>
            <a href="#">
                <span><i class="fas fa-envelope"></i> immaculateconceptionparish@email.com</span>
            </a>
            </div>
        </section>
        <section class="flex-content padding_0x">
        </section>
        <section class="flex-content padding_1x">
            <h3>Pages</h3>
            <a href="./index.php">Home</a>
            <a href="./services.php">Services</a>
            <a href="./product.php">Products</a>
            <a href="./about.php">About</a>
            <a href="./notification.php">Notification</a>
        </section>
        <section class="flex-content padding_1x">
            <h3>Services</h3>
            <a href="#">Wedding</a>
            <a href="#">Baptism</a>
            <a href="#">Funeral</a>
            <a href="#">Sick Call</a>
            <a href="#">Blessing</a>
        </section>
        <section class="flex-content padding_1x">
            <h3>Products</h3>
            <a href="product.php">Chibi Saints</a>
        </section>
        <section class="flex-content padding_3x">
            <h3>About our Website</h3>
            <a href="terms&cond.php">Terms and Condition</a>
            <a href="faq.php">FAQ</a>
        </section>
        <section class="flex-content padding_1x">
        </section>
        <section class="flex-content padding_0x"></section>
    </div>
    <br><br>
    <hr>
    <div class="flex">
        <section class="flex-content">
            <p> © 2023 || THESIS PROJECT</p>
        </section>
        <section class="flex-content">
    <a href="https://www.facebook.com" target="_blank"><i class="fa fa-facebook"></i></a>
    <a href=" immaculateconceptionparish@gmail.com" target="_blank"><i class="fa fa-envelope"></i></a>
    <a href="https://www.instagram.com" target="_blank"><i class="fa fa-instagram"></i></a>
    <a href="https://www.youtube.com" target="_blank"><i class="fa fa-youtube"></i></a>
</section>
    </div>
</footer>
</body>
</html>