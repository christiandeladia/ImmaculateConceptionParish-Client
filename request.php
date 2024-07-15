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
    <title>REQUEST FOR CERTIFICATES - ICP </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="image/favicon.ico">
    <link rel="stylesheet" href="styles/services.css">
    <link rel="stylesheet" href="style/nav.css">
    <link rel="stylesheet" href="styles/footer.css">
    <!-- FONT -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- MODAL -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<?php include 'nav.php';?>
<section id="about" class="section-b"></section>
<div class="card">
    <div class="card-wrap">
        <img class="card-header" src="services_forms/image/baptismal.jpg">
        <div class="card-content">
            <h1 class="card-title">BAPTISMAL</h1>
            <p class="card-text">Apply for baptism in church: Complete a form, submit details, and embrace a spiritual
                journey through this sacred initiation.</p>
            <?php if ($is_customer_logged_in) { ?>
            <button class="card-btn" data-toggle="modal" data-target="#baptismalrequest">Apply Now</button>
            <?php } else { ?>
            <a href="customer/login.php"><button class="card-btn">Apply Now</button></a>
            <?php } ?>
        </div>
    </div>


    <div class="services">


        <!-- Baptismal Modal -->
        <div class="modal fade" id="baptismalrequest" tabindex="-1" aria-labelledby="exampleModalLabel"
            style="padding-left: 20px;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">BAPTISMAL CERTIFICATE FORM</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <div class="form-section" id="section1">
                            <div class="bg-light p-3">
                                <p>Baptism holds a significant role within the Christian faith as it formally welcomes a
                                    new member into the church. It serves as the cornerstone of the entire Christian
                                    journey, acting as the entryway to a life guided by the Holy Spirit and granting
                                    access to other sacred sacraments. Through this sacred ritual, individuals are
                                    cleansed of their sins and spiritually reborn as children of God. They become an
                                    integral part of the body of Christ, joining the church and participating in its
                                    mission.
                                    <br>
                                    <br>
                                    Beyond its religious significance, baptism has evolved into a cultural tradition
                                    characterized by family gatherings and the strengthening of societal bonds. As a
                                    religious institution, the parish is dedicated to ensuring the solemnity of this
                                    celebration for the newly initiated member.
                                </p>
                                <br>
                                <br>
                                <h3>REMINDERS</h3>
                                <ul>
                                    <li>The child should have received baptism in our church.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <a href="request_cert.php"><button type="submit" class="btn btn-success">Get
                                    Started</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>

</html>
<script>
function calculateMonths() {
    var birthdate = document.getElementById('birthdate').value;
    if (birthdate) {
        var currentDate = new Date();
        var birthDate = new Date(birthdate);

        var ageInMonths = (currentDate.getFullYear() - birthDate.getFullYear()) * 12 +
            (currentDate.getMonth() - birthDate.getMonth());
        document.getElementById('months').value = ageInMonths;
    }
}
var today = new Date();
var yyyy = today.getFullYear();
var mm = String(today.getMonth() + 1).padStart(2, '0');
var dd = String(today.getDate()).padStart(2, '0');

var maxDate = yyyy + '-' + mm + '-' + dd;
document.getElementById('birthdate').max = maxDate;

function validateAge(inputId) {
    var ageInput = document.getElementById(inputId);
    var enteredAge = parseInt(ageInput.value, 10);

    if (enteredAge < 16) {
        alert("Age must be 16 or above.");
        ageInput.value = "";
    }
}
document.getElementById('marriage').addEventListener('change', function() {
    var marriageValue = this.value;
    var marriageLocationInput = document.getElementById('marriageLocation');
    marriageLocationInput.disabled = (marriageValue === 'hindi');
    // Clear the input value when disabled
    if (marriageLocationInput.disabled) {
        marriageLocationInput.value = '';
    }
});

function handlePlace() {
    var placeSelect = document.getElementById("place");
    var otherPlaceContainer = document.getElementById("otherPlaceContainer");
    var otherPlaceInput = document.getElementById("otherPlace");

    if (placeSelect.value === "Other") {
        otherPlaceContainer.style.display = "block";
        otherPlaceInput.required = true;
    } else {
        otherPlaceContainer.style.display = "none";
        otherPlaceInput.required = false;
    }
}


$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})


function handleCivilStatus() {
    var civilStatus = document.getElementById("civil_status").value;
    var spouseNameInput = document.getElementById("spouse_name");
    var numberOfChildInput = document.getElementById("number_of_child");

    if (civilStatus === "Single") {
        spouseNameInput.value = "";
        numberOfChildInput.value = "";
        spouseNameInput.disabled = true;
        numberOfChildInput.disabled = true;
    } else {
        spouseNameInput.disabled = false;
        numberOfChildInput.disabled = false;
    }
}
</script>
<style>
.modal-dialog {
    max-width: 70%;
    /* max-height: 200px; */
    margin: 1.75rem auto;
    font-family: "Montserrat";
}

.modal-content {
    /* min-height: 100%; */
    margin: 0 auto;
    font-size: 20px;
}

.modal-body {
    width: 100%;
    margin: 0 auto;
}

.modal-title {
    /* text-align: center; */
    /* margin-left: 20%; */
    font-weight: 1000;
    color: green;
}

.modal-body h3 {
    /* text-align: center; */
    /* margin-left: 20%; */
    font-weight: 1000;
    color: green;
}
button.btn.btn-success {
    font-size: 20px;
    background-color: green;
    padding: 10px;
}
.fa-question-circle {
    color: #888888;
}

.services {
    width: 90%;
    display: flex;
    flex-direction: column;
    margin-left: auto;
    margin-right: auto;
}

.form-control {
    height: calc(2em + 1rem + 3px);
}


.fa-question-circle {
    color: #888888;
}

.services {
    width: 90%;
    display: flex;
    flex-direction: column;
    margin-left: auto;
    margin-right: auto;

}

:root {
    --color-text: #616161;
    --color-text-btn: #ffffff;
    --color1: #11998e;
    --color2: #38ef7d;
}

.card {
    margin: 0;
    height: 380px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    flex-direction: row;
    /* gap: 40px; */
    background: transparent;
    border: 0px solid rgba(0, 0, 0, .125) !important;


}

.close {
    float: right;
    font-size: 3rem;
    font-weight: 700;
    line-height: 1;
    color: #ff0000;
    text-shadow: 0 1px 0 #fff;
    opacity: .5;
}

@media only screen and (max-device-width: 480px) {
    .section-b {
        max-width: 90%;
    }

    .card {
        flex-direction: column;
        /* Change flex direction to column for smaller screens */
        column-gap: 20px;
        height: auto;
        /* Adjust height as needed for smaller screens */
        display: grid;
        grid-template-columns: 40% 1fr;
        padding-left: 100px;
        justify-items: center;


        .card-wrap {
            width: 350px;
        }

        .card-wrap:hover {
            transform: scale(1);
        }
    }
}

.card-wrap {
    width: 20%;
    height: 440px;
    background: #fff;
    border-radius: 20px;
    border: 5px solid #fff;
    overflow: hidden;
    color: var(--color-text);
    box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
    cursor: pointer;
    justify-content: center;
    transition: all 0.2s ease-in-out;

}

.card-wrap:hover {
    transform: scale(1.1);
}

.card-header {
    padding: 0 !important;
    height: 200px;
    width: 100%;
    background: white;
    border-radius: 100% 0% 100% 0% / 0% 50% 50% 100% !important;
    /* display: grid; */
    place-items: center;
}

.card-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 80%;
    margin: 0 auto;
}

.card-title {
    text-align: center;
    text-transform: uppercase;
    font-size: 18px;
    font-weight: bold;
    margin-top: 10px;
    margin-bottom: 20px;
}

.card-text {
    height: 80px;
    text-align: left;
    font-size: 14px;
    margin-bottom: 20px;
}

.card-btn {
    position: block;
    border: none;
    width: 200px;
    border-radius: 100px;
    padding: 10px 20px;
    color: #fff;
    margin-bottom: 10px;
    text-transform: uppercase;
    background: linear-gradient(to left,
            var(--color1),
            var(--color2));
}

.card-header {
    background: linear-gradient(to bottom left,
            var(--color1),
            var(--color2));
}

.section-b {
    width: 95%;
    position: relative;
    margin: 20px 40px 90px 40px;
    background: url(services_forms/image/banner2.jpg) no-repeat bottom center/cover;
    height: 250px;
    border-radius: 10px 10px 10px 10px;
    /* box-shadow: 20px 10px 20px 5px #eee; */
    padding-top: 100px;
}
</style>