<?php 
require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/../controller/authController.php';
require_once __DIR__ . '/../controller/userController.php';
require_once __DIR__ . '/../controller/trainingController.php';
require_once __DIR__ . '/../controller/exerciseController.php';
require_once __DIR__ . '/../controller/setController.php';

$router = new Router();
$authController = new AuthController();
$userController = new UserController();
$trainingController = new trainingController();
$exerciseController = new ExerciseController();
$userController = new setController();

// AUTENTICATE
$router->addRoute("POST", 'crud/register', [$authController, "register"]);
$router->addRoute("POST", 'crud/login', [$authController, "login"]);
$router->addRoute("GET", 'crud/get-user', [$userController, "getUser"]);

// TRAININGS
$router->addRoute("GET", 'crud/all-trainings', [$trainingController, "index"]);
$router->addRoute("GET", 'crud/show-training/{id}', [$trainingController, "show"]);
$router->addRoute("POST", 'crud/add-training', [$trainingController, "create"]);
// EXERCICES
$router->addRoute("POST", 'crud/add-exercise', [$exerciseController, "create"]);
// SETS 
$router->addRoute("POST", 'crud/add-set', [$setController, "create"]);


$router->addRoute("GET", 'crud/teste', function() {
    return ["message" => "Rota GET funcionando"];
});

return $router;


?>