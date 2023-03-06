<?php 

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    exit();
}

session_start();


if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    // header("Location: ../bejelentkezés.php");
    exit();
}

require(__DIR__.'/conn.php');

$sql = "DELETE FROM users WHERE id =?";
$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [$_SESSION['id']]);

unlink(__DIR__."/../img/profile/".$_SESSION['id'].".png");
session_destroy();
// header("Location: ../index.php");

?>