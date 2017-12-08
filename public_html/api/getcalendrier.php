<?php
 
/*
 * Following code will list all the products
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '/../../newdb_config.php';
// get all products from products table
$result = $db->query("SELECT * FROM calendrier") or die(mysql_error());
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

        $calendrier["lieu"] = $row["lieu"];
     
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