<!DOCTYPE HTML>
<html>
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
        <h1><a href="index.php">Administration asso</a></h1>
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
            $req = $db->prepare("SELECT * FROM nomasso WHERE idasso = :id");

            $req->execute(array(':id' => $_SESSION['id']));
            $donnees = $req->fetch();
            ?>

            <?php if(!isset($_SESSION['id'])): ?>

              <form class='navbar-form navbar-right inline-form' action='connexion.php' method='POST'>
                <div class='form-group'>
                  <input type='text' placeholder='nom' class='form-control1' name='nom'>
                </div>
                <div class='form-group'>
                  <input type='Password' placeholder='mot de passe' class='form-control1' name='mdp'>
                </div>
                <button type='submit' class='btn btn-success' >S'identifier</button>
              </form>

               
            }
            <?php else: ?>
              <form class='navbar-form navbar-right inline-form' action='deconnexion.php' method='POST'>
                <button type='submit' class='btn btn-success' >Deconnexion</button>
              </form>
              <form class='navbar-form navbar-right inline-form' action='profil.php' method='POST'>
                <button type='submit' class='btn btn-success' >Profil <?=$donnees['nomasso']?></button>
              </form>
            <?php endif ?>
            ?>
          </div>
        </div>
      </nav>
    </nav>
      <div>Bienvenue sur la page d'accueil du site</div>
  <body/>   
</html>
