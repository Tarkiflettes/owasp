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


              <?php
               if (isset($_SESSION['id']))
              {              
                ?>
                <li> <a href="news.php">news</a> </li>
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
        if($_SESSION['id'] != -1)
          header ('location: index.php');

        //news
        if(isset($_POST['nom']) AND !empty($_POST['nom']) && isset($_POST['desc']) AND !empty($_POST['desc']))
        {
          $nom = htmlspecialchars($_POST['nom']);
          $desc = htmlspecialchars($_POST['desc']);
          $asso = htmlspecialchars($_POST['asso']);


          $fichier = basename($_FILES['avatar']['name']);
          $dossier =  $_SERVER['DOCUMENT_ROOT'].'images_de_l\'application/';
          $taille_maxi = 500000;
          $taille = filesize($_FILES['avatar']['tmp_name']);
          $extensions = array('.png','.PNG', '.jpg', '.jpeg');
          $extension = strrchr($_FILES['avatar']['name'], '.'); 
          //Début des vérifications de sécurité...
          if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
          {
               $erreur = 'Vous devez uploader un fichier de type png, jpg, jpeg uniquement';
          }
          if($taille>$taille_maxi)
          {
               $erreur = 'Le fichier est trop gros';
          }
          if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
          {
               //On formate le nom du fichier ici...
               $fichier = strtr($fichier, 
                    'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                    'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
               $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
               if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
               {
                  echo 'Upload effectué avec succès !';

                  $req = $db->prepare("INSERT INTO products (name, description, image, asso) VALUES (:nom, :desc, :image, :asso)");

                  $success = $req->execute(array(
                    ':nom' => $nom,
                    ':desc' => $desc,
                    ':image' => $fichier,
                    ':asso' => $asso
                  ));
               }
               else //Sinon (la fonction renvoie FALSE).
               {
                    echo 'Echec de l\'upload !';
               }
          }
          else
          {
               echo $erreur;
          }
        }

        //partenariats
        if(isset($_POST['titre']) AND !empty($_POST['titre']) && isset($_POST['description']) AND !empty($_POST['description'])) 
        {
          $nom = htmlspecialchars($_POST['titre']);
          $desc = htmlspecialchars($_POST['description']);
          $campus = htmlspecialchars($_POST['campus']);


          $fichier = basename($_FILES['avatar']['name']);
          $dossier =  $_SERVER['DOCUMENT_ROOT'].'images_partenariats/';
          $taille_maxi = 500000;
          $taille = filesize($_FILES['avatar']['tmp_name']);
          $extensions = array('.png','.PNG', '.jpg', '.jpeg');
          $extension = strrchr($_FILES['avatar']['name'], '.');
          //Début des vérifications de sécurité...
          if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
          {
               $erreur = 'Vous devez uploader un fichier de type png, jpg, jpeg uniquement';
          }
          if($taille>$taille_maxi)
          {
               $erreur = 'Le fichier est trop gros';
          }
          if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
          {
               //On formate le nom du fichier ici...
               $fichier = strtr($fichier, 
                    'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                    'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
               $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
               if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
               {
                  echo 'Upload effectué avec succès !';

                  $req = $db->prepare("INSERT INTO partenariat (nom, description, photo, campus) VALUES (:nom, :description, :image, :asso)");

                  $success = $req->execute(array(
                    ':nom' => $nom,
                    ':description' => $desc,
                    ':image' => $fichier,
                    ':asso' => $campus
                  ));
               }
               else //Sinon (la fonction renvoie FALSE).
               {
                    echo 'Echec de l\'upload !';
               }
          }
          else
          {
               echo $erreur;
          }
        }

        //membres
          if(isset($_POST['nom']) AND !empty($_POST['nom']) && isset($_POST['poste']) AND !empty($_POST['poste']) && isset($_POST['rang']) AND !empty($_POST['rang']) && isset($_POST['asso']) AND !empty($_POST['asso'])) 
        {
          $nom = htmlspecialchars($_POST['nom']);
          $poste = htmlspecialchars($_POST['poste']);
          $rang = htmlspecialchars($_POST['rang']);
          $asso = htmlspecialchars($_POST['asso']);

          $fichier = basename($_FILES['avatar']['name']);
          $dossier =  $_SERVER['DOCUMENT_ROOT'].'images_des_membres/';
          $taille_maxi = 100000;
          $taille = filesize($_FILES['avatar']['tmp_name']);
          $extensions = array('.png','.PNG', '.jpg', '.jpeg');
          $extension = strrchr($_FILES['avatar']['name'], '.'); 
          //Début des vérifications de sécurité...
          if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
          {
               $erreur = 'Vous devez uploader un fichier de type png, jpg, jpeg uniquement';
          }
          if($taille>$taille_maxi)
          {
               $erreur = 'Le fichier est trop gros';
          }
          if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
          {
               //On formate le nom du fichier ici...
               $fichier = strtr($fichier, 
                    'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                    'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
               $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
               if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
               {
                  echo 'Upload effectué avec succès !';

                  $req = $db->prepare("INSERT INTO membresasso (nom, poste, photo, asso, rang) VALUES (:nom, :poste, :photo, :asso, :rang)");

                  $success = $req->execute(array(
                      ':nom' => $nom,
                      ':poste' => $poste,
                      ':photo' => $fichier,
                      ':asso' => $asso,
                      ':rang' => $rang
                  ));
               }
               else //Sinon (la fonction renvoie FALSE).
               {
                    echo 'Echec de l\'upload !';
               }
          }
          else
          {
               echo $erreur;
          }
        }

        //ajout image
          if(isset($_POST['dossier']) AND !empty($_POST['dossier'])) 
        {
          $dos = htmlspecialchars($_POST['dossier']);

          $fichier = basename($_FILES['avatar']['name']);
          $dossier1 =  $_SERVER['DOCUMENT_ROOT'].'images_des_membres/';
          $dossier2 =  $_SERVER['DOCUMENT_ROOT'].'images_de_l\'application/';
          $dossier3 =  $_SERVER['DOCUMENT_ROOT'].'images_partenariats/';
          $taille_maxi1 = 100000;
          $taille_maxi2 = 500000;
          $taille = filesize($_FILES['avatar']['tmp_name']);
          $extensions = array('.png','.PNG', '.jpg', '.jpeg');
          $extension = strrchr($_FILES['avatar']['name'], '.');

          if($dos == "membres")
          {
            $dossier = $dossier1;
            $taille_maxi = $taille_maxi1;
          }
          else if($dos == "news")
          {
            $dossier = $dossier2;
            $taille_maxi = $taille_maxi2;
          }
          else if($dos == "partenariat")
          {
            $dossier = $dossier3;
            $taille_maxi = $taille_maxi2;
          }
          //Début des vérifications de sécurité...
          if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
          {
               $erreur = 'Vous devez uploader un fichier de type png, jpg, jpeg uniquement';
          }
          if($taille>$taille_maxi)
          {
               $erreur = 'Le fichier est trop gros';
          }
          if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
          {
               //On formate le nom du fichier ici...
               $fichier = strtr($fichier, 
                    'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                    'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
               $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
               if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
               {
                  echo 'Upload effectué avec succès !';
               }
               else //Sinon (la fonction renvoie FALSE).
               {
                    echo 'Echec de l\'upload !';
               }
          }
          else
          {
               echo $erreur;
          }
        }

        //calendrier
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
          $asso = htmlspecialchars($_POST['asso']);

          $req = $db->prepare("INSERT INTO calendrier (name, description, jour, datedebut, jourfin, numerofin, moisfin, heurefin, lieu, asso) VALUES(:nom, :contenu, :jour, :datedebut, :jourfin, :numerofin, :moisfin, :heurefin, :lieu, :asso)");
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
              ':asso' => $asso
          ));

          header ('location: calendrier.php');
        }
       
        if(isset($_POST['id']) AND !empty($_POST['id']))
        {

          $id = htmlspecialchars($_POST["id"]);
          $asso = $db->query("SELECT * FROM nomasso");

          if($id == -1)
          {
            ?>
            <div id="hauteur">
            <form action="indexadmin.php" method="POST" enctype="multipart/form-data">
              <div id="formulaire">
                <h1>Ajouter news</h1>
                <label>nom</label>
                <input type="text" name="nom" id="champs"  required autofocus />
                <label>contenu</label>
                <td colspan="2"><textarea name="desc" cols="50" rows="2" id ="champs1"></textarea></td>

                <label>Asso</label>
                  <select name="asso" id="champ">
                    <option value="0"></option>
                  <?php
                  while ($donnees = $asso->fetch()) // On boucle pour afficher toutes les données et on met toutes données dans un tableau
                  {
                    ?>
                    <option value="<?php echo $donnees[1];?>"><?php echo $donnees[3];?></option>
                    <?php
                  }
                  ?>
                  </select></br>

                <label>
                  <div id="rouge"> !!! attention l'image doit faire 600px par 300px ou le même ratio!!! </div>
                </label>
                <input type="file" name="avatar">


                <input type="submit" id="inscrire1" value="AJOUTER"/>
              </div> 
             </form> 
          </div>
          <?php
          }
          else if($id == -2)
          {
            ?>
            <div id="hauteur">
              <form action="indexadmin.php" method="POST">
                <div id="formulaire">
                  <h1>Ajouter Calendrier</h1>
                  <label>titre</label>
                  <input type="text" name="nom" id="champs" required autofocus />
                  <label>description</label>
                  <td colspan="2"><textarea name="contenu" cols="50" rows="10" id ="champs1"></textarea></td>
                  <label>Jour</label>
                  <select name="jour" id="champ">
                    <option value="Lundi">Lundi</option>
                    <option value="Mardi">Mardi</option>
                    <option value="Mercredi">Mercredi</option>
                    <option value="Jeudi">Jeudi</option>
                    <option value="Vendredi">Vendredi</option>
                    <option value="Samedi">Samedi</option>
                    <option value="Dimanche">Dimanche</option> 
                  </select></br>

                  <label>date</label>
                  <input type="datetime-local" name="date" id="champs" />

                  <label>Jour fin</label>
                  <select name="jourfin" id="champ">
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
                  <input type="time" name="heurefin" id="champs" />
                  <label>Lieu</label>
                  <input type="text" name="lieu"  id="champs" />
                   <label>Asso</label>
                  <select name="asso" id="champ">
                    <option value="0"></option>
                  <?php
                  while ($donnees = $asso->fetch()) // On boucle pour afficher toutes les données et on met toutes données dans un tableau
                  {
                    ?>
                    <option value="<?php echo $donnees[1];?>"><?php echo $donnees[3];?></option>
                    <?php
                  }
                  ?>
                  </select></br>
                  <input type="submit" id="inscrire1" value="AJOUTER"/>
                </div> 
               </form>
            </div>
            <?php
          }
          else if($id == -3)
          {
            ?>
            <div id="hauteur">
              <form action="indexadmin.php" method="POST" enctype="multipart/form-data">
                <div id="formulaire">
                  <h1>Ajouter Membre</h1>
                  <label>nom</label>
                  <input type="text" name="nom" id="champs" required autofocus />
                  <label>poste</label>
                  <td colspan="2"><textarea name="poste" cols="50" rows="5" id ="champs"></textarea></td>
                  <label>rang</label>
                  <input type="number" name="rang" id="champs" />
                   <label>Asso</label>
                  <select name="asso" id="champ">
                    <option value="0"></option>
                  <?php
                  while ($donnees = $asso->fetch()) // On boucle pour afficher toutes les données et on met toutes données dans un tableau
                  {
                    ?>
                    <option value="<?php echo $donnees[1];?>"><?php echo $donnees[3];?></option>
                    <?php
                  }
                  ?>
                  </select></br>
                  <label>
                    <div id="rouge"> !!! attention l'image doit faire 150px par 150px !!!</div>
                  </label>
                <input type="file" name="avatar">

                  <input type="submit" id="inscrire1" value="AJOUTER"/>
                </div> 
               </form>
            </div>
            <?php
          }
          else if($id == -5)
          {
          ?>
          <div id="hauteur">
            <form action="indexadmin.php" method="POST" enctype="multipart/form-data">
              <div id="formulaire">
                <h1>Ajouter partenariat</h1>
                <label>titre</label>
                <input type="text" name="titre" id="champs"  required autofocus />
                <label>description</label>
                <td colspan="2"><textarea name="description" cols="50" rows="2" id ="champs1"></textarea></td>

                <label>
                  <div id="rouge"> !!! attention l'image doit faire 600px par 300px ou le même ratio !!! </div>
                </label>
                <input type="file" name="avatar">
               <label>Campus</label>
                  <select name="campus" id="champ">
                    <option value="0">Laval</option>
                    <option value="1">Paris</option>
                  </select></br>

                <input type="submit" id="inscrire1" value="AJOUTER"/>
              </div> 
            </form> 
          </div>
          <?php
          }
          else if($id == -4)
            {
              ?>
              <div id="hauteur">
                <form action="indexadmin.php" method="POST" enctype="multipart/form-data">
                  <div id="formulaire">
                    <h1>Ajouter image</h1>
                    <label>afectation image</label>
                    <select name="dossier" id="champ" required autofocus>
                      <option value="membres">membres</option>
                      <option value="news">news</option>
                      <option value="partenariat">partenariat</option>
                    </select></br>
                    <label>
                      <div id="rouge"> !!! attention l'image doit faire 150px par 150px pour les membres!!!</div>
                      <div id="rouge"> !!! attention l'image doit faire 600px par 300px ou le même ratio pour les news et les partenariats!!!</div>
                    </label>
                  <input type="file" name="avatar">

                    <input type="submit" id="inscrire1" value="AJOUTER"/>
                  </div> 
                 </form>
              </div>
              <?php
            }
          }
          else
          {
            ?>
            <div id = formulaire>
              <form action="indexadmin.php" method="POST">
                <input type="hidden" name="id" value="-1" id="champs" />
                <input type="submit" id="inscrire1" value="Ajouter news"/>
              </form>
            </div>
            <div id = formulaire>
              <form action="indexadmin.php" method="POST">
                <input type="hidden" name="id" value="-2" id="champs" />
                <input type="submit" id="inscrire1" value="Ajouter calendrier"/>
              </form>
            </div>
            <div id = formulaire>
              <form action="indexadmin.php" method="POST">
                <input type="hidden" name="id" value="-3" id="champs" />
                <input type="submit" id="inscrire1" value="Ajouter membre"/>
              </form>
            </div>
            <div id = formulaire>
              <form action="indexadmin.php" method="POST">
                <input type="hidden" name="id" value="-5" id="champs" />
                <input type="submit" id="inscrire1" value="Ajouter partenariats"/>
              </form>
            </div>
            <div id = formulaire>
              <form action="indexadmin.php" method="POST">
                <input type="hidden" name="id" value="-4" id="champs" />
                <input type="submit" id="inscrire1" value="Ajouter image"/>
              </form>
            </div>
            <?php
          } 
        }
?>

  <body/>   
</html>
