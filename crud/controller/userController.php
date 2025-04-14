<?php 
require_once __DIR__ . '/../helpers/Jwt_helper.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/Database.php';

class UserController {
    private $db;
    private $user;
    private $JWT;

    public function __construct() 
    {
        $database = new Database();
        $this->db = $database;
        $this->user = new User($this->db);
    }
    
    public function getUser()
    {
        $headers = getallheaders();

        if(!isset($headers['Authorization'])) {
            http_response_code(401);
            return ([
                'message' => 'token não recebido'
            ]);
            exit;
        }

        $token = str_replace("Bearer ", "", $headers['Authorization']);
        try {
            $decoded = JWT_helper::decodeToken($token);
            $user_id = $decoded->data->id;
            $userData = $this->user->findById($user_id);

            return ([
                "message" => "Usuario buscado com sucesso",
                "user" => $userData
            ]);
        } catch (Exception $e) {
            return ([
                "error" => "Erro ao buscar usuario",
                "error" => $e->getMessage()
            ]);
        }
    }

}

?>