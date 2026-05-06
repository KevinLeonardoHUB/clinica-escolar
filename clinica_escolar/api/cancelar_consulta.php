<?php
// Aqui inicio a sessão para conseguir identificar o aluno que está logado
session_start();

// Aqui faço a ligação ao banco de dados
require 'db.php';

// Aqui crio uma função para tratar erros:
// Sempre que algo der errado, redireciono de volta para a página "minhas_consultas.php"
// e envio a mensagem de erro na URL
function erro($msg) {
    header("Location: ../minhas_consultas.php?erro=" . urlencode($msg));
    exit;
}

// Aqui crio uma função para tratar mensagens de sucesso:
// Redireciono para "minhas_consultas.php" com uma mensagem de sucesso
function sucesso($msg) {
    header("Location: ../minhas_consultas.php?sucesso=" . urlencode($msg));
    exit;
}

// Aqui verifico se o aluno está logado
// Se não estiver, chamo a função de erro com uma mensagem apropriada
if (!isset($_SESSION['aluno_id'])) {
    erro("Precisa iniciar sessão para desmarcar uma consulta.");
}

// Aqui guardo o ID do aluno que está na sessão
$alunoId = $_SESSION['aluno_id'];

// Aqui recebo o ID da consulta enviada pelo formulário (POST)
$consultaId = (int)($_POST['consulta_id'] ?? 0);

// Se o ID da consulta não for válido, printo um erro
if ($consultaId <= 0) {
    erro("Consulta inválida.");
}

// Aqui procuro na base de dados a consulta com o ID recebido
$stmt = $pdo->prepare("
    SELECT id, aluno_id, data, hora, status
      FROM consultas
     WHERE id = ?
");
$stmt->execute([$consultaId]);
$consulta = $stmt->fetch();

// Se não encontrar consulta nenhuma, mando mensagem de erro
if (!$consulta) {
    erro("Consulta não encontrada.");
}

// Aqui verifico se a consulta realmente pertence ao aluno logado
// Se o aluno tentar desmarcar uma consulta que não é dele, dá erro
if ((int)$consulta['aluno_id'] !== $alunoId) {
    erro("Não tem permissão para desmarcar esta consulta.");
}


// Aqui verifico o estado da consulta, só deixo desmarcar se estiver 'marcada'
if (!in_array($consulta['status'], ['marcada'], true)) {
    erro("Só é possível desmarcar consultas marcadas.");
}


// Aqui crio uma data com o dia de hoje
$hoje = new DateTime('today');

// Aqui crio uma data com o dia da consulta
$dataConsulta = new DateTime($consulta['data']);

// Se a data da consulta for hoje ou já tiver passado, não pode desmarcar
if ($dataConsulta <= $hoje) {
    erro("Só é possível desmarcar com pelo menos 1 dia de antecedência.");
}


// Aqui, se passou por todas as validações, atualizo o estado para 'cancelada'
$upd = $pdo->prepare("UPDATE consultas SET status = 'cancelada' WHERE id = ?");
$upd->execute([$consultaId]);

// Por fim, mando mensagem de sucesso e volto para a página "minhas_consultas"
sucesso("Consulta desmarcada com sucesso.");
