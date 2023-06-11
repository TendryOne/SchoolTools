<?php


class EtudiantsModel
{
    private $statementSessionInsert;
    private $statementEtudiantInsert;
    private $statementEtudiantRead;
    private $statementEtudiantReadAll;

    function __construct(private $pdo)
    {

        $this->statementEtudiantInsert = $pdo->prepare('INSERT INTO etudiants VALUES(
            DEFAULT,
            :name,
            :firstname,
            :email,
            :password
                )');
        $this->statementEtudiantRead = $pdo->prepare('SELECT * FROM etudiants WHERE email=:email');

        $this->statementSessionInsert = $pdo->prepare('INSERT INTO sessions_etudiants VALUES(
            :id_session,
            :id_etudiants
        )');

        $this->statementEtudiantReadAll = $pdo->prepare('SELECT * FROM etudiants');
    }

    public function InsertEtudiants($name, $firstname, $email, $password)
    {
        $this->statementEtudiantInsert->bindValue(':name', $name);
        $this->statementEtudiantInsert->bindValue(':firstname', $firstname);
        $this->statementEtudiantInsert->bindValue(':email', $email);
        $this->statementEtudiantInsert->bindValue(':password', $password);
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

    public function ReadAllEtudiants()
    {
        $this->statementEtudiantReadAll->execute();
        return $this->statementEtudiantReadAll->fetchAll();
    }
}
class ProfsModel
{

    private $statementProfsInsert;
    private $statementProfsRead;
    private $statementSessionInsert;
    private $statementProfsReadAll;

    function __construct(private $pdo)
    {

        $this->statementProfsInsert = $pdo->prepare('INSERT INTO profs VALUES(
            DEFAULT,
            :name,
            :firstname,
            :email,
            :password
                )');
        $this->statementProfsRead = $pdo->prepare('SELECT * FROM profs WHERE email=:email');

        $this->statementSessionInsert = $pdo->prepare('INSERT INTO sessions_profs VALUES(
            :id_session,
            :id_profs
        )');

        $this->statementProfsReadAll = $pdo->prepare('SELECT * FROM profs ');
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

    public function ReadAllProfs()
    {
        $this->statementProfsReadAll->execute();
        return $this->statementProfsReadAll->fetchAll();
    }
}
