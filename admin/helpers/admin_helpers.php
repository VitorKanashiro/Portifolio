<?php
// Arquivo do painel administrativo

// Polyfills para compatibilidade com versÃµes anteriores ao PHP 8.0
if (!function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle): bool
    {
        return $needle !== '' && strpos($haystack, $needle) !== false;
    }
}

if (!function_exists('str_starts_with')) {
    function str_starts_with(string $haystack, string $needle): bool
    {
        return strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

if (!function_exists('str_ends_with')) {
    function str_ends_with(string $haystack, string $needle): bool
    {
        return $needle === '' || (substr($haystack, -strlen($needle)) === $needle);
    }
}

require_once dirname(__DIR__) . '/config/admin_config.php';

function adminEsc(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function adminSanitizar(string $texto): string
{
    return trim(strip_tags($texto));
}

function adminSanitizarUrl(string $url): string
{
    $url = trim($url);
    if ($url === '') {
        return '';
    }

    return filter_var($url, FILTER_VALIDATE_URL) ? $url : '';
}

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

function adminWebPath(): string
{
    return adminSiteRoot() . 'admin/';
}


function adminUrlBase(): string
{
    return adminWebPath();
}

function adminLoginUrl(): string
{
    return adminWebPath() . 'auth/login';
}

function renderAdminView(string $view, array $dados = [], array $opcoes = [])
{
    $pageTitle = $opcoes['page_title'] ?? 'Admin PortfÃ³lio';
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
        echo '<div class="admin-content p-5"><p class="text-danger">View nÃ£o encontrada: ' . adminEsc($view) . '</p></div>';
    } else {
        include $viewPath;
    }

    include dirname(__DIR__) . '/includes/admin_footer.php';
}

function adminRedirect(string $url, $success = null)
{
    if ($success !== null) {
        $separador = str_contains($url, '?') ? '&' : '?';
        $url .= $separador . 'success=' . urlencode($success);
    }

    header('Location: ' . $url);
    exit;
}

function adminMensagemSucesso($chave, array $mapa): string
{
    return $mapa[$chave ?? ''] ?? 'OperaÃ§Ã£o realizada com sucesso!';
}

function adminUploadExiste($arquivo): bool
{
    return $arquivo !== null && $arquivo !== '' && file_exists(ADMIN_UPLOAD_DIR . $arquivo);
}

function adminUploadSrc(string $arquivo): string
{
    return adminSiteRoot() . ADMIN_UPLOAD_URL . $arquivo;
}

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// BANCO DE DADOS â€” Prepared Statements
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

function dbFetchOne(mysqli $conn, string $sql, string $types = '', ...$params)
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

function dbFetchAll(mysqli $conn, string $sql, string $types = '', ...$params): array
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

function dbExecute(mysqli $conn, string $sql, string $types = '', ...$params): bool
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


function dbFetchScalar(mysqli $conn, string $sql, string $types = '', ...$params): int
{
    $linha = dbFetchOne($conn, $sql, $types, ...$params);

    return (int) ($linha ? array_values($linha)[0] : 0);
}

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// UPLOAD DE IMAGENS
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

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
        return ['arquivo' => '', 'erro' => 'Formato invÃ¡lido. Use: JPG, PNG, GIF ou WEBP.'];
    }

    if (($arquivo['size'] ?? 0) > ADMIN_UPLOAD_MAX_SIZE) {
        return ['arquivo' => '', 'erro' => 'Arquivo muito grande. MÃ¡ximo 5MB.'];
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

function adminRemoverUpload($arquivo)
{
    if ($arquivo && file_exists(ADMIN_UPLOAD_DIR . $arquivo)) {
        @unlink(ADMIN_UPLOAD_DIR . $arquivo);
    }
}

function adminNivelPercentual(string $nivel): int
{
    $nivelLower = strtolower($nivel);

    if (str_contains($nivelLower, 'expert')) {
        return 95;
    } elseif (str_contains($nivelLower, 'avan')) {
        return 85;
    } elseif (str_contains($nivelLower, 'inter')) {
        return 70;
    } elseif (str_contains($nivelLower, 'bÃ¡s') || str_contains($nivelLower, 'bas')) {
        return 50;
    } else {
        return 60;
    }
}

function adminBadgeNivel(string $nivel): string
{
    return badgeNivelTecnologia($nivel);
}



