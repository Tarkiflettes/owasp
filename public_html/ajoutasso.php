<?php
    session_start();
    require_once __DIR__ . '/../newdb_config.php';
  // connecting to db
  $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USER, DB_PASSWORD) or die(mysql_error());
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>inscription</title>
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

    <nav id='nav_bar'>
      <nav class ="navbar navbar-inverse">
        <div class="container">
          <div class="container-fluid">
            <ul class="nav navbar-nav">
              <li> <a href="index.php">Accueil</a> </li>

              <?php
              if (isset($_SESSION['id']))
              {              
                ?>
                <li> <a href="news.php">news</a> </li>
                <li> <a href="calendrier.php">calendrier</a> </li>
                <li> <a href="membres.php">membres</a> </li>
                <li> <a href="notif.php">notif</a> </li>
                <li> <a href="partenariats.php">partenariats</a> </li>
                <?php
                if($_SESSION['id'] == -1){
                  echo "<li class='active'> <a href='comptes.php'>comptes</a> </li>";
                }
              }
              ?>
            </ul>

            <?php
            if (!isset($_SESSION['id'])){
              echo "<form class='navbar-form navbar-right inline-form' action='connexion.php' method='POST'>";
                echo "<div class='form-group'>";
                  echo "<input type='text' placeholder='pseudo' class='form-control1' name='pseudo'>";
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

              echo "<form class='navbar-form navbar-right inline-form' action='profil.php' method='POST'>";
                echo "<button type='submit' class='btn btn-success' >Profil ".$donnees['nomasso']."</button>";
              echo "</form>";
            }
            ?>
          </div>
        </div>
      </nav>
    </nav>

    <?php

    if(!isset($_SESSION['id']))
      header('Location: index.php');

    if (isset($_POST["nom"]) && isset($_POST["idasso"]) && isset($_POST["couleur"]) && isset($_POST["email"]) && isset($_POST["photo"])) {
      $connection =0;

            // caractères ASCII
      $lower   = range(97, 122);  // 26 caractères 33 - 126
      $upper   = range(65, 90);   // 26 caractères
      $numeric = range(48, 57);   // 10 caractères
      $base    = array_map('chr', array_merge($lower, $upper, $numeric));
      shuffle($base);
       
      // clé de salage de 40 caractères
      $salt = '';
      for($i = 0; $i < 40; ++$i) {
         $salt .= $base[mt_rand(0, 51)];
      }
      $pass=htmlspecialchars($_POST["motdepasse"]);
      
      //Là, $pass a hasher="monmotdepassemonsalage"
      $mdp = sha1($pass.$salt);

        //récupération des valeurs des champs:
        $nom = htmlspecialchars($_POST["nom"]);
        $idasso = htmlspecialchars($_POST["idasso"]);
        $couleur = htmlspecialchars($_POST["couleur"]);
        $email = htmlspecialchars($_POST["email"]);
        $photo = htmlspecialchars($_POST["photo"]);

          //changement du format de date en francais 

        // lancement de la requete
        $req = $db->prepare("INSERT INTO nomasso(nomasso, idasso, couleur, email, photo) VALUES(:nomasso, :idasso, :couleur, :email, :photo)");
        $success = $req->execute(array(
          ':nomasso' => $nom,
          ':idasso' => $idasso,
          ':couleur' =>$couleur,
          ':email' =>$email,
          ':photo' =>$photo
        ));

        header ('location: comptes.php');
    }

    ?>
    <div id="hauteur">
      <form action="ajoutasso.php" method="POST">
        <div id="formulaire">
          <h1>Ajouter asso</h1>
          <label>nomasso</label>
          <input type="text" name="nom" id="champs" required autofocus />
          <label>id-asso</label>
          <input type="number" name="idasso" id="champs"  min = "-1" max = "50"/>
          <label>couleur</label>
          <input type="text" name="couleur" id="champs" />
          <label>email</label>
          <input type="email" name="email" id="champs" />
          <label>photo</label>
          <input type="text" name="photo" id="champs" />
          <input type="submit" id="inscrire" value="Ajouter">
        </div> 
       </form> 
    </div>

  </body>
</html>