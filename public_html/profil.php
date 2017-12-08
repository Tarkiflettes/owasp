<?php
    session_start();
    require_once __DIR__ . '/../newdb_config.php';
  // connecting to db
  $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USER, DB_PASSWORD) or die(mysql_error());
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>profil</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <head/>
  <body>

<?php
if (!isset($_SESSION['id'])){
    header('Location: index.php');
}
  ?>
    

    <div class="jumboton">
      <div class="container">
        <h1><a href="index.php">Administration asso</a></h1>
      </div>
    </div>

   <?php include("menu.php"); ?>

    <?php
    if(isset($_POST['nomasso']) && !empty($_POST['nomasso']) && isset($_POST['email']) && !empty($_POST['email']))
    {
      $nom = htmlspecialchars($_POST['nomasso']);
      $email = htmlspecialchars($_POST['email']);
      $description = htmlspecialchars(($_POST['description']));
      $facebook = htmlspecialchars($_POST['facebook']);
      $snapchat = htmlspecialchars($_POST['snapchat']);
      $twitter = htmlspecialchars($_POST['twitter']);
      $instagram = htmlspecialchars($_POST['instagram']);
      $youtube = htmlspecialchars($_POST['youtube']);
      $telephone = htmlspecialchars($_POST['telephone']);
      
      $req = $db->prepare("UPDATE nomasso SET nomasso = :nom, email  =:email, description = :description, facebook = :facebook, snapchat = :snapchat, twitter = :twitter, instagram = :instagram, youtube = :youtube, telephone = :telephone WHERE idasso = :id");
          $success = $req->execute(array(
            ':nom' => $nom,
            ':email' => $email,
            ':description' => $description,
            ':id' => $_SESSION['id'],
            ':facebook' => $facebook,
            ':snapchat' => $snapchat,
            ':twitter' => $twitter,
            ':instagram' => $instagram,
            ':youtube' => $youtube,
            ':telephone' =>$telephone
          ));

      if(!empty($_POST['motdepasse']) && !empty($_POST['newmotdepasse']) && !empty($_POST['newmotdepasse2']))
        {
          $reponse = $db->query("SELECT * FROM compte WHERE idasso='".$_SESSION['id']."'"); // Requête SQL
          $donnee = $reponse->fetch();
          $salt = $donnee['salage'];

          $mdp1 = htmlspecialchars($_POST['motdepasse']);
          $mdp2 = htmlspecialchars($_POST['newmotdepasse']);
          $mdp3 = htmlspecialchars($_POST['newmotdepasse2']);

          $mdp = sha1($mdp1.$salt);
          $newmdp = sha1($mdp2.$salt);
          $newmdp2 = sha1($mdp3.$salt);

          if($donnee['mdp'] == $mdp && $newmdp == $newmdp2)
          {
              $req = $db->prepare("UPDATE compte SET mdp = :mdp WHERE idasso = :id");
              $success = $req->execute(array(
                ':mdp' => $newmdp,
                ':id' => $_SESSION['id']
          ));
          }
        }
      }

    //ajout image asso
      if(isset($_POST['assophoto']) AND !empty($_POST['assophoto'])) 
        {

          $fichier = basename($_FILES['avatar']['name']);
          $dossier =  $_SERVER['DOCUMENT_ROOT'].'asso/';
          $taille_maxi = 500000;
          $taille = filesize($_FILES['avatar']['tmp_name']);
          $extensions = array('.png','.PNG', '.jpg', '.jpeg');
          $extension = strrchr($_FILES['avatar']['name'], '.');
          $id = $_SESSION['id'];

          //Début des vérifications de sécurité...
          if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
          {
               $erreur = 'Vous devez uploader un fichier de type png, jpg, jpeg uniquement';
          }
          if($taille>$taille_maxi)
          {
               $erreur = 'Le fichier est trop gros';
          }
          if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
          {
               //On formate le nom du fichier ici...
               $fichier = strtr($fichier, 
                    'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                    'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
               $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
               if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
               {
                  echo 'Upload effectué avec succès !';

                  $req = $db->prepare("UPDATE nomasso SET photo = :image WHERE idasso = :id");

                  $success = $req->execute(array(
                      ':image' => $fichier,
                      ':id' => $id
                  ));


               }
               else //Sinon (la fonction renvoie FALSE).
               {
                    echo 'Echec de l\'upload !';
               }
          }
          else
          {
               echo $erreur;
          }
      }

    $req = $db->prepare("SELECT * FROM nomasso WHERE idasso = :id");

    $req->execute(array(
      ':id' => $_SESSION['id']
    ));
    $donnees = $req->fetch();

    if(isset($_POST['id']) AND !empty($_POST['id']))
    {
      $id = htmlspecialchars($_POST['id']);

      if($id == -1)
        {
          ?>
          <div id="hauteur">
            <form action="profil.php" method="POST" enctype="multipart/form-data">
              <div id="formulaire">
                <h1>modifier image groupe asso</h1>
                <input type="hidden" name="assophoto" value="plop" id="champs" />
                <label>
                  <div id="rouge"> !!! attention l'image doit faire 600px par 300px pour les membres!!!</div>
                </label>
                <input type="file" name="avatar">
                <input type="submit" id="inscrire1" value="AJOUTER"/>
              </div> 
            </form>
          </div>
        <?php
      }
    }
    else{
    ?>

    <div id= "formulaire">
      <img src="asso/<?php echo $donnees["photo"]?>" alt="Smiley face" height="200" width="400">
      <form action="profil.php" method="POST">
          <input type="hidden" name="id" value="-1" id="champs" />
          <input type="submit" id="inscrire1" value="Modifier image groupe asso"/>
      </form>
    </div>

    <div id="formulaire">
      <form action="profil.php" method="POST">
        <h1>Modification du nom de l'asso</h1>
        <label>Nom</label>
        <input type="text" name="nomasso" value="<?php echo $donnees['nomasso'] ?>" id="champs" />
        <label>Contact</label>
        <input type="text" name="email" value="<?php echo $donnees['email'] ?>" id="champs" />
        <label>Description Asso</label>
        <input type="text" name="description" value="<?php echo $donnees['description'] ?>" id="champs" />
        <label>id page facebook</label></br>
        <?php
          echo "pour trouver l'id d'une page facebook, il faut être admin de la page et aller dans 'a propos' puis l'id est tout en bas";
        ?>
        <input type="number" name="facebook" value="<?php echo $donnees['facebook'] ?>" id="champs" />
        <label>snapchat</label>
        <input type="text" name="snapchat" value="<?php echo $donnees['snapchat'] ?>" id="champs" />
        <label>twitter</label>
        <input type="text" name="twitter" value="<?php echo $donnees['twitter'] ?>" id="champs" />
        <label>instagram</label>
        <input type="text" name="instagram" value="<?php echo $donnees['instagram'] ?>" id="champs" />
        <label>youtube</label>
        <input type="text" name="youtube" value="<?php echo $donnees['youtube'] ?>" id="champs" />
        <label>telephone</label>
        <input type="text" name="telephone" value="<?php echo $donnees['telephone'] ?>" id="champs" />
        <h1>Modification de mot de passe</h1>
        <label>Ancien mot de passe</label>
        <input type="password" name="motdepasse" placeholder='********' value="" id="champs" />
        <label>Nouveau mot de passe</label>
        <input type="password" name="newmotdepasse" placeholder='********' value="" id="champs" />
        <label>Confirmer nouveau mot de passe</label>
        <input type="password" name="newmotdepasse2" placeholder='********' value="" id="champs" />

        <input type="submit" id="inscrire" value="MODIFIER">
      </form>
    </div> 
    <?php
    }
    ?>
    
  <body/>   
</html>