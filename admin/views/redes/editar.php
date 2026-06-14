<?php
// Visualizacao do painel administrativo  ?>
<div class="admin-content">
    <div class="d-flex align-items-center gap-3 mb-5">
        <a href="<?= adminEsc($adminBase) ?>redes" class="btn btn-outline-custom btn-custom" style="padding:0.5rem 0.9rem;"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h1 class="fw-black mb-0 fs-3">Editar Rede Social</h1>
            <p class="text-muted-custom mb-0 small"><?= adminEsc($rede['plataforma']) ?></p>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/alertas.php'; ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <form method="POST">
                <div class="glass p-4 rounded-4 mb-4">
                    <h5 class="fw-bold mb-4 text-gradient">Dados da Rede Social</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label-custom">Plataforma *</label>
                            <input type="text" name="plataforma" class="form-control form-control-admin"
                                   value="<?= adminEsc($plataforma ?? $rede['plataforma']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Ordem de exibição</label>
                            <input type="number" name="ordem" class="form-control form-control-admin"
                                   value="<?= (int) ($ordem ?? $rede['ordem']) ?>">
                        </div>
                    </div>

                    <div class="mb-4 mt-3">
                        <label class="form-label-custom">Link Completo *</label>
                        <input type="url" name="link" class="form-control form-control-admin"
                               value="<?= adminEsc($link ?? $rede['link']) ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">ícone (Bootstrap Icons) *</label>
                        <div class="position-relative">
                            <i id="icon-preview" class="bi <?= adminEsc($icone ?? $rede['icone']) ?> position-absolute" style="left:1rem;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:1.1rem;"></i>
                            <input type="text" name="icone" id="iconeInput" class="form-control form-control-admin"
                                   style="padding-left:2.75rem !important;"
                                   value="<?= adminEsc($icone ?? $rede['icone']) ?>" required
                                   oninput="updateIconPreview(this.value)">
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <?php foreach ($iconSuggestions as $ic): ?>
                            <button type="button" onclick="selectIcon('<?= adminEsc($ic) ?>')"
                                    class="btn btn-sm glass border-0"
                                    style="padding:0.4rem 0.6rem;border-radius:8px;border:1px solid var(--border-glass) !important;">
                                <i class="bi <?= adminEsc($ic) ?>"></i>
                            </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" role="switch" id="ativoSwitch" name="ativo" value="1"
                               <?= ($ativo ?? $rede['ativo']) ? 'checked' : '' ?>>
                        <label class="form-check-label text-muted-custom" for="ativoSwitch">Ativo (Exibir no site)</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-custom btn-custom btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Salvar Alterações
                </button>
                <button type="button" onclick="confirmDelete('<?= adminEsc($adminBase) ?>redes/excluir?id=<?= (int) $id ?>', '<?= adminEsc(addslashes($rede['plataforma'])) ?>')"
                        class="btn btn-custom btn-lg ms-2" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#f87171;">
                    <i class="bi bi-trash me-2"></i>Excluir
                </button>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="glass p-4 rounded-4 text-center">
                <h5 class="fw-bold mb-4 text-gradient">Preview</h5>
                <div class="d-inline-flex align-items-center justify-content-center p-4 rounded-circle mb-3" style="background: rgba(124,58,237,0.1); border: 1px solid rgba(124,58,237,0.3); width: 100px; height: 100px;">
                    <i id="preview-icon-big" class="bi <?= adminEsc($icone ?? $rede['icone']) ?> text-white" style="font-size: 2.5rem;"></i>
                </div>
                <h6 class="fw-bold mb-1" id="preview-name"><?= adminEsc($plataforma ?? $rede['plataforma']) ?></h6>
            </div>
        </div>
    </div>
</div>

<script>
function updateIconPreview(val) {
    const classes = 'bi ' + (val || 'bi-link-45deg');
    document.getElementById('icon-preview').className = classes + ' position-absolute';
    document.getElementById('preview-icon-big').className = classes + ' text-white';
}
function selectIcon(ic) {
    document.getElementById('iconeInput').value = ic;
    updateIconPreview(ic);
}
document.querySelector('[name="plataforma"]').addEventListener('input', function(){
    document.getElementById('preview-name').textContent = this.value || 'Plataforma';
});
</script>


