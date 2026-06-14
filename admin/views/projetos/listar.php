<?php
// Visualizacao do painel administrativo  ?>
<div class="admin-content">
        <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-black mb-1 fs-3">Projetos</h1>
            <p class="text-muted-custom mb-0 small"><?= (int) $totalCount ?> projeto<?= $totalCount != 1 ? 's' : '' ?> cadastrado<?= $totalCount != 1 ? 's' : '' ?></p>
        </div>
        <a href="<?= adminEsc($adminBase) ?>projetos/criar" class="btn btn-primary-custom btn-custom">
            <i class="bi bi-plus-circle"></i> Novo Projeto
        </a>
    </div>

        <form method="GET" class="mb-4">
        <div class="position-relative" style="max-width:360px;">
            <i class="bi bi-search position-absolute" style="left:1rem;top:50%;transform:translateY(-50%);color:var(--text-muted);"></i>
            <input type="text" name="q" class="form-control form-control-admin"
                   style="padding-left:2.75rem !important;"
                   placeholder="Buscar por título ou tecnologia..."
                   value="<?= adminEsc($search ?? '') ?>">
        </div>
    </form>

    <?php include __DIR__ . '/../partials/alertas.php'; ?>

        <div class="glass rounded-4 p-4 overflow-auto">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Título</th>
                    <th>Tecnologias</th>
                    <th>Destaque</th>
                    <th>Data</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($projetos)): ?>
                    <?php foreach ($projetos as $p): ?>
                    <tr>
                        <td style="width:60px;">
                            <?php if (adminUploadExiste($p['imagem'] ?? '')): ?>
                            <img src="<?= adminEsc(adminUploadSrc($p['imagem'])) ?>"
                                 style="width:48px;height:48px;border-radius:10px;object-fit:cover;border:1px solid var(--border-glass);">
                            <?php else: ?>
                            <div style="width:48px;height:48px;border-radius:10px;background:rgba(124,58,237,0.1);border:1px solid var(--border-glass);display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-image text-muted-custom"></i>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td class="fw-semibold"><?= adminEsc($p['titulo']) ?></td>
                        <td>
                            <?php foreach (array_slice(array_map('trim', explode(',', $p['tecnologias'] ?? '')), 0, 3) as $t): ?>
                                <?php if ($t): ?>
                                <span class="badge me-1" style="background:rgba(124,58,237,0.12);color:#a78bfa;border-radius:6px;font-size:0.72rem;">
                                    <?= adminEsc($t) ?>
                                </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <?php if ($p['destaque']): ?>
                            <span class="badge" style="background:rgba(245,158,11,0.15);color:#fbbf24;border-radius:8px;">
                                <i class="bi bi-star-fill me-1"></i>Sim
                            </span>
                            <?php else: ?>
                            <span class="text-muted-custom small">Não</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-muted-custom small"><?= date('d/m/Y', strtotime($p['created_at'])) ?></td>
                        <td class="text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="<?= adminEsc(urlProjeto($p)) ?>" target="_blank"
                                   class="btn btn-sm" style="background:rgba(6,182,212,0.1);color:#22d3ee;border-radius:8px;padding:0.4rem 0.7rem;" title="Ver no site">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?= adminEsc($adminBase) ?>projetos/editar?id=<?= (int) $p['id'] ?>"
                                   class="btn btn-sm" style="background:rgba(124,58,237,0.1);color:#a78bfa;border-radius:8px;padding:0.4rem 0.7rem;" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button onclick="confirmDelete('<?= adminEsc($adminBase) ?>projetos/excluir?id=<?= (int) $p['id'] ?>', '<?= adminEsc(addslashes($p['titulo'])) ?>')"
                                        class="btn btn-sm" style="background:rgba(239,68,68,0.1);color:#f87171;border-radius:8px;padding:0.4rem 0.7rem;" title="Excluir">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="empty-state">
                                <i class="bi bi-folder-x"></i>
                                <p class="mt-2">Nenhum projeto encontrado.</p>
                                <a href="<?= adminEsc($adminBase) ?>projetos/criar" class="btn btn-primary-custom btn-custom mt-2">
                                    <i class="bi bi-plus-circle"></i> Criar primeiro projeto
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

        <?php if (($totalPages ?? 1) > 1): ?>
    <nav class="mt-4 d-flex justify-content-center">
        <ul class="pagination" style="gap:0.25rem;">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item">
                <a class="page-link <?= $i == $page ? 'active' : '' ?>"
                   href="?page=<?= $i ?>&q=<?= urlencode($search ?? '') ?>"
                   style="background:<?= $i == $page ? 'rgba(124,58,237,0.3)' : 'var(--bg-glass)' ?>;border:1px solid var(--border-glass);color:<?= $i == $page ? '#fff' : 'var(--text-muted)' ?>;border-radius:8px;">
                    <?= $i ?>
                </a>
            </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>


