<?php include(__DIR__.'/backend/validator.php'); ?>
<!DOCTYPE html>
<html lang="hu">

<?php 
$TITLE_SUFFIX = 'Projektjeim';
include(__DIR__.'/components/head.php'); 
?>

<body>
    <?php 
    $ACTIVE = 'Projektjeim';
    include(__DIR__.'/components/header.php'); 
    ?>

    <main>
        <h2>Projektjeim</h2>
        <div id="list">
            <span id="loadingText">Betöltés alatt (csak webszerverről megnyitva fog betölteni)</span>
        </div>

    </main>

    <?php include(__DIR__.'/components/footer.php'); ?>

    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/project_list.js"></script>
</body>

</html>