<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Enviar mensagem
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = trim($_POST['message']);
    if (!empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO Mensagens (Mensagem, ID_Usuario_Envia) VALUES (?, ?)");
        $stmt->execute([$message, $userId]);
    }
    exit(); // Para evitar recarregamento da página
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chat Interno</title>
    <link rel="stylesheet" href="css/chat.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .chat-container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
        }
        .chat-box {
            border: 1px solid #ccc;
            padding: 10px;
            height: 400px;
            overflow-y: scroll;
            background: #f8f9fa;
        }
    </style>
</head>
<body>

<div class="chat-container">
    <h2 class="text-center">Chat Interno</h2>
    
    <div class="chat-box" id="chat-box">
        <!-- Mensagens serão carregadas aqui -->
    </div>

    <form id="chat-form">
        <div class="input-group mt-2">
            <input type="text" id="message" name="message" class="form-control" placeholder="Digite sua mensagem" required>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </form>

    <a href="logout.php" class="btn btn-secondary mt-3 d-block">Sair</a>
</div>

<script>
    function loadMessages() {
        $.get("chat_load.php", function(data) {
            $("#chat-box").html(data);
            $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
        });
    }

    $("#chat-form").submit(function(e) {
        e.preventDefault();
        $.post("chat.php", { message: $("#message").val() }, function() {
            $("#message").val('');
            loadMessages();
        });
    });

    setInterval(loadMessages, 3000); // Atualiza a cada 3 segundos
    loadMessages();
</script>

</body>
</html>