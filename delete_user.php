<?php
session_start();
include 'includes/config.php';

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "error";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $userId = $_POST['id'];

    // Evita que o admin exclua a si mesmo
    if ($userId == $_SESSION['user_id']) {
        echo "error";
        exit();
    }

    // Deleta o usuário
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt->execute([$userId])) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>