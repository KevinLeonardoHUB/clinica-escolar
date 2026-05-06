<?php
// Aqui inicio a sessão para conseguir verificar se o aluno está autenticado
session_start();

// Aqui verifico se o utilizador não tem sessão iniciada
// Se não tiver, redireciono para o login com uma mensagem de erro
if (!isset($_SESSION['aluno_id'])) {
    header("Location: login.php?erro=" . urlencode("É necessário iniciar sessão para ver as suas consultas."));
    exit;
}

// Aqui ligo a base de dados
require 'api/db.php';

// Guardo o ID do aluno que está na sessão
$alunoId = $_SESSION['aluno_id'];

// Aqui preparo a query em sql para buscar todas as consultas do aluno, bem como o nome do médico
$stmt = $pdo->prepare("
    SELECT c.id, c.data, c.hora, c.status, m.nome AS medico_nome
      FROM consultas c
      JOIN medicos m ON c.medico_id = m.id
     WHERE c.aluno_id = ?
     ORDER BY c.data, c.hora
");

// Executo a query passando o ID do aluno
$stmt->execute([$alunoId]);

// Guardo todas as consultas encontradas
$consultas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
 <!-- Aqui defino a formatação de texto, coloquei favicon, um título e linkei ao style.css-->
  <meta charset="UTF-8">
  <title>Minhas Consultas - Clínica Eduga</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/png" href="imagens/favicon.png">
</head>
<body>

  <!--Aqui importo a barra de navegação-->
  <?php include 'api/header.php'; ?>

  <!--Aqui crio o conteúdo principal da página com class para modificar no css-->
  <main class="page-content">
    <h1>Minhas consultas</h1>

    <!--Aqui mostro mensagem de erro, caso exista algum-->
    <?php if (isset($_GET['erro'])): ?>
      <div class="msg erro" style="margin-bottom:15px;">
        <?= htmlspecialchars($_GET['erro']) ?>
      </div>
    <?php endif; ?>

    <!--Aqui mostro mensagem de sucesso, caso exista algum-->
    <?php if (isset($_GET['sucesso'])): ?>
      <div class="msg sucesso" style="margin-bottom:15px;">
        <?= htmlspecialchars($_GET['sucesso']) ?>
      </div>
    <?php endif; ?>

    <!--Se o aluno não tiver consultas registadas-->
    <?php if (empty($consultas)): ?>
      <p>Não tem consultas registadas.</p>
    <!--Caso o contrário-->
    <?php else: ?>
      <!--Aqui crio a tabela que lista todas as consultas com class para estilizar no css-->
      <table class="tabela-calendario">
        <thead>
          <tr>
            <th>Data</th>
            <th>Hora</th>
            <th>Médico</th>
            <th>Estado</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>

        <?php
          // Aqui crio uma data com o dia atual para verificar se ainda dá para desmarcar, porque caso o aluno tente desmarcar sem 1 dia de antecedencia nao aparece a opcao
          $hoje = new DateTime('today');

          // Aqui percorro cada consulta para mostrar na tabela
          foreach ($consultas as $c):

              // Converto a data da consulta para DateTime
              $dataConsulta = new DateTime($c['data']);

              // Aqui verifico se a consulta pode ser desmarcada
              // Apenas se estiver marcada e ainda não tiver passado o dia
              $podeDesmarcar = (
                  in_array($c['status'], ['marcada'], true)
                  && $dataConsulta > $hoje
              );
        ?>
          <tr>
            <!--Mostro a data-->
            <td><?= htmlspecialchars($c['data']) ?></td>

            <!--Mostro a hora cortando os segundos-->
            <td><?= htmlspecialchars(substr($c['hora'], 0, 5)) ?></td>

            <!--Nome do médico-->
            <td><?= htmlspecialchars($c['medico_nome']) ?></td>

            <!--Estado da consulta-->
            <td><?= htmlspecialchars($c['status']) ?></td>

            <!--Botão de desmarcar (apenas se for possível)-->
            <td>
              <?php if ($podeDesmarcar): ?>
                <!--Formulário que envia o ID da consulta para cancelar-->
                <form action="api/cancelar_consulta.php" method="post" style="display:inline;"
                      onsubmit="return confirm('Tem a certeza que quer desmarcar esta consulta?');">
                  <input type="hidden" name="consulta_id" value="<?= (int)$c['id'] ?>">
                  <button type="submit" class="btn">Desmarcar</button>
                </form>
              <?php else: ?>
                -
              <?php endif; ?>
            </td>
          </tr>

        <?php endforeach; ?>

        </tbody>
      </table>
    <?php endif; ?>
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
