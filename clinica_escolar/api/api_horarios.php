<?php

// Aqui ativo os erros para aparecerem (usei para testar e encontrar problemas)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Aqui coloco que a resposta deste ficheiro será em JSON porque vai ser lido pelo JavaScript 
header('Content-Type: application/json; charset=utf-8');

// Aqui faço a ligação ao banco de dados
require 'db.php';

// Aqui recebo o ID do médico e a data enviados pelo JavaScript 
$medicoId = isset($_GET['medico_id']) ? (int) $_GET['medico_id'] : 0;
$data     = isset($_GET['data']) ? $_GET['data'] : null;

// Aqui verifico se os parâmetros recebidos são válidos
if ($medicoId <= 0 || !$data) {
    echo json_encode(['error' => 'Parâmetros inválidos.']);
    exit;
}

// Aqui crio a query em sql que busca todos os horários do médico escolhido
// Também verifico se já existe consulta nesse horário (status 'marcada')
// Se não existir consulta, o horário está disponível
$sql = "
    SELECT 
        h.id,
        h.hora,
        CASE 
            WHEN c.id IS NULL THEN 1   -- Se não existir consulta, horário está disponível
            ELSE 0                      -- Se existir consulta marcada, NÃO está disponível
        END AS disponivel
    FROM horarios h
    LEFT JOIN consultas c
        ON c.medico_id = h.medico_id
       AND c.data = h.data
       AND c.hora = h.hora
       AND c.status = 'marcada'
    WHERE h.medico_id = :medico_id   -- Médico escolhido
      AND h.data = :data             -- Data escolhida
    ORDER BY h.hora                  -- Ordeno os horários
";

// Aqui preparo e executo a query
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':medico_id' => $medicoId,
    ':data'      => $data
]);

// Aqui recebo todos os horários encontrados
$horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Aqui devolvo a resposta em JSON para o JavaScript usar na página
echo json_encode($horarios);
