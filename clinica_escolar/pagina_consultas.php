<?php
// Inicia a sessão para conseguirmos saber qual o aluno está logado
session_start();

// Verifico se o utilizador (aluno) não está autenticado
// Se não existir 'aluno_id' na sessão, redireciono para a página de login, pois não da para marcar consulta sem estar logado
if (!isset($_SESSION['aluno_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <!-- Aqui defino a formatação de texto, o título da página e o favicon e ligo no css -->
  <meta charset="UTF-8">
  <title>Marcar Consulta | Clínica Eduga</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/png" href="imagens/favicon.png">
</head>
<body>
  <!-- Incluo a barra de navegação/menu -->
  <?php include 'api/header.php'; ?>

  <!-- Coloco um mini banner apenas para estilo, uma corzinha aqui -->
  <header class="sub-hero">
    <h1>Marque a sua consulta</h1>
    <p>Escolha o profissional, a data e selecione um dos horários disponíveis.</p>
  </header>

  <!-- Conteúdo principal da página de marcação de consulta com class para identificar no css -->
  <main class="page-content consulta-page">
    <!-- Cartão principal com o formulário da consulta com class para estilizar no css -->
    <section class="consulta-card">
      <h2>Dados da consulta</h2>

      <!-- Campo de escolha do médico/profissional com class para estilizar no css -->
      <div class="campo">
        <label for="medico">Médico / Profissional</label>
        <!-- Opcoes de selecionar os medicos disponíveis através do id, criados na database -->
        <select id="medico">
          <option value="1">Quévin Tavares (Psicologo)</option>
          <option value="2">João Salomão (Fisioterapeuta)</option>
          <option value="3">André Barroso (Pediatra)</option>
        </select>
      </div>

      <!-- Campo para escolher a data da consulta com a mesma class para o mesmo estilo -->
      <div class="campo">
        <label for="data">Data</label>
        <!-- Input do tipo date para o utilizador escolher o dia -->
        <input type="date" id="data">
      </div>

      <!-- Secção onde vão aparecer os horários disponíveis para a data escolhida com a mesma class para o mesmo estilo -->
      <div class="campo">
        <label>Horários disponíveis</label>
        <div id="slots" class="slots">
          <!-- O JavaScript (ficheiro script.js que está em javascript/script.js) vai buscar os horários e preencher aqui -->
        </div>
      </div>

      <!-- Botão que o utilizador carrega para confirmar o agendamento da consulta com class para estilizar-->
      <button id="btnConfirmar" class="btn btn-full">Confirmar agendamento</button>

      <!-- Div para mostrar mensagens de erro (por exemplo: nenhum horário selecionado) com class para estilo no css -->
      <div id="mensagem" class="msg erro" style="display:none;"></div>

      <!-- Div para mostrar mensagem de sucesso (quando a consulta for marcada) com class para estilo no css -->
      <div id="mensagemSucesso" class="msg sucesso" style="display:none;"></div>
    </section>

    <!-- Criei um espaço com algumas informações importantes sobre as consultas com class para estilo no css -->
    <aside class="consulta-info">
      <h3>Informações importantes</h3>
      <ul>
        <li>As consultas têm a duração máxima de 45 minutos.</li>
        <li>Em caso de impossibilidade de comparecer, desmarque com 1 dia de antecedência, caso contrário a consulta continuará marcada.</li>
        <li>Os atendimentos são destinados à comunidade escolar (alunos, e funcionários).</li>
      </ul>
    </aside>
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

  <!-- Importo o ficheiro JavaScript onde está a lógica para carregar horários e enviar o agendamento -->
  <script src="javascript/script.js"></script>
</body>
</html>
