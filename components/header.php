<?php

session_start();

$pages = [
    "Kezdőlap" => "index.php",
    "Projektjeim" => "projektek.php",
    "Javaslatok" => "visszajelzes.php",
    "Csevegjünk!" => "csevegjünk.php",
];

if (isset($ACTIVE) && !empty($ACTIVE)) {
    $_active = $ACTIVE;
} else {
    $_active = 'Kezdőlap';
}
?>
<header>
    <div class="company">
        <img id="logo" src="img/logo/logocrop.png" alt="Cég logó">
        <h1>HangÁr</h1>
        <blockquote>Én adom a hangot, Ön adja az árát!</blockquote>
    </div>
    <nav>
        <?php 
        foreach ($pages as $_page_name => $_href) { 
            if ($_page_name === $_active) {
                $_class =" active";
            } else {
                $_class = "";
            }
        ?>
        <a class="nav-link<?= $_class ?>" href="<?= $_href ?>"><?= $_page_name ?></a>
        <?php }
        if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
            $_page_name = "Kijelentkezés";
            $_href = "backend/logout.php";
        } else {
            $_page_name = "Bejelentkezés";
            $_href = "login_register.php";
        }
        ?>
        <a class="nav-link<?= $_class ?>" href="<?= $_href ?>"><?= $_page_name ?></a>
    </nav>
</header>
<hr>
<?php unset($_active, $_page_name, $_href, $_class); ?>