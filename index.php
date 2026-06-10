<?php
/**
 * index.php — Página principal do portfólio (pública)
 *
 * Este arquivo apenas orquestra: carrega dados via controllers,
 * define SEO e inclui as sections. Toda lógica está nos controllers.
 */
require_once 'config/conexao.php';
require_once 'includes/helpers.php';
require_once 'controllers/PortfolioController.php';
require_once 'controllers/ContactController.php';

$portfolio = new PortfolioController($conn);
$contato   = new ContactController($conn);

// Processa formulário de contato (padrão PRG)
$contato->processarFormulario();
$mensagens = $contato->recuperarMensagens();

// Carrega dados da página inicial
$dados = $portfolio->carregarPaginaInicial();
extract($dados);

// Tecnologias únicas para filtro de projetos
$tecnologias_projeto = $portfolio->extrairTecnologiasUnicas($projetos);

// Mensagens do formulário de contato
$msg_success       = $mensagens['msg_success'];
$msg_error         = $mensagens['msg_error'];
$scroll_to_contato = $mensagens['scroll_to_contato'];

// SEO básico: title, description e keywords da página inicial
extract($portfolio->seoPaginaInicial($dados));

include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- SEO: conteúdo principal — cada seção usa H2 como título -->
<main>
    <?php
    include 'sections/hero.php';
    include 'sections/sobre.php';
    include 'sections/tecnologias.php';
    include 'sections/projetos.php';
    include 'sections/contato.php';
    ?>
</main>

<?php
include 'includes/footer.php';

if ($scroll_to_contato): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const el = document.getElementById('contato');
        if (el) { setTimeout(() => el.scrollIntoView({ behavior: 'smooth', block: 'start' }), 300); }
    });
</script>
<?php endif; ?>
