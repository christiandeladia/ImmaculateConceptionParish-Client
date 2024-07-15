<?php
// Include database connection
include '../connect.php';

// Function to check if email exists
function checkUserExists($email, $mobileNumber) {
    global $pdo;
    
    $checkUserQuery = "SELECT COUNT(*) as count FROM login WHERE email = :email OR mobile_number = :mobile_number";
    $checkUserStmt = $pdo->prepare($checkUserQuery);
    $checkUserStmt->bindValue(':email', $email);
    $checkUserStmt->bindValue(':mobile_number', $mobileNumber);
    $checkUserStmt->execute();
    $userCount = $checkUserStmt->fetch(PDO::FETCH_ASSOC)['count'];

    return $userCount > 0 ? 'exists' : 'not_exists';
}
// Check if email or mobile number is provided in the request
if (isset($_POST['email']) && isset($_POST['mobile_number'])) {
    $email = $_POST['email'];
    $mobileNumber = $_POST['mobile_number'];
    echo checkUserExists($email, $mobileNumber);
}

