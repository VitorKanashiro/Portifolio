<?php
// Arquivo do painel administrativo
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/controllers/DashboardController.php';

(new DashboardController($conn))->index();


