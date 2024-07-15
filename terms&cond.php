<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <title>TERMS AND CONDITION - ICP</title>
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

    .container__heading>h2 {
        font-size: 1.75rem;
        line-height: 1.75rem;
        margin: 0;
    }

    /* .container__content {
        flex-grow: 1;
        overflow-y: scroll;
    } */

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
    </style>
    <?php include 'nav.php';?>
</head>

<body>
    <main class="wrap">
        <section class="container">
            <div class="container__heading">
                <h2>Terms & Conditions</h2>
            </div>
            <div class="container__content" id="content">
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
                <hr>
                <p><strong>Immaculate Conception Parish Church</strong><br>Poblacion Pandi Bulacan, Philippines
                    3014<br>immaculateconceptionparish@email.com <br>
                    +639 123 4567</p>

                <p><strong>Last Updated:</strong> December, 2023</p>

            </div>
            <!-- <div class="container__nav">
                <small>By clicking 'Accept' you are agreeing to our terms and conditions.</small>
                <button class="button" id="acceptButton" disabled>Accept</button>
            </div> -->
        </section>
    </main>

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
</body>
<?php include 'footer.php';?>

</html>