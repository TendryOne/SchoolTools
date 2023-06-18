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




    if (!$currentUserAdmin) {
        header('Location: /');
    }

    ?>
    <?php require_once __DIR__ . '/../header.php' ?>
    <h2 class="title">Emploi Du Temps</h2>
    <div class="container-admin">
        <?php require_once __DIR__ . '/admin-dashboard.php' ?>
        <div class="etudiant-table">
            <table>
                <tr>
                    <th>id_module</th>
                    <th>Nom de la matiere</th>
                    <th>Professeur</th>
                    <th style="width: 300px;">Remarque</th>
                    <th>action</th>
                </tr>
                <?php foreach ($modules as $module) : ?>
                    <tr>
                        <td>
                            <?= $module['id_module'] ?>
                        </td>
                        <?php
                        $moduleEdt = $edtController->ReadEdtByidModule($module['id_module']);
                        $constraints = $moduleController->checkConstraints($module['id_module'], $module['id_prof']);
                        ?>
                        <td>
                            <?= $module['nom'] ?>
                        </td>
                        <td>
                            <?= $module['name'] ?> <?= $module['firstname'] ?>
                        </td>
                        <td>
                            <?php if ($moduleEdt) : ?>
                                <p>Ne peut être supprimer car ce module est ratacher à un evenement du <?= DateTime::createFromFormat('Y-m-d', $moduleEdt['jour'])->format('d/m/Y'); ?> de <?= $moduleEdt['id_module'] ?></p>
                            <?php endif ?>
                        </td>
                        <td class="button-container">
                            <a class="button" href="/views/Admin/Ajout-module.php?id=<?= $module['id_module'] ?>">Modifier</a>
                            <a class="button button-delete <?= $constraints ? 'disabled' : '' ?>" href="/views/Admin/delete-module.php?id=<?= $module['id_module'] ?>">Effacer</a>
                        </td>
                    </tr>

                <?php endforeach ?>

            </table>
        </div>
    </div>

    <script src="/assets/js/script.js"></script>


    <script src="/assets/js/script.js"></script>
</body>

</html>