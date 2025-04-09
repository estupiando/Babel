<?php
session_start();
include 'includes/config.php';

$stmt = $pdo->query("SELECT m.Mensagem, u.Nome FROM Mensagens m 
                     JOIN Usuarios u ON m.ID_Usuario_Envia = u.ID_Usuario 
                     ORDER BY m.ID_Mensagem ASC");
$messages = $stmt->fetchAll();

foreach ($messages as $msg):
?>
    <div class="message"><strong><?php echo htmlspecialchars($msg['Nome']); ?>:</strong> <?php echo htmlspecialchars($msg['Mensagem']); ?></div>
<?php endforeach; ?>