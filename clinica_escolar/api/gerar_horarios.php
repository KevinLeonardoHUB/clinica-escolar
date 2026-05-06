<?php
// Aqui ativo a exibição de todos os erros, usei para testes, porque estava com problemas
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Aqui faço a ligação ao banco de dados
require 'db.php';

// Aqui defino as configurações para a geração automática dos horários
$diasParaFrente = 30;        // quantos dias a partir de hoje vão ser gerados
$horaInicio = 8;             // hora inicial (08:00)
$horaFim = 14;               // hora final (14:00) - inclui 08,09,10,11,12,13,14
$intervaloHoras = 1;         // intervalo de 1 em 1 hora entre os horários, para ter o tempo da consulta e tempo do medico se preparar para a próxima consulta

// Aqui apenas mostro uma mensagem inicial para acompanhar o processo, escrevo apenas para teste, pois essa não é uma pagina acessivel
echo "<pre>Iniciando geração de horários...\n";

// Aqui busco todos os médicos cadastrados no banco, escrevo apenas para teste, pois essa não é uma pagina acessivel
try {
    $medicos = $pdo->query("SELECT id, nome FROM medicos")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar médicos: " . $e->getMessage());
}

// Aqui verifico se existe pelo menos um médico, escrevo apenas para teste, pois essa não é uma pagina acessivel
if (empty($medicos)) {
    die("Nenhum médico encontrado na tabela 'medicos'. Cadastre pelo menos um médico primeiro.");
}

// Mostro no ecrã os médicos encontrados, escrevo apenas para teste, pois essa não é uma pagina acessivel
echo "Médicos encontrados:\n";
foreach ($medicos as $m) {
    echo "- ID {$m['id']}: {$m['nome']}\n";
}

// Aqui pego a data de hoje para começar a gerar os horários
$dataHoje = new DateTime();

// Aqui percorro cada médico para gerar horários individualmente, escrevo apenas para teste, pois essa não é uma pagina acessivel
foreach ($medicos as $medico) {

    $medicoId = $medico['id'];
    echo "\nGerando horários para o médico ID {$medicoId}...\n";

    // Aqui copio a data de hoje para não alterar a variável original
    $data = clone $dataHoje;

    // Loop que percorre os dias definidos anteriormente
    for ($d = 0; $d < $diasParaFrente; $d++) {

        // Converto a data para formato YYYY-MM-DD
        $dataStr = $data->format('Y-m-d');
        echo "  Dia: {$dataStr}\n";

        // Aqui percorro as horas daquele dia (de 08:00 até 14:00)
        for ($h = $horaInicio; $h <= $horaFim; $h += $intervaloHoras) {

            // Formato da hora sempre com dois dígitos (ex: 08:00:00)
            $horaStr = sprintf('%02d:00:00', $h);
            echo "    Verificando horário {$horaStr}... ";

            // Aqui verifico se esse horário já existe na base de dados
            $check = $pdo->prepare("
                SELECT COUNT(*) FROM horarios
                WHERE medico_id = ? AND data = ? AND hora = ?
            ");
            $check->execute([$medicoId, $dataStr, $horaStr]);
            $existe = $check->fetchColumn();

            // Se não existir, insiro um novo horário
            if ($existe == 0) {
                $insert = $pdo->prepare("
                    INSERT INTO horarios (medico_id, data, hora, disponivel)
                    VALUES (?, ?, ?, 1)
                ");
                $insert->execute([$medicoId, $dataStr, $horaStr]);
                echo "INSERIDO.\n";

            // Se já existir, não insiro novamente
            } else {
                echo "já existia, pulando.\n";
            }
        }

        // Aqui avanço para o próximo dia
        $data->modify('+1 day');
    }
}

// Mensagem final informando que terminou, escrevo apenas para teste, pois essa não é uma pagina acessivel
echo "\nConcluído!\n</pre>";
