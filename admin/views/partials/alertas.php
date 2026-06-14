<?php
// Visualizacao do painel administrativo
?>
<?php if (!empty($erro)): ?>
<div class="alert-custom alert-danger-custom mb-4 p-3 rounded-3" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2" aria-hidden="true"></i><?= adminEsc($erro) ?>
</div>
<?php endif; ?>

<?php if (!empty($sucesso)): ?>
<div class="alert-custom alert-success-custom mb-4 p-3 rounded-3" role="alert">
    <i class="bi bi-check-circle-fill me-2" aria-hidden="true"></i><?= adminEsc($sucesso) ?>
</div>
<?php endif; ?>

<?php if (!empty($sucesso_get)): ?>
<div class="alert-custom alert-success-custom mb-4 p-3 rounded-3" role="alert">
    <i class="bi bi-check-circle-fill me-2" aria-hidden="true"></i><?= adminEsc($sucesso_get) ?>
</div>
<?php endif; ?>


