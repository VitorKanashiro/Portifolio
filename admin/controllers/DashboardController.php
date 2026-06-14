<?php
// Controlador administrativo

require_once dirname(__DIR__) . '/auth/auth.php';

class DashboardController
{
        private $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function index()
    {
        exigirAutenticacao();

        renderAdminView('dashboard', [
            'total_projetos'     => dbFetchScalar($this->conn, 'SELECT COUNT(*) AS total FROM projetos'),
            'total_tecnologias'  => dbFetchScalar($this->conn, 'SELECT COUNT(*) AS total FROM tecnologias'),
            'total_redes'        => dbFetchScalar($this->conn, 'SELECT COUNT(*) AS total FROM redes_sociais WHERE ativo = 1'),
            'total_mensagens'    => dbFetchScalar($this->conn, 'SELECT COUNT(*) AS total FROM mensagens WHERE lida = 0'),
            'projetos_recentes'  => dbFetchAll($this->conn, 'SELECT * FROM projetos ORDER BY created_at DESC LIMIT 6'),
            'mensagens_recentes' => dbFetchAll($this->conn, 'SELECT * FROM mensagens ORDER BY created_at DESC LIMIT 5'),
            'admin_email'        => adminEmailLogado(),
        ], ['page_title' => 'Dashboard | Admin Portfólio']);
    }
}


