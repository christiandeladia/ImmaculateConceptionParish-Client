<?php
require "connect.php";
if (!isset($_SESSION['auth_login'])) {
    header("location: login.php");
    exit;
}
$auth = $_SESSION['auth_login'];
$auth_id = $auth['id'];
$cart_name = 'cart-' . $auth_id . '-cart';

# Create cart
if (!isset($_SESSION[$cart_name])) {
    $_SESSION[$cart_name] = [];
}

# Get orders
$sql = "SELECT * FROM `address` WHERE `customer_id` = ? ORDER BY date_added DESC;";
$stmt = $pdo->prepare($sql);
$stmt->execute([$auth_id]);
$address = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Count the total number of orders
$totalAddress = count($address);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>MODAL-CHECKOUT - ICP</title>
    <link rel="icon" type="image/x-icon" href="image/favicon.ico">
    <link rel="stylesheet" href="style/nav.css">
    <link rel="stylesheet" href="style/checkout.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<style>
/* html {
    box-sizing: border-box;
    height: 100%;
}

*,
*:before,
*:after {
    box-sizing: inherit;
}

body {
    font-size: 1em;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
    color: #566270;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-top: 20vh;
    background-size: cover;
    background-repeat: no-repeat;
    background: #ff7473;
    background: linear-gradient(to top right, #ff7473, #ffc952);
} */

h1 {
    padding-bottom: 1rem;
    color: #FFFFF3;
    font-size: 3rem;
}

h2 {
    margin: 0;
}

/*****************/
/* BUTTON STYLES */
/*****************/

.button {
    /* display: flex;
    align-items: center;
    justify-content: center; */
    margin: 0.8rem;
    padding: 0.4rem 0.8rem;
    cursor: pointer;
    transition: all 60ms ease-in-out;
    text-align: center;
    white-space: nowrap;
    text-decoration: none;
    appearance: none;
    line-height: 1.3;
    font-weight: 500;
    text-transform: capitalize;
    ;
    color: #4a4a4a;
    background-color: #f2f2f2;
    border: 0 none;
    border-radius: 3px;
}

.button:hover {
    transition: all 60ms ease;
    opacity: .85;
}

.button:active {
    text-decoration: none;
    transition: all 60ms ease;
    transform: scale(0.97);
    opacity: .75;
}

.button:visited {
    text-decoration: none;
}

.button.good {
    color: #FFFFF3;
    background: green;
}

.button.green {
    color: #FFFFF3;
    background: #258d36;
}


.button.button-bordered {
    color: #FFFFF3;
    border: 2px solid #FFFFF3;
    background: transparent;
}

.button.button-bordered:hover,
.button.button-bordered:active {
    color: #ff7473;
    border-color: #FFFFF3;
    background: #FFFFF3;
}

/*************/
/*   MODAL   */
/*************/
/* The Modal (background) */

.modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 1;
    /* Sit on top */
    left: 0;
    top: 0;
    width: 100%;
    /* Full width */
    height: 100%;
    /* Full height */
    overflow: hidden;
    /* Enable scroll if needed */
    /* background-color: #A593E0; */
    /* Black w/ opacity */
    transition: all 0.5s ease 0.06s;
}


/* Modal Content/Box */

.modal-content {
    background-color: #fff;
    margin: 1% auto;
    /* 15% from the top and centered */
    padding: 1rem;
    width: 40%;
    /* Could be more or less, depending on screen size */
    visibility: hidden;
    box-shadow: 2px 2px 10px 0px rgba(99, 106, 119, 0.6);
    border-radius: 5px;
}


/* The Close Button */

.close {
    color: #dedede;
    /*float: right;*/
    font-size: 2rem;
    font-weight: bold;
    display: flex;
    align-items: center;
}

.close:before {
    content: "Close";
    font-size: 1rem;
    display: none;
    text-decoration: none;
    align-self: center;
    margin-top: 0.2rem;
    font-weight: 400;
}

.close:hover:before {
    display: initial;
    color: #dedede;
}

.close:hover,
.close:focus {
    color: hsl(0, 100%, 70%);
    text-decoration: none;
    cursor: pointer;
}

.close:active,
.close:before:active {
    transition: all 60ms ease;
    transform: scale(0.97);
}


/***********************/
/*  modal form layout  */
/***********************/

.modal-content {
    display: flex;
    flex-direction: column;
}

.modal-header {
    display: flex;
    flex-direction: row-reverse;
    justify-content: space-between;
    align-items: center;
    font-size: 18px;
    font-weight: bold;
    border-bottom: 1px solid;
}

.modal-footer {
    display: flex;
    flex-direction: row-reverse;
    justify-content: space-between;
    align-items: center;
    font-size: 18px;
    font-weight: bold;

}



.modal-form {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}


.slideDown {
    animation-name: slideDown;
    -webkit-animation-name: slideDown;
    animation-duration: 0.6s;
    -webkit-animation-duration: 0.6s;
    animation-timing-function: ease;
    -webkit-animation-timing-function: ease;
    visibility: visible !important;
}

@keyframes slideDown {
    0% {
        transform: translateY(-100%);
    }

    50% {
        transform: translateY(4%);
    }

    65% {
        transform: translateY(-2%);
    }

    80% {
        transform: translateY(2%);
    }

    95% {
        transform: translateY(-1%);
    }

    100% {
        transform: translateY(0%);
    }
}


/* RADIO BUTTONS */
.radio-inputs {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    max-width: 350px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.radio-inputs>* {
    margin: 6px;
}

.radio-input:checked+.radio-tile {
    border-color: #2260ff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    color: #2260ff;
}

.radio-input:checked+.radio-tile:before {
    transform: scale(1);
    opacity: 1;
    background-color: #2260ff;
    border-color: #2260ff;
}

.radio-input:checked+.radio-tile .radio-icon svg {
    fill: #2260ff;
}

.radio-input:checked+.radio-tile .radio-label {
    color: #2260ff;
}

.radio-input:focus+.radio-tile {
    border-color: #2260ff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1), 0 0 0 4px #b5c9fc;
}

.radio-input:focus+.radio-tile:before {
    transform: scale(1);
    opacity: 1;
}

.radio-tile {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 500px;
    min-height: 80px;
    border-radius: 0.5rem;
    border: 2px solid #b5bfd9;
    background-color: #fff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    transition: 0.15s ease;
    cursor: pointer;
    position: relative;
    padding: 5px;
}

.radio-tile button {
    /* margin-left: auto; */
    margin-top: 5px;
    margin-right: 5px;
    color: #FFFFF3;
    background-color: #dc3545;
    border-color: #dc3545;
    border-radius: 3px;
    cursor: pointer;
    padding: 3px 10px;
}

.radio_button {
    display: flex;
    flex-direction: row;
    position: relative;
    left: 195px;
}

.radio-tile:before {
    content: "";
    position: absolute;
    display: block;
    width: 0.75rem;
    height: 0.75rem;
    border: 2px solid #b5bfd9;
    background-color: #fff;
    border-radius: 50%;
    top: 0.25rem;
    left: 0.25rem;
    opacity: 0;
    transform: scale(0);
    transition: 0.25s ease;
}

.radio-tile:hover {
    border-color: #2260ff;
}

.radio-tile:hover:before {
    transform: scale(1);
    opacity: 1;
}

.radio-icon svg {
    width: 2rem;
    height: 2rem;
    fill: #494949;
}

.radio-label {
    color: #707070;
    transition: 0.375s ease;
    text-align: center;
    font-size: 13px;
}

.radio-input {
    clip: rect(0 0 0 0);
    -webkit-clip-path: inset(100%);
    clip-path: inset(100%);
    height: 1px;
    overflow: hidden;
    position: absolute;
    white-space: nowrap;
    width: 1px;
}

.address-modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    background-color: rgba(0, 0, 0, 0.5);
}

.address-modal-content {
    background-color: #fff;
    margin: 8% auto;
    padding: 1rem;
    width: 40%;
    border-radius: 5px;
    position: relative;
}
</style>
<style>
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
</style>
<?php include 'nav.php';?>

<body>
    <br>
    <a class="back_button" href="checkout.php">
        <i class='bx bx-arrow-back' style='font-size:12px'></i>Back
    </a>
    <!-- <a class="back_button" href="javascript:void(0);" onclick="goBack()">
        <i class='bx bx-arrow-back' style='font-size:12px'></i>Back
    </a>
    <script>
    function goBack() {
        window.history.back();
    }
    </script> -->

    <div class="modal-content slideDown">

        <div class="modal-header">
            <span style="visibility: hidden;">&times;</span>
            <h2>Address Selection(<?php echo $totalAddress ?>)</h2>
            <button class="add_address button green" id="add_address"><i class="fas fa-plus"></i>  Add</button>
        </div>

        <div class="modal-body" style="max-height: 450px; overflow-y: auto; width: 100%;">
            <form action="checkout.php" class="modal-form" method="post">
                <!-- Adjusted action to point to checkout.php -->
                <br>
                <div class="radio-inputs">
                    <?php foreach ($address as $row) { ?>
                    <label>
                        <input class="radio-input" type="radio" name="selected_address"
                            value="<?php echo htmlspecialchars(json_encode($row)); ?>">
                        <!-- Added htmlspecialchars for security -->
                        <span class="radio-tile">
                            <span class="radio_button">
                                <button style="visibility:hidden;" id="modal-button_<?php echo $row['id']; ?>"
                                    onclick="editAddress(<?php echo $row['id']; ?>)">Edit</button>
                                <button id="modal-button_<?php echo $row['id']; ?>"
                                    onclick="deleteAddress(<?php echo $row['id']; ?>)"><i class="fas fa-trash-alt"></i></button>
                            </span>
                            <span class="radio-label">
                                <strong><?php echo $row['id']; ?> <?php echo htmlspecialchars($row['first_name']); ?>
                                    <?php echo htmlspecialchars($row['last_name']); ?></strong> |
                                <?php echo htmlspecialchars($row['mobile_number']); ?>
                            </span>
                            <span class="radio-label"><?php echo htmlspecialchars($row['street']); ?>,
                                <?php echo htmlspecialchars($row['barangay']); ?></span>
                            <span class="radio-label"><?php echo htmlspecialchars($row['city']); ?>,
                                <?php echo htmlspecialchars($row['province']); ?>,
                                <?php echo htmlspecialchars($row['region']); ?>,
                                <?php echo htmlspecialchars($row['zip_code']); ?></span>
                        </span>
                    </label>
                    <?php } ?>
                </div>
</div>

                <div class="modal-footer">
                    <input type="submit" class="button good" value="Save">
                </div>
            </form>
        </div>
    </div>



        <!-- ADD Address modal -->
        <div id="addressModal" class="address-modal">
            <div class="address-modal-content">
                <div class="modal-header">
                    <span class="close" id="closeAddressModal">&times;</span>
                    <h2>Add Delivery Address</h2>
                </div>
                <div class="container">
                    <div class="form-wapper">

                        <div class="form-body">
                            <form method="POST" action="address/add_address.php">
                                <div class="input-wrapper">
                                    <div class="select-wrapper">
                                        <label for="first_name">First name</label>
                                        <input id="first_name" type="text" name="first_name"
                                            placeholder="Enter First name" required autocomplete="given-name">
                                    </div>
                                    <div class="select-wrapper">
                                        <label for="last_name">Last name</label>
                                        <input id="last_name" type="text" name="last_name" placeholder="Enter Last name"
                                            required autocomplete="family-name">
                                    </div>
                                </div>
                                <div class="input-wrapper">
                                    <div class="select-wrapper">
                                        <label for="mobile_number">Mobile Number</label>
                                        <input type="tel" id="mobile_number" name="mobile_number"
                                            placeholder="09*********" pattern="[0-9]{11}" required autocomplete="tel">
                                    </div>
                                    <div class="select-wrapper">
                                        <label for="zip_code">Zip Code</label>
                                        <input id="zip_code" type="text" name="zip_code" placeholder="Enter Zip Code"
                                            required autocomplete="postal-code">
                                    </div>
                                </div>
                                <div class="input-wrapper">
                                    <div class="select-wrapper">
                                        <label for="region">Region</label>
                                        <select class="dropdown_address" name="region" id="region"
                                            autocomplete="region">
                                        </select>
                                        <input type="hidden" class="form-control form-control-md" name="region_text"
                                            id="region-text" required>
                                    </div>
                                    <div class="select-wrapper">
                                        <label for="province">Province</label>
                                        <select class="dropdown_address" name="province" id="province"
                                            autocomplete="region">
                                        </select>
                                        <input type="hidden" class="form-control form-control-md" name="province_text"
                                            id="province-text" required>
                                    </div>
                                </div>
                                <div class="input-wrapper">
                                    <div class="select-wrapper">
                                        <label for="city">City/Municipality</label>
                                        <select class="dropdown_address" name="city" id="city"
                                            autocomplete="address-level2">
                                        </select>
                                        <input type="hidden" class="form-control form-control-md" name="city_text"
                                            id="city-text" required>
                                    </div>
                                    <div class="select-wrapper">
                                        <label for="barangay">Barangay</label>
                                        <select class="dropdown_address" name="barangay" id="barangay"
                                            autocomplete="address-level3">
                                        </select>
                                        <input type="hidden" class="form-control form-control-md" name="barangay_text"
                                            id="barangay-text" required>
                                    </div>
                                </div>
                                <div class="input-wrapper">
                                    <label for="street">House No. and Street</label>
                                    <input id="street" type="text" name="street" placeholder="Enter Street" required
                                        autocomplete="street-address">
                                </div>
                                <div class="input-wrapper">
                                    <label for="shipping_fee">Shipping Fee</label>
                                    <input id="shipping_fee" type="number" name="shipping_fee"  readonly>
                                </div>
                                <input type="hidden" value="true" name="cart_checkout" />
                                <div class="address_button">
                                    <button class="delete_address_button">CANCEL</button>
                                    <input type="submit" class="save_address_button" value="Save">
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>


        <!-- UPDATE Address Modal -->
        <?php foreach ($address as $row) { ?>
        <div id="editdataModal_<?php echo $row['id']; ?>" class="modal">
            <div class="address-modal-content">
                <div class="modal-header">
                    <span class="close" id="closeAddressModal">&times;</span>
                    <h2>Update Delivery Address</h2>
                </div>
                <div class="container">
                    <div class="form-wapper">

                        <div class="form-body">
                            <form method="POST" action="address/update_address.php">
                                <div class="input-wrapper">
                                    <div class="select-wrapper">
                                        <label for="first_name">First name</label>
                                        <input id="first_name" type="text" name="first_name"
                                            placeholder="Enter First name" value="<?php echo $row['first_name']; ?>"
                                            required>
                                    </div>
                                    <div class="select-wrapper">
                                        <label for="last_name">Last name</label>
                                        <input id="last_name" type="text" name="last_name" placeholder="Enter Last name"
                                            value="<?php echo $row['last_name']; ?>" required>
                                    </div>
                                </div>
                                <div class="input-wrapper">
                                    <div class="select-wrapper">
                                        <label for="mobile_number">Mobile Number</label>
                                        <input type="tel" id="mobile_number" name="mobile_number"
                                            placeholder="09*********" value="<?php echo $row['mobile_number']; ?>"
                                            pattern="[0-9]{11}" required>
                                    </div>
                                    <div class="select-wrapper">
                                        <label for="zip_code">Zip Code</label>
                                        <input id="zip_code" type="text" name="zip_code" placeholder="Enter Zip Code"
                                            value="<?php echo $row['zip_code']; ?>" required>
                                    </div>
                                </div>
                                <div class="input-wrapper">
                                    <div class="select-wrapper">
                                        <label for="region">Region</label>
                                        <select class="dropdown_address" name="region" id="region">
                                        </select>
                                        <input type="hidden" class="form-control form-control-md" name="region_text"
                                            id="region-text" value="<?php echo $row['region']; ?>" required>
                                    </div>
                                    <div class="select-wrapper">
                                        <label for="province">Province</label>
                                        <select class="dropdown_address" name="province" id="province">
                                        </select>
                                        <input type="hidden" class="form-control form-control-md" name="province_text"
                                            id="province-text" value="<?php echo $row['province']; ?>" required>
                                    </div>
                                </div>
                                <div class="input-wrapper">
                                    <div class="select-wrapper">
                                        <label for="city">City/Municipality</label>
                                        <select class="dropdown_address" name="city" id="city">
                                        </select>
                                        <input type="hidden" class="form-control form-control-md" name="city_text"
                                            id="city-text" value="<?php echo $row['city']; ?>" required>
                                    </div>
                                    <div class="select-wrapper">
                                        <label for="barangay">Barangay</label>
                                        <select class="dropdown_address" name="barangay" id="barangay">
                                        </select>
                                        <input type="hidden" class="form-control form-control-md" name="barangay_text"
                                            id="barangay-text" value="<?php echo $row['barangay']; ?>" required>
                                    </div>
                                </div>
                                <div class="input-wrapper">
                                    <label for="street">Street</label>
                                    <input id="street" type="text" name="street" placeholder="Enter Street"
                                        value="<?php echo $row['street']; ?>" required>
                                </div>


                                <input type="hidden" value="true" name="cart_checkout" />
                                <div class="address_button">
                                    <button class="delete_address_button">CANCEL</button>
                                    <input type="submit" class="save_address_button" value="Save">
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php } ?>



</body>
<?php include 'footer.php';?>
<script src="address/address_selector.js"></script>
<script>
const addressModal = document.getElementById('addressModal');
const addButton = document.querySelectorAll('.add_address');
const closeAddressModal = document.getElementById('closeAddressModal');

// Function to open address editing modal
const openAddressModal = function() {
    addressModal.style.display = "block";
};

// Function to close address editing modal
const closeAddressModalFunction = function() {
    addressModal.style.display = "none";
};

// Add click event listeners for "Edit" buttons
for (let i = 0; i < addButton.length; i++) {
    addButton[i].addEventListener('click', openAddressModal, false);
}

// Close address editing modal when close button is clicked
closeAddressModal.addEventListener('click', closeAddressModalFunction, false);

// Close address editing modal when clicking outside of it
window.onclick = function(event) {
    if (event.target == addressModal) {
        addressModal.style.display = "none";
    }
};
</script>

<script>
function editAddress(addressId) {
    // Find the correct modal using the product ID
    var modalId = 'editdataModal_' + addressId;
    $('#' + modalId).modal('show');
}
</script>

<script>
function deleteAddress(addressId) {
    // Confirm before proceeding with deletion
    if (confirm("Are you sure you want to delete this Address?")) {
        // Send an AJAX request to delete.php for deletion
        $.ajax({
            url: 'address/delete_address.php',
            method: 'GET',
            data: {
                id: addressId
            },
            success: function(response) {
                console.log('AJAX Success:', response);
                if (response.trim() === 'success') {
                    alert('Address deleted successfully!');
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('Failed to delete the address. Please try again.');
                    // alert('Blessing completed successfully!');
                    location.reload(); // Reload the page to reflect changes
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle errors as needed
            }
        });
    }
}
</script>

<script>
    // Get the region dropdown
    const regionDropdown = document.getElementById('region');

    // Add event listener to the region dropdown
    regionDropdown.addEventListener('change', function() {
        // Get the selected region value
        const selectedRegion = regionDropdown.value;

        // Define the shipping fee data based on your JSON structure
        const regionData = {
            "01": 40, // Region I (Ilocos Region)
            "02": 40,
            "03": 40,
            "04": 40,
            "05": 40,
            "06": 40,
            "07": 80,
            "08": 80,
            "09": 80,
            "10": 120,
            "11": 120,
            "12": 120,
            "13": 120,
            "14": 40,
            "15": 40,
            "16": 120,
            "17": 120,
        };

        // Retrieve the shipping fee based on the selected region code
        const shippingFee = regionData[selectedRegion] || 0;

        // Update the shipping fee input field
        document.getElementById('shipping_fee').value = shippingFee;
    });
</script>
</html>