<?php
// Arquivo do painel administrativo
require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__) . '/controllers/SobreController.php';
(new SobreController($conn))->editar();

