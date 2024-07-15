<?php
include_once "../connect.php";

// Start session
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

// Extract form data
$patients_name = $_POST["patients_name"];
$age = $_POST["age"];
$address = $_POST["address"];
$urgent = $_POST["urgent"];
$complete_address = $_POST["complete_address"];
$illness = $_POST["illness"];
$can_eat = $_POST["can_eat"];
$can_speak = $_POST["can_speak"];
$contact_person = $_POST["contact_person"];
$contact_number = $_POST["contact_number"];
$date = $_POST["date"];
$time = $_POST["time"];
$status_id = "1";
// Generate reference ID
$reference_id = "sickcall-" . uniqid();
$currentUserId = $_SESSION['auth_login']['id']; 
$sql = "SELECT * FROM login WHERE id = '$currentUserId'";
$result = mysqli_query($conn, $sql);

if ($result && $row = mysqli_fetch_assoc($result)) {
    $currentUserEmail = $row['email'];
    $currentUserFirstName = $row['first_name'];
    // Prepare SQL statement for insertion
    $sql1 = "INSERT INTO sickcall (client_id, user_email, user_first_name, reference_id, patients_name, age, address, complete_address, urgent, illness, can_eat, can_speak, contact_person, contact_number, date, time, status_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt1 = mysqli_prepare($conn, $sql1);

    if ($stmt1) {
        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt1, "sssssssssssssssss",$currentUserId, $currentUserEmail, $currentUserFirstName, $reference_id, $patients_name, $age, $address, $complete_address, $urgent, $illness, $can_eat, $can_speak, $contact_person, $contact_number, $date, $time, $status_id);

        
        $checkResult1 = mysqli_stmt_execute($stmt1);

        if ($checkResult1) {
            // Retrieve the last inserted record from the sickcall table
            $lastId = mysqli_insert_id($conn);
            $result = mysqli_query($conn, "SELECT * FROM sickcall WHERE id = $lastId");

            if ($result && $row = mysqli_fetch_assoc($result)) {
                // Insert data into notification table
                $services = 'Sick Call';
                $status = 'unread';
                $sql2 = "INSERT INTO notification (reference_id, services, status, customer_id, customer_name) 
                    VALUES (?, ?, ?, ?, ?)";

                $stmt2 = mysqli_prepare($conn, $sql2);

                if ($stmt2) {
                    mysqli_stmt_bind_param($stmt2, "sssss", $reference_id, $services, $status, $auth_id, $auth_fullname);

                    $checkResult2 = mysqli_stmt_execute($stmt2);

                    if ($checkResult2) {
                        // Insert data into schedule table
                        $services = 'Sickcall';
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
<title>SICKCALL APPLICATION - ICP </title>
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
    margin-top: 3%;
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
                <p>The Sick Call application has been submitted successfully. Kindly wait for the approvals through
                    email.</p>
            </div>
        </div>
        <hr>
        <fieldset>
            <div class="form-row">
                <div class="form-group col-md">
                    <label for="<?= $row["patients_name"] ?>">Patient's Name:</label>
                    <input type="text" class="form-control" value="<?= $row["patients_name"] ?>" disabled>
                </div>

                <div class="form-group col-md">
                    <label for="age">Age:</label>
                    <input type="number" class="form-control" value="<?= $row["age"] ?>" disabled>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" value="<?= $row["address"] ?>" disabled>
                </div>

                <div class="form-group col-md">
                    <label for="complete_address">Complete Address:</label>
                    <input type="text" class="form-control" value="<?= $row["complete_address"] ?>" disabled>
                </div>
            </div>

            <div class="form-row">
            <div class="form-group col-md">
                    <label for="urgent">It is urgent?</label>
                    <input type="text" class="form-control" value="<?= $row["urgent"] ?>" disabled>
                </div>
                <div class="form-group col-md">
                    <label for="illness">Illness:</label>
                    <input type="text" class="form-control" value="<?= $row["illness"] ?>" disabled>
                </div>
                <div class="form-group col-md">
                    <label for="can_eat">Can Eat:</label>
                    <input type="text" class="form-control" value="<?= $row["can_eat"] ?>" disabled>
                    </select>
                </div>

                <div class="form-group col-md">
                    <label for="can_speak">Can Speak:</label>
                    <input type="text" class="form-control" value="<?= $row["can_speak"] ?>" disabled>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md">
                    <label for="contact_person">Contact Person:</label>
                    <input type="text" class="form-control" value="<?= $row["contact_person"] ?>" disabled>
                </div>

                <div class="form-group col-md">
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" class="form-control" value="<?= $row["contact_number"] ?>" maxlength="11"
                        pattern="[0-9]{11}" title="Please enter a valid 11-digit contact number" disabled>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md">
                    <label for="date">Date:</label>
                    <input type="text" class="form-control" value="<?= date('M d, Y', strtotime($row["date"])) ?>"
                        disabled>

                </div>

                <div class="form-group col-md">
                    <label for="time">Time:</label>
                    <input type="text" class="form-control" value="<?= date('h:i a', strtotime($row["time"])) ?>"
                        disabled>
                </div>
            </div>

        </fieldset>
        <div class="modal-footer">
            <a href="../send_sickcall_application.php?id=<?= $row['id'] ?>"><button type="button"
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
                echo "Error retrieving data from sickcall table.";
            }
        } else {
            echo "Unsuccessful in inserting data into sickcall table.";
        }

        // Close the statement
        mysqli_stmt_close($stmt1);
    } else {
        echo "Prepared statement error: " . mysqli_error($conn);
    }
} else {
    echo "Error retrieving user data.";
}

// Close the connection
mysqli_close($conn);
?>