<?php
// Visualizacao do painel administrativo  ?>
<div class="admin-content">
    <div class="d-flex align-items-center gap-3 mb-5">
        <a href="<?= adminEsc($adminBase) ?>projetos" class="btn btn-outline-custom btn-custom" style="padding:0.5rem 0.9rem;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h1 class="fw-black mb-0 fs-3">Editar Projeto</h1>
            <p class="text-muted-custom mb-0 small"><?= adminEsc($proj['titulo']) ?></p>
        </div>
    </div>

    <?php include __DIR__ . '/../partials/alertas.php'; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="glass p-4 rounded-4 mb-4">
                    <h5 class="fw-bold mb-4 text-gradient">Informações do Projeto</h5>

                    <div class="mb-4">
                        <label class="form-label-custom">Título *</label>
                        <input type="text" name="titulo" class="form-control form-control-admin"
                               value="<?= adminEsc($titulo ?? $proj['titulo']) ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label-custom">Descrição</label>
                        <textarea name="descricao" class="form-control form-control-admin" rows="5"><?= adminEsc($descricao ?? $proj['descricao']) ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label-custom">Tecnologias (separadas por vírgula)</label>
                        <input type="text" name="tecnologias" class="form-control form-control-admin"
                               value="<?= adminEsc($tecnologias ?? $proj['tecnologias']) ?>">
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label-custom">GitHub</label>
                            <div class="position-relative">
                                <i class="bi bi-github position-absolute" style="left:1rem;top:50%;transform:translateY(-50%);color:var(--text-muted);"></i>
                                <input type="url" name="github" class="form-control form-control-admin"
                                       style="padding-left:2.75rem !important;"
                                       value="<?= adminEsc($github ?? $proj['github']) ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Demo</label>
                            <div class="position-relative">
                                <i class="bi bi-globe position-absolute" style="left:1rem;top:50%;transform:translateY(-50%);color:var(--text-muted);"></i>
                                <input type="url" name="demo" class="form-control form-control-admin"
                                       style="padding-left:2.75rem !important;"
                                       value="<?= adminEsc($demo ?? $proj['demo']) ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="glass p-4 rounded-4 mb-4">
                    <h5 class="fw-bold mb-4 text-gradient">Imagem do Projeto</h5>

                    <?php if (adminUploadExiste($proj['imagem'] ?? '')): ?>
                    <div class="text-center mb-3">
                        <img id="img-preview" src="<?= adminEsc(adminUploadSrc($proj['imagem'])) ?>"
                             class="img-preview mb-2" style="max-width:100%;border-radius:12px;">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="remover_imagem" id="remover_imagem">
                            <label class="form-check-label text-muted-custom small" for="remover_imagem">
                                Remover imagem atual
                            </label>
                        </div>
                    </div>
                    <?php else: ?>
                    <div id="img-placeholder" class="d-flex align-items-center justify-content-center rounded-3 mb-3"
                         style="height:140px;background:rgba(255,255,255,0.03);border:2px dashed var(--border-glass);">
                        <div class="text-center text-muted-custom">
                            <i class="bi bi-cloud-upload fs-2 mb-2 d-block"></i>
                            <small>Clique para selecionar</small>
                        </div>
                    </div>
                    <img id="img-preview" src="" alt="" style="display:none;max-width:100%;border-radius:12px;" class="mb-2">
                    <?php endif; ?>

                    <input type="file" name="imagem" id="imageInput" class="form-control form-control-admin mt-3"
                           accept="image/*" data-preview="img-preview">
                    <small class="text-muted-custom d-block mt-2">JPG, PNG, WEBP · Máx. 5MB</small>
                </div>

                <div class="glass p-4 rounded-4 mb-4">
                    <h5 class="fw-bold mb-4 text-gradient">Configurações</h5>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <label class="fw-semibold d-block mb-1">Projeto em Destaque</label>
                            <small class="text-muted-custom">Aparece primeiro na listagem</small>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="destaque" id="destaque"
                                   style="width:48px;height:26px;cursor:pointer;"
                                   <?= ($destaque ?? $proj['destaque'] ?? 0) ? 'checked' : '' ?>>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-custom btn-custom w-100 btn-lg mb-2">
                    <i class="bi bi-check-circle me-2"></i>Salvar Alterações
                </button>
                <button type="button" onclick="confirmDelete('<?= adminEsc($adminBase) ?>projetos/excluir?id=<?= (int) $id ?>', '<?= adminEsc(addslashes($proj['titulo'])) ?>')"
                        class="btn btn-custom w-100" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#f87171;">
                    <i class="bi bi-trash me-2"></i>Excluir Projeto
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function() {
    const preview = document.getElementById('img-preview');
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>


