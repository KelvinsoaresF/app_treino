<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Training.php';
require_once __DIR__ . '/../helpers/Jwt_helper.php';

class trainingController
{
    private $db;
    private $user;
    private $training;
    private $JWT;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
        $this->training = new Training($this->db);
        $this->user = new User($this->db);
    }

    public function index()
    {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            return ([
                'message' => 'token não recebido'
            ]);
            exit;
        }

        try {
            $token = str_replace("Bearer ", "", $headers['Authorization']);

            $decoded = JWT_helper::decodeToken($token);
            $user_id = $decoded->data->id;

            $trainings = $this->training->index($user_id);
            return ([
                "message" => "treinos buscados",
                "trainings" => $trainings
            ]);
        } catch (\Throwable $e) {
            return ([
                "error" => "Erro inesperado",
                "details" => $e->getMessage(),
                "file" => $e->getFile(),
                "line" => $e->getLine()
            ]);
        }
    }

    public function show($id)
    {
        try {
            $training = $this->training->show($id);

            if (!$training) {
                return ([
                    'error' => 'treino não encontrado',
                ]);
            }

            if ($training) {
                return ([
                    'message' => 'treino buscado',
                    'treino' => $training
                ]);
            } else {
                return ([
                    'error' => 'erro ao buscar treino',
                ]);
            }
        } catch (\Throwable $e) {
            return ([
                "error" => "Erro inesperado",
                "details" => $e->getMessage(),
                "file" => $e->getFile(),
                "line" => $e->getLine()
            ]);
        }
    }

    public function create($data)
    {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            return ([
                'message' => 'token não recebido'
            ]);
            exit;
        }

        try {
            $token = str_replace("Bearer ", "", $headers['Authorization']);

            $decoded = JWT_helper::decodeToken($token);
            $user_id = $decoded->data->id;

            $this->training->user_id = $user_id;
            $this->training->name = $data['name'];
            $this->training->day = $data['day'];
            $this->training->start = $data['start'];
            $this->training->end = $data['end'];

            if ($this->training->create()) {
                $training = [
                    "name" => $this->training->name,
                    "day" => $this->training->day,
                    "start" => $this->training->start,
                    "end" => $this->training->end,
                    "user_id" => $this->training->user_id,
                ];

                return ([
                    "message" => "treino criado com sucesso",
                    "training" => $training,
                ]);
            } else {
                return ([
                    "error" => "Erro ao criar treino"
                ]);
            }
        } catch (\Exception $e) {
            return json_encode([
                "error" => "Erro inesperado",
                "details" => $e->getMessage(),
                "file" => $e->getFile(),
                "line" => $e->getLine()
            ]);
        }
    }
}
