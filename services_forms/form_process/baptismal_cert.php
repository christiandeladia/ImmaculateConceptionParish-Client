<?php
include_once "../connect.php";

session_start();

// Check if user is logged in
if (!isset($_SESSION['auth_login'])) {
    header("Location: ../index.php");
    exit; // Stop further execution
}

// Retrieve auth_id from session
$auth_id = $_SESSION['auth_login']['id'];
$auth_fname = $_SESSION['auth_login']['first_name'];
$auth_lname = $_SESSION['auth_login']['last_name'];
$auth_fullname = $auth_fname . ' ' . $auth_lname;

$child_first_name = $_POST["child_first_name"];
$mother_maiden_lastname = $_POST["mother_maiden_lastname"];
$father_lastname = $_POST["father_lastname"];
$birthdate = $_POST["birthdate"];
$birthplace = $_POST["birthplace"];
$father_fullname = $_POST["father_fullname"];
$mother_maidenname = $_POST["mother_maidenname"];
$purpose = $_POST["purpose"];
$status_id = "1";

// Generate reference ID
$reference_id = uniqid();
$currentUserId = $_SESSION['auth_login']['id']; 
$sql = "SELECT * FROM login WHERE id = '$currentUserId'";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $currentUserEmail = $row['email'];
    $currentUserFirstName = $row['first_name'];
}
// Insert data into binyag_request_certificate table
$sql = "INSERT INTO binyag_request_certificate (client_id, user_email, user_first_name, reference_id, child_first_name, mother_maiden_lastname, father_lastname, birthdate, birthplace, father_fullname, mother_maidenname, purpose,status_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt1 = mysqli_prepare($conn, $sql);

if ($stmt1) {
    mysqli_stmt_bind_param($stmt1, "sssssssssssss", $currentUserId, $currentUserEmail, $currentUserFirstName, $reference_id, $child_first_name, $mother_maiden_lastname, $father_lastname, $birthdate, $birthplace, $father_fullname, $mother_maidenname, $purpose, $status_id);

    $checkResult = mysqli_stmt_execute($stmt1);

    if ($checkResult) {
        // Retrieve the last inserted record from binyag_request_certificate table
        $lastId = mysqli_insert_id($conn);
        $result = mysqli_query($conn, "SELECT * FROM binyag_request_certificate WHERE id = $lastId");

        if ($result && $row = mysqli_fetch_assoc($result)) {
            // Insert data into notification table
            $services = 'Baptismal Certificate';
            $status = 'unread';
            $sql2 = "INSERT INTO notification (reference_id, services, status, customer_id, customer_name) 
                    VALUES (?, ?, ?, ?, ?)";
    
            $stmt2 = mysqli_prepare($conn, $sql2);
    
            if ($stmt2) {
                mysqli_stmt_bind_param($stmt2, "sssss", $reference_id, $services, $status, $auth_id, $auth_fullname);
    
                $checkResult2 = mysqli_stmt_execute($stmt2);
    
                if ($checkResult2) {
                
                    ?>

<!DOCTYPE html>
<title>BAPTISMAL CERTIFICATE - ICP </title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/x-icon" href="favicon.ico">
<link rel="stylesheet" href="confirmation.css">
<!-- FONT -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<!-- ICON -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- MODAL -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<style>
body {
    background-image: url("../image/banner_about.png");
    background-repeat: no-repeat;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-attachment: fixed;
}

.form {
    background-color: white;
    width: 70%;
    margin-top: 5%;
    margin-left: auto;
    margin-right: auto;
    border-top: 10px solid green;
    padding: 20px 20px 0px 20px;
}
.btn-success {
    padding: 5px 20px;
    font-size: 20px;
    color: #fff;
    border-radius: 40px;
    background-color: #28a745;
    border-color: #28a745;
    box-shadow: 0 4px 5px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.19);
}
</style>

<body>

    <div class="form">
        <div class="funds-success-message-container">
            <div class="funds-checkmark-text-container">
                <div class="funds-checkmark-container">
                    <svg class="funds-checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                        <circle class="funds-checkmark-circle" cx="26" cy="26" r="25" fill="none" />
                        <path class="funds-checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                    </svg>

                    <div class="funds-display-on-ie">
                        <svg class="funds-ie-checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                            <circle class="funds-ie-checkmark-circle" cx="26" cy="26" r="25" fill="none" />
                            <path class="funds-ie-checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                        </svg>
                    </div>
                </div>

                <h1 class="funds-success-done-text">SUCCESS!</h1>
            </div>

            <div class="funds-success-message">

                <h2>Application Submitted Successfully</h2>
                <span class="data-title"><strong>Reference Number:</strong></span>
                <?= $row["reference_id"] ?><br><br>
                <p>(The application has been submitted successfully, kindly wait for the approvals through
                    email!)
                </p>
            </div>
        </div>

        <hr>
        <div class="form-row">
            <div class="form-group col-md">
                <label for="child_first_name">Child's First Name:</label>
                <input type="text" class="form-control" value="<?= $row["child_first_name"] ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="mother_maiden_lastname">Mother's Maiden Lastname:</label>
                <input type="text" class="form-control" value="<?= $row["mother_maiden_lastname"] ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="father_lastname">Father's Lastname:</label>
                <input type="text" class="form-control" value="<?= $row["father_lastname"] ?>" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md">
                <label for="birthdate">Birthdate:</label>
                <input type="text" class="form-control" value="<?= $row["birthdate"] ?>" disabled>
            </div>

            <div class="form-group col-md">
                <label for="birthplace">Birthplace:</label>
                <input type="text" class="form-control" value="<?= $row["birthplace"] ?>" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md">
                <label for="father_fullname">Father's Full Name:</label>
                <input type="text" class="form-control" value="<?= $row["father_fullname"] ?>" disabled>
            </div>

            <div class="form-group col-md">
                <label for="mother_maidenname">Mother's Maiden Name:</label>
                <input type="text" class="form-control" value="<?= $row["mother_maidenname"] ?>" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md">
                <label for="purpose">Purpose:</label>
                <input type="text" class="form-control" value="<?= $row["purpose"] ?>" disabled>
            </div>
        </div>
        <div class="modal-footer">
            <a href="../send_baptismal_cert.php?id=<?= $row['id'] ?>"><button type="button"
                    class="btn btn-success">DONE →</button></a>
        </div>
    </div>
</body>

</html>
<?php
                    exit; // Stop further execution
                } else {
                    echo "Unsuccessful in inserting data into notification table.";
                }
    
                // Close the statement
                mysqli_stmt_close($stmt2);
            } else {
                echo "Prepared statement error: " . mysqli_error($conn);
            }
        } else {
            echo "Error retrieving data from binyag_request_certificate table.";
        }
    } else {
        echo "Unsuccessful in inserting data into binyag_request_certificate table.";
    }

    // Close the statement
    mysqli_stmt_close($stmt1);
} else {
    echo "Prepared statement error: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>