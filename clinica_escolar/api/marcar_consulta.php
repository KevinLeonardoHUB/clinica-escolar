<?php
// Aqui inicio a sessão para identificar qual aluno está logado
session_start();

// Aqui defino que este ficheiro vai devolver em JSON
header('Content-Type: application/json; charset=utf-8');

// Aqui verifico se o utilizador está ogado
// Caso não esteja, envio mensagem e paro o código
if (!isset($_SESSION['aluno_id'])) {
    echo json_encode(['ok' => false, 'msg' => 'Precisa iniciar sessão para marcar consulta.']);
    exit;
}

// Aqui ligo ao banco de dados e importo a função de enviar email com phpmailer
require 'db.php';
require 'enviar_email.php';

// Aqui recebo os dados enviados pelo JavaScript (em JSON)
$raw = file_get_contents('php://input');
$dataJson = json_decode($raw, true);

// Aqui obtenho os valores enviados
$medicoId = (int)($dataJson['medico_id'] ?? 0);
$data     = $dataJson['data']       ?? null;
$hora     = $dataJson['hora']       ?? null;

// Aqui verifico se todos os dados necessários foram enviados
if ($medicoId <= 0 || !$data || !$hora) {
    echo json_encode(['ok' => false, 'msg' => 'Dados incompletos para marcar consulta.']);
    exit;
}

// Aqui guardo o ID e o nome do aluno que está na sessão
$alunoId   = $_SESSION['aluno_id'];
$alunoNome = $_SESSION['aluno_nome'] ?? '';


// 1) Aqui verifico se o horário já está ocupado para aquele médico
$sql = "
    SELECT COUNT(*) 
      FROM consultas
     WHERE medico_id = :medico_id
       AND data = :data
       AND hora = :hora
       AND status IN ('marcada')
";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':medico_id' => $medicoId,
    ':data'      => $data,
    ':hora'      => $hora
]);
$ocupadas = $stmt->fetchColumn();

// Se já existir consulta marcada nesse horário, envio erro
if ($ocupadas > 0) {
    echo json_encode([
        'ok'  => false,
        'msg' => 'Este horário já foi marcado para este médico. Escolha outro horário.'
    ]);
    exit;
}


// 2) Aqui verifico se o aluno já tem uma consulta nesse mesmo dia e hora
$sql = "
    SELECT COUNT(*) 
      FROM consultas
     WHERE aluno_id = :aluno_id
       AND data = :data
       AND hora = :hora
       AND status IN ('marcada')
";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':aluno_id' => $alunoId,
    ':data'     => $data,
    ':hora'     => $hora
]);
$jaTem = $stmt->fetchColumn();

// Se já tiver uma consulta nesse horário, envio mensagem
if ($jaTem > 0) {
    echo json_encode([
        'ok'  => false,
        'msg' => 'Já tem uma consulta marcada nesse dia e horário.'
    ]);
    exit;
}


// Aqui insiro a nova consulta na base de dados
$stmt = $pdo->prepare("
    INSERT INTO consultas (aluno_id, medico_id, data, hora, status)
    VALUES (:aluno_id, :medico_id, :data, :hora, 'marcada')
");
$stmt->execute([
    ':aluno_id' => $alunoId,
    ':medico_id'=> $medicoId,
    ':data'     => $data,
    ':hora'     => $hora,
]);


// Aqui busco o email do aluno para enviar a confirmação
$stmt = $pdo->prepare('SELECT email FROM alunos WHERE id = ?');
$stmt->execute([$alunoId]);
$aluno = $stmt->fetch();

// Se o aluno tiver um email registado, envio o email de confirmação
if ($aluno && !empty($aluno['email'])) {
    $emailAluno = $aluno['email'];

    // Corpo do email enviado ao aluno
    $corpo = "
        <h2>Confirmação de consulta - Clínica Eduga</h2>
        <p>Olá, {$alunoNome}!</p>
        <p>Recebemos o seu pedido de consulta para o dia <strong>{$data}</strong> às <strong>{$hora}</strong>.</p>
    ";

    enviarEmail($emailAluno, $alunoNome, 'Confirmação de consulta - Clínica Eduga', $corpo);
}

// Aqui envio a resposta final para o JavaScript
echo json_encode([
    'ok'  => true,
    'msg' => 'Consulta marcada com sucesso!'
]);
exit;
