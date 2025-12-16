<?php
require_once __DIR__ . '/../models/UsuarioModel.php';

class UsuarioController {
    private $model;

    public function __construct() {
        $this->model = new UsuarioModel();
    }

    public function listar() {
        $usuarios = $this->model->listarTodos();
        require_once __DIR__ . '/../views/usuarios/listar.php';
    }

    public function editar() {
        if (!isset($_GET['id'])) {
            header('Location: index.php?action=listar');
            exit();
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $usuario = $this->model->buscarPorId($id);

        if (!$usuario) {
            header('Location: index.php?action=listar&erro=usuario_nao_encontrado');
            exit();
        }

        require_once __DIR__ . '/../views/usuarios/editar.php';
    }

    public function atualizar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=listar');
            exit();
        }

        $id  = trim($_POST['id']);
        $nome = trim($_POST['nome']);
        $email = $_POST['email'];

        if (!$id || empty($nome) || empty($email)) {
            header('Location: index.php?action=editar&id=' . $id . '&erro=campos_vazios');
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Location: index.php?action=editar&id=' . $id . '&erro=email_invalido');
            exit();
        }

        if ($this->model->verificarEmailExiste($email, $id)) {
            header('Location: index.php?action=editar&id=' . $id . '&erro=email_existente');
            exit();
        }

        if ($this->model->atualizar($id, $nome, $email)) {
            header('Location: index.php?action=listar&sucesso=atualizado');
            exit();
        } else {
            header('Location: index.php?action=editar&id=' . $id . '&erro=erro_atualizacao');
            exit();
        }
    }

    public function remover() {
        if (!isset($_GET['id'])) {
            header('Location: index.php?action=listar');
            exit();
        }

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $usuario = $this->model->buscarPorId($id);

        if (!$usuario) {
            header('Location: index.php?action=listar&erro=usuario_nao_encontrado');
            exit();
        }

        require_once __DIR__ . '/../views/usuarios/remover.php';
    }

    public function confirmarRemocao() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=listar');
            exit();
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: index.php?action=listar&erro=id_invalido');
            exit();
        }

        if ($this->model->remover($id)) {
            header('Location: index.php?action=listar&sucesso=removido');
            exit();
        } else {
            header('Location: index.php?action=listar&erro=erro_remocao');
            exit();
        }
    }

    public function logout() {
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        header('Location: ../TelaLogin/Login.php');
        exit();
    }
}
