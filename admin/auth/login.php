<?php
/**
 * admin/auth/login.php — Ponto de entrada do login (apenas orquestração).
 */
require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__) . '/controllers/LoginController.php';

(new LoginController($conn))->exibirLogin();
