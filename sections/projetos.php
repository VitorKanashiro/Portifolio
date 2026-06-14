<?php
// Secao principal do portfolio
$tecnologiasFiltro = $tecnologias_projeto ?? [];
?>
<section id="projetos" class="py-5" style="background: linear-gradient(to bottom, #0a0a0f, #0a0f1e);" aria-labelledby="projetos-titulo">
    <div class="container py-5">
        <div class="text-center mb-5 reveal">
            <h2 id="projetos-titulo" class="section-title mx-auto">Projetos</h2>
            <p class="text-muted-custom mt-4">Algumas das soluÃ§Ãµes que desenvolvi</p>
        </div>

        <div class="d-flex flex-wrap gap-3 justify-content-center align-items-center mb-5 reveal">
            <div class="position-relative">
                <i class="bi bi-search position-absolute" style="left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);" aria-hidden="true"></i>
                <label for="project-search" class="visually-hidden">Buscar projeto</label>
                <input type="text" id="project-search" class="form-control-custom"
                       style="padding-left: 2.5rem !important; min-width: 240px;"
                       placeholder="Buscar projeto...">
            </div>
            <div class="d-flex gap-2 flex-wrap justify-content-center" role="group" aria-label="Filtrar projetos por tecnologia">
                <button class="filter-btn active" data-filter="all">Todos</button>
                <?php foreach ($tecnologiasFiltro as $tech): ?>
                <button class="filter-btn" data-filter="<?= esc($tech) ?>"><?= esc($tech) ?></button>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if (!empty($projetos)): ?>
        <div class="row g-4" id="projects-grid">
            <?php foreach ($projetos as $indice => $projeto): ?>
            <div class="col-lg-4 col-md-6 project-item reveal delay-<?= ($indice % 4) + 1 ?>"
                 data-tech="<?= esc($projeto['tecnologias'] ?? '') ?>">
                <article class="card project-card glass border-0 h-100">
                    <div class="project-img-wrapper">
                        <?php if (!empty($projeto['imagem']) && uploadExiste($projeto['imagem'])): ?>
                            <img src="<?= esc(uploadUrl($projeto['imagem'])) ?>"
                                 class="project-img"
                                 alt="Projeto <?= esc($projeto['titulo']) ?>"
                                 title="Projeto <?= esc($projeto['titulo']) ?>"
                                 loading="lazy"
                                 width="400" height="225">
                        <?php else: ?>
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center"
                                 style="background: linear-gradient(135deg, rgba(124,58,237,0.15), rgba(6,182,212,0.1));"
                                 role="img"
                                 aria-label="Imagem placeholder do projeto <?= esc($projeto['titulo']) ?>">
                                <i class="bi bi-window-stack" style="font-size: 4rem; color: rgba(124,58,237,0.4);" aria-hidden="true"></i>
                            </div>
                        <?php endif; ?>
                        <?php if ($projeto['destaque']): ?>
                        <span class="position-absolute top-0 end-0 m-3 badge"
                              style="background: rgba(124,58,237,0.8); border-radius: 8px; font-size: 0.72rem;">
                            <i class="bi bi-star-fill me-1" aria-hidden="true"></i>Destaque
                        </span>
                        <?php endif; ?>
                    </div>

                    <div class="card-body p-4 d-flex flex-column">
                        <h3 class="card-title fw-bold text-white mb-2 fs-5"><?= esc($projeto['titulo']) ?></h3>
                        <p class="card-text text-muted-custom mb-3 flex-grow-1"
                           style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.6;">
                            <?= esc($projeto['descricao']) ?>
                        </p>

                        <div class="mb-3">
                            <?php foreach (array_slice(array_map('trim', explode(',', $projeto['tecnologias'] ?? '')), 0, 4) as $tech): ?>
                                <?php if ($tech): ?>
                                <span class="tech-badge" style="font-size: 0.75rem; margin: 0.15rem;">
                                    <i class="bi bi-dot" aria-hidden="true"></i><?= esc($tech) ?>
                                </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>

                        <div class="d-flex gap-2 mt-auto">
                            <a href="<?= esc($portfolio->urlProjeto($projeto)) ?>" class="btn btn-primary-custom btn-custom flex-fill" style="padding: 0.6rem 1rem; font-size: 0.85rem;">
                                <i class="bi bi-eye" aria-hidden="true"></i> Detalhes
                            </a>
                            <?php if (!empty($projeto['github'])): ?>
                            <a href="<?= esc($projeto['github']) ?>" target="_blank" rel="noopener noreferrer"
                               class="btn btn-outline-custom btn-custom flex-fill" style="padding: 0.6rem 1rem; font-size: 0.85rem;">
                                <i class="bi bi-github" aria-hidden="true"></i> RepositÃ³rio
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty-state reveal">
            <i class="bi bi-folder-x" aria-hidden="true"></i>
            <p class="fs-5">Nenhum projeto cadastrado ainda.</p>
            <small>Acesse o painel admin para adicionar projetos.</small>
        </div>
        <?php endif; ?>
    </div>
</section>


