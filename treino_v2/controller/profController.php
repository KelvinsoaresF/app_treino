<?php

require_once __DIR__ . "/../helpers/Verify_Helper.php";
require_once __DIR__ . "/../config/Database.php";

class ProfController {

    private $db;
    private $verifyProf;
    private $user;
    private $profAluno;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database;
        $this->verifyProf = new Verify_Helper($this->db);
        $this->user = new User($this->db);
        $this->profAluno = new Prof($this->db); 
    }

    public function assoc_aluno($aluno_id)
    {
        if(!isset($headers['Authorization'])) {
            http_response_code(401);
            return ([
                'message' => 'token não recebido'
            ]);
            exit;
        }

        $token = str_replace("Bearer ", "", $headers['Authorization']);
        
        $decoded = JWT_helper::decodeToken($token);
        $user_id = $decoded->id;
        if (!Verify_Helper::verify_Prof($user_id)) {
            http_response_code(404);
            return json_encode(["error" => "Acesso negado, apenas professores"]);
        }

        $this->profAluno->prof_id = $this->user->id;
    }
}
