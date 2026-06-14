<?php
// Controlador administrativo

require_once dirname(__DIR__) . '/auth/auth.php';

class RedeController
{
        private $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function listar()
    {
        exigirAutenticacao();

        $redes = dbFetchAll($this->conn, 'SELECT * FROM redes_sociais ORDER BY ordem ASC');

        $sucesso = $_GET['success'] ?? null;

        renderAdminView('redes/listar', [
            'redes'       => $redes,
            'sucesso_get' => $sucesso ? adminMensagemSucesso($sucesso, [
                'created' => 'Rede social adicionada!',
                'updated' => 'Rede social atualizada!',
                'deleted' => 'Rede social excluÃ­da!',
            ]) : '',
        ], ['page_title' => 'Redes Sociais | Admin']);
    }

    public function criar()
    {
        exigirAutenticacao();

        $erro  = '';
        $dados = ['plataforma' => '', 'link' => '', 'icone' => '', 'ativo' => 1, 'ordem' => 0];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->inserir($_POST);
            if ($resultado['redirect']) {
                adminRedirect('index.php', 'created');
            }
            $erro  = $resultado['erro'];
            $dados = $resultado['dados'];
        }

        renderAdminView('redes/criar', array_merge([
            'erro'            => $erro,
            'iconSuggestions' => $this->iconesSugeridos(),
        ], $dados), ['page_title' => 'Nova Rede Social | Admin']);
    }

    public function editar()
    {
        exigirAutenticacao();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: index.php');
            exit;
        }

        $rede = dbFetchOne($this->conn, 'SELECT * FROM redes_sociais WHERE id = ? LIMIT 1', 'i', $id);
        if (!$rede) {
            header('Location: index.php');
            exit;
        }

        $erro = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->atualizar($id, $_POST);
            if ($resultado['redirect']) {
                adminRedirect('index.php', 'updated');
            }
            $erro = $resultado['erro'];
            $rede = array_merge($rede, $resultado['dados']);
        }

        renderAdminView('redes/editar', [
            'rede'            => $rede,
            'erro'            => $erro,
            'iconSuggestions' => $this->iconesSugeridos(),
        ], ['page_title' => 'Editar Rede Social | Admin']);
    }

    public function excluir()
    {
        exigirAutenticacao();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            dbExecute($this->conn, 'DELETE FROM redes_sociais WHERE id = ?', 'i', $id);
        }

        adminRedirect('index.php', 'deleted');
    }

    private function inserir(array $post): array
    {
        $dados = $this->extrairDados($post);
        $erro  = $this->validar($dados);

        if ($erro !== '') {
            return ['redirect' => false, 'erro' => $erro, 'dados' => $dados];
        }

        $ok = dbExecute(
            $this->conn,
            'INSERT INTO redes_sociais (plataforma, link, icone, ativo, ordem) VALUES (?, ?, ?, ?, ?)',
            'sssii',
            $dados['plataforma'], $dados['link'], $dados['icone'], $dados['ativo'], $dados['ordem']
        );

        return $ok
            ? ['redirect' => true, 'erro' => '', 'dados' => $dados]
            : ['redirect' => false, 'erro' => 'Erro ao salvar rede social.', 'dados' => $dados];
    }

    private function atualizar(int $id, array $post): array
    {
        $dados = $this->extrairDados($post);
        $erro  = $this->validar($dados);

        if ($erro !== '') {
            return ['redirect' => false, 'erro' => $erro, 'dados' => $dados];
        }

        $ok = dbExecute(
            $this->conn,
            'UPDATE redes_sociais SET plataforma=?, link=?, icone=?, ativo=?, ordem=? WHERE id=?',
            'sssiii',
            $dados['plataforma'], $dados['link'], $dados['icone'], $dados['ativo'], $dados['ordem'], $id
        );

        return $ok
            ? ['redirect' => true, 'erro' => '', 'dados' => $dados]
            : ['redirect' => false, 'erro' => 'Erro ao atualizar rede social.', 'dados' => $dados];
    }

    private function extrairDados(array $post): array
    {
        return [
            'plataforma' => adminSanitizar($post['plataforma'] ?? ''),
            'link'       => adminSanitizarUrl($post['link'] ?? ''),
            'icone'      => adminSanitizar($post['icone'] ?? ''),
            'ativo'      => isset($post['ativo']) ? 1 : 0,
            'ordem'      => max(0, (int) ($post['ordem'] ?? 0)),
        ];
    }

    private function iconesSugeridos(): array
    {
        return [
            'bi-github', 'bi-linkedin', 'bi-instagram', 'bi-twitter-x',
            'bi-facebook', 'bi-youtube', 'bi-tiktok', 'bi-whatsapp',
            'bi-telegram', 'bi-discord', 'bi-twitch', 'bi-medium',
        ];
    }

    private function validar(array $dados): string
    {
        if ($dados['plataforma'] === '') {
            return 'O nome da plataforma Ã© obrigatÃ³rio.';
        }
        if ($dados['link'] === '') {
            return 'O link Ã© obrigatÃ³rio e deve ser uma URL vÃ¡lida.';
        }

        return '';
    }
}


