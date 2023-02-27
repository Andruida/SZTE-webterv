<?php

session_start();


if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    header('Location: ../index.php');
    exit();
}

function redirectWithError($error, $extra = "") {
    header(
        "Location: ../bejelentkezés.php?error=$error&form=register".
        "&email=".urlencode($_POST['email']).
        "&display_name=".urlencode($_POST['display_name']).
        "&birth_date=".urlencode($_POST['birth_date']).
        "&introduction=".urlencode($_POST['introduction']).$extra
    );
    exit();
}

foreach ($_POST as $key => $value) {
    if (isset($value)) {
        $_POST[$key] = trim($value);
    }
}
foreach ($_POST as $key => $value) {
    if ($key == 'introduction') continue;
    if (isset($value) && !empty($value)) {
        if (strlen($_POST[$key]) > 100) {
            redirectWithError("FieldTooLong", "&field=".urlencode($key));
            echo "A(z) $key mező túl hosszú!";
            exit();
        }
    } else {
        redirectWithError("EmptyField", "&field=".urlencode($key));
        echo "A(z) $key mező nem lehet üres!";
        exit();
    }
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    redirectWithError("InvalidEmail");
    echo "Az e-mail cím formátuma nem megfelelő.";
    exit();
}

if (strtotime($_POST['birth_date']) === false) {
    redirectWithError("InvalidBirthDate");
    echo "A születési dátum formátuma nem megfelelő.";
    exit();
}

if (strlen($_POST['password']) < 8) {
    redirectWithError("PasswordTooShort");
    echo "A jelszó túl rövid.";
    exit();
}


$display_name = $_POST['display_name'];
$email = $_POST['email'];

require(__DIR__ . '/conn.php');



if ($_POST['password'] != $_POST['password1']) {
    redirectWithError("PasswordsDontMatch");
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
    redirectWithError("EmailIsInUse");
    echo "Az e-mail cím már foglalt.";
    exit();
}

$sql = "SELECT * FROM users WHERE display_name=?";
$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [$display_name]);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    redirectWithError("DisplayNameIsInUse");
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
    redirectWithError("DatabaseError");
    exit();
}
$_SESSION['email'] = $email;
$_SESSION['id'] = mysqli_insert_id($conn);
header('Location: ../index.php');
echo "Sikeres regisztráció!";

?>
