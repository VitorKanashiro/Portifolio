<?php
/**
 * admin/auth/auth.php
 * Middleware de autenticação — protege páginas administrativas.
 *
 * Uso: require_once e chamar exigirAutenticacao() no início de cada página protegida.
 */

require_once dirname(__DIR__) . '/config/admin_config.php';
require_once dirname(__DIR__) . '/helpers/admin_helpers.php';

/**
 * Inicia a sessão do admin com configurações seguras.
 */
function iniciarSessaoAdmin(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    session_name(ADMIN_SESSION_NAME);

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}

/**
 * Verifica timeout da sessão com base na última atividade.
 * Protege contra sessões abandonadas.
 */
function verificarTimeoutSessao(): void
{
    $agora = time();

    if (isset($_SESSION['last_activity']) && ($agora - $_SESSION['last_activity']) > ADMIN_SESSION_TIMEOUT) {
        encerrarSessaoAdmin();
        header('Location: ' . adminLoginUrl() . '?timeout=1');
        exit;
    }

    $_SESSION['last_activity'] = $agora;
}

/**
 * Middleware principal: exige login para acessar a página.
 * Redireciona para login se não autenticado.
 */
function exigirAutenticacao(): void
{
    iniciarSessaoAdmin();
    verificarTimeoutSessao();

    if (empty($_SESSION['admin_id'])) {
        $retorno = urlencode($_SERVER['REQUEST_URI'] ?? '');
        header('Location: ' . adminLoginUrl() . ($retorno ? '?redirect=' . $retorno : ''));
        exit;
    }
}

/**
 * Verifica se o admin já está logado (para página de login).
 */
function adminJaLogado(): bool
{
    iniciarSessaoAdmin();
    verificarTimeoutSessao();

    return !empty($_SESSION['admin_id']);
}

/**
 * Registra dados do admin na sessão após login bem-sucedido.
 * Regenera ID da sessão para prevenir Session Fixation.
 */
function registrarSessaoAdmin(array $admin): void
{
    iniciarSessaoAdmin();

    session_regenerate_id(true);

    $_SESSION['admin_id']       = (int) $admin['id'];
    $_SESSION['admin_email']    = $admin['email'];
    $_SESSION['login_time']     = time();
    $_SESSION['last_activity']  = time();
}

/**
 * Encerra a sessão do admin de forma segura.
 */
function encerrarSessaoAdmin(): void
{
    iniciarSessaoAdmin();

    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}

/**
 * Retorna e-mail do admin logado.
 */
function adminEmailLogado(): string
{
    return $_SESSION['admin_email'] ?? 'Admin';
}
