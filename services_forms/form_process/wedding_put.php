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

Configuration::instance([
    'cloud' => [
        'cloud_name' => 'djj8halfk',
        'api_key' => '432567652899755',
        'api_secret' => 'pt5XCkw8DBIduTR1A02h9QIP2Os'
    ],
    'url' => [
        'secure' => true
    ]
]);

$psa_cenomar_photocopy_groom = $_FILES['psa_cenomar_photocopy_groom']['tmp_name'];
$result_psa_cenomar_photocopy_groom = (new UploadApi())->upload($psa_cenomar_photocopy_groom);
$psa_cenomar_photocopy_groom_url = $result_psa_cenomar_photocopy_groom['secure_url'];

$psa_cenomar_photocopy_bride = $_FILES['psa_cenomar_photocopy_bride']['tmp_name'];
$result_psa_cenomar_photocopy_bride = (new UploadApi())->upload($psa_cenomar_photocopy_bride);
$psa_cenomar_photocopy_bride_url = $result_psa_cenomar_photocopy_bride['secure_url'];


$baptismal_certificates_groom = $_FILES['baptismal_certificates_groom']['tmp_name'];
$result_baptismal_certificates_groom = (new UploadApi())->upload($baptismal_certificates_groom);
$baptismal_certificates_groom_url = $result_baptismal_certificates_groom['secure_url'];

$baptismal_certificates_bride = $_FILES['baptismal_certificates_bride']['tmp_name'];
$result_baptismal_certificates_bride = (new UploadApi())->upload($baptismal_certificates_bride);
$baptismal_certificates_bride_url = $result_baptismal_certificates_bride['secure_url'];


$psa_birth_certificate_photocopy_groom = $_FILES['psa_birth_certificate_photocopy_groom']['tmp_name'];
$result_psa_birth_certificate_photocopy_groom = (new UploadApi())->upload($psa_birth_certificate_photocopy_groom);
$psa_birth_certificate_photocopy_groom_url = $result_psa_birth_certificate_photocopy_groom['secure_url'];

$psa_birth_certificate_photocopy_bride = $_FILES['psa_birth_certificate_photocopy_bride']['tmp_name'];
$result_psa_birth_certificate_photocopy_bride = (new UploadApi())->upload($psa_birth_certificate_photocopy_bride);
$psa_birth_certificate_photocopy_bride_url = $result_psa_birth_certificate_photocopy_bride['secure_url'];


$id_picture_groom = $_FILES['id_picture_groom']['tmp_name'];
$result_id_picture_groom = (new UploadApi())->upload($id_picture_groom);
$id_picture_groom_url = $result_id_picture_groom['secure_url'];

$id_picture_bride = $_FILES['id_picture_bride']['tmp_name'];
$result_id_picture_bride = (new UploadApi())->upload($id_picture_bride);
$id_picture_bride_url = $result_id_picture_bride['secure_url'];


$confirmation_certificates = $_FILES['confirmation_certificates']['tmp_name'];
$result_confirmation_certificates = (new UploadApi())->upload($confirmation_certificates);
$confirmation_certificates_url = $result_confirmation_certificates['secure_url'];

$computerized_name_of_sponsors = $_FILES['computerized_name_of_sponsors']['tmp_name'];
$result_computerized_name_of_sponsors = (new UploadApi())->upload($computerized_name_of_sponsors);
$computerized_name_of_sponsors_url = $result_computerized_name_of_sponsors['secure_url'];

$date = $_POST["date"];
$time = $_POST["time"];
$address = $_POST["address"];
if ($_POST['address'] !== 'other') {
    $complete_address = $_POST["complete_address1"];
} else {
    $complete_address = $_POST["complete_address2"];
}
// $permission = $_POST["permission"];
if ($_POST['address'] !== 'other') {
    $permission = 'N/A';
} else {
    $permission_certificate = $_FILES['permission']['tmp_name'];
    $result_permission_certificate = (new UploadApi())->upload($permission_certificate);
    $permission = $result_permission_certificate['secure_url'];
}
$groom_name = $_POST["groom_name"];
$groom_age = $_POST["groom_age"];
$groom_father_name = $_POST["groom_father_name"];
$groom_mother_name = $_POST["groom_mother_name"];
$bride_name = $_POST["bride_name"];
$bride_age = $_POST["bride_age"];
$bride_father_name = $_POST["bride_father_name"];
$bride_mother_name = $_POST["bride_mother_name"];
$status_id = "1";
// Generate reference ID
$reference_id = "wedding-" . uniqid();
$currentUserId = $_SESSION['auth_login']['id']; 
$sql = "SELECT * FROM login WHERE id = '$currentUserId'";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $currentUserEmail = $row['email'];
    $currentUserFirstName = $row['first_name'];
$sql = "INSERT INTO wedding (client_id, user_email, user_first_name, reference_id, psa_cenomar_photocopy_groom, psa_cenomar_photocopy_bride, baptismal_certificates_groom, baptismal_certificates_bride, confirmation_certificates, psa_birth_certificate_photocopy_groom, psa_birth_certificate_photocopy_bride, id_picture_groom, id_picture_bride, computerized_name_of_sponsors, groom_name, groom_age, groom_father_name, groom_mother_name, bride_name, bride_age, bride_father_name, bride_mother_name,status_id, date, time, address, complete_address, permission) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssssssssss",$currentUserId, $currentUserEmail, $currentUserFirstName, $reference_id, $psa_cenomar_photocopy_groom_url, $psa_cenomar_photocopy_bride_url, $baptismal_certificates_groom_url, $baptismal_certificates_bride_url, $confirmation_certificates_url, $psa_birth_certificate_photocopy_groom_url, $psa_birth_certificate_photocopy_bride_url, $id_picture_groom_url, $id_picture_bride_url, $computerized_name_of_sponsors_url, $groom_name, $groom_age, $groom_father_name, $groom_mother_name, $bride_name, $bride_age, $bride_father_name, $bride_mother_name, $status_id, $date, $time, $address, $complete_address, $permission);
    
    $checkResult = mysqli_stmt_execute($stmt);

    if ($checkResult) {
        // Retrieve the last inserted record from the wedding table
        $lastId = mysqli_insert_id($conn);
        $result = mysqli_query($conn, "SELECT * FROM wedding WHERE id = $lastId");

        if ($result && $row = mysqli_fetch_assoc($result)) {
            // Insert data into notification table
            $services = 'Wedding';
            $status = 'unread';
            $sql2 = "INSERT INTO notification (reference_id, services, status, customer_id, customer_name) 
                    VALUES (?, ?, ?, ?, ?)";
    
            $stmt2 = mysqli_prepare($conn, $sql2);
    
            if ($stmt2) {
                mysqli_stmt_bind_param($stmt2, "sssss", $reference_id, $services, $status, $auth_id, $auth_fullname);
    
                $checkResult2 = mysqli_stmt_execute($stmt2);
    
                if ($checkResult2) {
                    // Insert data into schedule table
                    $services = 'Wedding';
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
<title>WEDDING APPLICATION - ICP </title>
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
        <fieldset>
            <div class="form-row">
                <div class="form-group col-md">
                    <label for="date">Preferred Date:</label>
                    <input type="text" class="form-control" value="<?= date('M d, Y', strtotime($row["date"])) ?>" disabled>
                </div>
                <div class="form-group col-md">
                    <label for="time">Preferred Time:</label>
                    <input type="text" class="form-control" value="<?= date('h:i a', strtotime($row["time"])) ?>" disabled>
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
            <!-- Groom Information -->
            <div class="form-row">
                <div class="form-group col-md">
                    <label for="groom_name">Groom's Name:</label>
                    <input type="text" class="form-control" value="<?= $row["groom_name"] ?>" disabled>
                </div>
                <div class="form-group col-md">
                    <label for="groom_age">Groom's Age:</label>
                    <input type="number" class="form-control" value="<?= $row["groom_age"] ?>" disabled>
                </div>
                <div class="form-group col-md">
                    <label for="groom_father_name">Groom's Father's Name:</label>
                    <input type="text" class="form-control" value="<?= $row["groom_father_name"] ?>" disabled>
                </div>
                <div class="form-group col-md">
                    <label for="groom_mother_name">Groom's Mother's Name:</label>
                    <input type="text" class="form-control" value="<?= $row["groom_mother_name"] ?>" disabled>
                </div>
            </div>

            <!-- Bride Information -->
            <div class="form-row">
                <div class="form-group col-md">
                    <label for="bride_name">Bride's Name:</label>
                    <input type="text" class="form-control" value="<?= $row["bride_name"] ?>" disabled>
                </div>
                <div class="form-group col-md">
                    <label for="bride_age">Bride's Age:</label>
                    <input type="number" class="form-control" value="<?= $row["bride_age"] ?>" disabled>
                </div>
                <div class="form-group col-md">
                    <label for="bride_father_name">Bride's Father's Name:</label>
                    <input type="text" class="form-control" value="<?= $row["bride_father_name"] ?>" disabled>
                </div>
                <div class="form-group col-md">
                    <label for="bride_mother_name">Bride's Mother's Name:</label>
                    <input type="text" class="form-control" value="<?= $row["bride_mother_name"] ?>" disabled>
                </div>
            </div>
            <h4>DOCUMENTS</h4>
            <div class="form-row">
                <div class="form-group col-md">
                    <?php
                    $url = $row["psa_cenomar_photocopy_groom"];
                    $hiddenValue = str_repeat('PSA Cenomar Photocopy (Groom):', strlen(1));
                    ?>
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?= $hiddenValue ?>" disabled>
                        <div class="input-group-append">
                            <button class="btn btn-primary view-btn"
                                data-url="<?= $row["psa_cenomar_photocopy_groom"] ?>">View</button>
                        </div>
                    </div>
                    <div class="file-path" id="psa_cenomar_photocopy_groom_path" style="display: none;">
                        <?= $row["psa_cenomar_photocopy_groom"] ?>
                    </div>
                </div>

                <div class="form-group col-md">
                    <?php
                    $url = $row["psa_cenomar_photocopy_bride"];
                    $hiddenValue = str_repeat('PSA Cenomar Photocopy (Bride):', strlen(1));
                    ?>
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?= $hiddenValue ?>" disabled>
                        <div class="input-group-append">
                            <button class="btn btn-primary view-btn"
                                data-url="<?= $row["psa_cenomar_photocopy_bride"] ?>">View</button>
                        </div>
                        <div class="file-path" id="psa_cenomar_photocopy_bride_path" style="display: none;">
                            <?= $row["psa_cenomar_photocopy_bride"] ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md">
                    <?php
                    $url = $row["baptismal_certificates_groom"];
                    $hiddenValue = str_repeat('Baptismal Certificates (Groom):', strlen(1));
                    ?>
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?= $hiddenValue ?>" disabled>
                        <div class="input-group-append">
                            <button class="btn btn-primary view-btn"
                                data-url="<?= $row["baptismal_certificates_groom"] ?>">View</button>
                        </div>
                        <div class="file-path" id="baptismal_certificates_groom_path" style="display: none;">
                            <?= $row["baptismal_certificates_groom"] ?>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md">
                    <?php
                    $url = $row["baptismal_certificates_bride"];
                    $hiddenValue = str_repeat('Baptismal Certificates (Bride):', strlen(1));
                    ?>
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?= $hiddenValue ?>" disabled>
                        <div class="input-group-append">
                            <button class="btn btn-primary view-btn"
                                data-url="<?= $row["baptismal_certificates_bride"] ?>">View</button>
                        </div>
                        <div class="file-path" id="baptismal_certificates_bride_path" style="display: none;">
                            <?= $row["baptismal_certificates_bride"] ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md">
                    <?php
                    $url = $row["psa_birth_certificate_photocopy_groom"];
                    $hiddenValue = str_repeat('PSA Birth Certificate Photocopy (Groom):', strlen(1));
                    ?>
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?= $hiddenValue ?>" disabled>
                        <div class="input-group-append">
                            <button class="btn btn-primary view-btn"
                                data-url="<?= $row["psa_birth_certificate_photocopy_groom"] ?>">View</button>
                        </div>
                        <div class="file-path" id="psa_birth_certificate_photocopy_groom_path" style="display: none;">
                            <?= $row["psa_birth_certificate_photocopy_groom"] ?>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md">
                    <?php
                    $url = $row["psa_birth_certificate_photocopy_bride"];
                    $hiddenValue = str_repeat('PSA Birth Certificate Photocopy (Bride):', strlen(1));
                    ?>
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?= $hiddenValue ?>" disabled>
                        <div class="input-group-append">
                            <button class="btn btn-primary view-btn"
                                data-url="<?= $row["psa_birth_certificate_photocopy_bride"] ?>">View</button>
                        </div>
                        <div class="file-path" id="psa_birth_certificate_photocopy_bride_path" style="display: none;">
                            <?= $row["psa_birth_certificate_photocopy_bride"] ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md">
                    <?php
                    $url = $row["id_picture_groom"];
                    $hiddenValue = str_repeat('ID Picture (Groom):', strlen(1));
                    ?>
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?= $hiddenValue ?>" disabled>
                        <div class="input-group-append">
                            <button class="btn btn-primary view-btn"
                                data-url="<?= $row["id_picture_groom"] ?>">View</button>
                        </div>
                        <div class="file-path" id="id_picture_groom_path" style="display: none;">
                            <?= $row["id_picture_groom"] ?>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md">
                    <?php
                    $url = $row["id_picture_bride"];
                    $hiddenValue = str_repeat('ID Picture (Bride):', strlen(1));
                    ?>
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?= $hiddenValue ?>" disabled>
                        <div class="input-group-append">
                            <button class="btn btn-primary view-btn"
                                data-url="<?= $row["id_picture_bride"] ?>">View</button>
                        </div>
                        <div class="file-path" id="id_picture_bride_path" style="display: none;">
                            <?= $row["id_picture_bride"] ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md">
                    <?php
                    $url = $row["confirmation_certificates"];
                    $hiddenValue = str_repeat('Confirmation Certificates:', strlen(1));
                    ?>
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?= $hiddenValue ?>" disabled>
                        <div class="input-group-append">
                            <button class="btn btn-primary view-btn"
                                data-url="<?= $row["confirmation_certificates"] ?>">View</button>
                        </div>
                        <div class="file-path" id="confirmation_certificates_path" style="display: none;">
                            <?= $row["confirmation_certificates"] ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md">
                    <?php
                    $url = $row["computerized_name_of_sponsors"];
                    $hiddenValue = str_repeat('Computerized Name of Sponsors:', strlen(1));
                    ?>
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?= $hiddenValue ?>" disabled>
                        <div class="input-group-append">
                            <button class="btn btn-primary view-btn"
                                data-url="<?= $row["computerized_name_of_sponsors"] ?>">View</button>
                        </div>
                        <div class="file-path" id="computerized_name_of_sponsors_path" style="display: none;">
                            <?= $row["computerized_name_of_sponsors"] ?>
                        </div>
                    </div>
                </div>
            </div>

        </fieldset>
        <input type="hidden" id="file-path" value="">
        <div class="modal-footer">
            <a href="../send_wedding_application.php?id=<?= $row['id'] ?>"><button type="button"
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
            echo "Error retrieving data from wedding table.";
        }
    } else {
        echo "Unsuccessful in inserting data into wedding table.";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Prepared statement error: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
}
?>