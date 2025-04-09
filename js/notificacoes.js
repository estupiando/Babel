document.addEventListener("DOMContentLoaded", function () {
    // Configurar Pusher
    Pusher.logToConsole = false; // Defina como 'true' para debug
    const pusher = new Pusher("7f1f458f0742ba4a3f88", {
        cluster: "ap2",
        encrypted: true
    });

    // Assinar o canal de notificações
    const channel = pusher.subscribe("biblioteca-channel");

    // Listener para novas notificações de arquivos
    channel.bind("novo-arquivo", function (data) {
        const mensagem = `📂 Novo arquivo: ${data.nome_arquivo}`;
        exibirNotificacao(mensagem);
        enviarNotificacaoNavegador(mensagem);
    });

    // Listener para notificações de novos usuários
    channel.bind("novo-usuario", function (data) {
        const mensagem = `👤 Novo usuário registrado: ${data.username}`;
        exibirNotificacao(mensagem);
        enviarNotificacaoNavegador(mensagem);
    });

    // Função para exibir notificações na UI
    function exibirNotificacao(mensagem) {
        const notificacoesContainer = document.getElementById("notificacoes");

        if (notificacoesContainer) {
            const noti = document.createElement("div");
            noti.className = "notificacao fade-in";
            noti.textContent = mensagem;

            // Adiciona a notificação ao container
            notificacoesContainer.appendChild(noti);

            // Remove a notificação após 5 segundos com efeito
            setTimeout(() => {
                noti.classList.add("fade-out");
                setTimeout(() => {
                    noti.remove();
                }, 500); // Tempo para a animação de saída
            }, 5000);
        }
    }

    // Função para notificações no navegador
    function enviarNotificacaoNavegador(mensagem) {
        if (Notification.permission === "granted") {
            new Notification("Biblioteca Virtual 📚", {
                body: mensagem,
                icon: "/img/notificacao-icon.png"
            });
        } else if (Notification.permission !== "denied") {
            Notification.requestPermission().then(permission => {
                if (permission === "granted") {
                    new Notification("Biblioteca Virtual 📚", {
                        body: mensagem,
                        icon: "/img/notificacao-icon.png"
                    });
                }
            });
        }
    }
});