<?php 
require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/../controller/authController.php';

$router = new Router();
$authController = new AuthController();

$router->addRoute("POST", 'crud/register', [$authController, "register"]);
$router->addRoute("POST", 'crud/login', [$authController, "login"]);

$router->addRoute("GET", 'crud/teste', function() {
    return ["message" => "Rota GET funcionando"];
});

return $router;


?>