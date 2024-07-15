<?php
require "connect.php";
if (!isset($_SESSION['auth_login'])) {
    header("location: customer/login.php");
    exit;
}

if (isset($_GET['reference_id'])) {
    $orderId = mysqli_real_escape_string($conn, $_GET['reference_id']);
    
    // Execute the query to fetch data using mysqli_query
    $query = "SELECT * FROM sickcall WHERE reference_id = '$orderId' ORDER BY date_added";
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
            $date = $data[0]['date_added'];
            $reason = $data[0]['reason'];
            $remarks = $data[0]['remarks'];
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
    <title>View Orders Sick Call - ICP</title>
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
        padding: 1em 3em;
        background-color: var(--line-border-fill);
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: .6em;
    }

    .btn:active {
        transform: scale(0.98);
    }

    .btn:disabled {
        background-color: var(--line-border-empty);
        cursor: not-allowed;
    }

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

                        <?php if ($status == 4): ?>
                        <div class="customer-reason">
                            <p><strong> Your Order #<?php echo $orderId; ?> has been Cancelled!</strong><br><strong>
                                    Reason:</strong> <?php echo $reason ?></p>
                        </div>
                        <?php endif; ?>

                        <?php if ($status != 4): ?>
                        <div class="card mb-4" style="background-color: #fff !important; z-index: -100;">
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
                                                <div class="circle"><i class="fas fa-check-double"></i>
                                                    <span class="step-date">
                                                        <?php if (!empty($notification_dates[1])) echo date('M d, Y g:ia', strtotime($notification_dates[1])); ?>
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
                                <h4 class="p-0 mb-10">Sick Call Application Form</h4>
                                
                                </div><hr>
                                <form method="post" action="form_process/wedding_put.php" method="POST"
                        enctype="multipart/form-data">
                        <fieldset>

                        <div class="form-row">
                <div class="form-group col-md">
                    <label for="<?= $data[0]["patients_name"] ?>">Patient's Name:</label>
                    <input type="text" class="form-control" value="<?= $data[0]["patients_name"] ?>" disabled>
                </div>

                <div class="form-group col-md">
                    <label for="age">Age:</label>
                    <input type="number" class="form-control" value="<?= $data[0]["age"] ?>" disabled>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" value="<?= $data[0]["address"] ?>" disabled>
                </div>

                <div class="form-group col-md">
                    <label for="complete_address">Complete Address:</label>
                    <input type="text" class="form-control" value="<?= $data[0]["complete_address"] ?>" disabled>
                </div>
            </div>

            <div class="form-row">
            <div class="form-group col-md">
                    <label for="urgent">It is urgent?</label>
                    <input type="text" class="form-control" value="<?= $data[0]["urgent"] ?>" disabled>
                </div>
                <div class="form-group col-md">
                    <label for="illness">Illness:</label>
                    <input type="text" class="form-control" value="<?= $data[0]["illness"] ?>" disabled>
                </div>
                <div class="form-group col-md">
                    <label for="can_eat">Can Eat:</label>
                    <input type="text" class="form-control" value="<?= $data[0]["can_eat"] ?>" disabled>
                    </select>
                </div>

                <div class="form-group col-md">
                    <label for="can_speak">Can Speak:</label>
                    <input type="text" class="form-control" value="<?= $data[0]["can_speak"] ?>" disabled>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md">
                    <label for="contact_person">Contact Person:</label>
                    <input type="text" class="form-control" value="<?= $data[0]["contact_person"] ?>" disabled>
                </div>

                <div class="form-group col-md">
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" class="form-control" value="<?= $data[0]["contact_number"] ?>" maxlength="11"
                        pattern="[0-9]{11}" title="Please enter a valid 11-digit contact number" disabled>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md">
                    <label for="date">Date:</label>
                    <input type="text" class="form-control" value="<?= date('M d, Y', strtotime($data[0]["date"])) ?>"
                        disabled>

                </div>

                <div class="form-group col-md">
                    <label for="time">Time:</label>
                    <input type="text" class="form-control" value="<?= date('h:i a', strtotime($data[0]["time"])) ?>"
                        disabled>
                </div>
            </div>

                        </fieldset>

                    </form>
                            </div>
                        </div>


                        <!-- TIMELINE -->
                        <?php if ($status != 4): ?>
                        <div class="card mt-4">
                            <div class="card-body">
                                <h4>Timeline</h4>
                                <ul class="timeline">
                                    <li <?php if ($status >= 1) echo 'class="active"'; ?>>
                                        <h6>To Process</h6>
                                        <p>Your Application <strong style="color: #007bff"><?php echo $orderId; ?></strong>
                                        was submitted! and is currently under review by the admin.
                                        </p>
                                        <p class="text-muted">
                                            <?php echo date('M d, Y g:ia', strtotime($data[0]['date_added'])); ?></p>
                                    </li>
                                    <li <?php if ($status >= 2) echo 'class="active"'; ?>>
                                        <h6>Approved</h6>
                                        <p>Your Application <strong style="color: #007bff"><?php echo $orderId; ?></strong>
                                        was approved. The admin will set a schedule for you, kindly wait for an email</p>
                                        <p class="text-muted">
                                            <?php if (!empty($notification_dates[0])) echo date('M d, Y g:ia', strtotime($notification_dates[0])); ?>
                                    </li>
                                    <li <?php if ($status >= 3) echo 'class="active"'; ?>>
                                        <h6>COMPLETED</h6>
                                        <p>Your Application completed successfully!</p>
                                        <p class="text-muted">
                                            <?php if (!empty($notification_dates[1])) echo date('M d, Y g:ia', strtotime($notification_dates[1])); ?>
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
copyText.querySelector("button").addEventListener("click", function () {
	let input = copyText.querySelector("input.text");
	input.select();
	document.execCommand("copy");
	copyText.classList.add("active");
	window.getSelection().removeAllRanges();
	setTimeout(function () {
		copyText.classList.remove("active");
	}, 2500);
});

</script>
</html>