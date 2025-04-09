<?php
session_start();
$_SESSION = []; // Limpa todas as variáveis de sessão
session_unset(); // Remove todas as variáveis da sessão ativa
session_destroy(); // Destroi a sessão

// Evita que o navegador armazene em cache a página protegida
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Location: login.php");
exit();
?>