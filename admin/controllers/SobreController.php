<?php
// Controlador administrativo

require_once dirname(__DIR__) . '/auth/auth.php';

class SobreController
{
        private $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function editar()
    {
        exigirAutenticacao();

        $sobre = dbFetchOne($this->conn, 'SELECT * FROM sobre LIMIT 1');

        if (!$sobre) {
            dbExecute($this->conn, 'INSERT INTO sobre (titulo) VALUES (?)', 's', 'Sobre Mim');
            $sobre = dbFetchOne($this->conn, 'SELECT * FROM sobre LIMIT 1');
        }

        $erro    = '';
        $sucesso = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->atualizar((int) $sobre['id'], $sobre, $_POST, $_FILES);
            $erro      = $resultado['erro'];
            $sucesso   = $resultado['sucesso'];
            $sobre     = dbFetchOne($this->conn, 'SELECT * FROM sobre LIMIT 1') ?? $sobre;
        }

        renderAdminView('sobre', [
            'sobre'   => $sobre,
            'erro'    => $erro,
            'sucesso' => $sucesso,
        ], ['page_title' => 'Editar Sobre Mim | Admin']);
    }

    private function atualizar(int $id, array $sobre, array $post, array $files): array
    {
        $titulo         = adminSanitizar($post['titulo'] ?? '');
        $descricao      = adminSanitizar($post['descricao'] ?? '');
        $biografia      = adminSanitizar($post['biografia'] ?? '');
        $objetivos      = adminSanitizar($post['objetivos'] ?? '');
        $experiencia    = adminSanitizar($post['experiencia'] ?? '');
        $projetosCount  = adminSanitizar($post['projetos_count'] ?? '');
        $foto           = $sobre['foto'] ?? '';

        if ($titulo === '') {
            return ['erro' => 'O tÃ­tulo Ã© obrigatÃ³rio.', 'sucesso' => ''];
        }

        if (!empty($files['foto']['name'])) {
            $upload = adminProcessarUpload($files['foto'], 'sobre_');
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
            'UPDATE sobre SET titulo=?, descricao=?, biografia=?, objetivos=?, experiencia=?, projetos_count=?, foto=? WHERE id=?',
            'sssssssi',
            $titulo, $descricao, $biografia, $objetivos, $experiencia, $projetosCount, $foto, $id
        );

        return $ok
            ? ['erro' => '', 'sucesso' => 'InformaÃ§Ãµes sobre vocÃª atualizadas com sucesso!']
            : ['erro' => 'Erro ao salvar informaÃ§Ãµes.', 'sucesso' => ''];
    }
}


