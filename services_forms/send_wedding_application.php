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
$sql = mysqli_query($conn, "SELECT * FROM `wedding` WHERE `id` = $id");
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


$mail->Subject = 'Wedding Application';
$mail->Body    = '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background: linear-gradient(#93C572, #FFFFFF);">
<div style="background-color: #008000; text-align: center; padding: 10px;">
    <img src="https://res.cloudinary.com/dqtbveriz/image/upload/v1711791868/logo_white_lio37e.png" alt="Sample Logo" style="display: inline-block; max-width: 200px;">
</div>
<h2 style="color: #333333; font-size: 24px; font-weight: bold; text-align: center;">Wedding Application Submitted Successfully</h2>
            <p style="font-size: 16px;"><strong>Reference Number:</strong> ' . $row["reference_id"] . '</p>
            <p style="font-size: 16px;"><strong>Psa Cenomar Photocopy Groom:</strong> ' . $row["psa_cenomar_photocopy_groom"] . '</p>
            <p style="font-size: 16px;"><strong>Psa Cenomar Photocopy Bride:</strong> ' . $row["psa_cenomar_photocopy_bride"] . '</p>
            <p style="font-size: 16px;"><strong>Baptismal Certificates Groom:</strong> ' . $row["baptismal_certificates_groom"] . '</p>
            <p style="font-size: 16px;"><strong>Baptismal_Certificates_Bride:</strong> ' . $row["baptismal_certificates_bride"] . '</p>
            <p style="font-size: 16px;"><strong>Psa Birthcertificate Photocopy Groom:</strong> ' . $row["psa_birth_certificate_photocopy_groom"] . '</p>
            <p style="font-size: 16px;"><strong>Psa Birthcertificate Photocopy Bride:</strong> ' . $row["psa_birth_certificate_photocopy_bride"] . '</p>
            <p style="font-size: 16px;"><strong>Id Picture Groom:</strong> ' . $row["id_picture_groom"] . '</p>
            <p style="font-size: 16px;"><strong>Id Picture Bride:</strong> ' . $row["id_picture_bride"] . '</p>
            <p style="font-size: 16px;"><strong>Computerized Name of Sponsors:</strong> ' . $row["computerized_name_of_sponsors"] . '</p>
            <p style="font-size: 16px;"><strong>Groom Name:</strong> ' . $row["groom_name"] . '</p>
            <p style="font-size: 16px;"><strong>Groom Age:</strong> ' . $row["groom_age"] . '</p>
            <p style="font-size: 16px;"><strong>Groom Father Name:</strong> ' . $row["groom_father_name"] . '</p>
            <p style="font-size: 16px;"><strong>Groom Mother Name:</strong> ' . $row["groom_mother_name"] . '</p>
            <p style="font-size: 16px;"><strong>Bride Name:</strong> ' . $row["bride_name"] . '</p>
            <p style="font-size: 16px;"><strong>Bride Age:</strong> ' . $row["bride_age"] . '</p>
            <p style="font-size: 16px;"><strong>Bride Father Name:</strong> ' . $row["bride_father_name"] . '</p>
            <p style="font-size: 16px;"><strong>Bride Mother Name:</strong> ' . $row["bride_mother_name"] . '</p>
            <p style="font-size: 16px;"><strong>Date Added:</strong> ' . $row["date_added"] . '</p>
            <p style="font-size: 16px;">(The application has been submitted successfully, kindly wait for the approvals through email!)</p>';
$mail->AltBody = 'Application Submitted Successfully
            Reference Number: ' . $row["reference_id"] . '
            Psa Cenomar Photocopy Groom: ' . $row["psa_cenomar_photocopy_groom"] . '
            Psa Cenomar Photocopy Bride: ' . $row["psa_cenomar_photocopy_bride"] . '
            Baptismal Certificates Groom: ' . $row["baptismal_certificates_groom"] . '
            Baptismal_Certificates_Bride: ' . $row["baptismal_certificates_bride"] . '
            Psa Birthcertificate Photocopy Groom: ' . $row["psa_birth_certificate_photocopy_groom"] . '
            Id Picture Groom: ' . $row["id_picture_groom"] . '
            Id Picture Bride: ' . $row["id_picture_bride"] . '
            Computerized Name of Sponsors: ' . $row["computerized_name_of_sponsors"] . '
            Groom Name: ' . $row["groom_name"] . '
            Groom Age: ' . $row["groom_age"] . '
            Groom Father Name: ' . $row["groom_father_name"] . '
            Groom Mother Name: ' . $row["groom_mother_name"] . '
            Bride Name: ' . $row["bride_name"] . '
            Bride Age: ' . $row["bride_age"] . '
            Bride Father Name: ' . $row["bride_father_name"] . '
            Bride Mother Name: ' . $row["bride_mother_name"] . '
            Date Added: ' . $row["date_added"] . '
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
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Error: ID parameter not set.";
}
} else {
echo "Error: Database connection failed.";
}

mysqli_close($conn);
?>