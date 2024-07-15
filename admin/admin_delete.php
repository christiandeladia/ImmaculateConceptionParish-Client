<?php
  require_once "connect.php";

$id = $_GET['id'];

$query = "DELETE FROM inventory WHERE id = ?";
$statement = $pdo->prepare($query);
$statement->execute([$id]);

header('Location: ../admin/index.php');
?>
