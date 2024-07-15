<?php
  require_once "../connect.php";

  // Assuming you have the necessary database connection and setup
  
  if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
      // Sanitize the input
      $addressId = intval($_GET['id']);
  
      // Perform the deletion operation
      $sql = "DELETE FROM address WHERE id = :id";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':id', $addressId, PDO::PARAM_INT);
  
      if ($stmt->execute()) {
          echo 'success';
      } else {
          echo 'error';
      }
  }
  ?>
  