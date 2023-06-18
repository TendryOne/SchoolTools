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
    <title>GeniusGate</title>
</head>

<body>


    <?php
    $pdo = require_once __DIR__ . '/Models/Database.php';
    require __DIR__ . '/Controllers/Authentification.php';
    require __DIR__ . '/Models/M_Authentification.php';
    require __DIR__ . "/Controllers/Admin.php";


    $AdminModels = new Admin($pdo);
    $authAdmin = new AuthAdmin($AdminModels);
    $profsModels = new ProfsModel($pdo);
    $etudiantsModels = new EtudiantsModel($pdo);
    $AuthDB = new AuthController($profsModels, $etudiantsModels);
    $currentUserEtudiant = $AuthDB->isLoggedAsEtudiant();
    $currentUserAdmin = $authAdmin->LoggedAsAdmin();
    $currentUserProf = $AuthDB->isLoggedAsProf();
    $etudiants = $AuthDB->readEtudiantsAll();
    $Profs = $AuthDB->readProfsAll();


    // include('404.php');
    // exit();
    http_response_code(200);
    if (http_response_code() > 200) {
        http_response_code(404);
        include('404.php');
        exit();
    }
    ?>
    <div class="nav-container">
        <?php require_once './views/header.php' ?>
        <div class="slogan">
            <h2 style=" color:white;"><i class="fa-solid fa-quote-left fa-fade" style="font-size: 50px; color:white;"></i> Des professeurs engagés, des étudiants inspirés - ensemble, nous grandissons <i class="fa-sharp fa-solid fa-quote-right fa-fade" style="font-size: 50px;  color:white;"></i></h2>
            <a href="/views//Authentification/Choice.php">Nous rejoindre <i class="fa-sharp fa-solid fa-graduation-cap"></i></a>
        </div>


    </div>
    <section>
        <div class="community-container">

            <div class="community">
                <div class="card">
                    <span><i class="fa-solid fa-user-tie" style="font-size: 100px; color:var(--black);"></i>
                        <p>Professeurs</p>
                    </span>
                    <span class="sideback"><i class="fa-solid fa-user" style="margin: 20px;font-size: 30px;"></i><em style="color: var(--secondary-bg);"><?= count($Profs) ?? '0' ?></em> Professeur(s) deja inscrit</span>
                </div>
                <div class="card">
                    <span> <i class="fa-solid fa-user-graduate" style="font-size: 100px;  color:var(--black);"></i>
                        <p>Etudiants</p>
                    </span>
                    <span class="sideback"><i class="fa-solid fa-user" style="margin: 20px;font-size: 30px;"></i> <em style="color: var(--secondary-bg);"><?= count($etudiants) ?? '0' ?></em>Etudiant(s) deja inscrit</span>
                </div>

                <div class="card">
                    <span><i class="fa-solid fa-school" style="font-size: 100px;  color:var(--black);"></i>
                        <p>Universite</p>
                    </span>
                    <span class="sideback"><i class="fa-solid fa-user" style="margin: 20px;font-size: 30px;"></i><em style="color: var(--secondary-bg);">2</em> Universite nous ont fait confiance</span>
                </div>
            </div>


        </div>

        <div class="container" id="container">
            <div class="section1">
                <div class="image-container"></div>
                <p style="color: black;">🙶 Ouvrez les portes du génie avec l'éducation 🙸</p>
            </div>
            <div class="section2">
                <p>Rejoignez la communauté Genius Gate et élevez vos compétences à de nouveaux sommets, là où la passion de l'apprentissage rencontre la connexion entre enseignants et étudiants.</p>

                <div class="join-container">
                    <a href="">Nous Rejoindre <i class="fa-sharp fa-solid fa-graduation-cap"></i></a>
                    <a href="">En savoir plus ... </a>
                </div>

            </div>
        </div>
        <div class="about-container">
            <div class="about1">
                <i class="fa-regular fa-note-sticky" style="font-size: 50px;"></i>
                <span style="margin-bottom: 50px;">Partage des notes</span>
                <p>Simplifiez le partage des notes avec notre plateforme éducative, permettant aux professeurs de partager facilement les résultats des évaluations avec les étudiants, favorisant ainsi une transparence académique et un suivi régulier de la progression</p>
            </div>
            <div class="about2">
                <i class="fa-regular fa-calendar-days" style="font-size: 50px;"></i>
                <span style="margin-bottom: 50px;">Emploi du temps</span>
                <p>Gagnez du temps précieux grâce à notre emploi du temps simplifié et intuitif, vous permettant d'organiser facilement vos activités et de maximiser votre productivité</p>
            </div>
            <div class="about3">
                <i class="fa-solid fa-people-group" style="font-size: 50px; "></i>
                <span style="margin-bottom: 50px;">Proximite Prof-Etudiants</span>
                <p>Renforcez la proximité entre professeurs et étudiants grâce à notre plateforme dédiée, offrant la possibilité aux enseignants d'envoyer facilement les notes, l'emploi du temps et les exercices aux étudiants, favorisant ainsi une communication fluide et une collaboration efficace</p>
            </div>
        </div>

    </section>

    <?php require_once './views/footer.php' ?>

    <script src="/assets/js/script.js"></script>
</body>


</html>