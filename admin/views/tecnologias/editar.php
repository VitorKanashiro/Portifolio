<?php /** View: editar tecnologia */ ?>
<div class="admin-content">
    <div class="d-flex align-items-center gap-3 mb-5">
        <a href="<?= adminEsc($adminBase) ?>tecnologias/index.php" class="btn btn-outline-custom btn-custom" style="padding:0.5rem 0.9rem;"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h1 class="fw-black mb-0 fs-3">Editar Tecnologia</h1>
            <p class="text-muted-custom mb-0 small"><?= adminEsc($tec['nome']) ?></p>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/alertas.php'; ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <form method="POST">
                <div class="glass p-4 rounded-4 mb-4">
                    <h5 class="fw-bold mb-4 text-gradient">Dados da Tecnologia</h5>

                    <div class="mb-4">
                        <label class="form-label-custom">Nome *</label>
                        <input type="text" name="nome" class="form-control form-control-admin"
                               value="<?= adminEsc($nome ?? $tec['nome']) ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Ícone Bootstrap Icons</label>
                        <div class="position-relative">
                            <i id="icon-preview" class="bi <?= adminEsc($icone ?? $tec['icone']) ?> position-absolute" style="left:1rem;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:1.1rem;"></i>
                            <input type="text" name="icone" id="iconeInput" class="form-control form-control-admin"
                                   style="padding-left:2.75rem !important;"
                                   value="<?= adminEsc($icone ?? $tec['icone']) ?>"
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

                    <div class="mb-3">
                        <label class="form-label-custom">Nível</label>
                        <div class="d-flex gap-2 flex-wrap">
                            <?php
                            $niveis = [
                                'Básico'         => ['color' => '#94a3b8', 'bg' => 'rgba(100,116,139,0.25)', 'border' => 'rgba(100,116,139,0.5)'],
                                'Intermediário'  => ['color' => '#fbbf24', 'bg' => 'rgba(245,158,11,0.2)',   'border' => 'rgba(245,158,11,0.5)'],
                                'Avançado'       => ['color' => '#22d3ee', 'bg' => 'rgba(6,182,212,0.2)',    'border' => 'rgba(6,182,212,0.5)'],
                            ];
                            $nivelAtual = $nivel ?? $tec['nivel'];
                            foreach ($niveis as $nv => $style): ?>
                            <label class="nivel-option" style="--nv-color:<?= $style['color'] ?>;--nv-bg:<?= $style['bg'] ?>;--nv-border:<?= $style['border'] ?>">
                                <input type="radio" name="nivel" value="<?= adminEsc($nv) ?>" <?= ($nivelAtual === $nv) ? 'checked' : '' ?> class="d-none">
                                <span class="nivel-label"><?= adminEsc($nv) ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-custom btn-custom btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Salvar Alterações
                </button>
                <button type="button" onclick="confirmDelete('<?= adminEsc($adminBase) ?>tecnologias/excluir.php?id=<?= (int) $id ?>', '<?= adminEsc(addslashes($tec['nome'])) ?>')"
                        class="btn btn-custom btn-lg ms-2" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#f87171;">
                    <i class="bi bi-trash me-2"></i>Excluir
                </button>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="glass p-4 rounded-4 text-center">
                <h5 class="fw-bold mb-4 text-gradient">Preview</h5>
                <div class="tech-card mx-auto" style="max-width:180px;">
                    <div class="tech-icon"><i id="preview-icon" class="bi <?= adminEsc($icone ?? $tec['icone']) ?>"></i></div>
                    <h6 class="fw-bold mb-1" id="preview-name"><?= adminEsc($nome ?? $tec['nome']) ?></h6>
                    <span class="badge-level badge-intermediario" id="preview-nivel"><?= adminEsc($nivel ?? $tec['nivel']) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateIconPreview(val) {
    const classes = 'bi ' + (val || 'bi-code-slash');
    document.getElementById('icon-preview').className = classes + ' position-absolute';
    document.getElementById('preview-icon').className = 'bi ' + (val || 'bi-code-slash');
}
function selectIcon(ic) {
    document.getElementById('iconeInput').value = ic;
    updateIconPreview(ic);
}
document.querySelector('[name="nome"]').addEventListener('input', function(){
    document.getElementById('preview-name').textContent = this.value || 'Nome';
});
document.querySelector('[name="nivel"]').addEventListener('change', function(){
    document.getElementById('preview-nivel').textContent = this.value;
});
</script>
