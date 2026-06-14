<?php
// Autenticacao do administrador

require_once dirname(__DIR__) . '/config/admin_config.php';
require_once dirname(__DIR__) . '/helpers/admin_helpers.php';

function iniciarSessaoAdmin()
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

function verificarTimeoutSessao()
{
    $agora = time();

    if (isset($_SESSION['last_activity']) && ($agora - $_SESSION['last_activity']) > ADMIN_SESSION_TIMEOUT) {
        encerrarSessaoAdmin();
        header('Location: ' . adminLoginUrl() . '?timeout=1');
        exit;
    }

    $_SESSION['last_activity'] = $agora;
}

function exigirAutenticacao()
{
    iniciarSessaoAdmin();
    verificarTimeoutSessao();

    if (empty($_SESSION['admin_id'])) {
        $retorno = urlencode($_SERVER['REQUEST_URI'] ?? '');
        header('Location: ' . adminLoginUrl() . ($retorno ? '?redirect=' . $retorno : ''));
        exit;
    }
}

function adminJaLogado(): bool
{
    iniciarSessaoAdmin();
    verificarTimeoutSessao();

    return !empty($_SESSION['admin_id']);
}

function registrarSessaoAdmin(array $admin)
{
    iniciarSessaoAdmin();

    session_regenerate_id(true);

    $_SESSION['admin_id']       = (int) $admin['id'];
    $_SESSION['admin_email']    = $admin['email'];
    $_SESSION['login_time']     = time();
    $_SESSION['last_activity']  = time();
}

function encerrarSessaoAdmin()
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

function adminEmailLogado(): string
{
    return $_SESSION['admin_email'] ?? 'Admin';
}


