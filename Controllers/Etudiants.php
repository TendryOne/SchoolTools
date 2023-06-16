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
}
