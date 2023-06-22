<?php
class moduleModel
{
    private $statementInsertmodule;
    private $statementReadmodule;
    private $statementReadmoduleById;
    private $statementReadModuleAndProf;
    private $statementUpdateModule;
    private $statementReadmoduleByIdProf;
    private $statementDeleteModule;
    private $statementCheckConstraints;

    function __construct(private PDO $pdo)
    {
        $this->statementInsertmodule = $pdo->prepare('INSERT INTO modules VALUES (
            :id_module,
            :nom,
            :id_prof
        )');

        $this->statementReadmodule = $pdo->prepare('SELECT * FROM modules');

        $this->statementReadmoduleById = $pdo->prepare('SELECT * FROM modules WHERE id_module = :id_module');

        $this->statementReadModuleAndProf = $pdo->prepare('SELECT m.nom , p.name , p.firstname , m.id_module, m.id_prof FROM modules m JOIN profs p ON m.id_prof = p.id_prof');

        $this->statementReadmoduleByIdProf = $pdo->prepare('SELECT * FROM modules WHERE id_prof = :id_prof');

        $this->statementUpdateModule = $pdo->prepare('UPDATE modules SET 
            nom = :nom,
            id_prof = :id_prof
            WHERE id_module = :id_module
        ');

        $this->statementDeleteModule = $pdo->prepare('DELETE FROM modules WHERE id_module = :id_module');

        $this->statementCheckConstraints = $pdo->prepare('SELECT count(*) FROM emploi_du_temps e LEFT JOIN modules m ON e.id_module = m.id_module WHERE e.id_module = :id_module AND (m.id_prof IS NULL OR m.id_prof = :id_prof)');
    }

    public function insertmodule($id_module, $nom, $id_prof)
    {
        $this->statementInsertmodule->bindValue(':id_module', $id_module);
        $this->statementInsertmodule->bindValue(':nom', $nom);
        $this->statementInsertmodule->bindValue(':id_prof', $id_prof);
        $this->statementInsertmodule->execute();
    }
    public function readmodule()
    {
        $this->statementReadmodule->execute();
        return $this->statementReadmodule->fetchAll();
    }
    public function readmodulebyId($id_module)
    {
        $this->statementReadmoduleById->bindValue(':id_module', $id_module);
        $this->statementReadmoduleById->execute();
        return $this->statementReadmoduleById->fetch();
    }

    public function ReadmoduleAndProfs()
    {
        $this->statementReadModuleAndProf->execute();
        return $this->statementReadModuleAndProf->fetchAll();
    }

    public function UpdateModule($id_module, $nom, $id_prof)
    {
        $this->statementUpdateModule->bindValue(':nom', $nom);
        $this->statementUpdateModule->bindValue(':id_prof', $id_prof);
        $this->statementUpdateModule->bindValue(':id_module', $id_module);
        $this->statementUpdateModule->execute();
    }
    public function ReadmoduleByIdProf($id_prof)
    {
        $this->statementReadmoduleByIdProf->bindValue(':id_prof', $id_prof);
        $this->statementReadmoduleByIdProf->execute();
        return $this->statementReadmoduleByIdProf->fetchAll();
    }

    public function DeleteModule($id_module)
    {
        $this->statementDeleteModule->bindValue(':id_module', $id_module);
        $this->statementDeleteModule->execute();
    }

    public function checkConstraints($id_module, $id_prof)
    {
        $this->statementCheckConstraints->bindValue(':id_module', $id_module);
        $this->statementCheckConstraints->bindValue(':id_prof', $id_prof);
        $this->statementCheckConstraints->execute();
        return $this->statementCheckConstraints->fetchColumn();
    }
}
