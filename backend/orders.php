<?php
session_start();

require(__DIR__."/conn.php");

$szolgaltatas = $_POST['szolgaltatas'];
$typeSelect=$_POST['typeSelect'];
$bookingDate=$_POST['appointment booking date'];
$bookingTime=$_POST['time'];
$bookingTime=$_POST['time'];
$mobileNumber=$_POST['mobileNumber'];



$sql = "INSERT INTO orders 
    (`user_id`, `services`, `way_of_contact`, `datetime`, `phone`) 
    VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [
    $_SESSION['id'],
    $szolgaltatas,
    $typeSelect,
    strtotime($bookingDate." ".$bookingTime),
    $mobileNumber])
?>