<?php /** View: listar tecnologias */ ?>
<div class="admin-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-black mb-1 fs-3">Tecnologias</h1>
            <p class="text-muted-custom mb-0 small"><?= count($tecnologias) ?> tecnologia<?= count($tecnologias) != 1 ? 's' : '' ?> cadastrada<?= count($tecnologias) != 1 ? 's' : '' ?></p>
        </div>
        <a href="<?= adminEsc($adminBase) ?>tecnologias/criar.php" class="btn btn-primary-custom btn-custom">
            <i class="bi bi-plus-circle"></i> Nova Tecnologia
        </a>
    </div>

    <?php include __DIR__ . '/../partials/alertas.php'; ?>

    <!-- Cards Grid -->
    <?php if (!empty($tecnologias)): ?>
    <div class="row g-4">
        <?php foreach ($tecnologias as $t): ?>
        <div class="col-sm-6 col-md-4 col-xl-3">
            <div class="glass rounded-4 p-4 text-center h-100" style="transition: var(--transition);"
                 onmouseover="this.style.borderColor='rgba(124,58,237,0.4)'; this.style.transform='translateY(-4px)';"
                 onmouseout="this.style.borderColor=''; this.style.transform='';">
                <div class="mb-3" style="font-size:2.5rem; background:var(--gradient-primary); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">
                    <i class="bi <?= adminEsc($t['icone']) ?>"></i>
                </div>
                <h6 class="fw-bold mb-2"><?= adminEsc($t['nome']) ?></h6>

                <span class="badge-level <?= adminBadgeNivel($t['nivel'] ?? '') ?> d-inline-block mb-3"><?= adminEsc($t['nivel']) ?></span>

                <div class="d-flex gap-2 mt-3 justify-content-center">
                    <a href="<?= adminEsc($adminBase) ?>tecnologias/editar.php?id=<?= (int) $t['id'] ?>"
                       class="btn btn-sm" style="background:rgba(124,58,237,0.1);color:#a78bfa;border-radius:8px;padding:0.4rem 0.8rem;">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                    <button onclick="confirmDelete('<?= adminEsc($adminBase) ?>tecnologias/excluir.php?id=<?= (int) $t['id'] ?>', '<?= adminEsc(addslashes($t['nome'])) ?>')"
                            class="btn btn-sm" style="background:rgba(239,68,68,0.1);color:#f87171;border-radius:8px;padding:0.4rem 0.8rem;">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="empty-state glass rounded-4 p-5">
        <i class="bi bi-cpu"></i>
        <p class="mt-2 mb-3">Nenhuma tecnologia cadastrada.</p>
        <a href="<?= adminEsc($adminBase) ?>tecnologias/criar.php" class="btn btn-primary-custom btn-custom">
            <i class="bi bi-plus-circle"></i> Adicionar primeira tecnologia
        </a>
    </div>
    <?php endif; ?>
</div>
