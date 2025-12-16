<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários - Nexus</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" referrerpolicy="no-referrer" />
    <style>
        .container-usuarios {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }
        .header-usuarios {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .header-usuarios h1 {
            color: #333;
            margin: 0;
        }
        .btn-voltar {
            padding: 10px 20px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .btn-voltar:hover {
            background: #5a6268;
        }
        .btn-logout {
            padding: 10px 20px;
            background: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-left: 10px;
        }
        .btn-logout:hover {
            background: #c82333;
        }
        .header-actions {
            display: flex;
            align-items: center;
        }
        .mensagem {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .mensagem.sucesso {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .mensagem.erro {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #191919ff;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .acoes {
            display: flex;
            gap: 10px;
        }
        .btn-editar, .btn-remover {
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }
        .btn-editar {
            background: #007bff;
            color: white;
        }
        .btn-editar:hover {
            background: #0056b3;
        }
        .btn-remover {
            background: #dc3545;
            color: white;
        }
        .btn-remover:hover {
            background: #c82333;
        }
        .sem-usuarios {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container-usuarios">
        <div class="header-usuarios">
            <h1>Gerenciar Usuários</h1>
            <div class="header-actions">
                <a href="../telaprincipal/telaprincipal.html" class="btn-voltar">Voltar</a>
                <a href="../usuarios/index.php?action=logout" class="btn-logout">Sair</a>
            </div>
        </div>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="mensagem sucesso">
                <?php
                if ($_GET['sucesso'] === 'atualizado') {
                    echo 'Usuário atualizado com sucesso!';
                } elseif ($_GET['sucesso'] === 'removido') {
                    echo 'Usuário removido com sucesso!';
                }
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['erro'])): ?>
            <div class="mensagem erro">
                <?php
                $erros = [
                    'usuario_nao_encontrado' => 'Usuário não encontrado.',
                    'campos_vazios' => 'Por favor, preencha todos os campos.',
                    'email_invalido' => 'E-mail inválido.',
                    'email_existente' => 'Este e-mail já está cadastrado.',
                    'erro_atualizacao' => 'Erro ao atualizar usuário.',
                    'erro_remocao' => 'Erro ao remover usuário.',
                    'id_invalido' => 'ID inválido.'
                ];
                echo $erros[$_GET['erro']] ?? 'Ocorreu um erro.';
                ?>
            </div>
        <?php endif; ?>

        <?php if (empty($usuarios)): ?>
            <div class="sem-usuarios">
                <p>Nenhum usuário cadastrado.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Data de Cadastro</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr class="usuario-row">
                            <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($usuario['data_cadastro'])); ?></td>
                            <td>
                                <div class="acoes">
                                    <a href="../usuarios/index.php?action=editar&id=<?php echo $usuario['id']; ?>" class="btn-editar">Editar</a>
                                    <a href="../usuarios/index.php?action=remover&id=<?php echo $usuario['id']; ?>" class="btn-remover">Remover</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
