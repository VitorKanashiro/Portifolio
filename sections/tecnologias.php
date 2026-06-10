<?php
/**
 * sections/tecnologias.php — Seção de Tecnologias
 * Variáveis: $tecnologias (array)
 */
?>
<!-- SEO: seção Tecnologias — título de seção em H2, itens em H3 -->
<section id="tecnologias" class="py-5" style="background: linear-gradient(to bottom, #0d0d1a, #0a0a0f);" aria-labelledby="tecnologias-titulo">
    <div class="container py-5">
        <div class="text-center mb-5 reveal">
            <h2 id="tecnologias-titulo" class="section-title mx-auto">Tecnologias</h2>
            <p class="text-muted-custom mt-4">Ferramentas e tecnologias que utilizo no meu dia a dia</p>
        </div>

        <?php if (!empty($tecnologias)): ?>
        <div class="row g-4 justify-content-center">
            <?php foreach ($tecnologias as $indice => $tech): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 reveal delay-<?= ($indice % 5) + 1 ?>">
                <article class="tech-card text-center h-100">
                    <div class="tech-icon">
                        <i class="bi <?= esc($tech['icone']) ?>" aria-hidden="true"></i>
                    </div>
                    <h3 class="fw-bold mb-1 text-white fs-6"><?= esc($tech['nome']) ?></h3>
                    <span class="badge-level <?= badgeNivelTecnologia($tech['nivel'] ?? 'intermediário') ?>">
                        <?= esc($tech['nivel']) ?>
                    </span>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty-state reveal">
            <i class="bi bi-cpu" aria-hidden="true"></i>
            <p>Nenhuma tecnologia cadastrada ainda.</p>
        </div>
        <?php endif; ?>
    </div>
</section>
