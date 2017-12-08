<?php
session_start();
require_once __DIR__ . '/../db_config.php';
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Upload</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <head/>
    <body>

        <?php
        $newsList = $db->query("SELECT * FROM calendrier");
        ?>


        <div class="jumboton">
            <div class="container">
                <h1><a href="index.php">Administration asso</a></h1>
            </div>
        </div>

        <?php include("menu.php"); ?>
        <div id="hauteur">
            <form action="" method="GET">
                <div id="formulaire">
                    <label>Numéro de news</label>
                    <select name="newsId" id="champ">
                        <?php foreach ($newsList as $news): ?>
                            <option value="<?= $news['id'] ?>"><?= $news['name'] ?></option>
                        <?php endforeach ?>
                    </select></br>
                    <input type="submit" id="inscrire1" value="Supprimer"/>
                </div>
            </form>


            <br/><br/>
            <b>Description: </b>
            Cette page contient une faille csrf.<br/>
            
            <br/>
            <br/>
            <br/>
            <b>POC:</b>
            Pour faire supprimer une news à un administrateur, il suffit de lui envoyer le lien suivant : <br/>
            http://79.137.87.179/csrf.php?newsId=IDdeLaNewsASupprimer <br/>
            <br/>
            Pour se protéger, il faudrait ajouter un jeton CSRF sur la page.<br/>
            Ce jeton est généré lors de la création du formulaire, et on vérifie qu'il concorde avec l'utilisateur qui clique sur le formulaire.


            <body/>   
</html>