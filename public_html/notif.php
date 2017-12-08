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

        <nav id='nav_bar'>
            <nav class ="navbar navbar-inverse">
                <div class="container">
                    <div class="container-fluid">
                        <ul class="nav navbar-nav">
                            <li class="active"> <a href="index.php">Accueil</a> </li>
                            <form class='navbar-form navbar-right inline-form' action='connexion.php' method='POST'>
                                <div class='form-group'>
                                    <input type='text' placeholder='nom' class='form-control1' name='nom'>
                                </div>
                                <div class='form-group'>
                                    <input type='Password' placeholder='mot de passe' class='form-control1' name='mdp'>
                                </div>
                                <button type='submit' class='btn btn-success' >S'identifier</button>
                            </form>
                    </div>
                </div>
            </nav>
        </nav>
        <div class="body-center"><b>Description:</b><br/>
            Ce serveur contient une section securisée réservée aux administrateurs.<br/>
            Cette page est située à l'adresse <?php echo $urlsite; ?>admin <br/>
            Pour y accéder, il existe un htaccess de protection.<br/>
            Malheureusement, les administrateurs n'ont pas patchés la faille htaccess.<br/>
            
        </div>
    </body>   
</html>
