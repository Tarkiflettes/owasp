<!DOCTYPE html>
<html>
  <body>
  <?php
  session_start();
  require_once __DIR__ . '/../newdb_config.php';
  // connecting to db
  $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USER, DB_PASSWORD) or die(mysql_error());
  
  if (isset($_POST['nom']) && isset($_POST['mdp'])) 
  {
    
    $pass = htmlspecialchars($_POST['mdp']);
    $nom = htmlspecialchars($_POST['nom']);

    $reponse = $db->query("SELECT * FROM compte");

    while ($donnees = $reponse->fetch()) // On boucle pour afficher toutes les données et on met toutes données dans un tableau
    {
      if($donnees["nom"] == $nom)
      {
        $mdp = sha1($pass.$donnees["salage"]);
        if($donnees["mdp"] == $mdp)
        {
          $idasso = $donnees["2"];
          $nom = $donnees["nom"];
              
          $_SESSION['nom'] = $nom;
          $_SESSION['id'] = $idasso;
        }
      }
    }
    $reponse->closeCursor();
    header('Location: index.php');
  }
  else
    header('Location: index.php');
  ?>

  </body>
</html>

