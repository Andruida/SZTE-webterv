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
        <form>
            <fieldset>
                <legend>Visszajelzés</legend>
                <label>Email címed: <input type="email" /></label>
                <label>Név:
                    <input type="text" /></label>
                <label>Részletes és kifejtett építő jellegű véleménye:
                    <textarea></textarea></label>
                <label><input type="checkbox" /> Belegyezek, hogy harmadik fél kezelje az adataimat.</label>
                <input type="submit" value="Küldés" />
                <input type="reset" value="Vissza mindent" />
            </fieldset>
        </form>
    </main>
    <?php include(__DIR__.'/components/footer.php'); ?>
</body>

</html>