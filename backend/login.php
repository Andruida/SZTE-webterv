<?php

session_start();

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    header('Location: ../profil.php');
    exit();
}

$email = $_POST['email'];
$password = $_POST['password'];


if (isset($password) && !empty($password)) {
    $password = trim($password);
} else {
    header("Location: ../bejelentkezés.php?form=login&error=EmptyPassword&email=" . urlencode($email));
    echo "A jelszó mező nem lehet üres!";
    exit();
}


if (isset($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $email = trim($email);
} else {
    header("Location: ../bejelentkezés.php?form=login&error=InvalidEmail&email=" . urlencode($email));
    echo "Az e-mail cím formátuma nem megfelelő.";
    exit();
}

require(__DIR__ . '/conn.php');

$sql = "SELECT * FROM users WHERE email = ?";

$stmt = mysqli_prepare($conn, $sql);
// mysqli_stmt_bind_param($stmt, 's', $email);
$success = mysqli_stmt_execute($stmt, [$email]);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    header("Location: ../bejelentkezés.php?form=login&error=UserDoesntExist&email=" . urlencode($email));
    echo "A felhasználónév nem található.";
    exit();
}

$row = mysqli_fetch_assoc($result);

if (password_verify($password, $row['password'])) {
    $_SESSION['email'] = $email;
    $_SESSION['id'] = $row["id"];
    
    header("Location: ../profil.php");
    echo "Sikeres bejelentkezés!";
} else {
    header("Location: ../bejelentkezés.php?form=login&error=WrongPassword&email=" . urlencode($email));
    echo "Hibás jelszó!";
}
