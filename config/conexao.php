<?php
//Configuração da conexão com o banco de dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'portifolio');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn){
    die(json_encode(['error' => 'Erro de conexão com o banco de dados!']));
}

mysqli_set_charset($conn, DB_CHARSET);
?>