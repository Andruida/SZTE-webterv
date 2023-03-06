<?php
include(__DIR__ . '/backend/validator.php');

session_start();

require(__DIR__ . '/backend/conn.php');

$stmt = mysqli_prepare(
    $conn,
    "SELECT p.`id`, p.`name`, p.`description`, AVG(r.`rating`) as `rating` FROM projects p
        LEFT JOIN ratings r ON r.project_id = p.id
        WHERE p.`id` = ?
        GROUP BY p.`id`, p.`name`, p.`description`"
);
$success = mysqli_stmt_execute($stmt, [$_GET['projectId']]);
$result = mysqli_stmt_get_result($stmt);

if (!$success || mysqli_num_rows($result) === 0) {
    header('Location: projektek.php');
    die();
}

$project = mysqli_fetch_assoc($result);
mysqli_free_result($result);
if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $stmt = mysqli_prepare(
        $conn,
        "SELECT r.`rating` FROM ratings r
        WHERE r.`user_id` = ? AND r.`project_id` = ?"
    );
    $success = mysqli_stmt_execute($stmt, [$_SESSION['id'], $_GET['projectId']]);
    $result = mysqli_stmt_get_result($stmt);

    $rating = null;
    if ($success && mysqli_num_rows($result) > 0) {
        $rating = mysqli_fetch_assoc($result)["rating"];
        mysqli_free_result($result);
    }
}

?>
<!DOCTYPE html>
<html lang="hu">

<?php
$CSS = ["css/rating.css"];
$TITLE_SUFFIX = $project["name"];
include(__DIR__ . '/components/head.php');
?>

<body>
    <?php
    $ACTIVE = 'Projektek';
    include(__DIR__ . '/components/header.php');
    ?>
    <main>
        <article>
            <h2><?= $project["name"] ?></h2>
            <img src="img/projects/<?= $project["id"] ?>.png" alt="" width="100" />
            <p>
                <?= $project["description"] ?>
            </p>
            <audio controls>
                <source src="sounds/<?= $project["id"] ?>.mp3" type="audio/mpeg">
                A böngésződ sajnos nem támogatja csodás dalaim lejátszását :c
            </audio>
        </article>

        <br />

        <div class="ratingBox">
            <?php if (isset($_SESSION['id']) && !empty($_SESSION['id'])) { ?>
                <div class="borderless">Értékeld a művet: </div>
                <div class="rate">
                    <input type="radio" <?= ($rating == 5) ? "checked" : "" ?> id="star5" name="rating" value="5" />
                    <label for="star5" title="5 csillag">5 csillag</label>
                    <input type="radio" <?= ($rating == 4) ? "checked" : "" ?> id="star4" name="rating" value="4" />
                    <label for="star4" title="4 csillag">4 csillag</label>
                    <input type="radio" <?= ($rating == 3) ? "checked" : "" ?> id="star3" name="rating" value="3" />
                    <label for="star3" title="3 csillag">3 csillag</label>
                    <input type="radio" <?= ($rating == 2) ? "checked" : "" ?> id="star2" name="rating" value="2" />
                    <label for="star2" title="2 csillag">2 csillag</label>
                    <input type="radio" <?= ($rating == 1) ? "checked" : "" ?> id="star1" name="rating" value="1" />
                    <label for="star1" title="1 csillag">1 csillag</label>
                </div>
            <?php } ?>
            <div class="borderless">Mások így értékelték:</div>
            <div class="readOnlyRating">
                <label title="5 csillag" class="<?= (round($project["rating"]) >= 5) ? "checked" : "" ?>">5 csillag</label>
                <label title="4 csillag" class="<?= (round($project["rating"]) >= 4) ? "checked" : "" ?>">4 csillag</label>
                <label title="3 csillag" class="<?= (round($project["rating"]) >= 3) ? "checked" : "" ?>">3 csillag</label>
                <label title="2 csillag" class="<?= (round($project["rating"]) >= 2) ? "checked" : "" ?>">2 csillag</label>
                <label title="1 csillag" class="<?= (round($project["rating"]) >= 1) ? "checked" : "" ?>">1 csillag</label>
            </div>
        </div>



    </main>
    <?php include(__DIR__ . '/components/footer.php'); ?>

    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/rating.js"></script>

</body>

</html>