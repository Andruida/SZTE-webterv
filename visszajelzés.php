<?php 
include(__DIR__ . '/backend/validator.php'); 

foreach ($_GET as $key => $value) {
    $_GET[$key] = htmlspecialchars($value);
}

$required = ['email', 'name', 'feedback'];
if (isset($_GET['error'])) {
    foreach ($required as $key) {
        if (!isset($_GET[$key]) || empty($_GET[$key]) || is_array($_GET[$key])) {
            $_GET[$key] = "";
        }
    }
} else {
    foreach ($required as $key) {
        $_GET[$key] = "";
    }
}
?>
<!DOCTYPE html>
<html lang="hu">

<?php
$TITLE_SUFFIX = 'Visszajelzés';
include(__DIR__ . '/components/head.php');
?>

<body>
    <?php
    $ACTIVE = 'Visszajelzés';
    include(__DIR__ . '/components/header.php');
    ?>
    <main>
        <article>
            <h2>Véleménye számít!</h2>
            <p>Kedves felhasználók, nagyon fontos számunkra a véleményük. Az oldalunk folyamatos fejlesztésének és
                javításának célja, hogy a lehető legjobb élményt nyújtsa Önöknek. Ennek érdekében szívesen hallanánk a
                véleményüket a weboldalunkkal kapcsolatban.
            </p>
            <p>Kérjük, töltse ki az alábbi kérdőívet, és mondja el nekünk, mit gondol az oldalunkról:</p>
            <ul>
                <li>Milyen volt az oldal használata?</li>
                <li>Talált-e mindent, amit keresett?</li>
                <li>Volt-e olyan problémája, amelyet nem tudott megoldani az oldalon?</li>
                <li>Van-e olyan funkció, amelyet szívesen látna az oldalon?</li>
                <li>Milyen véleménnyel van az oldal dizájnjáról?</li>
            </ul>
        </article>
        <form method="post" action="backend/feedback.php">
            <fieldset>
                <legend>Visszajelzés</legend>

                <label for="email">Email címed:</label>
                <input type="email" id="email" name="email" required maxlength="100" 
                    value="<?= $_GET["email"] ?>" />
                <?php if (
                    isset($_GET["error"]) && $_GET["error"] == "EmptyField" &&
                    isset($_GET["field"]) && $_GET["field"] == "email"
                ) { ?>
                    <span class="error">Nem maradhat üresen!</span>
                <?php } ?>
                <?php if (
                    isset($_GET["error"]) && $_GET["error"] == "FieldTooLong" &&
                    isset($_GET["field"]) && $_GET["field"] == "email"
                ) { ?>
                    <span class="error">Legfeljebb 100 karakter hosszú lehet!</span>
                <?php } ?>
                <?php if (isset($_GET["error"]) && $_GET["error"] == "InvalidEmail") { ?>
                    <span class="error">Érvénytelen e-mail cím!</span>
                <?php } ?><br />

                <label for="name">Név:</label>
                <input required id="name" maxlength="100" type="text" name="name" 
                    value="<?= $_GET["name"] ?>" />
                <?php if (
                    isset($_GET["error"]) && $_GET["error"] == "EmptyField" &&
                    isset($_GET["field"]) && $_GET["field"] == "name"
                ) { ?>
                    <span class="error">Nem maradhat üresen!</span>
                <?php } ?>
                <?php if (
                    isset($_GET["error"]) && $_GET["error"] == "FieldTooLong" &&
                    isset($_GET["field"]) && $_GET["field"] == "name"
                ) { ?>
                    <span class="error">Legfeljebb 100 karakter hosszú lehet!</span>
                <?php } ?><br />

                <label for="feedback">Részletes és kifejtett építő jellegű véleménye:</label>
                <textarea required id="feedback" name="feedback"><?= $_GET["feedback"] ?></textarea>
                <?php if (
                    isset($_GET["error"]) && $_GET["error"] == "EmptyField" &&
                    isset($_GET["field"]) && $_GET["field"] == "feedback"
                ) { ?>
                    <span class="error">Nem maradhat üresen!</span>
                <?php } ?>
                <br />

                <label class="required"><input required type="checkbox" /> Belegyezek, hogy harmadik fél kezelje az adataimat.</label>

                <input type="submit" value="Küldés" />
                <input type="reset" value="Vissza mindent" />
                <?php if (isset($_GET["success"]) && $_GET["success"] == "1") { ?>
                    <span id="success" class='ok'>A visszajelzés sikeresen elküldve!</span>
                <?php } ?>
            </fieldset>
        </form>
    </main>
    <?php include(__DIR__ . '/components/footer.php'); ?>
</body>

</html>