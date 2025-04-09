<?php
session_start();
include 'includes/config.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    die("Acesso negado.");
}

// Diretório de destino
$uploadDir = 'uploads/';

// Lista de extensões permitidas
$allowed_types = ['pdf', 'jpg', 'jpeg', 'png', 'docx', 'mp4'];
$max_size = 5 * 1024 * 1024; // 5MB

// Verifica se um arquivo foi enviado
if (!isset($_FILES['arquivo']) || $_FILES['arquivo']['error'] !== UPLOAD_ERR_OK) {
    die("Erro no envio do arquivo.");
}

$file = $_FILES['arquivo'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

// Validação do tipo de arquivo
if (!in_array($ext, $allowed_types)) {
    die("Tipo de arquivo não permitido.");
}

// Validação do tamanho do arquivo
if ($file['size'] > $max_size) {
    die("O arquivo excede o limite de 5MB.");
}

// Renomeia o arquivo para evitar conflitos
$new_name = uniqid() . "." . $ext;
$destination = $uploadDir . $new_name;

// Move o arquivo para o diretório seguro
if (move_uploaded_file($file['tmp_name'], $destination)) {
    // Insere o registro no banco de dados
    $stmt = $pdo->prepare("INSERT INTO files (user_id, file_name, file_path) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $file['name'], $destination]);

    echo "Upload realizado com sucesso!";
} else {
    die("Erro ao mover o arquivo.");
}
?>