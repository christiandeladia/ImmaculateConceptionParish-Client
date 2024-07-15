<?php
include_once "../connect.php";
require 'vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
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


// Cloudinary configuration
Configuration::instance([
    'cloud' => [
        'cloud_name' => 'djj8halfk',
        'api_key' => '432567652899755',
        'api_secret' => 'pt5XCkw8DBIduTR1A02h9QIP2Os'
    ],
    'url' => [
      'secure' => true]]);

// Upload birth certificate image
$reciept = $_FILES['reciept']['tmp_name'];
$result_reciept = (new UploadApi())->upload($reciept);
$reciept_url = $result_reciept['secure_url'];


// Extract form data
$purpose = $_POST["purpose"];
$name = $_POST["name"];
$date = $_POST["date"];
$time = $_POST["time"];

// Generate reference ID
$reference_id = "mass-" . uniqid();
$services = 'Mass'; // Assuming you want to insert 'mass' into the 'services' column
$status = 'unread';

$currentUserId = $_SESSION['auth_login']['id']; 
$sql = "SELECT email, first_name FROM login WHERE id = '$currentUserId'";
$result = mysqli_query($conn, $sql);

if ($result && $row = mysqli_fetch_assoc($result)) {
    $currentUserEmail = $row['email'];
    $currentUserFirstName = $row['first_name'];
    $status_id = "1";

    $sql = "INSERT INTO mass (client_id, user_email, user_first_name, reference_id, purpose, name, date, time, reciept, status_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt1 = mysqli_prepare($conn, $sql);

    if ($stmt1) {
        mysqli_stmt_bind_param($stmt1, "ssssssssss", $currentUserId, $currentUserEmail, $currentUserFirstName, $reference_id, $purpose, $name, $date, $time, $reciept_url, $status_id);

        $checkResult1 = mysqli_stmt_execute($stmt1);

        mysqli_stmt_close($stmt1);

        if ($checkResult1) {

            // Retrieve the last inserted record from mass table
            $lastId = mysqli_insert_id($conn);
            $result = mysqli_query($conn, "SELECT * FROM mass WHERE id = $lastId");

            if ($result && $row = mysqli_fetch_assoc($result)) {
                // Insert data into mass_notification table
                $sql2 = "INSERT INTO notification (reference_id, services, status, customer_id, customer_name) 
        VALUES (?, ?, ?, ?, ?)";

                $stmt2 = mysqli_prepare($conn, $sql2);

                if ($stmt2) {
                    mysqli_stmt_bind_param($stmt2, "sssss", $reference_id, $services, $status, $auth_id, $auth_fullname);

                    $checkResult2 = mysqli_stmt_execute($stmt2);

                    mysqli_stmt_close($stmt2);

                    if ($checkResult2) {
                    ?>
<!DOCTYPE html>
<title>MASS APPLICATION - ICP </title>
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
    margin-top: 8%;
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
                <p>(The Mass application has been submitted successfully, kindly wait for the approvals through
                    email!)
                </p>
            </div>
        </div>
        <hr>
        <fieldset>
            <div class="form-row">
                <div class="form-group col-md">
                    <label for="purpose">Purpose:</label>
                    <input type="text" class="form-control" value="<?= $row["purpose"] ?>" disabled>
                </div>
                <div class="form-group col-md">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" value="<?= $row["name"] ?>" disabled>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md">
                    <label for="date">Date:</label>
                    <input type="text" class="form-control"
                        value="<?= date('M d, Y', strtotime($row["date"])) ?>" disabled>
                </div>

                <div class="form-group col-md">
                    <label for="date">Mass Time:</label>
                    <input type="text" class="form-control" value="<?= date('h:i a', strtotime($row["time"])) ?>"
                        disabled>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md">
                    <label for="reciept">Reciept:</label>
                    <?php
                
                $url = $row["reciept"];
                $hiddenValue = str_repeat('Reciept', strlen(1));
                ?>
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?= $hiddenValue ?>" disabled>
                        <div class="input-group-append">
                            <button class="btn btn-primary view-btn"
                                data-url="<?= $row["reciept"] ?>">View</button>
                        </div>
                    </div>
                    <div class="file-path" id="reciept" style="display: none;">
                        <?= $row["reciept"] ?>
                    </div>
                </div>
            </div>


        </fieldset>
        <div class="modal-footer">
            <a href="../send_mass_application.php?id=<?= $row['id'] ?>"><button type="button"
                    class="btn btn-success">DONE →</button></a>
        </div>
    </div>
    <div id="imageModal" class="modal_pic">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImage">
</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var viewButtons = document.querySelectorAll('.view-btn');
    var modal = document.getElementById('imageModal');
    var modalImg = document.getElementById('modalImage');
    var closeModal = document.getElementsByClassName('close')[0];
    document.body.addEventListener('contextmenu', function(event) {
        event.preventDefault();
    });

    viewButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            var url = this.getAttribute('data-url');
            modal.style.display = 'block'; // Display the modal
            modalImg.src = url; // Set the image source
        });
    });

    closeModal.addEventListener('click', function() {
        modal.style.display = 'none'; // Hide the modal when the close button is clicked
    });

    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none'; // Hide the modal when clicked outside of it
        }
    });

    modal.addEventListener('contextmenu', function(event) {
        event.preventDefault(); // Prevent default right-click behavior
    });

    modalImg.addEventListener('contextmenu', function(event) {
        event.preventDefault(); // Prevent default right-click behavior
    });
});
</script>
<style>
    body{
    height: 100%;
    background-image: url(../image/banner_about.png) !important;
    /* background-color: #33bb11; */
    background-size: cover;
    background-position: center;

}
/* Center modal vertically and horizontally */
.modal_pic {
    display: none;
    /* Hide modal by default */
    position: fixed;
    z-index: 1000;
    padding-top: 100px;
    /* Location of the modal */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.9);
    /* Black w/ opacity */
}

.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    /* Adjust modal width as needed */
    max-width: 600px;
    /* Set maximum modal width */
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
</style>
</body>

</html>
<?php
                    } else {
                        echo "Unsuccessful in inserting data into mass_notification table.";
                    }
                } else {
                    echo "Prepared statement error: " . mysqli_error($conn);
                }
            } else {
                echo "Error retrieving data from mass table.";
            }
        } else {
            echo "Unsuccessful in inserting data into mass table.";
        }
    } else {
        echo "Prepared statement error: " . mysqli_error($conn);
    }
} else {
    echo "Error retrieving user data from login table.";
}

mysqli_close($conn);
?>