<?php
session_start();

//Redirecionamento se já estiver logado
// Se o usuário já tiver uma sessão ativa, redirecione-o para a tela principal
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    header("Location: ../telaprincipal/telaprincipal.html");
    exit();
}

// Configurações de Conexão com o Banco de Dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); 
define('DB_PASS', ''); 
define('DB_NAME', 'nexus_db'); 

$mensagem_erro = '';
$pdo = null;

//  Tentar Conexão com o Banco de Dados
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $mensagem_erro = "Erro de Conexão. Verifique o MySQL do XAMPP. Detalhes: " . $e->getMessage();
    $pdo = null; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $pdo) { 
    
    $email_digitado = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha_digitada = filter_input(INPUT_POST, 'password', FILTER_DEFAULT); 

    if (empty($email_digitado) || empty($senha_digitada)) {
        $mensagem_erro = "Por favor, preencha o e-mail e a senha.";
    } else {
        try {
            // Prepara a consulta para buscar o usuário pelo e-mail
            $stmt = $pdo->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
            $stmt->execute([$email_digitado]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            //  Verifica se o usuário foi encontrado
            if ($usuario) {
                
                // Verifica a senha usando password_verify (comparação segura do hash)
                if (password_verify($senha_digitada, $usuario['senha'])) {
                    
                    // SUCESSO
                    $_SESSION['logado'] = true;
                    $_SESSION['id_usuario'] = $usuario['id'];
                    $_SESSION['nome_usuario'] = $usuario['nome'];
                    
                    // Redireciona para a tela principal 
                    header("Location: ../telaprincipal/telaprincipal.html"); 
                    exit();
                    
                } else {
                    
                    $mensagem_erro = "E-mail ou senha inválidos.";
                }
            } else {
               
                $mensagem_erro = "E-mail ou senha inválidos.";
            }

        } catch (PDOException $e) {
            $mensagem_erro = "Erro interno ao processar o login. Tente novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login - Nexus</title> 	
    
    <!-- Incluindo as fontes e o ícone de olho -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" xintegrity="sha512-iBBXm8fW90+nuLcSKFfA2r0s11OQ2bUa1o2l/8g2r3u+m/c0/N6L9h2nQnK6Gqj/9g8A2A0s/A0A9x0B2g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="Login.css" />
</head>
<body class="pagina-login">

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
            <h1>Entrar no Nexus</h1>
            <?php if (!empty($mensagem_erro)): ?>
                <p style="color: red; text-align: center; margin-bottom: 20px; font-weight: bold;"><?php echo $mensagem_erro; ?></p>
            <?php endif; ?>
            <form action="" method="POST"> 
                <div class="grupo-input">
                    <input type="email" id="email" name="email" placeholder="E-mail" required />
                </div>

                <div class="grupo-input grupo-senha">
                  
                    <input type="password" id="password" name="password" placeholder="Senha" required />
                    <span class="alternar-senha" onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye"></i>
                    </span>
                </div> 
                <button type="submit" class="botao botao-primario botao-login">Entrar</button>
            </form> 
            
            <div class="links">
                <a href="EsqueceuSenha.html" class="esqueceu-senha">Esqueceu a senha?</a>
                <a href="../TelaCadastro/TelaCadastro.php" class="criar-conta">Criar Conta</a>
            </div>

        </div>
    </div>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const icon = document.querySelector('.alternar-senha i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>