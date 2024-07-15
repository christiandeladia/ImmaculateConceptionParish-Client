<?php
require_once "connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['referenceId'])) {
    $referenceId = $_POST['referenceId'];
    
    // Update the status of the notification to 'read' in the database
    $updateQuery = "UPDATE notification_client SET status = 'read' WHERE reference_id = :referenceId";
    $statement = $pdo->prepare($updateQuery);
    $statement->bindParam(':referenceId', $referenceId, PDO::PARAM_STR);
    
    if ($statement->execute()) {
        // Notification marked as read successfully
        echo 'success';
    } else {
        // Error handling
        echo 'error';
    }
} else {
    echo 'invalid_request';
}
?>
