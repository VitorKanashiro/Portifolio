<?php
// Componente visual global
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

        <title><?= esc($page_title) ?></title>

        <meta name="description" content="<?= esc($page_desc) ?>">

        <meta name="keywords" content="<?= esc($page_keywords) ?>">

        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <link href="<?= $base_url ?>assets/css/style.css" rel="stylesheet">
</head>
<body>


