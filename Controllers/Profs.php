<?php

class ProfController
{
    private $prof;

    function __construct(Profs $prof)
    {
        $this->prof = $prof;
    }

    public function DeleteProf($id_prof)
    {

        return $this->prof->DeleteProf($id_prof);
    }

    public function AccessGrantedProfs($id_prof)
    {
        return $this->prof->AccessGrantedProfs($id_prof);
    }
    public function CheckModuleConstraints($id_prof)
    {
        return $this->prof->CheckModuleConstraints($id_prof);
    }
}
