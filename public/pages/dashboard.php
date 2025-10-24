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

    <!-- Botão Criar Tarefa -->
    <button type="button" class="btn btn-outline-secondary mb-4" onclick="filterTask()">
        Filtros
    </button>

    <!-- Colunas Pendentes / Concluídas -->
    <div class="task-columns d-flex gap-3">

        <!-- Pendentes -->
        <div class="task-column flex-fill">
            <h5 class="column-title">Pendentes</h5>
            <ul id="pending-tasks" class="list-group list-group-flush mb-3">
                <li class="list-group-item text-muted text-center">📋 Nenhuma tarefa pendente.</li>
            </ul>
        </div>

        <!-- Concluídas -->
        <div class="task-column flex-fill">
            <h5 class="column-title">Concluídas</h5>
            <ul id="completed-tasks" class="list-group list-group-flush mb-3">
                <li class="list-group-item text-muted text-center">✅ Nenhuma tarefa concluída.</li>
            </ul>
        </div>

    </div>

    <!-- BOTÃO DE PAGINAÇÃO -->
    <nav aria-label="Page navigation example" class="d-flex justify-content-center">

        <ul class="pagination" id="list-total-pages">

            <!-- BOTAO PAGINAÇÃO VAI AQUI -->

            </li>
        </ul>
    </nav>


    <!-- MODALS -->
    <div id="modalEditTask"></div>
    <div id="modalDeleteTask"></div>
    <div id="modalCreateTask"></div>
    <div id="modalFiltrosTask"></div>


</div>

<script type="module">
    import {
        fetchCreateTask,
        fetchDeleteTask,
        fetchEditTask
    } from "./js/api.js";
    import {
        renderTasks, renderTasksFilter
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
    import {
        renderModalFilter
    } from "./js/renderModalFilter.js";


    renderTasks("task-list");

    //Mudar a paginação
    window.changePageTask = function(page) {
        renderTasks("task-list", page)

    }

    //Quando apertar filtros 
    window.filterTask = function() {

        renderModalFilter()

        const modalElement = document.getElementById("modalFilter");
        const modal = new bootstrap.Modal(modalElement);
        modal.show();

        formTaskCreator.addEventListener("submit", async (e) => {
            e.preventDefault();

            console.log("to chamando a função filter")

            const formData = new FormData(formTaskCreator);
            const data = Object.fromEntries(formData.entries());

            const taskData = {
                title: data.title,
                description: data.description,
                situation: data.situation,
                order: data.order,
                group: data.group,
                dateStart: data.dateStart,
                endDate: data.endDate
            };

            console.log("dados filter enviados :", data)

            try {

                renderTasksFilter(taskData);
                modal.hide();
                modalElement.remove();

            } catch (err) {

                console.error("Erro ao filtra tarefa:", err);

            }
        });
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