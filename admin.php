<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'administrador') {
    header("Location: login.php");
    exit();
}

// Listar usuários
$stmt = $pdo->query("SELECT * FROM Usuarios");
$users = $stmt->fetchAll();

// Listar arquivos
$stmtFiles = $pdo->query("SELECT * FROM Materiais_Didaticos");
$files = $stmtFiles->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel de Administração</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h1 class="mb-4">Painel de Administração</h1>

    <h2>Usuários</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['Nome']); ?></td>
                    <td><?php echo htmlspecialchars($user['Email']); ?></td>
                    <td><?php echo htmlspecialchars($user['Tipo_Usuario']); ?></td>
                    <td>
                        <a href="editar_usuario.php?id=<?php echo $user['ID_Usuario']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="excluir_usuario.php?id=<?php echo $user['ID_Usuario']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Arquivos</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Tipo</th>
                <th>Download</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($files as $file): ?>
                <tr>
                    <td><?php echo htmlspecialchars($file['Titulo']); ?></td>
                    <td><?php echo htmlspecialchars($file['Tipo']); ?></td>
                    <td><a href="uploads/<?php echo htmlspecialchars($file['Arquivo']); ?>" class="btn btn-primary btn-sm" download>Baixar</a></td>
                    <td>
                        <a href="excluir_arquivo.php?id=<?php echo $file['ID_Material']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="logout.php" class="btn btn-secondary mt-3">Sair</a>
</body>
</html>