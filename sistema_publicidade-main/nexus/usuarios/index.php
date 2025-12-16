<?php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../TelaLogin/Login.php');
    exit();
}

require_once __DIR__ . '/../controllers/UsuarioController.php';

$action = $_GET['action'] ?? 'listar';
$controller = new UsuarioController();

switch ($action) {
    case 'listar':
        $controller->listar();
        break;
    case 'editar':
        $controller->editar();
        break;
    case 'atualizar':
        $controller->atualizar();
        break;
    case 'remover':
        $controller->remover();
        break;
    case 'confirmarRemocao':
        $controller->confirmarRemocao();
        break;
    case 'logout':
        $controller->logout();
        break;
    default:
        $controller->listar();
        break;
}
