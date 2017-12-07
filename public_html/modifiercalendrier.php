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
              <li class="active"> <a href="index.php">Accueil</a> </li>
              <li> <a href="news.php">news</a> </li>
              <li> <a href="calendrier.php">calendrier</a> </li>
              <li> <a href="membres.php">membres</a> </li>
              <li> <a href="partenariats.php">partenariats</a> </li>


              <?php
               if (isset($_SESSION['id']))
              {              
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

        if(isset($_POST['nom']) AND !empty($_POST['nom']) && isset($_POST['contenu']) AND !empty($_POST['contenu']) && isset($_POST['jour']) AND !empty($_POST['jour']) && isset($_POST['date']) AND !empty($_POST['date']) && isset($_POST['jourfin']) AND !empty($_POST['jourfin']) && isset($_POST['numerofin']) AND !empty($_POST['numerofin']) && isset($_POST['moisfin']) AND !empty($_POST['moisfin']) && isset($_POST['heurefin']) AND !empty($_POST['heurefin']) && isset($_POST['lieu']) AND !empty($_POST['lieu'])) {

          $nom = htmlspecialchars($_POST['nom']);
          $contenu = htmlspecialchars($_POST['contenu']);
          $jour = htmlspecialchars($_POST['jour']);
          $date = htmlspecialchars($_POST['date']);
          $jourfin = htmlspecialchars($_POST['jourfin']);
          $numerofin = htmlspecialchars($_POST['numerofin']);
          $moisfin = htmlspecialchars($_POST['moisfin']);
          $heurefin = htmlspecialchars($_POST['heurefin']);
          $lieu = htmlspecialchars($_POST['lieu']);
          $id = htmlspecialchars($_POST['id']);

          if($_SESSION['id'] == -1)
          {
            $idasso = htmlspecialchars($_POST['idasso']);


            $req = $db->prepare("UPDATE calendrier SET name = :nom, description = :contenu,jour = :jour, datedebut = :datedebut, jourfin = :jourfin, numerofin = :numerofin, moisfin = :moisfin, heurefin = :heurefin, lieu = :lieu, asso = :asso WHERE id = :id");

            $success = $req->execute(array(
                ':nom' => $nom,
                ':contenu' => $contenu,
                ':jour' => $jour,
                ':datedebut' => $date,
                ':jourfin' => $jourfin,
                ':numerofin' => $numerofin,
                ':moisfin' => $moisfin,
                ':heurefin' => $heurefin,
                ':lieu' => $lieu,
                ':id' => $id,
                ':asso' => $idasso
            ));
          }
          else
          {
            $req = $db->prepare("UPDATE calendrier SET name = :nom, description = :contenu,jour = :jour, datedebut = :datedebut, jourfin = :jourfin, numerofin = :numerofin, moisfin = :moisfin, heurefin = :heurefin, lieu = :lieu WHERE id = :id");

            $success = $req->execute(array(
                ':nom' => $nom,
                ':contenu' => $contenu,
                ':jour' => $jour,
                ':datedebut' => $date,
                ':jourfin' => $jourfin,
                ':numerofin' => $numerofin,
                ':moisfin' => $moisfin,
                ':heurefin' => $heurefin,
                ':lieu' => $lieu,
                ':id' => $id
            ));
          }

          header ('location: calendrier.php');
        }
        else if(isset($_POST['idsuppr']) AND !empty($_POST['idsuppr']))
        {

          $id = htmlspecialchars($_POST['idsuppr']);

          $req = $db->prepare("DELETE FROM calendrier WHERE id = :id");

              $req->execute(array(
                ':id' => $id
              ));
              $News = $req->fetch();

          header ('location: calendrier.php');
        }
        else
        {


        $id = htmlspecialchars($_POST["id"]);


        $req = $db->prepare("SELECT * FROM calendrier WHERE id = :id ORDER BY id DESC");

              $req->execute(array(
                ':id' => $id
              ));
              $News = $req->fetch();
        ?>

        <div id="hauteur">
          <form action="modifiercalendrier.php" method="POST">
            <div id="formulaire">
              <h1>modifier</h1>
              <label>titre</label>
              <input type="text" name="nom" id="champs" value="<?php echo $News['1'];?>" required autofocus />
              <label>description</label>
              <td colspan="2"><textarea name="contenu" cols="50" rows="5" id ="champs1"> <?php echo $News['2'];?> </textarea></td>
              <label>Jour</label>
                  <select name="jour" id="champ">
                    <option selected="selected" value="<?php echo $News['4'];?>"><?php echo $News['4'];?></option>
                    <option value="Lundi">Lundi</option>
                    <option value="Mardi">Mardi</option>
                    <option value="Mercredi">Mercredi</option>
                    <option value="Jeudi">Jeudi</option>
                    <option value="Vendredi">Vendredi</option>
                    <option value="Samedi">Samedi</option>
                    <option value="Dimanche">Dimanche</option> 
                  </select></br>
              <label>date</label>
              <input type="datetime" name="date" value="<?php echo $News['5'];?>" id="champs" />

              <label>Jour fin</label>
                  <select name="jourfin" id="champ">
                    <option selected="selected" value="<?php echo $News['6'];?>"><?php echo $News['6'];?></option>
                    <option value="Lundi">Lundi</option>
                    <option value="Mardi">Mardi</option>
                    <option value="Mercredi">Mercredi</option>
                    <option value="Jeudi">Jeudi</option>
                    <option value="Vendredi">Vendredi</option>
                    <option value="Samedi">Samedi</option>
                    <option value="Dimanche">Dimanche</option> 
                  </select></br>

              <label>Numéro fin</label>
                  <select name="numerofin" id="champ">
                    <option selected="selected" value="<?php echo $News['7'];?>"><?php echo $News['7'];?></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option> 
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                  </select></br>

              <label>Mois fin</label>
                  <select name="moisfin" id="champ">
                    <option selected="selected" value="<?php echo $News['8'];?>"><?php echo $News['8'];?></option>
                    <option value="Janvier">Janvier</option>
                    <option value="Février">Février</option>
                    <option value="Mars">Mars</option>
                    <option value="Avril">Avril</option>
                    <option value="Mai">Mai</option>
                    <option value="Juin">Juin</option>
                    <option value="Juillet">Juillet</option> 
                    <option value="Aout">Aout</option> 
                    <option value="Septembre">Septembre</option> 
                    <option value="Octobre">Octobre</option> 
                    <option value="Novembre">Novembre</option> 
                    <option value="Décembre">Décembre</option> 
                  </select></br>
              <label>heure fin</label>
              <input type="time" name="heurefin" value="<?php echo $News['9'];?>" id="champs" />
              <label>Lieu</label>
              <input type="text" name="lieu" value="<?php echo $News['10'];?>" id="champs" />
              <?php
                if($_SESSION['id'] == -1)
                {
                ?>

                <label>idasso</label>
                <input type="number" name="idasso" value="<?php echo $News['11'];?>" id="champs" />

                <?php
                }
                ?>

              <input type="hidden" name="id" value="<?php echo $News['0'];?>" id="champs" />

              <input type="submit" id="inscrire1" value="MODIFIER"/>
           </form>

           <form action="modifiercalendrier.php" method="POST">

              <input type="hidden" name="idsuppr" value="<?php echo $News['0'];?>" id="champs" />

              <input type="submit" id="inscrire1" value="SUPPRIMER"/>
            </div>
           </form> 
        </div>
        <?php
        }
      }
      else
    header('Location: index.php');
?>
  <body/>   
</html>
