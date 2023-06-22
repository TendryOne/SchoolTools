<?php

class EtudiantController
{
    private $etudiant;

    function __construct(Etudiants $etudiant)
    {
        $this->etudiant = $etudiant;
    }

    public function DeleteEtudiant($id_etudiant)
    {
        return $this->etudiant->DeleteEtudiant($id_etudiant);
    }
    public function AccessGrantedEtudiants($id_etudiant)
    {
        return $this->etudiant->AccessGrantedEtudiants($id_etudiant);
    }
    public function ReadEtudiantById($id_etudiant)
    {
        return $this->etudiant->ReadEtudiantById($id_etudiant);
    }
    public function UploadProfile($profilePicture, $id_etudiant)
    {
        $this->etudiant->UploadProfile($profilePicture, $id_etudiant);
    }
}
