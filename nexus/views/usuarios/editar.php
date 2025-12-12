<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário - Nexus</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" referrerpolicy="no-referrer" />
    <style>
        .container-editar {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
        }
        .header-editar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .header-editar h1 {
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
        .mensagem {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .mensagem.erro {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .form-editar {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        .btn-salvar, .btn-cancelar {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-salvar {
            background: #007bff;
            color: white;
        }
        .btn-salvar:hover {
            background: #0056b3;
        }
        .btn-cancelar {
            background: #6c757d;
            color: white;
        }
        .btn-cancelar:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container-editar">
        <div class="header-editar">
            <h1>Editar Usuário</h1>
            <a href="index.php?action=listar" class="btn-voltar">Voltar</a>
        </div>

        <?php if (isset($_GET['erro'])): ?>
            <div class="mensagem erro">
                <?php
                $erros = [
                    'campos_vazios' => 'Por favor, preencha todos os campos.',
                    'email_invalido' => 'E-mail inválido.',
                    'email_existente' => 'Este e-mail já está cadastrado.',
                    'erro_atualizacao' => 'Erro ao atualizar usuário.'
                ];
                echo $erros[$_GET['erro']] ?? 'Ocorreu um erro.';
                ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?action=atualizar" class="form-editar">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>">
            
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-salvar">Salvar Alterações</button>
                <a href="../../usuarios/index.php?action=listar" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
