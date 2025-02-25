<?php 

require_once 'vendor/autoload.php';  // Inclua esta linha no topo do seu arquivo PHP

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWT_helper {
    private static $key = "chave_secreta";

    public static function generateToken($user_id, $name, $email) {
        $payload = [
            "iss" => "localhost",
            "aud" => "localhost",
            "iat" => time(),
            "exp" => time() + (180 * 180),
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
}
?>