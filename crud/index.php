<?php 

$router = require("./routes/routes.php");

$router->handleRequest();

// $password = "123";
// $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// echo "Senha fornecida: '$password'\n";
// echo "Hash gerado: '$hashedPassword'\n";
// $password = '123';
// $hash = password_hash($password, PASSWORD_BCRYPT);
// var_dump($hash);  // Verifique o valor gerado

$testPassword = "dario"; // Senha fornecida para o teste
$hashedPassword = password_hash($testPassword, PASSWORD_BCRYPT); // Gerando o hash manualmente
var_dump($hashedPassword); 

?>