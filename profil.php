<?php 
include(__DIR__.'/backend/validator.php'); 

session_start();

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header('Location: bejelentkezés.php');
    exit();
}

require(__DIR__ . '/backend/conn.php');

$sql = "SELECT * FROM users WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [ $_SESSION['id']]);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {
    header("Location: bejelentkezés.php");
    exit();
}

$row = mysqli_fetch_assoc($result);

foreach($row as $key=>$value) {
    $row[$key] = htmlspecialchars($value);
}

?>
<!DOCTYPE html>
<html>
<?php
$TITLE_SUFFIX = htmlspecialchars($_GET['projectName']);
include(__DIR__ . '/components/head.php');
?>

<body>
    <?php
    $ACTIVE = 'Profilom';
    include(__DIR__ . '/components/header.php');
    ?>
    <main>
        <h1>Profilom</h1>
        <form >
            <fieldset>
                <div class="borderless profileData">
                    <div class="borderless fields">
                        <label for="display_name">Felhasználónév:</label>
                        <input type="text" id="display_name" name="display_name" readonly value="<?= $row["display_name"] ?>"><br />
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" readonly value="<?= $row["email"] ?>"><br />
                        <label for="birth_date">Születési dátum:</label>
                        <input type="date" id="birth_date" name="birth_date" readonly value="<?= $row["birth_date"] ?>"><br />
                        <label for="introduction">Bemutatkozás:</label>
                        <textarea id="introduction" name="introduction" readonly value="<?= $row["introduction"] ?>"></textarea><br />
                    </div>
                    <div class="borderless picture">
                        <?php if (file_exists(__DIR__ . "/img/profile/" . $_SESSION["id"] . ".png")) { ?>
                            <img src="img/profile/<?= $_SESSION["id"] ?>.png" alt="Nézd azt a hombár fejedet">
                        <?php } ?>
                        <label for="picture_upload">Profilkép feltöltése:</label>
                        <input type="file" id="picture_upload" name="picture_upload">
                    </div>
                    <div class="borderless buttons">
                        <input type="submit" value="szerkesztés">
                    </div>
                </div>
            </fieldset>
        </form>
    </main>
</body>

</html>