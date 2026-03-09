<?php
/*
 * On indique que les chemins des fichiers qu'on inclut
 * seront relatifs au répertoire src.
 */
set_include_path("./src");

/* Inclusion des classes utilisées dans ce fichier */
require_once("Router.php");
require_once("model/AnimalStorageSession.php");
require_once("model/AnimalStorageMySQL.php");
require_once(__DIR__ . '/mysql_config.php');
session_name("Site_Animaux");
session_start();
/*
 * Cette page est simplement le point d'arrivée de l'internaute
 * sur notre site. On se contente de créer un routeur
 * et de lancer son main.
 */

// Connexion à la base de données
try {
    // Options de connexion
    $options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    $dsn = MYSQL_HOST. MYSQL_PORT . MYSQL_DB;
    $pdo= new PDO($dsn, MYSQL_USER, MYSQL_PASSWORD, $options);
} catch (PDOException $e) {
    echo "Connexion impossible à mySql : ", $e->getMessage();
    exit(); // Arrêter l'exécution du script en cas d'échec de connexion
}

$animalStorageMySQL = new AnimalStorageMySQL($pdo);
$router = new Router();
$router->main($animalStorageMySQL);
?>