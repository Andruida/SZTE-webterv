<?php

session_start();

$_pages = [
    "Kezdőlap" => "index.php",
    "Projektjeim" => "projektek.php",
    "Javaslatok" => "visszajelzes.php",
    "Csevegjünk!" => "csevegj%C3%BCnk.php",
];

if (isset($_SESSION["id"]) && !empty($_SESSION["id"])) {
    $_pages["Profilom"] = "profil.php";
    $_pages["Kijelentkezés"] = "backend/logout.php";
} else {
    $_pages["Bejelentkezés"] = "bejelentkez%C3%A9s.php";
}

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
        foreach ($_pages as $_page_name => $_href) { 
            if ($_page_name === $_active) {
                $_class =" active";
            } else {
                $_class = "";
            }
        ?>
        <a class="nav-link<?= $_class ?>" href="<?= $_href ?>"><?= $_page_name ?></a>
        <?php } ?>
    </nav>
</header>
<hr>
<?php unset($_active, $_page_name, $_href, $_class, $_pages); ?>