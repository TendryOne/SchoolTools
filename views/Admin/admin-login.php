<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style-login.css">
    <link rel="shortcut icon" href="/assets/images/logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/fontawesome-free-6.4.0-web/css/all.min.css">
    <title>Admin | GeniusGate</title>
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

const REQUIRED_FIELD = "Veuillez remplir ce champ";


$error = [
    'username' => '',
    'password' => ''
];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = filter_input_array(INPUT_POST, [
        'username' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
    ]);

    $username = $input['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$username) {
        $error['username'] = REQUIRED_FIELD;
    }

    if (!$password) {
        $error['password'] = REQUIRED_FIELD;
    }


    if (empty(array_filter($error, fn ($e) => $e !== ''))) {
        $admin = $authAdmin->ReadAdmin($username);
        if ($admin) {
            if (password_verify($password, $admin['password'])) {
                $id_sessionAdmin = bin2hex(random_bytes(32));
                $signature = hash_hmac('sha256', $id_sessionAdmin, 'GeniusGate');
                $authAdmin->LoginAdmin($id_sessionAdmin, $admin['id_admin'], $signature);
                header("Location: /");
            } else {
                $error['password'] = 'Votre mot de passe ou nom d\'utilisateur n\' est pas valide';
            }
        } else {
            $error['password'] = "Cette utilisateur n'est pas un admin ";
        }
    }
}


?>

<body>

    <div class="login-container">
        <a href="/" style="position: absolute; top: 10px ; left: 10px; color: var(--black); text-decoration :none"><i class="fa-solid fa-arrow-left-long"></i> Accueil</a>
        <form action="admin-login.php" method="post">
            <div class="log">
                <h2>Admin <i class="fa-solid fa-shield-halved"></i></h2>
            </div>
            <div class="form-group">
                <div class="form-list">
                    <label for="username"><i class="fa-solid fa-user"></i></label>
                    <input type="text" name="username" id="username" placeholder="Votre Pseudo" value="<?= $username ?? '' ?>">

                </div>
                <?php if ($error['username']) : ?>
                    <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error['username'] ?> </p>
                <?php endif ?>
            </div>
            <div class="form-group">
                <div class="form-list">
                    <label for="password"><i class="fa-solid fa-lock"></i></label>
                    <input type="password" name="password" id="password" placeholder="Votre mot de passe">

                </div>
                <?php if ($error['password']) : ?>
                    <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error['password'] ?> </p>
                <?php endif ?>
            </div>


            <div class="button-container">
                <button type="submit">Se connecter</button>
            </div>
        </form>
        <!-- <div class="image-container">
            <div class="text-container">
                <p style=>© 2023 Genius Gate</p>
            </div>
        </div> -->
    </div>

</body>

</html>