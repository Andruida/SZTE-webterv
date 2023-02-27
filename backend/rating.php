<?php

session_start();

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    exit();
}

include(__DIR__.'/conn.php');

// $sql = "UPDATE ratings SET rating = ? WHERE user_id = ? AND project_id = ?;";

?>