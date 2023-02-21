<!DOCTYPE html>
<html lang="hu">

<?php
$TITLE_SUFFIX = 'Bejelentkezés';
include(__DIR__.'/components/head.php'); 
?>

<body>

    <?php
    $ACTIVE = 'Bejelentkezés';
    include(__DIR__.'/components/header.php'); 
    ?>

    <h1>Bejelentkezés</h1>
    <form action="backend/login.php" method="post">
        <fieldset>
            <div class="borderless">
                <label for="email">Email cím:</label>
                <input type="text" id="email" name="email"/><br />
                <label for="password">Jelszó:</label>
                <input type="password" id="password" name="password"><br />
                <input type="submit" value="Bejelentkezés"/>
            </div>
        </fieldset>
    </form>

    <hr>

    <h1>Regisztráció</h1>
    <form action="backend/register.php" method="post">
        <fieldset>
            <div class="borderless">
                <label for="display_name">Felhasználónév:</label>
                <input type="text" id="display_name" name="display_name" /><br />

                <label for="email">E-mail cím:</label>
                <input type="email" id="email" name="email"><br />

                <label for="password">Jelszó:</label>
                <input type="password" id="password" name="password" /><br />

                <label for="password1">Jelszó mégegyszer:</label>
                <input type="password" id="password1" name="password1" /><br />

                <label for="birth_date">Születési dátum:</label>
                <input type="date" id="birth_date" name="birth_date" /><br />

                <label for="introduction">Bemutatkozás:</label>
                <textarea id="introduction" name="introduction" rows="3"></textarea><br />



                <input type="submit" value="Regisztráció">
            </div>
        </fieldset>
    </form>

    <?php include(__DIR__."/components/footer.php"); ?>
</body>

</html>