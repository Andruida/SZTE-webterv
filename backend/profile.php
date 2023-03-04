<?php

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    exit();
}

session_start();

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header("Location: ../bejelentkezés.php");
    exit();
}

function redirectWithError($error, $extra = "") {
    header(
        "Location: ../profil.php?error=$error".
        "&email=".urlencode($_POST['email']).
        "&display_name=".urlencode($_POST['display_name']).
        "&birth_date=".urlencode($_POST['birth_date']).
        "&introduction=".urlencode($_POST['introduction']).$extra
    );
    exit();
}

$notRequired = ['password', 'password1', 'picture_upload'];

foreach ($_POST as $key => $value) {
    if (isset($value)) {
        $_POST[$key] = trim($value);
    }
}

foreach ($_POST as $key => $value) {
    if ($key == "introduction") continue;
    if (isset($value) && !empty($value)) {
        if (strlen($_POST[$key]) > 100) {
            redirectWithError("FieldTooLong", "&field=".urlencode($key));
        }
    } else {
        if (array_search($key, $notRequired)) continue;
        redirectWithError("EmptyField", "&field=".urlencode($key));
    }
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    redirectWithError("InvalidEmail");
}

if (strtotime($_POST['birth_date']) === false) {
    redirectWithError("InvalidBirthDate");
}

if (isset($_POST['password']) && !empty($_POST['password'])) {
    if (strlen($_POST['password']) < 8) {
        redirectWithError("PasswordTooShort");
    }
    if ($_POST['password'] !== $_POST['password1']) {
        redirectWithError("PasswordsDontMatch");
    }
}

if (isset($_FILES['picture_upload']) && !empty($_FILES['picture_upload']) && $_FILES['picture_upload']['size'] !== 0) {
    $file = $_FILES['picture_upload'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    if (!in_array($fileActualExt, ['png'])) {
        redirectWithError("InvalidFileFormat");
    }
    if ($fileError !== 0) { 
        redirectWithError("UploadError");
    }
    if ($fileSize > 5242880) {
        redirectWithError("FileTooBig");
    }


    $fileNameNew = $_SESSION["id"].".".$fileActualExt;
    $fileDestination = __DIR__.'/../img/profile/'.$fileNameNew;
    move_uploaded_file($fileTmpName, $fileDestination);

}

require (__DIR__."/conn.php");

$display_name = $_POST['display_name'];
$email = $_POST['email'];
$birth_date = $_POST['birth_date'];
$introduction = $_POST['introduction'];


$sql = "SELECT * FROM users WHERE email=? AND id != ?";
$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [$email, $_SESSION['id']]);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    redirectWithError("EmailIsInUse");
}

$sql = "SELECT * FROM users WHERE display_name=? AND id != ?";
$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [$display_name, $_SESSION['id']]);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    redirectWithError("DisplayNameIsInUse");
}

if (!empty($_POST["password"])) {
    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
}


if (isset($password_hash)) {
    $sql = "UPDATE users SET display_name = ?, email = ?, birth_date = ?, introduction = ?, `password` = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    $success = mysqli_stmt_execute($stmt, [$display_name, $email, $birth_date, $introduction, $password_hash, $_SESSION['id']]);
} else {
    $sql = "UPDATE users SET display_name = ?, email = ?, birth_date = ?, introduction = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    $success = mysqli_stmt_execute($stmt, [$display_name, $email, $birth_date, $introduction, $_SESSION['id']]);
}
if ($success) {
    header("Location: ../profil.php");
    exit();
} else {
    redirectWithError("DatabaseError");
}

?>