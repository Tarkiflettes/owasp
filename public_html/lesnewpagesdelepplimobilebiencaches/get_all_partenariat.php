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
$result = $db->query("SELECT * FROM partenariat") or die(mysql_error());
 
// check for empty result
if (1) {
    // looping through all results
    // products node
    $response["products"] = array();
 
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // temp user array
        $product = array();
        $product["pid"] = $row["id"];
        $product["nom"] = $row["nom"];
        $product["description"] = $row["description"];
        $product["photo"] = $row["photo"];
        $product["campus"] = $row["campus"];
 
        // push single product into final response array
        array_push($response["products"], $product);
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
