<?php
$pdo = require_once __DIR__ . '/../../Models/Database.php';
require __DIR__ . '/../../Models/M_Etudiants.php';
require __DIR__ . '/../../Controllers/Etudiants.php';
require __DIR__ . '/../../Controllers/Notes.php';
require __DIR__ . '/../../Models/M_Notes.php';
$EtudiantM = new Etudiants($pdo);
$noteModel = new NoteModel($pdo);
$EtudiantController = new EtudiantController($EtudiantM);
$noteController = new NoteController($noteModel);


$id_etudiant = $_GET['id'] ?? '';

if ($id_etudiant) {
    try {
        $pdo->beginTransaction();
        $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
        $EtudiantController->DeleteEtudiant($id_etudiant);
        $noteController->DeleteNote($id_etudiant);
        $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
        $pdo->commit();
        header('Location:User-etudiants.php');
    } catch (PDOException $th) {
        $pdo->rollBack();
        $th->getMessage();
    }
}
