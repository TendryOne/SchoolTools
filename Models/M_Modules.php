<?php
class moduleModel
{
    private $statementInsertmodule;
    private $statementReadmodule;
    private $statementReadmoduleById;
    private $statemetReadModuleAndProf;

    function __construct(private PDO $pdo)
    {
        $this->statementInsertmodule = $pdo->prepare('INSERT INTO module VALUES (
            :id_module,
            :nom,
            :id_prof
        )');

        $this->statementReadmodule = $pdo->prepare('SELECT * FROM module');

        $this->statementReadmoduleById = $pdo->prepare('SELECT * FROM module WHERE id_module = :id_module');

        $this->statemetReadModuleAndProf = $pdo->prepare('SELECT m.nom , p.name , p.firstname , m.id_module FROM module m JOIN profs p ON m.id_prof = p.id_prof');
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
        $this->statemetReadModuleAndProf->execute();
        return $this->statemetReadModuleAndProf->fetchAll();
    }
}
