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
    <title>APPLY FOR FUNERAL - ICP </title>
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
                <header>FUNERAL FORM</header>
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
                    <div class="step">
                        <p></p>
                        <div class="bullet">
                            <span>4</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>

                </div>
                <div class="form-outer">
                    <form method="post" action="services_forms/form_process/funeral_put.php" method="POST"
                        enctype="multipart/form-data">

                        <div class="page slide-page">
                            <div class="title">Deceased's Basic Info:</div>
                            <div class="field">
                                <label class="label" for="deceased_fullname">Deceased Full Name</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="deceased_fullname" required>
                            </div>

                            <div class="field">
                                <label class="label" for="age">Age</label>
                                <input type="number" class="form-control" name="age" required>
                            </div>

                            <div class="field">
                                <label class="label" for="date_of_death">Date of Death</label>
                                <input type="date" class="form-control" name="date_of_death" id="date_of_death"
                                    onchange="calculateMonths()" required max="<?= date('Y-m-d'); ?>">
                            </div>
                            <div class="field">
                                <label class="label" for="cause_of_death">Cause of Death</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="cause_of_death" required>
                            </div>
                            <div class="field">
                                <label class="label" for="address">Kasalukuyang Tirahan</label>
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
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div id="completeAddress" style="display: none;">
                                <div class="field">
                                    <label class="label" for="complete_address">Complete Address</label>
                                    <input type="text" id="complete_address1" name="complete_address1">
                                </div>
                            </div>
                            <div id="otherAddress" style="display: none;">
                                <div class="field">
                                    <label class="label" for="complete_address">Complete Address</label>
                                    <input type="text" id="complete_address2" name="complete_address2">
                                </div>
                                <div class="field">
                                    <label class="label" for="permission">Permission Certificate from your
                                        Church</label>
                                    <input type="file" id="permission" name="permission">
                                </div>
                            </div>

                            <script>
                            function checkOther(select) {
                                var completeAddressInput = document.getElementById('completeAddress');
                                var addressInput = document.getElementById('address');
                                var otherAddressInput = document.getElementById('otherAddress');
                                var otherAddressField1 = document.getElementById('complete_address1');
                                var otherAddressField2 = document.getElementById('complete_address2');
                                var permissionField = document.getElementById('permission');

                                if (select.value === 'other') {
                                    otherAddressInput.style.display = 'block';
                                    addressInput.style.display = 'block';
                                    completeAddressInput.style.display = 'none';
                                    permissionField.required = true;
                                    otherAddressInput.required = true;
                                    otherAddressField2.required = true;
                                    otherAddressField1.required = false;
                                    permissionField.value = null;
                                } else {
                                    completeAddressInput.style.display = 'block';
                                    otherAddressInput.style.display = 'none';
                                    otherAddressField1.required = true;
                                    otherAddressField2.required = false;
                                    permissionField.required = false;
                                    permissionField.value = 'N/A';
                                }
                            }
                            </script>
                            <div class="field">
                                <button class="firstNext next">Next</button>
                            </div>
                        </div>

                        <div class="page">
                            <div class="title">Family:</div>
                            <div class="field">
                                <label class="label" for="civil_status">Civil Status</label>
                                <select class="select" name="civil_status" id="civil_status" required>
                                    <option value="" disabled selected hidden></option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                </select>
                            </div>

                            <div class="field">
                                <label class="label" for="spouse_name">Spouse Name</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="spouse_name" id="spouse_name" disabled>
                            </div>

                            <div class="field">
                                <label class="label" for="number_of_child">Number of Children</label>
                                <input type="number" class="form-control" name="number_of_child" id="number_of_child"
                                    disabled>
                            </div>
                            <div class="field">
                                <label class="label" for="mother_name">Mother's Name</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="mother_name" required>
                            </div>

                            <div class="field">
                                <label class="label" for="father_name">Father's Name</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="father_name" required>
                            </div>
                            <div class="field btns">
                                <button class="prev-1 prev">Previous</button>
                                <button class="next-1 next">Next</button>
                            </div>
                        </div>
                        <div class="page">
                            <div class="title">Mass:</div>
                            <div class="field">
                                <label class="label" for="has_sacrament">Has Sacrament</label>
                                <select class="select" name="has_sacrament" required>
                                    <option value="" disabled selected hidden></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="field">
                                <label class="label" for="burial_place">Burial Place</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="burial_place" required>
                            </div>
                            <div class="field">
                                <label class="label" for="allowed_to_mass">Allowed to Mass</label>
                                <select class="select" name="allowed_to_mass" required>
                                    <option value="" disabled selected hidden></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="field">
                                <label class="label" for="mass_location">Mass Location</label>
                                <input type="text" class="form-control" name="mass_location" required>
                            </div>

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
                            <div class="title">Applicant Info:</div>
                            <div class="field">
                                <label class="label" for="client_name">Client Name</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="client_name" required>
                            </div>

                            <div class="field">
                                <label class="label" for="relationship">Relationship</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="relationship" required>
                            </div>
                            <div class="field">
                                <label class="label" for="contact_number">Contact number</label>
                                <input type="text" class="form-control" name="contact_number" maxlength="11"
                                    pattern="[0-9]{11}" title="Please enter a valid 11-digit contact number" required>
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
    --stepNumber: 4;
    --containerWidth: 1000px;
    --bgColor: #017b36;
    --inputBorderColor: lightgray;
}

.progress-bar .step .bullet:before,
.progress-bar .step .bullet:after {
    position: absolute;
    content: "";
    bottom: 11px;
    right: -221px;
    height: 3px;
    width: 220px;
    background: #017b36;
}
</style>
<script>

</script>