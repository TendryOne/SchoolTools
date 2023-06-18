<?php
$pdo = require_once __DIR__ . '/../../Models/Database.php';
require __DIR__ . '/../../Models/M_Profs.php';
require __DIR__ . '/../../Controllers/Profs.php';
$profM = new Profs($pdo);
$profController = new ProfController($profM);

$id_prof = $_GET['id'] ?? '';

if ($id_prof) {
    $profController->AccessGrantedProfs($id_prof);
    header('Location:User-profs.php');
}
