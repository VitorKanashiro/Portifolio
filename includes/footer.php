<?php
// Componente visual global
require_once dirname(__DIR__) . '/includes/helpers.php';
$base_url = $base_url ?? getSiteRoot();
?>
<footer class="text-center py-5" style="background: rgba(0,0,0,0.6); border-top: 1px solid var(--border-glass);">
    <div class="container">
        <a href="<?= esc(siteUrl('')) ?>#home" class="text-gradient fw-black fs-3 text-decoration-none d-block mb-3">
            &lt;<?= esc($nome ?? 'PortfÃ³lio') ?>/&gt;
        </a>

        <?php if (!empty($redes)): ?>
        <nav class="d-flex justify-content-center gap-3 mb-4" aria-label="Redes sociais no rodapÃ©">
            <?php foreach ($redes as $rede): ?>
            <a href="<?= esc($rede['link']) ?>" target="_blank" rel="noopener noreferrer"
               class="social-link" title="<?= esc($rede['plataforma']) ?>">
                <i class="bi <?= esc($rede['icone']) ?>" aria-hidden="true"></i>
                <span class="visually-hidden"><?= esc($rede['plataforma']) ?></span>
            </a>
            <?php endforeach; ?>
        </nav>
        <?php endif; ?>

        <p class="text-muted-custom mb-1 small">
            &copy; <?= date('Y') ?> <?= esc($nome ?? 'PortfÃ³lio') ?>. Todos os direitos reservados.
        </p>
    </div>
</footer>

<div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"></div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content glass border-0" style="border-radius: 20px; border: 1px solid rgba(239,68,68,0.3) !important;">
            <div class="modal-body p-4 text-center">
                <div class="mb-3" style="font-size: 3rem; color: #ef4444;">
                    <i class="bi bi-exclamation-triangle" aria-hidden="true"></i>
                </div>
                <h5 class="fw-bold mb-2">Confirmar ExclusÃ£o</h5>
                <p class="text-muted-custom mb-4">Deseja excluir <strong id="deleteItemName">este item</strong>? Esta aÃ§Ã£o nÃ£o pode ser desfeita.</p>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-custom btn-custom flex-fill" data-bs-dismiss="modal">Cancelar</button>
                    <a id="deleteConfirmBtn" href="#" class="btn flex-fill btn-custom"
                       style="background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); color: #f87171;">
                        <i class="bi bi-trash me-1" aria-hidden="true"></i>Excluir
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base_url ?>assets/js/main.js"></script>
</body>
</html>


