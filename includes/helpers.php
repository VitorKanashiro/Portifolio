<?php
/**
 * includes/helpers.php
 * Funções auxiliares reutilizáveis em todo o portfólio público.
 * Centraliza lógica comum para facilitar manutenção por estudantes de ADS.
 */

/**
 * Escapa texto para exibição segura em HTML (previne XSS).
 */
function esc(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

/**
 * Retorna o caminho web absoluto até a raiz do projeto (ex: /portifolio-1/).
 */
function getSiteRoot(): string
{
    static $root = null;

    if ($root !== null) {
        return $root;
    }

    $docRoot     = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/'));
    $projectRoot = str_replace('\\', '/', realpath(dirname(__DIR__)) ?: dirname(__DIR__));

    if ($docRoot !== '' && str_starts_with($projectRoot, $docRoot)) {
        $root = '/' . trim(substr($projectRoot, strlen($docRoot)), '/') . '/';
        return $root;
    }

    $root = '/';
    return $root;
}

/**
 * Monta URL absoluta a partir da raiz do site.
 */
function siteUrl(string $path = ''): string
{
    if ($path === '' || $path === '/') {
        return getSiteRoot();
    }

    return getSiteRoot() . ltrim($path, '/');
}

/**
 * Converte um título em slug amigável para URLs.
 * Ex: "Sistema de Portfólio" → "sistema-de-portfolio"
 */
function gerarSlug(string $texto): string
{
    $texto = mb_strtolower($texto, 'UTF-8');
    $texto = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $texto) ?: $texto;
    $texto = preg_replace('/[^a-z0-9]+/', '-', $texto) ?? '';
    $texto = trim($texto, '-');

    return $texto !== '' ? $texto : 'projeto';
}

/**
 * Gera slug único para um projeto (título + id para evitar duplicatas).
 */
function gerarSlugProjeto(array $projeto): string
{
    $slugBase = gerarSlug($projeto['titulo'] ?? 'projeto');

    return $slugBase . '-' . ($projeto['id'] ?? 0);
}

/**
 * Retorna URL amigável do projeto (ex: /portifolio-1/projeto/sistema-de-portfolio-1).
 */
function urlProjeto(array $projeto): string
{
    return siteUrl('projeto/' . gerarSlugProjeto($projeto));
}

/**
 * Verifica se um arquivo de upload existe no servidor.
 */
function uploadExiste(string $arquivo): bool
{
    if ($arquivo === '') {
        return false;
    }

    return file_exists(dirname(__DIR__) . '/assets/uploads/' . $arquivo);
}

/**
 * Retorna o caminho relativo da imagem de upload.
 */
function uploadUrl(string $arquivo): string
{
    return siteUrl('assets/uploads/' . $arquivo);
}

/**
 * Retorna classe CSS do badge de nível da tecnologia.
 */
function badgeNivelTecnologia(string $nivel): string
{
    $nivelLower = strtolower($nivel);

    return match (true) {
        str_contains($nivelLower, 'expert')   => 'badge-expert',
        str_contains($nivelLower, 'avan')   => 'badge-avancado',
        str_contains($nivelLower, 'inter')    => 'badge-intermediario',
        default                               => 'badge-iniciante',
    };
}

/**
 * Extrai anos numéricos de um texto de experiência (ex: "3+" → 3).
 */
function extrairNumeroExperiencia(string $experiencia): int
{
    $numero = (int) preg_replace('/\D/', '', $experiencia);

    return $numero > 0 ? $numero : 3;
}
