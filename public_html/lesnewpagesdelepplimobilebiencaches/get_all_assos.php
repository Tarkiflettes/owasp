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
$result = $db->query("SELECT * FROM nomasso") or die(mysql_error());
 
// check for empty result
if (1) {
    // looping through all results
    // products node
    $response["assos"] = array();
 
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // temp user array
        $product = array();
        $product["pid"] = $row["Id"];
        $product["idasso"] = $row["idasso"];
        $product["nomasso"] = $row["nomasso"];
        $product["couleur"] = $row["couleur"];
        $product["email"] = $row["email"];
        $product["photo"] = $row["photo"];
        $product["facebook"] = $row["facebook"];
        $product["snapchat"] = $row["snapchat"];
        $product["twitter"] = $row["twitter"];
        $product["instagram"] = $row["instagram"];
        $product["youtube"] = $row["youtube"];
        $product["telephone"] = $row["telephone"];
        $product["campus"] = $row["campus"];
        $product["icone"] = $row["icone"];
        $product["description"] = $row["descasso"];
 
        // push single product into final response array
        array_push($response["assos"], $product);
    }
    // success
    $response["success"] = 1;
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No products found";
}
echo json_encode($response);
?>
