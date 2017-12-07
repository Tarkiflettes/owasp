<?php
 
/*
 * Following code will list all the products
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '/../../newdb_config.php';
// connecting to db
$db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USER, DB_PASSWORD) or die(mysql_error());
// get all products from products table
$result = $db->query("SELECT * FROM calendrier JOIN nomasso ON nomasso.idasso = calendrier.asso") or die(mysql_error());
// check for empty result
if (1) {
    // looping through all results
    // calendriers node
    $response["calendriers"] = array();
 
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // temp user array
        $calendrier = array();
        $calendrier["pid"] = $row["id"];
        $calendrier["name"] = $row["name"];
        $calendrier["description"] = $row["description"];
        $calendrier["datemodif"] = $row["datemodif"];
        $calendrier["jour"] = $row["jour"];
        $calendrier["datedebut"] = $row["datedebut"];

        $tmp1 = $row["jourfin"];
        $tmp2 = $row["numerofin"];
        $tmp3 = $row["moisfin"];
        $tmp4 = $row["heurefin"];

        $calendrier["datefin"] = $tmp1 ." ". $tmp2 ." ". $tmp3 ." ". $tmp4;

        $calendrier["lieu"] = $row["lieu"];
        $calendrier["nomasso"] = $row["nomasso"];
        $calendrier["couleur"] = $row["couleur"];
        $calendrier["campus"] = $row["campus"];
     
        // push single calendrier into final response array
        array_push($response["calendriers"], $calendrier);
    }
    // success
    $response["success"] = 1;
 
    // echoing JSON response
    echo json_encode($response);
} else {
    // no calendriers found
    $response["success"] = 0;
    $response["message"] = "No calendriers found";
 
    // echo no users JSON
    echo json_encode($response);
}
?>