<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar-senha'];
}
    $erro = '';
    if (empty($nome) || empty($email) || empty($senha) || empty($confirmar_senha)) {
        $erro = 'Todos os campos devem ser preenchidos.';
    } elseif ($senha !== $confirmar_senha) {
        $erro = 'A senha e a confirmação de senha não coincidem.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter no mínimo 6 caracteres.';
    } else {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        header("Location: ../telaprincipal/telaprincipal.html");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cadastro - Nexus</title>  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="../style.css" />
  <link rel="stylesheet" href="Cadastro.css" />
</head>
<body class=" cadastro-page">

  <header>
    <nav class="main-nav">
      <ul>
        <li><a href="../index.html">Página Inicial</a></li>
        <li><a href="#">Planos</a></li>
        <li><a href="#">Suporte</a></li>
      </ul>
    </nav>
  </header>

    <div class="background"></div>
    
    <div class="cadastro-container">
         <div class="cadastro-box">
        <form class="cadastro-form" method="POST" action="">
          <h2>Crie Sua Conta</h2>

          <div class="input-group">
              <label for="nome">Nome Completo</label>
              <input type="text" id="nome" name="nome" placeholder="Seu nome" required>
          </div>

          <div class="input-group">
              <label for="email">E-mail</label>
              <input type="email" id="email" name="email" placeholder="email@exemplo.com" required>
          </div>

          <div class="input-group">
              <label for="senha">Senha</label>
              <input type="password" id="senha" name="senha" placeholder="Mínimo 6 caracteres" required minlength="6">
          </div>

          <div class="input-group">
              <label for="confirmar-senha">Confirmar Senha</label>
              <input type="password" id="confirmar-senha" name="confirmar-senha" placeholder="Repita a senha" required minlength="6">
          </div>

          <button type="submit" name="cadastrar" class="btn-primary">Cadastrar</button> 

          <p class="login-link">
              Já tem uma conta? <a href="../TelaLogin/Login.html">Faça Login</a>
          </p>
      </form>
    </div>
</body>
</html>
