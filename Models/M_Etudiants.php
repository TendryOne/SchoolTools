<?php

class Etudiants
{
    private $statementDeleteEtudiants;
    private $statementAccessGranted;

    function __construct(private PDO $pdo)
    {

        $this->statementDeleteEtudiants = $pdo->prepare(('DELETE FROM etudiants WHERE id_etudiant = :id_etudiant'));

        $this->statementAccessGranted = $pdo->prepare('UPDATE etudiants SET validated = "approved" WHERE id_etudiant = :id_etudiant ');
    }

    public function DeleteEtudiant($id_etudiant)
    {
        $this->statementDeleteEtudiants->bindValue(':id_etudiant', $id_etudiant);
        $this->statementDeleteEtudiants->execute();
    }
    public function AccessGrantedEtudiants($id_etudiant)
    {
        $this->statementAccessGranted->bindValue(':id_etudiant', $id_etudiant);
        $this->statementAccessGranted->execute();
    }
}
