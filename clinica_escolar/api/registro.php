<?php
// Aqui inicio a sessão para poder guardar ou validar dados do utilizador
session_start();

// Aqui faço a ligação ao banco de dados e importo a função de enviar email
require 'db.php';
require 'enviar_email.php';

// Aqui verifico se o pedido veio por POST(envio de dados), caso contrário volto para a página de registo
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../registro.php');
    exit;
}

// Aqui recebo os campos enviados pelo formulário e uso trim para limpar os espaços para leitura
$nome   = trim($_POST['nome']   ?? '');
$turma  = trim($_POST['turma']  ?? '');
$email  = trim($_POST['email']  ?? '');
$senha  = $_POST['senha']  ?? '';
$senha2 = $_POST['senha2'] ?? '';

// Aqui crio uma função rápida para redirecionar com uma mensagem de erro caso exista
function erro($msg) {
    header("Location: ../registro.php?erro=" . urlencode($msg));
    exit;
}

// Aqui valido o nome, permitindo apenas letras (com acentos) e espaços, sem numeros ou caracteres especiais
if (!preg_match('/^[A-Za-zÀ-ÿ ]+$/', $nome)) {
    erro("O nome só pode conter letras e espaços.");
}

// Aqui separo o nome por espaços para garantir primeiro e último nome
$partes_nome = explode(' ', trim($nome));
$partes_nome = array_filter($partes_nome);

// Aqui verifico se o utilizador escreveu pelo menos duas palavras, pois o aluno tem que ter o nome e sobrenome
if (count($partes_nome) < 2) {
    erro("Por favor escreva o primeiro e o último nome.");
}

// Aqui verifico se cada nome tem pelo menos 2 letras, para ser válido
foreach ($partes_nome as $p) {
    if (mb_strlen($p) < 2) {
        erro("Cada nome deve ter pelo menos 2 letras.");
    }
}

// Aqui valido se a turma está no formato correto (ex.: 9ºF, 12ºGPSI)
if (!preg_match('/^\d{1,2}º[A-Za-z]+$/', $turma)) {
    erro("A turma deve estar no formato correto (ex: 9ºF, 12ºGPSI).");
}

// Aqui verifico se o email é válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    erro("Email inválido.");
}

// Aqui verifico se as senhas são iguais
if ($senha !== $senha2) {
    erro("As senhas não coincidem.");
}

// Aqui valido a força da senha (mínimo 8 caracteres, 1 maiúscula e 1 número)
if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $senha)) {
    erro("A senha deve ter no mínimo 8 caracteres, incluir 1 letra maiúscula e 1 número.");
}

// Aqui verifico se já existe conta com o mesmo email
$stmt = $pdo->prepare('SELECT id FROM alunos WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    erro("Já existe uma conta com este email.");
}

// Aqui crio uma função para gerar um número único de aluno (ex.: a00012)
function gerarNumeroAluno(PDO $pdo): string {
    do {
        $numero = 'a' . str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);
        $st = $pdo->prepare('SELECT id FROM alunos WHERE numero_aluno = ?');
        $st->execute([$numero]);
        $existe = $st->fetch();
    } while ($existe);

    return $numero;
}

// Aqui gero o número do aluno e faço hash da senha para guardar em segurança, tambem crio o token para enviar ao email e confirmar a conta
$numeroAluno = gerarNumeroAluno($pdo);
$hash        = password_hash($senha, PASSWORD_DEFAULT);
$token       = bin2hex(random_bytes(32));

// Aqui insiro o novo aluno no banco de dados
$stmt = $pdo->prepare("
    INSERT INTO alunos (numero_aluno, nome, turma, email, senha, email_verificado, token_verificacao)
    VALUES (?, ?, ?, ?, ?, 0, ?)
");
$stmt->execute([$numeroAluno, $nome, $turma, $email, $hash, $token]);

// Aqui crio o link para o aluno confirmar o email com a token enviada por email
$link = 'http://localhost/clinica_escolar/api/confirmar_email.php?token=' . urlencode($token) .
        '&email=' . urlencode($email);

// Aqui preparo o corpo da mensagem de confirmação
$corpo = "
    <h2>Confirmação de email - Clínica Eduga</h2>
    <p>Olá, {$nome}!</p>
    <p>Clique no link abaixo para confirmar o seu email:</p>
    <p><a href=\"{$link}\">Confirmar email</a></p>
";

// Aqui envio o email de confirmação
enviarEmail($email, $nome, 'Confirmação de email - Clínica Eduga', $corpo);

// Aqui redireciono para o login com mensagem de sucesso
header("Location: ../login.php?sucesso=" . urlencode("Conta criada! Verifique o seu email para ativar a conta."));
exit;
?>
