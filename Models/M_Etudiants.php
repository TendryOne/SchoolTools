<?php

class Etudiants
{
    private $statementDeleteEtudiants;
    private $statementAccessGranted;
    private $statementReadEtudiantById;

    function __construct(private PDO $pdo)
    {

        $this->statementDeleteEtudiants = $pdo->prepare(('DELETE FROM etudiants WHERE id_etudiant = :id_etudiant'));

        $this->statementAccessGranted = $pdo->prepare('UPDATE etudiants SET validated = "approved" WHERE id_etudiant = :id_etudiant ');

        $this->statementReadEtudiantById = $pdo->prepare('SELECT * FROM etudiants WHERE id_etudiant = :id_etudiant');
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

    public function ReadEtudiantById($id_etudiant)
    {
        $this->statementReadEtudiantById->bindValue(':id_etudiant', $id_etudiant);
        $this->statementReadEtudiantById->execute();
        return $this->statementReadEtudiantById->fetch();
    }
}
