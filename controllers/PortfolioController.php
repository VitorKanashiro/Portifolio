<?php
/**
 * controllers/PortfolioController.php
 * Responsável por todas as consultas ao banco relacionadas ao portfólio público.
 * Centraliza a lógica de dados para manter as views (sections) apenas com HTML.
 */

require_once dirname(__DIR__) . '/includes/helpers.php';

class PortfolioController
{
    /** @var mysqli Conexão ativa com o MySQL */
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    // ─────────────────────────────────────────────────────────────
    // CONSULTAS AO BANCO DE DADOS
    // ─────────────────────────────────────────────────────────────

    /** Busca o perfil principal (seção Hero). */
    public function buscarPerfil(): array
    {
        $resultado = mysqli_query($this->conn, 'SELECT * FROM perfil LIMIT 1');

        return mysqli_fetch_assoc($resultado) ?: [];
    }

    /** Busca informações da seção Sobre. */
    public function buscarSobre(): array
    {
        $resultado = mysqli_query($this->conn, 'SELECT * FROM sobre LIMIT 1');

        return mysqli_fetch_assoc($resultado) ?: [];
    }

    /** Busca dados de contato exibidos na seção Contato. */
    public function buscarContato(): array
    {
        $resultado = mysqli_query($this->conn, 'SELECT * FROM contato LIMIT 1');

        return mysqli_fetch_assoc($resultado) ?: [];
    }

    /** Lista todos os projetos ordenados por destaque e data. */
    public function buscarProjetos(): array
    {
        $resultado = mysqli_query(
            $this->conn,
            'SELECT * FROM projetos ORDER BY destaque DESC, created_at DESC'
        );

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC) ?: [];
    }

    /** Lista tecnologias ordenadas por nível de proficiência. */
    public function buscarTecnologias(): array
    {
        $resultado = mysqli_query(
            $this->conn,
            'SELECT * FROM tecnologias ORDER BY nivel_percentual DESC'
        );

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC) ?: [];
    }

    /** Lista redes sociais ativas ordenadas. */
    public function buscarRedesSociais(): array
    {
        $resultado = mysqli_query(
            $this->conn,
            'SELECT * FROM redes_sociais WHERE ativo = 1 ORDER BY ordem ASC'
        );

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC) ?: [];
    }

    /** Busca um projeto específico pelo ID numérico. */
    public function buscarProjetoPorId(int $id): ?array
    {
        $id        = (int) $id;
        $resultado = mysqli_query($this->conn, "SELECT * FROM projetos WHERE id = '$id' LIMIT 1");
        $projeto   = mysqli_fetch_assoc($resultado);

        return $projeto ?: null;
    }

    /** Busca um projeto pelo slug amigável gerado a partir do título. */
    public function buscarProjetoPorSlug(string $slug): ?array
    {
        $projetos = $this->buscarProjetos();

        foreach ($projetos as $projeto) {
            if ($this->gerarSlugProjeto($projeto) === $slug) {
                return $projeto;
            }
        }

        return null;
    }

    // ─────────────────────────────────────────────────────────────
    // DADOS COMBINADOS PARA A PÁGINA INICIAL
    // ─────────────────────────────────────────────────────────────

    /**
     * Carrega todos os dados necessários para a página inicial (index.php).
     * Retorna um array associativo pronto para uso nas sections.
     */
    public function carregarPaginaInicial(): array
    {
        $perfil      = $this->buscarPerfil();
        $dadosPerfil = $this->normalizarPerfil($perfil);

        return array_merge($dadosPerfil, [
            'perfil'              => $perfil,
            'sobre'               => $this->buscarSobre(),
            'contato'             => $this->buscarContato(),
            'projetos'            => $this->buscarProjetos(),
            'tecnologias'         => $this->buscarTecnologias(),
            'redes'               => $this->buscarRedesSociais(),
            'tecnologias_projeto' => [],
        ]);
    }

    /**
     * Aplica valores padrão ao perfil quando campos estão vazios no banco.
     */
    public function normalizarPerfil(array $perfil): array
    {
        return [
            'nome'     => $perfil['nome']      ?? 'Desenvolvedor Full Stack',
            'cargo'    => $perfil['cargo']     ?? 'Desenvolvedor Full Stack',
            'frase'    => $perfil['frase']     ?? 'Transformando ideias em código.',
            'sub'      => $perfil['subtitulo'] ?? 'Criando soluções web modernas e escaláveis.',
            'github'   => $perfil['github']    ?? '#',
            'linkedin' => $perfil['linkedin']  ?? '#',
            'foto'     => $perfil['foto']      ?? '',
        ];
    }

    /**
     * Extrai lista única de tecnologias usadas nos projetos (para filtros).
     */
    public function extrairTecnologiasUnicas(array $projetos, int $limite = 6): array
    {
        $tecnologias = [];

        foreach ($projetos as $projeto) {
            $lista = array_map('trim', explode(',', $projeto['tecnologias'] ?? ''));

            foreach ($lista as $tech) {
                if ($tech !== '') {
                    $tecnologias[$tech] = true;
                }
            }
        }

        return array_slice(array_keys($tecnologias), 0, $limite);
    }

    // ─────────────────────────────────────────────────────────────
    // URLs amigáveis dos projetos
    // ─────────────────────────────────────────────────────────────

    /** Gera slug único para um projeto (título + id para evitar duplicatas). */
    public function gerarSlugProjeto(array $projeto): string
    {
        return gerarSlugProjeto($projeto);
    }

    /** Retorna URL amigável do projeto (ex: /portifolio-1/projeto/sistema-de-portfolio-1). */
    public function urlProjeto(array $projeto): string
    {
        return urlProjeto($projeto);
    }

    // ─────────────────────────────────────────────────────────────
    // SEO BÁSICO — title, description e keywords por página
    // ─────────────────────────────────────────────────────────────

    /**
     * SEO da página inicial.
     * Exemplo de title: "João Silva | Desenvolvedor Full Stack"
     */
    public function seoPaginaInicial(array $dados): array
    {
        $nome  = $dados['nome']  ?? 'Portfólio';
        $cargo = $dados['cargo'] ?? 'Desenvolvedor';
        $sub   = $dados['sub']   ?? '';

        $descricao = $sub !== ''
            ? $sub
            : 'Portfólio de ' . $nome . ', estudante de ADS e desenvolvedor focado em criar soluções modernas e eficientes.';

        return [
            'page_title'    => $nome . ' | ' . $cargo,
            'page_desc'     => $descricao,
            'page_keywords' => $nome . ', ADS, Desenvolvedor, PHP, MySQL, Bootstrap, Portfólio, ' . $cargo,
        ];
    }

    /**
     * SEO da página de detalhes de um projeto.
     * Exemplo de title: "Sistema de Biblioteca | João Silva"
     */
    public function seoPaginaProjeto(array $projeto, array $perfil): array
    {
        $nomePerfil = $perfil['nome'] ?? 'Portfólio';
        $titulo     = $projeto['titulo'] ?? 'Projeto';
        $descricao  = mb_substr($projeto['descricao'] ?? '', 0, 160);
        $techs      = $projeto['tecnologias'] ?? '';

        if ($descricao === '') {
            $descricao = 'Detalhes do projeto ' . $titulo . ' no portfólio de ' . $nomePerfil . '.';
        }

        return [
            'page_title'    => $titulo . ' | ' . $nomePerfil,
            'page_desc'     => $descricao,
            'page_keywords' => $titulo . ', ' . $techs . ', projeto, portfólio, ' . $nomePerfil,
        ];
    }
}
