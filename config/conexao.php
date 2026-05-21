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

//Função de limpeza e proteção de dados
function sanatize(string $str): string {
    return htmlspecialchars(strip_tags(trim($str)), ENT_QUOTES, 'UTF-8');
}

//Função bloquear acesso sem login
function requireAdmin(): void {
    if(session_status() !== PHP_SESSION_ACTIVE)
        session_start();
    if (!isset($_SESSION['admin_id'])){
        header('Location: ' . getAdminBase() . 'login.php');
        exit;
    }
}

//Ajustar caminhos de pastas automaticamente
function getAdminBase(): string {
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    return (strpos($uri, '/admin/') !== false) ? '' : 'admin/';
}
?>