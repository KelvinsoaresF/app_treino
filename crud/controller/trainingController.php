<?php 

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Training.php';
require_once __DIR__ . '/../helpers/Jwt_helper.php';

class trainingController {
    private $db;
    private $user;
    private $training;
    private $JWT;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
        $this->training = new Training($this->db);
        $this->user = new User($this->db);
        
    }

    public function create($data) 
    {
        try {
            $this->training->name = $data['name'];
            $this->training->day = $data['day'];
            $this->training->start = $data['start'];
            $this->training->end = $data['end'];


        } catch (\Throwable $e) {
            # code...
        }
    }
}

?>