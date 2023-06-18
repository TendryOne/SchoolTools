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
    require __DIR__ . '/../../Controllers/modules.php';
    require __DIR__ . '/../../Models/M_Modules.php';
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
    $moduleModels = new moduleModel($pdo);
    $moduleController = new moduleController($moduleModels);
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

    $module = $moduleController->readmodule();



    $error = [
        'id_module' => '',
        'jour' => '',
        'heure_debut' => '',
        'heure_fin' => '',
        'salle' => ''
    ];
    $id_emploi = $_GET['id'] ?? '';
    $edtbyId = $edtController->readEdtById($id_emploi);

    if ($id_emploi) {
        $id_module = $edtbyId['id_module'];
        $jour = $edtbyId['jour'];
        $heure_debut = $edtbyId['heure_debut'];
        $heure_fin = $edtbyId['heure_fin'];
        $salle = $edtbyId['salle'];
    } else {
        $id_module = $_POST['id_module'] ?? 'default';
    }




    if (!$currentUserAdmin) {
        header('Location: /');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = filter_input_array(INPUT_POST, [
            'salle' => FILTER_SANITIZE_NUMBER_INT
        ]);
        $id_module = $_POST['id_module'] ?? 'default';
        $jour = $_POST['jour'] ?? '';
        $heure_debut = $_POST['heure_debut'] ?? '';
        $heure_fin = $_POST['heure_fin'] ?? '';
        $salle = $_POST['salle'] ?? '';
        $format = 'Y-m-d';
        $dateTime = DateTime::createFromFormat($format, $jour);

        if ($id_module === 'default') {
            $error['id_module'] = REQUIRED_FIELD;
        }
        if (!$jour) {
            $error['jour'] = REQUIRED_FIELD;
        } elseif (!($dateTime && $dateTime->format($format) === $jour)) {
            $error['jour'] = 'Veuillez entrer une date valide';
        }

        if (!$heure_debut) {
            $error['heure_debut'] = REQUIRED_FIELD;
        }
        if (!$heure_fin) {
            $error['heure_fin'] = REQUIRED_FIELD;
        }

        if (!$salle) {
            $error['salle'] = REQUIRED_FIELD;
        }

        if (empty(array_filter($error, fn ($e) => $e !== ''))) {
            if ($id_emploi) {
                $edtController->UpdateEdt($id_emploi, $id_module, $jour, $heure_debut, $heure_fin, $salle);
                header('Location: emploi-du-temps.php');
            } else {
                $edtController->insertEdt($id_module, $jour, $heure_debut, $heure_fin, $salle);
                header('Location: emploi-du-temps.php');
            }
        }
    }



    ?>
    <?php require_once __DIR__ . '/../header.php' ?>
    <h2 class="title"><?= $id_emploi ? 'Modification de l\'emploi du temps' : 'Ajout emploi du temps' ?></h2>
    <div class="container-admin">
        <?php require_once __DIR__ . '/admin-dashboard.php' ?>
        <div class="emploi-du-temps">
            <form action='Ajout-emploi-du-temps.php<?= $id_emploi ? "?id=$id_emploi" : "" ?>' method="post">
                <div class="form-group">
                    <div class="form-list">
                        <select name="id_module" id="id_module">
                            <option value="default" disabled <?= !$id_module || $id_module === 'default' ? 'selected' : '' ?>>~~~ Veuillez choisir une module ~~~</option>
                            <?php foreach ($module as $modules) :   ?>
                                <option value="<?= $modules['id_module'] ?>" <?= !$id_module || $id_module === $modules['id_module'] ? 'selected' : '' ?>><?= $modules['id_module'] ?> : <?= $modules['nom'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <label for="id_module">id_module</label>
                        <?php if ($error['id_module']) : ?>
                            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error['id_module'] ?> </p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-list">

                        <input type="date" name="jour" id="jour" placeholder="Veuillez entrer votre nom ici " value="<?= $jour ?? '' ?>">
                        <label for="">Jour</label>
                        <?php if ($error['jour']) : ?>
                            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error['jour'] ?> </p>
                        <?php endif; ?>
                    </div>
                </div>


                <div class="form-group">
                    <div class="form-list">

                        <input type="time" name="heure_debut" id="heure_debut" placeholder="Veuillez entrer votre nom ici " value="<?= $heure_debut ?? '' ?>">
                        <label for="">heure du debut</label>
                        <?php if ($error['heure_debut']) : ?>
                            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error['heure_debut'] ?> </p>
                        <?php endif; ?>
                    </div>
                </div>


                <div class="form-group">
                    <div class="form-list">

                        <input type="time" name="heure_fin" id="heure_fin" placeholder="Veuillez entrer votre nom ici " value="<?= $heure_fin ?? '' ?>">
                        <label for="">heure de fin</label>
                        <?php if ($error['heure_fin']) : ?>
                            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error['heure_fin'] ?> </p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-list">

                        <input type="text" name="salle" id="salle" placeholder="Veuillez entrer la salle ici " value="<?= $salle ?? '' ?>">
                        <label for="">Salle</label>
                        <?php if ($error['salle']) : ?>
                            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error['salle'] ?> </p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="button-container">
                    <button type="submit"><?= $id_emploi ? 'Modifier' : 'Ajouter' ?></button>
                </div>
            </form>
        </div>


        <script src="/assets/js/script.js"></script>
</body>

</html>