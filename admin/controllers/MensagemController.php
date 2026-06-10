<?php
/**
 * admin/controllers/MensagemController.php
 * Gerenciamento da caixa de entrada (mensagens do formulário público).
 */

require_once dirname(__DIR__) . '/auth/auth.php';

class MensagemController
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function listar(): void
    {
        exigirAutenticacao();

        if (isset($_GET['action']) && $_GET['action'] === 'ler') {
            $this->marcarComoLida((int) ($_GET['id'] ?? 0));
            header('Location: index.php');
            exit;
        }

        if (isset($_GET['action']) && $_GET['action'] === 'ler_todas') {
            dbExecute($this->conn, 'UPDATE mensagens SET lida = 1 WHERE lida = 0');
            adminRedirect('index.php', 'readall');
        }

        $pagina   = max(1, (int) ($_GET['p'] ?? 1));
        $porPagina = ADMIN_MENSAGENS_POR_PAGINA;
        $offset   = ($pagina - 1) * $porPagina;
        $total    = dbFetchScalar($this->conn, 'SELECT COUNT(*) AS total FROM mensagens');

        $mensagens = dbFetchAll(
            $this->conn,
            'SELECT * FROM mensagens ORDER BY lida ASC, created_at DESC LIMIT ' . $porPagina . ' OFFSET ' . $offset
        );

        $sucesso = $_GET['success'] ?? null;

        renderAdminView('mensagens/listar', [
            'mensagens'   => $mensagens,
            'total'       => $total,
            'pagina'      => $pagina,
            'page'        => $pagina,
            'total_pages' => (int) ceil($total / $porPagina),
            'totalPages'  => (int) ceil($total / $porPagina),
            'sucesso_get' => $sucesso ? adminMensagemSucesso($sucesso, [
                'deleted' => 'Mensagem excluída com sucesso!',
                'readall' => 'Todas as mensagens foram marcadas como lidas!',
            ]) : '',
        ], [
            'page_title'  => 'Mensagens | Admin',
            'extra_styles' => $this->estilosPaginacao(),
        ]);
    }

    public function excluir(): void
    {
        exigirAutenticacao();

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            dbExecute($this->conn, 'DELETE FROM mensagens WHERE id = ?', 'i', $id);
        }

        adminRedirect('index.php', 'deleted');
    }

    private function marcarComoLida(int $id): void
    {
        if ($id > 0) {
            dbExecute($this->conn, 'UPDATE mensagens SET lida = 1 WHERE id = ?', 'i', $id);
        }
    }

    private function estilosPaginacao(): string
    {
        return '<style>
.hover-primary:hover { color: var(--primary-light) !important; }
.pagination .page-link { color: var(--text-muted); margin: 0 0.2rem; border-radius: 8px; }
.pagination .page-link:hover { background: rgba(124,58,237,0.2); color: var(--text-primary); }
.pagination .active .page-link { background: var(--primary) !important; color: white !important; }
.pagination .disabled .page-link { opacity: 0.5; background: rgba(255,255,255,0.05) !important; }
</style>';
    }
}
