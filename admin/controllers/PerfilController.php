<?php
// Controlador administrativo

require_once dirname(__DIR__) . '/auth/auth.php';

class PerfilController
{
        private $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function editar()
    {
        exigirAutenticacao();

        $perfil = dbFetchOne($this->conn, 'SELECT * FROM perfil LIMIT 1');

        if (!$perfil) {
            dbExecute($this->conn, 'INSERT INTO perfil (nome) VALUES (?)', 's', 'Seu Nome');
            $perfil = dbFetchOne($this->conn, 'SELECT * FROM perfil LIMIT 1');
        }

        $erro    = '';
        $sucesso = ($_GET['success'] ?? '') === 'updated' ? 'Perfil atualizado com sucesso!' : '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->atualizar((int) $perfil['id'], $perfil, $_POST, $_FILES);
            if ($resultado['sucesso'] !== '') {
                adminRedirect(adminWebPath() . 'perfil', 'updated');
            }
            $erro      = $resultado['erro'];
            $perfil    = dbFetchOne($this->conn, 'SELECT * FROM perfil LIMIT 1') ?? $perfil;
        }

        renderAdminView('perfil', [
            'perfil'  => $perfil,
            'erro'    => $erro,
            'sucesso' => $sucesso,
        ], ['page_title' => 'Editar Perfil | Admin']);
    }

    private function atualizar(int $id, array $perfil, array $post, array $files): array
    {
        $nome      = adminSanitizar($post['nome'] ?? '');
        $cargo     = adminSanitizar($post['cargo'] ?? '');
        $frase     = adminSanitizar($post['frase'] ?? '');
        $subtitulo = adminSanitizar($post['subtitulo'] ?? '');
        $github    = adminSanitizarUrl($post['github'] ?? '');
        $linkedin  = adminSanitizarUrl($post['linkedin'] ?? '');
        $foto      = $perfil['foto'] ?? '';

        if ($nome === '') {
            return ['erro' => 'O nome é obrigatório.', 'sucesso' => ''];
        }

        if (!empty($files['foto']['name'])) {
            $upload = adminProcessarUpload($files['foto'], 'perfil_');
            if ($upload['erro'] !== '') {
                return ['erro' => $upload['erro'], 'sucesso' => ''];
            }
            if ($upload['arquivo'] !== '') {
                adminRemoverUpload($foto);
                $foto = $upload['arquivo'];
            }
        }

        $ok = dbExecute(
            $this->conn,
            'UPDATE perfil SET nome=?, cargo=?, frase=?, subtitulo=?, github=?, linkedin=?, foto=? WHERE id=?',
            'sssssssi',
            $nome, $cargo, $frase, $subtitulo, $github, $linkedin, $foto, $id
        );

        return $ok
            ? ['erro' => '', 'sucesso' => 'Perfil atualizado com sucesso!']
            : ['erro' => 'Erro ao salvar perfil.', 'sucesso' => ''];
    }
}


