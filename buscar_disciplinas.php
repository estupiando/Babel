<?php
require 'includes/config.php'; // Conexão com o banco de dados

if (isset($_POST['curso']) && isset($_POST['classe'])) {
    $curso = $_POST['curso'];
    $classe = $_POST['classe'];

    // Consulta para buscar disciplinas relacionadas ao curso e classe selecionados
    $sql = "SELECT id, nome FROM disciplinas WHERE curso_id = ? AND classe_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$curso, $classe]);

    $disciplinas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($disciplinas); // Retorna os dados em JSON para o JavaScript
}
?>