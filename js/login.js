document.addEventListener("DOMContentLoaded", function() {
    const container = document.getElementById('container');
    const registerBtn = document.getElementById('register');
    const loginBtn = document.getElementById('login');

    // Alterna entre login e registro
    registerBtn.addEventListener('click', () => container.classList.add("active"));
    loginBtn.addEventListener('click', () => container.classList.remove("active"));

    // ================= LOGIN =================
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        event.preventDefault();
        
        let formData = new FormData(this);
        let button = document.getElementById("loginButton");
        let buttonText = document.getElementById("buttonText");
        let spinner = document.getElementById("loadingSpinner");
        let statusDiv = document.getElementById("loginStatus");

        statusDiv.innerHTML = ""; // Limpa mensagens anteriores

        // Desativa o botão e exibe o spinner
        button.disabled = true;
        buttonText.classList.add("d-none");
        spinner.classList.remove("d-none");

        fetch("login.php", {
            method: "POST",
            body: new URLSearchParams(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                statusDiv.innerHTML = `<p class="text-danger">${data.error}</p>`;
            } else if (data.success) {
                statusDiv.innerHTML = `<p class="text-success">${data.success}</p>`;
                setTimeout(() => window.location.href = data.redirect, 1500);
            }
        })
        .catch(error => {
            console.error("Erro:", error);
            statusDiv.innerHTML = `<p class="text-danger">Erro ao processar login.</p>`;
        })
        .finally(() => {
            button.disabled = false;
            buttonText.classList.remove("d-none");
            spinner.classList.add("d-none");
        });
    });

    // ================= CADASTRO =================
    document.getElementById("registerForm").addEventListener("submit", function(event) {
        event.preventDefault();
        
        let formData = new FormData(this);
        let button = this.querySelector("button");
        let statusDiv = document.getElementById("registerStatus");

        statusDiv.innerHTML = ""; // Limpa mensagens anteriores
        button.disabled = true;
        button.innerHTML = "Cadastrando...";

        fetch("register.php", {
            method: "POST",
            body: new URLSearchParams(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                statusDiv.innerHTML = `<p class="text-danger">${data.error}</p>`;
            } else if (data.success) {
                statusDiv.innerHTML = `<p class="text-success">${data.success}</p>`;
                setTimeout(() => window.location.href = "index.php", 2000);
            }
        })
        .catch(error => {
            console.error("Erro:", error);
            statusDiv.innerHTML = `<p class="text-danger">Erro ao processar cadastro.</p>`;
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = "Cadastrar";
        });
    });

    // ================= MOSTRAR/OCULTAR SENHA =================
    document.querySelectorAll(".btn-outline-secondary").forEach(button => {
        button.addEventListener("click", function() {
            let input = this.previousElementSibling;
            input.type = input.type === "password" ? "text" : "password";
            this.innerHTML = input.type === "password" ? "👁️" : "🙈";
        }); 
    });
});
