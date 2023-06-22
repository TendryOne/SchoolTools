<?php
class NoteController
{
    private $noteModel;

    function __construct(NoteModel $noteModel)
    {
        $this->noteModel = $noteModel;
    }

    public function GetNote($id_module)
    {
        return $this->noteModel->GetNote($id_module);
    }

    public function AddNote($id_etudiant, $id_module, $note)
    {
        $this->noteModel->AddNote($id_etudiant, $id_module, $note);
    }
    public function CheckProtection($id_etudiant, $id_module)
    {
        return $this->noteModel->CheckProtection($id_etudiant, $id_module);
    }
    public function UpdateNote($note, $id_note)
    {
        $this->noteModel->UpdateNote($note, $id_note);
    }
    public function DeleteNote($id_etudiant)
    {
        $this->noteModel->DeleteNote($id_etudiant);
    }
    public function ReadNoteByidEtudiant($id_etudiant)
    {
        return $this->noteModel->ReadNoteByidEtudiant($id_etudiant);
    }
    public function ReadNoteByIdModule($id_module)
    {
        return $this->noteModel->ReadNoteByIdModule($id_module);
    }
}
