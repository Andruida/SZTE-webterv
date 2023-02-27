<?php

session_start();

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header("Location: ../bejelentkezés.php");
    exit();
}

require(__DIR__."/conn.php");

$szolgaltatas = $_POST['szolgaltatas'];

$szolgaltatas_bitmap = 0;
foreach ($szolgaltatas as $szolgaltatas_id) {
    $szolgaltatas_bitmap |= 1 << $szolgaltatas_id;
}
$typeSelect=$_POST['typeSelect'];
$bookingDate=$_POST['date'];
$bookingTime=$_POST['time'];
$mobileNumber=$_POST['mobileNumber'];
$typeSelect_smt="";
function redirectWithError($error, $extra = "") {
    header(
        "Location: ../profil.php?error=$error".
        "&szolgaltatas=".urlencode($_POST['szolgaltatas']).
        "&typeSelect=".urlencode($_POST['typeSelect']).
        "&date=".urlencode($_POST['date']).
        "&mobileNumber=".urlencode($_POST['mobileNumber']).
        "&time=".urlencode($_POST['time']).
        $extra
    );
    exit();
}

switch ($typeSelect) {
    case 'Teams meet':
      $typeSelect_smt='TEAMS';
      break;
    case 'Google meet':
        $typeSelect_smt='MEET';
      break;
    case 'Személyes találkozó':
        $typeSelect_smt='PERSONAL';
      break;
    default:
        redirectWithError("typeSelectError");
      break;
  }
  

$sql = "INSERT INTO orders 
    (`user_id`, `services`, `way_of_contact`, `datetime`, `phone`) 
    VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [
    $_SESSION['id'],
    $szolgaltatas_bitmap,
    $typeSelect_smt,
    date("Y-m-d H:i:s", strtotime($bookingDate." ".$bookingTime)),
    $mobileNumber]);

if ($success) {
        header("Location: ../csevegjünk.php?success=$success#success");
        exit();
    } else {
        redirectWithError("DatabaseError");
    }
?>