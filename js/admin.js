document.addEventListener("DOMContentLoaded", function () {
    // Excluir usuário
    document.querySelectorAll(".delete-user").forEach(button => {
        button.addEventListener("click", function () {
            const userId = this.dataset.id;
            if (confirm("Tem certeza que deseja excluir este usuário?")) {
                fetch("delete_user.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `id=${userId}`
                })
                .then(response => response.text())
                .then(data => {
                    if (data === "success") {
                        this.closest("li").remove();
                    } else {
                        alert("Erro ao excluir usuário.");
                    }
                });
            }
        });
    });

    // Excluir arquivo
    document.querySelectorAll(".delete-file").forEach(button => {
        button.addEventListener("click", function () {
            const fileId = this.dataset.id;
            if (confirm("Tem certeza que deseja excluir este arquivo?")) {
                fetch("delete_file.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `id=${fileId}`
                })
                .then(response => response.text())
                .then(data => {
                    if (data === "success") {
                        this.closest("li").remove();
                    } else {
                        alert("Erro ao excluir arquivo.");
                    }
                });
            }
        });
    });
});