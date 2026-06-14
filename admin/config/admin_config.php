<?php
// Configuracao do admin

define('ADMIN_SESSION_TIMEOUT', 7200);

define('ADMIN_SESSION_NAME', 'portfolio_admin_session');

define('ADMIN_UPLOAD_MAX_SIZE', 5 * 1024 * 1024);

define('ADMIN_UPLOAD_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

define('ADMIN_UPLOAD_DIR', dirname(__DIR__, 2) . '/assets/uploads/');

define('ADMIN_UPLOAD_URL', 'assets/uploads/');

define('ADMIN_PROJETOS_POR_PAGINA', 8);
define('ADMIN_MENSAGENS_POR_PAGINA', 10);


