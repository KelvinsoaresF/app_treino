<?php 
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../helpers/Jwt_helper.php";

class AuthController {
    private $db;
    private $user;
    private $JWT;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->user = new User($this->db);
        $this->JWT = new JWT_helper($this->db);
    }

    public function register($data) {
        try {
            if ($this->user->emailExists($data['email'])) {
                return json_encode(["message" => "Email ja cadastrado"]);
            }

            $this->user->name = $data['name'];
            $this->user->email = $data['email'];
            $this->user->role = $data['role'];
            $this->user->password = password_hash($data['password'], PASSWORD_BCRYPT);

            
            if ($this->user->create()) {
                $user = [
                    "name" => $this->user->name,
                    "email" => $this->user->email,
                ];

                return ([
                    "message"  => "Usuario criado com sucesso",
                    "user" => $user
                ]);

            } else {
                return json_encode([
                    "error" => "Erro ao criar usuario"
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            return json_encode([
                "error" => "Erro inesperado",
                "details" => $e->getMessage(),  
                "file" => $e->getFile(),        
                "line" => $e->getLine()         
            ]);
        }
    }

    public function login($data)
    {
        try {
            $this->user->email = $data['email'];
            $this->user->password = $data['password'];
            $userData = $this->user->findByEmail();

            if ($userData && password_verify($this->user->password, $userData['password'])) {
                $token = JWT_helper::generateToken($userData['id'], $userData['name'], $userData['email']);

                if($this->JWT->saveToken($userData['id'], $token)) {
                    return ([
                        "message" => "login realizado com sucesso",
                        "token" => $token,
                        "user" => [
                            "id" => $userData['id'],
                            "name" => $userData['name'],
                            "email" => $userData['email'],
                        ]
                    ]);
                } else {
                    http_response_code(500);
                    return ([
                        "error" => "falha ao salvar token"
                    ]);
                }
                
            }  else {
                http_response_code(404);
                return ([
                    "error" => "Usuário não encontrado"
                ]);
            }
        } catch (\Throwable $e) {
            http_response_code(500);
            return ([
                "error" => "Erro inesperado",
                "details" => $e->getMessage(),
                "file" => $e->getFile(),
                "line" => $e->getLine()
            ]);
        }
    }

    public function logout()
    {
        
    }
}
?>
