<?php
session_start();
require 'includes/config.php'; // Arquivo de conexão com o banco de dados

// Buscar materiais recentes
$query = "SELECT titulo, descricao, data_upload, imagem FROM materiais_didaticos ORDER BY data_upload DESC LIMIT 5";
$result = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<!-- Menu Superior -->
<header class="top-menu">
    <div class="logo">📖 Biblioteca Virtual</div>
    <nav>
        <ul>
            <li><a href="index.php">🏠 Home</a></li>
            <li><a href="materiais.php">📚 Biblioteca</a></li>
            <li><a href="comunidade.php">💬 Comunidade</a></li>
            <li><a href="notificacoes.php">🔔 Notificações</a></li>
            <li><a href="perfil.php">👤 Perfil</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h1>Bem-vindo à Biblioteca Virtual</h1>
    <p>Encontre materiais didáticos e participe da comunidade acadêmica.</p>

    <!-- Barra de Pesquisa -->
    <form id="filtro-materiais" class="search-bar">
        <input type="text" id="pesquisa" name="pesquisa" placeholder="🔎 Buscar materiais...">
        <label for="curso">Curso:</label>
        <select id="curso" name="curso">
            <option value="">Todos</option>
        </select>

        <label for="classe">Classe:</label>
        <select id="classe" name="classe">
            <option value="">Todas</option>
        </select>

        <label for="disciplina">Disciplina:</label>
        <select id="disciplina" name="disciplina">
            <option value="">Todas</option>
        </select>

        <button type="submit">Pesquisar</button>
    </form>

    <!-- Seção de materiais recentes -->
    <section class="recentes">
        <h2>📌 Materiais Recentes</h2>
        <div class="materiais-grid">
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="material-item">
                    <img src="uploads/<?php echo $row['imagem']; ?>" alt="Capa do material">
                    <div class="info">
                        <strong><?php echo $row['titulo']; ?></strong>
                        <p><?php echo $row['descricao']; ?></p>
                        <small><?php echo date('d/m/Y', strtotime($row['data_upload'])); ?></small>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
</div>

<script src="js/main.js"></script>
</body>
</html>