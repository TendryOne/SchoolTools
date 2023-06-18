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
    <title>GeniusGate</title>
</head>

<body>
    <?php
    $pdo = require_once __DIR__ . '/../../Models/Database.php';
    require __DIR__ . '/../../Controllers/Authentification.php';
    require __DIR__ . '/../../Models/M_Authentification.php';
    require __DIR__ . '/../../Controllers/Admin.php';
    require __DIR__ . '/../../Models/M_Profs.php';
    require __DIR__ . '/../../Controllers/Profs.php';
    require __DIR__ . '/../../Models/M_Modules.php';
    require __DIR__ . '/../../Controllers/Modules.php';
    $moduleModels = new moduleModel($pdo);
    $moduleController = new moduleController($moduleModels);
    $profsModel = new ProfsModel($pdo);
    $EtudiantsModel = new EtudiantsModel($pdo);
    $AdminModel = new Admin($pdo);
    $authController = new AuthController($profsModel, $EtudiantsModel);
    $authAdmin = new AuthAdmin($AdminModel);

    $profM = new Profs($pdo);
    $profController = new ProfController($profM);
    $etudiant = $authController->readEtudiantsAll();
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
    <h2 class="title">Liste des professeurs</h2>
    <div class="container-admin">
        <?php require_once __DIR__ . '/admin-dashboard.php' ?>
        <div class="etudiant-table">
            <table>
                <tr>
                    <th>id</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Statut</th>
                    <th style="width: 300px">remarque</th>
                    <th style="width: 300px;">Action</th>
                </tr>
                <?php foreach ($Profs as $user) : ?>
                    <tr class="<?= $user['validated'] === 'pending' ? 'denied' : '' ?>">
                        <td>
                            <?= $user['id_prof'] ?>
                        </td>
                        <?php
                        $constraints = $profController->CheckModuleConstraints($user['id_prof']);
                        $ModuleAndProf = $moduleController->ReadmoduleByIdProf($user['id_prof']);
                        ?>
                        <td>
                            <?= $user['name'] ?>
                        </td>
                        <td>
                            <?= $user['firstname'] ?>
                        </td>

                        <td>
                            <?php if ($user['validated'] === 'pending') : ?>
                                <i class="fa-solid fa-circle-xmark" style="color: var(--error)"></i>
                            <?php else : ?>
                                <p><i class="fa-solid fa-circle-check" style="color: var(--success);"></i></p>
                            <?php endif ?>

                        </td>
                        <td>
                            <?php if ($user['validated'] === 'pending') : ?>
                                <p>Pas d'accès au plateforme</p>
                            <?php elseif ($constraints) : ?>
                                <p>Ne peut etre supprimer car il est rattacher aux modules
                                    <?php foreach ($ModuleAndProf as $modP) : ?>
                                        <span><?= $modP['id_module'] ?></span>
                                    <?php endforeach ?>
                                </p>
                            <?php endif ?>
                        </td>

                        <td class="button-container" style="display:flex; justify-content:flex-end">
                            <?php if ($user['validated'] === 'pending') : ?>
                                <a class="button" href="/views/Admin/accessgranted-Profs.php?id=<?= $user['id_prof'] ?>">Autoriser</a>
                            <?php endif ?>
                            <a class="button button-delete <?= $constraints ? 'disabled' : '' ?>" style="margin-left:10px" href="/views/Admin/User-profs.php?id=<?= $user['id_prof'] ?>">Effacer</a>
                        </td>
                    </tr>


                <?php endforeach ?>

            </table>

        </div>
    </div>

    <div style="background-color: gray; position:absolute ; bottom:20px ; left: 50%" class="error">

    </div>


    <?php if ($_GET['id'] ?? '') : ?>
        <div class="overlay-container">
            <a class="overlay" href="/views/Admin/User-etudiants.php" style="cursor: auto;"></a>
            <div class="text">
                <p>Vous etes sur de vouloir supprimer ce Professeur ? NB : cette action est irreversible </p>
                <div class="overlay-button">
                    <a class="button canceled-button" href="/views/Admin/User-etudiants.php">Annuler</a>
                    <a class="button canceled-button" href="/views/Admin/delete-user-profs.php?id=<?= $_GET['id'] ?? '' ?>">Supprimer </a>
                </div>
            </div>
        </div>
    <?php endif ?>

    <script src="/assets/js/script.js"></script>
</body>

</html>