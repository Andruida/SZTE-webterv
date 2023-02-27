<?php 
include(__DIR__.'/backend/validator.php'); 

session_start();

?>
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

        <?php if (isset($_SESSION['id']) && !empty($_SESSION['id'])) { ?>
        <div class="rate" >
            <input type="radio" id="star5" name="rating" value="5" />
            <label for="star5" title="5 csillag">5 csillag</label>
            <input type="radio" id="star4" name="rating" value="4" />
            <label for="star4" title="4 csillag">4 csillag</label>
            <input type="radio" id="star3" name="rating" value="3" />
            <label for="star3" title="3 csillag">3 csillag</label>
            <input type="radio" id="star2" name="rating" value="2" />
            <label for="star2" title="2 csillag">2 csillag</label>
            <input type="radio" id="star1" name="rating" value="1" />
            <label for="star1" title="1 csillag">1 csillag</label>
        </div>
        <?php } ?>
        


    </main>
    <?php include(__DIR__.'/components/footer.php'); ?>

    <script src="js/jquery-3.6.3.min.js"></script>
    <script src="js/project_loader.js"></script>
    <script src="js/rating.js"></script>

</body>

</html>