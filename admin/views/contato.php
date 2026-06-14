<?php
// Visualizacao do painel administrativo  ?>
<div class="admin-content">
    <div class="d-flex align-items-center gap-3 mb-5">
        <div>
            <h1 class="fw-black mb-0 fs-3">Editar Contato</h1>
            <p class="text-muted-custom mb-0 small">Informações exibidas na seção final do site</p>
        </div>
    </div>

    <?php include __DIR__ . '/partials/alertas.php'; ?>

    <form method="POST">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="glass p-4 rounded-4 mb-4">
                    <h5 class="fw-bold mb-4 text-gradient">Dados de Contato</h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">E-mail Principal *</label>
                            <input type="email" name="email" class="form-control form-control-admin"
                                   value="<?= adminEsc($email ?? $contato['email'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Telefone / WhatsApp</label>
                            <input type="text" name="telefone" class="form-control form-control-admin"
                                   value="<?= adminEsc($telefone ?? $contato['telefone'] ?? '') ?>" placeholder="(00) 00000-0000">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Cidade / Localização</label>
                        <input type="text" name="cidade" class="form-control form-control-admin"
                               value="<?= adminEsc($cidade ?? $contato['cidade'] ?? '') ?>" placeholder="Ex: São Paulo, SP">
                    </div>

                    <div class="mb-2">
                        <label class="form-label-custom">Mensagem Chamativa (Texto acima do formulário)</label>
                        <textarea name="mensagem" class="form-control form-control-admin" rows="4"><?= adminEsc($mensagem ?? $contato['mensagem'] ?? '') ?></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-custom btn-custom btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Salvar Alterações
                </button>
            </div>

            <div class="col-lg-4">
                <div class="glass p-4 rounded-4 text-center h-100">
                    <h5 class="fw-bold mb-4 text-gradient">Mensagens</h5>
                    <div class="d-flex align-items-center justify-content-center p-4 rounded-circle mb-4 mx-auto" style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); width: 120px; height: 120px;">
                        <i class="bi bi-envelope-paper-fill text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <p class="text-muted-custom small mb-4">Os contatos recebidos pelo formulário do site caem diretamente no banco de dados e podem ser lidos na aba Mensagens.</p>
                    <a href="<?= adminEsc($adminBase) ?>mensagens" class="btn btn-outline-custom btn-custom w-100">
                        Ir para Mensagens
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>


