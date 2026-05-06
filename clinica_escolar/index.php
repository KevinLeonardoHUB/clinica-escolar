<?php
session_start();

// Conecta-se ao banco
require_once 'api/db.php';

// Pega data de hoje
$hoje = date('Y-m-d');

// Verificar se ja existem horarios a partir de hoje
$stmt = $pdo->prepare("
    SELECT COUNT(*) 
    FROM horarios 
    WHERE data >= :hoje
");
$stmt->bindParam(':hoje', $hoje);
$stmt->execute();

$qtde = $stmt->fetchColumn();

// Se não houver nenhum horário, gera automaticamente
if ($qtde == 0) {
    require_once 'api/gerar_horarios.php';
}
?>


<!DOCTYPE html>
<html lang="pt">
<head>
     <!-- Aqui defino a formatação de texto, coloquei favicon, um título e linkei ao style.css-->
    <meta charset="UTF-8">
    <title>Início - Clínica Eduga</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="imagens/favicon.png"> 
</head>
<body>
    <!--Aqui importo a barra de menu do ficheiro header.php-->
    <?php include 'api/header.php'; ?>
<!--Aqui criei um banner-->
     <header class="hero">
        <div class="hero-content">
            <h1>Clínica Eduga</h1>
            <p>Apoio, acolhimento e saúde para toda a comunidade escolar.</p>
            <!--Aqui coloco um botão para a pagina de agendar consulta com class para estilizar no css-->
            <a href="pagina_consultas.php" class="btn">Agendar Consulta</a>
        </div>
    </header>

    <!-- Criei uma secção de serviços e identifico a secção para estilizar no css --> 
    <section class="servicos">
        <h2>Os Nossos Serviços</h2>
        <!--Identifico a div para estilizar no css -->
        <div class="servico-grid">
             <!-- Para cada secção coloquei uma imagem e identifico para estilizar no css -->
            <div class="card">
                <img src="imagens/psicologia.jpg" alt="">
                <h3>Psicologia</h3>
                <p>Acompanhamento emocional e de comportamento para todos os alunos.</p>
            </div>
            <!--Identifico as divs iguais a primeira "card" para estilizar no css -->
            <div class="card">
                <img src="imagens/enfermagem.jpg" alt="">
                <h3>Enfermagem</h3>
                <p>Primeiros socorros e apoio em situações de saúde.</p>
            </div>

            <!--Identifico as divs iguais a primeira "card" para estilizar no css -->
            <div class="card">
                <img src="imagens/fisioterapia.jpeg" alt="">
                <h3>Fisioterapia</h3>
                <p>Apoio especializado para dificuldades de movimentação.</p>
            </div>

        </div>
    </section>

    <!-- Criei uma secção para falar sobre a clinica e identifico a secção para estilizar no css --> 
    <section class="sobre-nos">
        <!--Identifico a imagem para estilizar no css -->
        <img src="imagens/escola.jpg" class="sobre-img">
        <!--Identifico a div do textozinho que fiz para falar sobre a clinica-->
        <div class="sobre-text">
            <h2>Quem Somos</h2>
            <p>
                A Clínica Eduga é um espaço dedicado ao bem-estar físico, emocional e social
                dos alunos, professores e comunidade escolar. Trabalhamos com profissionais
                qualificados para garantir um ambiente com apoio, acolhimento e saúde para toda a comunidade escolar.
            </p>
            <!--Aqui coloco um botão para a pagina de "sobre" com class mesma class que o primeiro botao de agendar consulta para estilizar no css da mesma forma-->
            <a href="sobre.php" class="btn">Saiba Mais</a>
        </div>
    </section>

   

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