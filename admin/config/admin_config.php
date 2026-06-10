<?php
/**
 * admin/config/admin_config.php
 * Configurações centralizadas da área administrativa.
 */

/** Timeout da sessão em segundos (2 horas). */
define('ADMIN_SESSION_TIMEOUT', 7200);

/** Nome da sessão do painel admin. */
define('ADMIN_SESSION_NAME', 'portfolio_admin_session');

/** Tamanho máximo de upload de imagens (5 MB). */
define('ADMIN_UPLOAD_MAX_SIZE', 5 * 1024 * 1024);

/** Extensões de imagem permitidas. */
define('ADMIN_UPLOAD_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

/**
 * Diretório físico de uploads (compartilhado com o site público).
 * Os arquivos ficam em assets/uploads/ para exibição no portfólio.
 */
define('ADMIN_UPLOAD_DIR', dirname(__DIR__, 2) . '/assets/uploads/');

/** Caminho relativo dos uploads a partir da raiz do projeto. */
define('ADMIN_UPLOAD_URL', 'assets/uploads/');

/** Itens por página nas listagens paginadas. */
define('ADMIN_PROJETOS_POR_PAGINA', 8);
define('ADMIN_MENSAGENS_POR_PAGINA', 10);
