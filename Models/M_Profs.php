<?php

class Profs
{
    private $statementdeleteProfs;
    private $statementAccessGranted;
    private $statementCheckModuleConstraints;
    private $statementProfileUpload;


    function __construct(private PDO $pdo)
    {

        $this->statementdeleteProfs = $pdo->prepare('DELETE FROM profs WHERE id_prof = :id_prof');

        $this->statementAccessGranted = $pdo->prepare('UPDATE profs SET validated = "approved" WHERE id_prof = :id_prof ');

        $this->statementCheckModuleConstraints = $this->pdo->prepare('SELECT COUNT(*) FROM modules WHERE id_prof = :id_prof');

        $this->statementProfileUpload = $pdo->prepare('UPDATE profs SET ProfilePicture = :ProfilePicture WHERE id_prof = :id_prof');
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
    public function CheckModuleConstraints($id_prof)
    {
        $this->statementCheckModuleConstraints->bindValue(':id_prof', $id_prof);
        $this->statementCheckModuleConstraints->execute();
        return $this->statementCheckModuleConstraints->fetchColumn();
    }

    public function UploadProfile($profilePicture, $id_prof)
    {
        $this->statementProfileUpload->bindValue(':id_prof', $id_prof);
        $this->statementProfileUpload->bindValue(':ProfilePicture', $profilePicture);
        $this->statementProfileUpload->execute();
    }
}
