<?php
session_start();

// Configurações de Conexão com o Banco de Dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'nexus_db');

$mensagem_sucesso = '';
$mensagem_erro = '';
$pdo = null;

// Tentar Conexão com o Banco de Dados
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $mensagem_erro = "Erro de Conexão. Verifique o MySQL do XAMPP. Detalhes: " . $e->getMessage();
    $pdo = null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $pdo) {

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (empty($email)) {
        $mensagem_erro = "Por favor, informe seu e-mail.";
    } else {
        try {
            
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                $id_usuario = $usuario['id'];
                
                
                $token = bin2hex(random_bytes(32)); 
                $expiracao = date('Y-m-d H:i:s', strtotime('+1 hour')); 

                
                $stmt_token = $pdo->prepare(
                    "UPDATE usuarios SET token_recuperacao = ?, expiracao_token = ? WHERE id = ?"
                );
                $stmt_token->execute([$token, $expiracao, $id_usuario]);

                
                $link_redefinicao = "http://localhost/sistema_publicidade/Desenvolvimento/TelaLogin/RedefinirSenha.php?token=" . $token;
                
               
                
                // --- SIMULAÇÃO DE E-MAIL  ---
                $assunto = "Redefinição de Senha Nexus";
                $corpo_email = "Olá,<br><br>";
                $corpo_email .= "Você solicitou a redefinição de sua senha. Clique no link abaixo para prosseguir. O link expirará em 1 hora.<br><br>";
                $corpo_email .= "<a href='$link_redefinicao'>REDEFINIR MINHA SENHA</a><br><br>";
                $corpo_email .= "Se você não solicitou esta redefinição, por favor, ignore este e-mail.";

                $mensagem_sucesso = "Um link de redefinição de senha foi enviado para seu e-mail. Verifique sua caixa de entrada (e spam).";
                


            } else {
                $mensagem_sucesso = "Se o e-mail estiver cadastrado em nosso sistema, um link de redefinição foi enviado.";
            }

        } catch (PDOException $e) {
            $mensagem_erro = "Erro interno. Tente novamente mais tarde.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
 <meta charset="UTF-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Recuperar Senha - Nexus</title> 
 <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
 <link rel="stylesheet" href="../style.css" />
 <link rel="stylesheet" href="Login.css" />
</head>
<body class="pagina-RecuperarSenha">

 <header>
 <nav class="main-nav">
<ul>
<li><a href="../index.html">Página Inicial</a></li>
 <li><a href="../index.html#secao_planos">Planos</a></li>
 <li><a href="#">Suporte</a></li>
 </ul>
 </nav>
 </header>

<div class="fundo"></div>

 <div class="container-login">
 <div class="caixa-login">
 <h1>Recuperar Senha</h1>

        <?php if (!empty($mensagem_erro)): ?>
 <p style="color: red; text-align: center; margin-bottom: 20px; font-weight: bold;"><?php echo $mensagem_erro; ?></p>
 <?php endif; ?>
        <?php if (!empty($mensagem_sucesso)): ?>
         <p style="color: green; text-align: center; margin-bottom: 20px; font-weight: bold;"><?php echo $mensagem_sucesso; ?></p>
<?php endif; ?>

 <form action="" method="POST">
 <div class="grupo-input">
 <input type="email" id="email" name="email" placeholder="E-mail" required />
</div>
 <h5>Informe seu e-mail para receber um link de recuperação</h5>
 <button type="submit" class="botao botao-primario botao-login">Enviar</button>
 </form> 
        <div class="links">
 <a href="Login.php" class="esqueceu-senha">Voltar ao Login</a>
    </div>
  </div>
</div>
</body>
</html>