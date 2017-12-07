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

        if(isset($_POST['nom']) AND !empty($_POST['nom']) && isset($_POST['couleur']) AND !empty($_POST['couleur']) && isset($_POST['contact']) AND !empty($_POST['contact']) && isset($_POST['image']) AND !empty($_POST['image'])) {

          $nom = htmlspecialchars($_POST['nom']);
          $idasso = htmlspecialchars($_POST['idasso']);
          $couleur = htmlspecialchars($_POST['couleur']);
          $contact = htmlspecialchars($_POST['contact']);
          $image = htmlspecialchars($_POST['image']);
          $id = htmlspecialchars($_POST['idmodifasso']);
          $facebook = htmlspecialchars($_POST['facebook']);
          $snapchat = htmlspecialchars($_POST['snapchat']);
          $twitter = htmlspecialchars($_POST['twitter']);
          $instagram = htmlspecialchars($_POST['instagram']);
          $youtube = htmlspecialchars($_POST['youtube']);
          $telephone = htmlspecialchars($_POST['telephone']);
          $descasso = htmlspecialchars($_POST['descasso']);

      
          $req = $db->prepare("UPDATE nomasso SET nomasso = :nom, idasso = :idasso, couleur
          = :couleur, email = :contact, photo = :image, facebook = :facebook, snapchat = :snapchat, twitter = :twitter, instagram = :instagram, youtube = :youtube, telephone = :telephone, descasso = :descasso WHERE Id = :id");

          $success = $req->execute(array(
              ':nom' => $nom,
              ':idasso' => $idasso,
              ':couleur' => $couleur,
              ':contact' => $contact,
              ':image' => $image,
              ':id' => $id,
              ':facebook' => $facebook,
              ':snapchat' => $snapchat,
              ':twitter' => $twitter,
              ':instagram' => $instagram,
              ':youtube' => $youtube,
              ':telephone' => $telephone,
              ':descasso' => $descasso
          ));

          header ('location: comptes.php');
        }
        else
        {


        $id = htmlspecialchars($_POST["idmodifasso"]);

      $req = $db->prepare("SELECT * FROM nomasso WHERE Id = :id");

              $req->execute(array(
                ':id' => $id
            ));
              $News = $req->fetch();

        ?>

        <div id="hauteur">
          <form action="modifiercomptes.php" method="POST">
            <div id="formulaire">
              <h1>modifier</h1>
              <label>Id asso</label>
              <input type="number" name="idasso" id="champs" value="<?php echo $News['idasso'];?>" required autofocus />
              <label>Nom compte</label>
              <input type="text" name="nom" id="champs" value="<?php echo $News['nomasso'];?>" />
              <label>couleur</label>
              <input type="text" name="couleur" value="<?php echo $News['couleur'];?>" id="champs" />
              <label>Contact</label>
              <input type="email" name="contact" value="<?php echo $News['email'];?>" id="champs" />
              <label>Description Asso</label>
              <input type="text" name="descasso" value="<?php echo $News['descasso'];?>" id="champs" />
              <label>Image</label>
              <input type="text" name="image" value="<?php echo $News['photo'];?>" id="champs" />
              <label>facebook</label>
              <input type="text" name="facebook" value="<?php echo $News['facebook'] ?>" id="champs" />
              <label>snapchat</label>
              <input type="text" name="snapchat" value="<?php echo $News['snapchat'] ?>" id="champs" />
              <label>twitter</label>
              <input type="text" name="twitter" value="<?php echo $News['twitter'] ?>" id="champs" />
              <label>instagram</label>
              <input type="text" name="instagram" value="<?php echo $News['instagram'] ?>" id="champs" />
              <label>youtube</label>
              <input type="text" name="youtube" value="<?php echo $News['youtube'] ?>" id="champs" />
              <label>telephone</label>
              <input type="text" name="telephone" value="<?php echo $News['telephone'] ?>" id="champs" />
        
              <input type="hidden" name="idmodifasso" value="<?php echo $News['0'];?>" id="champs" />

              <input type="submit" id="inscrire1" value="MODIFIER"/>
              </div>
           </form> 

        </div>
        <?php
        }
      }
      else
    header('Location: comptes.php');
?>
  <body/>   
</html>