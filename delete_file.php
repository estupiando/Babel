<?php
session_start();
include 'includes/config.php';

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "error";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $fileId = $_POST['id'];

    // Busca o caminho do arquivo antes de deletá-lo
    $stmt = $pdo->prepare("SELECT file_path FROM files WHERE id = ?");
    $stmt->execute([$fileId]);
    $file = $stmt->fetch();

    if ($file) {
        // Remove o arquivo do servidor
        if (file_exists($file['file_path'])) {
            unlink($file['file_path']);
        }

        // Remove do banco de dados
        $stmt = $pdo->prepare("DELETE FROM files WHERE id = ?");
        if ($stmt->execute([$fileId])) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>