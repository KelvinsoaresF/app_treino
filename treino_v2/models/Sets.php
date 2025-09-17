<?php 
class Sets{
    private $conn;

    public $exercise_id;
    public $reps;
    public $carga;
    public $obs;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function setsByExercise($exercise_id)
    {
        $this->conn->query("USE treino");
        $query = "SELECT * FROM sets WHERE exercise_id = :exercise_id";
        $stmt = $this->conn->prepare($query); 
        $stmt->bindParam(':exercise_id', $exercise_id);
        $stmt->execute();
        $sets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $sets;
    }

    public function create()
    {
        try {
            $this->conn->query("USE crud");

            $query = "INSERT INTO sets (exercise_id, reps, carga, obs) VALUES (:exercise_id, :reps, :carga, :obs)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':exercise_id', $this->exercise_id);
            $stmt->bindParam(':reps', $this->reps);
            $stmt->bindParam(':carga', $this->carga);
            $stmt->bindParam(':obs', $this->obs);
            
            if($stmt->execute()) {
                http_response_code(201);
                return json_encode([
                    "success" => "Série criada com sucesso"
                ]);
            } else {
                http_response_code(500);
                return json_encode([
                    "error" => "Erro ao criar série"
                ]);
            }
        } catch (PDOException $e) {
            return json_encode([
                "error" => "Erro no banco de dados", 
                "details" => $e->getMessage()
            ]);
        }
    }
}



?>