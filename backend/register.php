<?php

session_start();


if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}

foreach ($_POST as $key => $value) {
    if ($key == 'introduction') continue;
    if (isset($value) && !empty($value)) {
        $_POST[$key] = trim($value);
    } else {
        echo "A(z) $key mező nem lehet üres!";
        exit();
    }
}


$display_name = $_POST['display_name'];
$email = $_POST['email'];

include(__DIR__ . '/conn.php');



if ($_POST['password'] != $_POST['password1']) {
    echo ("A jelszavak nem egyeznek meg.");
    exit();
} else {
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
}

$sql = "SELECT * FROM users WHERE display_name=? OR email=?";
$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [$display_name, $email]);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo "A felhasználónév vagy az e-mail cím már foglalt.";
    exit();
}
$sql = "INSERT INTO users 
    (`display_name`, `email`, `password`, `birth_date`, `introduction`) 
    VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [
    $display_name, 
    $email, 
    $password, 
    $_POST['birth_date'], 
    $_POST['introduction']
]);
if (!$success) {
    echo "Hiba a regisztráció során: " . mysqli_error($conn);
    exit();
}
$_SESSION['email'] = $email;
$_SESSION['id'] = mysqli_insert_id($conn);
header('Location: ../index.php');
echo "Sikeres regisztráció!";

?>
