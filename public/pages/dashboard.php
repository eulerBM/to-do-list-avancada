<?php
session_start();
include 'includes/header.php';

?>

<link rel="stylesheet" href="../css/dashboard.css">

<div id="divMain" class="p-4">

    <div class="container">

    </div>

    <!-- Botão Criar Tarefa -->
    <button type="button" class="btn btn-outline-secondary mb-4" onclick="createTask()">
        Criar tarefa
    </button>

    <!-- Seção de Tarefas -->
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

    <!-- MODAL EDITAR TASK VAI AQUI -->
    <div id="modalEditTask">

    </div>

    <!-- MODAL EXCLUIR TASK VAI AQUI -->
    <div id="modalDeleteTask">

    </div>

    <!-- MODAL CREATE TASK VAI AQUI -->
    <div id="modalCreateTask">

    </div>


</div>

<script type="module">
    import {
        fetchCreateTask,
        fetchDeleteTask,
        fetchEditTask
    } from "./js/api.js";
    import {
        renderTasks
    } from "./js/renderTasks.js";
    import {
        renderModalEdit
    } from "./js/renderModalEdit.js";
    import {
        renderModalDelete
    } from "./js/renderModalDelete.js";
    import {
        renderModalCreate
    } from "./js/renderModalCreate.js";

    renderTasks("task-list");

    //Mudar a paginação
    window.changePageTask = function(page) {
        renderTasks("task-list", page)

    }

    //Quando apertar criar task
    window.createTask = function() {

        renderModalCreate()

        const modalElement = document.getElementById("modalTarefa");
        const modal = new bootstrap.Modal(modalElement);
        modal.show();

        formTaskCreator.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(formTaskCreator);
            const data = Object.fromEntries(formData.entries());

            const taskData = {
                titulo: data.titulo,
                descricao: data.descricao,
                grupo: data.grupo,
                dateLimit: data.dateLimit
            };

            try {

                await fetchCreateTask(taskData);
                modal.hide();
                modalElement.remove();
                renderTasks("task-list");

            } catch (err) {

                console.error("Erro ao deletar tarefa:", err);

            }
        });


        console.log("oi euler :D")

    }

    //Quando apertar Excluir
    window.deleteTask = function(title, idTask) {

        renderModalDelete(title, idTask);

        const modalElement = document.getElementById("modalExcluir");
        const modal = new bootstrap.Modal(modalElement);
        modal.show();

        //Deletar Tarefa
        const formDelete = modalElement.querySelector("#formDeletTask");
        formDelete.addEventListener("submit", async (e) => {
            e.preventDefault();


            try {

                await fetchDeleteTask(idTask);
                modal.hide();
                modalElement.remove();
                renderTasks("task-list");

            } catch (err) {

                console.error("Erro ao deletar tarefa:", err);

            }
        });
    };

    //Quando apertar editar
    window.editTask = function(title, description, situation, group, timeout, idTask) {

        console.log(title, description, situation, group, timeout, idTask);


        renderModalEdit(title, description, status, group, timeout, idTask);

        const modalElement = document.getElementById("modalTarefaEditar");
        const modal = new bootstrap.Modal(modalElement);
        modal.show();

        const formEdit = document.getElementById("formTaskEdit");

        if (!formEdit) return;

        // Remove listener antigo para não duplicar
        formEdit.replaceWith(formEdit.cloneNode(true));
        const newFormEdit = document.getElementById("formTaskEdit");

        newFormEdit.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(newFormEdit);
            const data = Object.fromEntries(formData.entries());

            const taskData = {
                titulo: data.titulo === title ? null : data.titulo,
                descricao: data.descricao === description ? null : data.descricao,
                situation: data.situation === situation ? null : data.situation,
                grupo: data.grupo === group ? null : data.grupo,
                dateLimit: data.dataHora === timeout ? null : data.dataHora,
                idTask: idTask,
            };

            try {

                await fetchEditTask(taskData);
                renderTasks("task-list");
                modal.hide();

            } catch (err) {

                console.error("Erro ao editar tarefa:", err);

            }
        });
    };
</script>

<?php include 'includes/footer.php'; ?>