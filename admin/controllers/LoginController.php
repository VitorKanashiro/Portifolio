<?php
// Controlador administrativo

require_once dirname(__DIR__) . '/auth/auth.php';

class LoginController
{
        private $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

        public function exibirLogin()
    {
        if (adminJaLogado()) {
            header('Location: ' . adminUrlBase() . 'dashboard');
            exit;
        }

        $dados = [
            'erro'    => '',
            'sucesso' => $this->mensagemLogout(),
            'email'   => adminSanitizar($_POST['email'] ?? ''),
            'timeout' => isset($_GET['timeout']),
            'recuperar_senha_habilitado' => false, // preparado para implementaÃ§Ã£o futura
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $this->autenticar();
            if ($resultado['sucesso']) {
                $redirect = $this->urlRedirecionamentoSeguro($_GET['redirect'] ?? '');
                header('Location: ' . $redirect);
                exit;
            }
            $dados['erro']  = $resultado['erro'];
            $dados['email'] = $resultado['email'];
        }

        renderAdminView('auth/login', $dados, [
            'page_title'   => 'Login | Admin PortfÃ³lio',
            'show_sidebar' => false,
        ]);
    }

        public function autenticar(): array
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $senha = $_POST['senha'] ?? '';

        if (!$email || $senha === '') {
            return [
                'sucesso' => false,
                'erro'    => 'Por favor, preencha todos os campos corretamente.',
                'email'   => adminSanitizar($_POST['email'] ?? ''),
            ];
        }

        $admin = dbFetchOne(
            $this->conn,
            'SELECT id, email, senha FROM admin WHERE email = ? LIMIT 1',
            's',
            $email
        );

        if (!$admin || !password_verify($senha, $admin['senha'])) {
            return [
                'sucesso' => false,
                'erro'    => 'E-mail ou senha incorretos. Verifique suas credenciais.',
                'email'   => adminSanitizar($email),
            ];
        }

        registrarSessaoAdmin($admin);

        return ['sucesso' => true, 'erro' => '', 'email' => ''];
    }

        public function logout()
    {
        encerrarSessaoAdmin();
        header('Location: ' . adminLoginUrl() . '?logged_out=1');
        exit;
    }

        private function mensagemLogout(): string
    {
        if (isset($_GET['logged_out'])) {
            return 'SessÃ£o encerrada com sucesso.';
        }

        return '';
    }

        private function urlRedirecionamentoSeguro(string $url): string
    {
        $padrao = adminUrlBase() . 'dashboard';

        if ($url === '' || !str_starts_with($url, '/')) {
            return $padrao;
        }

        if (str_contains($url, '//') || str_contains(strtolower($url), 'javascript:')) {
            return $padrao;
        }

        return $url;
    }

        public function solicitarRecuperacaoSenha(string $email): array
    {
        return [
            'sucesso' => false,
            'erro'    => 'RecuperaÃ§Ã£o de senha ainda nÃ£o configurada. Contate o administrador do sistema.',
        ];
    }
}


