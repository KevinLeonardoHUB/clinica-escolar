<?php
// Aqui inicio a sessão porque vou precisar validar e atualizar dados do aluno
session_start();

// Aqui verifico se veio com um token na URL, caso contrário o link é inválido
if (!isset($_GET['token']) || empty($_GET['token'])) {
    header("Location: ../login.php?erro=Link de confirmação inválido.");
    exit();
}

// Aqui guardo o token enviado no link com GET
$token = $_GET['token'];

// Aqui faço a ligação a base de dados
require_once "db.php";

try {
    // Aqui procuro na base de dados um aluno que tenha exatamente este token
    $stmt = $pdo->prepare("
        SELECT id 
        FROM alunos 
        WHERE token_verificacao = :token
        LIMIT 1
    ");
    $stmt->bindParam(":token", $token, PDO::PARAM_STR);
    $stmt->execute();

    // Aqui guardo o resultado da pesquisa (ou false se não existir)
    $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

    // Aqui verifico se encontrou realmente um aluno com esse token
    if (!$aluno) {
        header("Location: ../login.php?erro=Link de confirmação inválido ou expirado.");
        exit();
    }

    // Aqui atualizo o aluno: marco o email como verificado e removo o token da base de dados
    $stmt = $pdo->prepare("
        UPDATE alunos
        SET email_verificado = 1,
            token_verificacao = NULL
        WHERE id = :id
    ");
    $stmt->bindParam(":id", $aluno['id'], PDO::PARAM_INT);
    $stmt->execute();

    // Aqui redireciono o aluno para o login com mensagem de sucesso
    header("Location: ../login.php?sucesso=Email confirmado com sucesso! Já pode entrar.");
    exit();

} catch (Exception $e) {
    // Se acontecer algum erro inesperado, mostro na tela (apenas para debug e teste)
    echo "Erro ao confirmar email: " . $e->getMessage();
    exit();
}
