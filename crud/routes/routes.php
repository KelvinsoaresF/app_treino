<?php 
require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/../controller/authController.php';
require_once __DIR__ . '/../controller/userController.php';

$router = new Router();
$authController = new AuthController();
$userController = new UserController();

$router->addRoute("POST", 'crud/register', [$authController, "register"]);
$router->addRoute("POST", 'crud/login', [$authController, "login"]);
$router->addRoute("POST", 'crud/get-user', [$userController, "login"]);


$router->addRoute("GET", 'crud/teste', function() {
    return ["message" => "Rota GET funcionando"];
});

return $router;


?>