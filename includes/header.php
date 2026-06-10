<?php
/**
 * includes/header.php
 * Cabeçalho HTML global do site público.
 *
 * SEO básico (variáveis definidas em index.php ou projeto.php):
 *   $page_title    → tag <title>
 *   $page_desc     → meta description
 *   $page_keywords → meta keywords
 */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once dirname(__DIR__) . '/includes/helpers.php';

$base_url = getSiteRoot();
$page_title    = $page_title    ?? 'Portfólio Profissional';
$page_desc     = $page_desc     ?? 'Portfólio de desenvolvedor web com projetos em PHP, MySQL e Bootstrap.';
$page_keywords = $page_keywords ?? 'portfólio, desenvolvedor, PHP, MySQL, Bootstrap, ADS';
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO: título da página (único por página, exibido na aba do navegador) -->
    <title><?= esc($page_title) ?></title>

    <!-- SEO: descrição da página (resumo exibido nos resultados de busca) -->
    <meta name="description" content="<?= esc($page_desc) ?>">

    <!-- SEO: palavras-chave relacionadas ao conteúdo da página -->
    <meta name="keywords" content="<?= esc($page_keywords) ?>">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= $base_url ?>assets/css/style.css" rel="stylesheet">
</head>
<body>
