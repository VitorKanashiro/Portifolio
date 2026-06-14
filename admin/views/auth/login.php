<?php
// Autenticacao do administrador  ?>
<div class="login-page">
    <div style="position:absolute;top:-20%;left:-10%;width:500px;height:500px;background:radial-gradient(circle,rgba(6,182,212,0.1) 0%,transparent 70%);border-radius:50%;pointer-events:none;" aria-hidden="true"></div>

    <div class="login-card glass animate-fadeInUp">
        <div class="text-center mb-5">
            <div class="d-inline-flex align-items-center justify-content-center mb-3"
                 style="width:60px;height:60px;border-radius:16px;background:var(--gradient-primary);">
                <i class="bi bi-code-slash fs-3 text-white" aria-hidden="true"></i>
            </div>
            <h1 class="fw-black mb-1 fs-2">Admin Panel</h1>
            <p class="text-muted-custom small">Entre com suas credenciais para continuar</p>
        </div>

        <?php include __DIR__ . '/../partials/alertas.php'; ?>

        <?php if (!empty($timeout)): ?>
        <div class="alert-custom alert-danger-custom mb-4 p-3 rounded-3" role="alert">
            <i class="bi bi-clock-history me-2" aria-hidden="true"></i>Sua sessÃ£o expirou por inatividade. FaÃ§a login novamente.
        </div>
        <?php endif; ?>

        <form method="POST" novalidate id="login-form">
            <div class="mb-4">
                <label class="form-label-custom" for="email">E-mail</label>
                <div class="position-relative">
                    <i class="bi bi-envelope position-absolute" style="left:1rem;top:50%;transform:translateY(-50%);color:var(--text-muted);" aria-hidden="true"></i>
                    <input type="email" id="email" name="email" class="form-control form-control-admin"
                           style="padding-left:2.75rem !important;"
                           placeholder="admin@admin.com"
                           value="<?= adminEsc($email) ?>"
                           required autofocus>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label-custom" for="senha">Senha</label>
                <div class="position-relative">
                    <i class="bi bi-lock position-absolute" style="left:1rem;top:50%;transform:translateY(-50%);color:var(--text-muted);" aria-hidden="true"></i>
                    <input type="password" name="senha" id="senhaInput" class="form-control form-control-admin"
                           style="padding-left:2.75rem !important; padding-right:3rem !important;"
                           placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢" required>
                    <button type="button" onclick="toggleSenha()"
                            style="position:absolute;right:1rem;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-muted);cursor:pointer;padding:0;"
                            aria-label="Mostrar ou ocultar senha">
                        <i class="bi bi-eye" id="toggleIcon" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <?php if (!empty($recuperar_senha_habilitado)): ?>
            <div class="text-end mb-4">
                <a href="#" class="text-muted-custom small text-decoration-none">Esqueceu a senha?</a>
            </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary-custom btn-custom w-100 btn-lg mb-4" id="btn-login">
                <span class="btn-text"><i class="bi bi-box-arrow-in-right me-2" aria-hidden="true"></i>Entrar no Painel</span>
                <span class="btn-loading d-none"><span class="spinner-border spinner-border-sm me-2" role="status"></span>Entrando...</span>
            </button>

            <div class="text-center">
                <a href="<?= adminEsc($baseUrl) ?>" class="text-muted-custom small text-decoration-none">
                    <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Voltar ao site
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function toggleSenha() {
    const input = document.getElementById('senhaInput');
    const icon  = document.getElementById('toggleIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
document.getElementById('login-form').addEventListener('submit', function() {
    const btn = document.getElementById('btn-login');
    btn.querySelector('.btn-text').classList.add('d-none');
    btn.querySelector('.btn-loading').classList.remove('d-none');
    btn.disabled = true;
});
</script>


