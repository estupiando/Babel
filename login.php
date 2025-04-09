<?php
session_start();
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    if (!isset($_POST['action'])) {
        echo json_encode(["error" => "Ação não especificada."]);
        exit();
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($_POST['action'] === 'login') {
        if (empty($email) || empty($password)) {
            echo json_encode(["error" => "Preencha todos os campos."]);
            exit();
        }

        $stmt = $pdo->prepare("SELECT ID_Usuario, Tipo_Usuario, Senha FROM usuarios WHERE Email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['Senha'])) {
            $_SESSION['id_usuario'] = $user['ID_Usuario'];
            $_SESSION['tipo_usuario'] = $user['Tipo_Usuario'];
            echo json_encode(["success" => "Login realizado com sucesso!", "redirect" => "index.php"]);
        } else {
            echo json_encode(["error" => "E-mail ou senha inválidos."]);
        }
        exit();
    }

    if ($_POST['action'] === 'register') {
        $nome = trim($_POST['nome'] ?? '');
        $num_estudante = trim($_POST['num_estudante'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if (empty($nome) || empty($email) || empty($senha) || empty($num_estudante)) {
            echo json_encode(["error" => "Preencha todos os campos."]);
            exit();
        }

        // Verifica se o número de estudante existe antes de verificar o e-mail
        $stmt = $pdo->prepare("SELECT id_estudante FROM estudantes WHERE num_estudante = ?");
        $stmt->execute([$num_estudante]);
        $estudante = $stmt->fetch();

        if (!$estudante) {
            echo json_encode(["error" => "Número de estudante inválido."]);
            exit();
        }

        // Verificar se o e-mail já está cadastrado
        $stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            echo json_encode(["error" => "E-mail já cadastrado."]);
            exit();
        }

        // Criptografar a senha antes de armazenar
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Inserir novo us
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo_usuario, id_estudante) VALUES (?, ?, ?, 'estudante', ?)");
        $stmt->execute([$nome, $email, $senha_hash, $estudante['id_estudante']]);

        echo json_encode(["success" => "Cadastro realizado com sucesso!", "redirect" => "login.php"]);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Página de Login</title>
</head>

<body>

    <div class="container" id="container">
        <!-- Formulário de Cadastro -->
        <div class="form-container sign-up">
            <form id="registerForm">
                <h1>Crie uma conta</h1>
                <div class="mb-3">
                    <input type="text" name="nome" class="form-control" placeholder="Nome Completo" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="E-mail" required>
                </div>
                <div class="mb-3 input-group">
                    <input type="password" id="registerPassword" name="senha" class="form-control" placeholder="Senha" required>
                    <!--
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('registerPassword')">👁️</button>       
                    -->
                </div>
                <div class="mb-3">
                    <input type="text" name="num_estudante" class="form-control" placeholder="Número de Estudante" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                <div id="registerStatus" class="mt-3 text-center"></div>
            </form>
        </div>

        <!-- Formulário de Login -->
        <div class="form-container sign-in">
            <form id="loginForm">
                <h1>Fazer login</h1>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="E-mail" required>
                </div>
                <div class="mb-3 input-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Senha" required>
                    <!--
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">👁️</button>                        
                    -->

                </div>
                <button type="submit" id="loginButton" class="btn btn-primary w-100">
                    <span id="buttonText">Login</span>
                    <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none"></span>
                </button>
                <div id="loginStatus" class="mt-3 text-center"></div>
            </form>
        </div>

        <!-- Painel de Alternância -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Bem-vindo de volta!</h1>
                    <p>Insira seus dados pessoais para usar todos os recursos da sua biblioteca virtual!</p>
                    <button class="hidden" id="login">Entrar</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Olá, aluno!</h1>
                    <p>Faça o seu cadastro para ter acesso a todos os materiais que a instituição tem a lhe oferecer.</p>
                    <button class="hidden" id="register">Inscrever-se</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/login.js"></script>
</body>

</html>
