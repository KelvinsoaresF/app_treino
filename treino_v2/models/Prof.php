<?php
class Prof
{
    private $conn;

    public $prof_id;
    public $aluno_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function assoc_aluno($id)
    {
        try {
            $this->conn->query("USE treino");
            $query = "INSERT INTO prof_aluno (prof_id, aluno_id) VALUES ()";
        } catch (\Throwable $th) {
        }
    }
}
