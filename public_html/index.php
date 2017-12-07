<?php
session_start();
require_once __DIR__ . '/../db_config.php';
?>

<!DOCTYPE HTML>
<html>
<<<<<<< HEAD
  <head>
    <title>accueil</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

  <head/>
  <body>
  <?php
  session_start();
  require_once __DIR__ . '/../newdb_config.php';
  // connecting to db
  $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USER, DB_PASSWORD) or die(mysql_error());
  ?>
  
    <div class="jumboton">
      <div class="container">
        <h1><a href="index.php">OWASP</a></h1>
      </div>
    </div>

    <nav id='nav_bar'>
      <nav class ="navbar navbar-inverse">
        <div class="container">
          <div class="container-fluid">
            <ul class="nav navbar-nav">
              <li class="active"> <a href="index.php">Accueil</a> </li>


              <?php
               if (isset($_SESSION['id']))
              {              
                ?>
                <li> <a href="news.php">news</a> </li>
                <li> <a href="calendrier.php">calendrier</a> </li>
                <li> <a href="membres.php">membres</a> </li>
                <li> <a href="partenariats.php">partenariats</a> </li>
                <li> <a href="notif.php">notif</a> </li>
                <?php
                if($_SESSION['id'] == -1){
                  echo "<li> <a href='comptes.php'>comptes</a> </li>";
                }
              }
              ?>
            </ul>


            <?php
            if (!isset($_SESSION['id'])){

              echo "<form class='navbar-form navbar-right inline-form' action='connexion.php' method='POST'>";
                echo "<div class='form-group'>";
                  echo "<input type='text' placeholder='nom' class='form-control1' name='nom'>";
                echo "</div>";
                echo "<div class='form-group'>";
                  echo "<input type='Password' placeholder='mot de passe' class='form-control1' name='mdp'>";
                echo "</div>";
                echo "<button type='submit' class='btn btn-success' >S'identifier</button>";
              echo "</form>";

               
            }
            else{

              echo "<form class='navbar-form navbar-right inline-form' action='deconnexion.php' method='POST'>";
                echo "<button type='submit' class='btn btn-success' >Deconnexion</button>";
              echo "</form>";

              $req = $db->prepare("SELECT * FROM nomasso WHERE idasso = :id");

              $req->execute(array(
                ':id' => $_SESSION['id']
            ));
              $donnees = $req->fetch();
=======
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
>>>>>>> f8190e33b8dbfa0bee5b116ed5b36655ef8a5b95

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
            Cette page contient une faille d'injection SQL.
            Vous pouvez vous connecter directement en admin avec les identifiants suivants :<br/>
            nom : admin<br/>
            mot de passe : ' or '1=1<br/>
            <br/>
            Le mot de passe de base était pourtant : Admn1str@t3ur<br/>
            <br/>
            Il est également possible de se connecter en mettant ' or '1=1 au lieu de l'identifiant admin
        </div>
    </body>   
</html>
