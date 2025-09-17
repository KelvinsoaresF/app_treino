<?php 
require_once __DIR__ . '/Sets.php';

class Exercise {
    private $conn;
    public $sets;

    public $training_day_id;
    public $name;

    public function __construct($db) 
    {
        $this->conn = $db;
        $this->sets = new Sets($db);
    }

    public function getExerciciesByTraining($training_day_id)
    {
        $this->conn->query("USE treino");
        $query = "SELECT * FROM exercises WHERE training_day_id = :training_day_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':training_day_id', $training_day_id);
        $stmt->execute();
        $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($exercises as &$exercise) {
            $exercise['sets'] = $this->sets->setsByExercise($exercise['id']);
        }

        return $exercises;
    }

    public function create()
    {
        try {
            $this->conn->query("USE crud");

            $query = "INSERT INTO exercises (training_day_id, name) VALUES (:training_day_id, :name)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':training_day_id', $this->training_day_id);
            $stmt->bindParam(':name', $this->name);

            if($stmt->execute()) {
                http_response_code(201);
                return ([
                    "success" => "Exercício criado com sucesso no banco"
                ]);
            } else {
                http_response_code(500);
                return ([
                    "error" => "Erro ao criar exercício"
                ]);
            }
        } catch (PDOException $e) {
            http_response_code(500);
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