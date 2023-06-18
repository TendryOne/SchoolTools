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
    require __DIR__ . '/../../Controllers/modules.php';
    require __DIR__ . '/../../Models/M_Modules.php';
    const REQUIRED_FIELD = "Veuillez remplir ce champ";
    const LONG_MODULE = "votre module est trop long";

    $profsModel = new ProfsModel($pdo);
    $EtudiantsModel = new EtudiantsModel($pdo);
    $AdminModel = new Admin($pdo);
    $emploiModels = new emploiDuTempsModel($pdo);
    $moduleModel = new moduleModel($pdo);

    $authController = new AuthController($profsModel, $EtudiantsModel);
    $authAdmin = new AuthAdmin($AdminModel);
    $edtController = new emploiDuTempsController($emploiModels);
    $moduleController = new moduleController($moduleModel);

    $etudiant = $authController->readEtudiantsAll();
    $Profs = $authController->readProfsAll();
    $currentUserEtudiant = $authController->isLoggedAsEtudiant();
    $currentUserAdmin = $authAdmin->LoggedAsAdmin();
    $currentUserProf = $authController->isLoggedAsProf();
    $etudiants = $authController->readEtudiantsAll();
    $Profs = $authController->readProfsAll();

    $error = [
        'id_module' => '',
        'nom' => '',
        'id_prof' => '',

    ];

    $GetId_module = $_GET['id'] ?? '';
    $modulebyId = $moduleController->readmodulebyId($GetId_module);
    if ($GetId_module) {
        $id_module = $modulebyId['id_module'];
        $nom = $modulebyId['nom'];
        $id_prof = $modulebyId['id_prof'];
    } else {
        $id_prof = $_POST['id_prof'] ?? 'default';
    }






    if (!$currentUserAdmin) {
        header('Location: /');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = filter_input_array(INPUT_POST, [
            'id_module' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'nom' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        ]);

        $id_module = $input['id_module'] ?? '';
        $nom = $input['nom'] ?? '';
        $id_prof = $_POST['id_prof'] ?? 'default';

        if (!$id_module && !$GetId_module) {
            $error['id_module'] = REQUIRED_FIELD;
        } else if (mb_strlen($id_module) > 10) {
            $error['id_module'] = LONG_MODULE;
        }

        if (!$nom) {
            $error['nom'] = REQUIRED_FIELD;
        } elseif (mb_strlen($nom) < 3) {
            $error['nom'] = 'Le nom du module est trop court';
        }

        if (!$id_prof) {
            $error['id_prof'] = REQUIRED_FIELD;
        }

        if (empty(array_filter($error, fn ($e) => $e !== ''))) {
            $module = $moduleController->readmodulebyId($id_module);

            if ($GetId_module) {
                $moduleController->UpdateModule($GetId_module, $nom, $id_prof);
                header('Location: module-list.php');
            } else {

                if ($module) {
                    $error['id_module'] = "$id_module est deja pris";
                } else {
                    $moduleController->insertmodule($id_module, $nom, $id_prof);
                    header('Location: module-list.php');
                }
            }
        }
    }



    ?>
    <?php require_once __DIR__ . '/../header.php' ?>
    <h2 class="title"><?= $GetId_module ? "Modification du module" : "Ajout du module" ?></h2>
    <div class="container-admin">
        <?php require_once __DIR__ . '/admin-dashboard.php' ?>
        <div class="emploi-du-temps">
            <form action='Ajout-module.php<?= $GetId_module ? "?id=$GetId_module" : "" ?>' method="post">

                <div class="form-group">
                    <div class="form-list">
                        <?php if (!$GetId_module) : ?>
                            <input type="text" name="id_module" id="id_module" placeholder="Veuillez entrer l'id du module " value="<?= $id_module ?? '' ?>">
                            <label for="id_module">id_module</label>
                        <?php endif; ?>
                        <?php if ($error['id_module']) : ?>
                            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error['id_module'] ?> </p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-list">

                        <input type="text" name="nom" id="nom" placeholder="Veuillez entrer votre nom ici " value="<?= $nom ?? '' ?>">
                        <label for="">nom du module</label>
                        <?php if ($error['nom']) : ?>
                            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error['nom'] ?> </p>
                        <?php endif; ?>
                    </div>
                </div>


                <div class="form-group">
                    <div class="form-list">

                        <select name="id_prof" id="id_prof">
                            <option value="default" disabled <?= !$id_prof || $id_prof === 'default' ? 'selected' : '' ?>>~~~ Veuillez choisir le professeur ~~~</option>
                            <?php foreach ($Profs as $Prof) : ?>
                                <option class="<?= $Prof['validated'] === 'pending' ? 'denied' : '' ?>" value="<?= $Prof['id_prof'] ?>" <?= $id_prof === $Prof['id_prof'] ? 'selected' : '' ?>> <?= $Prof['name'] ?> <?= $Prof['firstname'] ?> </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="">Professeur</label>

                        <?php if ($error['id_prof']) : ?>
                            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error['id_prof'] ?> </p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="button-container">
                    <button type="submit"><?= $GetId_module ? "Modifier" : "Ajouter" ?></button>
                </div>
            </form>
        </div>


        <script src="/assets/js/script.js"></script>
</body>

</html>