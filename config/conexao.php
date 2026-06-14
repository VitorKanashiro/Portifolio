<?php
// Configuracao global do banco e sistema

define('DB_HOST', 'mysql.fatecss.com.br');
define('DB_NAME', 'fatecss08'); 
define('DB_USER', 'fatecss08'); 
define('DB_PASS', 'BynqedHikre');  
define('DB_CHARSET', 'utf8mb4');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die(json_encode(['error' => 'Erro de conexão com o banco de dados.']));
}
mysqli_set_charset($conn, DB_CHARSET);

function sanitize(string $str): string {
    return htmlspecialchars(strip_tags(trim($str)), ENT_QUOTES, 'UTF-8');
}

?>

