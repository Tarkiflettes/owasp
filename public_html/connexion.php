<?php
session_start();
require_once __DIR__ . '/../db_config.php';
// connecting to db


if (isset($_POST['nom']) && isset($_POST['mdp'])) {
    $reponse = $db->query("SELECT * FROM compte WHERE nom ='" . $_POST['nom'] . "' AND mdp ='" . $_POST['mdp'] . "'");

    $donnees = $reponse->fetch();
    
    $_SESSION['nom'] = $donnees["nom"];
    $_SESSION['id'] = $donnees["2"];
    
    if(!empty($donnees)){
        header('Location: accueil.php');
        exit;
    }
    $reponse->closeCursor();
  }
  
  header('Location: index.php');
