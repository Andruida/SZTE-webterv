<?php
include(__DIR__ . '/backend/validator.php');

require(__DIR__ . '/backend/conn.php');

$results = mysqli_query($conn, "SELECT * FROM projects");
?>
<!DOCTYPE html>
<html lang="hu">

<?php
$TITLE_SUFFIX = 'Projektjeim';
include(__DIR__ . '/components/head.php');
?>

<body>
    <?php
    $ACTIVE = 'Projektjeim';
    include(__DIR__ . '/components/header.php');
    ?>

    <main>
        <h2>Projektjeim</h2>
        <div id="list">
            <?php while ($row = mysqli_fetch_assoc($results)) { ?>
                <div data-project-id="<?= $row["id"] ?>" class="card">
                    <img src="img/projects/<?= $row["id"] ?>.png" alt="<?= $row["name"] ?>">
                    <h3><?= $row["name"] ?></h3>
                    <p>
                        <?= $row["description"] ?>
                    </p>
                </div>
            <?php } ?>
        </div>

    </main>

    <?php include(__DIR__ . '/components/footer.php'); ?>

    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/project_list.js"></script>
</body>

</html>