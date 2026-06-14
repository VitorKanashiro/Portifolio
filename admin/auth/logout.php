<?php
// Autenticacao do administrador
require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__) . '/controllers/LoginController.php';

(new LoginController($conn))->logout();


