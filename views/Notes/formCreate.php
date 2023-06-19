<!DOCTYPE html>
<html lang="en">

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
    <link rel="stylesheet" href="/assets/css/style-user-admin.css">
    <link rel="stylesheet" href="/assets/css/style-emploiDuTemps.css">
    <title>GeniusGate</title>
</head>
<style>
    body {
        display: block;
    }
</style>

<body>
    <?php
    $pdo = require_once __DIR__ . '/../../Models/Database.php';
    require __DIR__ . '/../../Controllers/Authentification.php';
    require __DIR__ . '/../../Models/M_Authentification.php';
    require __DIR__ . '/../../Controllers/Admin.php';
    require __DIR__ . '/../../Controllers/EmploiDuTemps.php';
    require __DIR__ . '/../../Models/M_EmploiDuTemps.php';
    require __DIR__ . '/../../Models/M_Modules.php';
    require __DIR__ . '/../../Controllers/Modules.php';

    $profsModel = new ProfsModel($pdo);
    $EtudiantsModel = new EtudiantsModel($pdo);
    $AdminModel = new Admin($pdo);
    $emploiModels = new emploiDuTempsModel($pdo);
    $modulesModel = new moduleModel($pdo);
    $authController = new AuthController($profsModel, $EtudiantsModel);
    $authAdmin = new AuthAdmin($AdminModel);
    $edtController = new emploiDuTempsController($emploiModels);
    $moduleController = new moduleController($modulesModel);

    $etudiant = $authController->readEtudiantsAll();
    $edt = $edtController->readEdt();
    $modules = $moduleController->ReadmoduleAndProfs();
    $Profs = $authController->readProfsAll();
    $currentUserEtudiant = $authController->isLoggedAsEtudiant();
    $currentUserAdmin = $authAdmin->LoggedAsAdmin();
    $currentUserProf = $authController->isLoggedAsProf();
    $etudiants = $authController->readEtudiantsAll();
    $Profs = $authController->readProfsAll();
    $modules = $moduleController->ReadmoduleByIdProf($currentUserProf['id_prof']);




    if (!$currentUserProf) {
        header('Location: /');
    }

    ?>
    <?php require_once __DIR__ . '/../header.php' ?>
    <h2 class="title">Note</h2>
    <ul class="note-container">
        <?php foreach ($modules as $module) : ?>
            <a style="text-decoration: none;" href="./List-etudiant.php?id_module=<?= $module['id_module'] ?>">
                <div class="card">
                    <li class="image-container"></li>
                    <div class="module-container">
                        <li><?= $module['nom'] ?></li>
                        <li><?= $module['id_module'] ?></li>
                    </div>
                </div>
            </a>
        <?php endforeach ?>
    </ul>


    <script src="/assets/js/script.js"></script>

</body>

</html>