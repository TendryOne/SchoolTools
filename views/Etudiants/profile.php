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
    <link rel="stylesheet" href="/assets/css/style-profile.css">
    <title>GeniusGate</title>
</head>

<body>


    <?php
    $pdo = require_once __DIR__ . '/../../Models/Database.php';
    require __DIR__ . '/../../Models/M_Authentification.php';
    require __DIR__ . '/../../Controllers/Authentification.php';
    require __DIR__ . "/../../Controllers/Admin.php";
    require __DIR__ . '/../../Models/M_Modules.php';
    require __DIR__ . '/../../Controllers/Modules.php';
    require __DIR__ . '/../../Models/M_Etudiants.php';
    require __DIR__ . '/../../Controllers/Etudiants.php';


    $EtudantM = new Etudiants($pdo);
    $EtudiantController = new EtudiantController($EtudantM);
    $AdminModels = new Admin($pdo);
    $authAdmin = new AuthAdmin($AdminModels);
    $profsModels = new ProfsModel($pdo);
    $etudiantsModels = new EtudiantsModel($pdo);
    $modulesModel = new moduleModel($pdo);
    $AuthDB = new AuthController($profsModels, $etudiantsModels);
    $moduleController = new moduleController($modulesModel);
    $currentUserEtudiant = $AuthDB->isLoggedAsEtudiant();
    $currentUserAdmin = $authAdmin->LoggedAsAdmin();
    $currentUserProf = $AuthDB->isLoggedAsProf();
    $etudiants = $AuthDB->readEtudiantsAll();
    $Profs = $AuthDB->readProfsAll();

    $error = [
        'image' => ''
    ];


    $location = __DIR__ . '/../../assets/ProfilePicture/';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if ($_FILES['ProfilePicture']['error'] === UPLOAD_ERR_OK) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'jpg1'];
            $fileName = $_FILES['ProfilePicture']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (in_array($fileExtension, $allowedExtensions)) {
                $uploadDirectory = $location;
                $uniqueFileName = uniqid() . '_' . $_FILES['ProfilePicture']['name'];
                $destinationPath = $uploadDirectory . $uniqueFileName;
                $dest = "/assets/ProfilePicture/$uniqueFileName";

                if (!empty($currentUserEtudiant['ProfilePicture'])) {
                    $oldFilePath = $uploadDirectory . basename($currentUserEtudiant['ProfilePicture']);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                if (move_uploaded_file($_FILES['ProfilePicture']['tmp_name'], $destinationPath)) {
                    $EtudiantController->UploadProfile($dest, $currentUserEtudiant['id_etudiant']);
                    header('Location: profile.php');
                } else {
                    $error['image'] = "Une erreur s'est produite durant le téléchargement de la nouvelle photo de profil";
                }
            } else {
                $error['image'] = "La photo de profil doit être au format JPEG, JPG ou PNG";
            }
        } else {
            $error['image'] = "Une erreur s'est produite lors du téléchargement de la nouvelle photo de profil";
        }
    }



    ?>
    <?php require_once __DIR__ . '/../header.php' ?>
    <div class="profile-container">
        <h2>Mes informations</h2>

        <form action="profile.php" method="POST" enctype="multipart/form-data">

            <div class="custom-file-input">
                <input type="file" id="myFile" name="ProfilePicture" onchange="displayImagePreview(this)">

                <label for="myFile" id="fileLabel" style="background-image:url('<?= !$currentUserEtudiant['ProfilePicture'] ? '/assets/images/logoNB.png' : $currentUserEtudiant['ProfilePicture'] ?>');">Modifier ma Photo de profil</label>
                <p id="fileName"></p>
                <?php if ($error['image']) : ?>
                    <p><?= $error['image'] ?></p>
                <?php endif ?>

            </div>

            <ul class="information-container">
                <div class="info-content">
                    <span>Nom :</span>
                    <li> <?= $currentUserEtudiant['name'] ?></li>
                </div>
                <div class="info-content">
                    <span>Prenom :</span>
                    <li><?= $currentUserEtudiant['firstname'] ?></li>
                </div>
                <div class="info-content">
                    <span>Votre email :</span>
                    <li><?= $currentUserEtudiant['email'] ?></li>
                </div>
                <div class="info-content">
                    <span>Mon statut :</span>
                    <li><i class="fa-solid fa-circle-check" style="color: var(--success)"></i></li>
                </div>
                <div class="info-content">
                    <span>Mon Role :</span>
                    <li><i class="fa-solid fa-user-graduate"></i> </li>
                </div>
            </ul>
            <div class="button-container">
                <button type="submit">Valider les changements</button>
            </div>
        </form>
    </div>
    <?php require_once __DIR__ . '/../footer.php' ?>
    <script src="/assets/js/script.js"></script>
</body>


</html>