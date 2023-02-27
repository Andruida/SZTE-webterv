<?php

session_start();

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header("Location: bejelentkezés.php");
    exit();
}

function redirectWithError($error) {
    header(
        "Location: ../profil.php?error=$error".
        "&email=".urlencode($_POST['email']).
        "&display_name=".urlencode($_POST['display_name']).
        "&birth_date=".urlencode($_POST['birth_date']).
        "&introduction=".urlencode($_POST['introduction'])
    );
    exit();
}

$notRequired = ['introduction', 'password', 'password1', 'picture_upload'];

foreach ($_POST as $key => $value) {
    if (array_search($key, $notRequired)) continue;
    if (isset($value) && !empty($value)) {
        $_POST[$key] = trim($value);
        if (strlen($_POST[$key]) > 100) {
            redirectWithError("FieldTooLong");
            echo "A(z) $key mező túl hosszú!";
            exit();
        }
    } else {
        redirectWithError("EmptyField");
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

if (isset($_POST['password']) && !empty($_POST['password'])) {
    if (strlen($_POST['password']) < 8) {
        redirectWithError("PasswordTooShort");
        echo "A jelszó túl rövid!";
        exit();
    }
    if ($_POST['password'] !== $_POST['password1']) {
        redirectWithError("PasswordsDontMatch");
        echo "A két jelszó nem egyezik!";
        exit();
    }
}

if (isset($_FILES['picture_upload']) && !empty($_FILES['picture_upload'])) {
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
        echo "A kép formátuma nem megfelelő!";
        exit();
    }
    if ($fileError !== 0) { 
        redirectWithError("UploadError");
        echo "Hiba történt a kép feltöltése során!";
        exit();
    }
    if ($fileSize < 1000000) {
        redirectWithError("FileTooBig");
        echo "A kép mérete túl nagy!";
        exit();
    }


    $fileNameNew = $_SESSION["id"].".".$fileActualExt;
    $fileDestination = '../img/profile/'.$fileNameNew;
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
    echo "Az e-mail cím már foglalt.";
    exit();
}

$sql = "SELECT * FROM users WHERE display_name=? AND id != ?";
$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [$display_name, $_SESSION['id']]);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    redirectWithError("DisplayNameIsInUse");
    echo "A felhasználónév már foglalt.";
    exit();
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
    redirectWithError("SaveError");
    echo "Hiba történt a mentés során!";
}

?>