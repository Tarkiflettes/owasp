<?php
<<<<<<< HEAD
  session_start();
  require_once __DIR__ . '/../db_config.php';
  // connecting to db
  
  $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USER, DB_PASSWORD) or die(mysql_error());
  
  echo 'plop';die;
  if (isset($_POST['nom']) && isset($_POST['mdp'])) 
  {
      

    
      
      $reponse = $db->exec("SELECT * FROM compte WHERE nom = $_POST['nom'] && mdp = $_POST['mdp']"); 
    
    
=======

session_start();
require_once __DIR__ . '/../db_config.php';
// connecting to db


if (isset($_POST['nom']) && isset($_POST['mdp'])) {
    $reponse = $db->query("SELECT * FROM compte WHERE nom ='" . $_POST['nom'] . "' AND mdp ='" . $_POST['mdp'] . "'");

    $donnees = $reponse->fetch();
>>>>>>> f8190e33b8dbfa0bee5b116ed5b36655ef8a5b95
    
    $_SESSION['nom'] = $donnees["nom"];
    $_SESSION['id'] = $donnees["2"];
    
    if(!empty($donnees)){
        header('Location: accueil.php');
        exit;
    }
<<<<<<< HEAD
    $reponse->closeCursor();
  }
  
  //header('Location: index.php');
=======
}

header('Location: index.php');
>>>>>>> f8190e33b8dbfa0bee5b116ed5b36655ef8a5b95
