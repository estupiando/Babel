<?php
require __DIR__ . '/vendor/autoload.php';

use Pusher\Pusher;

$options = array(
    'cluster' => 'ap2',         // Exemplo: 'ap2'
    'useTLS' => true
);

$pusher = new Pusher(
    '7f1f458f0742ba4a3f88',     // Exemplo: 'SEU_APP_KEY',
    'd659fdfd680fda9a958b',     // Exemplo: 'SEU_APP_SECRET',
    '1946057',                  // Exemplo: 'SEU_APP_ID',
    $options
);

// Exemplo de notificação
$data = ['mensagem' => 'Nova postagem disponível na biblioteca!'];
$pusher->trigger('notificacoes_canal', 'nova_notificacao', $data);

echo "Notificação enviada!";
?>