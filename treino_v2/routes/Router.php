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
    
        // percorre as rotas com base no handler
        foreach ($this->routes[$method] as $route => $callback) {
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $route); //pega o (id) da rota
    
            //compara se a rota tem algum parametro (id), se sim joga no m
            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                $params = array_filter($matches, function($key) {
                    return !is_int($key);
                }, ARRAY_FILTER_USE_KEY); // filtra o matches e pega apenas o parametro nomeado, por exemplo "id" => 1
    
                $data = json_decode(file_get_contents("php://input"), true);
    
                if (isset($params['id'])) {
                    $response = call_user_func($callback, $params['id'], $data); 
                } else {
                    $response = call_user_func($callback, $data); 
                }

                echo json_encode($response);
                return;
            }
        }
    
        http_response_code(404);
        echo json_encode(["error" => "Rota não encontrada"]);
    }
}
?>