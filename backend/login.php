<?php

session_start();

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}

$email = $_POST['email'];
$password = $_POST['password'];

if (isset($password) && !empty($password)) {
    $password = trim($password);
} else {
    echo "A jelszó mező nem lehet üres!";
    exit();
}

if (isset($email) && !empty($email)) {
    $email = trim($email);
} else {
    echo "Az email mező nem lehet üres!";
    exit();
}

include(__DIR__.'/conn.php');

$sql = "SELECT * FROM users WHERE email = ?";

$stmt = mysqli_prepare($conn, $sql);
// mysqli_stmt_bind_param($stmt, 's', $email);
$success = mysqli_stmt_execute($stmt, [ $email ]);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {
  $row = mysqli_fetch_assoc($result);
  if (password_verify($password, $row['password'])) {
    $_SESSION['email'] = $email;
    $_SESSION['id'] = $row["id"];
    // setcookie('email', $email, time() + (86400 * 30), '/');
    header("Location: ../index.php");
    echo "Sikeres bejelentkezés!";
  } else {
    echo "Hibás jelszó!";
  }
} else {
  echo "A felhasználónév nem található.";
}

?>