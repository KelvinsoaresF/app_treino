<?php 

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Exercise.php';

class ExerciseController {
    private $db;
    private $exercise;


    public function __construct()
    {
        $database = New Database();
        $this->db = $database->connect();
        $this->exercise = new Exercise($this->db);
    }

    public function create($data)
    {
        try {
            
            $this->exercise->training_day_id = $data['training_day_id'];
            $this->exercise->name = $data['name'];
    
            if($this->exercise->create()) {
                http_response_code(201);
                $exercise = [
                    "name" => $this->exercise->name,
                    "training_day_id" => $this->exercise->training_day_id
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