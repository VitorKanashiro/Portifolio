<?php
// Controlador administrativo

require_once dirname(__DIR__) . '/auth/auth.php';

class ContatoController
{
        private $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function editar()
    {
        exigirAutenticacao();

        $contato = dbFetchOne($this->conn, 'SELECT * FROM contato LIMIT 1');

        if (!$contato) {
            dbExecute($this->conn, 'INSERT INTO contato (email) VALUES (?)', 's', 'seu@email.com');
            $contato = dbFetchOne($this->conn, 'SELECT * FROM contato LIMIT 1');
        }

        $erro    = '';
        $sucesso = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->atualizar((int) $contato['id'], $_POST);
            $erro      = $resultado['erro'];
            $sucesso   = $resultado['sucesso'];
            $contato   = dbFetchOne($this->conn, 'SELECT * FROM contato LIMIT 1') ?? $contato;
        }

        renderAdminView('contato', [
            'contato' => $contato,
            'erro'    => $erro,
            'sucesso' => $sucesso,
        ], ['page_title' => 'Editar Contato | Admin']);
    }

    private function atualizar(int $id, array $post): array
    {
        $email    = adminSanitizar($post['email'] ?? '');
        $telefone = adminSanitizar($post['telefone'] ?? '');
        $cidade   = adminSanitizar($post['cidade'] ?? '');
        $mensagem = adminSanitizar($post['mensagem'] ?? '');

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['erro' => 'Informe um e-mail vÃ¡lido.', 'sucesso' => ''];
        }

        $ok = dbExecute(
            $this->conn,
            'UPDATE contato SET email=?, telefone=?, cidade=?, mensagem=? WHERE id=?',
            'ssssi',
            $email, $telefone, $cidade, $mensagem, $id
        );

        return $ok
            ? ['erro' => '', 'sucesso' => 'InformaÃ§Ãµes de contato atualizadas com sucesso!']
            : ['erro' => 'Erro ao salvar informaÃ§Ãµes de contato.', 'sucesso' => ''];
    }
}


