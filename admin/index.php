<?php
// Arquivo do painel administrativo
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/auth/auth.php';

if (adminJaLogado()) {
    header('Location: ' . adminWebPath() . 'dashboard.php');
} else {
    header('Location: ' . adminLoginUrl());
}
exit;


