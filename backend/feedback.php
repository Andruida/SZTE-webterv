<?php

// kérés típusának ellenőrzése
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    exit();
}

session_start();

function redirectWithError($error, $extra=""){
    header(
        "Location: ../visszajelzés.php?error=$error".
        "&email=".urlencode($_POST['email']).
        "&name=".urlencode($_POST['name']).
        "&feedback=".urlencode($_POST['feedback']).
        $extra
    );
    exit();
}

$required = ['email', 'name', 'feedback'];

// tömb mezők ellenőrzése
foreach ($_POST as $key => $value) {
    if (isset($value) && !is_array($value)) {
        $_POST[$key] = trim($value);
    } else {
        unset($_POST[$key]);
    }
}

// kötelező mezők ellenőrzése
foreach ($required as $key) {
    if (!isset($_POST[$key]) || empty($_POST[$key])) {
        redirectWithError("EmptyField", "&field=".urlencode($key));
    }
}

// mezők hosszának ellenőrzése
foreach ($_POST as $key => $value) {
    if ($key == "feedback") continue;
    if (isset($value) && !empty($value)) {
        if (strlen($_POST[$key]) > 100) {
            redirectWithError("FieldTooLong", "&field=".urlencode($key));
        }
    } else {
        redirectWithError("EmptyField", "&field=".urlencode($key));
    }
}

// email cím ellenőrzése
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    redirectWithError("InvalidEmail");
}

require(__DIR__."/conn.php");

$email=$_POST['email'];
$name=$_POST['name'];
$feedback=$_POST['feedback'];
$user_id=null;
if( (isset($_SESSION['id']) || !empty($_SESSION['id']))){
    $user_id=$_SESSION['id'];
}

$sql = "INSERT INTO feedback 
    (`user_id`,`email`,`name`,`body`) 
    VALUES (?, ?, ?,?)";

$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [
    $user_id,
    $email,
    $name,
    $feedback
]);
if ($success) {
    header("Location: ../visszajelzés.php?success=$success#success");
    exit();
} else {
    redirectWithError("DatabaseError");
}

?>