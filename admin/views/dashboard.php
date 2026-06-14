<?php
// Visualizacao do painel administrativo  ?>
<div class="admin-content" id="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-black mb-1 fs-3">Dashboard</h1>
            <p class="text-muted-custom mb-0 small">
                Bem-vindo, <strong style="color: var(--primary-light);"><?= adminEsc($admin_email) ?></strong>
                &nbsp;·&nbsp; <?= date('d \d\e F \d\e Y') ?>
            </p>
        </div>
        <a href="<?= adminEsc($baseUrl) ?>" target="_blank" class="btn btn-outline-custom btn-custom d-none d-md-flex" style="font-size:0.85rem;padding:0.5rem 1rem;">
            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i> Ver Site
        </a>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-sm-6 col-xl-3">
            <a href="<?= adminEsc($adminBase) ?>projetos" class="text-decoration-none">
                <div class="stat-card h-100" style="border-left: 3px solid #7c3aed;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted-custom small mb-1 text-uppercase" style="letter-spacing:0.5px;">Projetos</p>
                            <h2 class="fw-black mb-0" style="font-size:2.2rem;"><?= (int) $total_projetos ?></h2>
                        </div>
                        <div class="stat-icon" style="background:rgba(124,58,237,0.15);color:#a78bfa;"><i class="bi bi-folder2-open" aria-hidden="true"></i></div>
                    </div>
                    <p class="text-muted-custom mb-0 small"><i class="bi bi-arrow-right me-1" aria-hidden="true"></i>Gerenciar projetos</p>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="<?= adminEsc($adminBase) ?>tecnologias" class="text-decoration-none">
                <div class="stat-card h-100" style="border-left: 3px solid #06b6d4;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted-custom small mb-1 text-uppercase" style="letter-spacing:0.5px;">Tecnologias</p>
                            <h2 class="fw-black mb-0" style="font-size:2.2rem;"><?= (int) $total_tecnologias ?></h2>
                        </div>
                        <div class="stat-icon" style="background:rgba(6,182,212,0.15);color:#22d3ee;"><i class="bi bi-cpu" aria-hidden="true"></i></div>
                    </div>
                    <p class="text-muted-custom mb-0 small"><i class="bi bi-arrow-right me-1" aria-hidden="true"></i>Gerenciar tecnologias</p>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="<?= adminEsc($adminBase) ?>redes" class="text-decoration-none">
                <div class="stat-card h-100" style="border-left: 3px solid #10b981;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted-custom small mb-1 text-uppercase" style="letter-spacing:0.5px;">Redes Sociais</p>
                            <h2 class="fw-black mb-0" style="font-size:2.2rem;"><?= (int) $total_redes ?></h2>
                        </div>
                        <div class="stat-icon" style="background:rgba(16,185,129,0.15);color:#34d399;"><i class="bi bi-share-fill" aria-hidden="true"></i></div>
                    </div>
                    <p class="text-muted-custom mb-0 small"><i class="bi bi-arrow-right me-1" aria-hidden="true"></i>Gerenciar redes</p>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3">
            <a href="<?= adminEsc($adminBase) ?>mensagens" class="text-decoration-none">
                <div class="stat-card h-100" style="border-left: 3px solid #f59e0b;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted-custom small mb-1 text-uppercase" style="letter-spacing:0.5px;">Mensagens</p>
                            <h2 class="fw-black mb-0" style="font-size:2.2rem;"><?= (int) $total_mensagens ?></h2>
                        </div>
                        <div class="stat-icon" style="background:rgba(245,158,11,0.15);color:#fbbf24;"><i class="bi bi-envelope-fill" aria-hidden="true"></i></div>
                    </div>
                    <p class="text-muted-custom mb-0 small">
                        <?= $total_mensagens > 0 ? '<span style="color:#fbbf24;">Não lidas</span>' : 'Nenhuma nova mensagem' ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <div class="row g-3 mb-5">
        <div class="col-12"><h2 class="fw-bold mb-3 text-muted-custom small text-uppercase" style="letter-spacing:1px;">Ações Rápidas</h2></div>
        <div class="col-6 col-md-3"><a href="<?= adminEsc($adminBase) ?>projetos/criar" class="btn btn-primary-custom btn-custom w-100"><i class="bi bi-plus-circle" aria-hidden="true"></i><br><small>Novo Projeto</small></a></div>
        <div class="col-6 col-md-3"><a href="<?= adminEsc($adminBase) ?>tecnologias/criar" class="btn btn-outline-custom btn-custom w-100"><i class="bi bi-cpu" aria-hidden="true"></i><br><small>Nova Tecnologia</small></a></div>
        <div class="col-6 col-md-3"><a href="<?= adminEsc($adminBase) ?>perfil" class="btn btn-outline-custom btn-custom w-100"><i class="bi bi-person-badge" aria-hidden="true"></i><br><small>Editar Perfil</small></a></div>
        <div class="col-6 col-md-3"><a href="<?= adminEsc($adminBase) ?>redes/criar" class="btn btn-outline-custom btn-custom w-100"><i class="bi bi-share" aria-hidden="true"></i><br><small>Nova Rede Social</small></a></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="glass rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold mb-0 fs-5">Projetos Recentes</h2>
                    <a href="<?= adminEsc($adminBase) ?>projetos" class="btn btn-outline-custom btn-custom" style="font-size:0.8rem;padding:0.4rem 0.9rem;">Ver Todos <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark-custom mb-0">
                        <thead><tr><th>#</th><th>Título</th><th>Tecnologias</th><th>Data</th><th></th></tr></thead>
                        <tbody>
                            <?php if (!empty($projetos_recentes)): ?>
                                <?php foreach ($projetos_recentes as $p): ?>
                                <tr>
                                    <td class="text-muted-custom"><?= (int) $p['id'] ?></td>
                                    <td class="fw-semibold"><?= adminEsc($p['titulo']) ?></td>
                                    <td><span class="badge" style="background:rgba(124,58,237,0.15);color:#a78bfa;border-radius:8px;font-size:0.72rem;"><?= adminEsc(substr($p['tecnologias'] ?? '', 0, 25)) ?></span></td>
                                    <td class="text-muted-custom small"><?= date('d/m/Y', strtotime($p['created_at'])) ?></td>
                                    <td><a href="<?= adminEsc($adminBase) ?>projetos/editar?id=<?= (int) $p['id'] ?>" class="btn btn-sm" style="background:rgba(124,58,237,0.15);color:#a78bfa;border-radius:8px;"><i class="bi bi-pencil" aria-hidden="true"></i></a></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center text-muted-custom py-4">Nenhum projeto encontrado.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="glass rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold mb-0 fs-5">Mensagens Recentes</h2>
                    <?php if ($total_mensagens > 0): ?>
                    <span class="badge" style="background:rgba(245,158,11,0.2);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);border-radius:8px;"><?= (int) $total_mensagens ?> nova<?= $total_mensagens > 1 ? 's' : '' ?></span>
                    <?php endif; ?>
                </div>
                <?php if (!empty($mensagens_recentes)): ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($mensagens_recentes as $msg): ?>
                        <div class="p-3 rounded-3 <?= !$msg['lida'] ? 'glass' : '' ?>" style="border: 1px solid var(--border-glass);">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="fw-semibold small"><?= adminEsc($msg['nome']) ?></span>
                                <span class="text-muted-custom" style="font-size:0.72rem;"><?= date('d/m', strtotime($msg['created_at'])) ?></span>
                            </div>
                            <p class="text-muted-custom mb-0" style="font-size:0.82rem; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical;"><?= adminEsc($msg['mensagem']) ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state py-4"><i class="bi bi-inbox" style="font-size:2.5rem;" aria-hidden="true"></i><p class="mt-2 mb-0 small">Nenhuma mensagem recebida.</p></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


