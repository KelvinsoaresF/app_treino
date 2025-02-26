<?php 
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../helpers/Jwt_helper.php";

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->user = new User($this->db);
    }

    public function register($data) {
        try {
            var_dump("Senha fornecida durante o registro: '" . $data['password'] . "'");
            if ($this->user->emailExists($data['email'])) {
                return json_encode(["message" => "Email ja cadastrado"]);
            }

            $user = [
                "name" => $data['name'],
                "email" => $data['email'],
                "password" => password_hash($data['password'], PASSWORD_BCRYPT)
            ];

            $this->user->name = $user['name'];
            $this->user->email = $user['email'];
            $this->user->name = $user['password'];

            // Verifique o hash gerado
            var_dump("Hash gerado durante o registro: " . $this->user->password . "'");
    
            if ($this->user->create()) {
                return json_encode([
                    "message"  => "Usuario criado com sucesso",
                    "user" => $user
                ]);
            } else {
                return json_encode(["error" => "Erro ao criar usuario"]);
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
            var_dump("dados do login", $data); // Debug: Verifique os dados de login
    
            $this->user->email = $data['email'];
            $this->user->password = $data['password'];
            $userData = $this->user->findByEmail();
    
            var_dump("dados do user data", $userData); // Debug: Verifique os dados do usuário
    
            if ($userData && password_verify($this->user->password, $userData['password'])) {
                $token = JWT_helper::generateToken($userData['id'], $userData['name'], $userData['email']);
                return json_encode([
                    "message" => "Login realizado com sucesso",
                    "token" => $token,
                    "user" => $userData
                ]);
            }  else {
                http_response_code(404);
                return json_encode(["error" => "Usuário não encontrado"]);
            }

        } catch (\Throwable $e) {
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
<!-- 
// Verifica se a senha fornecida corresponde ao hash armazenado
            //     if (password_verify($this->user->password, $userData['password'])) {
            //         // Gera o token JWT
            //         $token = JWT_helper::generateToken($userData['id'], $userData['name'], $userData['email']);
            //         return json_encode([
            //             "message" => "Login realizado com sucesso",
            //             "token" => $token
            //         ]);
            //     } else {
            //         var_dump("Senha fornecida não corresponde ao hash armazenado"); // Debug
            //         http_response_code(401);
            //         return json_encode(["error" => "Credenciais inválidas"]);
            //     }
            // } else {
            //     http_response_code(404);
            //     return json_encode(["error" => "Usuário não encontrado"]);
            // } -->