<?php
require_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['groupOrder'])) {
    // Assuming your table name is `notification_order` and the column for status is named `status`
    $groupOrder = $_POST['groupOrder'];
    
    // Update the status of the notification to "read"
    $update_query = "UPDATE notification_order SET status = 'read' WHERE id = :groupOrder";
    $statement = $pdo->prepare($update_query);
    $statement->bindParam(':groupOrder', $groupOrder, PDO::PARAM_STR);
    
    // Execute the update query
    if ($statement->execute()) {
        // Return success response
        echo json_encode(array("success" => true));
    } else {
        // Return failure response
        echo json_encode(array("success" => false));
    }
} else {
    // Invalid request method or missing parameters
    echo json_encode(array("success" => false, "message" => "Invalid request"));
}
?>
