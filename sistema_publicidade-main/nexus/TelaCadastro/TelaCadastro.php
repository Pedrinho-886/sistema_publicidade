<?php
//Configurações de Conexão com o Banco de Dados

define('DB_HOST', 'db');
define('DB_USER', 'nexus'); 
define('DB_PASS', 'nexus123'); 
define('DB_NAME', 'nexus_db'); 

$mensagem_erro = '';
$mensagem_sucesso = '';
$nome = '';
$pdo = null; 

// Tentar Conexão com o Banco de Dados
try {
    
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Se a conexão falhar (MySQL parado ou credenciais erradas)
    $mensagem_erro = "Erro de Conexão. Verifique o MySQL do XAMPP e suas credenciais. Detalhes: " . $e->getMessage();
    $pdo = null; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $pdo) { // <-- CORREÇÃO: Verifica se $pdo é válido antes de prosseguir
    
    //  Coletar e Sanear Dados
    $nome  = trim($_POST['nome']  ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    // Validação Básica
    if (empty($nome) || empty($email) || empty($senha)) {
        $mensagem_erro = "Por favor, preencha todos os campos.";
    } else {
        
        // Verificar se o E-mail já Existe (Garantindo a restrição UNIQUE)
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetchColumn() > 0) {
                $mensagem_erro = "Este e-mail já está cadastrado. Tente fazer login.";
            } else {
                
                //  CRIPTOGRAFIA DA SENHA 
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
                
                if ($stmt->execute([$nome, $email, $senha_hash])) {
                    
                    // LOGIN AUTOMÁTICO E REDIRECIONAMENTO 
                    $id_usuario = $pdo->lastInsertId();
                    
                    $_SESSION['logado'] = true;
                    $_SESSION['id_usuario'] = $id_usuario;
                    $_SESSION['nome_usuario'] = $nome; 

                    header("Location: ../TelaLogin/Login.php"); 
                    exit();
                    
                } else {
                    $mensagem_erro = "Erro ao cadastrar. Tente novamente.";
                }
            }
        } catch (PDOException $e) {
            $mensagem_erro = "Erro ao executar consulta no banco de dados. Tente novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Cadastro - Nexus</title> 
    <link rel="stylesheet" href="Cadastro.css"> 
</head>
<body class="cadastro-page"> 
    
    <header>
        <nav class="main-nav">
            <ul>
                <li><a href="../index.html">Página Inicial</a></li>
                <li><a href="../index.html#secao_planos">Planos</a></li>
                <li><a href="#">Suporte</a></li>
            </ul>
        </nav>
    </header>

    <div class="background"></div> 

    <div class="login-container"> 
        <div class="cadastro-box">
            <h1>Crie sua Conta Nexus</h1>

            <?php if (!empty($mensagem_sucesso)): ?>
                <p style="color: green; text-align: center; font-weight: bold;"><?php echo $mensagem_sucesso; ?></p>
            <?php endif; ?>

            <?php if (!empty($mensagem_erro)): ?>
                <p style="color: red; text-align: center; font-weight: bold;"><?php echo $mensagem_erro; ?></p>
            <?php endif; ?>

            <form action="" method="POST" class="cadastro-form"> 
                <div class="input-group">
                    <input type="text" id="nome" name="nome" placeholder="Nome Completo" required 
                           value="<?php echo htmlspecialchars($nome ?? ''); ?>" />
                </div>
                <div class="input-group">
                    <input type="email" id="email" name="email" placeholder="E-mail" required 
                           value="<?php echo htmlspecialchars($email ?? ''); ?>" />
                </div>

                <div class="input-group grupo-senha"> 
                    <input type="password" id="senha" name="senha" placeholder="Senha" required />
                </div> 

                <button type="submit" class="btn-primary botao-cadastro">CADASTRAR</button>
            </form> 
            
            <div class="login-link"> 
                <a href="../TelaLogin/Login.php" class="fazer-login">Já tem conta? Faça Login</a>
            </div>
        </div>
    </div> 
</body>
</html>