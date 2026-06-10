<?php
/**
 * admin/dashboard.php — Painel principal (orquestração).
 */
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/controllers/DashboardController.php';

(new DashboardController($conn))->index();
