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
    <title>APPLY FOR BAPTISMAL - ICP </title>
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
                <header>BAPTISMAL FORM</header>
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
                    <form method="post" action="services_forms/form_process/baptismal_put.php" method="POST"
                        enctype="multipart/form-data">
                        <div class="page slide-page">
                            <div class="title">Child's Basic Info:</div>
                            <div class="field">
                                <label class="label" for="child_first_name">Pangalan</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="child_first_name"
                                    title="Please enter the name of the child" required>
                            </div>

                            <div class="field">
                                <label class="label" for="mother_maiden_lastname">Apelyido ng Ina (Dalaga)</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="mother_maiden_lastname" required>
                            </div>

                            <div class="field">
                                <label class="label" for="father_lastname">Apelyido ng Ama</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="father_lastname" required>
                            </div>
                            <div class="field">
                                <label class="label" for="birthdate">Petsa ng Kapanganakan</label>
                                <input type="date" class="form-control" name="birthdate" id="birthdate"
                                    onchange="calculateMonths()" required>
                            </div>

                            <div class="field">
                                <label class="label" for="months">Edad(Buwan)</label>
                                <input type="text"
                                    class="form-control" name="months" id="months" readonly required>
                            </div>
                            <div class="field">
                                <label class="label" for="birthplace">Lugar ng Kapanganakan</label>
                                <input type="text"
                                    class="form-control" name="birthplace" required>
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
                                    <label class="label" for="complete_address">Kumpletong Address</label>
                                    <input type="text"
                                        class="input" id="complete_address1" name="complete_address1">
                                </div>
                            </div>
                            <div id="otherAddress" style="display: none;">
                                <div class="field">
                                    <label class="label" for="complete_address">Kumpletong Address</label>
                                    <input type="text"
                                        class="input" id="complete_address2" name="complete_address2">
                                </div>
                                <div class="field">
                                    <label class="label" for="permission">Sertipiko ng pahintulot mula sa simbahang
                                        nasasakupan</label>
                                    <input type="file" id="permission" name="permission">
                                </div>
                            </div>

                            <script>
                            function checkOther(select) {
                                var completeAddress = document.getElementById('completeAddress');
                                var otherAddress = document.getElementById('otherAddress');
                                var completeAddressField = document.getElementById('complete_address1');
                                var otherAddressField = document.getElementById('complete_address2');
                                var permissionField = document.getElementById('permission');
                                var addressInput = document.getElementById('address');


                                if (select.value === 'other') {
                                    otherAddress.style.display = 'block';
                                    addressInput.style.display = 'block';
                                    completeAddress.style.display = 'none';
                                    permissionField.required = true;
                                    otherAddress.required = true;
                                    otherAddressField.required = true;
                                    // otherAddressField1.required = false;
                                    permissionField.value = null;
                                } else {
                                    completeAddress.style.display = 'block';
                                    otherAddress.style.display = 'none';
                                    completeAddressField.required = true;
                                    // otherAddressField2.required = false;
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
                            <div class="title">Date and Time:</div>
                            <i>Note: The selected date and time could be under review for approval.</i>
                            <div class="field">
                                <label class="label" for="date">Petsa ng Binyag: <i>(Walang binyag sa araw ng
                                        <strong>Lunes at Martes</strong>)</i></label>
                                <?php
                                    date_default_timezone_set('Asia/Manila');
                                    $currentDate = date('Y-m-d');
                                ?>
                                <input type="date" class="form-control" name="date" id="date"
                                    min="<?php echo $currentDate; ?>" required onchange="fetchBaptismSchedule()">
                            </div>
                            <script>
                            document.getElementById('date').addEventListener('change', function() {
                                var selectedDate = new Date(this.value);
                                var day = selectedDate.getDay(); // 0 is Sunday, 1 is Monday, ..., 6 is Saturday

                                if (day === 0) { // Sunday
                                    alert('Regular Baptism');
                                } else if (day === 1 || day === 2) { // Monday or Tuesday
                                    alert('Mondays and Tuesdays - NO baptisms for these days');
                                    this.value = ''; // Clear the input field
                                } else if (day >= 3 && day <= 6) { // Wednesday to Saturday
                                    alert('Special Baptism for approval');
                                }


                                var baptismTimeSelect = document.getElementById('time');
                                baptismTimeSelect.innerHTML =
                                    '<option value="" disabled selected hidden></option>';

                                if (day === 0) { // Sunday
                                    // For regular baptism on Sundays
                                    baptismTimeSelect.innerHTML += '<option value="10:30 AM">10:30 AM</option>';
                                } else {
                                    // For special baptism on other days
                                    baptismTimeSelect.innerHTML += '<option value="9:00 AM">9:00 AM</option>';
                                    baptismTimeSelect.innerHTML += '<option value="10:00 AM">10:00 AM</option>';
                                    baptismTimeSelect.innerHTML += '<option value="11:00 AM">11:00 AM</option>';
                                    baptismTimeSelect.innerHTML += '<option value="1:00 PM">1:00 PM</option>';
                                    baptismTimeSelect.innerHTML += '<option value="2:00 PM">2:00 PM</option>';
                                }
                            });
                            </script>
                            <script>
                            // Replace the existing fetchBaptismSchedule function with this modified version
                            function fetchBaptismSchedule() {
                                var selectedDate = document.getElementById('date').value;

                                // Convert the selected date to a JavaScript Date object
                                var date = new Date(selectedDate);

                                // Get the day of the week (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
                                var dayOfWeek = date.getUTCDay();

                                // Check if the day is from Monday (1) to Saturday (6)
                                if (dayOfWeek >= 1 && dayOfWeek <= 6) {
                                    // Send the selected date to the PHP script using AJAX
                                    var xhr = new XMLHttpRequest();
                                    xhr.open('POST', 'scheduleDates.php', true);
                                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                    xhr.onreadystatechange = function() {
                                        if (xhr.readyState === XMLHttpRequest.DONE) {
                                            if (xhr.status === 200) {
                                                // Parse the JSON response
                                                var scheduleData = JSON.parse(xhr.responseText);

                                                var timeSelect = document.getElementById('time');
                                                var options = timeSelect.getElementsByTagName('option');

                                                // Loop through each option
                                                for (var i = 0; i < options.length; i++) {
                                                    var option = options[i];
                                                    var optionValue = option.value;

                                                    // Check if the option value matches any schedule time
                                                    var isDisabled = scheduleData.some(function(item) {
                                                        return item.time === optionValue && item.date ===
                                                            selectedDate;
                                                    });

                                                    // Disable the option if it matches any schedule time
                                                    option.disabled = isDisabled;
                                                }
                                            } else {
                                                console.error('Error:', xhr.status);
                                            }
                                        }
                                    };
                                    xhr.send('selected_date=' + selectedDate);
                                } else {
                                    // Clear any previous selections and disable the time options
                                    var timeSelect = document.getElementById('time');
                                    var options = timeSelect.getElementsByTagName('option');
                                    for (var i = 0; i < options.length; i++) {
                                        options[i].disabled = true;
                                    }
                                    console.warn('Selected date is not between Monday and Saturday.');
                                }
                            }
                            </script>


                            <div class="field">
                                <label class="label" for="time">Oras ng Binyag</label>
                                <select class="select" name="time" id="time" required>
                                    <option value="" disabled selected hidden></option>
                                </select>
                            </div>


                            <div class="field btns">
                                <button class="prev-1 prev">Previous</button>
                                <button class="next-1 next">Next</button>
                            </div>
                        </div>
                        <div class="page">
                            <div class="title">Parents:</div>
                            <div class="field">
                                <label class="label" for="marriage">Kasal</label>
                                <select class="select" name="marriage" id="marriage" required>
                                    <option value="" disabled selected hidden></option>
                                    <option value="hindi">Hindi</option>
                                    <option value="oo">Oo</option>
                                </select>
                            </div>
                            <div class="field">
                                <label class="label" for="marriage_location">Saan Kinasal</label>
                                <input type="text" class="form-control" name="marriage_location" id="marriageLocation"
                                    required disabled>
                            </div>
                            <div class="field">
                                <label class="label" for="father_name">Pangalan ng Ama</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="father_name" required>
                            </div>
                            <div class="field">
                                <label class="label" for="father_origin_place">Lugar na Pinagmulan ng Ama</label>
                                <input type="text" class="form-control" name="father_origin_place" required>
                            </div>
                            <div class="field">
                                <label class="label" for="mother_maiden_fullname">Pangalan ng Ina sa Pagkadalaga</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="mother_maiden_fullname" required>
                            </div>
                            <div class="field">
                                <label class="label" for="mother_origin_place">Lugar na Pinagmulan ng Ina</label>
                                <input type="text" class="form-control" name="mother_origin_place" required>
                            </div>

                            <div class="field btns">
                                <button class="prev-2 prev">Previous</button>
                                <button class="next-2 next">Next</button>
                            </div>
                        </div>
                        <div class="page">
                            <div class="title">Godparents:</div>
                            <i>(Bawal ang palayaw at kailangan 16 anyos pataas lamang at binyagang katoliko)</i>
                            <div class="field">
                                <label class="label" for="godfather">Pangalan ng Ninong</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="godfather" required>
                            </div>
                            <div class="field">
                                <label class="label" for="godfather_age">Edad</label>
                                <input type="number" class="form-control" name="godfather_age" min="16" required>
                            </div>
                            <div class="field">
                                <label class="label" for="godfather_religion">Relihiyon</label>
                                <select class="select" name="godfather_religion" required>
                                    <option value="Roman Catholic">Roman Catholic</option>
                                </select>
                            </div>
                            <div class="field">
                                <label class="label" for="godfather_address">Tirahan</label>
                                <input type="text" class="form-control" name="godfather_address" required>
                            </div>
                            <div class="field">
                                <label class="label" for="godmother">Pangalan ng Ninang</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="godmother" required>
                            </div>
                            <div class="field">
                                <label class="label" for="godmother_age">Edad</label>
                                <input type="number" class="form-control" name="godmother_age" min="16" required>
                            </div>
                            <div class="field">
                                <label class="label" for="godmother_religion">Relihiyon</label>
                                <select class="select" name="godmother_religion" required>
                                    <option value="Roman Catholic">Roman Catholic</option>
                                </select>
                            </div>

                            <div class="field">
                                <label class="label" for="godmother_address">Tirahan</label>
                                <input type="text" class="form-control" name="godmother_address" required>
                            </div>

                            <div class="field btns">
                                <button class="prev-3 prev">Previous</button>
                                <button class="next-3 next">Next</button>
                            </div>
                        </div>

                        <div class="page">
                            <div class="title">Applicant Info:</div>
                            <div class="field">
                                <label class="label" for="client_name">Pangalan ng nagpalista</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="client_name" required>
                            </div>

                            <div class="field">
                                <label class="label" for="client_relationship">Relasyon ng nagpalista</label>
                                <input type="text"
                                    onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || event.charCode === 46 || event.charCode === 32"
                                    class="form-control" name="client_relationship" required>
                            </div>

                            <div class="field">
                                <label class="label" for="client_contact_number">Contact number</label>
                                <input type="text" class="form-control" name="client_contact_number" maxlength="11"
                                    pattern="[0-9]{11}" title="Please enter a valid 11-digit contact number" required>
                            </div>
                            <div class="field btns">
                                <button class="prev-4 prev">Previous</button>
                                <button class="next-4 next">Next</button>
                            </div>
                        </div>

                        <div class="page">
                            <div class="title">Documents:</div>
                            <div class="field">
                                <label class="label" for="copy_birth_certificate">Kopya ng Birth certificate</label>
                                <input type="file" class="form-control" name="copy_birth_certificate" required>
                            </div>

                            <div class="field">
                                <label class="label" for="copy_marriage_certificate">Kopya ng Marriage
                                    certificate</label>
                                <input type="file" class="form-control" name="copy_marriage_certificate" required>
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

</html>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var marriageSelect = document.getElementById("marriage");
    var marriageCertificateInput = document.querySelector('input[name="copy_marriage_certificate"]');

    function toggleMarriageCertificateField() {
        var marriageValue = marriageSelect.value;

        if (marriageValue === "hindi") {
            marriageCertificateInput.value = "N/A";
            marriageCertificateInput.setAttribute("disabled", "disabled");
        } else {
            marriageCertificateInput.removeAttribute("disabled");
            marriageCertificateInput.value = ""; // Clear the value if not disabled
        }
    }

    toggleMarriageCertificateField(); // Call the function initially to set the field state

    marriageSelect.addEventListener("change", toggleMarriageCertificateField);
});
</script>
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
<script>
//KASAL CONDITION
document.addEventListener("DOMContentLoaded", function() {
    var marriageSelect = document.getElementById("marriage");
    var marriageLocationInput = document.getElementById("marriageLocation");

    function setMarriageLocation() {
        if (marriageSelect.value === "hindi") {
            marriageLocationInput.value = "N/A";
            marriageLocationInput.setAttribute("disabled", "disabled");
        } else {
            marriageLocationInput.removeAttribute("disabled");
        }
    }
    setMarriageLocation();
    marriageSelect.addEventListener("change", setMarriageLocation);
});
//BAPTISMAL AGE
function calculateMonths() {
    var birthdate = document.getElementById('birthdate').value;
    if (birthdate) {
        var currentDate = new Date();
        var birthDate = new Date(birthdate);

        var ageInMonths = (currentDate.getFullYear() - birthDate.getFullYear()) * 12 +
            (currentDate.getMonth() - birthDate.getMonth());
        document.getElementById('months').value = ageInMonths;
    }
}
var today = new Date();
var yyyy = today.getFullYear();
var mm = String(today.getMonth() + 1).padStart(2, '0');
var dd = String(today.getDate()).padStart(2, '0');

var maxDate = yyyy + '-' + mm + '-' + dd;
document.getElementById('birthdate').max = maxDate;

function validateAge(inputId) {
    var ageInput = document.getElementById(inputId);
    var enteredAge = parseInt(ageInput.value, 10);

    if (enteredAge < 16) {
        alert("Age must be 16 or above.");
        ageInput.value = "";
    }
}
//FILES
document.getElementById('copy_birth_certificate').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    document.getElementById('fileLabel').innerText = fileName;
});
document.getElementById('copy_marriage_certificate').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    document.getElementById('fileLabel').innerText = fileName;
});
</script>