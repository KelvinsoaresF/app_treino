<?php
// require_once __DIR__ . '/../config/Database.php';
// require_once __DIR__ . '/../helpers/Jwt_helper.php';

require_once __DIR__ . '/./config/Database.php';
require_once __DIR__ . '/./helpers/Jwt_helper.php';

// Conexão com banco
$database = new Database();
$db = $database->connect();
$jwt = new JWT_helper();

// Dados de teste
$user_id = 7;
$test_token = "test_token_" . time();

echo "Testando salvamento de token...\n";

try {
    // Teste direto
    $query = "INSERT INTO tokens (user_id, token) VALUES (?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute([$user_id, $test_token]);
    
    $rows = $stmt->rowCount();
    echo "Linhas afetadas: $rows\n";
    
    // Verifique no banco
    $check = $db->query("SELECT * FROM tokens WHERE user_id = $user_id");
    $result = $check->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Resultado no banco:\n";
    print_r($result);
    
    // Limpeza
    $db->query("DELETE FROM tokens WHERE user_id = $user_id");
    
} catch (PDOException $e) {
    echo "ERRO PDO: " . $e->getMessage() . "\n";
    echo "Info: " . print_r($db->errorInfo(), true) . "\n";
}