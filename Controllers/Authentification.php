<?php
class AuthController
{
    private $ProfsModel;
    private $EtudiantsModel;

    function __construct(ProfsModel $profsModel, EtudiantsModel $EtudiantsModel)
    {
        $this->ProfsModel = $profsModel;
        $this->EtudiantsModel = $EtudiantsModel;
    }

    public function registerProfs($name, $firstname, $email, $password)
    {
        $password = password_hash($password, PASSWORD_ARGON2I);
        $this->ProfsModel->InsertProf($name, $firstname, $email, $password);
    }
    public function registerEtudiants($name, $firstname, $email, $password)
    {
        $password = password_hash($password, PASSWORD_ARGON2I);
        $this->EtudiantsModel->InsertEtudiants($name, $firstname, $email, $password);
    }
    public function readEtudiants($email)
    {
        return $this->EtudiantsModel->ReadEtudiants($email);
    }
    public function LoginEtudiants($id_session, $id_etudiants)
    {
        $this->EtudiantsModel->InsertSessionEtudiants($id_session, $id_etudiants);
        setcookie('session', $id_session, time() + 60 * 60 * 24 * 14, '', '', false, true);
    }
}
