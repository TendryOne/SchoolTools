<div class="admin-dashboard">
    <?php $modules = $moduleController->ReadmoduleByIdProf($currentUserProf['id_prof']);
    ?>
    <ul>
        <?php foreach ($modules as $module) : ?>
            <li><a href="/views/Notes/List-etudiant.php?id_module=<?= $module['id_module'] ?>" class="<?= $_SERVER['REQUEST_URI'] === '/views/Notes/List-etudiant.php?id_module=' . $module['id_module'] ? 'active' : '' ?>"><?= $module['id_module'] ?> </a></li>
        <?php endforeach ?>
    </ul>
    <div class="copyright">
        <p><i class="fa-solid fa-shield-halved"></i> Professeur </p>
        <p>© All reserved | GeniusGate </p>
    </div>
</div>