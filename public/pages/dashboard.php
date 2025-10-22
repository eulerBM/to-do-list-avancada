<?php
session_start();
include 'includes/header.php';

?>

<link rel="stylesheet" href="../css/dashboard.css">

<div id="divMain" class="p-4">

    <div class="container">

    </div>

    <!-- Botão Criar Tarefa -->
    <button type="button" class="btn btn-outline-secondary mb-4" data-bs-toggle="modal" data-bs-target="#modalTarefa">
        Criar tarefa
    </button>

    <!-- 🔽 Seção de Tarefas -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Tarefas</h5>
        </div>

        <ul id="task-list" class="list-group list-group-flush">

            <li class="list-group-item">

                <!-- TAREFAS VAO AQUI -->


            </li>
            <li class="list-group-item text-muted text-center">📋 Nenhuma tarefa encontrada.</li>
        </ul>

        <!-- BOTÃO DE PAGINAÇÃO -->
        <nav aria-label="Page navigation example" class="d-flex justify-content-center">

            <ul class="pagination" id="list-total-pages">

                <!-- BOTAO PAGINAÇÃO VAI AQUI -->

                </li>
            </ul>
        </nav>

    </div>

    <!-- Modal para excluir -->
    <div class="modal fade" id="modalTarefaExcluir" tabindex="-1" aria-labelledby="modalTarefaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTarefaLabel">Excluir Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">

                    <form id="formDeletTask">

                        <div class="mb-3 text-center">
                            <label for="titulo" class="form-label">Título: </label>
                        </div>

                        <div class="mb-3 text-center">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control form-control-sm" id="titulo" name="titulo" placeholder="Digite o título" required>
                        </div>

                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Excluir</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal editar tarefa -->
    <div class="modal fade" id="modalTarefaEditar" tabindex="-1" aria-labelledby="modalTarefaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTarefaLabel">Editar Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <form action="salvar_tarefa.php" method="POST">
                        <div class="mb-3 text-center">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control form-control-sm" id="titulo" name="titulo" placeholder="Digite o título" required>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control form-control-sm" id="descricao" name="descricao" rows="3" placeholder="Descrição"></textarea>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="situacao" class="form-label">Situação</label>
                            <select class="form-control form-control-sm" id="situacao" name="situacao" required>
                                <option value="">Selecione...</option>
                                <option value="pendente">Pendente</option>
                                <option value="concluida">Concluída</option>
                            </select>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="grupo" class="form-label">Grupo</label>
                            <input type="text" class="form-control form-control-sm" id="grupo" name="grupo" placeholder="Digite o email de cada pessoa" required>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="dataHora" class="form-label">Data limite</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="dataHora" name="dataHora" required>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Criar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal criar tarefa -->
    <div class="modal fade" id="modalTarefa" tabindex="-1" aria-labelledby="modalTarefaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTarefaLabel">Nova Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <form id="formTaskCreator">
                        <div class="mb-3 text-center">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control form-control-sm" id="titulo" name="titulo" placeholder="Digite o título" required>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control form-control-sm" id="descricao" name="descricao" rows="3" placeholder="Descrição"></textarea>
                        </div>

                        <div class="mb-3 text-center">
                            <label for="grupo" class="form-label">Grupo</label>
                            <input type="email" class="form-control form-control-sm" id="grupo" name="grupo[]" placeholder="Digite os e-mails dos usuários" multiple required>
                            <small class="form-text text-muted">Separe os e-mails por vírgula.</small>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="dataHora" class="form-label">Data limite</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="dataHora" name="dateLimit" required>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Criar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

<script type="module">
    import {
        fetchCreateTask,
        fetchDeleteTask
    } from "./js/api.js";
    import {
        renderTasks
    } from "./js/renderTasks.js";

    let currentPage = 1;

    // dentro do módulo
    window.deleteTask = function(nameTask, idTask) {

        const confirmDelete = confirm("Você tem certeza que quer excluir a tarefa: " + nameTask);
        if (!confirmDelete) return;

        return fetchDeleteTask(idTask);
        
    };

    document.addEventListener("DOMContentLoaded", () => {

        // ========================
        // 🔹 Renderizar Tarefas (Página Atual)
        // ========================
        renderTasks("task-list", currentPage);

        // ========================
        // 📝 Criar Tarefa
        // ========================
        const formCreate = document.getElementById("formTaskCreator");
        if (formCreate) {
            formCreate.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(formCreate);
                const data = Object.fromEntries(formData.entries());

                console.log("🟢 Enviando dados (criar):", data);

                try {
                    await fetchCreateTask(data);
                    renderTasks("task-list", currentPage); // Recarrega tarefas
                } catch (err) {
                    console.error("Erro ao criar tarefa:", err);
                }
            });
        }

        // ========================
        // 🗑️ Deletar Tarefa
        // ========================
        const formDelete = document.getElementById("formDeletTask");
        if (formDelete) {
            formDelete.addEventListener("submit", async (e) => {
                e.preventDefault();

                const formData = new FormData(formDelete);
                const data = Object.fromEntries(formData.entries());

                console.log("🔴 Enviando dados (deletar):", data);

                try {
                    await fetchCreateTask(data);
                    renderTasks("task-list", currentPage); // Recarrega tarefas
                } catch (err) {
                    console.error("Erro ao deletar tarefa:", err);
                }
            });
        }

        // ========================
        // 📄 Paginação (se quiser integrar aqui)
        // ========================
        const pagination = document.querySelector(".pagination");
        if (pagination) {
            pagination.addEventListener("click", (e) => {
                e.preventDefault();
                const target = e.target.closest(".page-link");
                if (!target) return;

                const label = target.getAttribute("aria-label");
                const pageText = target.textContent.trim();

                if (!isNaN(pageText)) {
                    currentPage = Number(pageText);
                } else if (label === "Next") {
                    currentPage++;
                } else if (label === "Previous" && currentPage > 1) {
                    currentPage--;
                }

                renderTasks("task-list", currentPage);
            });
        }
    });
</script>

<?php include 'includes/footer.php'; ?>