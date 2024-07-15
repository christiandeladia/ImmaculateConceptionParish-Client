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
    <title>APPLY FOR WEDDING - ICP </title>
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
                <header>WEDDING FORM</header>
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
                    <div class="step">
                        <p></p>
                        <div class="bullet">
                            <span>5</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                    <div class="step">
                        <p></p>
                        <div class="bullet">
                            <span>6</span>
                        </div>
                        <div class="check fas fa-check"></div>
                    </div>
                </div>

                <div class="form-outer">
                    <form method="post" action="services_forms/form_process/wedding_put.php" method="POST"
                        enctype="multipart/form-data">

                        <div class="page slide-page">
                            <div class="title">Groom's Basic Info:</div>
                            <div class="field">
                                <label class="label" for="groom_name">Groom's Fullname</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" id="label" name="groom_name" required>
                            </div>

                            <div class="field">
                                <label class="label" for="groom_age">Groom's Age</label>
                                <input type="number" class="form-control" id="groom_age" name="groom_age" required
                                    oninput="this.value = this.value.replace(/e/g, '');">
                            </div>
                            <div class="field">
                                <label class="label" for="groom_father_name">Groom's Father Fullname</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" id="groom_father_name" name="groom_father_name" required>
                            </div>
                            <div class="field">
                                <label class="label" for="groom_mother_name">Groom's Mother Fullname</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" id="groom_mother_name" name="groom_mother_name" required>
                            </div>
                            <div class="field">
                                <button class="firstNext next">Next</button>
                            </div>
                        </div>

                        <div class="page">
                            <div class="title">Bride's Basic Info:</div>
                            <div class="field">

                                <label class="label" for="bride_name">Bride's Fullname</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" id="bride_name" name="bride_name" required>
                            </div>
                            <div class="field">
                                <label class="label" for="bride_age">Bride's Age</label>
                                <input type="number" class="form-control" id="bride_age" name="bride_age" required
                                    oninput="this.value = this.value.replace(/e/g, '');">
                            </div>
                            <div class="field">
                                <label class="label" for="bride_father_name">Bride's Father Fullname</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" id="bride_father_name" name="bride_father_name" required>
                            </div>
                            <div class="field">
                                <label class="label" for="bride_mother_name">Bride's Mother Fullname</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" id="bride_mother_name" name="bride_mother_name" required>
                            </div>
                            <div class="field btns">
                                <button class="prev-1 prev">Previous</button>
                                <button class="next-1 next">Next</button>
                            </div>
                        </div>

                        <div class="page">
                            <div class="title">Date and Time:</div>
                            <i>Note: The selected date and time could be under review for approval.</i>

                            <div class="field">
                                <div class="label">Preferred Date <i>(preparation must be at least 1 month)</i></div>
                                <?php
                                    date_default_timezone_set('Asia/Manila');
                                    $currentDate = date('Y-m-d');
                                    $preferredDate = date('Y-m-d', strtotime($currentDate . ' +30 days'));
                                ?>
                                <input type="date" class="form-control" name="date" id="date"
                                    min="<?php echo $preferredDate; ?>" required onchange="fetchSchedule()">
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
                            <div class="title">Address:</div>
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
                                    <input type="text" class="input" id="complete_address1" name="complete_address1">
                                </div>
                            </div>
                            <div id="otherAddress" style="display: none;">
                                <div class="field">
                                    <label class="label" for="complete_address">Complete Address</label>
                                    <input type="text" class="input" id="complete_address2" name="complete_address2">
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

                            <div class="field btns">
                                <button class="prev-2 prev">Previous</button>
                                <button class="next-2 next">Next</button>
                            </div>
                        </div>


                        <div class="page">
                            <div class="title">Documents 1:</div>
                            <div class="col-md-6">
                                <div class="field">
                                    <label class="label" for="psa_cenomar_photocopy_groom">Groom's PSA Cenomar
                                        Photocopy</label>
                                    <input type="file" class="form-control-file" id="psa_cenomar_photocopy_groom"
                                        name="psa_cenomar_photocopy_groom" required>
                                </div>
                                <div class="field">
                                    <label class="label" for="baptismal_certificates_groom">Groom's Baptismal
                                        Certificates</label>
                                    <input type="file" class="form-control-file" id="baptismal_certificates_groom"
                                        name="baptismal_certificates_groom" required>
                                </div>
                                <div class="field">
                                    <label class="label" for="psa_birth_certificate_photocopy_groom">Groom's PSA Birth
                                        Certificate</label>
                                    <input type="file" class="form-control-file"
                                        id="psa_birth_certificate_photocopy_groom"
                                        name="psa_birth_certificate_photocopy_groom" required>
                                </div>
                                <div class="field">
                                    <label class="label" for="id_picture_groom">Groom's ID Picture</label>
                                    <input type="file" class="form-control-file" id="id_picture_groom"
                                        name="id_picture_groom" required>
                                </div>
                                <div class="field">
                                    <label class="label" for="confirmation_certificates">Confirmation
                                        Certificates</label>
                                    <input type="file" class="form-control-file" id="confirmation_certificates"
                                        name="confirmation_certificates" required>
                                </div>
                            </div>
                            <div class="field btns">
                                <button class="prev-3 prev">Previous</button>
                                <button class="next-3 next">Next</button>
                            </div>
                        </div>

                        <div class="page">
                            <div class="title">Documents 2:</div>
                            <div class="col-md-6">
                                <div class="field">
                                    <label class="label" for="psa_cenomar_photocopy_bride">Bride's PSA Cenomar
                                        Photocopy</label>
                                    <input type="file" class="form-control-file" id="psa_cenomar_photocopy_bride"
                                        name="psa_cenomar_photocopy_bride" required>
                                </div>
                                <div class="field">
                                    <label class="label" for="psa_birth_certificate_photocopy_bride">Bride's PSA Birth
                                        Certificate</label>
                                    <input type="file" class="form-control-file"
                                        id="psa_birth_certificate_photocopy_bride"
                                        name="psa_birth_certificate_photocopy_bride" required>
                                </div>
                                <div class="field">
                                    <label class="label" for="baptismal_certificates_bride">Bride's Baptismal
                                        Certificates</label>
                                    <input type="file" class="form-control-file" id="baptismal_certificates_bride"
                                        name="baptismal_certificates_bride" required>
                                </div>

                                <div class="field">
                                    <label class="label" for="id_picture_bride">Bride's ID Picture</label>
                                    <input type="file" class="form-control-file" id="id_picture_bride"
                                        name="id_picture_bride" required>
                                </div>

                                <div class="field">
                                    <label class="label" for="computerized_name_of_sponsors">Computerized Name of
                                        Sponsors/Entourage</label>
                                    <input type="file" class="form-control-file" id="computerized_name_of_sponsors"
                                        name="computerized_name_of_sponsors" required>
                                </div>
                            </div>
                            <div class="field btns">
                                <button class="prev-4 prev">Previous</button>
                                <button class="next-4 next">Next</button>
                            </div>
                        </div>

                        <div class="page">
                            <div class="title">Fees:</div>
                            <div class="text">
                                <p class="label"><i>(to be paid and processed over the counter)</i></p>
                                <ul>
                                    <li><strong>Marriage Fee: ₱2,250.00</strong>
                                        <ul>
                                            <li>Mass</li>
                                            <li>Electricity</li>
                                            <li>Marriage Contract Registration Fee</li>
                                            <li><b>OPTIONAL:</b>
                                                <ul>
                                                    <li>Choir ₱500.00</li>
                                                    <li>Carpet ₱500.00</li>
                                                    <li>Candle ₱400.00</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="field btns">
                                <button class="prev-5 prev">Previous</button>
                                <button class="submit" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            if (this.files[0].size > 3 * 1024 *
                1024) { // Check if file size is greater than 3MB
                alert('File size exceeds the limit of 3MB. Please select a smaller file.');
                this.value = ''; // Reset the file input
            }
        });
    });
});
</script>

</html>
<script src="js/forms.js"></script>
<style>
:root {
    --primary: #017b36;
    --secondary: #017b36;
    --errorColor: red;
    --stepNumber: 6;
    --containerWidth: 1000px;
    --bgColor: #017b36;
    --inputBorderColor: lightgray;
}

.progress-bar .step .bullet:before,
.progress-bar .step .bullet:after {
    position: absolute;
    content: "";
    bottom: 11px;
    right: -141px;
    height: 3px;
    width: 140px;
    background: #017b36;
}
</style>