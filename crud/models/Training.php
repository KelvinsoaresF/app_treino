<?php 
class Training {

    private $conn;

    public $user_id;
    public $day;
    public $name;
    public $start;
    public $end;

    public function __construct($db) 
    {
        $this->conn = $db;
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
            return json_encode(["error" => "Erro no banco de dados", "details" => $e->getMessage()]);
        }
        

    }
}

?>