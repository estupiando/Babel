<?php
session_start();
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $num_estudante = trim($_POST['num_estudante'] ?? '');

    if (empty($nome) || empty($email) || empty($senha) || empty($num_estudante)) {
        echo json_encode(["error" => "Preencha todos os campos."]);
        exit();
    }

    // Verificar se o e-mail já está cadastrado
    $stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(["error" => "E-mail já cadastrado."]);
        exit();
    }

    // Verificar se o número de estudante existe na base de dados
    $stmt = $pdo->prepare("SELECT id_estudante FROM estudantes WHERE num_estudante = ?");
    $stmt->execute([$num_estudante]);
    $estudante = $stmt->fetch();

    if (!$estudante) {
        echo json_encode(["error" => "Número de estudante inválido."]);
        exit();
    }

    // Criptografar a senha antes de armazenar
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir novo usuário na base de dados
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo_usuario, id_estudante) VALUES (?, ?, ?, 'estudante', ?)");
    $stmt->execute([$nome, $email, $senha_hash, $estudante['id_estudante']]);

    echo json_encode(["success" => "Cadastro realizado com sucesso!", "redirect" => "login.php"]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Estudante</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card p-4 shadow" style="width: 350px;">
    <h3 class="text-center">Cadastro de Estudante</h3>

    <form id="registerForm">
        <div class="mb-3">
            <input type="text" name="nome" class="form-control" placeholder="Nome Completo" required>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="E-mail" required>
        </div>
        <div class="mb-3">
            <input type="password" name="senha" class="form-control" placeholder="Senha" required>
        </div>
        <div class="mb-3">
            <input type="text" name="num_estudante" class="form-control" placeholder="Número de Estudante" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
    </form>

    <div id="registerStatus" class="mt-3 text-center"></div>

    <a href="login.php" class="d-block text-center mt-2">Já tem uma conta? Faça login</a>
</div>

<script>
$(document).ready(function() {
    $("#registerForm").submit(function(event) {
        event.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: "register.php",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                let statusDiv = $("#registerStatus");
                if (response.error) {
                    statusDiv.html('<p class="text-danger">' + response.error + '</p>');
                } else if (response.success) {
                    statusDiv.html('<p class="text-success">' + response.success + '</p>');
                    setTimeout(() => window.location.href = response.redirect, 1500);
                }
            },
            error: function() {
                $("#registerStatus").html('<p class="text-danger">Erro ao processar o cadastro.</p>');
            }
        });
    });
});
</script>

</body>
</html>