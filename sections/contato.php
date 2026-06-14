<?php
// Secao principal do portfolio
?>
<section id="contato" class="py-5" style="background: linear-gradient(to bottom, #0a0f1e, #0a0a0f);" aria-labelledby="contato-titulo">
    <div class="container py-5">
        <div class="text-center mb-5 reveal">
            <h2 id="contato-titulo" class="section-title mx-auto">Vamos Conversar?</h2>
            <p class="text-muted-custom mt-4">
                <?= esc($contato['mensagem'] ?? 'Entre em contato para conversarmos!') ?>
            </p>
        </div>

        <div class="row g-5 justify-content-center">
            <div class="col-lg-4 reveal">
                <div class="d-flex flex-column gap-4">
                    <?php if (!empty($contato['email'])): ?>
                    <div class="d-flex align-items-center gap-4 glass p-4 rounded-4">
                        <div class="stat-icon" style="background: rgba(124,58,237,0.15); color: #a78bfa; flex-shrink: 0;">
                            <i class="bi bi-envelope-fill" aria-hidden="true"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">E-mail</div>
                            <a href="mailto:<?= esc($contato['email']) ?>" class="fw-semibold text-white text-decoration-none"
                               style="font-size: 0.95rem;"><?= esc($contato['email']) ?></a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($contato['telefone'])): ?>
                    <div class="d-flex align-items-center gap-4 glass p-4 rounded-4">
                        <div class="stat-icon" style="background: rgba(16,185,129,0.15); color: #34d399; flex-shrink: 0;">
                            <i class="bi bi-phone-fill" aria-hidden="true"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Telefone</div>
                            <span class="fw-semibold text-white" style="font-size: 0.95rem;"><?= esc($contato['telefone']) ?></span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($contato['cidade'])): ?>
                    <div class="d-flex align-items-center gap-4 glass p-4 rounded-4">
                        <div class="stat-icon" style="background: rgba(6,182,212,0.15); color: #22d3ee; flex-shrink: 0;">
                            <i class="bi bi-geo-alt-fill" aria-hidden="true"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Localização</div>
                            <span class="fw-semibold text-white" style="font-size: 0.95rem;"><?= esc($contato['cidade']) ?></span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($redes)): ?>
                    <div>
                        <p class="text-muted-custom small mb-3">Minhas redes sociais:</p>
                        <div class="d-flex gap-2 flex-wrap">
                            <?php foreach ($redes as $rede): ?>
                            <a href="<?= esc($rede['link']) ?>" target="_blank" rel="noopener noreferrer"
                               class="social-link" title="<?= esc($rede['plataforma']) ?> â€” <?= esc($nome ?? 'Portfólio') ?>">
                                <i class="bi <?= esc($rede['icone']) ?>" aria-hidden="true"></i>
                                <span class="visually-hidden"><?= esc($rede['plataforma']) ?></span>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-7 reveal delay-2">
                <div class="glass p-5 rounded-4">
                    <?php if (!empty($msg_success)): ?>
                    <div class="alert-custom alert-success-custom mb-4 p-3 rounded-3" role="alert">
                        <i class="bi bi-check-circle-fill me-2" aria-hidden="true"></i><?= esc($msg_success) ?>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($msg_error)): ?>
                    <div class="alert-custom alert-danger-custom mb-4 p-3 rounded-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2" aria-hidden="true"></i><?= esc($msg_error) ?>
                    </div>
                    <?php endif; ?>

                    <form method="POST" id="contact-form" novalidate>
                        <input type="hidden" name="contact_form_submitted" value="1">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-custom" for="contato-nome">Nome *</label>
                                <input type="text" id="contato-nome" name="nome" class="form-control form-control-custom" placeholder="Seu nome" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom" for="contato-email">E-mail *</label>
                                <input type="email" id="contato-email" name="email" class="form-control form-control-custom" placeholder="seu@email.com" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label-custom" for="contato-assunto">Assunto</label>
                                <input type="text" id="contato-assunto" name="assunto" class="form-control form-control-custom" placeholder="Sobre o que você quer conversar?">
                            </div>
                            <div class="col-12">
                                <label class="form-label-custom" for="contato-mensagem">Mensagem *</label>
                                <textarea id="contato-mensagem" name="mensagem" class="form-control form-control-custom" rows="5"
                                          placeholder="Descreva seu projeto ou ideia..." required></textarea>
                            </div>
                            <div class="col-12 mt-2">
                                <button type="submit" name="contact_submit" class="btn btn-primary-custom btn-custom btn-lg w-100">
                                    <i class="bi bi-send-fill" aria-hidden="true"></i> Enviar Mensagem
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


