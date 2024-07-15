<?php
// fetch_schedule.php

// Include your database connection file
require_once "connect.php";

// Get the selected date from the AJAX request
$date = $_GET['date'];

// Query to fetch the date, time, and date_time for the selected date
$query = "SELECT date, time, date_time FROM schedule WHERE date = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $date);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $date, $time, $date_time);

// Fetch the result
$result = array();
while (mysqli_stmt_fetch($stmt)) {
    $result[] = array(
        'date' => $date,
        'time' => $time,
        'date_time' => $date_time
    );
}

// Return the result as JSON
echo json_encode($result);

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
