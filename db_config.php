<?php

$dsn = 'mysql:dbname=association;host=localhost';
$user = 'root';
$password = 'root';

try {
    $db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}