<?php
  session_start();
  require_once __DIR__ . '/../db_config.php';
  // connecting to db
  
  $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USER, DB_PASSWORD) or die(mysql_error());
  
  if (isset($_POST['nom']) && isset($_POST['mdp'])) 
  {

    $reponse = $db->exec("SELECT * FROM nomasso"); 
    
    
    
    if($donnees = $reponse->fetch()){
    
        $_SESSION['nom'] = $donnees["nom"];
        $_SESSION['id'] = $donnees["2"];
     
    }
    $reponse->closeCursor();
  }
  
  header('Location: index.php');
