<?php
require "connect.php";
if (!isset($_SESSION['auth_login'])) {
    header("location: customer/login.php");
    exit;
}

if (isset($_GET['reference_id'])) {
    $orderId = mysqli_real_escape_string($conn, $_GET['reference_id']);
    
    // Execute the query to fetch data using mysqli_query
    $query = "SELECT * FROM wedding WHERE reference_id = '$orderId' ORDER BY date_added";
    $result = mysqli_query($conn, $query);
    
    // Check if the query executed successfully
    if ($result) {
        // Fetch data
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        
        // Access the status after fetching data
        if (!empty($data) && isset($data[0]['status_id'])) {
            $status = $data[0]['status_id'];
            $date = $data[0]['date'];
            $reason = $data[0]['reason'];
        } else {
            // Handle the case where data is empty or status is not defined
            $status = 'Unknown';
            $date = 'Unknown';
            $reason = 'Unknown';
        }
    } else {
        // Handle query error
        echo "Error: " . mysqli_error($conn);
    }

    // Fetch date from notification_order table
    $query = "SELECT date_added FROM notification_client WHERE reference_id = '$orderId'";
    $result = mysqli_query($conn, $query);

    // Check if the query executed successfully
    if ($result) {
        // Fetch data
        $notification_dates = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $notification_dates[] = $row['date_added'];
        }
    } else {
        // Handle query error
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" />
    <title>View Orders - ICP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <style>
    /* PROCESS STEPS */
    @import url('https://fonts.googleapis.com/css?family=Muli&display=swap');

    :root {
        --line-border-fill: #007bff;
        --line-border-empty: #bdbdbd;
        --background-fill: #77b9ff;
    }

    * {
        box-sizing: border-box;
    }

    .process_steps {
        /* background-color: rgb(223, 255, 244); */
        font-family: 'Muli', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 20vh;
        overflow: hidden;
        margin: 0;
    }

    .container_progress {
        text-align: center;
    }

    .progress-container {
        display: flex;
        justify-content: space-between;
        position: relative;
        max-width: 100%;
        width: 900px;
        margin-bottom: 2.5em;
    }

    .progress-container::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        height: 10px;
        width: 100%;
        /* Changed from 350px to 100% */
        background-color: var(--line-border-empty);
        z-index: -1;
    }

    .progress_line {
        position: absolute;
        top: 50%;
        left: 0;
        width: 0;
        height: 10px;
        background-color: var(--line-border-fill);
        z-index: -1;
        transition: all .5s ease-in;
    }


    .step-text {
        color: transparent;
        /* Hide the text by default */
        position: absolute;
        bottom: -40px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 20px;
        width: 200px;
        font-weight: bold;
        transition: color 0.4s ease-in;
        /* Smooth transition when displaying the text */
    }

    .circle.active .step-text {
        color: #000000b2;
        /* Display the text when the circle is active */
    }

    .step-date {
        color: transparent;
        /* Hide the date by default */
        position: absolute;
        bottom: -60px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 15px;
        width: 200px;
        transition: color 0.4s ease-in;
        /* Smooth transition when displaying the date */
    }

    .circle.active .step-date {
        color: #00000078;
        /* Display the date when the circle is active */
    }


    .circle {
        position: relative;
        font-size: 50px;
        color: var(--line-border-empty);
        background-color: #fff;
        height: 120px;
        width: 120px;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 10px solid var(--line-border-empty);
        border-radius: 50%;
        transition: all .4s ease-in;
    }

    .circle.active {
        border-color: var(--line-border-fill);
        background-color: var(--background-fill);
        color: #fff;
        /* box-shadow: 0px 0px 31px -2px rgba(0, 105, 37, 0.62); */
    }

    .btn {
        /* padding: 1em 3em; */
        background-color: var(--line-border-fill);
        color: #fff;
        /* border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: .6em; */
    }

    /* 
    .btn:active {
        transform: scale(0.98);
    }

    .btn:disabled {
        background-color: var(--line-border-empty);
        cursor: not-allowed;
    } */

    .list-group-item.active {
        background: #ffc107;
    }

    /* end common class */


    /* end top status */

    ul.timeline {
        list-style-type: none;
        position: relative;
    }

    ul.timeline:before {
        content: ' ';
        background: #d4d9df;
        display: inline-block;
        position: absolute;
        left: 29px;
        width: 2px;
        height: 100%;
        z-index: 400;
    }

    ul.timeline>li {
        margin: 20px 0;
        padding-left: 30px;
    }

    ul.timeline>li:before {
        content: '\2713';
        background: #fff;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 0;
        left: 5px;
        width: 50px;
        height: 50px;
        z-index: 400;
        text-align: center;
        line-height: 50px;
        color: #d4d9df;
        font-size: 24px;
        border: 2px solid #d4d9df;
        display: none;
    }

    ul.timeline>li.active:before {
        content: '\2713';
        background: #007bff;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 0;
        left: 5px;
        width: 50px;
        height: 50px;
        z-index: 400;
        text-align: center;
        line-height: 50px;
        color: #fff;
        font-size: 30px;
        border: 2px solid #007bff;
    }

    .timeline p {
        visibility: hidden;
        margin-bottom: 0;

    }

    .timeline .text-muted {
        margin-bottom: 30px;
        font-size: 15px;

    }

    .timeline h6 {
        color: #666;
        visibility: hidden;
        margin-bottom: 0;
    }

    .timeline li.active p {
        visibility: visible;
        display: block;
    }

    .timeline li.active h6 {
        visibility: visible;
        display: block;
        color: #000;
        font-weight: 900;
    }

    /* end timeline */

    .back_button {
        display: block;
        width: 120px;
        margin-top: 10px;
        margin-left: 25px;
        padding: 10px 25px 10px 25px;
        border: 2px solid rgb(246, 246, 246);
        border-radius: 30px;
        background-color: green;
        text-decoration: none;
        color: rgb(255, 255, 255);
        text-align: center;
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.3),
            inset 0 -2px 3px rgba(0, 0, 0, 0.3);
        transition: 0.5s;
    }

    .back_button:hover {
        background-color: rgb(255, 255, 255);
        color: green;
    }


    .customer-reason {
        background-color: rgb(254 242 242);
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 20px;
        color: #F87171;
    }
    </style>
</head>
<?php include 'nav.php';?>

<body style=";background-color: green !important">

    <!-- <a class="btn btn-info btn-sm m-3" href=$data.php">Back to Orders</a> -->
    <br>
    <a class="back_button" href="view_services.php">
        <i class='bx bx-arrow-back' style='font-size:12px'></i>Back
    </a>
    <section class="">
        <div class="container">
            <div class="main-body">

                <button class="btn" id="prev" style="display: none;" disabled>Prev</button>
                <button class="btn" id="next" style="display: none;">Next</button>

                <!-- ORDER PROGRESS -->
                <div class="row">
                    <div class="col-lg">

                        <?php if ($status == 5): ?>
                        <div class="customer-reason">
                            <p><strong> Your Order #<?php echo $orderId; ?> has been Cancelled!</strong><br><strong>
                                    Reason:</strong> <?php echo $reason ?></p>
                        </div>
                        <?php endif; ?>

                        <?php if ($status != 5): ?>
                        <div class="card mb-5" style="background-color: #fff !important; z-index: -100;">
                            <div class="card-body">

                                <div class="top-status">
                                    <div style="display: flex; justify-content: space-between;">
                                        <h5 style="font-weight: 700;
                                                    margin: 0;
                                                    font-size: 17px;
                                                    background-color: rgb(239, 246, 255);
                                                    border-radius: 5px;
                                                    padding: 5px;
                                                    color: rgb(29 78 216 / 62%);">
                                            Application ID: <?php echo $orderId; ?></h5>

                                    </div>
                                    <script></script>
                                    <br>
                                    <div class="process_steps">
                                        <div class="container_progress">
                                            <div class="progress-container">
                                                <div class="progress_line"></div>
                                                <div class="circle active"><i class="	fas fa-clock"></i>
                                                    <span class="step-date">
                                                        <td><?php echo date('M d, Y g:ia', strtotime( $data[0]['date_added'])); ?>
                                                        </td>
                                                    </span>
                                                    <span class="step-text">To Process</span>
                                                </div>
                                                <div class="circle"><i class="fas fa-check-circle"></i>
                                                    <span class="step-date">
                                                        <?php if (!empty($notification_dates[0])) echo date('M d, Y g:ia', strtotime($notification_dates[0])); ?>
                                                    </span>
                                                    <span class="step-text">Approved</span>
                                                </div>
                                                <div class="circle"><i class="fa-solid fa-users-rectangle"></i></i>
                                                    <span class="step-date">
                                                        <?php if (!empty($notification_dates[1])) echo date('M d, Y g:ia', strtotime($notification_dates[1])); ?>
                                                    </span>
                                                    <span class="step-text">Banns Added</span>
                                                </div>
                                                <div class="circle"><i class="fas fa-check-double"></i>
                                                    <span class="step-date">
                                                        <?php if (!empty($notification_dates[2])) echo date('M d, Y g:ia', strtotime($notification_dates[2])); ?>
                                                    </span>
                                                    <span class="step-text">Completed</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">

                    <!-- PRODUCT DESCRIPTION -->
                    <div class="col-lg">
                        <div class="card">
                            <div class="card-body p-10">
                                <div style="display: flex; justify-content: space-between;">
                                    <h4 class="p-0 mb-10">Wedding Application Form</h4>
                                    <div class="form-group" style="display: none;">

                                        <?php
                             if ($status == 1) { ?>
                                        <button type="button" class="btn-sm btn-danger" data-toggle="modal"
                                            data-target="#declineModal_<?php echo $orderId; ?>">
                                            <i class="fas fa-times-circle"></i> Cancel
                                        </button>
                                        <?php } ?>
                                        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="right"
                                            title="Once You cancel your application it can't be undone"></i>
                                    </div>
                                </div>
                                <hr>
                                <form method="post" action="form_process/wedding_put.php" method="POST"
                                    enctype="multipart/form-data">
                                    <fieldset>

                                        <div class="form-row">
                                            <div class="form-group col-md">
                                                <label for="date">Preferred Date:</label>
                                                <input type="text" class="form-control"
                                                    value="<?= date('M d, Y', strtotime($data[0]["date"])) ?>" disabled>
                                            </div>
                                            <div class="form-group col-md">
                                                <label for="time">Preferred Time:</label>
                                                <input type="text" class="form-control"
                                                    value="<?= date('h:i a', strtotime($data[0]["time"])) ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md">
                                                <label for="complete_address">Complete Address:</label>
                                                <input type="text" class="form-control"
                                                    value="<?= $data[0]["complete_address"] ?>" disabled>
                                            </div>
                                            <?php if ($data[0]["permission"] === 'N/A'): ?>
                                            <div class="form-group col-md">
                                                <label for="permission">Permission Certificate:</label>
                                                <input type="text" class="form-control"
                                                    value="<?= $data[0]["permission"] ?>" disabled>
                                            </div>
                                            <?php else: ?>
                                            <div class="form-group col-md">
                                                <label for="permission">Permission Certificate:</label>
                                                <?php
                                                    $permissionPath = $data[0]["permission"];
                                                    $hiddenValue = str_repeat('Permission Certificate', 1);
                                                ?>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" value="<?= $hiddenValue ?>"
                                                        disabled>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button"
                                                            data-toggle="modal"
                                                            data-target="#permissionModal">View</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Permission Certificate Modal -->
                                            <div class="modal fade" id="permissionModal" tabindex="-1"
                                                aria-labelledby="permissionModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="permissionModalLabel">Permission
                                                                Certificate</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php
                                                                if (!empty($permissionPath)) {
                                                                    echo '<img src="' . htmlspecialchars($permissionPath, ENT_QUOTES, 'UTF-8') . '" alt="Permission Certificate" class="img-fluid">';
                                                                } else {
                                                                    echo '<p>No certificate available.</p>';
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php endif; ?>
                                        </div>
                                        <!-- Groom Information -->
                                        <div class="form-row">
                                            <div class="form-group col-md">
                                                <label for="groom_name">Groom's Name:</label>
                                                <input type="text" class="form-control"
                                                    value="<?= $data[0]["groom_name"] ?>" disabled>
                                            </div>
                                            <div class="form-group col-md">
                                                <label for="groom_age">Groom's Age:</label>
                                                <input type="number" class="form-control"
                                                    value="<?= $data[0]["groom_age"] ?>" disabled>
                                            </div>
                                            <div class="form-group col-md">
                                                <label for="groom_father_name">Groom's Father's Name:</label>
                                                <input type="text" class="form-control"
                                                    value="<?= $data[0]["groom_father_name"] ?>" disabled>
                                            </div>
                                            <div class="form-group col-md">
                                                <label for="groom_mother_name">Groom's Mother's Name:</label>
                                                <input type="text" class="form-control"
                                                    value="<?= $data[0]["groom_mother_name"] ?>" disabled>
                                            </div>
                                        </div>

                                        <!-- Bride Information -->
                                        <div class="form-row">
                                            <div class="form-group col-md">
                                                <label for="bride_name">Bride's Name:</label>
                                                <input type="text" class="form-control"
                                                    value="<?= $data[0]["bride_name"] ?>" disabled>
                                            </div>
                                            <div class="form-group col-md">
                                                <label for="bride_age">Bride's Age:</label>
                                                <input type="number" class="form-control"
                                                    value="<?= $data[0]["bride_age"] ?>" disabled>
                                            </div>
                                            <div class="form-group col-md">
                                                <label for="bride_father_name">Bride's Father's Name:</label>
                                                <input type="text" class="form-control"
                                                    value="<?= $data[0]["bride_father_name"] ?>" disabled>
                                            </div>
                                            <div class="form-group col-md">
                                                <label for="bride_mother_name">Bride's Mother's Name:</label>
                                                <input type="text" class="form-control"
                                                    value="<?= $data[0]["bride_mother_name"] ?>" disabled>
                                            </div>
                                        </div>
                                        <h4>Documents</h4>
                                        <hr>
                                        <div class="form-row">
                                            <!-- Groom's PSA Cenomar Photocopy -->
                                            <div class="form-group col-md">
                                                <label for="psa_cenomar_photocopy_groom">Groom's PSA Cenomar
                                                    Photocopy:</label>
                                                <i class="fa fa-question-circle" data-toggle="tooltip"
                                                    data-placement="right" title="Choose an image:(JPEG,PNG,GIF)"></i>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="PSA Cenomar Photocopy" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-toggle="modal"
                                                            data-target="#groomCenomarModal">View</button>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Bride's PSA Cenomar Photocopy -->
                                            <div class="form-group col-md">
                                                <label for="psa_cenomar_photocopy_bride">Bride's PSA Cenomar
                                                    Photocopy:</label>
                                                <i class="fa fa-question-circle" data-toggle="tooltip"
                                                    data-placement="right" title="Choose an image:(JPEG,PNG,GIF)"></i>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="PSA Cenomar Photocopy" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-toggle="modal"
                                                            data-target="#brideCenomarModal">View</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <!-- Groom's Baptismal Certificates -->
                                            <div class="form-group col-md">
                                                <label for="baptismal_certificates_groom">Groom's Baptismal
                                                    Certificates:</label>
                                                <i class="fa fa-question-circle" data-toggle="tooltip"
                                                    data-placement="right" title="Choose an image:(JPEG,PNG,GIF)"></i>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="Baptismal Certificates" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-toggle="modal"
                                                            data-target="#groomBaptismalModal">View</button>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Bride's Baptismal Certificates -->
                                            <div class="form-group col-md">
                                                <label for="baptismal_certificates_bride">Bride's Baptismal
                                                    Certificates:</label>
                                                <i class="fa fa-question-circle" data-toggle="tooltip"
                                                    data-placement="right" title="Choose an image:(JPEG,PNG,GIF)"></i>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="Baptismal Certificates" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-toggle="modal"
                                                            data-target="#brideBaptismalModal">View</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <!-- Groom's PSA Birth Certificate -->
                                            <div class="form-group col-md">
                                                <label for="psa_birth_certificate_photocopy_groom">Groom's PSA Birth
                                                    Certificate:</label>
                                                <i class="fa fa-question-circle" data-toggle="tooltip"
                                                    data-placement="right" title="Choose an image:(JPEG,PNG,GIF)"></i>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="PSA Birth Certificate" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-toggle="modal"
                                                            data-target="#groomBirthModal">View</button>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Bride's PSA Birth Certificate -->
                                            <div class="form-group col-md">
                                                <label for="psa_birth_certificate_photocopy_bride">Bride's PSA Birth
                                                    Certificate:</label>
                                                <i class="fa fa-question-circle" data-toggle="tooltip"
                                                    data-placement="right" title="Choose an image:(JPEG,PNG,GIF)"></i>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="PSA Birth Certificate" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-toggle="modal"
                                                            data-target="#brideBirthModal">View</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <!-- Groom's ID Picture -->
                                            <div class="form-group col-md">
                                                <label for="id_picture_groom">Groom's ID Picture:</label>
                                                <i class="fa fa-question-circle" data-toggle="tooltip"
                                                    data-placement="right"
                                                    title="The background color should be white, and the size should be 2 by 2 inches."></i>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" value="ID Picture" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-toggle="modal"
                                                            data-target="#groomIdModal">View</button>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Bride's ID Picture -->
                                            <div class="form-group col-md">
                                                <label for="id_picture_bride">Bride's ID Picture:</label>
                                                <i class="fa fa-question-circle" data-toggle="tooltip"
                                                    data-placement="right"
                                                    title="The background color should be white, and the size should be 2 by 2 inches."></i>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" value="ID Picture" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-toggle="modal"
                                                            data-target="#brideIdModal">View</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <!-- Confirmation Certificates -->
                                            <div class="form-group col-md">
                                                <label for="confirmation_certificates">Confirmation
                                                    Certificates:</label>
                                                <i class="fa fa-question-circle" data-toggle="tooltip"
                                                    data-placement="right" title="Choose an image:(JPEG,PNG,GIF)"></i>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="Confirmation Certificates" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-toggle="modal"
                                                            data-target="#confirmationModal">View</button>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Computerized Name of Sponsors/Entourage -->
                                            <div class="form-group col-md">
                                                <label for="computerized_name_of_sponsors">Computerized Name of
                                                    Sponsors/Entourage:</label>
                                                <i class="fa fa-question-circle" data-toggle="tooltip"
                                                    data-placement="right"
                                                    title="A list of sponsors in PDF form, that includes the entire entourage. These are the bridesmaids, groomsmen, and godparents."></i>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        value="Name of Sponsors/Entourage" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            data-toggle="modal"
                                                            data-target="#sponsorsModal">View</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Groom's PSA Cenomar Modal -->
                                        <div class="modal fade" id="groomCenomarModal" tabindex="-1"
                                            aria-labelledby="groomCenomarModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="groomCenomarModalLabel">Groom's PSA
                                                            Cenomar Photocopy</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                    $groomCenomarPath = $data[0]['psa_cenomar_photocopy_groom'];
                    if (!empty($groomCenomarPath)) {
                        echo '<img src="' . htmlspecialchars($groomCenomarPath, ENT_QUOTES, 'UTF-8') . '" alt="Groom\'s PSA Cenomar Photocopy" class="img-fluid">';
                    } else {
                        echo '<p>No photocopy available.</p>';
                    }
                ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bride's PSA Cenomar Modal -->
                                        <div class="modal fade" id="brideCenomarModal" tabindex="-1"
                                            aria-labelledby="brideCenomarModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="brideCenomarModalLabel">Bride's PSA
                                                            Cenomar Photocopy</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                    $brideCenomarPath = $data[0]['psa_cenomar_photocopy_bride'];
                    if (!empty($brideCenomarPath)) {
                        echo '<img src="' . htmlspecialchars($brideCenomarPath, ENT_QUOTES, 'UTF-8') . '" alt="Bride\'s PSA Cenomar Photocopy" class="img-fluid">';
                    } else {
                        echo '<p>No photocopy available.</p>';
                    }
                ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Groom's Baptismal Modal -->
                                        <div class="modal fade" id="groomBaptismalModal" tabindex="-1"
                                            aria-labelledby="groomBaptismalModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="groomBaptismalModalLabel">Groom's
                                                            Baptismal Certificates</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                    $groomBaptismalPath = $data[0]['baptismal_certificates_groom'];
                    if (!empty($groomBaptismalPath)) {
                        echo '<img src="' . htmlspecialchars($groomBaptismalPath, ENT_QUOTES, 'UTF-8') . '" alt="Groom\'s Baptismal Certificates" class="img-fluid">';
                    } else {
                        echo '<p>No certificate available.</p>';
                    }
                ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bride's Baptismal Modal -->
                                        <div class="modal fade" id="brideBaptismalModal" tabindex="-1"
                                            aria-labelledby="brideBaptismalModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="brideBaptismalModalLabel">Bride's
                                                            Baptismal Certificates</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                    $brideBaptismalPath = $data[0]['baptismal_certificates_bride'];
                    if (!empty($brideBaptismalPath)) {
                        echo '<img src="' . htmlspecialchars($brideBaptismalPath, ENT_QUOTES, 'UTF-8') . '" alt="Bride\'s Baptismal Certificates" class="img-fluid">';
                    } else {
                        echo '<p>No certificate available.</p>';
                    }
                ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Groom's Birth Certificate Modal -->
                                        <div class="modal fade" id="groomBirthModal" tabindex="-1"
                                            aria-labelledby="groomBirthModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="groomBirthModalLabel">Groom's PSA
                                                            Birth Certificate</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                    $groomBirthPath = $data[0]['psa_birth_certificate_photocopy_groom'];
                    if (!empty($groomBirthPath)) {
                        echo '<img src="' . htmlspecialchars($groomBirthPath, ENT_QUOTES, 'UTF-8') . '" alt="Groom\'s PSA Birth Certificate" class="img-fluid">';
                    } else {
                        echo '<p>No certificate available.</p>';
                    }
                ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bride's Birth Certificate Modal -->
                                        <div class="modal fade" id="brideBirthModal" tabindex="-1"
                                            aria-labelledby="brideBirthModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="brideBirthModalLabel">Bride's PSA
                                                            Birth Certificate</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                    $brideBirthPath = $data[0]['psa_birth_certificate_photocopy_bride'];
                    if (!empty($brideBirthPath)) {
                        echo '<img src="' . htmlspecialchars($brideBirthPath, ENT_QUOTES, 'UTF-8') . '" alt="Bride\'s PSA Birth Certificate" class="img-fluid">';
                    } else {
                        echo '<p>No certificate available.</p>';
                    }
                ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Groom's ID Picture Modal -->
                                        <div class="modal fade" id="groomIdModal" tabindex="-1"
                                            aria-labelledby="groomIdModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="groomIdModalLabel">Groom's ID
                                                            Picture</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                    $groomIdPath = $data[0]['id_picture_groom'];
                    if (!empty($groomIdPath)) {
                        echo '<img src="' . htmlspecialchars($groomIdPath, ENT_QUOTES, 'UTF-8') . '" alt="Groom\'s ID Picture" class="img-fluid">';
                    } else {
                        echo '<p>No ID picture available.</p>';
                    }
                ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bride's ID Picture Modal -->
                                        <div class="modal fade" id="brideIdModal" tabindex="-1"
                                            aria-labelledby="brideIdModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="brideIdModalLabel">Bride's ID
                                                            Picture</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                    $brideIdPath = $data[0]['id_picture_bride'];
                    if (!empty($brideIdPath)) {
                        echo '<img src="' . htmlspecialchars($brideIdPath, ENT_QUOTES, 'UTF-8') . '" alt="Bride\'s ID Picture" class="img-fluid">';
                    } else {
                        echo '<p>No ID picture available.</p>';
                    }
                ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Confirmation Certificates Modal -->
                                        <div class="modal fade" id="confirmationModal" tabindex="-1"
                                            aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="confirmationModalLabel">Confirmation
                                                            Certificates</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                    $confirmationPath = $data[0]['confirmation_certificates'];
                    if (!empty($confirmationPath)) {
                        echo '<img src="' . htmlspecialchars($confirmationPath, ENT_QUOTES, 'UTF-8') . '" alt="Confirmation Certificates" class="img-fluid">';
                    } else {
                        echo '<p>No certificate available.</p>';
                    }
                ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sponsors/Entourage Modal -->
                                        <div class="modal fade" id="sponsorsModal" tabindex="-1"
                                            aria-labelledby="sponsorsModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="sponsorsModalLabel">Computerized
                                                            Name of Sponsors/Entourage</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                    $sponsorsPath = $data[0]['computerized_name_of_sponsors'];
                    if (!empty($sponsorsPath)) {
                        echo '<embed src="' . htmlspecialchars($sponsorsPath, ENT_QUOTES, 'UTF-8') . '" type="application/pdf" width="100%" height="400px" />';
                    } else {
                        echo '<p>No PDF available.</p>';
                    }
                ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </fieldset>

                                    <div class="modal-footer">

                                    </div>
                                </form>
                            </div>
                        </div>


                        <!-- TIMELINE -->
                        <?php if ($status != 5): ?>
                        <div class="card mt-4">
                            <div class="card-body">
                                <h4>Timeline</h4>
                                <ul class="timeline">
                                    <li <?php if ($status >= 1) echo 'class="active"'; ?>>
                                        <h6>To Process</h6>
                                        <p>Your Application <strong
                                                style="color: #007bff"><?php echo $orderId; ?></strong>
                                            was submitted! and is currently under review by the admin.
                                        </p>
                                        <p class="text-muted">
                                            <?php echo date('M d, Y g:ia', strtotime($data[0]['date_added'])); ?></p>
                                    </li>
                                    <li <?php if ($status >= 2) echo 'class="active"'; ?>>
                                        <h6>Approved</h6>
                                        <p>Your Application <strong
                                                style="color: #007bff"><?php echo $orderId; ?></strong>
                                            was approved. The admin will notify you through text for the schedule of
                                            Dulog.</p>
                                        <p class="text-muted">
                                            <?php if (!empty($notification_dates[0])) echo date('M d, Y g:ia', strtotime($notification_dates[0])); ?>
                                    </li>
                                    <li <?php if ($status >= 3) echo 'class="active"'; ?>>
                                        <h6>Wedding Banns Added</h6>
                                        <p>Your Application <strong
                                                style="color: #007bff"><?php echo $orderId; ?></strong>
                                            has been added to the Wedding Banns, with a duration of 3 Sundays.
                                        </p>
                                        <p class="text-muted">
                                            <?php if (!empty($notification_dates[1])) echo date('M d, Y g:ia', strtotime($notification_dates[1])); ?>
                                    </li>
                                    <li <?php if ($status >= 4) echo 'class="active"'; ?>>
                                        <h6>COMPLETED</h6>
                                        <p>Your Application completed successfully!</p>
                                        <p class="text-muted">
                                            <?php if (!empty($notification_dates[2])) echo date('M d, Y g:ia', strtotime($notification_dates[2])); ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- END TIMELINE -->
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- MODAL DECLINE -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php if ($status == 1) { ?>
    <div class="modal fade" id="declineModal_<?php echo $orderId; ?>" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 1000px">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        REASON OF DECLINING (ID: <?php echo $orderId; ?>)
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="declineForm_<?php echo $orderId; ?>" action="wedding_decline.php" method="POST">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="reason">Reason:</label>
                                <select class="form-control" id="reason_<?php echo $orderId; ?>" name="reason">
                                    <option value="Incomplete or Inaccurate Information">Incomplete or Inaccurate
                                        Information</option>
                                    <option value="Documentation Issues">Documentation Issues</option>
                                    <option value="Scheduling Conflicts">Scheduling Conflicts</option>
                                    <option value="Failure to Comply with Church Policies">Failure to Comply with Church
                                        Policies</option>
                                    <option value="Issues with the Location or Venue">Issues with the Location or Venue
                                    </option>
                                    <option value="Concerns about the Purpose or Intent">Concerns about the Purpose or
                                        Intent</option>
                                    <option value="Overlapping Requests or Capacity Issues">Overlapping Requests or
                                        Capacity Issues</option>
                                    <option value="Unresolved Issues from Previous Interactions">Unresolved Issues from
                                        Previous Interactions</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md">
                            <label for="time">ID:</label>
                            <input type="text" class="form-control" value="<?= $orderId ?>" disabled>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md">
                                <label for="remarks">Remarks:</label>
                                <textarea rows="15" cols="50" class="form-control" id="remarks_<?php echo $orderId; ?>"
                                    name="remarks"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success"
                            onclick="declineWedding(event, <?php echo $orderId; ?>)">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php } ?>

    <script>
    function declineWedding(event, orderId) {
        event.preventDefault();

        var reason = $('#reason_' + orderId).val();
        var remarks = $('#remarks_' + orderId).val();

        $.ajax({
            url: 'wedding_decline.php',
            type: 'POST',
            dataType: 'json',
            data: {
                orderId: orderId,
                reason: reason,
                remarks: remarks
            },
            success: function(response) {
                if (response.status === 'success') {
                    $('#declineModal_' + orderId).modal('hide');
                    alert('Wedding order has been declined successfully.');
                    // Optionally, refresh the page or update the UI accordingly
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred while declining the wedding order: ' + error);
            }
        });
    }
    </script>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script>
    const status = <?php echo $status; ?>; // Pass PHP status variable to JavaScript

    // Hide or show the progress section based on the status
    const progressSection = document.querySelector(".process_steps");
    progressSection.style.display = status === 5 ? 'none' : 'flex';

    if (status !== 5) {
        const next = document.querySelector("#next");
        const prev = document.querySelector("#prev");
        const progress = document.querySelector(".progress_line");
        const circles = document.querySelectorAll(".circle");
        const totalSteps = circles.length;
        let currentStep = status; // Initialize currentStep with the status fetched from the database

        // Update progress steps based on currentStep
        updateProgress();

        next.addEventListener("click", () => {
            if (currentStep < totalSteps) {
                currentStep++;
                updateProgress();
            }
        });

        prev.addEventListener("click", () => {
            if (currentStep > 1) {
                currentStep--;
                updateProgress();
            }
        });

        function updateProgress() {
            circles.forEach((circle, index) => {
                if (index < currentStep) {
                    circle.classList.add("active");
                } else {
                    circle.classList.remove("active");
                }
            });

            if (currentStep === 1) {
                prev.disabled = true;
            } else if (currentStep === totalSteps) {
                next.disabled = true;
            } else {
                prev.disabled = false;
                next.disabled = false;
            }

            const progressWidth = ((currentStep - 1) / (totalSteps - 1)) * 100 + '%';
            progress.style.width = progressWidth;
            // Get the tracking number element
            var date = document.getElementById('tracking_number');

            if (!date) {
                console.error("Tracking number element not found!");
            } else {
                if (currentStep === 1 || currentStep === 2) {
                    date.style.display = 'none';
                } else if (currentStep === 5) {
                    date.style.display = 'block';
                    date.textContent = 'Cancelled';
                } else {
                    date.style.display = 'block';
                    date.textContent = 'J&T Tracking No. : <?php echo $date; ?>';
                }
            }
        }
    }
    </script>
    <?php include 'footer.php';?>
</body>
<script>
let copyText = document.querySelector(".copy-text");
copyText.querySelector("button").addEventListener("click", function() {
    let input = copyText.querySelector("input.text");
    input.select();
    document.execCommand("copy");
    copyText.classList.add("active");
    window.getSelection().removeAllRanges();
    setTimeout(function() {
        copyText.classList.remove("active");
    }, 2500);
});
</script>

</html>