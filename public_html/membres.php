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
  require_once __DIR__ . '/../db_config.php';
  ?>
    <div class="jumboton">
      <div class="container">
        <h1><a href="index.php">Administration asso</a></h1>
      </div>
    </div>

   <?php include('menu.php'); 

      if (isset($_SESSION['id']))
      {
           ?>
          <div class="body-center"><b>Description:</b><br/>
              Cette page contient une faille d injection SQL dans une URL.<br>
            
            pour exploiter la faille, utilisez cete faille : <font color="red"><?= $urlsite;?>/owasp/public_html/membres.php?membreId=3 UNION SELECT nom, mdp FROM compte</font>  après l'URL<br/><br/>
            toutes les données des comptes s'affichent<br/><br/><br/>
            
                <?php
            
          $news = $db->query("SELECT nom, poste FROM membresasso WHERE id = ".$_GET["membreId"]);
        ?>

        <table border="2" cellpadding="1" cellspacing="1" style="width:100%; text-align:center ">
        <tr>
            <td>Nom</br></td>
            <td>Poste</br></td>
            
        </tr>
        <tbody>
        <?php
        $i = 0;
        while ($donnees = $news->fetch()) // On boucle pour afficher toutes les données et on met toutes données dans un tableau
        {
          ?>
          <tr>
          <td> <?php echo $donnees[0]?></br></td>
          <td> <?php echo $donnees[1]?></br></td>
          <?php
        }
      $news->closeCursor(); 
      ?>
        </table>
        <?php
      }
      else
    header('Location: index.php');
?>

  <body/>   
</html>
