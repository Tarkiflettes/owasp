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

        if(isset($_POST['nom']) AND !empty($_POST['nom']) && isset($_POST['contenu']) AND !empty($_POST['contenu'])) {

          $nom = htmlspecialchars($_POST['nom']);
          $contenu = htmlspecialchars($_POST['contenu']);
          $image = htmlspecialchars($_POST['image1']);
          $id = htmlspecialchars($_POST['id']);

                if($_SESSION['id'] == -1)
                {
                  $idasso = htmlspecialchars($_POST['idasso']);

                  $req = $db->prepare("UPDATE products SET name = :nom, description = :contenu, image
          = :image, asso = :asso WHERE id = :id");

                  $success = $req->execute(array(
                      ':nom' => $nom,
                      ':contenu' => $contenu,
                      ':image' => $image,
                      ':id' => $id,
                      ':asso' => $idasso
                  ));
                }
                else
                {
                  $req = $db->prepare("UPDATE products SET name = :nom, description = :contenu, image
          = :image WHERE id = :id");

          $success = $req->execute(array(
              ':nom' => $nom,
              ':contenu' => $contenu,
              ':image' => $image,
              ':id' => $id
          ));
                }

          header ('location: news.php');
        }
        if(isset($_POST['idsuppr']) AND !empty($_POST['idsuppr']))
        {

          $id = htmlspecialchars($_POST['idsuppr']);


          $req = $db->prepare("DELETE FROM products WHERE id = :id");

              $req->execute(array(
                ':id' => $id
            ));
              $donnees = $req->fetch();

          $fichier = htmlspecialchars($_POST['image']);

          $dossier_traite = '/var/www/appliandroid/public_html/images_de_l\'application'; 
           
          $repertoire = opendir($dossier_traite); // On définit le répertoire dans lequel on souhaite travailler.
           
          $chemin = $dossier_traite."/".$fichier; // On définit le chemin du fichier à effacer.
           
          // Si le fichier n'est pas un répertoire…
          if ($fichier != ".." AND $fichier != "." AND !is_dir($fichier))
          {
            unlink($chemin); // On efface.
          }
      closedir($repertoire); // Ne pas oublier de fermer le dossier ***EN DEHORS de la boucle*** ! Ce qui évitera à PHP beaucoup de calculs et des problèmes liés à l'ouverture du dossier.
          header ('location: news.php');
        }
        else
        {
        $id = htmlspecialchars($_POST["id"]);


        $req = $db->prepare("SELECT * FROM products WHERE id = :id ORDER BY id DESC");

              $req->execute(array(
                ':id' => $id
            ));
              $News = $req->fetch();

        ?>

        <div id="hauteur">
          <form action="modifiernews.php" method="POST">
            <div id="formulaire">
              <h1>modifier</h1>
              <label>nom</label>
              <input type="text" name="nom" id="champs" value="<?php echo $News['1'];?>" required autofocus />
              <label>contenu</label>
              <td colspan="2"><textarea name="contenu" cols="50" rows="2" id ="champs1"> <?php echo $News['2'];?> </textarea></td>
              <label>image</label>
                  <select name="image1" id="champ">
                    <option value="<?php echo $News['4'];?>"><?php echo $News['4'];?></option> 
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
              <?php
                if($_SESSION['id'] == -1)
                {
                ?>

                <label>idasso</label>
                <input type="number" name="idasso" value="<?php echo $News['5'];?>" id="champs" />

                <?php
                }
                ?>

              <input type="hidden" name="id" value="<?php echo $News['0'];?>" id="champs" />

              <input type="submit" id="inscrire1" value="MODIFIER"/>
           </form> 

           <form action="modifiernews.php" method="POST">

              <input type="hidden" name="idsuppr" value="<?php echo $News['0'];?>" id="champs" />
              <input type="hidden" name="image" value="<?php echo $News['4'];?>" id="champs" />

              <input type="submit" id="inscrire1" value="SUPPRIMER"/>
            </div>
           </form> 
        </div>
        <?php
        }
      }
      else
    header('Location: index.php');
?>
  <body/>   
</html>