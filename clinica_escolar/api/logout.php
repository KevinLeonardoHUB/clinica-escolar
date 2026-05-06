<?php
// Aqui inicio a sessão para conseguir apagá-la corretamente
session_start();

// Aqui removo todas as variáveis guardadas na sessão
session_unset();

// Aqui destruo completamente a sessão do utilizador (logout total)
session_destroy();

// Aqui redireciono o utilizador de volta para a página inicial
header('Location: ../index.php');
exit;