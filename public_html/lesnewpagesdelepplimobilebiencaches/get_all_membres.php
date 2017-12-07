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
$result = $db->query("SELECT * FROM membresasso") or die(mysql_error());

// check for empty result
if (1) {
    // looping through all results
    // calendriers node
    $response["membres"] = array();
 
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // temp user array
        
        $calendrier = array();
        $calendrier["pid"] = $row["id"];
        $calendrier["nom"] = $row["nom"];
        $calendrier["poste"] = $row["poste"];
        $calendrier["photo"] = $row["photo"];
        $calendrier["asso"] = $row["asso"];
        $calendrier["rang"] = $row["rang"];
 
        // push single calendrier into final response array
        array_push($response["membres"], $calendrier);
    }
    // success
    $response["success"] = 1;
 
    // echoing JSON response
    echo json_encode($response);
} else {
    // no calendriers found
    $response["success"] = 0;
    $response["message"] = "No membres found";
 
    // echo no users JSON
    echo json_encode($response);
}
?>