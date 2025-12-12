<?php
/*
 * Point d'entrée de l'API JSON.
 */
set_include_path("./src");

require_once("ApiRouter.php");
require_once("model/AnimalStorageMySQL.php");
require_once('/users/ahmed232/private/mysql_config.php');

// Connexion à la base de données
try {
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    $dsn = MYSQL_HOST . MYSQL_PORT . MYSQL_DB;
    $pdo = new PDO($dsn, MYSQL_USER, MYSQL_PASSWORD, $options);
} catch (PDOException $e) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(500);
    echo json_encode(['error' => 'Connexion impossible à MySQL', 'detail' => $e->getMessage()]);
    exit;
}

$animalStorageMySQL = new AnimalStorageMySQL($pdo);
$router = new ApiRouter();
$router->main($animalStorageMySQL);

