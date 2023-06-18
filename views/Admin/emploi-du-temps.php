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
    const REQUIRED_FIELD = "Veuillez remplir ce champ";
    const LONG_MODULE = "votre module est trop long";

    $profsModel = new ProfsModel($pdo);
    $EtudiantsModel = new EtudiantsModel($pdo);
    $AdminModel = new Admin($pdo);
    $emploiModels = new emploiDuTempsModel($pdo);
    $authController = new AuthController($profsModel, $EtudiantsModel);
    $authAdmin = new AuthAdmin($AdminModel);
    $edtController = new emploiDuTempsController($emploiModels);
    $etudiant = $authController->readEtudiantsAll();
    $edt = $edtController->readEdt();
    $Profs = $authController->readProfsAll();
    $currentUserEtudiant = $authController->isLoggedAsEtudiant();
    $currentUserAdmin = $authAdmin->LoggedAsAdmin();
    $currentUserProf = $authController->isLoggedAsProf();
    $etudiants = $authController->readEtudiantsAll();
    $Profs = $authController->readProfsAll();


    $error = [
        'id_module' => '',
        'jour' => '',
        'heure_debut' => '',
        'heure_fin' => '',
        'salle' => ''
    ];

    if (!$currentUserAdmin) {
        header('Location: /');
    }

    setlocale(LC_TIME, 'fr_FR.UTF-8');


    $date = date('Y-m-d');
    $edtController->AutoDeleteEvent($date);

    ?>
    <?php require_once __DIR__ . '/../header.php' ?>
    <h2 class="title">Emploi Du Temps</h2>
    <div class="container-admin">
        <?php require_once __DIR__ . '/admin-dashboard.php' ?>
        <div class="etudiant-table">
            <table>
                <tr>
                    <th>id_module</th>
                    <th>jour</th>
                    <th>heure du debut</th>
                    <th>heure de fin</th>
                    <th>Salle</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($edt as $emploi) : ?>
                    <?php
                    $jour_en = date("l", strtotime($emploi['jour']));
                    $jour_fr = str_replace(
                        array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
                        array('Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.', 'Dim.'),
                        $jour_en
                    );
                    ?>
                    <tr>
                        <td>
                            <?= $emploi['id_module'] ?>
                        </td>
                        <td>
                            <?= $jour_fr ?> <?= date("d-m-Y", strtotime($emploi['jour'])) ?>
                        </td>
                        <td>
                            <?= date("H:i", strtotime($emploi['heure_debut'])) ?>
                        </td>
                        <td>
                            <?= date("H:i", strtotime($emploi['heure_fin'])) ?>
                        </td>
                        <td>
                            <?= $emploi['salle'] ?>
                        </td>
                        <td class="button-container">
                            <a class="button" href="/views/Admin/ajout-emploi-du-temps.php?id=<?= $emploi['id_emploi'] ?>">modifier</a>
                            <a class="button button-delete" href="/views/Admin/emploi-du-temps.php?id=<?= $emploi['id_emploi'] ?>">supprimer</a>
                        </td>
                    </tr>

                <?php endforeach ?>

            </table>
        </div>
    </div>

    <?php if ($_GET['id'] ?? '') : ?>
        <div class=" overlay-container">
            <a class="overlay" href="/views/Admin/User-etudiants.php" style="cursor: auto;"></a>
            <div class="text">
                <p>Vous etes sur de vouloir supprimer ce Professeur ? NB : cette action est irreversible </p>
                <div class="overlay-button">
                    <a class="button canceled-button" href="/views/Admin/emploi-du-temps.php">Annuler</a>
                    <a class="button canceled-button" href="/views/Admin/delete-emploi.php?id=<?= $_GET['id'] ?? '' ?>">Supprimer </a>
                </div>
            </div>
        </div>
    <?php endif ?>
    <script src="/assets/js/script.js"></script>


    <script src="/assets/js/script.js"></script>
</body>

</html>