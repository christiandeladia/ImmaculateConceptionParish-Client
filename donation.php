<?php 
	require_once "connect.php";
	$is_customer_logged_in = isset($_SESSION['auth_login']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <title>SUPPORT & DONATE - ICP</title>
</head>

<?php include 'nav.php';?>

<style>
.wrap {
    display: flex;
    justify-content: space-around;
    align-items: center;
    box-sizing: border-box;
    /* height: 100vh; */
    padding: 2rem;
    /* background-color: #eee; */
}

.container {
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
    padding: 1rem;
    background-color: #fff;
    width: 70%;
    height: 100%;
    border-radius: 0.25rem;
    box-shadow: 0rem 1rem 2rem -0.25rem rgba(0, 0, 0, 0.25);
}

.container__heading {
    padding: 1rem 0;
    border-bottom: 1px solid #ccc;
    text-align: center;
}

.container__heading>h1 {
    font-size: 2rem;
    line-height: 1.75rem;
    margin: 0;
}
.container__content {
    margin: auto 20px;
}
.container__content p {
    line-height: 30px;
    font-weight: 500;
}
.container__content li {
    line-height: 25px;
    font-weight: 500;
}
.container__content a {
    text-decoration: underline !important;
    cursor: pointer;
    color: blue;
}
  

.container__nav {
    border-top: 1px solid #ccc;
    text-align: right;
    padding: 2rem 0 1rem;
}

.container__nav>button {
    background-color: #444499;
    box-shadow: 0rem 0.5rem 1rem -0.125rem rgba(0, 0, 0, 0.25);
    padding: 0.8rem 2rem;
    border-radius: 0.5rem;
    color: #fff;
    text-decoration: none;
    font-size: 0.9rem;
    transition: transform 0.25s, box-shadow 0.25s;
    border: none;
    cursor: pointer;
}

.container__nav>button:hover {
    box-shadow: 0rem 0rem 1rem -0.125rem rgba(0, 0, 0, 0.25);
    transform: translateY(-0.5rem);
}

.container__nav>small {
    color: #777;
    margin-right: 1rem;
}

.container__nav>button[disabled] {
    background-color: #ccc;
    color: #888;
    pointer-events: none;
}


/* MODAL */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 50px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0,0.9);
}

.modal-content {
  margin: auto;
  display: block;
  max-width: 80%;
  max-height: 80%;
}

.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}
.close2 {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close2:hover,
.close2:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}
</style>


<body>
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
</div>
<div id="myModal2" class="modal">
  <span class="close2">&times;</span>
  <img class="modal-content" id="img02">
</div>
    <main class="wrap">

        <section class="container">
            <div class="container__heading">
                <h1>Support & Donate</h1>
            </div>
            <div class="container__content" id="content">
                <p>&emsp;&emsp;&emsp;The Immaculate Conception Parish of Pandi Bulacan warmly welcomes volunteers, parishioners and
                    visitors to explore ways to support its
                    mission and actively engage through volunteerism. This page contains information about various
                    donation options, including GCash, PayPal, and Bank Transfer, as well as how to become a valued
                    volunteer in the parish community.</p>
                    <br>
                <h2><i class='fas fa-hand-holding-heart'></i> DONATION OPTIONS:</h2>
                <p><strong>GCASH</strong></p>
                <p>Visitors can easily make contributions through GCash, a trusted mobile payment platform widely used in the Philippines. To donate using GCash, kindly follow these steps:</p>
                <ul>
                    <li>Open the GCash app.</li>
                    <li>Choose "Send Money."</li>
                    <li>Enter the GCash number: 0939-600-4981 (CHRISTIAN D.).</li>
                    <li>Specify the donation amount.</li>
                    <li>Confirm the donation.</li>
                    <li>You can also <a id="modalBtn">Click here</a> to display the QR Code.</li>
                </ul>

                <p><strong>PAYPAL</strong></p>
                <p>Donations can be made securely via PayPal, a reputable online payment service. To donate through PayPal, please follow these steps:</p>
                <ul>
                    <li>Click this link - <a href="https://paypal.me/deladiachristian" target="_blank">https://paypal.me/deladiachristian</a></li>
                    <li>Log in to your PayPal account.</li>
                    <li>Select the desired donation amount.</li>
                    <li>Review and confirm your donation.</li>
                    <li>You can also click here to display the QR Code.</li>
                </ul>

                <p><strong>BANK TRANSFER</strong></p>
                <p>For those who prefer bank transfers, we offer the following account details:</p>
                <ul>
                    <li>Bank Name: BDO</li>
                    <li>Account Name: ICP</li>
                    <li>Account Number: 1321313132325</li>
                    <li>You can also <a id="modalBtn2">Click here</a> to display the QR Code.</li>
                </ul>
<br>
                <h2><i class="fas fa-hands-helping"></i> BECOMING A VOLUNTEER:</h2>
                <p>We encourage individuals to actively participate in our parish's activities and serve the community
                    by volunteering their time and talents. Here's how to get involved:</p>

                <p><strong>1. EXPLORE VOLUNTEER OPPORTUNITIES</strong></p>
                <ul>
                    <li>Visit the parish office for list of available volunteer opportunities in the parish.</li>
                    <li>Consider interests, skills, and availability when choosing a volunteer opportunity.</li>
                </ul>

                <p><strong>2. CONTACT THE ORGANIZATION</strong></p>
                <ul>
                    <li>Express your interest in volunteering by reaching out to a particular organization's officers and existing volunteers.</li>
                    <li>Discuss the volunteer role interested in, and they will provide additional information and next steps.</li>
                </ul>

                <p><strong>3. ATTEND VOLUNTEER ORIENTATION (IF APPLICABLE)</strong></p>
                <ul>
                    <li>Depending on the role, you may be invited to attend a volunteer orientation session to gain insights into our parish and your specific responsibilities.</li>
                </ul>
                <p><strong>4. BEGIN VOLUNTEER JOURNEY</strong></p>
                <ul>
                    <li>Start making a meaningful impact on our parish and community by actively participating in chosen volunteer role.</li>
                </ul>
                <br>

                <h2>A BIG THANK YOU</h2>
                <p>The parish extends heartfelt gratitude to all who choose to support us through donations or volunteer
                    service. Those contributions, whether in time or resources, are instrumental in the growth of our
                    parish and the fulfillment of our mission. For inquiries or assistance with donations or volunteer
                    opportunities, please do not hesitate to contact us.</p>
                <hr>
                <p><strong>Immaculate Conception Parish Church</strong><br>Poblacion Pandi Bulacan, Philippines
                    3014<br>immaculateconceptionparish@email.com <br>
                    +639 123 4567</p>

                <p><strong>Last Update:</strong> April, 2024</p>

            </div>
        </section>
    </main>


</body>

<?php include 'footer.php';?>
<script>
    var modal = document.getElementById('myModal');
var modalImg = document.getElementById("img01");
var btn = document.getElementById("modalBtn");
var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
  modal.style.display = "block";
  modalImg.src = "image/gcash.jpg"; // Replace "your_image_url.jpg" with the actual URL of your image
}

span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

</script>
<script>
    var modal2 = document.getElementById('myModal2');
    var modalImg2 = document.getElementById("img02");
    var btn2 = document.getElementById("modalBtn2");
    var span2 = document.getElementsByClassName("close2")[0];

    btn2.onclick = function() {
        modal2.style.display = "block";
        modalImg2.src = "image/bdo.jfif"; // Replace "your_image.jpg" with the actual URL of your image
    }

    span2.onclick = function() {
        modal2.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal2) {
            modal2.style.display = "none";
        }
    }
</script>
</html>