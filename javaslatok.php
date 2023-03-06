<?php
include(__DIR__ . '/backend/validator.php');

session_start();
require(__DIR__ . '/backend/conn.php');

$results = mysqli_query($conn, "SELECT * FROM feedback");

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header('Location: bejelentkezés.php');
    exit();
}

if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: profil.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="hu">

<?php
$TITLE_SUFFIX = 'Javaslatok';
include(__DIR__ . '/components/head.php');
?>

<body>
    <?php
    $ACTIVE = 'Javaslatok';
    include(__DIR__ . '/components/header.php');
    ?>
    <main>
        <div style="overflow-x: auto;">
            <table class="order_table">
                <thead>
                    <tr>
                        <th>Email cím:</th>
                        <th>Név:</th>
                        <th class="third-column">Javaslat:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while($row = mysqli_fetch_assoc($results)) {
                    ?>
                    <tr>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['body'] ?></td>
                    </tr>
                   <?php }?>
                </tbody>
            </table>
        </div>
    </main>
    <?php include(__DIR__ . "/components/footer.php"); ?>
</body>

</html>