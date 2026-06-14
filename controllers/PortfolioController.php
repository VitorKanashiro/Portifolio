<?php
// Controlador do portfólio

require_once dirname(__DIR__) . '/includes/helpers.php';

class PortfolioController
{
        private $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    // CONSULTAS AO BANCO DE DADOS
    // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

        public function buscarPerfil(): array
    {
        $resultado = mysqli_query($this->conn, 'SELECT * FROM perfil LIMIT 1');

        return mysqli_fetch_assoc($resultado) ?: [];
    }

        public function buscarSobre(): array
    {
        $resultado = mysqli_query($this->conn, 'SELECT * FROM sobre LIMIT 1');

        return mysqli_fetch_assoc($resultado) ?: [];
    }

        public function buscarContato(): array
    {
        $resultado = mysqli_query($this->conn, 'SELECT * FROM contato LIMIT 1');

        return mysqli_fetch_assoc($resultado) ?: [];
    }

        public function buscarProjetos(): array
    {
        $resultado = mysqli_query(
            $this->conn,
            'SELECT * FROM projetos ORDER BY destaque DESC, created_at DESC'
        );

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC) ?: [];
    }

        public function buscarTecnologias(): array
    {
        $resultado = mysqli_query(
            $this->conn,
            'SELECT * FROM tecnologias ORDER BY nivel_percentual DESC'
        );

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC) ?: [];
    }

        public function buscarRedesSociais(): array
    {
        $resultado = mysqli_query(
            $this->conn,
            'SELECT * FROM redes_sociais WHERE ativo = 1 ORDER BY ordem ASC'
        );

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC) ?: [];
    }

        public function buscarProjetoPorId(int $id)
    {
        $id        = (int) $id;
        $resultado = mysqli_query($this->conn, "SELECT * FROM projetos WHERE id = '$id' LIMIT 1");
        $projeto   = mysqli_fetch_assoc($resultado);

        return $projeto ?: null;
    }

        public function buscarProjetoPorSlug(string $slug)
    {
        $projetos = $this->buscarProjetos();

        foreach ($projetos as $projeto) {
            if ($this->gerarSlugProjeto($projeto) === $slug) {
                return $projeto;
            }
        }

        return null;
    }

    // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    // DADOS COMBINADOS PARA A PÃGINA INICIAL
    // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

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

        public function normalizarPerfil(array $perfil): array
    {
        return [
            'nome'     => $perfil['nome']      ?? 'Desenvolvedor Full Stack',
            'cargo'    => $perfil['cargo']     ?? 'Desenvolvedor Full Stack',
            'frase'    => $perfil['frase']     ?? 'Transformando ideias em cÃ³digo.',
            'sub'      => $perfil['subtitulo'] ?? 'Criando soluÃ§Ãµes web modernas e escalÃ¡veis.',
            'github'   => $perfil['github']    ?? '#',
            'linkedin' => $perfil['linkedin']  ?? '#',
            'foto'     => $perfil['foto']      ?? '',
        ];
    }

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

    // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    // URLs amigÃ¡veis dos projetos
    // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

        public function gerarSlugProjeto(array $projeto): string
    {
        return gerarSlugProjeto($projeto);
    }

        public function urlProjeto(array $projeto): string
    {
        return urlProjeto($projeto);
    }

    // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    // SEO BÃSICO â€” title, description e keywords por pÃ¡gina
    // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

        public function seoPaginaInicial(array $dados): array
    {
        $nome  = $dados['nome']  ?? 'PortfÃ³lio';
        $cargo = $dados['cargo'] ?? 'Desenvolvedor';
        $sub   = $dados['sub']   ?? '';

        $descricao = $sub !== ''
            ? $sub
            : 'PortfÃ³lio de ' . $nome . ', estudante de ADS e desenvolvedor focado em criar soluÃ§Ãµes modernas e eficientes.';

        return [
            'page_title'    => $nome . ' | ' . $cargo,
            'page_desc'     => $descricao,
            'page_keywords' => $nome . ', ADS, Desenvolvedor, PHP, MySQL, Bootstrap, PortfÃ³lio, ' . $cargo,
        ];
    }

        public function seoPaginaProjeto(array $projeto, array $perfil): array
    {
        $nomePerfil = $perfil['nome'] ?? 'PortfÃ³lio';
        $titulo     = $projeto['titulo'] ?? 'Projeto';
        $descricao  = mb_substr($projeto['descricao'] ?? '', 0, 160);
        $techs      = $projeto['tecnologias'] ?? '';

        if ($descricao === '') {
            $descricao = 'Detalhes do projeto ' . $titulo . ' no portfÃ³lio de ' . $nomePerfil . '.';
        }

        return [
            'page_title'    => $titulo . ' | ' . $nomePerfil,
            'page_desc'     => $descricao,
            'page_keywords' => $titulo . ', ' . $techs . ', projeto, portfÃ³lio, ' . $nomePerfil,
        ];
    }
}


