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
        if (strlen($_POST[$key]) > 100) {
            header("Location: ../bejelentkezés.php?form=register&error=FieldTooLong&email=".urlencode($email).
            "&display_name=".urlencode($_POST['display_name']).
            "&birth_date=".urlencode($_POST['birth_date']).
            "&introduction=".urlencode($_POST['introduction']));
            echo "A(z) $key mező túl hosszú!";
            exit();
        }
    } else {
        header("Location: ../bejelentkezés.php?error=EmptyField&form=register&email=".urlencode($email).
            "&display_name=".urlencode($_POST['display_name']).
            "&birth_date=".urlencode($_POST['birth_date']).
            "&introduction=".urlencode($_POST['introduction']));
        echo "A(z) $key mező nem lehet üres!";
        exit();
    }
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header("Location: ../bejelentkezés.php?form=register&error=InvalidEmail&email=".urlencode($email).
    "&display_name=".urlencode($_POST['display_name']).
    "&birth_date=".urlencode($_POST['birth_date']).
    "&introduction=".urlencode($_POST['introduction']));
    echo "Az e-mail cím formátuma nem megfelelő.";
    exit();
}

if (strtotime($_POST['birth_date']) === false) {
    header("Location: ../bejelentkezés.php?form=register&error=InvalidBirthDate&email=".urlencode($email).
    "&display_name=".urlencode($_POST['display_name']).
    "&birth_date=".urlencode($_POST['birth_date']).
    "&introduction=".urlencode($_POST['introduction']));
    echo "A születési dátum formátuma nem megfelelő.";
    exit();
}

if (strlen($_POST['password']) < 8) {
    header("Location: ../bejelentkezés.php?form=register&error=PasswordTooShort&email=".urlencode($email).
    "&display_name=".urlencode($_POST['display_name']).
    "&birth_date=".urlencode($_POST['birth_date']).
    "&introduction=".urlencode($_POST['introduction']));
    echo "A jelszó túl rövid.";
    exit();
}


$display_name = $_POST['display_name'];
$email = $_POST['email'];

require(__DIR__ . '/conn.php');



if ($_POST['password'] != $_POST['password1']) {
    header("Location: ../bejelentkezés.php?form=register&error=PasswordsDontMatch&email=".urlencode($email).
    "&display_name=".urlencode($display_name).
    "&birth_date=".urlencode($_POST['birth_date']).
    "&introduction=".urlencode($_POST['introduction']));
    echo ("A jelszavak nem egyeznek meg.");
    exit();
} else {
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
}

$sql = "SELECT * FROM users WHERE email=?";
$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [$email]);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    header("Location: ../bejelentkezés.php?form=register&error=EmailIsInUse&email=".urlencode($email).
    "&display_name=".urlencode($display_name).
    "&birth_date=".urlencode($_POST['birth_date']).
    "&introduction=".urlencode($_POST['introduction']));
    echo "Az e-mail cím már foglalt.";
    exit();
}

$sql = "SELECT * FROM users WHERE display_name=?";
$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [$display_name]);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    header("Location: ../bejelentkezés.php?form=register&error=DisplayNameIsInUse&email=".urlencode($email).
    "&display_name=".urlencode($display_name).
    "&birth_date=".urlencode($_POST['birth_date']).
    "&introduction=".urlencode($_POST['introduction']));
    echo "A felhasználónév már foglalt.";
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
    (trim($_POST['introduction'])) ? trim($_POST['introduction']) : null
]);
if (!$success) {
    header("Location: ../bejelentkezés.php?form=register&error=ErrorAtRegistration=".urlencode($email).
    "&display_name=".urlencode($display_name).
    "&birth_date=".urlencode($_POST['birth_date']).
    "&introduction=".urlencode($_POST['introduction']));
    // echo "Hiba a regisztráció során: " . mysqli_error($conn);
    exit();
}
$_SESSION['email'] = $email;
$_SESSION['id'] = mysqli_insert_id($conn);
header('Location: ../index.php');
echo "Sikeres regisztráció!";

?>
