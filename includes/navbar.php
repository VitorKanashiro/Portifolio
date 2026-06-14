<?php
// Componente visual global
require_once dirname(__DIR__) . '/includes/helpers.php';

$navModo    = $nav_modo ?? 'home';
$navActive  = $nav_active ?? '';
$homeUrl    = siteUrl('');
$navHomeUrl = $nav_home_url ?? ($navModo === 'interno' ? $homeUrl : '#home');
$prefixo    = ($navModo === 'interno') ? $homeUrl : '';

$navItems = [
    'home'         => ['label' => 'Home',         'href' => $prefixo . '#home'],
    'sobre'        => ['label' => 'Sobre',        'href' => $prefixo . '#sobre'],
    'tecnologias'  => ['label' => 'Tecnologias',  'href' => $prefixo . '#tecnologias'],
    'projetos'     => ['label' => 'Projetos',     'href' => $prefixo . '#projetos'],
    'contato'      => ['label' => 'Contato',      'href' => $prefixo . '#contato'],
];
?>
<header>
    <nav class="navbar navbar-expand-lg fixed-top glass-nav" id="mainNav" aria-label="Navegação principal">
        <div class="container">
            <a class="navbar-brand text-gradient" href="<?= esc($navHomeUrl) ?>">
                &lt;<?= esc($nome) ?>/&gt;
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Abrir menu de navegação">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-lg-3 py-3 py-lg-0">
                    <?php foreach ($navItems as $key => $item): ?>
                    <li class="nav-item">
                        <a class="nav-link<?= $navActive === $key ? ' active' : '' ?>"
                           href="<?= esc($item['href']) ?>"><?= esc($item['label']) ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>


