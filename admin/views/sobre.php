<?php
// Visualizacao do painel administrativo  ?>
<div class="admin-content">
    <div class="d-flex align-items-center gap-3 mb-5">
        <div>
            <h1 class="fw-black mb-0 fs-3">Editar Sobre Mim</h1>
            <p class="text-muted-custom mb-0 small">Sua biografia, resumo e estatÃ­sticas</p>
        </div>
    </div>

    <?php include __DIR__ . '/partials/alertas.php'; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="glass p-4 rounded-4 mb-4">
                    <h5 class="fw-bold mb-4 text-gradient">Textos Principais</h5>

                    <div class="mb-4">
                        <label class="form-label-custom">TÃ­tulo da SeÃ§Ã£o *</label>
                        <input type="text" name="titulo" class="form-control form-control-admin"
                               value="<?= adminEsc($titulo ?? $sobre['titulo']) ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">DescriÃ§Ã£o Curta (Resumo)</label>
                        <textarea name="descricao" class="form-control form-control-admin" rows="3"><?= adminEsc($descricao ?? $sobre['descricao'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Biografia Completa</label>
                        <textarea name="biografia" class="form-control form-control-admin" rows="6"><?= adminEsc($biografia ?? $sobre['biografia'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Objetivos Profissionais</label>
                        <textarea name="objetivos" class="form-control form-control-admin" rows="3"><?= adminEsc($objetivos ?? $sobre['objetivos'] ?? '') ?></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-custom btn-custom btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Salvar AlteraÃ§Ãµes
                </button>
            </div>

            <div class="col-lg-4">
                                <div class="glass p-4 rounded-4 text-center mb-4">
                    <h5 class="fw-bold mb-4 text-gradient">Foto da SeÃ§Ã£o</h5>
                    <div class="mb-3">
                        <?php if (adminUploadExiste($sobre['foto'] ?? '')): ?>
                            <img src="<?= adminEsc(adminUploadSrc($sobre['foto'])) ?>" alt="Foto Sobre" class="mb-3 border" style="width: 200px; height: 200px; object-fit: cover; border-radius: 20px; border-color: rgba(124,58,237,0.5) !important;">
                        <?php else: ?>
                            <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 200px; height: 200px; background: rgba(124,58,237,0.15); border: 2px dashed rgba(124,58,237,0.4); border-radius: 20px;">
                                <i class="bi bi-person-workspace text-muted" style="font-size: 4rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom text-start d-block">Alterar Foto (Recomendado 500x500)</label>
                        <input type="file" name="foto" class="form-control form-control-admin" accept="image/*">
                    </div>
                    <p class="small text-muted-custom mb-0">Esta foto aparece ao lado do texto na seÃ§Ã£o "Sobre Mim".</p>
                </div>

                                <div class="glass p-4 rounded-4 text-center">
                    <h5 class="fw-bold mb-4 text-gradient">EstatÃ­sticas</h5>
                    <p class="text-muted-custom small mb-4">Esses nÃºmeros aparecem nos blocos da seÃ§Ã£o sobre vocÃª.</p>

                    <div class="mb-4 text-start">
                        <label class="form-label-custom">Anos de ExperiÃªncia</label>
                        <input type="text" name="experiencia" class="form-control form-control-admin text-center fs-4 fw-bold"
                               value="<?= adminEsc($experiencia ?? $sobre['experiencia'] ?? '') ?>" placeholder="ex: 3+">
                    </div>

                    <div class="mb-4 text-start">
                        <label class="form-label-custom">Projetos ConcluÃ­dos</label>
                        <input type="text" name="projetos_count" class="form-control form-control-admin text-center fs-4 fw-bold"
                               value="<?= adminEsc($projetos_count ?? $sobre['projetos_count'] ?? '') ?>" placeholder="ex: 20+">
                    </div>

                    <div class="mt-5 p-3 rounded-3" style="background: rgba(124,58,237,0.1); border: 1px solid rgba(124,58,237,0.2);">
                        <i class="bi bi-info-circle text-primary-light mb-2 fs-4"></i>
                        <p class="small text-muted-custom mb-0">A contagem de Tecnologias Ã© calculada automaticamente baseada nos itens cadastrados.</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


