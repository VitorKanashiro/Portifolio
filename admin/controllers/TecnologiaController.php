<?php
// Controlador administrativo

require_once dirname(__DIR__) . '/auth/auth.php';

class TecnologiaController
{
        private $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function listar()
    {
        exigirAutenticacao();

        $tecnologias = dbFetchAll(
            $this->conn,
            'SELECT * FROM tecnologias ORDER BY nivel_percentual DESC'
        );

        $sucesso = $_GET['success'] ?? null;

        renderAdminView('tecnologias/listar', [
            'tecnologias' => $tecnologias,
            'sucesso_get' => $sucesso ? adminMensagemSucesso($sucesso, [
                'created' => 'Tecnologia criada!',
                'updated' => 'Tecnologia atualizada!',
                'deleted' => 'Tecnologia excluída!',
            ]) : '',
        ], ['page_title' => 'Tecnologias | Admin']);
    }

    public function criar()
    {
        exigirAutenticacao();

        $erro = '';
        $dados = ['nome' => '', 'icone' => '', 'nivel' => 'Intermediário'];
        $iconesSugeridos = $this->iconesSugeridos();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->inserir($_POST);
            if ($resultado['redirect']) {
                adminRedirect(adminWebPath() . 'tecnologias', 'created');
            }
            $erro  = $resultado['erro'];
            $dados = $resultado['dados'];
        }

        renderAdminView('tecnologias/criar', array_merge([
            'erro'             => $erro,
            'iconSuggestions'  => $iconesSugeridos,
        ], $dados), ['page_title' => 'Nova Tecnologia | Admin']);
    }

    public function editar()
    {
        exigirAutenticacao();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: ' . adminWebPath() . 'tecnologias');
            exit;
        }

        $tech = dbFetchOne($this->conn, 'SELECT * FROM tecnologias WHERE id = ? LIMIT 1', 'i', $id);
        if (!$tech) {
            header('Location: ' . adminWebPath() . 'tecnologias');
            exit;
        }

        $erro = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->atualizar($id, $_POST);
            if ($resultado['redirect']) {
                adminRedirect(adminWebPath() . 'tecnologias', 'updated');
            }
            $erro = $resultado['erro'];
            $tech = array_merge($tech, $resultado['dados']);
        }

        renderAdminView('tecnologias/editar', [
            'tec'               => $tech,
            'erro'              => $erro,
            'iconSuggestions'   => $this->iconesSugeridos(),
        ], ['page_title' => 'Editar Tecnologia | Admin']);
    }

    public function excluir()
    {
        exigirAutenticacao();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            dbExecute($this->conn, 'DELETE FROM tecnologias WHERE id = ?', 'i', $id);
        }

        adminRedirect(adminWebPath() . 'tecnologias', 'deleted');
    }

    private function inserir(array $post): array
    {
        $dados = $this->extrairDados($post);
        $erro  = $dados['nome'] === '' ? 'O nome é obrigatório.' : '';

        if ($erro !== '') {
            return ['redirect' => false, 'erro' => $erro, 'dados' => $dados];
        }

        $percentual = adminNivelPercentual($dados['nivel']);

        $ok = dbExecute(
            $this->conn,
            'INSERT INTO tecnologias (nome, icone, nivel, nivel_percentual) VALUES (?, ?, ?, ?)',
            'sssi',
            $dados['nome'], $dados['icone'], $dados['nivel'], $percentual
        );

        return $ok
            ? ['redirect' => true, 'erro' => '', 'dados' => $dados]
            : ['redirect' => false, 'erro' => 'Erro ao salvar tecnologia.', 'dados' => $dados];
    }

    private function atualizar(int $id, array $post): array
    {
        $dados = $this->extrairDados($post);
        $erro  = $dados['nome'] === '' ? 'O nome é obrigatório.' : '';

        if ($erro !== '') {
            return ['redirect' => false, 'erro' => $erro, 'dados' => $dados];
        }

        $percentual = adminNivelPercentual($dados['nivel']);

        $ok = dbExecute(
            $this->conn,
            'UPDATE tecnologias SET nome=?, icone=?, nivel=?, nivel_percentual=? WHERE id=?',
            'sssii',
            $dados['nome'], $dados['icone'], $dados['nivel'], $percentual, $id
        );

        return $ok
            ? ['redirect' => true, 'erro' => '', 'dados' => $dados]
            : ['redirect' => false, 'erro' => 'Erro ao atualizar tecnologia.', 'dados' => $dados];
    }

    private function extrairDados(array $post): array
    {
        $niveisValidos = ['Básico', 'Intermediário', 'Avançado', 'Expert'];
        $nivel = adminSanitizar($post['nivel'] ?? 'Intermediário');

        if (!in_array($nivel, $niveisValidos, true)) {
            $nivel = 'Intermediário';
        }

        return [
            'nome'  => adminSanitizar($post['nome'] ?? ''),
            'icone' => adminSanitizar($post['icone'] ?? ''),
            'nivel' => $nivel,
        ];
    }

    private function iconesSugeridos(): array
    {
        return [
            'bi-filetype-html', 'bi-filetype-css', 'bi-filetype-js', 'bi-filetype-php',
            'bi-filetype-java', 'bi-filetype-py', 'bi-bootstrap', 'bi-database',
            'bi-git', 'bi-github', 'bi-node-plus', 'bi-code-slash', 'bi-terminal',
            'bi-cpu', 'bi-cloud', 'bi-server', 'bi-layout-wtf', 'bi-boxes',
        ];
    }
}


