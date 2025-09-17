<?php 

require_once __DIR__ . '/Exercise.php';

class Training {

    private $conn;

    public $exercise;

    public $user_id;
    public $day;
    public $name;
    public $start;
    public $end;

    public function __construct($db) 
    {
        $this->conn = $db;
        $this->exercise = new Exercise($db);
    }

    public function index($user_id)
    {
        try {
            $this->conn->query("USE treino");

            $query = "SELECT * FROM training_days WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            $trainings = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($trainings as &$training) {
                $training['exercises'] = $this->exercise->getExerciciesByTraining($training['id']);
            }
            return $trainings;

        } catch (PDOException $e) {
            return ([
                "error" => "Erro no banco de dados", 
                "details" => $e->getMessage()
            ]); 
        }
}
    public function show($id)
    {
        try {   
            $this->conn->query("USE crud");

            $query = "SELECT * FROM training_days WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $id);
            $stmt->execute();
        
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            error_log(print_r($result, true)); 
            return $result;
    
        } catch (PDOException $e) {
            return ([
                "error" => "Erro no banco de dados", 
                "details" => $e->getMessage()
            ]); 
        }
    }

    public function create() 
    {
        try {
            $this->conn->query("USE crud");

            $query = "INSERT INTO training_days (user_id, day, name, start, end) VALUES(:user_id, :day, :name, :start, :end)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':user_id', $this->user_id);
            $stmt->bindParam(':day', $this->day);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':start', $this->start);
            $stmt->bindParam(':end', $this->end);

            if ($stmt->execute()) {
                http_response_code(201);
                return json_encode([
                    "success" => "Treino criado com sucesso"
                ]);
            } else {
                http_response_code(500);
                return json_encode([
                    "error" => "Erro ao criar usuário"
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