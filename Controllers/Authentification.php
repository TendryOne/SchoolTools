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
    ///// Profs //////

    public function registerProfs($name, $firstname, $email, $password)
    {
        $password = password_hash($password, PASSWORD_ARGON2I);
        $this->ProfsModel->InsertProf($name, $firstname, $email, $password);
    }
    public function readProfs($email)
    {
        return $this->ProfsModel->readProfs($email);
    }


    public function LoginProfs($id_session, $id_profs, $signature)
    {
        $this->ProfsModel->InsertSessionProfs($id_session, $id_profs);
        setcookie('signature', $signature, time() + 60 * 60 * 24 * 14, '/', '', false, true);
        setcookie('session', $id_session, time() + 60 * 60 * 24 * 14, '/', '', false, true);
    }

    public function readProfsAll()
    {
        return $this->ProfsModel->ReadAllProfs();
    }

    /// etudiants ////




    public function registerEtudiants($name, $firstname, $email, $password)
    {
        $password = password_hash($password, PASSWORD_ARGON2I);
        $this->EtudiantsModel->InsertEtudiants($name, $firstname, $email, $password);
    }
    public function readEtudiants($email)
    {
        return $this->EtudiantsModel->ReadEtudiants($email);
    }
    public function LoginEtudiants($id_session, $id_etudiants, $signature)
    {
        $this->EtudiantsModel->InsertSessionEtudiants($id_session, $id_etudiants);
        setcookie('signature', $signature, time() + 60 * 60 * 24 * 14, '/', '', false, true);
        setcookie('session', $id_session, time() + 60 * 60 * 24 * 14, '/', '', false, true);
    }
    public function readEtudiantsAll()
    {
        return $this->EtudiantsModel->ReadAllEtudiants();
    }



    public function isLoggedAsEtudiant(): array | false
    {
        $sessionId = $_COOKIE['session'] ?? '';
        $signature = $_COOKIE['signature'] ?? '';


        if ($sessionId && $signature) {
            $hash = hash_hmac('sha256', $sessionId, 'GeniusGate');
            if (hash_equals($hash, $signature)) {
                $session = $this->EtudiantsModel->ReadSessionEtudiants($sessionId);

                if ($session) {
                    $etudiant = $this->EtudiantsModel->ReadEtudiantsbyId($session['id_etudiant']);
                }
            }
        }

        return $etudiant ?? false;
    }

    public function isLoggedAsProf(): array | false
    {
        $sessionId = $_COOKIE['session'] ?? '';
        $signature = $_COOKIE['signature'] ?? '';


        if ($sessionId && $signature) {
            $hash = hash_hmac('sha256', $sessionId, 'GeniusGate');
            if (hash_equals($hash, $signature)) {
                $session = $this->ProfsModel->ReadSessionProfs($sessionId);

                if ($session) {
                    $prof = $this->ProfsModel->ReadProfsbyId($session['id_prof']);
                }
            }
        }

        return $prof ?? false;
    }
    public function logoutEtudiant()
    {
        $id_session_etudiant = $_COOKIE['session'];
        $this->EtudiantsModel->DeleteSession($id_session_etudiant);
        setcookie('session', '', time() - 1, '/', '', false, true);
        setcookie('signature', '', time() - 1, '/', '', false, true);
    }
    public function logoutProf()
    {
    }
}
