<?php
/**
 * admin/helpers/admin_helpers.php
 * Funções auxiliares reutilizáveis do painel administrativo.
 */

require_once dirname(__DIR__) . '/config/admin_config.php';

/**
 * Escapa saída HTML de forma segura (previne XSS).
 */
function adminEsc(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitiza texto de entrada: remove tags HTML e espaços extras.
 * Usar ANTES de gravar no banco (prepared statements protegem SQL).
 */
function adminSanitizar(string $texto): string
{
    return trim(strip_tags($texto));
}

/**
 * Sanitiza e valida URL. Retorna string vazia se inválida.
 */
function adminSanitizarUrl(string $url): string
{
    $url = trim($url);
    if ($url === '') {
        return '';
    }

    return filter_var($url, FILTER_VALIDATE_URL) ? $url : '';
}

/**
 * Retorna o caminho web absoluto até a raiz do projeto (ex: /portifolio-1/).
 * Evita quebra de CSS/JS em páginas admin em subpastas.
 */
function adminSiteRoot(): string
{
    static $root = null;

    if ($root !== null) {
        return $root;
    }

    $docRoot = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/'));
    $projectRoot = str_replace('\\', '/', realpath(dirname(__DIR__, 2)) ?: dirname(__DIR__, 2));

    if ($docRoot !== '' && str_starts_with($projectRoot, $docRoot)) {
        $root = '/' . trim(substr($projectRoot, strlen($docRoot)), '/') . '/';
        return $root;
    }

    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $pos = stripos($script, '/admin/');

    if ($pos !== false) {
        $root = substr($script, 0, $pos + 1);
        return $root !== '' ? $root : '/';
    }

    $root = '/';
    return $root;
}

/**
 * Retorna o caminho web absoluto da pasta admin (ex: /portifolio-1/admin/).
 */
function adminWebPath(): string
{
    return adminSiteRoot() . 'admin/';
}


/**
 * Calcula prefixo relativo para links internos do admin (sidebar).
 */
function adminUrlBase(): string
{
    return adminWebPath();
}

/**
 * URL do login admin relativa ao script atual.
 */
function adminLoginUrl(): string
{
    return adminWebPath() . 'auth/login.php';
}

/**
 * Renderiza uma view do admin com header, sidebar e footer.
 */
function renderAdminView(string $view, array $dados = [], array $opcoes = []): void
{
    $pageTitle = $opcoes['page_title'] ?? 'Admin Portfólio';
    $showSidebar = $opcoes['show_sidebar'] ?? true;
    $extraScripts = $opcoes['extra_scripts'] ?? '';
    $extraStyles = $opcoes['extra_styles'] ?? '';

    $baseUrl = adminSiteRoot();
    $adminBase = adminWebPath();

    extract($dados, EXTR_SKIP);

    include dirname(__DIR__) . '/includes/admin_header.php';

    if ($showSidebar) {
        include dirname(__DIR__) . '/includes/admin_navbar.php';
        include dirname(__DIR__) . '/includes/admin_sidebar.php';
    }

    $viewPath = dirname(__DIR__) . '/views/' . $view . '.php';

    if (!file_exists($viewPath)) {
        http_response_code(500);
        echo '<div class="admin-content p-5"><p class="text-danger">View não encontrada: ' . adminEsc($view) . '</p></div>';
    } else {
        include $viewPath;
    }

    include dirname(__DIR__) . '/includes/admin_footer.php';
}

/**
 * Redireciona com mensagem de sucesso via query string.
 */
function adminRedirect(string $url, ?string $success = null): void
{
    if ($success !== null) {
        $separador = str_contains($url, '?') ? '&' : '?';
        $url .= $separador . 'success=' . urlencode($success);
    }

    header('Location: ' . $url);
    exit;
}

/**
 * Retorna mensagem de sucesso baseada no parâmetro GET ?success=
 */
function adminMensagemSucesso(?string $chave, array $mapa): string
{
    return $mapa[$chave ?? ''] ?? 'Operação realizada com sucesso!';
}

/**
 * Verifica se arquivo de upload existe no diretório de uploads.
 */
function adminUploadExiste(?string $arquivo): bool
{
    return $arquivo !== null && $arquivo !== '' && file_exists(ADMIN_UPLOAD_DIR . $arquivo);
}

/**
 * Retorna caminho relativo da URL de upload para exibição no admin.
 */
function adminUploadSrc(string $arquivo): string
{
    return adminSiteRoot() . ADMIN_UPLOAD_URL . $arquivo;
}

// ─────────────────────────────────────────────────────────────
// BANCO DE DADOS — Prepared Statements
// ─────────────────────────────────────────────────────────────

/**
 * Executa query preparada e retorna uma linha associativa ou null.
 */
function dbFetchOne(mysqli $conn, string $sql, string $types = '', mixed ...$params): ?array
{
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return null;
    }

    if ($types !== '') {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $linha     = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);

    return $linha ?: null;
}

/**
 * Executa query preparada e retorna todas as linhas.
 */
function dbFetchAll(mysqli $conn, string $sql, string $types = '', mixed ...$params): array
{
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return [];
    }

    if ($types !== '') {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $linhas    = mysqli_fetch_all($resultado, MYSQLI_ASSOC) ?: [];
    mysqli_stmt_close($stmt);

    return $linhas;
}

/**
 * Executa INSERT/UPDATE/DELETE preparado. Retorna true em sucesso.
 */
function dbExecute(mysqli $conn, string $sql, string $types = '', mixed ...$params): bool
{
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return false;
    }

    if ($types !== '') {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $ok;
}


/**
 * Retorna valor escalar de uma query COUNT etc.
 */
function dbFetchScalar(mysqli $conn, string $sql, string $types = '', mixed ...$params): int
{
    $linha = dbFetchOne($conn, $sql, $types, ...$params);

    return (int) ($linha ? array_values($linha)[0] : 0);
}

// ─────────────────────────────────────────────────────────────
// UPLOAD DE IMAGENS
// ─────────────────────────────────────────────────────────────

/**
 * Processa upload de imagem com validação de tipo e tamanho.
 * Retorna ['arquivo' => string, 'erro' => string].
 */
function adminProcessarUpload(array $arquivo, string $prefixo = 'img_'): array
{
    if (empty($arquivo['name']) || ($arquivo['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['arquivo' => '', 'erro' => ''];
    }

    if (($arquivo['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        return ['arquivo' => '', 'erro' => 'Erro no envio do arquivo. Tente novamente.'];
    }

    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

    if (!in_array($extensao, ADMIN_UPLOAD_EXTENSIONS, true)) {
        return ['arquivo' => '', 'erro' => 'Formato inválido. Use: JPG, PNG, GIF ou WEBP.'];
    }

    if (($arquivo['size'] ?? 0) > ADMIN_UPLOAD_MAX_SIZE) {
        return ['arquivo' => '', 'erro' => 'Arquivo muito grande. Máximo 5MB.'];
    }

    if (!is_dir(ADMIN_UPLOAD_DIR)) {
        mkdir(ADMIN_UPLOAD_DIR, 0755, true);
    }

    $nomeArquivo = $prefixo . uniqid() . '.' . $extensao;
    $destino     = ADMIN_UPLOAD_DIR . $nomeArquivo;

    if (!move_uploaded_file($arquivo['tmp_name'], $destino)) {
        return ['arquivo' => '', 'erro' => 'Falha ao salvar o arquivo no servidor.'];
    }

    return ['arquivo' => $nomeArquivo, 'erro' => ''];
}

/**
 * Remove arquivo de upload do disco se existir.
 */
function adminRemoverUpload(?string $arquivo): void
{
    if ($arquivo && file_exists(ADMIN_UPLOAD_DIR . $arquivo)) {
        @unlink(ADMIN_UPLOAD_DIR . $arquivo);
    }
}

/**
 * Mapeia nível textual para percentual (usado na ordenação do site).
 */
function adminNivelPercentual(string $nivel): int
{
    $nivelLower = strtolower($nivel);

    return match (true) {
        str_contains($nivelLower, 'expert')  => 95,
        str_contains($nivelLower, 'avan')    => 85,
        str_contains($nivelLower, 'inter')   => 70,
        str_contains($nivelLower, 'bás') || str_contains($nivelLower, 'bas') => 50,
        default                              => 60,
    };
}

/**
 * Retorna classe CSS do badge de nível da tecnologia.
 */
function adminBadgeNivel(string $nivel): string
{
    return badgeNivelTecnologia($nivel);
}

