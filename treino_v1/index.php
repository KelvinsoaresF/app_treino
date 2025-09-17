<?php 

header('Content-Type: application/json');

$router = require("./routes/routes.php");

$router->handleRequest();

?>