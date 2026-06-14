<?php
// Componente do admin
$paginaAtual = basename($_SERVER['PHP_SELF']);
$diretorioAtual = basename(dirname($_SERVER['PHP_SELF']));
$urlAdmin = $adminBase ?? adminWebPath();
?>
<div class="sidebar-overlay" id="sidebar-overlay"></div>

<aside class="admin-sidebar" id="sidebar" aria-label="Menu administrativo">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <i class="bi bi-code-slash" aria-hidden="true"></i>
        </div>
        <div>
            <div class="fw-bold text-white" style="font-size: 0.95rem; line-height: 1.2;">Admin Panel</div>
            <div style="font-size: 0.75rem; color: var(--text-muted);">Portfólio</div>
        </div>
    </div>

    <nav class="d-flex flex-column gap-1">
        <div class="sidebar-section-label">Principal</div>

        <a href="<?= adminEsc($urlAdmin) ?>dashboard"
           class="sidebar-link <?= ($paginaAtual === 'dashboard.php') ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2-fill" aria-hidden="true"></i>
            <span>Dashboard</span>
        </a>

        <div class="sidebar-section-label">Conteúdo</div>

        <a href="<?= adminEsc($urlAdmin) ?>projetos"
           class="sidebar-link <?= ($diretorioAtual === 'projetos') ? 'active' : '' ?>">
            <i class="bi bi-folder2-open" aria-hidden="true"></i>
            <span>Projetos</span>
        </a>

        <a href="<?= adminEsc($urlAdmin) ?>tecnologias"
           class="sidebar-link <?= ($diretorioAtual === 'tecnologias') ? 'active' : '' ?>">
            <i class="bi bi-cpu" aria-hidden="true"></i>
            <span>Tecnologias</span>
        </a>

        <div class="sidebar-section-label">Perfil</div>

        <a href="<?= adminEsc($urlAdmin) ?>perfil"
           class="sidebar-link <?= ($diretorioAtual === 'perfil') ? 'active' : '' ?>">
            <i class="bi bi-person-badge-fill" aria-hidden="true"></i>
            <span>Perfil / Hero</span>
        </a>

        <a href="<?= adminEsc($urlAdmin) ?>sobre"
           class="sidebar-link <?= ($diretorioAtual === 'sobre') ? 'active' : '' ?>">
            <i class="bi bi-person-lines-fill" aria-hidden="true"></i>
            <span>Sobre Mim</span>
        </a>

        <a href="<?= adminEsc($urlAdmin) ?>redes"
           class="sidebar-link <?= ($diretorioAtual === 'redes') ? 'active' : '' ?>">
            <i class="bi bi-share-fill" aria-hidden="true"></i>
            <span>Redes Sociais</span>
        </a>

        <a href="<?= adminEsc($urlAdmin) ?>contato"
           class="sidebar-link <?= ($diretorioAtual === 'contato') ? 'active' : '' ?>">
            <i class="bi bi-envelope-fill" aria-hidden="true"></i>
            <span>Contato</span>
        </a>

        <a href="<?= adminEsc($urlAdmin) ?>mensagens"
           class="sidebar-link <?= ($diretorioAtual === 'mensagens') ? 'active' : '' ?>">
            <i class="bi bi-inbox-fill" aria-hidden="true"></i>
            <span>Mensagens</span>
        </a>

        <div class="sidebar-section-label">Sistema</div>

        <a href="<?= adminEsc($baseUrl) ?>" target="_blank" class="sidebar-link">
            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
            <span>Ver Site</span>
        </a>

        <a href="<?= adminEsc($urlAdmin) ?>auth/logout" class="sidebar-link mt-2"
           style="color: #f87171; border: 1px solid rgba(239,68,68,0.2);"
           onmouseover="this.style.background='rgba(239,68,68,0.1)'; this.style.borderColor='rgba(239,68,68,0.4)';"
           onmouseout="this.style.background=''; this.style.borderColor='rgba(239,68,68,0.2)';">
            <i class="bi bi-box-arrow-left" aria-hidden="true"></i>
            <span>Sair</span>
        </a>
    </nav>
</aside>


