<?php
// Componente visual global

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

function esc(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

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

function siteUrl(string $path = ''): string
{
    if ($path === '' || $path === '/') {
        return getSiteRoot();
    }

    return getSiteRoot() . ltrim($path, '/');
}

function gerarSlug(string $texto): string
{
    $texto = mb_strtolower($texto, 'UTF-8');
    $texto = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $texto) ?: $texto;
    $texto = preg_replace('/[^a-z0-9]+/', '-', $texto) ?? '';
    $texto = trim($texto, '-');

    return $texto !== '' ? $texto : 'projeto';
}

function gerarSlugProjeto(array $projeto): string
{
    $slugBase = gerarSlug($projeto['titulo'] ?? 'projeto');

    return $slugBase . '-' . ($projeto['id'] ?? 0);
}

function urlProjeto(array $projeto): string
{
    return siteUrl('projeto/' . gerarSlugProjeto($projeto));
}

function uploadExiste(string $arquivo): bool
{
    if ($arquivo === '') {
        return false;
    }

    return file_exists(dirname(__DIR__) . '/assets/uploads/' . $arquivo);
}

function uploadUrl(string $arquivo): string
{
    return siteUrl('assets/uploads/' . $arquivo);
}

function badgeNivelTecnologia(string $nivel): string
{
    $nivelLower = strtolower($nivel);

    if (str_contains($nivelLower, 'expert')) {
        return 'badge-expert';
    } elseif (str_contains($nivelLower, 'avan')) {
        return 'badge-avancado';
    } elseif (str_contains($nivelLower, 'inter')) {
        return 'badge-intermediario';
    } else {
        return 'badge-iniciante';
    }
}

function extrairNumeroExperiencia(string $experiencia): int
{
    $numero = (int) preg_replace('/\D/', '', $experiencia);

    return $numero > 0 ? $numero : 3;
}


