<?php 

require_once 'vendor/autoload.php';  
require_once './crud/config/Database.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWT_helper {
    private $db;
    private static $key = "chave_secreta";

    public function __construct() {
        $database = new Database;
        $this->db = $database->connect(); 
    }

    public static function generateToken($user_id, $name, $email) {
        $payload = [
            "iss" => "localhost",
            "aud" => "localhost",
            "iat" => time(),
            // "exp" => time() + 3600, 
            "data" => [
                "id" => $user_id,
                "name" => $name,
                "email" => $email
            ]
        ];

        return JWT::encode($payload, self::$key, 'HS256');
    }

    public function validateToken($token) {
        try {
            return JWT::decode($token, new Key(self::$key, 'HS256'));
        } catch (Exception $e) {
            return false;
        }
    }

    public static function saveToken()
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO tokens (user_id, token) VALUES (:user_id, :token)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':token', $token);
            return $stmt->execute();
        } catch (\Exception $e) {
            return ([
                false,
                "error" => $e->getMessage()
            ]);
        }
    }
}
