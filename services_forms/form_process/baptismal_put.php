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

// Upload birth certificate image
$copy_birth_certificate = $_FILES['copy_birth_certificate']['tmp_name'];
$result_birth_certificate = (new UploadApi())->upload($copy_birth_certificate);
$birth_certificate_url = $result_birth_certificate['secure_url'];

// Upload marriage certificate image
$copy_marriage_certificate = $_FILES['copy_marriage_certificate']['tmp_name'];
$result_marriage_certificate = (new UploadApi())->upload($copy_marriage_certificate);
$marriage_certificate_url = $result_marriage_certificate['secure_url'];

// Extract form data
$child_first_name = $_POST["child_first_name"];
$mother_maiden_lastname = $_POST["mother_maiden_lastname"];
$father_lastname = $_POST["father_lastname"];
$birthdate = $_POST["birthdate"];
$months = $_POST["months"];
$marriage = $_POST["marriage"];
if ($_POST['marriage'] === 'hindi') {
    $marriage_location = 'N/A';
} else {
    $marriage_location = $_POST['marriage_location'];
}
$birthplace = $_POST["birthplace"];
$date = $_POST["date"];
$time = $_POST["time"];
$father_name = $_POST["father_name"];
$father_origin_place = $_POST["father_origin_place"];
$mother_maiden_fullname = $_POST["mother_maiden_fullname"];
$mother_origin_place = $_POST["mother_origin_place"];
$address = $_POST["address"];
if ($_POST['address'] !== 'other') {
    $complete_address = $_POST["complete_address1"];
} else {
    $complete_address = $_POST["complete_address2"];
}
if ($_POST['address'] !== 'other') {
    $permission = 'N/A';
} else {
    $permission_certificate = $_FILES['permission']['tmp_name'];
    $result_permission_certificate = (new UploadApi())->upload($permission_certificate);
    $permission = $result_permission_certificate['secure_url'];
}

$godfather = $_POST["godfather"];
$godfather_age = $_POST["godfather_age"];
$godfather_religion = $_POST["godfather_religion"];
$godfather_address = $_POST["godfather_address"];
$godmother = $_POST["godmother"];
$godmother_age = $_POST["godmother_age"];
$godmother_religion = $_POST["godmother_religion"];
$godmother_address = $_POST["godmother_address"];
$client_name = $_POST["client_name"];
$client_relationship = $_POST["client_relationship"];
$client_contact_number = $_POST["client_contact_number"];
$status_id = "1";

// Generate reference ID
$reference_id = "baptismal-" . uniqid();
$currentUserId = $_SESSION['auth_login']['id']; 
$sql = "SELECT * FROM login WHERE id = '$currentUserId'";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $currentUserEmail = $row['email'];
    $currentUserFirstName = $row['first_name'];
}
// Prepare SQL statement for insertion
$sql = "INSERT INTO binyag (client_id, user_email, user_first_name, reference_id, child_first_name, mother_maiden_lastname, father_lastname, birthdate, months, marriage, marriage_location, birthplace, date, time, father_name, father_origin_place, mother_maiden_fullname, mother_origin_place, address, complete_address, permission, godfather, godfather_age, godfather_religion, godfather_address, godmother, godmother_age, godmother_religion, godmother_address, client_name, client_relationship, client_contact_number, copy_birth_certificate, copy_marriage_certificate, status_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt, "sssssssssssssssssssssssssssssssssss",$currentUserId, $currentUserEmail, $currentUserFirstName, $reference_id, $child_first_name, $mother_maiden_lastname, $father_lastname, $birthdate, $months, $marriage, $marriage_location, $birthplace, $date, $time, $father_name, $father_origin_place, $mother_maiden_fullname, $mother_origin_place, $address, $complete_address, $permission, $godfather, $godfather_age, $godfather_religion, $godfather_address, $godmother, $godmother_age, $godmother_religion, $godmother_address, $client_name, $client_relationship, $client_contact_number, $birth_certificate_url, $marriage_certificate_url, $status_id);
    
    $checkResult = mysqli_stmt_execute($stmt);

    if ($checkResult) {
        // Retrieve the last inserted record from the binyag table
        $lastId = mysqli_insert_id($conn);
        $result = mysqli_query($conn, "SELECT * FROM binyag WHERE id = $lastId");

        if ($result && $row = mysqli_fetch_assoc($result)) {
            // Insert data into notification table
            $services = 'Baptismal';
            $status = 'unread';
            $sql2 = "INSERT INTO notification (reference_id, services, status, customer_id, customer_name) 
                    VALUES (?, ?, ?, ?, ?)";
    
            $stmt2 = mysqli_prepare($conn, $sql2);
    
            if ($stmt2) {
                mysqli_stmt_bind_param($stmt2, "sssss", $reference_id, $services, $status, $auth_id, $auth_fullname);
    
                $checkResult2 = mysqli_stmt_execute($stmt2);
    
                if ($checkResult2) {
                    // Insert data into schedule table
                    $services = 'Baptism';
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

                    ?>
<!DOCTYPE html>
<title>BAPTISMAL APPLICATION - ICP </title>
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

<body style="background-color: #33bb11;">
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
        <h4>BATANG MAGPAPABINYAG</h4>
        <!-- Child Information -->
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
                <label for="months">Months:</label>
                <input type="text" class="form-control" value="<?= $row["months"] ?>" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md">
                <label for="birthplace">Lugar ng Kapanganakan (Birthplace):</label>
                <input type="text" class="form-control" value="<?= $row["birthplace"] ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="date">Petsa ng Binyag (Baptismal Date):</label>
                <input type="text" class="form-control" value="<?= $row["date"] ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="time">Oras ng Binyag (Baptismal Time):</label>
                <input type="text" class="form-control" value="<?= date("h:i A", strtotime($row["time"])) ?>"
                    disabled>
            </div>
        </div>
        <hr>
        <h4>MAGULANG</h4>
        <div class="form-row">
            <div class="form-group col-md">
                <label for="father_name">Father's Name:</label>
                <input type="text" class="form-control" value="<?= $row["father_name"] ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="father_origin_place">Father's Origin Place:</label>
                <input type="text" class="form-control" value="<?= $row["father_origin_place"] ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="mother_maiden_fullname">Mother's Maiden Full Name:</label>
                <input type="text" class="form-control" value="<?= $row["mother_maiden_fullname"] ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="mother_origin_place">Mother's Origin Place:</label>
                <input type="text" class="form-control" value="<?= $row["mother_origin_place"] ?>" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md">
                <label for="marriage">Kasal:</label>
                <input type="text" class="form-control" value="<?= $row["marriage"] ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="marriage_location">Marriage Location:</label>
                <input type="text" class="form-control" value="<?= $row["marriage_location"] ?>" disabled>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md">
                <label for="complete_address">Complete Address:</label>
                <input type="text" class="form-control" value="<?= $row["complete_address"] ?>" disabled>
            </div>
            <?php if ($row["permission"] === 'N/A'): ?>
            <div class="form-group col-md">
                <label for="permission">Permission Certificate:</label>
                <input type="text" class="form-control" value="<?= $row["permission"] ?>" disabled>
            </div>
            <?php else: ?>
            <div class="form-group col-md">
                <label for="permission">Permission Certificate:</label>
                <?php
                $url = $row["permission"];
                $hiddenValue = str_repeat('Permission Certificate', strlen(1));
                ?>
                <div class="input-group">
                    <input type="text" class="form-control" value="<?= $hiddenValue ?>" disabled>
                    <div class="input-group-append">
                        <button class="btn btn-primary view-btn" data-url="<?= $row["permission"] ?>">View</button>
                    </div>
                </div>
                <div class="file-path" id="permission" style="display: none;">
                    <?= $row["permission"] ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <hr>
        <h4>NINONG AT NINANG</h4>
        <div class="form-row">
            <div class="form-group col-md">
                <label for="godfather">Ninong:</label>
                <input type="text" class="form-control" value="<?= $row["godfather"] ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="godfather_age">Age:</label>
                <input type="text" class="form-control" value="<?= $row["godfather_age"] ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="godfather_religion">Religion:</label>
                <input type="text" class="form-control" value="<?= $row["godfather_religion"] ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="godfather_address">Address:</label>
                <input type="text" class="form-control" value="<?= $row["godfather_address"] ?>" disabled>
            </div>

        </div>

        <div class="form-row">
            <div class="form-group col-md">
                <label for="godmother">Ninang:</label>
                <input type="text" class="form-control" value="<?= $row["godmother"] ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="godmother_age">Edad:</label>
                <input type="text" class="form-control" value="<?= $row["godmother_age"] ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="godmother_religion">Relihiyon:</label>
                <input type="text" class="form-control" value="<?= $row["godmother_religion"] ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="godmother_address">Tirahan:</label>
                <input type="text" class="form-control" value="<?= $row["godmother_address"] ?>" disabled>
            </div>
        </div>
        <hr>
        <h4>NAGPALISTA</h4>
        <div class="form-row">
            <div class="form-group col-md">
                <label for="client_name">Client Name:</label>
                <input type="text" class="form-control" value="<?= $row["client_name"] ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="client_relationship">Client Relationship:</label>
                <input type="text" class="form-control" value="<?= $row["client_relationship"] ?>" disabled>
            </div>
            <div class="form-group col-md">
                <label for="client_contact_number">Client Contact Number:</label>
                <input type="text" class="form-control" value="<?= $row["client_contact_number"] ?>" disabled>
            </div>
        </div>
        <hr>
        <h4>DOCUMENTS</h4>
        <div class="form-row">
            <div class="form-group col-md">
                <label for="psa_cenomar_photocopy_groom">Copy of Birth Certificate:</label>
                <?php
                
                $url = $row["copy_birth_certificate"];
                $hiddenValue = str_repeat('Birth Certificate', strlen(1));
                ?>
                <div class="input-group">
                    <input type="text" class="form-control" value="<?= $hiddenValue ?>" disabled>
                    <div class="input-group-append">
                        <button class="btn btn-primary view-btn"
                            data-url="<?= $row["copy_birth_certificate"] ?>">View</button>
                    </div>
                </div>
                <div class="file-path" id="psa_cenomar_photocopy_groom_path" style="display: none;">
                    <?= $row["copy_birth_certificate"] ?>
                </div>
            </div>

            <div class="form-group col-md">
                <label for="copy_marriage_certificate">Copy of Marriage Certificate:</label>
                <?php
                
                $url = $row["copy_birth_certificate"];
                $hiddenValue = str_repeat('Marriage Certificate', strlen(1));
                ?>
                <div class="input-group">
                    <input type="text" class="form-control" value="<?= $hiddenValue ?>" disabled>
                    <div class="input-group-append">
                        <button class="btn btn-primary view-btn"
                            data-url="<?= $row["copy_marriage_certificate"] ?>">View</button>
                    </div>
                </div>
                <div class="file-path" id="psa_cenomar_photocopy_groom_path" style="display: none;">
                    <?= $row["copy_marriage_certificate"] ?>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <a href="../send_baptismal_application.php?id=<?= $row['id'] ?>"><button type="button"
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
            echo "Error retrieving data from binyag table.";
        }
    } else {
        echo "Unsuccessful in inserting data into binyag table.";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Prepared statement error: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>