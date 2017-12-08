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
  require_once __DIR__ . '/../db_config.php';

  ?>
  
    <div class="jumboton">
      <div class="container">
        <h1><a href="index.php">Administration asso</a></h1>
      </div>
    </div>

    <?php include('menu.php'); ?>

    <form action="api/getcalendrier.php" method="post">
        <input type="submit" id="envoyer" name="utiliser l'api" value="utiliser l'api">
    <form>
  <body/>   
</html>
