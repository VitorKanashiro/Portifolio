<?php
// Visualizacao do painel administrativo  ?>
<div class="admin-content">
    <div class="d-flex align-items-center gap-3 mb-5">
        <a href="<?= adminEsc($adminBase) ?>tecnologias" class="btn btn-outline-custom btn-custom" style="padding:0.5rem 0.9rem;"><i class="bi bi-arrow-left"></i></a>
        <div>
            <h1 class="fw-black mb-0 fs-3">Nova Tecnologia</h1>
            <p class="text-muted-custom mb-0 small">Adicionar ao portfÃ³lio</p>
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
                               placeholder="Ex: JavaScript" value="<?= adminEsc($nome ?? '') ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Ãcone Bootstrap Icons</label>
                        <div class="position-relative">
                            <i id="icon-preview" class="bi bi-code-slash position-absolute" style="left:1rem;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:1.1rem;"></i>
                            <input type="text" name="icone" id="iconeInput" class="form-control form-control-admin"
                                   style="padding-left:2.75rem !important;"
                                   placeholder="bi-filetype-js"
                                   value="<?= adminEsc($icone ?? '') ?>"
                                   oninput="updateIconPreview(this.value)">
                        </div>
                        <small class="text-muted-custom">Use classes do Bootstrap Icons (ex: bi-filetype-php)</small>

                                                <div class="d-flex flex-wrap gap-2 mt-3">
                            <?php foreach ($iconSuggestions as $ic): ?>
                            <button type="button" onclick="selectIcon('<?= adminEsc($ic) ?>')"
                                    class="btn btn-sm glass border-0"
                                    style="padding:0.4rem 0.6rem;border-radius:8px;border:1px solid var(--border-glass) !important;"
                                    title="<?= adminEsc($ic) ?>">
                                <i class="bi <?= adminEsc($ic) ?>"></i>
                            </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">NÃ­vel</label>
                        <div class="d-flex gap-2 flex-wrap">
                            <?php
                            $niveis = [
                                'BÃ¡sico'         => ['color' => '#94a3b8', 'bg' => 'rgba(100,116,139,0.25)', 'border' => 'rgba(100,116,139,0.5)'],
                                'IntermediÃ¡rio'  => ['color' => '#fbbf24', 'bg' => 'rgba(245,158,11,0.2)',   'border' => 'rgba(245,158,11,0.5)'],
                                'AvanÃ§ado'       => ['color' => '#22d3ee', 'bg' => 'rgba(6,182,212,0.2)',    'border' => 'rgba(6,182,212,0.5)'],
                                'Expert'         => ['color' => '#a78bfa', 'bg' => 'rgba(124,58,237,0.2)',   'border' => 'rgba(124,58,237,0.5)'],
                            ];
                            $nivelAtual = $nivel ?? 'IntermediÃ¡rio';
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
                    <i class="bi bi-plus-circle me-2"></i>Adicionar Tecnologia
                </button>
                <a href="<?= adminEsc($adminBase) ?>tecnologias" class="btn btn-outline-custom btn-custom btn-lg ms-2">Cancelar</a>
            </form>
        </div>

                <div class="col-lg-4">
            <div class="glass p-4 rounded-4 text-center">
                <h5 class="fw-bold mb-4 text-gradient">Preview</h5>
                <div id="card-preview" class="tech-card mx-auto" style="max-width:180px;">
                    <div class="tech-icon"><i id="preview-icon" class="bi bi-code-slash"></i></div>
                    <h6 class="fw-bold mb-1" id="preview-name">Nome</h6>
                    <span class="<?= adminBadgeNivel($nivelAtual) ?>" id="preview-nivel"><?= adminEsc($nivelAtual) ?></span>
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
const badgeClasses = {
    'BÃ¡sico': 'badge-level badge-iniciante',
    'IntermediÃ¡rio': 'badge-level badge-intermediario',
    'AvanÃ§ado': 'badge-level badge-avancado',
    'Expert': 'badge-level badge-expert'
};
document.querySelectorAll('[name="nivel"]').forEach(radio => {
    radio.addEventListener('change', function(){
        const previewNivel = document.getElementById('preview-nivel');
        if (previewNivel) {
            previewNivel.textContent = this.value;
            previewNivel.className = badgeClasses[this.value] || 'badge-level badge-intermediario';
        }
    });
});
</script>


