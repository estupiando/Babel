document.addEventListener("DOMContentLoaded", function () {
    const chatBox = document.querySelector(".chat-box");
    const messageForm = document.querySelector("form");
    const messageInput = document.querySelector("input[name='message']");

    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    async function fetchMessages() {
        try {
            const response = await fetch("fetch_messages.php");
            const messages = await response.json();
            chatBox.innerHTML = "";
            messages.forEach(msg => {
                const messageDiv = document.createElement("div");
                messageDiv.classList.add("message");
                if (msg.self) {
                    messageDiv.classList.add("self");
                }
                messageDiv.innerHTML = `<strong>${msg.username}:</strong> ${msg.message}`;
                chatBox.appendChild(messageDiv);
            });
            scrollToBottom();
        } catch (error) {
            console.error("Erro ao buscar mensagens", error);
        }
    }

    messageForm.addEventListener("submit", async function (event) {
        event.preventDefault();
        const message = messageInput.value.trim();
        if (message === "") return;
        try {
            await fetch("chat.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `message=${encodeURIComponent(message)}`
            });
            messageInput.value = "";
            fetchMessages();
        } catch (error) {
            console.error("Erro ao enviar mensagem", error);
        }
    });

    setInterval(fetchMessages, 3000); // Atualiza o chat a cada 3 segundos
    fetchMessages();
});