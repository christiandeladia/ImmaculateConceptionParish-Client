<?php
include '../connect.php';
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    extract($_POST);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO `hold_otp` (`first_name`, `last_name`, `birthday`, `gender`, `mobile_number`, `email`, `password`, `date_created`)
            VALUES (:first_name, :last_name, :birthday, :gender, :mobile_number, :email, :password, NOW())";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":first_name", $first_name);
        $stmt->bindValue(":last_name", $last_name);
        $stmt->bindValue(":birthday", $birthday);
        $stmt->bindValue(":gender", $gender);
        $stmt->bindValue(":mobile_number", $mobile_number);
        $stmt->bindValue(":email", $email);
        // Use the hashed password variable here
        $stmt->bindValue(":password", $hashed_password);
        $result = $stmt->execute();

        if ($result) {
            $lastId = $pdo->lastInsertId();
            header("Location: send_otp.php?id=$lastId");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" />
    <title>SIGN UP - ICP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="../image/favicon.ico">
    <link rel="stylesheet" href="../style/login.css">
    <link rel="stylesheet" href="../style/nav.css">
    <link rel="stylesheet" href="../style/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<style>
/* Style the modal */
.modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 80%;
    max-height: 80%;
    /* overflow-y: auto; */
    z-index: 1000;
    flex-direction: column;
}

/* Style the overlay */
.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

/* Style the close button */
.close {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}

/* .accept {
    background: hsl(154, 53%, 38%);
    color: white;
    font-size: 1rem;
    border: none;
    padding: 10px 30px;
    transition: all 0.2s;
}

.accept:hover {
    background: hsl(154, 59%, 21%);
}

.accept[disabled] {
    opacity: 0.2;
} */

.alert-message {
    font-weight: bold;
    font-size: 15px;
    color: #f87171;
    background-color: #fef2f2;
    border: solid 1px #f87171;
    padding: 30px;
    border-radius: 5px;
    position: fixed;
    top: 18%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: none;
    z-index: 999;
    /* Ensure the alert is on top of other elements */
}
</style>

<style>
/* .wrap {
            display: flex;
            justify-content: space-around;
            align-items: center;
            box-sizing: border-box;
            height: 100vh;
            padding: 2rem;
        } */

/* .container {
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
            padding: 1rem;
            background-color: #fff;
            width: 70%;
            height: 100%;
            border-radius: 0.25rem;
            box-shadow: 0rem 1rem 2rem -0.25rem rgba(0, 0, 0, 0.25);
        } */

.container__heading {
    padding: 1rem 0;
    border-bottom: 1px solid #ccc;
    text-align: center;
}

.container__heading>h2 {
    font-size: 1.75rem;
    line-height: 1.75rem;
    margin: 0;
}

.container__content {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    overflow-y: scroll;
}

.container__nav {
    border-top: 1px solid #ccc;
    text-align: right;
    padding: 2rem 0 1rem;
}

.container__nav>input {
    background: hsl(154, 53%, 38%);
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

/* .container__nav>button:hover {
            box-shadow: 0rem 0rem 1rem -0.125rem rgba(0, 0, 0, 0.25);
            transform: translateY(-0.5rem);
        } */

.container__nav>small {
    color: #777;
    margin-right: 1rem;
}

.container__nav>input[disabled] {
    background-color: #ccc;
    color: #888;
    pointer-events: none;
}
</style>

<body>

    <!-- HTML for the alert message -->
    <div id="emailAlert" class="alert-message">
    </div>

    <div class="navtop">
        <div class="navcenter">
            <a href="../index.php">
                <img class="logo" src="../image/logo2.png" alt="Logo" />
            </a>
            <div class="topnav">
                <!-- <a class="activenav" href="../index.php">Home</a> -->
                <div class="topnav-right">
                    <a class="border_signup" href="signup.php">Sign Up</a>
                    <a class="border_login" href="login.php"> Log In </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">

        <div class="form-wapper">
            <div class="form-header">
                <h2>SIGN UP</h2>
                <!-- <p>Welcome! Please fill up the following information.</p> -->
            </div>

            <div class="form-body">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="sample_form">

                    <div class="input-wrapper">
                        <div class="select-wrapper">
                            <label for="first_name">First name</label>
                            <input id="first_name" type="text" name="first_name" placeholder="Enter First name"
                                required>
                        </div>
                        <div class="select-wrapper">
                            <label for="last_name">Last name</label>
                            <input id="last_name" type="text" name="last_name" placeholder="Enter Last name" required>
                        </div>
                    </div>
                    <div class="input-wrapper">
                        <div class="select-wrapper">
                            <label for="birthday">Birthday</label>
                            <input id="birthday" type="date" name="birthday" required>
                        </div>
                        <div class="select-wrapper">
                            <label for="gender">Gender</label>
                            <select class="gender" name="gender" id="gender">
                                <option disabled selected hidden>Select</option>
                                <option class="gender" value="male">male</option>
                                <option class="gender" value="female">female</option>
                            </select>
                        </div>
                    </div>

                    <div class="input-wrapper">
                        <div class="select-wrapper">
                            <label for="mobile_number">Mobile Number</label>
                            <input type="tel" id="mobile_number" name="mobile_number" placeholder="09*********"
                                pattern="[0-9]{11}" required>
                        </div>
                        <div class="select-wrapper">
                            <label for="email">Email</label>
                            <input id="email" type="text" name="email" placeholder="Enter Email" required>
                        </div>
                    </div>

                    <div class="input-wrapper">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="**********" required>
                        <span class="fas fa-eye-slash toggle-password-icon" onclick="togglePassword('password')"></span>
                    </div>
                    <div class="input-wrapper">
                        <label for="confirm_password">Confirm Password</label>
                        <input id="confirm_password" type="password" name="confirm_password" placeholder="**********"
                            required>
                        <span class="fas fa-eye-slash toggle-password-icon"
                            onclick="togglePassword('confirm_password')"></span>
                    </div>
                    <div class="input-wrapper" style="padding-left: 25px;">
                        <div class="g-recaptcha" data-sitekey="6LdHhWkpAAAAANoFPNxXANeCUcRXtKfUrQ-Icdez"></div>
                    </div>
                    <a class="button" href="#" id="btncheck" onclick="openModal()">SIGN UP</a>

                    <!-- The Modal -->
                    <div id="myModal" class="modal">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <div class="container__heading">
                            <h2>Terms & Conditions</h2>
                        </div>
                        <div class="container__content" id="content">
                            <p><strong>1. Acceptance of Terms</strong></p>
                            <p>By accessing or using the Parish Church Database Management System (hereinafter referred
                                to
                                as "the System"), you agree to comply with and be bound by these terms and conditions.
                                If
                                you do not agree with any part of these terms, you may not access the System.</p>

                            <p><strong>2. Use of the System</strong></p>
                            <p>2.1. The System is intended for use by members and authorized individuals associated with
                                the
                                parish church for legitimate purposes related to church administration, communication,
                                and
                                community engagement.</p>
                            <p>2.2. Users are responsible for maintaining the confidentiality of their login credentials
                                and
                                ensuring that unauthorized access is prevented.</p>

                            <p><strong>3. Data Security and Privacy</strong></p>
                            <p>3.1. The church is committed to protecting the privacy and security of user data.
                                Personal
                                information collected through the System will be handled in accordance with applicable
                                privacy laws and the church's privacy policy.</p>
                            <p>3.2. Users are prohibited from attempting to access, modify, or share data belonging to
                                other
                                users without proper authorization.</p>

                            <p><strong>4. Intellectual Property</strong></p>
                            <p>4.1. All content and materials provided through the System, including but not limited to
                                text, graphics, logos, and software, are the property of the parish church or its
                                licensors
                                and are protected by copyright and other intellectual property laws.</p>
                            <p>4.2. Users may not reproduce, distribute, or create derivative works from the content of
                                the
                                System without prior written consent from the parish church.</p>

                            <p><strong>5. Limitation of Liability</strong></p>
                            <p>5.1. The parish church and its representatives shall not be liable for any direct,
                                indirect,
                                incidental, consequential, or special damages arising out of or in any way connected
                                with
                                the use of the System.</p>

                            <p><strong>6. Termination of Access</strong></p>
                            <p>The parish church reserves the right to terminate or suspend access to the System, with
                                or
                                without notice, for any reason, including but not limited to a violation of these terms
                                and
                                conditions.</p>

                            <p><strong>7. Changes to Terms and Conditions</strong></p>
                            <p>The parish church reserves the right to modify these terms and conditions at any time.
                                Users
                                are responsible for regularly reviewing the terms, and continued use of the System after
                                changes constitute acceptance of those changes.</p>

                            <p><strong>8. Governing Law</strong></p>
                            <p>These terms and conditions are governed by and construed in accordance with the laws of
                                [Your
                                Jurisdiction]. Any disputes arising from or in connection with these terms shall be
                                subject
                                to the exclusive jurisdiction of the courts in [Your Jurisdiction].</p>

                            <br>
                            <hr>
                            <p><strong>Immaculate Conception Parish Church</strong><br>Poblacion Pandi Bulacan,
                                Philippines
                                3014<br>immaculateconceptionparish@email.com <br>
                                +639 123 4567</p>

                            <p><strong>Last Update:</strong> December, 2023</p>

                        </div>
                        <div class="container__nav">
                            <small>By clicking 'Accept' you are agreeing to our terms and conditions.</small>
                            <input type="submit" name="submit" value="Accept" class="buttons" id="acceptButton"
                                disabled></input>
                        </div>

                    </div>

                    <!-- The Overlay -->
                    <div id="overlay" class="overlay" onclick="closeModal()"></div>



                    <script>
                    function showAlertMessage(message, duration) {
                        const alertElement = document.getElementById("emailAlert");
                        alertElement.textContent = message; // Set the message text
                        alertElement.style.display = "block"; // Display the alert

                        // Hide the alert after the specified duration (in milliseconds)
                        setTimeout(function() {
                            alertElement.style.display = "none"; // Hide the alert
                        }, duration);
                    }


                    function openModal() {
                        // Check if all required fields are filled
                        const requiredFields = document.querySelectorAll('[required]');
                        let allFilled = true;
                        requiredFields.forEach(field => {
                            if (field.value.trim() === '') {
                                allFilled = false;
                            }
                        });

                        // Check if password and confirm password match
                        const password = document.getElementById('password').value.trim();
                        const confirmPassword = document.getElementById('confirm_password').value.trim();
                        const passwordsMatch = password === confirmPassword;

                        // Check if email is valid
                        const emailInput = document.getElementById('email');
                        const email = emailInput.value.trim();
                        const isEmailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

                        // Check if mobile number is valid
                        const mobileNumberInput = document.getElementById('mobile_number');
                        const mobileNumber = mobileNumberInput.value.trim();
                        const isMobileNumberValid = /^09\d{9}$/.test(mobileNumber);

                        if (!allFilled) {
                            showAlertMessage("Please fill out all required fields before continuing.", 3000);
                        } else if (!isEmailValid) {
                            showAlertMessage("Please enter a valid email address.", 3000);
                        } else if (!isMobileNumberValid) {
                            showAlertMessage("Please enter a valid 11-digit mobile number.", 3000);
                        } else if (!passwordsMatch) {
                            showAlertMessage("Passwords do not match. Please try again.", 3000);
                        } else {
                            // Perform AJAX request to check if email or mobile number exists
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', 'signup_check.php', true);
                            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    const response = xhr.responseText.trim();
                                    if (response === 'exists') {
                                        showAlertMessage(
                                            "Email or Mobile Number already taken. Please choose a different one.",
                                            3000);
                                    } else {
                                        document.getElementById("myModal").style.display = "flex";
                                        document.getElementById("overlay").style.display = "block";
                                    }
                                }
                            };
                            xhr.send('email=' + email + '&mobile_number=' + mobileNumber);
                        }

                    }

                    function closeModal() {
                        document.getElementById("myModal").style.display = "none";
                        document.getElementById("overlay").style.display = "none";
                    }
                    </script>

                    <!-- <input type="submit" class="button" name="submit" value="SIGN UP"> -->
                </form>
            </div>
            <div class="form-footer">
                <p>Have an account already? Click <a class="form-link" href="login.php"><b>Login</b></a></p>
            </div>
        </div>
        <div class="image-wapper" style="background-image: url(../image/signup.png)">
            <h1>Welcome!</h1>
        </div>
    </div>
</body>
<?php include '../footer.php';?>
<script>
const passwordField = document.getElementById("password");
// const togglePasswordIcon = document.getElementById("togglePassword");

function togglePassword(inputId) {
    const passwordField = document.getElementById(inputId);
    const togglePasswordIcon = document.querySelector(`#${inputId} + .toggle-password-icon`);

    if (passwordField.type === "password") {
        passwordField.type = "text";
        togglePasswordIcon.classList.remove("fa-eye-slash");
        togglePasswordIcon.classList.add("fa-eye");
    } else {
        passwordField.type = "password";
        togglePasswordIcon.classList.remove("fa-eye");
        togglePasswordIcon.classList.add("fa-eye-slash");
    }
}
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var content = document.getElementById("content");
    var acceptButton = document.getElementById("acceptButton");

    content.addEventListener("scroll", function() {
        // Add an offset to account for any discrepancies in calculating the scroll height
        if (content.scrollHeight - content.scrollTop <= content.clientHeight + 1) {
            acceptButton.disabled = false;
        } else {
            acceptButton.disabled = true;
        }
    });
});
</script>

</html>