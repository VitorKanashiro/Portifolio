<?php
/**
 * admin/auth/logout.php — Encerra sessão do administrador.
 */
require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__) . '/controllers/LoginController.php';

(new LoginController($conn))->logout();
