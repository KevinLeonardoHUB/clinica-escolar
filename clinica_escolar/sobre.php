<!DOCTYPE html>
<html lang="pt">
<head>
    <!--Aqui defino a formatação de texto, o título da página, ligo ao CSS e coloco o favicon-->
    <meta charset="UTF-8">
    <title>Sobre Nós - Clínica Eduga</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="imagens/favicon.png"> 
</head>
<body>

    <!--Aqui importo a barra de menu que está no ficheiro header.php-->
    <?php include 'api/header.php'; ?>

    <!-- Coloco um mini banner apenas para estilo, uma corzinha aqui -->
    <section class="sub-hero">
        <h1>Sobre a Clínica Eduga</h1>
        <p>
            Acompanhamos o desenvolvimento das crianças e jovens fisicamente, emocionalmente e a nível escolar,
            com uma equipa especializada e ambiente acolhedor.
        </p>
    </section>

    <!--Aqui inicio a secção principal que fala sobre a clínica com class para estilo no css-->
    <section class="sobre-nos">
        <div>
            <h2>Quem Somos</h2>
            <p>
                A Clínica Eduga nasce com o objetivo de aproximar a saúde e o bem-estar do contexto escolar.
                Somos uma organização parte do Agrupamento Eduardo Gageiro que trabalha para garantir um acompanhamento completo e saudável.
            </p>
            <p>
                Acreditamos que cada aluno é único. Por isso, adaptamos as nossas estratégias às necessidades
                individuais, promovendo autonomia, confiança e sucesso académico.
            </p>
        </div>

        
        <div>
            <h2>A Nossa Missão</h2>
            <p>
                Oferecer cuidados de saúde integrados, com foco no desenvolvimento infantil e juvenil:
            </p>
            <ul>
                <li>Promoção da saúde física e emocional.</li>
                <li>Trabalho em equipa com pais, professores e educadores.</li>
            </ul>
        </div>
    </section>

    <!--Aqui crio a secção onde apresento a equipa clínica com class para estilo no css-->
    <section class="equipa-section">
        <!--Header da secção da equipa com class para estilo no css-->
        <div class="equipa-header">
            <h2>A Nossa Equipa Clínica</h2>
            <p>
                Conheça os profissionais que todos os dias cuidam dos alunos do nosso agrupamento com dedicação e experiência.
            </p>
        </div>

        <!--Aqui crio uma grelha para mostrar os cartões dos profissionais com class para estilo no css-->
        <div class="equipa-grid">

            <!--Psicólogo Quévin, tudo com class para estilo no css-->
            <article class="doctor-card">
                <div class="doctor-photo">
                    <img src="imagens/kevin.jpg" alt="Kevin Tavares - Psicólogo">
                </div>
                <h3>Dr. Quévin Tavares</h3>
                <span class="especialidade">Psicólogo</span>
                <p>
                    Especialista em desenvolvimento infantil e juvenil, realiza avaliações psicológicas,
                    acompanhamento emocional e testes psicotécnicos, ajudando os alunos a lidarem com
                    ansiedade, foco, motivação, dificuldades na aprendizagem e descobrirem o seu futuro.
                </p>
            </article>

            <!--Card do fisioterapeuta João tudo com class para estilo no css-->
            <article class="doctor-card">
                <div class="doctor-photo">
                    <img src="imagens/joao.jpg" alt="João Salomão - Fisioterapeuta">
                </div>
                <h3>Dr. João Salomão</h3>
                <span class="especialidade">Fisioterapeuta</span>
                <p>
                    Focado na reabilitação física e prevenção de lesões, acompanha postura, coordenação
                    motora e queixas musculares das crianças e jovens, contribuindo para um crescimento
                    saudável e ativo.
                </p>
            </article>

            <!--Card do pediatra André tudo com class para estilo no css-->
            <article class="doctor-card">
                <div class="doctor-photo">
                    <img src="imagens/andre.jpg" alt="André Barroso - Pediatra">
                </div>
                <h3>Dr. André Barroso</h3>  
                <span class="especialidade">Pediatra da Clínica Escolar</span>
                <p>
                    Responsável pelo acompanhamento pediátrico na clínica escolar, realiza consultas de
                    rotina, avaliação de desenvolvimento, orientação a pais e juntamente com a escola 
                    promove a saúde infantil no dia a dia escolar. (obs: é o GOAT)
                </p>
            </article>

        </div>
    </section>

    <!--Aqui coloco uma secção para incentivar marcação de consulta-->
    <section class="equipa-cta">
        <div class="equipa-cta-card">
            <h2>Quer marcar uma consulta?</h2>
            <p>
                A nossa equipa está pronta para traçar, em conjunto, o melhor
                caminho para o seu bem-estar.
            </p>
            <!--Botão que leva à página de marcação-->
            <a href="pagina_consultas.php" class="btn">Marcar Consulta</a>
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
