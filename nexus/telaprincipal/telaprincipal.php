<?php
session_start();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela Ferramentas</title>
    <link rel="stylesheet" href="tela.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" referrerpolicy="no-referrer" />
</head>
<body>
    <section class="secao-ferramentas">
    <div class="container">
        <h2 class="titulo-secao">Acesso Rápido às Suas Ferramentas</h2>
        <p class="subtitulo-secao">Gerencie tudo em um só lugar: do planejamento à execução, com agilidade e inteligência.</p>

        <div class="grade-ferramentas">
            <a href="#" class="card-ferramenta">
                <i class="icone-ferramenta fas fa-calendar-check"></i> <h3 class="titulo-ferramenta">Agenda e Calendário</h3>
                <p class="descricao-ferramenta">Visualize compromissos, agende tarefas e controle prazos.</p>
            </a>

            <a href="#" class="card-ferramenta">
                <i class="icone-ferramenta fas fa-comments-dollar"></i> <h3 class="titulo-ferramenta">Reuniões com Clientes</h3>
                <p class="descricao-ferramenta">Registre detalhes, atas e próximos passos dos seus encontros.</p>
            </a>

            <a href="#" class="card-ferramenta">
                <i class="icone-ferramenta fas fa-clipboard-list"></i> <h3 class="titulo-ferramenta">Controle de Tarefas</h3>
                <p class="descricao-ferramenta">Organize, distribua e acompanhe o progresso de cada atividade.</p>
            </a>

            <a href="#" class="card-ferramenta">
                <i class="icone-ferramenta fas fa-share-nodes"></i> <h3 class="titulo-ferramenta">Mídias Sociais</h3>
                <p class="descricao-ferramenta">Crie, agende e monitore suas campanhas em diversas plataformas.</p>
            </a>

            <a href="../gestaoclientes/index.html" class="card-ferramenta">
                <i class="icone-ferramenta fas fa-address-book"></i> <h3 class="titulo-ferramenta">Cadastro de Clientes</h3>
                <p class="descricao-ferramenta">Mantenha o histórico e as informações completas de cada cliente.</p>
            </a>

            <a href="../usuarios/index.php" class="card-ferramenta">
                <i class="icone-ferramenta fas fa-users"></i> <h3 class="titulo-ferramenta">Gerenciar Usuários</h3>
                <p class="descricao-ferramenta">Edite, atualize e remova usuários do sistema.</p>
            </a>

            <a href="#" class="card-ferramenta">
                <i class="icone-ferramenta fas fa-chart-pie"></i> <h3 class="titulo-ferramenta">Relatórios e Desempenho</h3>
                <p class="descricao-ferramenta">Acompanhe métricas, resultados e tome decisões estratégicas.</p>
            </a>
        </div>
    </div>
</section>
</body>
</html>
