<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style-register.css">
    <link rel="shortcut icon" href="/assets/images/logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/fontawesome-free-6.4.0-web/css/all.min.css">
    <title>Inscription Etudiant | GeniusGate</title>
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

const SHORT_NAME = "Votre nom est trop court";
const INVALID_NAME = "Votre nom ne peut contenir que des lettres";
const SHORT_FIRSTNAME = "Votre Prenom est trop court";
const INVALID_FIRSTNAME = "Votre Prenom ne peut contenir que des lettres";
const REQUIRED_FIELD = "Veuillez remplir ce champ";
const SHORT_PASSWORD = "Votre mot de passe doit etre superieur a 8 caracteres";
const REGEX_PASSWORD = "Votre mot de passe doit contenir au moins 1 Majuscule et 1 chiffre";
const INVALID_EMAIL = "Votre email n'est pas valid , Veuillez essayer le format GenieGate@exemple.mg";
const TAKEN_EMAIL = "Cette email a deja ete utilise";



$level = $_POST['level'] ?? 'Default';

$error = [
    'name' => '',
    'firstname' => '',
    'level' => '',
    'email' => '',
    'password' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = filter_input_array(INPUT_POST, [
        'name' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'firstname' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'email' => FILTER_SANITIZE_EMAIL
    ]);

    $name = $input['name'] ?? '';
    $firstname = $input['firstname'] ?? '';
    $email = $input['email'] ?? '';
    $password = $_POST['password'] ?? '';


    if (!$name) {
        $error['name'] = REQUIRED_FIELD;
    } else if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
        $error['name'] = INVALID_NAME;
    } else if (mb_strlen($name) < 1) {
        $error['name'] = SHORT_NAME;
    }

    if (!$firstname) {
        $error['firstname'] = REQUIRED_FIELD;
    } else if (!preg_match('/^[a-zA-Z\s]+$/', $firstname)) {
        $error['firstname'] = INVALID_FIRSTNAME;
    } else if (mb_strlen($firstname) < 1) {
        $error['firstname'] = SHORT_FIRSTNAME;
    }

    if (!$email) {
        $error['email'] = REQUIRED_FIELD;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = INVALID_EMAIL;
    }
    if (!$level || $level === 'Default') {
        $error['level'] = REQUIRED_FIELD;
    }


    if (!$password) {
        $error['password'] = REQUIRED_FIELD;
    } else if (!preg_match('/^(?=.*\d)(?=.*[A-Z]).*$/', $password)) {
        $error['password'] = REGEX_PASSWORD;
    } else if (mb_strlen($password) < 8) {
        $error['password'] = SHORT_PASSWORD;
    }

    if (empty(array_filter($error, fn ($e) => $e !== ''))) {
        $etudiant = $authController->readEtudiants($email);
        $prof = $authController->readProfs($email);
        if ($etudiant || $prof) {
            $error['email'] = TAKEN_EMAIL;
        } else {
            $authController->registerEtudiants($name, $firstname, $email, $password, $level);
            header('Location: login.php');
        }
    }
}

?>

<body>

    <div class="login-container">
        <a href="/" style="position: absolute; top: 10px ; left: 10px; color: var(--black); text-decoration :none"><i class="fa-solid fa-arrow-left-long"></i> Accueil</a>
        <div class="image-container">
            <div class="text-container">
                <p style=>© 2023 Genius Gate</p>
            </div>
        </div>
        <form action="register-etudiant.php" method="post">
            <div class="log">
                <a href="/"><img src="/assets/images/logo.png" alt="" width="90px" height="80px"></a>
                <h2>Formulaire Etudiant</h2>
            </div>
            <div class="form-group">
                <div class="form-list">

                    <input type="text" name="name" id="name" placeholder="Veuillez entrer votre nom ici " value="<?= $name ?? '' ?>">
                    <label for="">Nom</label>
                    <?php if ($error['name']) : ?>
                        <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error['name'] ?> </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <div class="form-list">
                    <input type="text" name="firstname" id="firstname" placeholder="Veuillez entrer votre Prenom ici" value="<?= $firstname ?? '' ?>">
                    <label for="">Prenom</label>
                    <?php if ($error['firstname']) : ?>
                        <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error['firstname'] ?> </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <div class="form-list">
                    <select name="level" id="level">
                        <option value="Default" disabled <?= !$level || $level === 'Default' ? 'selected' : '' ?>>~~~ Veuillez choisir un niveau ~~~</option>
                        <option value="L1" <?= $level === 'L1' ? 'selected' : ''  ?>> L1</option>
                        <option value="L2" <?= $level === 'L2' ? 'selected' : ''  ?>> L2</option>
                        <option value="L3" <?= $level === 'L3' ? 'selected' : ''  ?>> L3</option>
                        <option value="M1" <?= $level === 'M1' ? 'selected' : ''  ?>> M1</option>
                        <option value="M2" <?= $level === 'M2' ? 'selected' : '' ?>> M2</option>
                    </select>
                    <?php if ($error['level']) : ?>
                        <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error['level'] ?> </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <div class="form-list">
                    <input type="text" name="email" id="email" placeholder="Veuillez entrer votre Email ici" value="<?= $email ?? '' ?>">
                    <label for="">Email</label>
                    <?php if ($error['email']) : ?>
                        <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error['email'] ?> </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group">
                <div class="form-list">
                    <input type="password" name="password" id="password" placeholder="Veuillez entrer votre mot de passe ici" value="<?= $password ?? '' ?>">
                    <label for="">Mot de passe</label>
                    <?php if ($error['password']) : ?>
                        <p class="error"><i class="fa-solid fa-circle-exclamation"></i><?= $error['password']  ?></p>
                    <?php endif ?>
                </div>
            </div>



            <div class="button-container">
                <button type="submit">S'inscrire</button>
            </div>
            <p style="width: 95%; display:flex ; justify-content:center; align-items:center ; color: var(--black) ; ">Vous avez deja un compte? <a href="/views/Authentification/login.php">Vous connecter</a></p>


        </form>
    </div>

</body>

</html>