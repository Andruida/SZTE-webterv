<?php 
session_start();


if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
  header("Location: ../bejelentkezés.php");
  exit();
}

include(__DIR__.'/conn.php');

$sql = "DELETE FROM users WHERE id =?";
$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [$_SESSION['id']]);

session_destroy();
header("Location: ../index.php");
?>