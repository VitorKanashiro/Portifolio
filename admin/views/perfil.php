<?php /** View: editar perfil */ ?>
<div class="admin-content">
    <div class="d-flex align-items-center gap-3 mb-5">
        <div>
            <h1 class="fw-black mb-0 fs-3">Editar Perfil</h1>
            <p class="text-muted-custom mb-0 small">Informações principais da seção Hero</p>
        </div>
    </div>

    <?php include __DIR__ . '/partials/alertas.php'; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="glass p-4 rounded-4 mb-4">
                    <h5 class="fw-bold mb-4 text-gradient">Dados Pessoais</h5>

                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Nome Completo *</label>
                            <input type="text" name="nome" class="form-control form-control-admin"
                                   value="<?= adminEsc($nome ?? $perfil['nome']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Cargo Atual *</label>
                            <input type="text" name="cargo" class="form-control form-control-admin"
                                   value="<?= adminEsc($cargo ?? $perfil['cargo'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Frase de Impacto</label>
                        <input type="text" name="frase" class="form-control form-control-admin"
                               value="<?= adminEsc($frase ?? $perfil['frase'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label-custom">Subtítulo (Apresentação curta)</label>
                        <textarea name="subtitulo" class="form-control form-control-admin" rows="3"><?= adminEsc($subtitulo ?? $perfil['subtitulo'] ?? '') ?></textarea>
                    </div>

                    <h5 class="fw-bold mt-4 mb-3 text-gradient">Links Rápidos (Hero)</h5>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Link do GitHub</label>
                            <input type="url" name="github" class="form-control form-control-admin"
                                   value="<?= adminEsc($github ?? $perfil['github'] ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label-custom">Link do LinkedIn</label>
                            <input type="url" name="linkedin" class="form-control form-control-admin"
                                   value="<?= adminEsc($linkedin ?? $perfil['linkedin'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-custom btn-custom btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Salvar Alterações
                </button>
            </div>

            <div class="col-lg-4">
                <div class="glass p-4 rounded-4 text-center">
                    <h5 class="fw-bold mb-4 text-gradient">Foto do Perfil</h5>
                    <div class="mb-3">
                        <?php if (adminUploadExiste($perfil['foto'] ?? '')): ?>
                            <img src="<?= adminEsc(adminUploadSrc($perfil['foto'])) ?>" alt="Foto" class="rounded-circle mb-3 border" style="width: 150px; height: 150px; object-fit: cover; border-color: rgba(124,58,237,0.5) !important;">
                        <?php else: ?>
                            <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; background: rgba(124,58,237,0.15); border: 2px dashed rgba(124,58,237,0.4);">
                                <i class="bi bi-person text-muted" style="font-size: 4rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom text-start d-block">Alterar Foto (Recomendado 500x500)</label>
                        <input type="file" name="foto" class="form-control form-control-admin" accept="image/*">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
