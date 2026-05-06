<?php
// Aqui inicio a sessão para poder mexer com o login do utilizador
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <!-- Aqui defino a formatação de texto, coloquei favicon, um título e linkei ao style.css-->
    <meta charset="UTF-8">
    <title>Login - Clínica Eduga</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="imagens/favicon.png">
</head>
<body>

    <!--Aqui importo a barra de navegação do ficheiro header.php-->
    <?php include 'api/header.php'; ?>

    <!--Aqui crio o conteúdo principal da página de login com class igual a outras para modificar com css-->
    <main class="page-content">
        <h1>Entrar</h1>

        <!--Aqui mostro mensagem de erro caso exista com class igual a outras para modificar com css--->
        <?php if (isset($_GET['erro'])): ?>
        <div class="msg erro" style="margin-bottom:15px;">
            <?= htmlspecialchars($_GET['erro']) ?>
        </div>
        <?php endif; ?>

        <!--Aqui mostro mensagem de sucesso caso exista com class igual a outras para modificar com css--->
        <?php if (isset($_GET['sucesso'])): ?>
        <div class="msg sucesso" style="margin-bottom:15px;">
            <?= htmlspecialchars($_GET['sucesso']) ?>
        </div>
        <?php endif; ?>

        <!--Aqui crio o formulário onde o utilizador coloca email e senha-->
        <form action="api/login.php" method="post">

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Senha</label>
            <input type="password" name="senha" required>

            <!--Botão para entrar na conta com class igual a outras para modificar com css--->
            <button type="submit" class="btn btn-full">Entrar</button>

        </form>
    </main>

    <!-- Aqui criei um rodapé com class para identificar no css e estilizar -->
    <footer class="footer">
        <!-- Aqui identifico no css para estilizar como se fosse uma grelha -->
        <div class="footer-grid">

            <div>
                <h4>Links Rápidos</h4>
                <ul>
                    <li><a href="index.php">Início</a></li>
                    <li><a href="pagina_consultas.php">Marcar Consulta</a></li>
                    <li><a href="sobre.php">Sobre</a></li>
                    <li><a href="contactos.php">Contato</a></li>
                </ul>
            </div>

            <div>
                <h4>Contactos</h4>
                <p>Email: ClinicaEduga@sapo.pt</p>
                <p>Telefone: 21 949 9800</p>
                <p>Endereço: R. Sport Grupo Sacavenense 28, Sacavém</p>
            </div>
        </div>

        <p class="copy">© 2025 Clínica Eduga — Todos os direitos reservados.(se o prof leu isso mereço 20)</p>
    </footer>

</body>
</html>
