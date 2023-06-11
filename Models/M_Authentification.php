<?php


class EtudiantsModel
{
    private $statementSessionInsert;
    private $statementSessionRead;
    private $statementSessionUpdate;
    private $statementEtudiantInsert;
    private $statementEtudiantRead;

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
}
class ProfsModel
{
    private $statementProf;

    function __construct(private $pdo)
    {

        $this->statementProf = $pdo->prepare('INSERT INTO profs VALUES(
            DEFAULT,
            :name,
            :firstname,
            :email,
            :password
                )');
    }

    public function InsertProf($name, $firstname, $email, $password)
    {
        $this->statementProf->bindValue(':name', $name);
        $this->statementProf->bindValue(':firstname', $firstname);
        $this->statementProf->bindValue(':email', $email);
        $this->statementProf->bindValue(':password', $password);
        $this->statementProf->execute();
    }
}
