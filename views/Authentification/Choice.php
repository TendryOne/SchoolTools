<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/assets/css/fontawesome-free-6.4.0-web/css/all.min.css">
        <link rel="shortcut icon" href="/assets/images//logo.png" type="image/x-icon">
        <link rel="stylesheet" href="/assets/css/style.css">
        <title>GeniusGate | choose</title>
    </head>
</head>
<?php
$pdo = require_once __DIR__ . '/../../Models/Database.php';
require __DIR__ . '/../../Controllers/Authentification.php';
require __DIR__ . '/../../Models/M_Authentification.php';
require __DIR__ . '/../../Controllers/Admin.php';


$profsModel = new ProfsModel($pdo);
$EtudiantsModel = new EtudiantsModel($pdo);
$AdminModel = new Admin($pdo);
$authController = new AuthController($profsModel, $EtudiantsModel);
$authAdmin = new AuthAdmin($AdminModel);
$currentUserAdmin = $authAdmin->LoggedAsAdmin();
$currentUserProfs = $authController->isLoggedAsProf();
$currentUserEtudiants = $authController->isLoggedAsEtudiant();

if ($currentUserAdmin || $currentUserProfs || $currentUserEtudiants) {
    header("Location:/");
}


?>

<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }


    .container-choice {
        display: flex;
        background-color: #2d3436;
        min-height: 100vh;
        align-items: center;
        justify-content: center;
    }

    .image-container1 {
        background-image: url('/assets/images/etudiant.png');
        background-position: center;
        background-size: contain;
        background-repeat: no-repeat;
        width: 612px;
        height: 408px;
        filter: grayscale(1);
        transition: 0.5s ease-in-out;
    }

    .image-container2 {
        background-image: url('/assets/images/Professeur.png');
        background-position: center;
        background-size: contain;
        background-repeat: no-repeat;
        width: 612px;
        height: 408px;
        filter: grayscale(1);
        transition: 0.5s ease-in-out;
    }

    .image-container1:hover,
    .image-container2:hover {
        filter: grayscale(0);
        transform: scale(1.1);
    }


    .card {
        position: relative;
        border: 10px solid white;
        width: 600px;
        height: 408px;
        margin: 10px;
        overflow: hidden;
    }



    p {
        color: #2d3436;
        padding: 10px;
        text-align: center;
        position: absolute;
        bottom: 0;
        left: 0;
        display: block;
        width: 100%;
        height: 20%;
        background-color: white;
        transition: 0.5s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card:hover p {
        height: 10%;
    }
</style>





<body>

    <div class="container-choice">
        <a href="/" style="color: white; text-decoration:none"><i class="fa-solid fa-arrow-left-long"></i> Revenir a l'accueil</a>
        <a href="/views/Authentification//register-etudiant.php">
            <div class="card">
                <div class="image-container1"></div>
                <p>Je suis un Etudiant</p>
            </div>
        </a>
        <a href="/views/Authentification/register-prof.php">
            <div class="card">
                <div class="image-container2"></div>
                <p>Je suis un Professeur</p>
            </div>
        </a>
    </div>
</body>

</html>