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
                <li class = "active"> <a href="membres.php">membres</a> </li>
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
           ?>
          <div class="body-center"><b>Description:</b><br/>
              Cette page contient une faille d injection SQL dans une URL.<br>
            Vous pouvez ajouter '?membreId=3' après l'URL<br/>
            pour exploiter la faille, bous pouvez ajouter '?membreId=3 UNION SELECT nom, mdp FROM compte' après l'URL<br/><br/>
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
