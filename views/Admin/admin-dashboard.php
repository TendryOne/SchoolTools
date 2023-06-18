<div class="admin-dashboard">
    <ul>

        <li><a href="/views/Admin/User-etudiants.php" class="<?= $_SERVER['REQUEST_URI'] === '/views/Admin/User-etudiants.php' ? 'active' : '' ?>">Liste des Etudiants</a></li>
        <li><a href="/views/Admin/User-profs.php" class="<?= $_SERVER['REQUEST_URI'] === '/views/Admin/User-profs.php' ? 'active' : '' ?>">Liste des Profs</a></li>
        <li><a href="/views/Admin/Ajout-emploi-du-temps.php" class="<?= $_SERVER['REQUEST_URI'] === '/views/Admin/Ajout-emploi-du-temps.php' ? 'active' : '' ?>">Ajout d'emploi du temps</a></li>
        <li><a href="/views/Admin/emploi-du-temps.php" class="<?= $_SERVER['REQUEST_URI'] === '/views/Admin/emploi-du-temps.php' ? 'active' : '' ?>">emploi du temps</a></li>
        <li><a href="/views/Admin/Ajout-module.php" class="<?= $_SERVER['REQUEST_URI'] === '/views/Admin/Ajout-module.php' ? 'active' : '' ?>">Ajout module</a></li>
        <li><a href="/views/Admin/module-list.php" class="<?= $_SERVER['REQUEST_URI'] === '/views/Admin/module-list.php' ? 'active' : '' ?>">Liste des modules</a></li>

    </ul>
    <div class="copyright">
        <p><i class="fa-solid fa-shield-halved"></i> Admin Dashboard </p>
        <p>© All reserved | GeniusGate </p>
    </div>
</div>