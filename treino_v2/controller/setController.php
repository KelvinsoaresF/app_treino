<?php 
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Sets.php';

class setController {
    private $db;
    private $sets;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database;
        $this->sets = new Sets($this->db);
    }

    public function create($data)
    {
        try {
            $this->sets->exercise_id = $data['exercise_id'];
            $this->sets->reps = $data['reps'];
            $this->sets->carga = $data['carga'];
            $this->sets->obs = $data['obs'];

            if($this->sets->create()) {
                http_response_code(201);
                $exercise = [
                    "exercise_id" => $this->sets->exercise_id,
                    "reps" => $this->sets->reps,
                    "carga" => $this->sets->carga,
                    "obs" => $this->sets->obs,
                ];
                return ([
                    "message" => "Exercício criado com sucesso",
                    "exercise" => $exercise
                ]);
            } else {
                return ([
                    "error" => "Erro ao criar exercicio"
               ]);
            }
        } catch (\Throwable $e) {
            return json_encode([
                "error" => "Erro inesperado",
                "details" => $e->getMessage(),  
                "file" => $e->getFile(),        
                "line" => $e->getLine()         
            ]);
        }
    }
}

?>