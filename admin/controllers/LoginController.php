<?php
/**
 * admin/controllers/LoginController.php
 * Lógica de autenticação do painel administrativo.
 */

require_once dirname(__DIR__) . '/auth/auth.php';

class LoginController
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Exibe formulário de login ou redireciona se já autenticado.
     */
    public function exibirLogin(): void
    {
        if (adminJaLogado()) {
            header('Location: ' . adminUrlBase() . 'dashboard.php');
            exit;
        }

        $dados = [
            'erro'    => '',
            'sucesso' => $this->mensagemLogout(),
            'email'   => adminSanitizar($_POST['email'] ?? ''),
            'timeout' => isset($_GET['timeout']),
            'recuperar_senha_habilitado' => false, // preparado para implementação futura
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
            'page_title'   => 'Login | Admin Portfólio',
            'show_sidebar' => false,
        ]);
    }

    /**
     * Valida credenciais e registra sessão segura.
     */
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

    /**
     * Encerra sessão e redireciona para login.
     */
    public function logout(): void
    {
        encerrarSessaoAdmin();
        header('Location: ' . adminLoginUrl() . '?logged_out=1');
        exit;
    }

    /**
     * Mensagem após logout ou timeout.
     */
    private function mensagemLogout(): string
    {
        if (isset($_GET['logged_out'])) {
            return 'Sessão encerrada com sucesso.';
        }

        return '';
    }

    /**
     * Valida URL de redirecionamento pós-login (evita open redirect).
     */
    private function urlRedirecionamentoSeguro(string $url): string
    {
        $padrao = adminUrlBase() . 'dashboard.php';

        if ($url === '' || !str_starts_with($url, '/')) {
            return $padrao;
        }

        if (str_contains($url, '//') || str_contains(strtolower($url), 'javascript:')) {
            return $padrao;
        }

        return $url;
    }

    /**
     * Estrutura preparada para recuperação de senha (implementação futura).
     */
    public function solicitarRecuperacaoSenha(string $email): array
    {
        return [
            'sucesso' => false,
            'erro'    => 'Recuperação de senha ainda não configurada. Contate o administrador do sistema.',
        ];
    }
}
