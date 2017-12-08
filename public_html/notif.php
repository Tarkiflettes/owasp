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

    </head>
    <body>
        <div class="jumboton">
            <div class="container">
                <h1><a href="index.php">Administration asso</a></h1>
            </div>
        </div>
        <?php include('menu.php'); ?>
        <div class="body-center"><b>Description:</b><br/>
            Ce serveur contient une section securisée réservée aux administrateurs.<br/>
            Cette page est située à l'adresse <font color="red"><?php echo $urlsite; ?>owasp/public_html/admin <br/></font>
            Pour y accéder, il existe un htaccess de protection.<br/>
            Malheureusement, les administrateurs n'ont pas patchés la faille htaccess.<br/>
            
            Pour y accéder, il suffit d'installer sur son ordinateur un petit logiciel appelé "Burp Suite".<br/>
            Vous changer ensuite la requête http en mettant n'importe une chaine de caractère à la place de "GET" dans la requête.<br/>
            Vous avez ensuite accès à la page.
        </div>
    </body>   
</html>
