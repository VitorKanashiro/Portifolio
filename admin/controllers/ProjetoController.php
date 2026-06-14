<?php
// Controlador administrativo

require_once dirname(__DIR__) . '/auth/auth.php';

class ProjetoController
{
        private $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function listar()
    {
        exigirAutenticacao();

        $pagina   = max(1, (int) ($_GET['page'] ?? 1));
        $busca    = adminSanitizar($_GET['q'] ?? '');
        $porPagina = ADMIN_PROJETOS_POR_PAGINA;
        $offset   = ($pagina - 1) * $porPagina;

        if ($busca !== '') {
            $like = '%' . $busca . '%';
            $projetos = dbFetchAll(
                $this->conn,
                'SELECT * FROM projetos WHERE titulo LIKE ? OR tecnologias LIKE ? ORDER BY created_at DESC LIMIT ' . $porPagina . ' OFFSET ' . $offset,
                'ss',
                $like, $like
            );
            $totalCount = dbFetchScalar(
                $this->conn,
                'SELECT COUNT(*) AS total FROM projetos WHERE titulo LIKE ? OR tecnologias LIKE ?',
                'ss',
                $like, $like
            );
        } else {
            $projetos = dbFetchAll(
                $this->conn,
                'SELECT * FROM projetos ORDER BY created_at DESC LIMIT ' . $porPagina . ' OFFSET ' . $offset
            );
            $totalCount = dbFetchScalar($this->conn, 'SELECT COUNT(*) AS total FROM projetos');
        }

        $sucesso = $_GET['success'] ?? null;

        renderAdminView('projetos/listar', [
            'projetos'     => $projetos,
            'totalCount'   => $totalCount,
            'pagina'       => $pagina,
            'page'         => $pagina,
            'total_pages'  => (int) ceil($totalCount / $porPagina),
            'totalPages'   => (int) ceil($totalCount / $porPagina),
            'search'       => $busca,
            'sucesso_get'  => $sucesso ? adminMensagemSucesso($sucesso, [
                'created' => 'Projeto criado com sucesso!',
                'updated' => 'Projeto atualizado com sucesso!',
                'deleted' => 'Projeto excluÃ­do com sucesso!',
            ]) : '',
        ], ['page_title' => 'Projetos | Admin']);
    }

    public function criar()
    {
        exigirAutenticacao();

        $erro = '';
        $dadosForm = $this->dadosFormularioVazio();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->salvarNovo($_POST, $_FILES);
            if ($resultado['redirect']) {
                adminRedirect('index.php', 'created');
            }
            $erro       = $resultado['erro'];
            $dadosForm  = $resultado['dados'];
        }

        renderAdminView('projetos/criar', array_merge([
            'erro' => $erro,
        ], $dadosForm), ['page_title' => 'Criar Projeto | Admin']);
    }

    public function editar()
    {
        exigirAutenticacao();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: index.php');
            exit;
        }

        $projeto = dbFetchOne($this->conn, 'SELECT * FROM projetos WHERE id = ? LIMIT 1', 'i', $id);
        if (!$projeto) {
            header('Location: index.php');
            exit;
        }

        $erro = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->atualizar($id, $projeto, $_POST, $_FILES);
            if ($resultado['redirect']) {
                adminRedirect('index.php', 'updated');
            }
            $erro    = $resultado['erro'];
            $projeto = array_merge($projeto, $resultado['dados']);
        }

        renderAdminView('projetos/editar', [
            'proj' => $projeto,
            'erro' => $erro,
            'id'   => $id,
        ], ['page_title' => 'Editar Projeto | Admin']);
    }

    public function excluir()
    {
        exigirAutenticacao();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: index.php');
            exit;
        }

        $projeto = dbFetchOne($this->conn, 'SELECT imagem FROM projetos WHERE id = ? LIMIT 1', 'i', $id);

        if ($projeto) {
            adminRemoverUpload($projeto['imagem'] ?? '');
            dbExecute($this->conn, 'DELETE FROM projetos WHERE id = ?', 'i', $id);
        }

        adminRedirect('index.php', 'deleted');
    }

    private function salvarNovo(array $post, array $files): array
    {
        $dados = $this->extrairDados($post);
        $erro  = $this->validarDados($dados);

        if ($erro !== '') {
            return ['redirect' => false, 'erro' => $erro, 'dados' => $dados];
        }

        $upload = adminProcessarUpload($files['imagem'] ?? [], 'proj_');
        if ($upload['erro'] !== '') {
            return ['redirect' => false, 'erro' => $upload['erro'], 'dados' => $dados];
        }

        $ok = dbExecute(
            $this->conn,
            'INSERT INTO projetos (titulo, descricao, tecnologias, imagem, github, demo, destaque) VALUES (?, ?, ?, ?, ?, ?, ?)',
            'ssssssi',
            $dados['titulo'],
            $dados['descricao'],
            $dados['tecnologias'],
            $upload['arquivo'],
            $dados['github'],
            $dados['demo'],
            $dados['destaque']
        );

        if (!$ok) {
            return ['redirect' => false, 'erro' => 'Erro ao salvar projeto no banco de dados.', 'dados' => $dados];
        }

        return ['redirect' => true, 'erro' => '', 'dados' => $dados];
    }

    private function atualizar(int $id, array $projeto, array $post, array $files): array
    {
        $dados  = $this->extrairDados($post);
        $erro   = $this->validarDados($dados);
        $imagem = $projeto['imagem'] ?? '';

        if ($erro !== '') {
            return ['redirect' => false, 'erro' => $erro, 'dados' => $dados];
        }

        if (!empty($files['imagem']['name'])) {
            $upload = adminProcessarUpload($files['imagem'], 'proj_');
            if ($upload['erro'] !== '') {
                return ['redirect' => false, 'erro' => $upload['erro'], 'dados' => $dados];
            }
            if ($upload['arquivo'] !== '') {
                adminRemoverUpload($imagem);
                $imagem = $upload['arquivo'];
            }
        }

        if (isset($post['remover_imagem'])) {
            adminRemoverUpload($imagem);
            $imagem = '';
        }

        $ok = dbExecute(
            $this->conn,
            'UPDATE projetos SET titulo=?, descricao=?, tecnologias=?, imagem=?, github=?, demo=?, destaque=? WHERE id=?',
            'ssssssii',
            $dados['titulo'],
            $dados['descricao'],
            $dados['tecnologias'],
            $imagem,
            $dados['github'],
            $dados['demo'],
            $dados['destaque'],
            $id
        );

        if (!$ok) {
            return ['redirect' => false, 'erro' => 'Erro ao atualizar projeto.', 'dados' => $dados];
        }

        return ['redirect' => true, 'erro' => '', 'dados' => $dados];
    }

    private function extrairDados(array $post): array
    {
        return [
            'titulo'      => adminSanitizar($post['titulo'] ?? ''),
            'descricao'   => adminSanitizar($post['descricao'] ?? ''),
            'tecnologias' => adminSanitizar($post['tecnologias'] ?? ''),
            'github'      => adminSanitizarUrl($post['github'] ?? ''),
            'demo'        => adminSanitizarUrl($post['demo'] ?? ''),
            'destaque'    => isset($post['destaque']) ? 1 : 0,
        ];
    }

    private function validarDados(array $dados): string
    {
        if ($dados['titulo'] === '') {
            return 'O tÃ­tulo Ã© obrigatÃ³rio.';
        }

        return '';
    }

    private function dadosFormularioVazio(): array
    {
        return [
            'titulo' => '', 'descricao' => '', 'tecnologias' => '',
            'github' => '', 'demo' => '', 'destaque' => 0,
        ];
    }
}


