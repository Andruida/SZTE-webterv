<?php
include(__DIR__ . '/backend/validator.php');

require(__DIR__ . '/backend/conn.php');

$results = mysqli_query($conn, 
    "SELECT p.`id`, p.`name`, p.`description`, AVG(r.`rating`) as `rating` FROM projects p
    LEFT JOIN ratings r ON r.project_id = p.id
    GROUP BY p.`id`, p.`name`, p.`description`"
);
?>
<!DOCTYPE html>
<html lang="hu">

<?php
$CSS = ["css/rating.css"];
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
                    <div class="readOnlyRating">
                        <label title="5 csillag" class="<?= (round($row["rating"]) >= 5) ? "checked" : "" ?>">5 csillag</label>
                        <label title="4 csillag" class="<?= (round($row["rating"]) >= 4) ? "checked" : "" ?>">4 csillag</label>
                        <label title="3 csillag" class="<?= (round($row["rating"]) >= 3) ? "checked" : "" ?>">3 csillag</label>
                        <label title="2 csillag" class="<?= (round($row["rating"]) >= 2) ? "checked" : "" ?>">2 csillag</label>
                        <label title="1 csillag" class="<?= (round($row["rating"]) >= 1) ? "checked" : "" ?>">1 csillag</label>
                    </div>
                </div>
            <?php } ?>
        </div>

    </main>

    <?php include(__DIR__ . '/components/footer.php'); ?>

    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/project_list.js"></script>
</body>

</html>