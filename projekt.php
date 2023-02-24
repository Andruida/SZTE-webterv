<?php include(__DIR__.'/backend/validator.php'); ?>
<!DOCTYPE html>
<html lang="hu">

<?php 
$TITLE_SUFFIX = htmlspecialchars($_GET['projectName']);
include(__DIR__.'/components/head.php'); 
?>

<body>
    <?php 
    $ACTIVE = 'Projektjeim';
    include(__DIR__.'/components/header.php'); 
    ?>
    <main>
        <article>
            <h2><span id="projectName"></span></h2>
            <img src="#" alt="" width="100" id="projectImage" />
            <p id="description"></p>
            <audio controls id="song">
                <source src="#" type="audio/mpeg">
                A böngésződ sajnos nem támogatja csodás dalaim lejátszását :c
            </audio>
        </article>

        <br />
        
        <div class="stars">
            <p>Értékeld a művet:</p>
            <span>★</span>
            <span>★</span>
            <span>★</span>
            <span>★</span>
            <span>★</span>
        </div>


    </main>
    <?php include(__DIR__.'/components/footer.php'); ?>

    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/project_loader.js"></script>

</body>

</html>