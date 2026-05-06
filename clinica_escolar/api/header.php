<?php
// Aqui verifico se a sessão ainda não foi iniciada, e inicio caso não exista
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!--Aqui crio a barra de navegação principal do site-->
<nav class="navbar">

    <!--Aqui coloco o logo da escola com link para o site do agrupamento com class para estilizar no css-->
    <a href="https://www.eduga.pt" class="logo" target="_blank">
        <img src="imagens/logo.jpeg" alt="logo">
    </a>

    <!--Aqui crio os links principais do menu de navegação com class para estilizar no css-->
    <ul class="nav-links">
        <li><a href="index.php">Início</a></li>
        <li><a href="pagina_consultas.php">Marcar Consulta</a></li>
        <li><a href="sobre.php">Sobre</a></li>
        <li><a href="contactos.php">Contactos</a></li>
    </ul>

    <!--Aqui crio a área onde aparece o login ou o nome do utilizador já autenticado com class para estilizar no css-->
    <div class="user-area">
        <?php if (isset($_SESSION['aluno_id'])): ?>
            <!--Aqui mostro o menu do utilizador quando ele está autenticado com class para estilizar no css-->
            <div class="user-menu">
                <!--Botão que mostra o nome e número do aluno com menu de dropdown(lista para baixo) com class para estilizar no css-->
                <button class="user-menu-toggle" type="button">
                    <?php echo htmlspecialchars($_SESSION['aluno_nome']); ?>
                    &nbsp;|&nbsp;
                    <?php echo htmlspecialchars($_SESSION['numero_aluno']); ?>
                    <!--Seta do menu de dropdown(lista para baixo) com class para estilizar no css-->
                    <span class="seta">&#9662;</span>
                </button>

                <!--Aqui está o menu dropdown com links para a pagina de minhas consultas e para sair da sessão que aparece ao clicar no nome do aluno,com class para estilizar no css-->
                <div class="user-menu-dropdown">
                    <a href="minhas_consultas.php">Minhas consultas</a>
                    <a href="api/logout.php">Sair</a>
                </div>
            </div>

        <?php else: ?>
            <!--Aqui mostro os botões de entrar e registar quando o utilizador ainda não está logado com class para estilizar no css-->
            <a href="login.php" class="btn-link">Entrar</a>
            <a href="registro.php" class="btn-link">Registar</a>
        <?php endif; ?>

    </div>
</nav>
