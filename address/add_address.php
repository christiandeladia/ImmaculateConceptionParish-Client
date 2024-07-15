<?php
    require_once "../connect.php";

    if (!isset($_SESSION['auth_login'])) {
        header("Location: ../index.php");
    }

    // Check if form is submitted
    if (isset($_POST['cart_checkout'])) {
        // Extract form data
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $mobile_number = $_POST['mobile_number'];
        $region_name = $_POST['region_text']; // Change to region name
        $province_name = $_POST['province_text']; // Change to province name
        $city_name = $_POST['city_text']; // Change to city name
        $barangay_name = $_POST['barangay_text']; // Change to barangay name
        $street = $_POST['street'];
        $zip_code = $_POST['zip_code'];
        $shipping_fee = $_POST['shipping_fee'];

        // Database insertion
        $auth = $_SESSION['auth_login'];
        $auth_id = $auth['id'];
        $group_order = uniqid(); // Generate unique group order ID

        // Prepare and execute SQL query
        $sql = "INSERT INTO `address`(`group_id`, `customer_id`, `first_name`, `last_name`, `mobile_number`, `region`, `province`, `city`, `barangay`, `street`, `zip_code`, `shipping_fee`, `date_added`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([$group_order, $auth_id, $first_name, $last_name, $mobile_number, $region_name, $province_name, $city_name, $barangay_name, $street, $zip_code, $shipping_fee]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit; // Stop further execution
        }

        // Redirect after successful submission
        header("Location: ../modal_checkout.php");
    } else {
        // If form not submitted, redirect back to index.php
        header("Location: ../index.php");
    }
?>
