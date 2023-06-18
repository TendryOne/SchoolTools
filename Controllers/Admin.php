
<?php

class AuthAdmin
{
    private $AdminModel;

    function __construct(Admin $AdminModel)
    {
        $this->AdminModel = $AdminModel;
    }

    public function InsertAdmin($username, $email, $password, $role)
    {
        $password = password_hash($password, PASSWORD_ARGON2I);
        $this->AdminModel->InsertAdmin($username, $email, $password, $role);
    }

    public function ReadAdmin($username)
    {
        return $this->AdminModel->ReadAdmin($username);
    }
    public function LoginAdmin($id_sessions_admin, $id_admin, $signature)
    {
        $this->AdminModel->InsertSessionAdmin($id_sessions_admin, $id_admin);
        setcookie('sessionAdmin', $id_sessions_admin, time() + 60 * 60 * 24 * 14, '/', '', false, true);
        setcookie('signatureAdmin', $signature, time() + 60 * 60 * 24 * 14, '/', '', false, true);
    }
    public function LoggedAsAdmin()
    {
        $id_session = $_COOKIE['sessionAdmin'] ?? '';
        $signature = $_COOKIE['signatureAdmin'] ?? '';
        $session = $this->AdminModel->ReadSessionAdmin($id_session);

        if ($session) {
            $hash = hash_hmac('sha256', $id_session, 'GeniusGate');
            if (hash_equals($hash, $signature)) {
                $admin = $this->AdminModel->ReadAdminById($session['id_admin']);
            }
        }

        return $admin ?? false;
    }
    public function LogoutAdmin()
    {

        $id_session_admin = $_COOKIE['sessionAdmin'];
        $sessionAdmin = $this->AdminModel->ReadSessionAdmin($id_session_admin);
        if ($sessionAdmin) {
            $this->AdminModel->DeleteSession($id_session_admin);
            setcookie('sessionAdmin', '', time() - 1, '/', '', false, true);
            setcookie('signatureAdmin', '', time() - 1, '/', '', false, true);
        }
    }
}
