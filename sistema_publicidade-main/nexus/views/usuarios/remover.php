<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remover Usuário - Nexus</title>
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" referrerpolicy="no-referrer" />
    <style>
        .container-remover {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
        }
        .header-remover {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .header-remover h1 {
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
        .confirmacao-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .aviso {
            background: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .info-usuario {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .info-usuario p {
            margin: 8px 0;
            color: #333;
        }
        .info-usuario strong {
            color: #007bff;
        }
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        .btn-confirmar, .btn-cancelar {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .btn-confirmar {
            background: #dc3545;
            color: white;
        }
        .btn-confirmar:hover {
            background: #c82333;
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
    <div class="container-remover">
        <div class="header-remover">
            <h1>Remover Usuário</h1>
            <a href="../../usuarios/index.php?action=listar" class="btn-voltar">Voltar</a>
        </div>

        <div class="confirmacao-box">
            <div class="aviso">
                <strong>Atenção!</strong> Esta ação não pode ser desfeita. O usuário será permanentemente removido do sistema.
            </div>

            <div class="info-usuario">
                <p><strong>ID:</strong> <?php echo htmlspecialchars($usuario['id']); ?></p>
                <p><strong>Nome:</strong> <?php echo htmlspecialchars($usuario['nome']); ?></p>
                <p><strong>E-mail:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
            </div>

            <form method="POST" action="index.php?action=confirmarRemocao">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>">
                
                <div class="form-actions">
                    <button type="submit" class="btn-confirmar">Confirmar Remoção</button>
                    <a href="../../usuarios/index.php?action=listar" class="btn-cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
