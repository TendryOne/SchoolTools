<?php

class NoteModel
{
    private $statementGetNote;
    private $statementAddNote;
    private $statementCheckProtection;
    private $statementUpdateNote;
    private $statementDeleteNote;
    private $statementReadNoteByIdEtudiant;
    private $statementReadNoteByIdmodule;
    function __construct(private PDO $pdo)
    {
        $this->statementGetNote = $pdo->prepare('SELECT e.name, e.firstname, e.id_etudiant, n.note , n.id_note
        FROM etudiants e
        LEFT JOIN notes n ON e.id_etudiant = n.id_etudiant AND n.id_module = :id_module');

        $this->statementAddNote = $pdo->prepare('INSERT INTO notes VALUES(
            DEFAULT,
            :id_etudiant,
            :id_module,
            :note
        )');
        $this->statementCheckProtection = $pdo->prepare('SELECT * FROM notes WHERE id_module = :id_module AND id_etudiant = :id_etudiant ;');

        $this->statementUpdateNote = $pdo->prepare('UPDATE notes SET note = :note WHERE id_note = :id_note ');

        $this->statementDeleteNote = $pdo->prepare('DELETE FROM  notes WHERE id_etudiant = :id_etudiant');

        $this->statementReadNoteByIdEtudiant = $pdo->prepare('SELECT * FROM notes WHERE id_etudiant = :id_etudiant');

        $this->statementReadNoteByIdmodule = $pdo->prepare('SELECT * FROM notes WHERE id_module = :id_module');
    }

    public function GetNote($id_module)
    {
        $this->statementGetNote->bindValue(':id_module', $id_module);
        $this->statementGetNote->execute();
        return $this->statementGetNote->fetchAll();
    }

    public function AddNote($id_etudiant, $id_module, $note)
    {
        $this->statementAddNote->bindValue(':id_etudiant', $id_etudiant);
        $this->statementAddNote->bindValue(':id_module', $id_module);
        $this->statementAddNote->bindValue(':note', $note);
        $this->statementAddNote->execute();
    }

    public function CheckProtection($id_etudiant, $id_module)
    {
        $this->statementCheckProtection->bindValue(':id_etudiant', $id_etudiant);
        $this->statementCheckProtection->bindValue(':id_module', $id_module);
        $this->statementCheckProtection->execute();
        return $this->statementCheckProtection->fetch();
    }

    public function UpdateNote($note, $id_note)
    {
        $this->statementUpdateNote->bindValue(':note', $note);
        $this->statementUpdateNote->bindValue(':id_note', $id_note);
        $this->statementUpdateNote->execute();
    }
    public function DeleteNote($id_etudiant)
    {
        $this->statementDeleteNote->bindValue(':id_etudiant', $id_etudiant);
        $this->statementDeleteNote->execute();
    }
    public function ReadNoteByidEtudiant($id_etudiant)
    {
        $this->statementReadNoteByIdEtudiant->bindValue(":id_etudiant", $id_etudiant);
        $this->statementReadNoteByIdEtudiant->execute();
        return $this->statementReadNoteByIdEtudiant->fetchAll();
    }
    public function ReadNoteByIdModule($id_module)
    {
        $this->statementReadNoteByIdmodule->bindValue(':id_module', $id_module);
        $this->statementReadNoteByIdmodule->execute();
        return $this->statementReadNoteByIdmodule->fetchAll();
    }
}
