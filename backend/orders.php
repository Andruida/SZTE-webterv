<?php

// kérés típusának ellenőrzése
if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    exit();
}

session_start();

// ha nincs bejelentkezve, akkor átirányítás a bejelentkezés oldalra
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header("Location: ../bejelentkezés.php");
    exit();
}

$szolgaltatas_bitmap = 0;
function redirectWithError($error, $extra = "") {
    global $szolgaltatas_bitmap;
    header(
        "Location: ../csevegjünk.php?error=$error".
        "&szolgaltatas=".urlencode($szolgaltatas_bitmap).
        "&typeSelect=".urlencode($_POST['typeSelect']).
        "&date=".urlencode($_POST['date']).
        "&mobileNumber=".urlencode($_POST['mobileNumber']).
        "&time=".urlencode($_POST['time']).
        $extra."#contact-us"
    );
    exit();
}

$required = ['typeSelect', 'date', 'time', 'mobileNumber'];

// tömb mezők ellenőrzése
foreach ($_POST as $key => $value) {
    if ($key == "szolgaltatas") continue;
    if (isset($value) && !is_array($value)) {
        $_POST[$key] = trim($value);
    } else {
        unset($_POST[$key]);
    }
}

// szolgáltatás bitmap kifejtése
if (isset($_POST["szolgaltatas"]) && !empty($_POST["szolgaltatas"]) ) {
    $szolgaltatas = $_POST['szolgaltatas'];
    foreach ($szolgaltatas as $szolgaltatas_id) {
        if (!is_numeric($szolgaltatas_id) ||
             intval($szolgaltatas_id) > 6 ||
             intval($szolgaltatas_id) < 0) 
                continue;
        $szolgaltatas_bitmap |= 1 << intval($szolgaltatas_id);
    }
}

unset($_POST["szolgaltatas"]);

if ($szolgaltatas_bitmap == 0) {
    redirectWithError("EmptyField", "&field=".urlencode("szolgaltatas"));
}

// kötelező mezők ellenőrzése
foreach ($required as $key) {
    if (!isset($_POST[$key]) || empty($_POST[$key])) {
        redirectWithError("EmptyField", "&field=".urlencode($key));
    }
}

// mezők hosszának ellenőrzése
foreach ($_POST as $key => $value) {
    if (isset($value) && !empty($value)) {
        if (strlen($_POST[$key]) > 100) {
            redirectWithError("FieldTooLong", "&field=".urlencode($key));
        }
    } else {
        redirectWithError("EmptyField", "&field=".urlencode($key));
    }
}

// időpont ellenőrzése
if (strtotime($_POST['date']) === false || strtotime($_POST['date']) < strtotime("tomorrow")) {
    redirectWithError("InvalidDate");
}
if (strtotime($_POST['time']) === false || 
    strtotime($_POST['time']) < strtotime("8:00") || 
    strtotime($_POST['time']) > strtotime("16:00")) {
        redirectWithError("InvalidTime");
}

// telefonszám ellenőrzése
if (!preg_match("/^\+36 ?[0-9]{1,2} ?[0-9]{3,4} ?[0-9]{3,4}$/", $_POST['mobileNumber'])) {
    redirectWithError("InvalidMobileNumber");
}

$typeSelect=$_POST['typeSelect'];
$bookingDate=$_POST['date'];
$bookingTime=$_POST['time'];
$mobileNumber=$_POST['mobileNumber'];
$typeSelect_smt="";

switch ($typeSelect) {
    case 'Teams meet':
        $typeSelect_smt = 'TEAMS';
        break;
    case 'Google meet':
        $typeSelect_smt = 'MEET';
        break;
    case 'Személyes találkozó':
        $typeSelect_smt = 'PERSONAL';
        break;
    default:
        redirectWithError("TypeSelectError");
        break;
}


require(__DIR__."/conn.php");
$sql = "INSERT INTO orders 
    (`user_id`, `services`, `way_of_contact`, `datetime`, `phone`) 
    VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [
    $_SESSION['id'],
    $szolgaltatas_bitmap,
    $typeSelect_smt,
    date("Y-m-d H:i:s", strtotime($bookingDate." ".$bookingTime)),
    $mobileNumber
]);

if ($success) {
    header("Location: ../csevegjünk.php?success=$success#success");
    exit();
} else {
    redirectWithError("DatabaseError");
}
