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
	              	<li> <a href="membres.php">membres</a> </li>
                  <li> <a href="partenariats.php">partenariats</a> </li>
	              	<li class = "active"> <a href="notif.php">notif</a> </li>
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
    if(!isset($_SESSION['id']))
  {
    header ('location: membres.php');
  }

		$message = htmlspecialchars($_POST['message']);
		$title = htmlspecialchars($_POST['titre']);
    $i =0;
    $nbsend = 0;
		$asso = "BDE";

		if($_SESSION['id'] == 0)
			$asso = "BDE";
		if($_SESSION['id'] == 1)
			$asso = "FUSION";
		if($_SESSION['id'] == 2)
			$asso = "BDS";
		if($_SESSION['id'] == 3)
			$asso = "BDA";
		if($_SESSION['id'] == 4)
			$asso = "RCLAB";
		if($_SESSION['id'] == 5)
			$asso = "ROBOT";
		if($_SESSION['id'] == 6)
			$asso = "LABEL";

    if($_SESSION['id'] == 10)
      $asso = "BDE_P";
    if($_SESSION['id'] == 11)
      $asso = "AGGE_P";
    if($_SESSION['id'] == 12)
      $asso = "BDS_P";
    if($_SESSION['id'] == 13)
      $asso = "BDA_P";
    if($_SESSION['id'] == 14)
      $asso = "KPS_P";
    if($_SESSION['id'] == 15)
      $asso = "DTRE_P";
    if($_SESSION['id'] == 16)
      $asso = "BDJ_P";
    if($_SESSION['id'] == 17)
      $asso = "REC_P";
    if($_SESSION['id'] == 18)
      $asso = "JUNIOR_P";
    if($_SESSION['id'] == 19)
      $asso = "AIRESIEA_P";
    

		if($_SESSION['id'] == -1)
    {
      $campus = htmlspecialchars($_POST['campus']);
      if($campus == 0)
			  $sql = "SELECT token,VERSION FROM devices WHERE CAMPUS = 0";
      else if($campus == 1)
        $sql = "SELECT token,VERSION FROM devices WHERE CAMPUS = 1";
      else if($campus == 2)
        $sql = "SELECT token,VERSION FROM devices";
    }
		else
			$sql = "SELECT token,VERSION FROM devices WHERE $asso = 1";

		$result = $db->query($sql);

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $tokens[0] = $row["token"];
        $version = $row["VERSION"];

    if($version > 28)
    {
        $icone = $donnees["icone"];
        

      $image = "http://79.137.87.179:443/iconeasso/".$icone;

      $message_status = send_notif_data($tokens, $title, $message, $image);
    }
    else
		    $message_status = send_notif($tokens, $title, $message);


    $obj = json_decode($message_status);
    if($obj->success == 0)
      {
        $req = $db->prepare("DELETE FROM devices WHERE token = :token");

              $req->execute(array(
                ':token' => $tokens[0]
            ));
              $donnees = $req->fetch();
      }
      else
      {
        $nbsend ++;
      }
  }
  echo $nbsend;
  echo " personnes touchées";
	?>
    <meta http-equiv="refresh" content="20 ; url=notif.php">
	<?php

function send_notif($tokens, $title, $message)
    {
      $url = 'https://fcm.googleapis.com/fcm/send';
      $fields = array('registration_ids'=>$tokens,'notification' => array('title'=>$title,'body'=>$message,'sound'=>'mySound'));
      $server_key = "AAAA5f4xvKE:APA91bFAG_i7I4OHWpbkvjE83qUTPPcFWUR_8brUT704zpuX5a73N2kA_aaMs8IzxiupVSj9S31mrg2lVRM_k23IBDlnKfQovMvvioXF1Lbcj5XQuOzEpLNwBrO3i357PDdSrMyPz76u";
      $headers = array('Authorization:key=' .$server_key,'Content-Type:application/json');
      
      $curl_session = curl_init();
      curl_setopt($curl_session, CURLOPT_URL, $url);
      curl_setopt($curl_session, CURLOPT_POST, true);
      curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
      curl_setopt($curl_session, CURLOPT_POSTFIELDS, json_encode($fields));
      $result = curl_exec($curl_session);
      
      if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }

    curl_close($curl_session);
    return $result;
    }

    function send_notif_data($tokens, $title, $message, $image)
    {
      $url = 'https://fcm.googleapis.com/fcm/send';
      $fields = array ( "registration_ids" => $tokens,"data" => array("title" => $title,"message" => $message,"url_icon" => $image));
      $server_key = "AAAA5f4xvKE:APA91bFAG_i7I4OHWpbkvjE83qUTPPcFWUR_8brUT704zpuX5a73N2kA_aaMs8IzxiupVSj9S31mrg2lVRM_k23IBDlnKfQovMvvioXF1Lbcj5XQuOzEpLNwBrO3i357PDdSrMyPz76u";
      $headers = array('Authorization:key=' .$server_key,'Content-Type:application/json');

      $curl_session = curl_init();
      curl_setopt($curl_session, CURLOPT_URL, $url);
      curl_setopt($curl_session, CURLOPT_POST, true);
      curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
      curl_setopt($curl_session, CURLOPT_POSTFIELDS, json_encode($fields));
      $result = curl_exec($curl_session);
      
      if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }

    curl_close($curl_session);
    return $result;
    }
?>
  <body/>   
</html>