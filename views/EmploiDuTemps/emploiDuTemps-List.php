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

    $Profs = $authController->readProfsAll();
    $currentUserEtudiant = $authController->isLoggedAsEtudiant();
    $currentUserAdmin = $authAdmin->LoggedAsAdmin();
    $currentUserProf = $authController->isLoggedAsProf();
    $etudiants = $authController->readEtudiantsAll();
    $Profs = $authController->readProfsAll();
    $edt = $edtController->GetProfEdt($currentUserProf['id_prof']);

    $error = [
        'id_module' => '',
        'jour' => '',
        'heure_debut' => '',
        'heure_fin' => '',
        'salle' => ''
    ];

    if (!$currentUserProf) {
        header('Location: /');
    }
    date_default_timezone_set('Indian/Antananarivo');
    $date = date('Y-m-d');
    $edtController->AutoDeleteEvent($date);

    ?>
    <?php require_once __DIR__ . '/../header.php' ?>
    <h2 class="title">Mon Emploi Du Temps</h2>
    <div class="container-admin">
        <div class="etudiant-table">
            <table>
                <tr>
                    <th>id_module</th>
                    <th>jour</th>
                    <th>heure du debut</th>
                    <th>heure de fin</th>
                    <th>Salle</th>
                    <th style="width: 400px; ">Remarque</th>
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
                            <?php if (date('Y-m-d') === $emploi['jour']) : ?>
                                <p>Aujourd'hui</p>
                            <?php else : ?>
                                <?= $jour_fr ?> <?= date("d-m-Y", strtotime($emploi['jour'])) ?>
                            <?php endif ?>
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
                        <td style="text-align: end;">
                            <?php
                            $eventDateTime = new DateTime($emploi['jour'] . $emploi['heure_debut']);
                            $endDateTime = new DateTime($emploi['jour'] . $emploi['heure_fin']);
                            $currentDateTime = new DateTime();
                            $diff = $currentDateTime->diff($eventDateTime);

                            $days = $diff->days;
                            $hours = $diff->h;
                            $min = $diff->i;
                            ?>
                            <?php if ($currentDateTime > $endDateTime) : ?>
                                <p class="error"> Événement manqué</p>
                            <?php elseif ($currentDateTime >= $eventDateTime && $currentDateTime <= $endDateTime) : ?>
                                <p class="success">Evenement en cours</p>
                            <?php else : ?>
                                <?php if ($days === 0 && $hours !== 0) : ?>
                                    <p>L'événement se déroule dans <?= $hours ?> heures et <?= $min ?> minutes </p>
                                <?php elseif ($hours === 0) : ?>
                                    <p>L'événement se déroule dans <?= $min ?> minutes</p>
                                <?php elseif ($hours === 0 && $days === 0 & $min === 0) : ?>
                                    <p class="success">evenement en cours</p>
                                <?php else : ?>
                                    <p>L'événement se déroule dans <?= $days . ' jours ' . $hours . ' heures. ' ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>

                    </tr>

                <?php endforeach ?>

            </table>
        </div>
    </div>




    <script src="/assets/js/script.js"></script>
</body>

</html>