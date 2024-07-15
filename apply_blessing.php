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
    <title>APPLY FOR BLESSING - ICP </title>
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
                <header>BLESSING FORM</header>
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
                    <form method="post" action="services_forms/form_process/blessing_put.php" method="POST"
                        enctype="multipart/form-data">


                        <div class="page slide-page">
                            <div class="title">Basic Info:</div>
                            <i>Note: We accommodated walk-ins for handheld belongings or items.</i>

                            <div class="field">
                                <label class="label" for="place">Place</label>
                                <div class="selectform">
                                    <select class="select" name="place" id="place" onchange="handlePlace()" required>
                                        <option value="" disabled selected hidden></option>
                                        <option value="House">House</option>
                                        <option value="Store">Store</option>
                                        <option value="Warehouse">Warehouse</option>
                                        <option value="Office">Office</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div id="otherPlaceContainer" style="display: none;">
                                <div class="field">
                                    <label class="label" for="otherPlace">Others, Please Specify</label>
                                    <input type="text" class="form-control" name="otherPlace" id="otherPlace">
                                </div>
                            </div>

                            <div class="field">
                                <label class="label" for="owner_name">Owner Name</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="owner_name" required>
                            </div>

                            <div class="field">
                                <label class="label" for="address">Current Address</label>
                                <select class="select" name="address" id="address" required onchange="checkOther(this)">
                                    <option value="" disabled selected hidden></option>
                                    <option value="Poblacion">Poblacion</option>
                                    <option value="San Roque">San Roque</option>
                                    <option value="Bunsuran 1st">Bunsuran 1st</option>
                                    <option value="Bunsuran 2nd">Bunsuran 2nd</option>
                                    <option value="Bunsuran 3rd">Bunsuran 3rd</option>
                                    <option value="Malibong Bata">Malibong Bata</option>
                                    <option value="Malibong Matanda">Malibong Matanda</option>
                                    <option value="Bagong Barrio">Bagong Barrio</option>
                                    <!-- <option value="other">Other</option> -->
                                </select>
                            </div>
                            <div id="completeAddress" style="display: none;">
                                <div class="field">
                                    <label class="label" for="complete_address">Complete Address</label>
                                    <input class="input" id="complete_address" name="complete_address" required>
                                </div>
                            </div>

                            <script>
                            function checkOther(select) {
                                var completeAddressInput = document.getElementById('completeAddress');
                                var addressInput = document.getElementById('address');

                                if (select.value === 'other') {
                                    otherAddressInput.style.display = 'block';
                                    completeAddressInput.style.display = 'none';
                                    addressInput.style.display = 'block';
                                } else {
                                    completeAddressInput.style.display = 'block';
                                    otherAddressInput.style.display = 'none';
                                }
                            }
                            </script>
                            <div class="field">
                                <button class="firstNext next">Next</button>
                            </div>
                        </div>
                        <div class="page">
                            <div class="title">Date and Time:</div>
                            <i>Note: The selected date and time could be under review for approval.</i>
                            <div class="field">
                                <div class="label">Preferred Date</div>
                                <?php
                                    date_default_timezone_set('Asia/Manila');
                                    $currentDate = date('Y-m-d');
                                ?>
                                <input type="date" class="form-control" name="date" id="date"
                                    min="<?php echo $currentDate; ?>" required onchange="fetchSchedule()">
                            </div>

                            <script>
                            function fetchSchedule() {
                                var selectedDate = document.getElementById('date').value;
                                var xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        var schedule = JSON.parse(this.responseText);

                                        var selectTime = document.getElementById('time');

                                        for (var i = 0; i < selectTime.options.length; i++) {
                                            selectTime.options[i].disabled = false;
                                        }

                                        for (var i = 0; i < schedule.length; i++) {
                                            var item = schedule[i];
                                            if (item.date === selectedDate && item.time !== "other") {
                                                var option = selectTime.querySelector("option[value='" + item.time +
                                                    "']");
                                                if (option) {
                                                    option.disabled = true;
                                                }
                                            }
                                        }
                                    }
                                };
                                xhr.open("GET", "scheduleDate.php?date=" + selectedDate, true);
                                xhr.send();
                            }
                            </script>
                            <div class="field">
                                <div class="label">Preferred Time</div>
                                <select class="select" name="time" id="time" required>
                                    <option value="" disabled selected hidden>Select a time</option>
                                    <option value="9:00 AM">9:00 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                </select>
                            </div>

                            <div class="field btns">
                                <button class="prev-2 prev">Previous</button>
                                <button class="next-2 next">Next</button>
                            </div>
                        </div>

                        <div class="page">
                            <div class="title">Contact:</div>
                            <div class="field">
                                <label class="label" for="contact_person">Contact Person</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="contact_person" required>
                            </div>

                            <div class="field">
                                <label class="label" for="contact_number">Contact Number</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="contact_number" maxlength="11" pattern="[0-9]{11}"
                                    title="Please enter a valid 11-digit contact number" required>
                            </div>
                            <div class="field btns">
                                <button class="prev-3 prev">Previous</button>
                                <button class="submit" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
</body>

</html>
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