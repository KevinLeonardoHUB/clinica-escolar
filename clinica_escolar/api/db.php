<?php
// Aqui defino os dados necessários para conectar ao banco de dados.
// Para uso local no XAMPP, os valores padrão já funcionam.
// Em hospedagem, configure estas variáveis de ambiente no painel do servidor.
$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'clinica_escolar';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo "Erro ao conectar: " . $e->getMessage();
    exit;
}