<?php 
    require_once "connect.php";
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
    <title>SERVICES - ICP</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="style/services.css">
    <link rel="stylesheet" href="style/nav.css">
    <link rel="stylesheet" href="style/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>

<?php include 'nav.php';?>
<style>
  .process-row {
    padding: 10px !important;
    margin-top: 0px !important;
}
  .services .service{
    width: 500px !important;
    min-height: 400px !important;
    border-radius: 10px;
  }
  /* .services .service:hover {
  width: 500spx !important;
} */
.apply {
    border: 1px solid rgb(37 141 54);
    color: rgb(37 141 54);
    padding: 10px 12px;
    border-radius: 50px;
    position: absolute;
    top: 80%;
}
.apply:hover{
  color: white;
  background: rgb(37 141 54);
}
.service-icon{
  width: 90%;
}
.services
 .inactive .title {
  font-size: 25px;
  font-weight: 1000;
}
.services
 .inactive {
  padding: 10px 10px !important;
}
</style>

<body>
<div class="header_services">
        <h1>Services</h1>
        <p>Guiding Souls, Strengthening Faith: Our Services for You.</p>
        <!-- <p>Services that we offered:</p> -->
    </div>

<div class="services">
  <div class="process-row">
    <div class="service animate-from-bottom__0">
      <div class="relative-block">
        <div class="service-icon">
          <img src="./image/certificate.png">
        </div>
        <div class="inactive">
          <div class="title">Request For Certificate</div>
        </div>
        <div class="active">
          <div class="title">Request For Certificate</div>
          <div class="sub-title">Available Certificates:
            <ul>
            <li>Wedding </li>   
            <li>Baptism</li> 
            <li>Funeral</li> 
            </ul>       
          </div>
          <a class="apply" href="services_forms/request.php">Request Now</a>
        </div>
      </div>
    </div>

    <div class="service animate-from-bottom__4">
      <div class="relative-block">
        <div class="service-icon">
          <img src="./image/form.png">
        </div>
        <div class="inactive">
          <div class="title">Application Form</div>
        </div>
        <div class="active">
          <div class="title">Application Form</div>
          <div class="sub-title">
          Available Services:
            <ul>
            <li>Wedding </li>   
            <li>Baptism</li> 
            <li>Funeral</li>  
            <li>Sick Call</li> 
            <li>Blessing</li> 
            </ul>
          </div>
          <a class="apply" href="services_forms/apply.php">Apply Now</a>
        </div>
      </div>
    </div>
  </div>
</div>
  
</body>










<!-- <div id="certificate" class="modal">
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
    <div class="calendar1"> -->
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
    <!-- </div>

    <div class="inner-container">
        <div class="buttons">
            <h2 id="button-title"> FORM </h2>
            <a href="#" class="button buttonC" data-modal-id="certificate">Request for Certificate</a>
            <a href="#" class="button buttonA" data-modal-id="application">Application Form</a>
        </div>
    </div>
</div>
<script src="./js/modal.js"></script> -->
<?php include 'footer.php';?>
</html>