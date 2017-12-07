<?php

require_once __DIR__ . '/../../newdb_config.php';
// connecting to db
$db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USER, DB_PASSWORD) or die(mysql_error());

if(isset($_POST['token']) AND !empty($_POST['token']))
{
    $token = htmlspecialchars($_POST['token']);
    $bde = htmlspecialchars($_POST['bde']);
    $bds = htmlspecialchars($_POST['bds']);
    $bda = htmlspecialchars($_POST['bda']);
    $rclab = htmlspecialchars($_POST['rclab']);
    $fusion = htmlspecialchars($_POST['fusion']);
    $robot = htmlspecialchars($_POST['robot']);
    $label = htmlspecialchars($_POST['label']);

    $bde_p = htmlspecialchars($_POST['bde_p']);
    $agge_p = htmlspecialchars($_POST['agge_p']);
    $bda_p = htmlspecialchars($_POST['bda_p']);
    $bds_p = htmlspecialchars($_POST['bds_p']);
    $kps_p = htmlspecialchars($_POST['kps_p']);
    $dtre_p = htmlspecialchars($_POST['dtre_p']);
    $bdj_p = htmlspecialchars($_POST['bdj_p']);
    $rec_p = htmlspecialchars($_POST['rec_p']);
    $junior_p = htmlspecialchars($_POST['junior_p']);
    $airesiea_p = htmlspecialchars($_POST['airesiea_p']);
    $version = "";
    $version = htmlspecialchars($_POST['version']);
    $campus = htmlspecialchars($_POST['campus']);


    if($bde == 0 && $bds == 0 && $bda == 0 && $rclab == 0 && $fusion == 0 && $robot == 0 && $label == 0)
        $campus = "1";
    else
        $campus = "0";
    $count = $db->prepare("SELECT COUNT(id) as exist FROM devices WHERE token = :token");

    $donnees = $count->execute(array(
                ':token' => $token
              ));

    $row = $count->fetch();
    $exist = $row["exist"];

    if($exist == 0)
    {
        $req = $db->prepare("INSERT INTO devices(token, BDE, BDA, BDS, FUSION, ROBOT, RCLAB, LABEL, BDE_P, AGGE_P, BDA_P, BDS_P, KPS_P, DTRE_P, BDJ_P, REC_P, JUNIOR_P, AIRESIEA_P, VERSION, CAMPUS) VALUES (:token, :bde, :bda, :bds, :fusion, :robot, :rclab, :label, :bde_p, :agge_p, :bda_p, :bds_p, :kps_p, :dtre_p, :bdj_p, :rec_p, :junior_p, :airesiea_p, :version, :campus)");
        $success = $req->execute(array(
                    ':token' => $token,
                    ':bde' => $bde,
                    ':bda' => $bda,
                    ':bds' => $bds,
                    ':fusion' => $fusion,
                    ':robot' => $robot,
                    ':rclab' => $rclab,
                    ':label' => $label,

                    ':bde_p' =>$bde_p,
                    ':agge_p' =>$agge_p,
                    ':bda_p' =>$bda_p,
                    ':bds_p' =>$bds_p,
                    ':kps_p' =>$kps_p,
                    ':dtre_p' =>$dtre_p,
                    ':bdj_p' =>$bdj_p,
                    ':rec_p' =>$rec_p,
                    ':junior_p' =>$junior_p,
                    ':airesiea_p' =>$airesiea_p,
                    ':version' =>$version,
                    ':campus' =>$campus
                  ));

        $response = array();

        if($success){
        	$response['error'] = false;
        	$response['message'] = 'token stored successfully';
        }else{
        	$response['error'] = true;
        	$response['message'] = "error";
        }

        echo json_encode($response);
    }
    else
    {
        // lancement de la requete
            $req2 = $db->prepare("UPDATE devices SET BDE = :bde, BDA = :bda, BDS = :bds, FUSION = :fusion, ROBOT = :robot, RCLAB = :rclab, LABEL = :label, BDE_P = :bde_p, AGGE_P = :agge_p, BDA_P = :bda_p, BDS_P = :bds_p, KPS_P = :kps_p, DTRE_P = :dtre_p, BDJ_P = :bdj_p, REC_P = :rec_p, JUNIOR_P = :junior_p, AIRESIEA_P = :airesiea_p, VERSION = :version, CAMPUS = :campus WHERE token = :token");
            $success = $req2->execute(array(
                    ':token' => $token,
                    ':bde' => $bde,
                    ':bda' => $bda,
                    ':bds' => $bds,
                    ':fusion' => $fusion,
                    ':robot' => $robot,
                    ':rclab' => $rclab,
                    ':label' => $label,

                    ':bde_p' =>$bde_p,
                    ':agge_p' =>$agge_p,
                    ':bda_p' =>$bda_p,
                    ':bds_p' =>$bds_p,
                    ':kps_p' =>$kps_p,
                    ':dtre_p' =>$dtre_p,
                    ':bdj_p' =>$bdj_p,
                    ':rec_p' =>$rec_p,
                    ':junior_p' =>$junior_p,
                    ':airesiea_p' =>$airesiea_p,
                    ':version' =>$version,
                    ':campus' =>$campus
                  ));

        $response = array();

        if($success){
            $response['error'] = false;
            $response['message'] = 'token update successfully';
        }else{
            $response['error'] = true;
            $response['message'] = "error";
        }

        echo json_encode($response);
    }
}
?>
