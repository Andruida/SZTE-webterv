<?php
include(__DIR__ . '/backend/validator.php');

session_start();

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header('Location: bejelentkezés.php');
    exit();
}

require(__DIR__ . '/backend/conn.php');

$sql = "SELECT * FROM users WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);
$success = mysqli_stmt_execute($stmt, [$_SESSION['id']]);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {
    header("Location: bejelentkezés.php");
    exit();
}

$row = mysqli_fetch_assoc($result);

foreach ($row as $key => $value) {
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
        <form action="backend/profile.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <div class="borderless profileData">
                    <div class="borderless fields">
                        <label for="display_name">Felhasználónév:</label>
                        <input type="text" id="display_name" name="display_name" readonly value="<?= $row["display_name"] ?>" />
                        <?php if (isset($_GET["error"]) && $_GET["error"] == "DisplayNameIsInUse") {?>
                            <span class="error">Ezt a nevet más már használja!</span>
                        <?php } ?><br />

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" readonly value="<?= $row["email"] ?>" />
                        <?php if (isset($_GET["error"]) && $_GET["error"] == "EmailIsInUse") {?>
                            <span class="error">Ezt az e-mail címet más már használja!</span>
                        <?php } ?>
                        <?php if (isset($_GET["error"]) && $_GET["error"] == "InvalidEmail") {?>
                            <span class="error">Érvénytelen e-mail cím!</span>
                        <?php } ?><br />

                        <label for="birth_date">Születési dátum:</label>
                        <input type="date" id="birth_date" name="birth_date" readonly value="<?= $row["birth_date"] ?>" />
                        <?php if (isset($_GET["error"]) && $_GET["error"] == "InvalidBirthDate") {?>
                            <span class="error">Érvénytelen dátum!</span>
                        <?php } ?><br />
                        

                        <label for="introduction">Bemutatkozás:</label>
                        <textarea id="introduction" name="introduction" readonly><?= $row["introduction"] ?></textarea><br />
                    </div>
                    <div class="borderless picture">
                        <?php if (file_exists(__DIR__ . "/img/profile/" . $_SESSION["id"] . ".png")) { ?>
                            <img src="img/profile/<?= $_SESSION["id"] ?>.png" alt="Nézd azt a hombár fejedet">
                        <?php } else { ?>
                            <img src="img/profile/default.png" alt="Nézd azt a hombár fejedet">
                        <?php } ?>
                        <label for="picture_upload" style="visibility: hidden;">Profilkép feltöltése:</label>
                        <input type="file" id="picture_upload" name="picture_upload" accept="image/png" style="visibility: hidden;" />
                    </div>
                </div>
                <div class="borderless" id="buttons">
                    <input type="button" onclick="enableEdit()" value="Szerkesztés engedélyezése" />
                    <input type="submit" value="Mentés" style="display: none;" />

                    <input style=" background-color: #f44336;" type="button" onclick="removeProfile()" value="Felhasználói fiók törlése" />
                </div>

            </fieldset>
        </form>
    </main>

    <?php include(__DIR__ . '/components/footer.php'); ?>

    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/profile.js"></script>
    <?php if (isset($_GET["error"]) && !empty($_GET["error"])) { ?>
        <script>enableEdit()</script>
    <?php } ?>
</body>

</html>