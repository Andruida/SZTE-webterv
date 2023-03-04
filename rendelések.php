<?php 
include(__DIR__ . '/backend/validator.php'); 

session_start();
require(__DIR__ . '/backend/conn.php');
$results = mysqli_query($conn, "SELECT * FROM orders INNER JOIN users ON orders.user_id=users.id");
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header('Location: bejelentkezés.php');
    exit();
}

if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: profil.php');
    exit();
}

$servicesToPickFrom = [
    "Hangtechnikai szolgáltatások",
    "Hang újra felvevő szolgáltatások",
    "Hangfájl transzkódolása",
    "Hangfájl minőség javítása",
    "Hangfájl szerkesztése",
    "Hangfájl tömörítése",
    "Hangfájl többszintű rendszerezése"
];

$possibleWaysOfContact = [
    "PERSONAL" => "Személyes találkozó",
    "TEAMS" => "Microsoft Teams",
    "MEET" => "Google Meet"
];

?>
<!DOCTYPE html>
<html lang="hu">

<?php
$TITLE_SUFFIX = 'Rendelések';
$CSS = ["css/orderstyle.css"];
include(__DIR__ . '/components/head.php');
?>
<body>
    <?php
    $ACTIVE = 'Rendelések';
    include(__DIR__ . '/components/header.php');
    ?>
    <div style="overflow-x: auto;">
        <table class="order_table">
            <thead>
            <tr>
                    <th>Ügyfél elérhetősége</th>
                    <th>Ügyfél telefonszáma</th>
                    <th>Igényelt szolgáltatás</th>
                    <th>Találkozó módja</th>
                    <th>Találkozó időpontja</th>
                </tr>
            </thead>
            <tbody>
                
                <?php while ($row = mysqli_fetch_assoc($results)) { 
                    foreach ($row as $key => $value) {
                        $row[$key] = htmlspecialchars($value);
                    }
                    $services = [];
                    foreach ($servicesToPickFrom as $i=>$service) {
                        if ($row['services'] & (1 << $i)) {
                            $services[] = $service;
                        }
                    }
                    $row['services_rendered'] = implode('</li><li> ', $services);
                    ?>

                    <tr>
                        <td><a href="mailto:<?= $row['email'] ?>" title="<?= $row['email'] ?>"><?= $row['display_name'] ?></a></td>
                        <td><?= $row['phone'] ?></td>
                        <td>
                            <?php if (count($services) > 0) { ?>
                            <ul><li><?= $row['services_rendered'] ?></li></ul>
                            <?php } ?>
                        </td>
                        <td><?= $possibleWaysOfContact[$row['way_of_contact']] ?></td>
                        <td><?= $row['datetime'] ?></td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php include(__DIR__ . "/components/footer.php"); ?>
</body>

</html>