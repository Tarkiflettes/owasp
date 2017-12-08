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
          
          //news
        if(isset($_POST['nom']) AND !empty($_POST['nom']) && isset($_POST['desc']) AND !empty($_POST['desc']))
        {
          $nom = $_POST['nom'];
          $desc = $_POST['desc'];
          
          $req = $db->prepare("INSERT INTO products (name, description) VALUES (:nom, :desc)");

            $success = $req->execute(array(
                ':nom' => $nom,
                ':desc' => $desc
            ));
        }
        
          $news = $db->query("SELECT * FROM products ORDER BY products.id DESC");
        ?>
<div class="body-center"><b>Description:</b><br/>
            Cette page contient une faille XSS.
            Vous pouvez ajouter une news avec la faille suivante dans le texte : <font color="red">&lt;script&gt;alert('Oh tiens, une faille xss');&lt;/script&gt;</font>
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
      ?>
            <div id="hauteur">
            <form action="news.php" method="POST" enctype="multipart/form-data">
              <div id="formulaire">
                <h1>Ajouter news</h1>
                <label>nom</label>
                <input type="text" name="nom" id="champs"/>
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
