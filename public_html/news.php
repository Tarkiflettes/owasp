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
                <li class = "active"> <a href="news.php">news</a> </li>
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

              echo "<form class='navbar-form navbar-right inline-form' action='rofil.php' method='POST'>";
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
          
          //news
        if(isset($_POST['nom']) AND !empty($_POST['nom']) && isset($_POST['desc']) AND !empty($_POST['desc']))
        {
          $nom = $_POST['nom'];
          $desc = $_POST['desc'];
          $asso = $_POST['asso'];
          
          $req = $db->prepare("INSERT INTO products (name, description, asso) VALUES (:nom, :desc, :asso)");

            $success = $req->execute(array(
                ':nom' => $nom,
                ':desc' => $desc,
                ':asso' => $asso
            ));
        }
        
          $news = $db->query("SELECT * FROM products ORDER BY products.id DESC");
        ?>
<div class="body-center"><b>Description:</b><br/>
            Cette page contient une faille XSS.
            Vous pouvez ajouter une news <br/>
            avec la faille suivante : <script>alert(Oh tiens, une faille xss);</script>
            <br/>
            Une fenêtre d'alerte s'affiche alors sur la page<br/><br/><br/>
            
            
      
        <table border="2" cellpadding="1" cellspacing="1" style="width:100%; text-align:center ">
        <tr>
            <td>titre</br></td>
            <td>description</br></td>
            <td>date</br></td>
        </tr>
        <tbody>
        <?php
        $i = 0;
        while ($donnees = $news->fetch()) // On boucle pour afficher toutes les données et on met toutes données dans un tableau
        {
          ?>
          <tr>
          <td> <?php echo $donnees[1]?></br></td>
          <td> <?php echo $donnees[2]?></br></td>
          <td> <?php echo $donnees[3]?></br></td>
          </tr>
          <?php
        }
        ?></table><?php
      $news->closeCursor();   
      $asso = $db->query("SELECT * FROM nomasso");
      ?>
            <div id="hauteur">
            <form action="news.php" method="POST" enctype="multipart/form-data">
              <div id="formulaire">
                <h1>Ajouter news</h1>
                <label>nom</label>
                <input type="text" name="nom" id="champs"  required autofocus />
                <label>contenu</label>
                <td colspan="2"><textarea name="desc" cols="50" rows="2" id ="champs1"></textarea></td>
                
                <input type="submit" id="inscrire1" value="AJOUTER"/>
              </div> 
             </form> 
          </div>
      
          <?php
          
      }
      else
    header('Location: index.php');
?>

  <body/>   
</html>
