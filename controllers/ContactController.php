<?php
/**
 * controllers/ContactController.php
 * Responsável pelo processamento do formulário de contato.
 * Utiliza o padrão PRG (Post-Redirect-Get) para evitar reenvio duplicado.
 */

class ContactController
{
    /** @var mysqli Conexão ativa com o MySQL */
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Processa o envio do formulário de contato (POST).
     * Redireciona com mensagem de sucesso ou erro via sessão/GET.
     */
    public function processarFormulario(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['contact_form_submitted'])) {
            return;
        }

        $nome    = trim(strip_tags($_POST['nome']     ?? ''));
        $email   = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $assunto = trim(strip_tags($_POST['assunto']  ?? ''));
        $mensagem = trim(strip_tags($_POST['mensagem'] ?? ''));

        if ($nome && $email && $mensagem) {
            $sql = "INSERT INTO mensagens (nome, email, assunto, mensagem) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($this->conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssss', $nome, $email, $assunto, $mensagem);
                $executou = mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                if ($executou) {
                    header('Location: ' . siteUrl('index.php?contato=ok'));
                    exit;
                }
            }

            $_SESSION['contato_error'] = 'Erro ao enviar mensagem. Tente novamente.';
            header('Location: ' . siteUrl('index.php?contato=erro'));
            exit;
        }

        $_SESSION['contato_error'] = 'Por favor, preencha todos os campos obrigatórios com informações válidas.';
        header('Location: ' . siteUrl('index.php?contato=erro'));
        exit;
    }

    /**
     * Recupera mensagens flash após redirect do formulário.
     * Retorna: msg_success, msg_error e scroll_to_contato.
     */
    public function recuperarMensagens(): array
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $msgSuccess       = '';
        $msgError         = '';
        $scrollToContato  = false;

        if (isset($_GET['contato'])) {
            $scrollToContato = true;

            if ($_GET['contato'] === 'ok') {
                $msgSuccess = 'Mensagem enviada com sucesso! Em breve retornarei o contato.';
            }
        }

        if (isset($_SESSION['contato_error'])) {
            $msgError = $_SESSION['contato_error'];
            unset($_SESSION['contato_error']);
        }

        return [
            'msg_success'       => $msgSuccess,
            'msg_error'         => $msgError,
            'scroll_to_contato' => $scrollToContato,
        ];
    }
}
