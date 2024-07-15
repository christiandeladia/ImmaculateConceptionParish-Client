<?php
include_once "../connect.php";
require 'vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

// Check if user is logged in
session_start();
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
// Retrieve auth_id from session
$auth_id = $_SESSION['auth_login']['id'];
$auth_fname = $_SESSION['auth_login']['first_name'];
$auth_lname = $_SESSION['auth_login']['last_name'];
$auth_fullname = $auth_fname . ' ' . $auth_lname;


$deceased_fullname = $_POST["deceased_fullname"];
$date_of_death = $_POST["date_of_death"];
$civil_status = $_POST["civil_status"];

if ($civil_status === "Single"){
    $spouse_name = "N/A";
    $number_of_child = "0";
} else {
    $spouse_name = $_POST["spouse_name"];
    $number_of_child = $_POST["number_of_child"];
}
$mother_name = $_POST["mother_name"];
$father_name = $_POST["father_name"];
$age = $_POST["age"];
$address = $_POST["address"];
if ($_POST['address'] !== 'other') {
    $complete_address = $_POST["complete_address1"];
} else {
    $complete_address = $_POST["complete_address2"];
}// $permission = $_POST["permission"];
if ($_POST['address'] !== 'other') {
    $permission = 'N/A';
} else {
    $permission_certificate = $_FILES['permission']['tmp_name'];
    $result_permission_certificate = (new UploadApi())->upload($permission_certificate);
    $permission = $result_permission_certificate['secure_url'];
}
$cause_of_death = $_POST["cause_of_death"];
$has_sacrament = $_POST["has_sacrament"];
$client_name = $_POST["client_name"];
$relationship = $_POST["relationship"];
$contact_number = $_POST["contact_number"];
$allowed_to_mass = $_POST["allowed_to_mass"];
$time = $_POST["time"];
$date = $_POST["date"];
$mass_location = $_POST["mass_location"];
$burial_place = $_POST["burial_place"];
$status_id = "1";

// Generate reference ID
$reference_id = "funeral-" . uniqid();
$currentUserId = $_SESSION['auth_login']['id']; 
$sql = "SELECT * FROM login WHERE id = '$currentUserId'";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $currentUserEmail = $row['email'];
    $currentUserFirstName = $row['first_name'];
}
// Prepare SQL statement for insertion
$sql1 = "INSERT INTO funeral (client_id, user_email, user_first_name, reference_id, deceased_fullname, date_of_death, civil_status,
    spouse_name, mother_name, father_name, age, number_of_child, address, permission, complete_address, cause_of_death,
    has_sacrament, client_name, relationship, contact_number, allowed_to_mass, time, date,
    mass_location, burial_place, status_id
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt1 = mysqli_prepare($conn, $sql1);

if ($stmt1) {
    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt1, "ssssssssssssssssssssssssss", $currentUserId, $currentUserEmail,$currentUserFirstName, $reference_id, $deceased_fullname, $date_of_death, $civil_status,
        $spouse_name, $mother_name, $father_name, $age, $number_of_child, $address, $permission, $complete_address, $cause_of_death,
        $has_sacrament, $client_name, $relationship, $contact_number, $allowed_to_mass, $time, $date,
        $mass_location, $burial_place, $status_id);
    
    $checkResult1 = mysqli_stmt_execute($stmt1);

    if ($checkResult1) {
        // Retrieve the last inserted record from the funeral table
        $lastId = mysqli_insert_id($conn);
        $result = mysqli_query($conn, "SELECT * FROM funeral WHERE id = $lastId");

        if ($result && $row = mysqli_fetch_assoc($result)) {
            // Insert data into notification table
            $services = 'Funeral';
            $status = 'unread';
            $sql2 = "INSERT INTO notification (reference_id, services, status, customer_id, customer_name) 
                    VALUES (?, ?, ?, ?, ?)";
    
            $stmt2 = mysqli_prepare($conn, $sql2);
    
            if ($stmt2) {
                mysqli_stmt_bind_param($stmt2, "sssss", $reference_id, $services, $status, $auth_id, $auth_fullname);
    
                $checkResult2 = mysqli_stmt_execute($stmt2);
    
                if ($checkResult2) {
                    // Insert data into schedule table
                    $services = 'Funeral';
                    $status = '1';
                    $date_time = $date . ' ' . $time;
                    $schedule_sql = "INSERT INTO schedule (reference_id, client_id, date, time, services, status, date_time) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)";

                    $schedule_stmt = mysqli_prepare($conn, $schedule_sql);

                    if ($schedule_stmt) {
                        mysqli_stmt_bind_param($schedule_stmt, "sssssss", $reference_id, $currentUserId, $date, $time, $services, $status, $date_time);
                        $schedule_checkResult = mysqli_stmt_execute($schedule_stmt);

                        mysqli_stmt_close($schedule_stmt);

                        if (!$schedule_checkResult) {
                            echo "Unsuccessful in inserting data into schedule table.";
                        }
                    } else {
                        echo "Prepared statement error: " . mysqli_error($conn);
                    }
    
                    // Display success message and redirect
                    ?>
<!DOCTYPE html>
<title>FUNERAL APPLICATION - ICP </title>
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
    margin-top: 1%;
    margin-bottom: 1%;
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
                <label for="deceased_fullname">Deceased Full Name:</label>
                <input type="text" class="form-control" value="<?= $deceased_fullname ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="age">Age:</label>
                <input type="number" class="form-control" value="<?= $age ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="date_of_death">Date of Death:</label>
                <input type="text" class="form-control" value="<?= date('M d, Y', strtotime($date_of_death)) ?>" disabled>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md">
                <label for="civil_status">Civil Status:</label>
                <input type="text" class="form-control" value="<?= $civil_status ?>" disabled>
            </div>

            <?php
            if ($civil_status === "Married") {
                ?>
            <div class="form-group col-md">
                <label for="spouse_name">Spouse Name:</label>
                <input type="text" class="form-control" value="<?= $spouse_name ?>" disabled>
            </div>

            <div class="form-group col-md">
                <label for="number_of_child">Number of Children:</label>
                <input type="text" class="form-control" value="<?= $number_of_child ?>" disabled>
            </div>
            <?php
            }
            ?>
        </div>

        <div class="form-row">
            <div class="form-group col-md">
                <label for="mother_name">Mother's Name:</label>
                <input type="text" class="form-control" value="<?= $mother_name ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="father_name">Father's Name:</label>
                <input type="text" class="form-control" value="<?= $father_name ?>" disabled>
            </div>
        </div>


        <div class="form-row">
            <div class="form-group col-md">
                <label for="complete_address">Complete Address:</label>
                <input type="text" class="form-control" value="<?= $complete_address ?>" disabled>
            </div>
            <?php if ($permission === 'N/A'): ?>
            <div class="form-group col-md">
                <label for="permission">Permission Certificate:</label>
                <input type="text" class="form-control" value="<?= $permission ?>" disabled>
            </div>
            <?php else: ?>
            <div class="form-group col-md">
                <label for="permission">Permission Certificate:</label>
                <?php
                $url = $permission;
                $hiddenValue = str_repeat('Permission Certificate', strlen(1));
                ?>
                <div class="input-group">
                    <input type="text" class="form-control" value="<?= $hiddenValue ?>" disabled>
                    <div class="input-group-append">
                        <button class="btn btn-primary view-btn" data-url="<?= $permission ?>">View</button>
                    </div>
                </div>
                <div class="file-path" id="permission" style="display: none;">
                    <?= $permission ?>
                </div>
            </div>
            <?php endif; ?>
        </div>


        <div class="form-row">
            <div class="form-group col-md">
                <label for="client_name">Client Name:</label>
                <input type="text" class="form-control" value="<?= $client_name ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="relationship">Relationship:</label>
                <input type="text" class="form-control" value="<?= $relationship ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="contact_number">Contact Number:</label>
                <input type="text" class="form-control" value="<?= $contact_number ?>" disabled>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md">
                <label for="cause_of_death">Cause of Death:</label>
                <input type="text" class="form-control" value="<?= $cause_of_death ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="has_sacrament">Has Sacrament:</label>
                <input type="text" class="form-control" value="<?= $has_sacrament ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="burial_place">Burial Place:</label>
                <input type="text" class="form-control" value="<?= $burial_place ?>" disabled>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md">
                <label for="allowed_to_mass">Allowed to Mass:</label>
                <input type="text" class="form-control" value="<?= $allowed_to_mass ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="time">Mass Time:</label>
                <input type="text" class="form-control" value="<?= date('h:m a', strtotime($time)) ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="date">Mass Date:</label>
                <input type="text" class="form-control" value="<?= date('M d, Y', strtotime($date)) ?>" disabled>
            </div>

            <div class="form-group col-md">
                <label for="mass_location">Mass Location:</label>
                <input type="text" class="form-control" value="<?= $mass_location ?>" disabled>
            </div>
        </div>

        <div class="modal-footer">
            <a href="../send_funeral_application.php?id=<?= $row['id'] ?>"><button type="button"
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

</body>
<style>
body {
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
            echo "Error retrieving data from funeral table.";
        }
    } else {
        echo "Unsuccessful in inserting data into funeral table.";
    }

    // Close the statement
    mysqli_stmt_close($stmt1);
} else {
    echo "Prepared statement error: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>