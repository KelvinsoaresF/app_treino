<?php 

class Verify_Helper {
    private $conn;
    private $user;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public static function verify_Prof($user)
    {
        if($user->role === 'prof') {
            return true;
        } else {
            return false;
        }
    }
}


?>