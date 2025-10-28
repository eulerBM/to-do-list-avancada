<?php
if (!isset($_SESSION['user'])) {
    header("Location: /login");
    exit;
}
include 'includes/header.php'; ?>

<link rel="stylesheet" href="../css/dashboard.css">

<div id="divMain" class="p-4">

    <div class="container">

    </div>

    <button type="button" class="btn btn-outline-secondary mb-4" onclick="createTask()">
        Criar tarefa
    </button>

    <button type="button" class="btn btn-outline-secondary mb-4" onclick="filterTask()">
        Filtros
    </button>

    <div class="task-columns d-flex gap-3">

        <div class="task-column flex-fill">
            <h5 class="column-title">Pendentes</h5>
            <ul id="pending-tasks" class="list-group list-group-flush mb-3">
                <li class="list-group-item text-muted text-center">📋 Nenhuma tarefa pendente.</li>
            </ul>
        </div>

        <div class="task-column flex-fill">
            <h5 class="column-title">Concluídas</h5>
            <ul id="completed-tasks" class="list-group list-group-flush mb-3">
                <li class="list-group-item text-muted text-center">✅ Nenhuma tarefa concluída.</li>
            </ul>
        </div>

    </div>

    <nav aria-label="Page navigation example" class="d-flex justify-content-center">

        <ul class="pagination" id="list-total-pages">

        </ul>
    </nav>

</div>

<script type="module">
    
    import RenderModalCreate from "./js/render/RenderModalCreate.js";
    import RenderModalDelete from "./js/render/RenderModalDelete.js";
    import RenderModalEdit from "./js/render/RenderModalEdit.js";
    import RenderModalFilter from "./js/render/RenderModalFilter.js";
    import RenderTasks from './js/render/RenderTasks.js';

    const modalCreateTask = new RenderModalCreate();
    const modalDeleteTask = new RenderModalDelete();
    const modalEditTask = new RenderModalEdit();
    const modalFilterTask = new RenderModalFilter();
    const renderTasks = new RenderTasks();
    

    await renderTasks.renderTasksWithPagination();

    //Create Task
    window.createTask = () => modalCreateTask.render();

    //Delete Task
    window.deleteTask = (title, idTask) => modalDeleteTask.render(title, idTask);

    //Edit Task
    window.editTask = (title, description, situation, timeout, idTask) => modalEditTask.render(title, description, situation, timeout, idTask);

    //Filter Task
     window.filterTask = () => modalFilterTask.render();

    //Paginação
    window.changePageTask = (page) => renderTasks.renderTasksWithPagination(page); 

</script>

<?php include 'includes/footer.php'; ?>