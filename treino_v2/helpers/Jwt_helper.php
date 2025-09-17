<?php

require_once 'vendor/autoload.php';
require_once __DIR__ . '/../config/Database.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWT_helper
{
    private $conn;

    private static $key = "chave_secreta";

    public function __construct($db)
    {

        $this->conn = $db;
    }

    public static function generateToken($user_id, $name, $email)
    {
        $payload = [
            "iss" => "localhost",
            "aud" => "localhost",
            "iat" => time(),
            // "exp" => time() + 3600, 
            "data" => [
                "id" => $user_id,
                "name" => $name,
                // "role" => $role,
                "email" => $email
            ]
        ];

        return JWT::encode($payload, self::$key, 'HS256');
    }

    public function validateToken($token)
    {
        try {
            return JWT::decode($token, new Key(self::$key, 'HS256'));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function decodeToken($token)
    {
        return JWT::decode($token, new Key(self::$key, 'HS256'));
    }

    public function saveToken($user_id, $token)
    {
        try {
            $this->conn->query("USE crud");
            $query = "INSERT INTO tokens (user_id, token) VALUES (:user_id, :token)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':token', $token);

            if ($stmt->execute()) {
                http_response_code(201);
                return json_encode(["success" => "Toekn salvo com sucesso"]);
            } else {
                http_response_code(500);
                return json_encode(["error" => "Erro ao salvar token"]);
            }
        } catch (PDOException $e) {
            return json_encode(["error" => "Erro no banco de dados", "details" => $e->getMessage()]);
        }
    }
}
