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
            <iframe src="<?php echo $_GET['url'] ?>" name="contenu" width="100%" height="300px" marginwidth="0" marginheight="0" scrolling="Auto" frameborder="0" id="contenu"></iframe>
        </div>
        <br/>
        <br/>
        <br/>
        <b>Description:</b></br>
        Cette page contient une iframe utilisant le fichier présent dans la requête get.<br/>
        Cette faille est appelée la faille include. <br/>
        <br/>
        <b>Attaque :</b><br/>
        Un attaquant peut utiliser cette page pour récupérer des identifiants d'un htacces par exemple. <br/>
        Il existe un répertoire protégé par un htaccess (/admin).<br/>
        L'attaquant peut donc faire un fichier php contenant uniquement la ligne ci-dessous sur son serveur et l'executer en mettant l'url en get.
        <br/><br/>
        par exemple noux avons créé un fichier test.php nous l'ajoutons à l'URL : <font color="red"><?= $urlsite;?>owasp/public_html/include.php?url=test.php</font> <br/><br/>
        <br/>
        <b>Script : </b><br/>
            echo file_get_contents('./admin/.htpasswd');<br/>
    </body>
</html>
