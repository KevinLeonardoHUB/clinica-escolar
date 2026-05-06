<?php
// Aqui inicio a sessão para poder guardar os dados do aluno depois do login
session_start();

// Aqui ligo a base de dados
require 'db.php';

// Aqui crio uma função para redirecionar para o login com uma mensagem de erro caso exista
function erro($msg) {
    header("Location: ../login.php?erro=" . urlencode($msg));
    exit;
}

// Aqui verifico se o pedido veio por POST(envio de dados), caso contrário volto para a página de login
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

// Aqui recebo o email e a senha enviados pelo formulário
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

// Aqui verifico se ambos os campos foram preenchidos
if (!$email || !$senha) {
    erro("Preencha o email e a senha.");
}

// Aqui procuro o aluno na base de dados pelo email
$stmt = $pdo->prepare('SELECT id, nome, numero_aluno, senha, email_verificado FROM alunos WHERE email = ?');
$stmt->execute([$email]);
$aluno = $stmt->fetch();

// Aqui verifico se existe aluno com esse email e se a senha está correta
if (!$aluno || !password_verify($senha, $aluno['senha'])) {
    erro("Email ou senha incorretos.");
}

// Aqui verifico se o email do aluno já foi confirmado
if (!$aluno['email_verificado']) {
    erro("Por favor confirme o seu email antes de iniciar sessão.");
}

// Aqui guardo na sessão os dados do aluno que fez login
$_SESSION['aluno_id']     = $aluno['id'];
$_SESSION['aluno_nome']   = $aluno['nome'];
$_SESSION['numero_aluno'] = $aluno['numero_aluno'];

// Aqui redireciono o aluno para a página onde ele marca consultas
header('Location: ../pagina_consultas.php');
exit;
