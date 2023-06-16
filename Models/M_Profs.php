<?php

class Profs
{
    private $statementdeleteProfs;
    private $statementAccessGranted;

    function __construct(private PDO $pdo)
    {

        $this->statementdeleteProfs = $pdo->prepare('DELETE FROM profs WHERE id_prof = :id_prof');

        $this->statementAccessGranted = $pdo->prepare('UPDATE profs SET validated = "approved" WHERE id_prof = :id_prof ');
    }

    public function DeleteProf($id_prof)
    {
        $this->statementdeleteProfs->bindValue(':id_prof', $id_prof);
        $this->statementdeleteProfs->execute();
    }
    public function AccessGrantedProfs($id_prof)
    {
        $this->statementAccessGranted->bindValue(':id_prof', $id_prof);
        $this->statementAccessGranted->execute();
    }
}
