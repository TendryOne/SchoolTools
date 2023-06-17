<?php

class moduleController
{
    private $moduleModels;

    function __construct(moduleModel $moduleModels)
    {
        $this->moduleModels = $moduleModels;
    }

    public function insertmodule($id_module, $nom, $id_prof)
    {
        return $this->moduleModels->insertmodule($id_module, $nom, $id_prof);
    }
    public function readmodule()
    {
        return $this->moduleModels->readmodule();
    }
    public function readmodulebyId($id_module)
    {
        return $this->moduleModels->readmodulebyId($id_module);
    }
    public function ReadmoduleAndProfs()
    {

        return $this->moduleModels->ReadmoduleAndProfs();
    }
}
