<?php
session_start();
require_once __DIR__ . '/../db_config.php';
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>accueil</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <head/>
    <body>
        <div class="jumboton">
            <div class="container">
                <h1><a href="index.php">Administration asso</a></h1>
            </div>
        </div>
        <?php include('menu.php'); ?>
        <div>
            <iframe src="<?= $_GET['url'] ?>" name="contenu" width="100%" height="100%" marginwidth="0" marginheight="0" scrolling="Auto" frameborder="0" id="contenu"></iframe>
        </div>
    </body>
</html>
