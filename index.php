<?php
session_start();
require 'includes/config.php'; // Arquivo de conexão com o banco de dados

// Buscar materiais recentes
$query = "SELECT titulo, descricao, data_upload FROM materiais_didaticos ORDER BY data_upload DESC LIMIT 5";
$result = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="container">
    <header>
        <h1>📚 Biblioteca Virtual</h1>
        <p>Bem-vindo! Aqui você encontra os materiais didáticos mais recentes.</p>
    </header>

    <!-- Links para seções principais -->
    <nav class="nav-links">
        <a href="perfil.php">👤 Perfil</a>
        <a href="materiais.php">📂 Materiais</a>
        <a href="notificacoes.php">🔔 Notificações</a>
        <a href="comunidade.php">💬 Comunidade</a>
    </nav>
    <form id="filtro-materiais">
        <label for="curso">Curso:</label>
        <select id="curso" name="curso">
            <option value="">Selecione o curso</option>
            <!-- Cursos preenchidos do banco de dados -->
        </select>

        <label for="classe">Classe:</label>
        <select id="classe" name="classe" disabled>
            <option value="">Selecione a classe</option>
        </select>

        <label for="disciplina">Disciplina:</label>
        <select id="disciplina" name="disciplina" disabled>
            <option value="">Selecione a disciplina</option>
        </select>

        <button type="submit">Pesquisar</button>
    </form>
    
    <!-- Seção de materiais recentes -->
    <section class="recentes">
        <h2>📌 Materiais Recentes</h2>
        <ul>
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                <li>
                    <strong><?php echo $row['titulo']; ?></strong> - <?php echo $row['descricao']; ?>
                    <small>(<?php echo date('d/m/Y', strtotime($row['data_upload'])); ?>)</small>
                </li>
            <?php } ?>
        </ul>
    </section>
</div>

<script src="js/main.js"></script>
</body>
</html>