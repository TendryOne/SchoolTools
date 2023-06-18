<?php
$pdo = require_once __DIR__ . '/../../Models/Database.php';
require __DIR__ . '/../../Models/M_Etudiants.php';
require __DIR__ . '/../../Controllers/Etudiants.php';
$EtudiantM = new Etudiants($pdo);
$EtudiantController = new EtudiantController($EtudiantM);

$id_etudiant = $_GET['id'] ?? '';

if ($id_etudiant) {
    $EtudiantController->DeleteEtudiant($id_etudiant);
    header('Location:User-etudiants.php');
}
