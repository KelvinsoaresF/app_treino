<?php 
class Router {
    private $routes = [];

    public function addRoute($method, $path, $handler) {
        $this->routes[$method][$path] = $handler;
    }

    public function handleRequest() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");

        $method = $_SERVER['REQUEST_METHOD'];
        $uri = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");

        

        if (isset($this->routes[$method][$uri])) {
            $data = json_decode(file_get_contents("php://input"), true);
            echo json_encode(call_user_func($this->routes[$method][$uri], $data));
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Rota não encontrada"]);
        }
    }
}

?>