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
    <title>REQUEST FOR BAPTISMAL CERTIFICATE - ICP </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="image/favicon.ico">
    <link rel="stylesheet" href="style/forms.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <a href="request.php" class="back">
        < Back</a>
            <div class="container">
                <header>BAPTISMAL CERTIFICATE FORM</header>
                <div class="progress-bar">
                    <div class="step">
                        <p></p>
                        <div class="bullet">
                            <span>1</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                    <div class="step">
                        <p></p>
                        <div class="bullet">
                            <span>2</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                </div>
                <div class="form-outer">
                    <form method="post" action="services_forms/form_process/baptismal_cert.php" method="POST"
                        enctype="multipart/form-data">
                        <div class="page slide-page">
                            <div class="title">Child's Basic Info:</div>

                            <div class="field"> <label class="label" for="child_first_name">Firstname:</label>
                                <input type="text" class="form-control" name="child_first_name" required>
                            </div>
                            <div class="field"> <label class="label" for="mother_maiden_lastname">Mother's Maiden
                                    Lastname:</label>
                                <input type="text" class="form-control" name="mother_maiden_lastname" required>
                            </div>
                            <div class="field"> <label class="label" for="father_lastname">Father's
                                    Lastname:</label>
                                <input type="text" class="form-control" name="father_lastname" required>
                            </div>
                            <div class="field"> <label class="label" for="birthdate">Birth
                                    Date:</label>
                                <input type="date" class="form-control" name="birthdate" id="birthdate"
                                    onchange="calculateMonths()" required max="<?= date('Y-m-d'); ?>">
                            </div>

                            <div class="field"> <label class="label" for="birthplace">Birth
                                    Place:</label>
                                <input type="text" class="form-control" name="birthplace" required>
                            </div>
                            <div class="field">
                                <button class="firstNext next">Next</button>
                            </div>
                        </div>

                        <div class="page">
                            <div class="title">Parents and Purpose:</div>
                            <div class="field"> <label class="label" for="father_fullname">Father's
                                    Full Name:</label>
                                <input type="text" class="form-control" name="father_fullname" required>
                            </div>

                            <div class="field"> <label class="label" for="mother_maidenname">Mother's
                                    Maiden Name:</label>
                                <input type="text" class="form-control" name="mother_maidenname" required>
                            </div>
                            <div class="field"> <label class="label" for="purpose">Purpose:</label>
                                <input type="text" class="form-control" name="purpose" required>
                            </div>
                            <div class="field btns">
                                <button class="prev-2 prev">Previous</button>
                                <button class="submit" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
</body>

</html>
<script src="js/forms.js"></script>
<style>
:root {
    --primary: #017b36;
    --secondary: #017b36;
    --errorColor: red;
    --stepNumber: 3;
    --containerWidth: 1000px;
    --bgColor: #017b36;
    --inputBorderColor: lightgray;
}

.progress-bar .step .bullet:before,
.progress-bar .step .bullet:after {
    position: absolute;
    content: "";
    bottom: 11px;
    right: -471px;
    height: 3px;
    width: 470px;
    background: #017b36;
}
</style>