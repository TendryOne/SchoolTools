<?php

class emploiDuTempsController
{
    private $emploidutempsModels;

    function __construct(emploiDuTempsModel $emploidutempsModels)
    {
        $this->emploidutempsModels = $emploidutempsModels;
    }

    public function insertEdt($id_module, $jour, $heure_debut, $heure_fin, $salle)
    {
        return $this->emploidutempsModels->insertEdt($id_module, $jour, $heure_debut, $heure_fin, $salle);
    }
    public function readEdt()
    {
        return $this->emploidutempsModels->readEdt();
    }

    public function readEdtById($id_emploi)
    {
        return $this->emploidutempsModels->readEdtById($id_emploi);
    }
    public function UpdateEdt($id_emploi, $id_module, $jour, $heure_debut, $heure_fin, $salle)
    {
        return $this->emploidutempsModels->UpdateEdt($id_emploi, $id_module, $jour, $heure_debut, $heure_fin, $salle);
    }
    public function DeleteEdt($id_emploi)
    {
        $this->emploidutempsModels->DeleteEdt($id_emploi);
    }
    public function ReadEdtByidModule($id_module)
    {
        return $this->emploidutempsModels->ReadEdtByidModule($id_module);
    }
    public function GetProfEdt($id_prof)
    {
        return $this->emploidutempsModels->GetProfEdt($id_prof);
    }
    public function AutoDeleteEvent($date)
    {
        $this->emploidutempsModels->AutoDeleteEvent($date);
    }
}
