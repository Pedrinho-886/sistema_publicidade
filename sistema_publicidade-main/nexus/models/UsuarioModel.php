<?php
require_once __DIR__ . '/../config/database.php';

class UsuarioModel {
    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnection();
    }

    public function listarTodos() {
        $stmt = $this->pdo->prepare("SELECT id, nome, email, data_cadastro FROM usuarios ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("SELECT id, nome, email FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $nome, $email) {
        $stmt = $this->pdo->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
        return $stmt->execute([$nome, $email, $id]);
    }

    public function remover($id) {
        $stmt = $this->pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function verificarEmailExiste($email, $idExcluir = null) {
        if ($idExcluir) {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ? AND id != ?");
            $stmt->execute([$email, $idExcluir]);
        } else {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
        }
        return $stmt->fetchColumn() > 0;
    }
}
