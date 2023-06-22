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
    require __DIR__ . '/../../Models/M_Notes.php';
    require __DIR__ . '/../../Controllers/Notes.php';
    require __DIR__ . '/../../Models/M_Etudiants.php';
    require __DIR__ . '/../../Controllers/Etudiants.php';

    $profsModel = new ProfsModel($pdo);
    $EtudiantsModel = new EtudiantsModel($pdo);
    $AdminModel = new Admin($pdo);
    $emploiModels = new emploiDuTempsModel($pdo);
    $modulesModel = new moduleModel($pdo);
    $noteModel = new NoteModel($pdo);
    $etM = new Etudiants($pdo);


    $authController = new AuthController($profsModel, $EtudiantsModel);
    $authAdmin = new AuthAdmin($AdminModel);
    $edtController = new emploiDuTempsController($emploiModels);
    $moduleController = new moduleController($modulesModel);
    $noteController = new NoteController($noteModel);
    $etudiantController = new EtudiantController($etM);



    $currentUserEtudiant = $authController->isLoggedAsEtudiant();
    $currentUserAdmin = $authAdmin->LoggedAsAdmin();
    $currentUserProf = $authController->isLoggedAsProf();
    $id_mod = $_GET['id_module'] ?? '';
    $id_etu = $_GET['id_etudiant'] ?? '';
    $id_not = $_GET['id_note'] ?? '';
    $etudiant = $etudiantController->ReadEtudiantById($id_etu);
    $protection = $noteController->CheckProtection($id_etu, $id_mod);
    const REQUIRED_FIELD = 'Veuillez entrer une note ';

    if ($id_not) {
        $note = $protection['note'] ?? '';
    }


    $error = [
        'note' => ''
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = filter_input_array(INPUT_POST, [
            'note' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
        ]);

        $note = $input['note'] ?? '';

        if (!$note) {
            $error['note'] = REQUIRED_FIELD;
        }

        if (empty(array_filter($error, fn ($e) => $e !== ''))) {
            if ($id_not) {
                $noteController->UpdateNote($note, $id_not);
                header("Location: List-etudiant.php?id_module=$id_mod");
            } else {
                if ($protection) {
                    $error['note'] = 'Desole Nous ne pouvons pas ajouter de note pour cette etudiant car il en a deja une ';
                } else {
                    $noteController->AddNote($id_etu, $id_mod, $note);
                    header("Location: List-etudiant.php?id_module=$id_mod");
                }
            }
        }
    }



    if (!$currentUserProf) {
        header('Location: /');
    }

    ?>
    <?php require_once __DIR__ . '/../header.php' ?>
    <h2 class="title">Ajout de note</h2>
    <div class="container-admin">
        <?php require_once __DIR__ . '/dashboard.php' ?>
        <div class="emploi-du-temps">
            <form action='ajout-de-note.php?id_module=<?= $id_mod ?>&id_etudiant=<?= $id_etu ?><?= $id_not ? '&id_note=' . $id_not : '' ?>' method="post">
                <div class="form-group">
                    <div class="form-list">
                        <div style="display: flex;">
                            <span style="margin-right:10px; flex:0 0 150px">id de l'etudiant :</span>
                            <h4 style="flex: 1;"><?= $etudiant['id_etudiant'] ?> </h4>
                        </div>
                        <div style="display: flex;">
                            <span style="margin-right:10px; flex:0 0 150px">Nom de l'etudiant :</span>
                            <h4 style="flex: 1;"><?= $etudiant['name'] ?> <?= $etudiant['firstname'] ?></h4>
                        </div>
                        <div style="display: flex;">
                            <span style="margin-right:10px; flex:0 0 150px">MATIERE:</span>
                            <h4 style="flex: 1;"><?= $id_mod ?> </h4>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-list">

                        <input type="number" step="0.01" name="note" id="note" placeholder="Veuillez entrer la note de l'etudiant " value="<?= $note ?? '' ?>">
                        <label for="note">Note</label>
                        <?php if ($error['note']) : ?>
                            <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error['note'] ?> </p>
                        <?php endif; ?>
                    </div>
                </div>


                <div class="button-container">
                    <button type="submit"><?= $id_not ? 'Modifier' : 'Ajouter' ?></button>
                </div>
            </form>
        </div>

    </div>


    <script src="/assets/js/script.js"></script>

</body>

</html>