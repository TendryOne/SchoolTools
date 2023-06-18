<?php
$pdo = require_once __DIR__ . '/../../Models/Database.php';
require __DIR__ . '/../../Controllers/Authentification.php';
require __DIR__ . '/../../Models/M_Authentification.php';

$profModel = new ProfsModel($pdo);
$etudiantModel = new EtudiantsModel($pdo);

$authDb = new AuthController($profModel, $etudiantModel);
$session = $_COOKIE['session'];
if ($session) {
    $authDb->logoutProf();
    $authDb->logoutEtudiant();
    header('Location: login.php');
    $pdo->closeCursor();
}
