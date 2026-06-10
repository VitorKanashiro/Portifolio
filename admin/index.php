<?php
/**
 * admin/index.php — Ponto de entrada do painel administrativo.
 * Redireciona para o dashboard ou tela de login baseado no estado de autenticação.
 */
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/auth/auth.php';

if (adminJaLogado()) {
    header('Location: ' . adminWebPath() . 'dashboard.php');
} else {
    header('Location: ' . adminLoginUrl());
}
exit;
