<?php
/**
 * admin/bootstrap.php
 * Arquivo de inicialização comum para todas as páginas do painel admin.
 */
define('ADMIN_ROOT', __DIR__);

require_once ADMIN_ROOT . '/../config/conexao.php';
require_once ADMIN_ROOT . '/config/admin_config.php';
require_once ADMIN_ROOT . '/../includes/helpers.php';
require_once ADMIN_ROOT . '/helpers/admin_helpers.php';
