<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
$hostname="localhost";
$username="root";
$password="";
$dbname="icp_database";

$conn=mysqli_connect($hostname, $username,$password,$dbname);


if ($conn) {
if (isset($_GET["id"])) {
$id = $_GET["id"];
$sql = mysqli_query($conn, "SELECT * FROM `funeral` WHERE `id` = $id");
if ($sql && $row = mysqli_fetch_assoc($sql)) {
$email = $_SESSION['auth_login']['email'];

// Check if the email address is not empty
if (!empty($email)) {
$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.hostinger.com';
$mail->SMTPAuth = true;
$mail->Username = 'immaculate@devdojo.cloud';
$mail->Password = 'immaculateEmail$123';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->setFrom('immaculate@devdojo.cloud');

$mail->addAddress($email);

$mail->isHTML(true);


$mail->Subject = 'Funeral Thank youu..';
$mail->Body    = '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background: linear-gradient(#93C572, #FFFFFF);">
<div style="background-color: #008000; text-align: center; padding: 10px;">
    <img src="https://res.cloudinary.com/dqtbveriz/image/upload/v1711791868/logo_white_lio37e.png" alt="Sample Logo" style="display: inline-block; max-width: 200px;">
</div>
            <h2 style="color: #333333; font-size: 24px; font-weight: bold; text-align: center;">Funeral Application Submitted Successfully</h2>
            <p style="font-size: 16px;"><strong>Reference Number:</strong> ' . $row["reference_id"] . '</p>
            <p style="font-size: 16px;"><strong>Deceased Full Name:</strong> ' . $row["deceased_fullname"] . '</p>
            <p style="font-size: 16px;"><strong>Date of Death:</strong> ' . $row["date_of_death"] . '</p>
            <p style="font-size: 16px;"><strong>Civil Status:</strong> ' . $row["civil_status"] . '</p>
            <p style="font-size: 16px;"><strong>Spous Name:</strong> ' . $row["spouse_name"] . '</p>
            <p style="font-size: 16px;"><strong>Mother Name:</strong> ' . $row["mother_name"] . '</p>
            <p style="font-size: 16px;"><strong>Father Name:</strong> ' . $row["father_name"] . '</p>
            <p style="font-size: 16px;"><strong>Age:</strong> ' . $row["age"] . '</p>
            <p style="font-size: 16px;"><strong>Number of Child:</strong> ' . $row["number_of_child"] . '</p>
            <p style="font-size: 16px;"><strong>Current Address:</strong> ' . $row["current_address"] . '</p>
            <p style="font-size: 16px;"><strong>Cause of Death:</strong> ' . $row["cause_of_death"] . '</p>
            <p style="font-size: 16px;"><strong>Has Sacrament:</strong> ' . $row["has_sacrament"] . '</p>
            <p style="font-size: 16px;"><strong>Client Name:</strong> ' . $row["client_name"] . '</p>
            <p style="font-size: 16px;"><strong>Relationship:</strong> ' . $row["relationship"] . '</p>
            <p style="font-size: 16px;"><strong>Contact Number:</strong> ' . $row["contact_number"] . '</p>
            <p style="font-size: 16px;"><strong>Allowed To Masss:</strong> ' . $row["allowed_to_mass"] . '</p>
            <p style="font-size: 16px;"><strong>Mass Time</strong> ' . $row["mass_time"] . '</p>
            <p style="font-size: 16px;"><strong>Mass Date:</strong> ' . $row["mass_date"] . '</p>
            <p style="font-size: 16px;"><strong>Mass Location:</strong> ' . $row["mass_location"] . '</p>
            <p style="font-size: 16px;"><strong>Burial Place:</strong> ' . $row["burial_place"] . '</p>
            <p style="font-size: 16px;"><strong>Date Added:</strong> ' . $row["date_added"] . '</p>

            <p style="font-size: 16px;">(The application has been submitted successfully, kindly wait for the approvals through email!)</p>';
$mail->AltBody = 'Application Submitted Successfully
            Reference Number: ' . $row["reference_id"] . '
            Deceased Full Name: ' . $row["deceased_fullname"] . '
            Date of Death: ' . $row["date_of_death"] . '
            Civil Status: ' . $row["civil_status"] . '
            Spous Name: ' . $row["spouse_name"] . '
            Mother Name: ' . $row["mother_name"] . '
            Father Name: ' . $row["father_name"] . '
            Age: ' . $row["age"] . '
            Number of Child: ' . $row["number_of_child"] . '
            Current Address: ' . $row["current_address"] . '
            Cause of Death: ' . $row["cause_of_death"] . '
            Has Sacrament: ' . $row["has_sacrament"] . '
            Client Name: ' . $row["client_name"] . '
            Relationship:' . $row["relationship"] . '
            Contact Number: ' . $row["contact_number"] . '
            Allowed To Masss: ' . $row["allowed_to_mass"] . '
            Mass Time: ' . $row["mass_time"] . '
            Mass Date: ' . $row["mass_date"] . '
            Mass Location: ' . $row["mass_location"] . '
            Burial Place: ' . $row["burial_place"] . '
            Date Added:</strong> ' . $row["date_added"] . '
            
            (The application has been submitted successfully, kindly wait for the approvals through email!)';

            $mail->addAddress($email);

            if ($mail->send()) {
                echo "
                <script>
                document.location.href = '../apply.php';
                </script>
                ";
            } else {
                echo "Error: " . $mail->ErrorInfo;
            }
        } else {
            echo "Error: Email address is empty.";
        }
    } else {
        echo "Error: Unable to fetch email address.";
    }
} else {
    echo "Error: ID parameter not set.";
}
} else {
echo "Error: Database connection failed.";
}

mysqli_close($conn);
?>