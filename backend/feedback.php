<?php

session_start();

require(__DIR__."/conn.php");

$email=$_POST['email'];
$name=$_POST['name'];
$feedback=$_POST['feedback'];
$user_id=null;
if( (isset($_SESSION['id']) || !empty($_SESSION['id']))){
    $user_id=$_SESSION['id'];
}

$sql = "INSERT INTO feedback 
    (`user_id`,`email`,`name`,`body`) 
    VALUES (?, ?, ?,?)";

$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [
    $user_id,
    $email,
    $name,
    $feedback
]);
if ($success) {
    header("Location: ../visszajelzés.php?success=$success#success");
    exit();
} else {
    redirectWithError("DatabaseError");
}

?>