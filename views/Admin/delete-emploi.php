<?php
$pdo = require_once __DIR__ . '/../../Models/Database.php';
require __DIR__ . '/../../Models/M_EmploiDuTemps.php';
require __DIR__ . '/../../Controllers/EmploiDuTemps.php';
$profM = new emploiDuTempsModel($pdo);
$profController = new emploiDuTempsController($profM);

$id_emploi = $_GET['id'] ?? '';

if ($id_emploi) {
    $profController->DeleteEdt($id_emploi);
    header('Location:emploi-du-temps.php');
}
