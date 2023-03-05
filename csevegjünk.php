<?php 
include(__DIR__.'/backend/validator.php'); 
session_start();

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header('Location: bejelentkezés.php');
    exit();
}

foreach ($_GET as $key => $value) {
    if (!empty($value)) {
        $_GET[$key] = htmlspecialchars(trim($value));
    }
}

function isServiceSelected($id) {
    if (!isset($_GET['szolgaltatas'])) return false;
    return ($_GET['szolgaltatas'] & (1 << $id));
}

?>
<!DOCTYPE html>
<html lang="hu">

<?php
$TITLE_SUFFIX = 'Csevegjünk';
include(__DIR__.'/components/head.php'); 
?>
<body>
    <?php 
    $ACTIVE = 'Csevegjünk!';
    include(__DIR__.'/components/header.php'); 
    ?>

    <main>
        <article>
        
            <h1> Időpontfoglalás</h1>
            <p>Üdvözöljük az időpontfoglalás oldalunkon! Az oldal segítségével kényelmesen foglalhat időpontot
                szolgáltatásainkra.</p>
            <p>Időpontfoglalás lépései</p>
            <ol>
                <li>Válassza ki a kívánt szolgáltatást.</li>
                <li>Válassza ki a dátumot és az időpontot.</li>
                <li>Adja meg az adatait, beleértve a nevét, az e-mail címét és a telefonszámát.</li>
                <li>Ellenőrizze a foglalási információkat, és ha minden rendben van, kattintson a "Foglalás" gombra.
                </li>
            </ol>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th rowspan="2">Szolgáltatás neve</th>
                            <th rowspan="2">Hossz (perc)</th>
                            <th colspan="3">Típus</th>
                            <th rowspan="2" class="nomobile">Leírás</th>
                        </tr>
                        <tr>
                            <th>Személyes Ár (HUF)</th>
                            <th>Teams Ár (HUF)</th>
                            <th>Google Meet Ár (HUF)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Hangtechnikai szolgáltatások</td>
                            <td>60</td>
                            <td>7000</td>
                            <td>6000</td>
                            <td>5000</td>
                            <td class="nomobile">Az élő események, a reklámfilmek és a filmek hangosítására és
                                feldolgozására szolgáló szolgáltatások.</td>
                        </tr>
                        <tr>
                            <td>Hang újra felvevő szolgáltatások</td>
                            <td>120</td>
                            <td>10000</td>
                            <td>11000</td>
                            <td>12000</td>
                            <td class="nomobile">Azokat a szolgáltatásokat, amelyek lehetővé teszik a régi vagy elavult
                                hangfájlok újrafelvételét, frissítését vagy megújítását.</td>
                        </tr>
                        <tr>
                            <td>Hangfájl transzkódolása</td>
                            <td>20</td>
                            <td>6000</td>
                            <td>5000</td>
                            <td>4000</td>
                            <td class="nomobile">Az audio formátum átalakítását jelenti, például MP3-ból WAV-ba vagy
                                vice
                                versa.</td>
                        </tr>
                        <tr>
                            <td>Hangfájl minőség javítása</td>
                            <td>50</td>
                            <td>15000</td>
                            <td>14000</td>
                            <td>13000</td>
                            <td class="nomobile">Az alacsony minőségű hangfájlok javítását jelenti, beleértve a
                                zajszűrést,
                                a frekvencia-állomány javítását és a hangerőszabályozást.</td>
                        </tr>
                        <tr>
                            <td>Hangfájl szerkesztése</td>
                            <td>180</td>
                            <td>20000</td>
                            <td>21000</td>
                            <td>22000</td>
                            <td class="nomobile">A hangfájlok kézi szerkesztése, például a zajok eltávolítása, a
                                hangeffektek hozzáadása és a hang időzítésének finomítása.</td>
                        </tr>
                        <tr>
                            <td>Hangfájl többszintű rendszerezése:</td>
                            <td>200</td>
                            <td>25000</td>
                            <td>26000</td>
                            <td>27000</td>
                            <td class="nomobile">A hangfájlok kategóriákra, projektekre és mappákra történő
                                rendszerezése,
                                hogy könnyen kereshetők és megtalálhatók legyenek.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </article>
        <form action="backend/orders.php" method="post">
            <fieldset>
                <legend>Találkozz velünk!</legend>
                <div style="margin-top: 0;">
                    <label class="required">Választott szolgáltatás:</label>
                    <input type="checkbox" id="szolgaltatas1" name="szolgaltatas[]" value="0"
                        <?= isServiceSelected(0) ? "checked" : "" ?> />
                    <label for="szolgaltatas1"> Hangtechnikai szolgáltatások</label><br />
                    <input type="checkbox" id="szolgaltatas2" name="szolgaltatas[]" value="1" 
                        <?= isServiceSelected(1) ? "checked" : "" ?> />
                    <label for="szolgaltatas2"> Hang újra felvevő szolgáltatások</label><br />
                    <input type="checkbox" id="szolgaltatas3" name="szolgaltatas[]" value="2" 
                        <?= isServiceSelected(2) ? "checked" : "" ?> />
                    <label for="szolgaltatas3"> Hangfájl transzkódolása</label><br />
                    <input type="checkbox" id="szolgaltatas4" name="szolgaltatas[]" value="3"
                        <?= isServiceSelected(3) ? "checked" : "" ?> />
                    <label for="szolgaltatas4"> Hangfájl minőség javítása</label><br />
                    <input type="checkbox" id="szolgaltatas5" name="szolgaltatas[]" value="4"
                        <?= isServiceSelected(4) ? "checked" : "" ?> />
                    <label for="szolgaltatas5"> Hangfájl szerkesztése</label><br />
                    <input type="checkbox" id="szolgaltatas6" name="szolgaltatas[]" value="5"
                        <?= isServiceSelected(5) ? "checked" : "" ?> />
                    <label for="szolgaltatas6"> Hangfájl tömörítése</label><br />
                    <input type="checkbox" id="szolgaltatas7" name="szolgaltatas[]" value="6" 
                        <?= isServiceSelected(6) ? "checked" : "" ?> />
                    <label for="szolgaltatas7"> Hangfájl többszintű rendszerezése</label><br />
                </div>
                <label class="required" for="typeSelect">Válassza ki a kapcsolatfelvétel módját:</label>
                <select id="typeSelect" name="typeSelect">
                    <option value="Személyes találkozó"
                        <?= (!empty($_GET["typeSelect"]) && 
                            $_GET["typeSelect"] == "Személyes találkozó") ? "selected" : "" ?>>
                        Személyes találkozó
                    </option>
                    <option value="Teams meet"
                        <?= (!empty($_GET["typeSelect"]) && 
                            $_GET["typeSelect"] == "Teams meet") ? "selected" : "" ?>>
                        Teams meet
                    </option>
                    <option value="Google meet"
                    <?= (!empty($_GET["typeSelect"]) && 
                            $_GET["typeSelect"] == "Google meet") ? "selected" : "" ?>>
                        Google meet
                    </option>
                </select>

                <label for="date" class="required">Melyik nap érsz rá?</label>
                <input required id="date" type="date" name="date" 
                    value="<?= (!empty($_GET["date"])) ? $_GET["date"] : "" ?>"><br />

                <label for="time" class="required">Milyen időpontban?</label>
                <input required id="time"type="time" name="time"
                    value="<?= (!empty($_GET["time"])) ? $_GET["time"] : "" ?>"><br />

                <label for="phone" class="required">Írd be a telefonszámod:</label>
                <input id="phone" required type="tel" placeholder="pl. +36 30 123 4567"
                    pattern="\+36 [0-9]{2} [0-9]{3} [0-9]{4}" name="mobileNumber"
                    value="<?= (!empty($_GET["mobileNumber"])) ? $_GET["mobileNumber"] : "" ?>"><br />

                
                <input type="submit" value="Foglalás" />
                <?php if (isset($_GET["success"]) && $_GET["success"] == "1") { ?>
                    <span id="success" class='ok'>Az időpontfoglalás sikeresen elküldve!</span>
                <?php } ?>
                
            </fieldset>
        </form>
    </main>

    <?php include(__DIR__."/components/footer.php"); ?>
</body>

</html>