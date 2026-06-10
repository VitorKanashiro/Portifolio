<?php
/**
 * sections/hero.php — Seção Hero (apresentação principal)
 * Variáveis: $nome, $cargo, $sub, $github, $linkedin, $foto
 */
?>
<!-- SEO: seção principal — contém o único H1 desta página -->
<section id="home" class="hero-section position-relative" aria-label="Apresentação">
    <canvas id="particles-canvas" style="position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none;" aria-hidden="true"></canvas>

    <div class="container position-relative" style="z-index: 1;">
        <div class="row align-items-center min-vh-100 py-5">
            <div class="col-lg-7 col-md-6 text-center text-md-start order-2 order-md-1 mt-4 mt-md-0">
                <span class="badge mb-3 py-2 px-3" style="background: rgba(124,58,237,0.2); border: 1px solid rgba(124,58,237,0.4); color: #a78bfa; border-radius: 50px; font-size: 0.8rem; letter-spacing: 1px;">
                    <i class="bi bi-circle-fill me-2" style="color: #10b981; font-size: 0.5rem;" aria-hidden="true"></i>
                    Disponível para projetos
                </span>

                <p class="text-muted mb-2 fw-semibold" style="letter-spacing: 2px; font-size: 0.85rem; text-transform: uppercase;">
                    Olá, eu sou
                </p>
                <!-- SEO: título principal da página (apenas um H1 por página) -->
                <h1 class="display-3 fw-black mb-3 lh-sm">
                    <?= esc($nome) ?><br>
                    <span class="text-gradient"><?= esc($cargo) ?></span>
                </h1>
                <p class="lead text-muted-custom mb-5 fs-5" style="max-width: 520px;">
                    <?= esc($sub) ?>
                </p>

                <div class="d-flex gap-3 flex-wrap justify-content-center justify-content-md-start">
                    <a href="#projetos" class="btn btn-primary-custom btn-custom btn-lg">
                        <i class="bi bi-briefcase-fill" aria-hidden="true"></i> Ver Projetos
                    </a>
                    <?php if ($github && $github !== '#'): ?>
                    <a href="<?= esc($github) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-custom btn-custom btn-lg">
                        <i class="bi bi-github" aria-hidden="true"></i> GitHub
                    </a>
                    <?php endif; ?>
                    <?php if ($linkedin && $linkedin !== '#'): ?>
                    <a href="<?= esc($linkedin) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-custom btn-custom btn-lg">
                        <i class="bi bi-linkedin" aria-hidden="true"></i> LinkedIn
                    </a>
                    <?php endif; ?>
                </div>

                <div class="mt-5 d-none d-md-flex align-items-center gap-2" style="color: var(--text-muted-dark); font-size: 0.8rem;">
                    <div style="width: 1px; height: 30px; background: linear-gradient(to bottom, transparent, var(--text-muted-dark));" aria-hidden="true"></div>
                    Scroll para explorar
                </div>
            </div>

            <div class="col-lg-5 col-md-6 text-center order-1 order-md-2">
                <div class="position-relative d-inline-block">
                    <div style="position: absolute; inset: -20px; border-radius: 50%; border: 1px solid rgba(124,58,237,0.2); animation: pulse-ring 3s ease infinite;" aria-hidden="true"></div>
                    <div style="position: absolute; inset: -40px; border-radius: 50%; border: 1px solid rgba(124,58,237,0.08); animation: pulse-ring 3s ease infinite 1s;" aria-hidden="true"></div>

                    <?php if (!empty($foto) && uploadExiste($foto)): ?>
                        <img src="<?= esc(uploadUrl($foto)) ?>"
                             alt="Foto de <?= esc($nome) ?>"
                             title="Foto de <?= esc($nome) ?>"
                             class="hero-avatar"
                             width="320" height="320">
                    <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($nome) ?>&size=512&background=7c3aed&color=fff&bold=true"
                             alt="Avatar de <?= esc($nome) ?>"
                             title="<?= esc($nome) ?> — <?= esc($cargo) ?>"
                             class="hero-avatar"
                             width="320" height="320">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes pulse-ring {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.05); opacity: 1; }
}
</style>
