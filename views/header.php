<nav>

    <?php
    $currentUserEtudiant = $currentUserEtudiant ?? false;
    $currentUserProf = $currentUserProf ?? false;
    $currentUserAdmin = $currentUserAdmin ?? false;

    ?>

    <div class="logo">
        <a href="/"><img src="/assets//images//logo.png" alt="" width="90px" height="80px"></a>
        <!-- <h1>GeniusGate</h1> -->

    </div>

    <?php if (!$currentUserEtudiant && !$currentUserProf && !$currentUserAdmin) : ?>
        <ul class="nav-content">
            <li><a href="/">Accueil</a></li>
            <li><a href="#container">A propos</a></li>
            <li><a href="#">Qui nous sommes?</a></li>
        </ul>
    <?php elseif ($currentUserEtudiant) : ?>
        <div style="display: flex; flex-direction:column ;color:white;">
            <h2>Bienvenue<span style="color: var(--secondary-bg);"> <?= $currentUserEtudiant['firstname'] ?></span></h2>
        </div>
    <?php elseif ($currentUserProf) : ?>
        <div style="display: flex; flex-direction:column ;color:white;">
            <h2>Bienvenue Professeur<span style="color: var(--secondary-bg);"> <?= $currentUserProf['firstname'] ?></span></h2>
        </div>
    <?php elseif ($currentUserAdmin) : ?>
        <div style="display: flex; flex-direction:column ;color:white;">
            <h2>Bienvenue <span style="color: var(--secondary-bg);"> <?= $currentUserAdmin['username'] ?></span></h2>
        </div>
    <?php endif; ?>



    <ul class="nav-connexion-container">
        <?php if (!$currentUserEtudiant && !$currentUserProf && !$currentUserAdmin) : ?>
            <li><a href="/views/Admin/admin-login.php">Admin <i class="fa-solid fa-shield-halved"></i></a></li>
            <li><a class="join" href="/views/Authentification/login.php"> Se connecter <i class="fa-solid fa-right-to-bracket"></i> </a></li>
        <?php endif; ?>

        <?php if ($currentUserEtudiant) : ?>
            <div class="nav-prof">
                <li class="profile" style="background-image:url('<?= $currentUserEtudiant['ProfilePicture'] ?>')"><?= $currentUserEtudiant['ProfilePicture'] ? '' : '<i class="fa-solid fa-user-graduate" style="color: white;"></i>' ?> <?= $currentUserEtudiant['ProfilePicture'] ? '' : $currentUserEtudiant['firstname'][0] . ' ' . $currentUserEtudiant['name'][0] ?></li>
                <ul class="dropdown-profile">
                    <li>Statut : <span style="color: var(--secondary-bg); margin-left:10px"> Etudiant</span></li>
                    <li><a href="/views/Etudiants/profile.php">Parametres <i class="fa-solid fa-gear"></i></a></li>
                    <li><a href="/views/EmploiDuTemps/emploiDutemps-Etudiant.php">Mon emploi du temps <i class="fa-solid fa-timeline"></i></a></li>
                    <li><a href="/views/Notes/note-etudiant.php">Ma note <i class="fa-solid fa-award"></i></a></li>
                    <li><a href="/views//Authentification/logout.php">Deconnexion <i class="fa-solid fa-right-from-bracket"></i></a></li>

                </ul>
            </div>
        <?php endif; ?>

        <?php if ($currentUserProf) : ?>
            <div class="nav-prof">
                <li class="profile" style="background-image:url('<?= $currentUserProf['ProfilePicture'] ?>');"><?= $currentUserProf['ProfilePicture'] ? '' : '<i class="fa-solid fa-user-tie" style="color: white; "></i>' ?> <?= !$currentUserProf['ProfilePicture'] ? $currentUserProf['firstname'][0] . ' ' . $currentUserProf['name'][0] : '' ?></li>
                <ul class="dropdown-profile">
                    <li>Statut : <span style="color: var(--secondary-bg); margin-left:10px"> Professeur </span></li>
                    <li><a href="/views/Profs/profile.php">Parametres <i class="fa-solid fa-gear"></i></a></li>
                    <li><a href="/views/EmploiDuTemps/emploiDuTemps-List.php">Mon emploi du temps <i class="fa-solid fa-timeline"></i></a></li>
                    <li><a href="/views/Notes/formCreate.php">Note des eleves <i class="fa-solid fa-award"></i></a></li>
                    <li><a href="/views//Authentification/logout.php">Deconnexion <i class="fa-solid fa-right-from-bracket"></i></a></li>

                </ul>
            </div>
        <?php endif; ?>
        <?php if ($currentUserAdmin) : ?>
            <div class="nav-prof">
                <li class="profile"><i class="fa-solid fa-user-shield" style="color: white;"></i> <?= $currentUserAdmin['username'][0] ?></li>
                <ul class="dropdown-profile">
                    <li>Statut : <span style="color: var(--secondary-bg); margin-left:10px"> Super Admin <i class="fa-solid fa-shield-halved"></i></span></li>
                    <li><a href="/views/Admin/User-etudiants.php">Mes etudiants <i class="fa-solid fa-award"></i></a></li>
                    <li><a href="/views/Admin/User-etudiants.php">Gerer <i class="fa-solid fa-timeline"></i></a></li>
                    <li><a href="/views/Admin/User-profs.php">Mes profs <i class="fa-solid fa-award"></i></a></li>
                    <li><a href="/views/Admin/logout.php">Deconnexion <i class="fa-solid fa-right-from-bracket"></i></a></li>

                </ul>
            </div>
        <?php endif; ?>

    </ul>
</nav>