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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <title>MY PROFILE - ICP</title>
</head>
<style>
body {
    background: lightgrey
}

.sttngs p {
    color: #000;
}

.sttngs {
    max-width: 55%;
    margin: 50px auto;
    background: #fff;
    padding: 15px;
    height: 500px;
    /* font-family: "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif; */
    border-radius: 3px;
    padding-top: 30px;
    -webkit-box-shadow: 0 0 50px 0 rgba(0, 0, 0, 0.2);
}

.sttngs h2 {
    letter-spacing: 2px;
    margin: 20px;
    color: #000;
}


.sttngs .tabordion {
    color: #FFF;
    display: block;
    mardgin: auto;
    position: relative;
    height: 670px;
    width: 100%;
    backgrdound: red;
}

.sttngs.tabordion input[name="sections"] {
    display: none;
}

.sttngs.tabordion section {
    display: block;
}

.tabordion section label {
    border-right: 1px solid lightgrey;
    display: block;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    padding: 14px 20px;
    color: #999;
    letter-spacing: 1px;
    position: relative;
    width: 130px;
    z-index: 100;
}


.trr {
    cursor: pointer;
}


.ver {
    color: limegreen;
}

.tabordion section article {
    display: none;
    padding-left: 200px;
    max-width: 100%;
    position: absolute;
    top: -50px;
}


/*
.tabordion section article:after {
  
  bottom: 0;
  content: "";
  display: block;
  left:-229px;
  position: relative;
  top: 0;
  width: 220px;
  z-index:1;
}
*/
.tabordion input[name="sections"]:checked+label {
    border-right: 3px solid limegreen;
    color: limegreen;
    font-weight: bold;
}

.tabordion input[name="sections"]:checked~article {
    display: block;
}

.social {
    display: inline-block;
    width: 32.7%;
}

.r1,
.r2 {
    /* margin-left: 4%; */
}


:root {
    background-color: #FCFEFD;
    /* font-family: helvetica, arial, sans-serif; */
    font-size: 15px;
}

input {
    color: red;
    display: block;
    box-sizing: border-box;
    width: 100%;
    outline: none;
    border: none;
    border-radius: 2px;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.frm .label {
    display: block;
    width: 100%;
    margin-bottom: 0.25em;
    font-size: 10px;
    text-align: left;
    font-weight: 900;
    padding: 0;
    color: #111;
    letter-spacing: 1px;
    border: none;
}

.input {
    padding: 10px;
    border: 1px solid lightgray;
    /* background-color: #f5f5f5; */
    color: #aaa;
    letter-spacing: .7px;
}

.input:focus {
    border-color: gray;
}


/* .textarea {
    min-height: 100px;
    resize: vertical;
} */



/* .tr {
    padding-top: 50px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;

    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    max-width: 600px;
} */

.tr {
    width: 700px;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    /* Adjust the gap between columns as needed */
}

.tr .column {
    padding: 10px;
}

.tr .label {

    margin-bottom: 0.25em;
    width: 100%;
    font-size: 14px;
    text-align: left;
    font-weight: 900;
    padding: 0;
    color: #111;
    letter-spacing: 2px;
    border: none;
}


.p {
    padding: 30px;
}


.input,
.checkbox-label:before,
.radio-label:before,
.checkbox-label:after,
.radio-label:after,
.checkbox-label,
.radio-label {
    margin-bottom: 2em;
}

.r {
    height: 250px;
    width: 250px;
    background: red;
    border-radius: 50%;
    float: left;
    margin-right: 30px;
}


.icon {
    width: 75px;
    height: 75px;
    margin: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

}


.camera4 {
    display: block;
    width: 70%;
    height: 50%;
    position: absolute;
    top: 30%;
    left: 15%;
    background-color: #000;
    border-radius: 5px;
}

.camera4:after {
    content: "";
    display: block;
    width: 15px;
    height: 15px;
    border: 7px solid #fff;
    position: absolute;
    top: 15%;
    left: 25%;
    background-color: #000;
    border-radius: 15px;
}

.camera4:before {
    content: "";
    display: block;
    width: 50%;
    height: 10px;
    position: absolute;
    top: -16%;
    left: 25%;
    background-color: #000;
    border-radius: 10px;
}



/* #profile-upload {
    background-image: url('');
    background-size: cover;
    background-position: center;
    height: 230px;
    width: 230px;
    border: 1px solid #bbb;
    position: relative;
    top: 20px;
    border-radius: 50%;
    overflow: hidden;
    float: left;
    margin-right: 30px;
    margin-bottom: 0px;

}

#profile-upload:hover input.upload {
    display: block;
}

#profile-upload:hover {
    border: 1px solid gray
}

#profile-upload:hover .hvr-profile-img {
    opacity: 1;
}

.hvr-profile-img {
    opacity: .3;
}

#profile-upload input.upload {
    z-index: 1;
    left: 0;
    margin: 0;
    bottom: 0;
    top: 0;
    padding: 0;
    opacity: 0;
    outline: none;
    cursor: pointer;
    position: absolute;

    width: 100%;
    display: none;
} */

#count {
    font-size: 12px;
    display: inline-block;
    text-align: center;
    color: grey;
    text-transform: none;
    font-weight: 600;
    letter-spacing: 0;
}


.e {
    max-width: 880px;
}


/* .select {
    position: relative;
    z-index: 1;
    padding-right: 40px;
}

.select::-ms-expand {
    display: none;
}

.select-wrap {
    position: relative;
}

.select-wrap:after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 2;
    padding: 0 15px;
    width: 10px;
    height: 100%;
    background-image: url("data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20version%3D%221.1%22%20x%3D%220%22%20y%3D%220%22%20width%3D%2213%22%20height%3D%2211.3%22%20viewBox%3D%220%200%2013%2011.3%22%20enable-background%3D%22new%200%200%2013%2011.3%22%20xml%3Aspace%3D%22preserve%22%3E%3Cpolygon%20fill%3D%22%23424242%22%20points%3D%226.5%2011.3%203.3%205.6%200%200%206.5%200%2013%200%209.8%205.6%20%22%2F%3E%3C%2Fsvg%3E");
    background-position: center;
    background-size: 10px;
    background-repeat: no-repeat;
    content: "";
    pointer-events: none;
} */

.frm {
    padding: 3%;
}


.tr span {
    display: inline-block;
    color: grey;
    font-size: 11px;
    letter-spacing: 0;
    font-weight: 700;
    text-transform: none;
}

#texte {
    display: inline-block;
    color: grey;
    text-transfgorm: none;
    letter-spacing: 0;
}

.sttngs button {
    text-transform: uppercase;
    font-weight: 800;
    letter-spacing: 1px;
    outline: 0;
    background: limegreen;
    width: 200px;
    border: 0;
    padding: 15px;
    color: #FFFFFF;
    font-size: 14px;
    -webkit-transition: all 0.3 ease;
    transition: all 0.3 ease;
    cursor: pointer;
    border-radius: 3px;
    margin-top: 30px;
    position: relative;
    left: 50%;
    transform: translate(-50%, 0px);
}


.sttngs button:hover,
.sttngs button:active,
.sttngs button:focus {
    background: #43A047;
}



@media (max-width: 600px) {
    /* #profile-upload {
        float: none;
        margin: auto;


    } */

    .sttngs .tabordion {
        height: 1020px;
    }


    .sttngs button {
        margin-top: -40px;
    }


    .sttngs {
        padding: 0;
        padding-top: 19px;
    }

    .sttngs h2 {
        text-align: center;
    }

    .tabordion section article {
        border-top: 1px solid #eee;
    }


}



@media (min-width: 768px) {
    .tabordion {
        height: 600px;
    }
}



@media (max-width: 768px) {


    button {
        margin-top: -40px;
    }

    .tabordion section label {
        float: left;
        display: inline-block;
        width: 17%;
        margin: auto;
        padding: 12px;
        font-size: 9px;
        border-right: none;
        text-align: center;

    }

    .wwq {
        padding: 10px;
    }

    .b {
        height: 170px;
        width: 170px;
    }

    .tabordion input[name="sections"]:checked+label {
        border-bottom: 3px solid limegreen;
        border-right: none;
    }

    .tabordion section article {
        left: 0;
        top: 38px;
        border-top: 1px solid #eee;
        padding: 0;
    }
}
</style>

<?php include 'nav.php';?>

<body>

    <div class="sttngs">
        <h2>MY PROFILE</h2>
        <div class="tabordion">

            <section id="section1">
                <input class="t" type="radio" name="sections" id="option1" checked>
                <label for="option1" class="trr"> Account</label>

                <article>
                    <div class="frm">

                        <div class="tr">
                            <div class="column">
                                <label class="label" for="input">First Name</label>
                                <input class="input" type="text" id="input" disabled
                                    value="<?php echo $auth['first_name']; ?>">

                                <?php
                                $mobile_number = $auth['mobile_number'];
                                $masked_mobile_number = substr($mobile_number, 0, 2) . str_repeat('*', strlen($mobile_number) - 5) . substr($mobile_number, -3);
                                ?>
                                <label class="label" for="input">Mobile Number</label>
                                <input class="input" type="text" id="input" disabled
                                    value="<?php echo $masked_mobile_number; ?>">


                                <label class="label" for="input">Birthday</label>
                                <input class="input" type="text" id="input" disabled
                                    value="<?php echo $auth['birthday']; ?>">

                                <label class="label" for="input">Date Created</label>
                                <input class="input" type="text" id="input" disabled
                                    value="<?php echo $auth['date_created']; ?>">
                            </div>

                            <div class="column">
                                <label class="label" for="input">Last Name</label>
                                <input class="input" type="text" id="input" disabled
                                    value="<?php echo $auth['last_name']; ?>">

                                <?php
                                $email = $auth['email'];
                                $visible_chars = substr($email, 0, 2); // Get the first 2 characters of the email
                                $masked_email = $visible_chars . str_repeat('*', strlen($email) - 5) . "@gmail.com"; // Replace remaining characters with asterisks and append the domain
                                ?>
                                <label class="label" for="input">Email</label>
                                <input class="input" type="text" id="input" disabled
                                    value="<?php echo $masked_email; ?>">

                                <label class="label" for="input">Gender</label>
                                <input class="input" type="text" id="input" disabled
                                    value="<?php echo $auth['gender']; ?>">


                            </div>
                        </div>
                        <br>

                    </div>
                </article>

            </section>

            <!-- <section id="section2">
                <input class="t" type="radio" name="sections" id="option2">
                <label for="option2" class="trr">Change Email</label>
                <article>
                    <div class="frm">
                        <div class="tr">
                            <div class="column">
                                <label class="label" for="input">current Email</label>
                                <input class="input e" type="password" id="input">

                                <label class="label" for="input">new Email</label>
                                <input class="input e" type="password" id="input">
                            </div>
                            <div class="column">
                                <label class="label" for="input">current Password</label>
                                <input class="input e" type="password" id="input">

                                <label class="label" for="input">confirm new Email</label>
                                <input class="input e" type="password" id="input">
                            </div>
                        </div>
                        <button>Change Email</button>
                    </div>
                </article>
            </section>

            <section id="section3">
                <input class="t" type="radio" name="sections" id="option3">
                <label for="option3" class="trr">Change Password</label>
                <article>
                    <div class="frm">
                        <div class="tr">
                            <div class="column">
                                <label class="label" for="input">current Email</label>
                                <input class="input e" type="password" id="input">

                                <label class="label" for="input">new Password</label>
                                <input class="input e" type="password" id="input">
                            </div>
                            <div class="column">
                                <label class="label" for="input">current Password</label>
                                <input class="input e" type="password" id="input">

                                <label class="label" for="input">confirm new Password</label>
                                <input class="input e" type="password" id="input">
                            </div>
                        </div>
                        <button>Change Password</button>
                    </div>
                </article>
            </section>

            <section id="section4">
                <input class="t" type="radio" name="sections" id="option4">
                <label for="option4" class="trr">My Purchase</label>
                <article>
                    <p>WORKING IN PROGRESS........ </p>
                </article>
            </section> -->
        </div>


    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</body>
<script>
// $("document").ready(function() {
//     var textmax = 500;
//     $("#count").text(textmax + ' character left');
//     $("#bio").keyup(function() {
//         var userlenght = $("#bio").val().length;
//         var remain = textmax - userlenght;
//         $("#count").text(remain + ' characters left');
//     });

// });

// document.getElementById('getval').addEventListener('change', readURL, true);

// function readURL() {
//     var file = document.getElementById("getval").files[0];
//     var reader = new FileReader();
//     reader.onloadend = function() {
//         document.getElementById('profile-upload').style.backgroundImage = "url(" + reader.result + ")";
//     }
//     if (file) {
//         reader.readAsDataURL(file);
//     } else {}
// }


$(function() {
    var $text = $('#texte');
    var $input = $('.texte');
    $input.on('keydown', function() {
        setTimeout(function() {
            $text.html($input.val());
        }, 0);
    });
})
</script>
<?php include 'footer.php';?>

</html>