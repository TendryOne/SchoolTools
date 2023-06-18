<?php

$pdo = require_once __DIR__ . '/../../Models/Database.php';
require __DIR__ . '/../../Models/M_Modules.php';
require __DIR__ . '/../../Controllers/Modules.php';
$moduleM = new moduleModel($pdo);
$moduleController = new moduleController($moduleM);

$id_module = $_GET['id'] ?? '';

if ($id_module) {
    $moduleController->DeleteModule($id_module);
    header('Location: module-list.php');
}
