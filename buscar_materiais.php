<?php
require 'includes/config.php';

$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$curso = isset($_POST['curso']) ? trim($_POST['curso']) : '';
$classe = isset($_POST['classe']) ? trim($_POST['classe']) : '';
$trimestre = isset($_POST['trimestre']) ? trim($_POST['trimestre']) : '';
$disciplina = isset($_POST['disciplina']) ? trim($_POST['disciplina']) : '';

$query = "SELECT titulo, descricao, data_upload FROM materiais WHERE 1=1";

if (!empty($search)) {
    $query .= " AND titulo LIKE '%$search%'";
}
if (!empty($curso)) {
    $query .= " AND curso = '$curso'";
}
if (!empty($classe)) {
    $query .= " AND classe = '$classe'";
}
if (!empty($trimestre)) {
    $query .= " AND trimestre = '$trimestre'";
}
if (!empty($disciplina)) {
    $query .= " AND disciplina = '$disciplina'";
}

$query .= " ORDER BY data_upload DESC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<li><strong>" . htmlspecialchars($row['titulo']) . "</strong> - " . htmlspecialchars($row['descricao']) . " <small>(" . date('d/m/Y', strtotime($row['data_upload'])) . ")</small></li>";
    }
} else {
    echo "<li>Nenhum material encontrado.</li>";
}
?>