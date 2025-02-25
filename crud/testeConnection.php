<?php 
require_once("./config/Database.php");

$db = new Database();

$conn = $db->connect();

if ($conn) {
    echo 'Conexão bem sucedida';
    
} else {
    echo 'falhou, essa bosta';
}
?>