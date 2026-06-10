<?php /** View: listar mensagens */ ?>
<div class="admin-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-black mb-1 fs-3">Caixa de Entrada</h1>
            <p class="text-muted-custom mb-0 small">Total de <?= (int) $total ?> mensagem(ns)</p>
        </div>
        <?php if ($total > 0): ?>
        <a href="?action=ler_todas" class="btn btn-outline-custom btn-custom" style="padding: 0.5rem 1rem;">
            <i class="bi bi-check2-all me-1"></i> Marcar todas como lidas
        </a>
        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/../partials/alertas.php'; ?>

    <?php if (!empty($mensagens)): ?>
    <div class="d-flex flex-column gap-3">
        <?php foreach ($mensagens as $msg): ?>
        <div class="glass rounded-4 p-4 <?= !$msg['lida'] ? 'border-primary' : '' ?>" style="<?= !$msg['lida'] ? 'border: 1px solid rgba(124,58,237,0.5);' : '' ?>">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 48px; height: 48px; background: rgba(124,58,237,0.15); color: var(--primary-light); font-weight: bold; font-size: 1.2rem;">
                        <?= strtoupper(substr($msg['nome'], 0, 1)) ?>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold <?= !$msg['lida'] ? 'text-white' : 'text-muted-custom' ?>">
                            <?= adminEsc($msg['nome']) ?>
                            <?php if (!$msg['lida']): ?>
                            <span class="badge ms-2" style="background: var(--primary); font-size: 0.6rem; vertical-align: middle;">NOVA</span>
                            <?php endif; ?>
                        </h6>
                        <small class="text-muted-custom" style="font-size: 0.8rem;">
                            <a href="mailto:<?= adminEsc($msg['email']) ?>" class="text-decoration-none text-muted-custom hover-primary">
                                <?= adminEsc($msg['email']) ?>
                            </a>
                        </small>
                    </div>
                </div>
                <div class="text-end">
                    <small class="text-muted-custom d-block mb-2"><?= date('d/m/Y \à\s H:i', strtotime($msg['created_at'])) ?></small>
                    <div class="d-flex gap-2 justify-content-end">
                        <?php if (!$msg['lida']): ?>
                        <a href="?action=ler&id=<?= (int) $msg['id'] ?>" class="btn btn-sm btn-primary-custom" title="Marcar como lida" style="padding: 0.2rem 0.5rem; font-size: 0.8rem;">
                            <i class="bi bi-check-lg"></i> Lida
                        </a>
                        <?php endif; ?>
                        <button onclick="confirmDelete('<?= adminEsc($adminBase) ?>mensagens/excluir.php?id=<?= (int) $msg['id'] ?>', 'esta mensagem')"
                                class="btn btn-sm" style="background:rgba(239,68,68,0.1);color:#f87171;border-radius:6px;padding:0.2rem 0.5rem;">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <?php if (!empty($msg['assunto'])): ?>
            <p class="fw-semibold mb-2" style="color: var(--text-primary); font-size: 0.95rem;">
                Assunto: <?= adminEsc($msg['assunto']) ?>
            </p>
            <?php endif; ?>

            <div class="p-3 rounded-3" style="background: rgba(0,0,0,0.2); border: 1px solid var(--border-glass);">
                <p class="mb-0 text-muted-custom" style="line-height: 1.6; white-space: pre-wrap; font-size: 0.9rem;"><?= adminEsc($msg['mensagem']) ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if (($totalPages ?? 1) > 1): ?>
    <nav class="mt-5">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link glass border-0" href="?p=<?= $page - 1 ?>">Anterior</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                <a class="page-link <?= $page == $i ? 'bg-primary border-primary' : 'glass border-0' ?>" href="?p=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link glass border-0" href="?p=<?= $page + 1 ?>">Próxima</a>
            </li>
        </ul>
    </nav>
    <?php endif; ?>

    <?php else: ?>
    <div class="empty-state glass rounded-4 p-5 text-center">
        <i class="bi bi-inbox" style="font-size: 3rem; color: rgba(124,58,237,0.4);"></i>
        <p class="mt-3 mb-0 fs-5">Caixa de entrada vazia.</p>
        <small class="text-muted-custom">Você ainda não recebeu nenhuma mensagem.</small>
    </div>
    <?php endif; ?>
</div>

<style>
.hover-primary:hover { color: var(--primary-light) !important; }
.pagination .page-link { color: var(--text-muted); margin: 0 0.2rem; border-radius: 8px; }
.pagination .page-link:hover { background: rgba(124,58,237,0.2); color: var(--text-primary); }
.pagination .active .page-link { background: var(--primary) !important; color: white !important; }
.pagination .disabled .page-link { opacity: 0.5; background: rgba(255,255,255,0.05) !important; }
</style>
