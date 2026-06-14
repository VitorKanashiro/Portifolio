<?php
// Secao principal do portfolio
$tituloSobre    = $sobre['titulo'] ?? 'Sobre Mim';
$experiencia    = $sobre['experiencia'] ?? '3+';
$projetosCount  = $sobre['projetos_count'] ?? '20+';
?>
<section id="sobre" class="py-5" style="background: linear-gradient(to bottom, #0a0a0f, #0d0d1a);" aria-labelledby="sobre-titulo">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-5 text-center reveal">
                <div class="position-relative d-inline-block">
                    <div style="width: 300px; height: 300px; border-radius: 30px; background: rgba(124,58,237,0.08); border: 1px solid rgba(124,58,237,0.2); display: flex; align-items: center; justify-content: center; margin: 0 auto; overflow: hidden;">
                        <?php if (!empty($sobre['foto']) && uploadExiste($sobre['foto'])): ?>
                            <img src="<?= esc(uploadUrl($sobre['foto'])) ?>"
                                 alt="Foto de <?= esc($nome ?? $tituloSobre) ?>"
                                 title="Foto de <?= esc($nome ?? $tituloSobre) ?>"
                                 loading="lazy"
                                 width="300" height="300"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <i class="bi bi-person-workspace" style="font-size: 8rem; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;" aria-hidden="true"></i>
                        <?php endif; ?>
                    </div>
                    <div class="position-absolute" style="top: -15px; right: -15px; background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); border-radius: 12px; padding: 0.5rem 0.75rem; font-size: 0.8rem; color: #34d399; white-space: nowrap;">
                        <i class="bi bi-check-circle-fill me-1" aria-hidden="true"></i><?= esc($experiencia) ?> Anos Exp.
                    </div>
                    <div class="position-absolute" style="bottom: -15px; left: -15px; background: rgba(124,58,237,0.15); border: 1px solid rgba(124,58,237,0.3); border-radius: 12px; padding: 0.5rem 0.75rem; font-size: 0.8rem; color: #a78bfa; white-space: nowrap;">
                        <i class="bi bi-briefcase-fill me-1" aria-hidden="true"></i><?= esc($projetosCount) ?> Projetos
                    </div>
                </div>
            </div>

            <div class="col-lg-7 reveal delay-2">
                <h2 id="sobre-titulo" class="section-title mb-4"><?= esc($tituloSobre) ?></h2>
                <p class="fs-5 text-muted-custom mb-3" style="line-height: 1.8;">
                    <?= nl2br(esc($sobre['descricao'] ?? '')) ?>
                </p>
                <?php if (!empty($sobre['biografia'])): ?>
                <p class="text-muted-custom mb-4" style="line-height: 1.8;">
                    <?= nl2br(esc($sobre['biografia'])) ?>
                </p>
                <?php endif; ?>
                <?php if (!empty($sobre['objetivos'])): ?>
                <div class="glass p-4 rounded-4 mb-4">
                    <h3 class="text-gradient fw-bold mb-2 fs-6"><i class="bi bi-target me-2" aria-hidden="true"></i>Objetivos</h3>
                    <p class="text-muted-custom mb-0"><?= nl2br(esc($sobre['objetivos'])) ?></p>
                </div>
                <?php endif; ?>

                <div class="d-flex gap-4 flex-wrap mt-4">
                    <div class="text-center">
                        <div class="fw-black" style="font-size: 2rem; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;"
                             data-count="<?= extrairNumeroExperiencia($experiencia) ?>" data-suffix="+">0</div>
                        <div style="font-size: 0.78rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Anos de Experiência</div>
                    </div>
                    <div style="width: 1px; background: var(--border-glass);" aria-hidden="true"></div>
                    <div class="text-center">
                        <div class="fw-black" style="font-size: 2rem; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;"
                             data-count="<?= count($projetos) ?>" data-suffix="+">0</div>
                        <div style="font-size: 0.78rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Projetos Criados</div>
                    </div>
                    <div style="width: 1px; background: var(--border-glass);" aria-hidden="true"></div>
                    <div class="text-center">
                        <div class="fw-black" style="font-size: 2rem; background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;"
                             data-count="<?= count($tecnologias) ?>" data-suffix="+">0</div>
                        <div style="font-size: 0.78rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Tecnologias</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


