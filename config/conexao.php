<?php
/**
 * config/conexao.php
 * Configuração da conexão com o banco de dados MySQL.
 * Utiliza MySQLi — padrão didático para projetos de ADS (Análise e Desenvolvimento de Sistemas).
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'portfolio');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die(json_encode(['error' => 'Erro de conexão com o banco de dados.']));
}
mysqli_set_charset($conn, DB_CHARSET);

/**
 * Função auxiliar para sanitizar strings
 */
function sanitize(string $str): string {
    return htmlspecialchars(strip_tags(trim($str)), ENT_QUOTES, 'UTF-8');
}

?>