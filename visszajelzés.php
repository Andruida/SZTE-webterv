<?php include(__DIR__.'/backend/validator.php'); ?>
<!DOCTYPE html>
<html lang="hu">

<?php 
$TITLE_SUFFIX = 'Javaslatok';
include(__DIR__.'/components/head.php'); 
?>

<body>
    <?php 
    $ACTIVE = 'Javaslatok';
    include(__DIR__.'/components/header.php'); 
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
                <input required id="email" maxlength="100" type="email" name="email" /><br />

                <label for="name">Név:</label>
                <input required id="name" maxlength="100" type="text" name="name" /><br />

                <label for="feedback">Részletes és kifejtett építő jellegű véleménye:</label>
                <textarea required id="feedback" name="feedback"></textarea><br />

                <label class="required"><input required type="checkbox" /> Belegyezek, hogy harmadik fél kezelje az adataimat.</label>

                <input type="submit" value="Küldés" />
                <input type="reset" value="Vissza mindent" />
                <?php if (isset($_GET["success"]) && $_GET["success"] == "1") { ?>
                    <span id="success" class='ok'>A visszajelzés sikeresen elküldve!</span>
                <?php } ?>
            </fieldset>
        </form>
    </main>
    <?php include(__DIR__.'/components/footer.php'); ?>
</body>

</html>