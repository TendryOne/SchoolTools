<?php


class EtudiantsModel
{
    private $statementSessionInsert;
    private $statementSessionRead;
    private $statementEtudiantInsert;
    private $statementEtudiantRead;
    private $statementEtudiantReadAll;
    private $statementEtudiantReadbyId;
    private $statementDeleteSession;

    function __construct(private $pdo)
    {

        $this->statementEtudiantInsert = $pdo->prepare('INSERT INTO etudiants VALUES(
            DEFAULT,
            :name,
            :firstname,
            :email,
            :password,
            "pending",
            :level,
            DEFAULT
                )');

        $this->statementEtudiantRead = $pdo->prepare('SELECT * FROM etudiants WHERE email=:email');

        $this->statementEtudiantReadbyId = $pdo->prepare('SELECT * FROM etudiants WHERE id_etudiant = :id_etudiant');

        $this->statementSessionInsert = $pdo->prepare('INSERT INTO sessions_etudiants VALUES(
            :id_session,
            :id_etudiants
        )');

        $this->statementEtudiantReadAll = $pdo->prepare('SELECT * FROM etudiants');

        $this->statementSessionRead = $pdo->prepare('SELECT * FROM sessions_etudiants WHERE id_session_etudiant = :id_session_etudiant ');

        $this->statementDeleteSession = $pdo->prepare('DELETE  FROM sessions_etudiants WHERE id_session_etudiant = :id_session_etudiant');
    }

    public function InsertEtudiants($name, $firstname, $email, $password, $level)
    {
        $this->statementEtudiantInsert->bindValue(':name', $name);
        $this->statementEtudiantInsert->bindValue(':firstname', $firstname);
        $this->statementEtudiantInsert->bindValue(':email', $email);
        $this->statementEtudiantInsert->bindValue(':password', $password);
        $this->statementEtudiantInsert->bindValue(':level', $level);
        $this->statementEtudiantInsert->execute();
    }
    public function ReadEtudiants($email)
    {
        $this->statementEtudiantRead->bindValue(':email', $email);
        $this->statementEtudiantRead->execute();
        return $this->statementEtudiantRead->fetch();
    }

    public function InsertSessionEtudiants($id_session, $id_etudiants)
    {
        $this->statementSessionInsert->bindValue(':id_session', $id_session);
        $this->statementSessionInsert->bindValue(':id_etudiants', $id_etudiants);
        $this->statementSessionInsert->execute();
    }

    public function ReadSessionEtudiants($id_session_etudiant)
    {
        $this->statementSessionRead->bindValue(':id_session_etudiant', $id_session_etudiant);
        $this->statementSessionRead->execute();
        return $this->statementSessionRead->fetch();
    }

    public function ReadAllEtudiants()
    {
        $this->statementEtudiantReadAll->execute();
        return $this->statementEtudiantReadAll->fetchAll();
    }
    public function ReadEtudiantsbyId($id_etudiant)
    {
        $this->statementEtudiantReadbyId->bindValue(':id_etudiant', $id_etudiant);
        $this->statementEtudiantReadbyId->execute();
        return $this->statementEtudiantReadbyId->fetch();
    }

    public function DeleteSession($id_session_etudiant)
    {
        $this->statementDeleteSession->bindValue(':id_session_etudiant', $id_session_etudiant);
        $this->statementDeleteSession->execute();
    }
}
class ProfsModel
{

    private $statementProfsInsert;
    private $statementProfsRead;
    private $statementSessionInsert;
    private $statementProfsReadAll;
    private $statementSessionRead;
    private $statementProfsReadbyId;
    private $statementDeleteSession;


    function __construct(private $pdo)
    {

        $this->statementProfsInsert = $pdo->prepare('INSERT INTO profs VALUES(
            DEFAULT,
            :name,
            :firstname,
            :email,
            :password,
            "pending",
            DEFAULT
                )');
        $this->statementProfsRead = $pdo->prepare('SELECT * FROM profs WHERE email=:email');

        $this->statementSessionInsert = $pdo->prepare('INSERT INTO sessions_profs VALUES(
            :id_session,
            :id_profs
        )');

        $this->statementSessionRead = $pdo->prepare('SELECT * FROM sessions_profs WHERE id_session_prof = :id_session_prof');

        $this->statementProfsReadbyId = $pdo->prepare('SELECT * FROM profs WHERE id_prof = :id_prof');

        $this->statementProfsReadAll = $pdo->prepare('SELECT * FROM profs ');

        $this->statementDeleteSession = $pdo->prepare('DELETE FROM sessions_profs WHERE id_session_prof = :id_session_prof');
    }

    public function InsertProf($name, $firstname, $email, $password)
    {
        $this->statementProfsInsert->bindValue(':name', $name);
        $this->statementProfsInsert->bindValue(':firstname', $firstname);
        $this->statementProfsInsert->bindValue(':email', $email);
        $this->statementProfsInsert->bindValue(':password', $password);
        $this->statementProfsInsert->execute();
    }

    public function ReadProfs($email)
    {
        $this->statementProfsRead->bindValue(':email', $email);
        $this->statementProfsRead->execute();
        return $this->statementProfsRead->fetch();
    }

    public function InsertSessionProfs($id_session, $id_profs)
    {
        $this->statementSessionInsert->bindValue(':id_session', $id_session);
        $this->statementSessionInsert->bindValue(':id_profs', $id_profs);
        $this->statementSessionInsert->execute();
    }
    public function ReadSessionProfs($id_session_prof)
    {
        $this->statementSessionRead->bindValue(':id_session_prof', $id_session_prof);
        $this->statementSessionRead->execute();
        return $this->statementSessionRead->fetch();
    }

    public function ReadAllProfs()
    {
        $this->statementProfsReadAll->execute();
        return $this->statementProfsReadAll->fetchAll();
    }
    public function ReadProfsbyId($id_prof)
    {
        $this->statementProfsReadbyId->bindValue(':id_prof', $id_prof);
        $this->statementProfsReadbyId->execute();
        return $this->statementProfsReadbyId->fetch();
    }
    public function DeleteSession($id_session_prof)
    {
        $this->statementDeleteSession->bindValue(':id_session_prof', $id_session_prof);
        $this->statementDeleteSession->execute();
    }
}

/// Admin
class Admin
{
    private $statementInsertAdmin;
    private $statementInsertSession;
    private $statementDeleteSession;
    private $statementReadAdmin;
    private $statementReadSession;
    private $statementReadAdminById;

    function __construct(private PDO $pdo)
    {
        $this->statementInsertAdmin = $pdo->prepare('INSERT INTO admin VALUES (
            DEFAULT,
            :username,
            :email,
            :password,
            :role
        )');

        $this->statementInsertSession = $pdo->prepare('INSERT INTO admin_session VALUE (
            :id_session_admin,
            :id_admin
        )');

        $this->statementDeleteSession = $pdo->prepare('DELETE FROM admin_session WHERE id_session_admin = :id_session_admin ');

        $this->statementReadAdmin = $pdo->prepare('SELECT * FROM admin WHERE username = :username');

        $this->statementReadSession = $pdo->prepare('SELECT * FROM admin_session WHERE id_session_admin = :id_session_admin ');

        $this->statementReadAdminById = $pdo->prepare('SELECT * FROM admin WHERE id_admin = :id_admin');
    }

    public function InsertAdmin($username, $email, $password, $role)
    {
        $this->statementInsertAdmin->bindValue(':username', $username);
        $this->statementInsertAdmin->bindValue(':email', $email);
        $this->statementInsertAdmin->bindValue(':password', $password);
        $this->statementInsertAdmin->bindValue(':role', $role);
        $this->statementInsertAdmin->execute();
    }

    public function ReadAdmin($username)
    {
        $this->statementReadAdmin->bindValue(':username', $username);
        $this->statementReadAdmin->execute();
        return $this->statementReadAdmin->fetch();
    }

    public function InsertSessionAdmin($id_session_admin, $id_admin)
    {
        $this->statementInsertSession->bindValue(':id_session_admin', $id_session_admin);
        $this->statementInsertSession->bindValue(':id_admin', $id_admin);
        $this->statementInsertSession->execute();
    }

    public function DeleteSession($id_session_admin)
    {
        $this->statementDeleteSession->bindValue(':id_session_admin', $id_session_admin);
        $this->statementDeleteSession->execute();
    }
    public function ReadSessionAdmin($id_session_admin)
    {
        $this->statementReadSession->bindValue(':id_session_admin', $id_session_admin);
        $this->statementReadSession->execute();
        return $this->statementReadSession->fetch();
    }

    public function ReadAdminById($id_admin)
    {
        $this->statementReadAdminById->bindValue(':id_admin', $id_admin);
        $this->statementReadAdminById->execute();
        return $this->statementReadAdminById->fetch();
    }
}
