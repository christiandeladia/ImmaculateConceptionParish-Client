
<?php
  require_once "../connect.php";

$id = $_GET['id'];

$query = "SELECT * FROM address WHERE id = ?";
$statement = $pdo->prepare($query);
$statement->execute([$id]);
$row = $statement->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $mobile_number = $_POST['mobile_number'];
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $region = $_POST['region'];
    $zip_code = $_POST['zip_code'];

    $query = "UPDATE address SET first_name = ?, last_name = ?, mobile_number = ?, street = ?, barangay = ?, city = ?, province = ?, region = ?, zip_code = ? WHERE id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$first_name, $last_name, $mobile_number, $street, $barangay, $city, $province, $region, $zip_code, $id]);

    header('Location: ../modal_checkout.php');
}
?>