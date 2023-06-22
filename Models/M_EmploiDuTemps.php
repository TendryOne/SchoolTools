<?php
class emploiDuTempsModel
{
    private $statementInsertEdt;
    private $statementReadEdt;
    private $statementreadEdtById;
    private $statementUpdateEdt;
    private $statementDeleteEdt;
    private $statementReadEdtByIdModule;
    private $statementGetProfEdt;
    private $statementAutoDeleteEvent;

    function __construct(private PDO $pdo)
    {
        $this->statementInsertEdt = $pdo->prepare('INSERT INTO emploi_du_temps VALUES (
            DEFAULT,
            :id_module,
            :jour,
            :heure_debut,
            :heure_fin,
            :salle
        )');

        $this->statementReadEdt = $pdo->prepare('SELECT * FROM emploi_du_temps');

        $this->statementreadEdtById = $pdo->prepare('SELECT * FROM emploi_du_temps WHERE id_emploi = :id_emploi');

        $this->statementUpdateEdt = $pdo->prepare('UPDATE emploi_du_temps SET 
            id_module = :id_module,
            jour = :jour,
            heure_debut = :heure_debut,
            heure_fin = :heure_fin,
            salle = :salle
            WHERE id_emploi = :id_emploi
        ');

        $this->statementDeleteEdt = $pdo->prepare('DELETE FROM emploi_du_temps WHERE id_emploi = :id_emploi');

        $this->statementReadEdtByIdModule = $pdo->prepare('SELECT * FROM emploi_du_temps WHERE id_module = :id_module
        ');

        $this->statementGetProfEdt = $pdo->prepare('SELECT e.id_module, e.jour, e.heure_debut, e.heure_fin, e.salle, m.nom, m.id_prof
        FROM emploi_du_temps e
        JOIN modules m ON e.id_module = m.id_module
        WHERE m.id_prof = :id_prof');

        $this->statementAutoDeleteEvent = $pdo->prepare('DELETE FROM emploi_du_temps WHERE jour < :current_date');
    }

    public function insertEdt($id_module, $jour, $heure_debut, $heure_fin, $salle)
    {
        $this->statementInsertEdt->bindValue(':id_module', $id_module);
        $this->statementInsertEdt->bindValue(':jour', $jour);
        $this->statementInsertEdt->bindValue(':heure_debut', $heure_debut);
        $this->statementInsertEdt->bindValue(':heure_fin', $heure_fin);
        $this->statementInsertEdt->bindValue(':salle', $salle);
        $this->statementInsertEdt->execute();
    }
    public function readEdt()
    {
        $this->statementReadEdt->execute();
        return $this->statementReadEdt->fetchAll();
    }

    public function readEdtbyId($id_emploi)
    {
        $this->statementreadEdtById->bindValue(':id_emploi', $id_emploi);
        $this->statementreadEdtById->execute();
        return $this->statementreadEdtById->fetch();
    }

    public function UpdateEdt($id_emploi, $id_module, $jour, $heure_debut, $heure_fin, $salle)
    {
        $this->statementUpdateEdt->bindValue(':id_module', $id_module);
        $this->statementUpdateEdt->bindValue(':jour', $jour);
        $this->statementUpdateEdt->bindValue(':heure_debut', $heure_debut);
        $this->statementUpdateEdt->bindValue(':heure_fin', $heure_fin);
        $this->statementUpdateEdt->bindValue(':salle', $salle);
        $this->statementUpdateEdt->bindValue(':id_emploi', $id_emploi);
        $this->statementUpdateEdt->execute();
    }

    public function DeleteEdt($id_emploi)
    {
        $this->statementDeleteEdt->bindValue(':id_emploi', $id_emploi);
        $this->statementDeleteEdt->execute();
    }
    public function ReadEdtByidModule($id_module)
    {
        $this->statementReadEdtByIdModule->bindValue(':id_module', $id_module);
        $this->statementReadEdtByIdModule->execute();
        return $this->statementReadEdtByIdModule->fetch();
    }

    public function GetProfEdt($id_prof)
    {
        $this->statementGetProfEdt->bindValue(':id_prof', $id_prof);
        $this->statementGetProfEdt->execute();
        return $this->statementGetProfEdt->fetchAll();
    }

    public function AutoDeleteEvent($date)
    {
        $this->statementAutoDeleteEvent->bindValue(':current_date', $date);
        $this->statementAutoDeleteEvent->execute();
    }
}
