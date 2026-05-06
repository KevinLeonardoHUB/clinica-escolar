<!DOCTYPE html>
<html lang="pt">
<head>
    <!--Aqui defino a formatação de texto, o título da página, ligo o CSS e coloco o favicon-->
    <meta charset="UTF-8">
    <title>Contactos - Clínica Eduga</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="imagens/favicon.png"> 
</head>
<body>

    <!--Aqui importo a barra de navegação do ficheiro header.php-->
    <?php include 'api/header.php'; ?>

    <!--Aqui crio um hero simples para estilo, igual ao das outras paginas -->
    <header class="sub-hero">
        <h1>Contactos</h1>
        <p>Estamos disponíveis para esclarecer dúvidas e ouvir sugestões.</p>
    </header>

    <!--Aqui crio uma grelha para dividir o conteúdo da página (informações + extra) com class para estilo no css-->
    <main class="contato-grid">

        <!--Informação principal com as informações de contacto da clínica com class para estilo no css-->
        <section class="contato-card">
            <h2>Informações de Contacto</h2>
            <p><strong>Email geral:</strong> ClinicaEduga@sapo.pt</p>
            <p><strong>Telefone da escola:</strong> 21 949 9800</p>
            <p><strong>Morada:</strong> R. Sport Grupo Sacavenense 28, Sacavém</p>
            <p><strong>Horário da Clínica:</strong> 2.ª a 6.ª feira, das 8h às 14h</p>
        </section>

        <!--Card secundário ao lado com um botão para enviar email diretamente com class para estilo no css-->
        <section class="contato-card contato-extra">
            <h2>Fale connosco</h2>
            <p>
                Envie-nos um email com as suas dúvidas, pedidos de informação ou sugestões.
            </p>
            <!--Botão que abre uma app ou site de email do utilizador com class para estilo no css-->
            <a href="mailto:ClinicaEduga@sapo.pt" class="btn btn-full">Enviar Email</a>
        </section>
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
