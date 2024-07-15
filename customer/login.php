<?php
require "../connect.php";

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {

    extract($_POST);

    $stmt = $pdo->prepare("SELECT * FROM `login` WHERE `mobile_number` = ? OR `email` = ?");
    $stmt->execute([$username, $username]); // Try both mobile number and email as the username
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && password_verify($password, $result['password'])) {
        $_SESSION['auth_login'] = $result;
    } else {
        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Invalid username or password')
        window.location.href='../customer/login.php';
        </SCRIPT>");
    }
}

if (isset($_SESSION['auth_login'])) {
    header("location: ../index.php");
    exit;
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" />
    <title>LOGIN - ICP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="../image/favicon.ico">
    <link rel="stylesheet" href="../style/login.css">
    <link rel="stylesheet" href="../style/nav.css">
    <link rel="stylesheet" href="../style/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
        overflow-y: auto;
        z-index: 1000;
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

    .accept {
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
    }
</style>

<body>

    <div class="navtop">
        <div class="navcenter">
            <a href="../index.php">
                <img class="logo" src="../image/logo2.png" alt="Logo" />
            </a>
            <div class="topnav">
                <div class="topnav-right">
                    <a class="border_signup" href="signup.php">Sign Up</a>
                    <a class="border_login" href="login.php"> Log In </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="image-wapper" style="background-image: url(../image/login.png)">
            <h1>Welcome Back!</h1>
        </div>
        <div class="form-wapper">
            <div class="form-header">
                <h2>LOGIN</h2>
                <p>Welcome back! Please login to your account.</p>
            </div>
            <div class="form-body">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="sample_form">
                    <?php if (isset($_SESSION['alert'])) { ?>
                        <!-- <div class="alert alert-success">Registered, please login</div> -->
                    <?php unset($_SESSION['alert']);
                    } else if (isset($_SESSION['error'])) { ?>
                        <div class="alert alert-danger"><?php echo $_SESSION['error']; ?></div>
                    <?php unset($_SESSION['error']);
                    } ?>

                    <div class="input-wrapper">
                        <label for="username">Email or Mobile number</label>
                        <input id="username" type="text" name="username" placeholder="email@example.com or 09********12" required>
                    </div>


                    <div class="input-wrapper">
                        <label for="password">Password</label>

                        <input id="password" type="password" name="password" placeholder="**********" required>
                        <span class="fas fa-eye-slash toggle-password-icon" id="togglePassword"></span>
                    </div>
                    <div class="input-wrapper" style="padding-left: 25px; width: 100px; height: auto;">
                        <div class="g-recaptcha" data-sitekey="6LdHhWkpAAAAANoFPNxXANeCUcRXtKfUrQ-Icdez"></div>
                    </div>
                    <!-- <div class="tacbox">
                        <input id="check" type="checkbox" checked />
                        <label for="check"> I agree to these <a href="#" onclick="openModal()">Terms and
                                Conditions</a>.</label>
                    </div> -->

                    <!-- The Modal -->
                    <div id="myModal" class="modal">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <h1>Terms and Conditions:</h1>
                        <p><strong>1. Acceptance of Terms</strong></p>
                        <p>By accessing or using the Parish Church Database Management System (hereinafter referred to
                            as "the System"), you agree to comply with and be bound by these terms and conditions. If
                            you do not agree with any part of these terms, you may not access the System.</p>

                        <p><strong>2. Use of the System</strong></p>
                        <p>2.1. The System is intended for use by members and authorized individuals associated with the
                            parish church for legitimate purposes related to church administration, communication, and
                            community engagement.</p>
                        <p>2.2. Users are responsible for maintaining the confidentiality of their login credentials and
                            ensuring that unauthorized access is prevented.</p>

                        <p><strong>3. Data Security and Privacy</strong></p>
                        <p>3.1. The church is committed to protecting the privacy and security of user data. Personal
                            information collected through the System will be handled in accordance with applicable
                            privacy laws and the church's privacy policy.</p>
                        <p>3.2. Users are prohibited from attempting to access, modify, or share data belonging to other
                            users without proper authorization.</p>

                        <p><strong>4. Intellectual Property</strong></p>
                        <p>4.1. All content and materials provided through the System, including but not limited to
                            text, graphics, logos, and software, are the property of the parish church or its licensors
                            and are protected by copyright and other intellectual property laws.</p>
                        <p>4.2. Users may not reproduce, distribute, or create derivative works from the content of the
                            System without prior written consent from the parish church.</p>

                        <p><strong>5. Limitation of Liability</strong></p>
                        <p>5.1. The parish church and its representatives shall not be liable for any direct, indirect,
                            incidental, consequential, or special damages arising out of or in any way connected with
                            the use of the System.</p>

                        <p><strong>6. Termination of Access</strong></p>
                        <p>The parish church reserves the right to terminate or suspend access to the System, with or
                            without notice, for any reason, including but not limited to a violation of these terms and
                            conditions.</p>

                        <p><strong>7. Changes to Terms and Conditions</strong></p>
                        <p>The parish church reserves the right to modify these terms and conditions at any time. Users
                            are responsible for regularly reviewing the terms, and continued use of the System after
                            changes constitute acceptance of those changes.</p>

                        <p><strong>8. Governing Law</strong></p>
                        <p>These terms and conditions are governed by and construed in accordance with the laws of [Your
                            Jurisdiction]. Any disputes arising from or in connection with these terms shall be subject
                            to the exclusive jurisdiction of the courts in [Your Jurisdiction].</p>

                        <br>
                        <p><strong>Immaculate Conception Parish Church</strong><br>Poblacion Pandi Bulacan, Philippines
                            3014<br>immaculateconceptionparish@email.com <br>
                            +639 123 4567</p>

                        <p><strong>Last Updated:</strong> December, 2023</p>
                        <hr>
                        <input type="submit" class="accept" disabled name="submit" value="SIGN UP">
                    </div>

                    <!-- The Overlay -->
                    <div id="overlay" class="overlay" onclick="closeModal()"></div>

                    <script>
                        function openModal() {
                            document.getElementById("myModal").style.display = "block";
                            document.getElementById("overlay").style.display = "block";
                        }

                        function closeModal() {
                            document.getElementById("myModal").style.display = "none";
                            document.getElementById("overlay").style.display = "none";
                        }
                    </script>
                    <input type="submit" class="button" name="submit" id="btncheck" value="LOGIN">
                </form>
            </div>
            <div class="form-footer">
                <p>Don't have an account yet? Click <a class="form-link" href="signup.php"><b>Sign Up</b></a></p>
            </div>
        </div>
    </div>
</body>
<?php include '../footer.php'; ?>
<script src="../js/checkbox.js"></script>
</script>

<script>
    const passwordField = document.getElementById("password");
    const togglePasswordIcon = document.getElementById("togglePassword");

    togglePasswordIcon.addEventListener("click", function() {
        if (passwordField.type === "password") {
            passwordField.type = "text";
            togglePasswordIcon.classList.remove("fa-eye-slash");
            togglePasswordIcon.classList.add("fa-eye");
        } else {
            passwordField.type = "password";
            togglePasswordIcon.classList.remove("fa-eye");
            togglePasswordIcon.classList.add("fa-eye-slash");
        }
    });
</script>

<script>
    $(document).on('click', '#btncheck', function(event) {
        var response = grecaptcha.getResponse();
        if (response.length == 0) {
            alert("Please Verify you are not a robot");
            event.preventDefault(); // Prevent form submission
            return false;
        }
    });
</script>


</html>