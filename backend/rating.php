<?php

// kérés típusának ellenőrzése
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    exit();
}

session_start();

// ha nincs bejelentkezve a kérést elutasítjuk
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    http_response_code(403);
    exit();
}

require(__DIR__.'/conn.php');

// projekt létezik-e
$sql = "SELECT * FROM projects WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [$_POST['projectId']]);

if (!$success || mysqli_num_rows(mysqli_stmt_get_result($stmt)) == 0) {
    http_response_code(404);
    exit();
}

// létezik-e korábbi értékelés
$sql = "SELECT * FROM ratings WHERE user_id = ? AND project_id = ?;";
$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [$_SESSION['id'], $_POST['projectId']]);
$result = mysqli_stmt_get_result($stmt);

if ($success && mysqli_num_rows($result) > 0) {
    $sql = "UPDATE ratings SET rating = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    $success = mysqli_stmt_execute($stmt, [$_POST['rating'], mysqli_fetch_assoc($result)['id']]);
} else {
    $sql = "INSERT INTO ratings (user_id, project_id, rating) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    $success = mysqli_stmt_execute($stmt, [$_SESSION['id'], $_POST['projectId'], $_POST['rating']]);
}

?>