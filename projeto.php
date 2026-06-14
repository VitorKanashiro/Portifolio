<?php
// Pagina de detalhes do projeto
require_once 'config/conexao.php';
require_once 'includes/helpers.php';
require_once 'controllers/PortfolioController.php';

$portfolio   = new PortfolioController($conn);
$homeUrl     = siteUrl('');
$projetosUrl = $homeUrl . '#projetos';

$slug = trim($_GET['slug'] ?? '');
$id   = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($slug !== '') {
    $projeto = $portfolio->buscarProjetoPorSlug($slug);
} elseif ($id) {
    $projeto = $portfolio->buscarProjetoPorId($id);
} else {
    header('Location: ' . $projetosUrl);
    exit;
}

if (!$projeto) {
    header('Location: ' . $projetosUrl);
    exit;
}

if ($id && $slug === '') {
    header('Location: ' . urlProjeto($projeto), true, 301);
    exit;
}

$perfil      = $portfolio->buscarPerfil();
$dadosPerfil = $portfolio->normalizarPerfil($perfil);
$redes       = $portfolio->buscarRedesSociais();

extract($dadosPerfil);
extract($portfolio->seoPaginaProjeto($projeto, $perfil));

$nav_home_url = $homeUrl;
$nav_modo     = 'interno';
$nav_active   = 'projetos';

$tecnologias = array_values(array_filter(array_map('trim', explode(',', $projeto['tecnologias'] ?? ''))));
$temImagem   = !empty($projeto['imagem']) && uploadExiste($projeto['imagem']);

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div style="min-height: 55vh; background: linear-gradient(135deg, #0a0a0f 0%, #0f0a1e 60%, #0a1628 100%); display: flex; align-items: flex-end; padding-top: 80px; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -20%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(124,58,237,0.15) 0%, transparent 70%); border-radius: 50%;"></div>

    <?php if ($temImagem): ?>
    <div style="position: absolute; inset: 0; z-index: 0;">
        <img src="<?= esc(uploadUrl($projeto['imagem'])) ?>" alt="" style="width:100%; height:100%; object-fit: cover; opacity: 0.15;">
        <div style="position: absolute; inset: 0; background: linear-gradient(to top, #0a0a0f 30%, transparent);"></div>
    </div>
    <?php endif; ?>

    <div class="container pb-5 position-relative" style="z-index: 1;">
        <a href="<?= esc($projetosUrl) ?>" class="btn btn-outline-custom btn-custom mb-4 animate-fadeIn" style="font-size: 0.85rem; padding: 0.5rem 1rem;">
            <i class="bi bi-arrow-left"></i> Voltar aos Projetos
        </a>
        <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
            <?php if ($projeto['destaque']): ?>
            <span class="badge animate-fadeIn delay-1" style="background: rgba(124,58,237,0.3); border: 1px solid rgba(124,58,237,0.5); color: #a78bfa; border-radius: 8px; padding: 0.4rem 0.8rem;">
                <i class="bi bi-star-fill me-1"></i>Destaque
            </span>
            <?php endif; ?>
        </div>
        <h1 class="display-4 fw-black mb-3 animate-fadeInUp delay-1"><?= esc($projeto['titulo']) ?></h1>
        <div class="d-flex gap-2 flex-wrap animate-fadeInUp delay-2">
            <?php foreach ($tecnologias as $t): ?>
                <?php if ($t): ?>
                <span class="tech-badge"><?= esc($t) ?></span>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<section style="background: var(--bg-dark); padding: 4rem 0 6rem;">
    <div class="container">
        <div class="row g-5">
                        <div class="col-lg-8">
                <?php if ($temImagem): ?>
                <div class="mb-5 animate-fadeInUp delay-2">
                    <img src="<?= esc(uploadUrl($projeto['imagem'])) ?>"
                         alt="<?= esc($projeto['titulo']) ?>"
                         style="width: 100%; border-radius: 20px; border: 1px solid var(--border-glass); box-shadow: var(--shadow-card);">
                </div>
                <?php endif; ?>

                <div class="glass p-4 rounded-4 animate-fadeInUp delay-3">
                    <h3 class="fw-bold mb-4 text-gradient">Sobre o Projeto</h3>
                    <p class="text-muted-custom fs-5" style="line-height: 1.9;">
                        <?= nl2br(esc($projeto['descricao'])) ?>
                    </p>
                </div>
            </div>

                        <div class="col-lg-4">
                <div class="glass p-4 rounded-4 sticky-top animate-fadeInUp delay-3" style="top: 100px; z-index: 10;">
                    <h5 class="fw-bold mb-4 text-gradient">Detalhes</h5>

                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom: 1px solid var(--border-glass);">
                            <span class="text-muted-custom small text-uppercase" style="letter-spacing: 0.5px;">Adicionado em</span>
                            <span class="fw-semibold"><?= date('d/m/Y', strtotime($projeto['created_at'])) ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-start py-2" style="border-bottom: 1px solid var(--border-glass);">
                            <span class="text-muted-custom small text-uppercase" style="letter-spacing: 0.5px;">Tecnologias</span>
                            <div class="d-flex flex-wrap gap-1 justify-content-end" style="max-width: 65%;">
                                <?php foreach (array_slice($tecnologias, 0, 5) as $t): ?>
                                    <?php if ($t): ?>
                                    <span class="badge" style="background: rgba(124,58,237,0.15); color: #a78bfa; border: 1px solid rgba(124,58,237,0.3); border-radius: 8px; font-size: 0.75rem;"><?= esc($t) ?></span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-3 mt-4">
                        <?php if (!empty($projeto['github'])): ?>
                        <a href="<?= esc($projeto['github']) ?>" target="_blank" rel="noopener noreferrer"
                           class="btn btn-primary-custom btn-custom w-100">
                            <i class="bi bi-github"></i> Ver no GitHub
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($projeto['demo'])): ?>
                        <a href="<?= esc($projeto['demo']) ?>" target="_blank" rel="noopener noreferrer"
                           class="btn btn-outline-custom btn-custom w-100">
                            <i class="bi bi-box-arrow-up-right"></i> Ver Demo
                        </a>
                        <?php endif; ?>
                        <a href="<?= esc($projetosUrl) ?>" class="btn btn-outline-custom btn-custom w-100">
                            <i class="bi bi-arrow-left"></i> Mais Projetos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>


