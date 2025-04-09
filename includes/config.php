<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'biblioteca_virtual');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Retorna arrays associativos por padrão
        PDO::ATTR_EMULATE_PREPARES => false, // Melhor proteção contra SQL Injection
    ]);
} catch (PDOException $e) {
    error_log("Erro na conexão: " . $e->getMessage()); // Registra o erro sem expor no navegador
    die("Erro ao conectar ao banco de dados. Tente novamente mais tarde.");
}
?>