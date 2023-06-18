<?php
$pdo = require_once __DIR__ . '/../../Models/Database.php';
require __DIR__ . '/../../Controllers/Admin.php';
require __DIR__ . '/../../Models/M_Authentification.php';

$adminModels = new Admin($pdo);
$adminAuth = new AuthAdmin($adminModels);

$session = $_COOKIE['sessionAdmin'];
if ($session) {
    $adminAuth->LogoutAdmin();
    header('Location: /');
}
