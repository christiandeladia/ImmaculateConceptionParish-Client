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
$sql = mysqli_query($conn, "SELECT * FROM `binyag_request_certificate` WHERE `id` = $id");
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


$mail->Subject = 'Baptismal Certificate';
$mail->Body    = '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background: linear-gradient(#93C572, #FFFFFF);">
<div style="background-color: #008000; text-align: center; padding: 10px;">
    <img src="https://res.cloudinary.com/dqtbveriz/image/upload/v1711791868/logo_white_lio37e.png" alt="Sample Logo" style="display: inline-block; max-width: 200px;">
</div>
<h2 style="color: #333333; font-size: 24px; font-weight: bold; text-align: center;">Baptismal Request Certificate Submitted Successfully</h2>
            <p style="font-size: 16px;"><strong>Reference Number:</strong> ' . $row["reference_id"] . '</p>
            <p style="font-size: 16px;"><strong>Full Name:</strong> ' . $row["fullname"] . '</p>
            <p style="font-size: 16px;"><strong>Birthdate:</strong> ' . $row["birthdate"] . '</p>
            <p style="font-size: 16px;"><strong>Birthplace:</strong> ' . $row["birthplace"] . '</p>
            <p style="font-size: 16px;"><strong>Father\'s Full Name:</strong> ' . $row["father_fullname"] . '</p>
            <p style="font-size: 16px;"><strong>Mother\'s Maiden Name:</strong> ' . $row["mother_maidenname"] . '</p>
            <p style="font-size: 16px;"><strong>Purpose:</strong> ' . $row["purpose"] . '</p>
            <p style="font-size: 16px;">(The Request has been submitted successfully, kindly wait for the approvals through email!)</p>';
$mail->AltBody = 'Request Submitted Submitted Successfully
            Reference Number: ' . $row["reference_id"] . '
            Full Name: ' . $row["fullname"] . '
            Birthdate: ' . $row["birthdate"] . '
            Birthplace: ' . $row["birthplace"] . '
            Father\'s Full Name: ' . $row["father_fullname"] . '
            Mother\'s Maiden Name: ' . $row["mother_maidenname"] . '
            Purpose: ' . $row["purpose"] . '
            (The Request has been submitted successfully, kindly wait for the approvals through email!)';

            $mail->addAddress($email);

            if ($mail->send()) {
                echo "
                <script>
                document.location.href = '../request.php';
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