<?php 
    require_once "connect.php";
    $is_customer_logged_in = isset($_SESSION['auth_login']);
?>
<?php
    if ( isset($_SESSION['auth_login']) ) {
		$auth = $_SESSION['auth_login'];
        $auth_full_name = $auth['first_name'] . $auth['last_name'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>APPLY FOR MASS - ICP </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="image/favicon.ico">
    <link rel="stylesheet" href="style/forms.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <a href="apply.php" class="back">
        < Back</a>
            <div class="container">
                <header>MASS FORM</header>
                <div class="progress-bar">
                    <div class="step">
                        <p></p>
                        <div class="bullet">
                            <span>1</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                    <div class="step">
                        <p></p>
                        <div class="bullet">
                            <span>2</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                    <div class="step">
                        <p></p>
                        <div class="bullet">
                            <span>3</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                </div>
                <div class="form-outer">
                    <form method="post" action="services_forms/form_process/mass_put.php" method="POST"
                        enctype="multipart/form-data">
                        <div class="page slide-page">
                            <div class="title">Basic Info:</div>
                            <div class="row">
                                <div class="form-row">
                                    <div class="field">
                                        <label class="label" for="purpose">Purpose</label>

                                        <div class="selectform">
                                            <select class="select" name="purpose" id="purpose" required>
                                                <option value="" disabled selected hidden></option>
                                                <option value="For Thanks Giving">For Thanks Giving</option>
                                                <option value="For Birthdays">For Birthdays</option>
                                                <option value="For the Soul">For the Soul</option>
                                                <option value="For the Healing">For the Healing</option>
                                                <option value="For the Healing">For the Fast Recovery</option>
                                                <option value="For the Safe Journey">For the Safe Trip</option>
                                                <option value="For Wedding Anniversary">For Wedding Anniversary</option>
                                                <option value="Special Intention">Special Intention</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label" for="name">Name of person requesting for prayer
                                        intention</label>
                                    <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="field">
                                <button class="firstNext next">Next</button>
                            </div>
                        </div>


                        <div class="page">
                            <div class="title">Date and Time:</div>
                            <i>Note: Please choose the day before your preferred mass date.</i>
                            <div class="field">
                                <label class="label" for="date">Choose start date of Mass</label>
                                <?php
                                    date_default_timezone_set('Asia/Manila');
                                    $tomorrow = date('Y-m-d', strtotime('+1 day'));
                                ?>
                                <input type="date" class="form-control" id="date" name="date"
                                    min="<?php echo $tomorrow; ?>" required onchange="updateTimeOptions()">
                            </div>

                            <div class="field">
                                <label class="label" for="time">Choose the time of Mass</label>
                                <div class="selectform">
                                    <select class="select" name="time" id="time" required>
                                        <option value="" disabled selected hidden>Select time</option>
                                    </select>
                                </div>
                            </div>

                            <script>
                            function updateTimeOptions() {
                                var dateSelect = new Date(document.getElementById('date').value);
                                var timeSelect = document.getElementById('time');

                                timeSelect.innerHTML = ''; // Clear existing options

                                console.log("Selected date: ", dateSelect);

                                // Check the day of the week (0 for Sunday, 1 for Monday, ..., 6 for Saturday)
                                var dayOfWeek = dateSelect.getDay();
                                console.log("Day of week: ", dayOfWeek);

                                if (dayOfWeek === 0) { // Sunday
                                    addOption(timeSelect, "6:00 AM");
                                    addOption(timeSelect, "7:30 AM");
                                    addOption(timeSelect, "5:00 PM");
                                } else if (dayOfWeek === 3) { // Wednesday
                                    addOption(timeSelect, "6:00 AM");
                                    addOption(timeSelect, "5:30 PM");
                                } else {
                                    // Default options
                                    addOption(timeSelect, "6:00 AM");
                                }
                            }

                            function addOption(selectElement, optionText) {
                                var option = document.createElement("option");
                                option.text = option.value = optionText;
                                selectElement.add(option);
                            }
                            </script>

                            <div class="field btns">
                                <button class="prev-1 prev">Previous</button>
                                <button class="next-1 next">Next</button>
                            </div>
                        </div>


                        <div class="page">
                            <div class="title">Payment:</div>
                            <div class="text">
                                <p class="label">Kindly follow these steps:</p>
                                <ul>
                                    <li>Open the GCash app.</li>
                                    <li>Choose "Send Money."</li>
                                    <li>Enter the GCash number: 0939-600-4981 (CHRISTIAN D.) or you can scan the QR Code
                                        below.</li>
                                    <li>Specify the payment amount.</li>
                                    <li>Confirm the donation.</li>
                                </ul>
                                <img src="image/qr.jpg" style="width: 300px;">
                            </div>
                            <div class="field">
                                <label class="label" for="hospital">Upload the reciept here</label>
                                <input type="file" class="form-control" name="reciept" required>
                            </div>

                            <div class="field btns">
                                <button class="prev-2 prev">Previous</button>
                                <button class="submit" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
</body>
<style>
.error-message {
    color: red;
    font-size: 12px;
    position: absolute;
    top: 100%;
    left: 0;
}
</style>

</html>
<script>
document.getElementById('date_started').addEventListener('change', function() {
    var startDate = this.value;
    document.getElementById('date_ended').min = startDate;
});


var modal = document.getElementById('myModal');
var modalImg = document.getElementById("img01");
var btn = document.getElementById("modalBtn");
var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
    modal.style.display = "block";
    modalImg.src = "image/gcash.jpg";
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script src="js/forms.js"></script>
<style>
:root {
    --primary: #017b36;
    --secondary: #017b36;
    --errorColor: red;
    --stepNumber: 3;
    --containerWidth: 1000px;
    --bgColor: #017b36;
    --inputBorderColor: lightgray;
}

.progress-bar .step .bullet:before,
.progress-bar .step .bullet:after {
    position: absolute;
    content: "";
    bottom: 11px;
    right: -306px;
    height: 3px;
    width: 305px;
    background: #017b36;
}
</style>