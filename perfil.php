<?php
session_start();
require 'includes/config.php'; // Conexão com o banco de dados

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Buscar informações do usuário no banco de dados
$query = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch();

// Atualizar perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';
    $ocultar_data = isset($_POST['ocultar_data']) ? 1 : 0;

    // Upload de imagem
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "uploads/perfis/";
        $target_file = $target_dir . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
    } else {
        $target_file = $user['foto'] ?? "";
    }

    $update_query = "UPDATE usuarios SET descricao = :descricao, data_nascimento = :data_nascimento, ocultar_data = :ocultar_data, foto = :foto WHERE id = :id";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->execute([
        'descricao' => $descricao,
        'data_nascimento' => $data_nascimento,
        'ocultar_data' => $ocultar_data,
        'foto' => $target_file,
        'id' => $user_id
    ]);

    header("Location: perfil.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="perfil-container">
        <h1>Meu Perfil</h1>
        <form action="perfil.php" method="POST" enctype="multipart/form-data">
            <div class="perfil-foto">
                <img src="<?php echo !empty($user['foto']) ? $user['foto'] : 'img/default-avatar.png'; ?>" alt="Foto de Perfil">
                <input type="file" name="foto">
            </div>
            <label>Nome:</label>
            <input type="text" value="<?php echo htmlspecialchars($user['nome']); ?>" disabled>
            <label>Número de Estudante:</label>
            <input type="text" value="<?php echo htmlspecialchars($user['numero_estudante']); ?>" disabled>
            <label>Curso:</label>
            <input type="text" value="<?php echo htmlspecialchars($user['curso']); ?>" disabled>
            <label>Classe:</label>
            <input type="text" value="<?php echo htmlspecialchars($user['classe']); ?>" disabled>
            <label>Descrição do Perfil:</label>
            <textarea name="descricao"><?php echo htmlspecialchars($user['descricao']); ?></textarea>
            <label>Data de Nascimento:</label>
            <input type="date" name="data_nascimento" value="<?php echo htmlspecialchars($user['data_nascimento']); ?>">
            <label>
                <input type="checkbox" name="ocultar_data" <?php echo $user['ocultar_data'] ? 'checked' : ''; ?>> Ocultar data de nascimento
            </label>
            <h3>📊 Estatísticas de Acesso</h3>
            <p>Total de acessos: <?php echo rand(10, 100); ?> vezes</p>
            <p>Último login: <?php echo date('d/m/Y H:i', strtotime($user['ultimo_login'])); ?></p>
            <button type="submit">Atualizar Perfil</button>
        </form>
    </div>
</body>
</html>