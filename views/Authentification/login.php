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
    <title>Login | GeniusGate</title>
</head>
<?php
$pdo = require_once __DIR__ . '/../../Models/Database.php';
require __DIR__ . '/../../Controllers/Authentification.php';
require __DIR__ . '/../../Models/M_Authentification.php';

$profsModel = new ProfsModel($pdo);
$EtudiantsModel = new EtudiantsModel($pdo);
$authController = new AuthController($profsModel, $EtudiantsModel);

const REQUIRED_FIELD = "Veuillez remplir ce champ";


$error = [
    'email' => '',
    'password' => ''
];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = filter_input_array(INPUT_POST, [
        'email' => FILTER_SANITIZE_EMAIL
    ]);

    $email = $input['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$email) {
        $error['email'] = REQUIRED_FIELD;
    }

    if (!$password) {
        $error['password'] = REQUIRED_FIELD;
    }


    if (empty(array_filter($error, fn ($e) => $e !== ''))) {
        $etudiant = $authController->readEtudiants($email);

        if ($etudiant) {
            if (password_verify($password, $etudiant['password'])) {
                $id_session = bin2hex(random_bytes(32));
                $signature = hash_hmac('sha256', $id_session, 'GeniusGate');
                $authController->LoginEtudiants($id_session, $etudiant['id_etudiant'], $signature);
                header('Location: /');
            } else {
                $error['password'] = 'le nom d\'utilisateur ou le mot de passe est incorrect , Vous etes un etudiant';
            }
        } else {
            $error['password'] = 'l\' utilisateur que vous avez entrer n\'existe pas';
        }
    }
}


?>

<body>

    <div class="login-container">
        <a href="/" style="position: absolute; top: 10px ; left: 10px; color: var(--black); text-decoration :none"><i class="fa-solid fa-arrow-left-long"></i> Accueil</a>
        <form action="login.php" method="post">
            <div class="log">
                <a href="/"><img src="/assets/images/logo.png" alt="" width="90px" height="80px"></a>
                <h2>Connexion</h2>
            </div>
            <div class="form-group">
                <div class="form-list">
                    <label for="email"><i class="fa-solid fa-user"></i></label>
                    <input type="text" name="email" id="email" placeholder="Votre email" value="<?= $email ?? '' ?>">
                </div>
                <?php if ($error['email']) : ?>
                    <p class="error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error['email'] ?> </p>
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
            <a style="width: 95%; display:flex ; justify-content:center; margin-top: 20px;" href="">mot de passe oublie?</a>
            <p style="width: 95%; display:flex ; justify-content:center; align-items:center ; color: var(--black) ; ">Vous n'avez pas de compte? <a href="/views/Authentification/Register.php">Creer un compte</a></p>


        </form>
        <div class="image-container">
            <div class="text-container">
                <p style=>© 2023 Genius Gate</p>
            </div>
        </div>
    </div>

</body>

</html>