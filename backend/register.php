<?php


// kérés típusának ellenőrzése
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    exit();
}

session_start();

// ha be van jelentkezve, akkor átirányítás a főoldalra
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

// tömb mezők ellenőrzése
foreach ($_POST as $key => $value) {
    if (isset($value) && !is_array($value)) {
        $_POST[$key] = trim($value);
    } else {
        unset($_POST[$key]);
    }
}

// mezők hosszának ellenőrzése
foreach ($_POST as $key => $value) {
    if ($key == 'introduction') continue;
    if (isset($value) && !empty($value)) {
        if (strlen($_POST[$key]) > 100) {
            redirectWithError("FieldTooLong", "&field=".urlencode($key));
        }
    } else {
        redirectWithError("EmptyField", "&field=".urlencode($key));
    }
}

// kötelező mezők ellenőrzése
$required = ["email", "display_name", "birth_date", "password", "password1"];
foreach ($required as $key) {
    if (!isset($_POST[$key]) || empty($_POST[$key])) {
        redirectWithError("EmptyField", "&field=".urlencode($key));
    }
}

// email cím ellenőrzése
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    redirectWithError("InvalidEmail");
}

// születési dátum ellenőrzése
if (strtotime($_POST['birth_date']) === false || strtotime($_POST['birth_date']) > time()) {
    redirectWithError("InvalidBirthDate");
}

// jelszó hosszának ellenőrzése
if (strlen($_POST['password']) < 8) {
    redirectWithError("PasswordTooShort");
}


$display_name = $_POST['display_name'];
$email = $_POST['email'];

require(__DIR__ . '/conn.php');


// ismételt jelszó ellenőrzése
if ($_POST['password'] != $_POST['password1']) {
    redirectWithError("PasswordsDontMatch");
} else {
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
}

// email cím használatának ellenőrzése

$sql = "SELECT * FROM users WHERE email=?";
$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [$email]);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    redirectWithError("EmailIsInUse");
}

// felhasználónév használatának ellenőrzése

$sql = "SELECT * FROM users WHERE display_name=?";
$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [$display_name]);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    redirectWithError("DisplayNameIsInUse");
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
}
$_SESSION['email'] = $email;
$_SESSION['id'] = mysqli_insert_id($conn);
header('Location: ../index.php');
echo "Sikeres regisztráció!";

?>
