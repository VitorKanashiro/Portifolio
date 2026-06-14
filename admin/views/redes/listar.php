<?php
// Visualizacao do painel administrativo  ?>
<div class="admin-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-black mb-1 fs-3">Redes Sociais</h1>
            <p class="text-muted-custom mb-0 small"><?= count($redes) ?> rede<?= count($redes) != 1 ? 's' : '' ?> cadastrada<?= count($redes) != 1 ? 's' : '' ?></p>
        </div>
        <a href="<?= adminEsc($adminBase) ?>redes/criar.php" class="btn btn-primary-custom btn-custom">
            <i class="bi bi-plus-circle"></i> Nova Rede
        </a>
    </div>

    <?php include __DIR__ . '/../partials/alertas.php'; ?>

        <?php if (!empty($redes)): ?>
    <div class="row g-4">
        <?php foreach ($redes as $r): ?>
        <div class="col-sm-6 col-md-4 col-xl-3">
            <div class="glass rounded-4 p-4 text-center h-100" style="transition: var(--transition); <?= !$r['ativo'] ? 'opacity: 0.6;' : '' ?>"
                 onmouseover="this.style.borderColor='rgba(124,58,237,0.4)'; this.style.transform='translateY(-4px)';"
                 onmouseout="this.style.borderColor=''; this.style.transform='';">

                <?php if (!$r['ativo']): ?>
                <span class="badge position-absolute top-0 end-0 m-3" style="background: rgba(239,68,68,0.2); color: #f87171; border: 1px solid rgba(239,68,68,0.3); border-radius: 8px;">Inativo</span>
                <?php endif; ?>

                <div class="mb-3" style="font-size:2.5rem; color: var(--text-muted);">
                    <i class="bi <?= adminEsc($r['icone']) ?>"></i>
                </div>
                <h6 class="fw-bold mb-1"><?= adminEsc($r['plataforma']) ?></h6>
                <p class="text-muted-custom small mb-3" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%; display: block;">
                    <a href="<?= adminEsc($r['link']) ?>" target="_blank" style="color: var(--primary-light); text-decoration: none;"><?= adminEsc($r['link']) ?></a>
                </p>

                <div class="d-flex gap-2 mt-3 justify-content-center">
                    <a href="<?= adminEsc($adminBase) ?>redes/editar.php?id=<?= (int) $r['id'] ?>"
                       class="btn btn-sm" style="background:rgba(124,58,237,0.1);color:#a78bfa;border-radius:8px;padding:0.4rem 0.8rem;">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                    <button onclick="confirmDelete('<?= adminEsc($adminBase) ?>redes/excluir.php?id=<?= (int) $r['id'] ?>', '<?= adminEsc(addslashes($r['plataforma'])) ?>')"
                            class="btn btn-sm" style="background:rgba(239,68,68,0.1);color:#f87171;border-radius:8px;padding:0.4rem 0.8rem;">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty-state glass rounded-4 p-5 text-center">
        <i class="bi bi-share-fill" style="font-size: 3rem; color: rgba(124,58,237,0.4);"></i>
        <p class="mt-3 mb-3">Nenhuma rede social cadastrada.</p>
        <a href="<?= adminEsc($adminBase) ?>redes/criar.php" class="btn btn-primary-custom btn-custom">
            <i class="bi bi-plus-circle"></i> Adicionar primeira rede
        </a>
    </div>
    <?php endif; ?>
</div>


