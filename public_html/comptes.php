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
              <li> <a href="index.php">Accueil</a> </li>


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
                  echo "<li class='active'> <a href='comptes.php'>comptes</a> </li>";
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
      if (isset($_SESSION['id']))
      {
        if($_SESSION['id'] != -1)
        {
          header ('location: index.php'); 
        }

        if(isset($_POST['idsuppr']) && !empty($_POST['idsuppr']))
        {
          $idsuppr = htmlspecialchars($_POST['idsuppr']);

          $supp = $db->prepare("DELETE FROM compte WHERE id = :id");

              $supp->execute(array(
                ':id' => $idsuppr
            ));


        }


        if(isset($_POST['photosuppr']) && !empty($_POST['photosuppr']))
        {
          $fichier = htmlspecialchars($_POST['photosuppr']);

          $dossier_traite = '/var/www/appliandroid/public_html/images_des_membres'; 
           
          $repertoire = opendir($dossier_traite); // On définit le répertoire dans lequel on souhaite travailler.
           
          $chemin = $dossier_traite."/".$fichier; // On définit le chemin du fichier à effacer.
           
          // Si le fichier n'est pas un répertoire…
          if ($fichier != ".." AND $fichier != "." AND !is_dir($fichier))
          {
            unlink($chemin); // On efface.
          }
      closedir($repertoire); // Ne pas oublier de fermer le dossier ***EN DEHORS de la boucle*** ! Ce qui évitera à PHP beaucoup de calculs et des problèmes liés à l'ouverture du dossier.

        }


        if(isset($_POST['photosupprnews']) && !empty($_POST['photosupprnews']))
        {
          $fichier = htmlspecialchars($_POST['photosupprnews']);

          $dossier_traite = '/var/www/appliandroid/public_html/images_de_l\'application'; 
           
          $repertoire = opendir($dossier_traite); // On définit le répertoire dans lequel on souhaite travailler.
           
          $chemin = $dossier_traite."/".$fichier; // On définit le chemin du fichier à effacer.
           
          // Si le fichier n'est pas un répertoire…
          if ($fichier != ".." AND $fichier != "." AND !is_dir($fichier))
          {
            unlink($chemin); // On efface.
          }
          closedir($repertoire); // Ne pas oublier de fermer le dossier ***EN DEHORS de la boucle*** ! Ce qui évitera à PHP beaucoup de calculs et des problèmes liés à l'ouverture du dossier.

        }

        if(isset($_POST['photosupprpartenariats']) && !empty($_POST['photosupprpartenariats']))
        {
          $fichier = htmlspecialchars($_POST['photosupprpartenariats']);

          $dossier_traite = '/var/www/appliandroid/public_html/images_partenariats'; 
           
          $repertoire = opendir($dossier_traite); // On définit le répertoire dans lequel on souhaite travailler.
           
          $chemin = $dossier_traite."/".$fichier; // On définit le chemin du fichier à effacer.
           
          // Si le fichier n'est pas un répertoire…
          if ($fichier != ".." AND $fichier != "." AND !is_dir($fichier))
          {
            unlink($chemin); // On efface.
          }
          closedir($repertoire); // Ne pas oublier de fermer le dossier ***EN DEHORS de la boucle*** ! Ce qui évitera à PHP beaucoup de calculs et des problèmes liés à l'ouverture du dossier.

        }


        if(isset($_POST['idsupprasso']) && !empty($_POST['idsupprasso']))
        {
          $idsupprasso = htmlspecialchars($_POST['idsupprasso']);

          $supp = $db->prepare("DELETE FROM nomasso WHERE id = :id");

              $supp->execute(array(
                ':id' => $idsuppr
            ));
        }

        $compte = $db->query("SELECT * FROM compte");
        ?>

        <table border="2" cellpadding="1" cellspacing="1" style="width:30%; text-align:center ">
        <tr>
          <td>liste comptes</td>
        </tr>
        <tr>
            <td>nom compte</br></td>
            <td>id asso</br></td>
            <td>supprimer compte</br></td>
        </tr>
        <tbody>
        <?php
        $i = 0;
        while ($donnees = $compte->fetch()) // On boucle pour afficher toutes les données et on met toutes données dans un tableau
        {
          ?>
          <tr>
          <td> <?php echo $donnees[1]?></br></td>
          <td> <?php echo $donnees[2]?></br></td>
          <td> 
            <form action="comptes.php" method="POST"> 
            <input type="hidden" name="idsuppr" value="<?php echo $donnees[0];?>" />
            <input type="submit" name="modifier" value="Supprimer"/> 
            </form></br></td>
          </tr>
          <?php
        }
        $compte->closeCursor();
        ?>
        <div id = formindex1>
          <form action="inscription.php" method="POST">
            <input type="submit" id="inscrire1" value="Ajout Compte"/>
          </form>
        </div>

        <div id = formindex1>
          <form action="ajoutasso.php" method="POST">
            <input type="hidden" name="id" value="-2" id="champs" />
            <input type="submit" id="inscrire1" value="Ajout asso"/>
          </form>
        </div>

        <?php
        $asso = $db->query("SELECT * FROM nomasso");
        ?>

        <table border="2" cellpadding="1" cellspacing="1" style="width:50%; text-align:center ">
        <tr>
          <td>liste des assos</td>
        </tr>
        <tr>
            <td>Id asso</br></td>
            <td>campus</br></td>
            <td>Nom compte</br></td>
            <td>Couleur</br></td>
            <td>Contact</br></td>
            <td>Image</br></td>
            <td>Facebook</br></td>
            <td>Snapchat</br></td>
            <td>Twitter</br></td>
            <td>Instagram</br></td>
            <td>Youtube</br></td>
            <td>Telephone</br></td>
            <td>Description</br></td>
            <td>Supprimer</br></td>
            <td>Modifier</br></td>
        </tr>
        <tbody>
        <?php
        while ($donnees = $asso->fetch()) // On boucle pour afficher toutes les données et on met toutes données dans un tableau
        {
          ?>
          <tr>
          <td> <?php echo $donnees[1]?></br></td>
          <td> <?php echo $donnees[2]?></br></td>
          <td> <?php echo $donnees[3]?></br></td>
          <td> <?php echo $donnees[4]?></br></td>
          <td> <?php echo $donnees[5]?></br></td>
          <td> <?php echo $donnees[6]?></br></td>
          <td> <?php echo $donnees[7]?></br></td>
          <td> <?php echo $donnees[8]?></br></td>
          <td> <?php echo $donnees[9]?></br></td>
          <td> <?php echo $donnees[10]?></br></td>
          <td> <?php echo $donnees[11]?></br></td>
          <td> <?php echo $donnees[12]?></br></td>
          <td> <?php echo $donnees[14]?></br></td>
          <td> 
            <form action="comptes.php" method="POST"> 
            <input type="hidden" name="idsupprasso" value="<?php echo $donnees[0];?>" />
            <input type="submit" name="supprimer" value="Supprimer"/> 
            </form></br></td>

          <td> 
            <form action="modifiercomptes.php" method="POST"> 
            <input type="hidden" name="idmodifasso" value="<?php echo $donnees[0];?>" />
            <input type="submit" name="modifier" value="Modifier"/> 
            </form></br></td>
          </tr>
          <?php
        }


        ?>
        <div id="formulaire">
          <form action="comptes.php" method="POST">
              <h1>supprimer image des membres</h1>
              <label>image de membres</label>
                  <select name="photosuppr" id="champ">
                    <?php 
                      $dirname = '/var/www/appliandroid/public_html/images_des_membres'; 
                      $dir = opendir($dirname); 

                      while($file = readdir($dir)) {
                        if($file != '.' && $file != '..' && !is_dir($dirname.$file)) 
                        {
                          ?>
                          <option value="<?php echo $file; ?>"><?php echo $file; ?></option> 
                          <?php
                        } 
                      }

                      closedir($dir);
                      ?> 
                  </select></br>

              <input type="submit" id="inscrire1" value="supprimer"/>
           </form>
           <form action="comptes.php" method="POST">
              <h1>supprimer image des news</h1>
              <label>image de news</label>
                  <select name="photosupprnews" id="champ">
                    <?php 
                      $dirname = '/var/www/appliandroid/public_html/images_de_l\'application'; 
                      $dir = opendir($dirname); 

                      while($file = readdir($dir)) {
                        if($file != '.' && $file != '..' && !is_dir($dirname.$file)) 
                        {
                          ?>
                          <option value="<?php echo $file; ?>"><?php echo $file; ?></option> 
                          <?php
                        } 
                      }

                      closedir($dir);
                      ?> 
                  </select></br>

              <input type="submit" id="inscrire1" value="supprimer"/>
           </form>
           <form action="comptes.php" method="POST">
              <h1>supprimer image des partenariats</h1>
              <label>image des partenariats</label>
                  <select name="photosupprpartenariats" id="champ">
                    <?php 
                      $dirname = '/var/www/appliandroid/public_html/images_partenariats'; 
                      $dir = opendir($dirname); 

                      while($file = readdir($dir)) {
                        if($file != '.' && $file != '..' && !is_dir($dirname.$file)) 
                        {
                          ?>
                          <option value="<?php echo $file; ?>"><?php echo $file; ?></option> 
                          <?php
                        } 
                      }

                      closedir($dir);
                      ?> 
                  </select></br>

              <input type="submit" id="inscrire1" value="supprimer"/>
           </form>
           </div>
           <?php
      }
      else
    header('Location: index.php');
?>

  <body/>
</html>
