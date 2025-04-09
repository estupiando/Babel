document.addEventListener("DOMContentLoaded", function () {
    console.log("Main.js carregado");

    // Validação de formulários
    const forms = document.querySelectorAll("form");
    forms.forEach(form => {
        form.addEventListener("submit", function (event) {
            let valid = true;
            const inputs = form.querySelectorAll("input[required], textarea[required]");
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    valid = false;
                    input.classList.add("input-error");
                } else {
                    input.classList.remove("input-error");
                }
            });

            if (!valid) {
                event.preventDefault();
                alert("Por favor, preencha todos os campos obrigatórios.");
            }
        });
    });

    // Alternância de visibilidade de senha
    const togglePasswords = document.querySelectorAll(".toggle-password");
    togglePasswords.forEach(toggle => {
        toggle.addEventListener("click", function () {
            const input = this.previousElementSibling;
            if (input.type === "password") {
                input.type = "text";
                this.textContent = "Ocultar";
            } else {
                input.type = "password";
                this.textContent = "Mostrar";
            }
        });
    });

    // === Busca de materiais ===
    document.addEventListener("DOMContentLoaded", function () {
        const cursoSelect = document.getElementById("curso");
        const classeSelect = document.getElementById("classe");
        const disciplinaSelect = document.getElementById("disciplina");
    
        // Quando um curso for selecionado, carregar as classes correspondentes
        cursoSelect.addEventListener("change", function () {
            const cursoId = this.value;
            classeSelect.innerHTML = '<option value="">Selecione a classe</option>';
            disciplinaSelect.innerHTML = '<option value="">Selecione a disciplina</option>';
            disciplinaSelect.disabled = true;
    
            if (cursoId) {
                classeSelect.disabled = false;
                buscarOpcoes("buscar_classes.php", { curso: cursoId }, classeSelect);
            } else {
                classeSelect.disabled = true;
            }
        });
    
        // Quando uma classe for selecionada, carregar as disciplinas correspondentes
        classeSelect.addEventListener("change", function () {
            const cursoId = cursoSelect.value;
            const classeId = this.value;
            disciplinaSelect.innerHTML = '<option value="">Selecione a disciplina</option>';
    
            if (classeId) {
                disciplinaSelect.disabled = false;
                buscarOpcoes("buscar_disciplinas.php", { curso: cursoId, classe: classeId }, disciplinaSelect);
            } else {
                disciplinaSelect.disabled = true;
            }
        });
    
        function buscarOpcoes(url, dados, select) {
            fetch(url, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams(dados),
            })
            .then(response => response.json())
            .then(data => {
                data.forEach(opcao => {
                    const option = document.createElement("option");
                    option.value = opcao.id;
                    option.textContent = opcao.nome;
                    select.appendChild(option);
                });
            })
            .catch(error => console.error("Erro ao buscar dados:", error));
        }
    });
    
});