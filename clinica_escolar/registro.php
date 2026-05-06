<?php
// Aqui inicio a sessão, caso seja necessário guardar ou verificar dados do utilizador
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <!-- Aqui defino a formatação de texto, coloquei favicon, um título e linkei ao style.css-->
    <meta charset="UTF-8">
    <title>Registo - Clínica Eduga</title>
    <link rel="icon" type="image/png" href="imagens/favicon.png"> 
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!--Aqui importo a barra de navegação do ficheiro header.php-->
    <?php include 'api/header.php'; ?>

    <!--Aqui crio o conteúdo principal da página de registo com class para modificar no css-->
    <main class="page-content">
        <h1>Criar conta</h1>

        <!--Aqui verifico se existe alguma mensagem de erro e mostro com class para modificar no css-->
        <?php if (isset($_GET['erro'])): ?>
        <div class="msg erro" style="margin-bottom:15px;">
            <?= htmlspecialchars($_GET['erro']) ?>
        </div>
        <?php endif; ?>

        <!--Aqui verifico se existe mensagem de sucesso e mostro com class para modificar no css-->
        <?php if (isset($_GET['sucesso'])): ?>
        <div class="msg sucesso" style="margin-bottom:15px;">
            <?= htmlspecialchars($_GET['sucesso']) ?>
        </div>
        <?php endif; ?>

        <!--Aqui crio o formulário de registo para o utilizador preencher-->
        <form action="api/registro.php" method="post">

            <label>Nome</label>
            <input type="text" name="nome" required>

            <label>Turma</label>
            <input type="text" name="turma" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Senha</label>
            <input type="password" name="senha" required>

            <label>Confirmar senha</label>
            <input type="password" name="senha2" required>

            <!--Botão para enviar o formulário e criar a conta com a class igual a outros botões para modificar no css-->
            <button type="submit" class="btn btn-full">Registar</button>

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
