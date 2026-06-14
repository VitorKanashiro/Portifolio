<?php
// Componente do admin
?>
<div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"></div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content glass border-0" style="border-radius: 20px; border: 1px solid rgba(239,68,68,0.3) !important;">
            <div class="modal-body p-4 text-center">
                <div class="mb-3" style="font-size: 3rem; color: #ef4444;">
                    <i class="bi bi-exclamation-triangle" aria-hidden="true"></i>
                </div>
                <h5 class="fw-bold mb-2">Confirmar Exclusão</h5>
                <p class="text-muted-custom mb-4">Deseja excluir <strong id="deleteItemName">este item</strong>? Esta ação não pode ser desfeita.</p>
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
<script src="<?= adminEsc($baseUrl) ?>assets/js/main.js"></script>
<?= $extraScripts ?? '' ?>
</body>
</html>


