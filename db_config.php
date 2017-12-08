<?php

$dsn = 'mysql:dbname=association;host=localhost';
$user = 'root';
$password = 'root';

$urlsite = 'http://administration.io/';

try {
    $db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

if(!isset($_SESSION['id'])){
    header ('location: index.php');
}