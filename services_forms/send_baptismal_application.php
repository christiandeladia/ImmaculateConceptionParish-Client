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
    $sql = mysqli_query($conn, "SELECT * FROM `binyag` WHERE `id` = $id");
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


    $mail->Subject = 'Baptismal Application Thank youu..';
    $mail->Body    = '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background: linear-gradient(#93C572, #FFFFFF);">
    <div style="background-color: #008000; text-align: center; padding: 10px;">
        <img src="https://res.cloudinary.com/dqtbveriz/image/upload/v1711791868/logo_white_lio37e.png" alt="Sample Logo" style="display: inline-block; max-width: 200px;">
    </div>
    <h2 style="color: #333333; font-size: 24px; font-weight: bold; text-align: center;">Baptismal Application Submitted Successfully</h2>
                <p style="font-size: 16px;"><strong>Reference Number:</strong> ' . $row["reference_id"] . '</p>
                <p style="font-size: 16px;"><strong>Child First Name:</strong> ' . $row["child_first_name"] . '</p>
                <p style="font-size: 16px;"><strong>Mother Maiden  Last Name:</strong> ' . $row["mother_maiden_lastname"] . '</p>
                <p style="font-size: 16px;"><strong>Father Last Name:</strong> ' . $row["father_lastname"] . '</p>
                <p style="font-size: 16px;"><strong>Birthdate:</strong> ' . $row["birthdate"] . '</p>
                <p style="font-size: 16px;"><strong>Months:</strong> ' . $row["months"] . '</p>
                <p style="font-size: 16px;"><strong>Marriage Location:</strong> ' . $row["marriage_location"] . '</p>
                <p style="font-size: 16px;"><strong>Birthplace:</strong> ' . $row["birthplace"] . '</p>
                <p style="font-size: 16px;"><strong>Baptismal Date:</strong> ' . $row["baptismal_date"] . '</p>
                <p style="font-size: 16px;"><strong>Father Name:</strong> ' . $row["father_name"] . '</p>
                <p style="font-size: 16px;"><strong>Father Origin Place:</strong> ' . $row["father_origin_place"] . '</p>
                <p style="font-size: 16px;"><strong>Mother Maiden FullName:</strong> ' . $row["mother_maiden_fullname"] . '</p>
                <p style="font-size: 16px;"><strong>Mother Origin Place:</strong> ' . $row["mother_origin_place"] . '</p>
                <p style="font-size: 16px;"><strong>Current Address:</strong> ' . $row["current_address"] . '</p>
                <p style="font-size: 16px;"><strong>God Father:</strong> ' . $row["godfather"] . '</p>
                <p style="font-size: 16px;"><strong>God Father Age:</strong> ' . $row["godfather_age"] . '</p>
                <p style="font-size: 16px;"><strong>God Father Religion:</strong> ' . $row["godfather_religion"] . '</p>
                <p style="font-size: 16px;"><strong>God Father Address:</strong> ' . $row["godfather_address"] . '</p>
                <p style="font-size: 16px;"><strong>God Mother:</strong> ' . $row["godmother"] . '</p>
                <p style="font-size: 16px;"><strong>God Mother Age:</strong> ' . $row["godmother_age"] . '</p>
                <p style="font-size: 16px;"><strong>God Mother Religion:</strong> ' . $row["godmother_religion"] . '</p>    
                <p style="font-size: 16px;"><strong>God Mother Addess:</strong> ' . $row["godmother_address"] . '</p>
                <p style="font-size: 16px;"><strong>Client Name:</strong> ' . $row["client_name"] . '</p>
                <p style="font-size: 16px;"><strong>Client Relationship:</strong> ' . $row["client_relationship"] . '</p>
                <p style="font-size: 16px;"><strong>Copy of Birth Certificate:</strong> ' . $row["copy_birth_certificate"] . '</p>
                <p style="font-size: 16px;"><strong>Copy marriage Certificate:</strong> ' . $row["copy_marriage_certificate"] . '</p>
                <p style="font-size: 16px;"><strong>Date Added:</strong> ' . $row["date_added"] . '</p>



                <p style="font-size: 16px;">(The application has been submitted successfully, kindly wait for the approvals through email!)</p>';
    $mail->AltBody = 'Application Submitted Successfully
                Reference Number: ' . $row["reference_id"] . '</p>
                Child First Name: ' . $row["child_first_name"] . '
                Mother Maiden  Last Name: ' . $row["mother_maiden_lastname"] . '
                Father Last Name: ' . $row["father_lastname"] . '
                Birthdate: ' . $row["birthdate"] . '
                >Months: ' . $row["months"] . '
                Marriage Location: ' . $row["marriage_location"] . '
                Birthplace: ' . $row["birthplace"] . '
                Baptismal Date: ' . $row["baptismal_date"] . '
                Father Name: ' . $row["father_name"] . '
                Father Origin Place: ' . $row["father_origin_place"] . '
                Mother Maiden FullName: ' . $row["mother_maiden_fullname"] . '
                Mother Origin Place: ' . $row["mother_origin_place"] . '
                Current Address: ' . $row["current_address"] . '
                God Father: ' . $row["godfather"] . '
                God  Father Age: ' . $row["godfather_age"] . '
                God Father Religion: ' . $row["godfather_religion"] . '
                God Father Address: ' . $row["godfather_address"] . '
                God Father Address: ' . $row["godfather_address"] . '
                God Mother: ' . $row["godmother"] . '
                God Mother Age: ' . $row["godmother_age"] . '
                God Mother Religion: ' . $row["godmother_religion"] . '
                God Mother Addess: ' . $row["godmother_address"] . '
                Client Name: ' . $row["client_name"] . '
                Client Relationship: ' . $row["client_relationship"] . '
                Copy of Birth Certificate: ' . $row["copy_birth_certificate"] . '
                Copy marriage Certificate: ' . $row["copy_marriage_certificate"] . '
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