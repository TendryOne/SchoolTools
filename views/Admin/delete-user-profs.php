<?php
$pdo = require_once __DIR__ . '/../../Models/Database.php';
require __DIR__ . '/../../Models/M_Profs.php';
require __DIR__ . '/../../Controllers/Profs.php';
$profM = new Profs($pdo);
$profController = new ProfController($profM);


$id_prof = $_GET['id'] ?? '';
$constraints = $profController->CheckModuleConstraints($id_prof);
if ($id_prof && $constraints) {
    header('Location:User-profs.php?error="Veuillez supprimer les modules correspondant a cette utilisateur svp"');
} elseif ($id_prof && !$constraints) {
    $profController->DeleteProf($id_prof);
    header('Location:User-profs.php');
}
