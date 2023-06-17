<?php
class emploiDuTempsModel
{
    private $statementInsertEdt;
    private $statementReadEdt;
    private $statementreadEdtById;
    private $statementUpdateEdt;
    private $statementDeleteEdt;

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
        ');

        $this->statementDeleteEdt = $pdo->prepare('DELETE FROM emploi_du_temps WHERE id_emploi = :id_emploi');
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

    public function UpdateEdt($id_module, $jour, $heure_debut, $heure_fin, $salle)
    {
        $this->statementUpdateEdt->bindValue(':id_module', $id_module);
        $this->statementUpdateEdt->bindValue(':jour', $jour);
        $this->statementUpdateEdt->bindValue(':heure_debut', $heure_debut);
        $this->statementUpdateEdt->bindValue(':heure_fin', $heure_fin);
        $this->statementUpdateEdt->bindValue(':salle', $salle);
        $this->statementUpdateEdt->execute();
    }

    public function DeleteEdt($id_emploi)
    {
        $this->statementDeleteEdt->bindValue(':id_emploi', $id_emploi);
        $this->statementDeleteEdt->execute();
    }
}
