<?php
session_start();
require_once __DIR__ . '/../db_config.php';
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>profil</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css.css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    </head>
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

        <?php include("menu.php"); ?>
        Cette page sert habituellement à pouvoir consulter mon phpinfo. <br/>
        
        <br/><br/>
        <b>Description: </b>
        Cette page contient une faille eval().<br/>
        Si un utilisateur l'utilise correctement il peut obtenir un accès complet sur le serveur.<br/>
        <br/>
        <br/>
        <b>POC:</b> 
        Pour tester, changer le "phpinfo(); en system('cat /etc/passwd');<br/><br/>
        Cette faille est très rare sur internet, mais elle permet cependant de controller totalement la machine et de faire une escalation de privilège par la suite.<br/>

        <div>
        <?php
            $ev = $_GET['ev'];
            eval('$output = ' . $_GET['ev'] . ';');
            
        ?>  
        </div>
        
    </body>   
</html>