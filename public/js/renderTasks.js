import { fetchAllTask, fetchTaskfilter } from "./api.js";
import { formatDate } from "./utils/formateDate.js";

export async function renderTasks(listId = "task-list", page = 1) {
  try {
    const result = await fetchAllTask(page);


    //Paginação
    const listPages = document.getElementById("list-total-pages")
    if (!listPages) {
      console.error(`Elemento #${listPages} não encontrado!`);
      return;
    }

    let totalPages = Number(localStorage.getItem("totalPages")) || 0;

    listPages.querySelectorAll(".page-item").forEach(li => li.remove());

    for (let i = 1; i <= totalPages; i++) {

      const itemHTML = `
        <li class="page-item"><a class="page-link" onclick="changePageTask(${i})">${i}</a></li>
      `;

      listPages.innerHTML += itemHTML;

    }


    const pendingList = document.getElementById("pending-tasks");
    const completedList = document.getElementById("completed-tasks");

    pendingList.innerHTML = "";
    completedList.innerHTML = "";

    if (!result.tasks || result.tasks.length === 0) {
      pendingList.innerHTML = `<li class="list-group-item text-muted text-center">📋 Nenhuma tarefa pendente.</li>`;
      completedList.innerHTML = `<li class="list-group-item text-muted text-center">✅ Nenhuma tarefa concluída.</li>`;
      return;
    }

    result.tasks.forEach(task => {
      const statusBadge = task.situation === 0
        ? '<span class="badge text-bg-warning">Pendente</span>'
        : '<span class="badge text-bg-success">Concluída</span>';

      const li = document.createElement("li");
      li.className = "list-group-item";
      li.dataset.id = task.idPublic;
      li.innerHTML = `
                <strong>Título:</strong> ${task.title}<br>
                <strong>Descrição:</strong> ${task.description}<br>
                <strong>Situação:</strong> ${statusBadge}<br>
                <strong>Data criação:</strong> ${formatDate(task.created_at)}<br>
                <strong>Data limite:</strong> ${formatDate(task.timeout)}<br>
                <strong>
                    <button type="button" class="btn btn-outline-secondary" onclick="editTask('${task.title}', '${task.description}', '${task.situation}', 'null', '${task.timeout}', '${task.idPublic}')">Editar</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="deleteTask('${task.title}', '${task.idPublic}')">Excluir</button>
                </strong>
            `;

      if (task.situation === 0) pendingList.appendChild(li);
      else completedList.appendChild(li);
    });

  } catch (err) {
    console.error("Erro ao carregar tarefas:", err);
  }
}











export async function renderTasksFilter(filter, page = 1) {
  try {
    const result = await fetchTaskfilter(filter, page);


    //Paginação
    const listPages = document.getElementById("list-total-pages")
    if (!listPages) {
      console.error(`Elemento #${listPages} não encontrado!`);
      return;
    }

    let totalPages = Number(localStorage.getItem("totalPages")) || 0;

    listPages.querySelectorAll(".page-item").forEach(li => li.remove());

    for (let i = 1; i <= totalPages; i++) {

      const itemHTML = `
        <li class="page-item"><a class="page-link" onclick="changePageTask(${i})">${i}</a></li>
      `;

      listPages.innerHTML += itemHTML;

    }


    const pendingList = document.getElementById("pending-tasks");
    const completedList = document.getElementById("completed-tasks");

    pendingList.innerHTML = "";
    completedList.innerHTML = "";

    if (!result.tasks || result.tasks.length === 0) {
      pendingList.innerHTML = `<li class="list-group-item text-muted text-center">📋 Nenhuma tarefa pendente.</li>`;
      completedList.innerHTML = `<li class="list-group-item text-muted text-center">✅ Nenhuma tarefa concluída.</li>`;
      return;
    }

    result.tasks.forEach(task => {
      const statusBadge = task.situation === 0
        ? '<span class="badge text-bg-warning">Pendente</span>'
        : '<span class="badge text-bg-success">Concluída</span>';

      const li = document.createElement("li");
      li.className = "list-group-item";
      li.dataset.id = task.idPublic;
      li.innerHTML = `
                <strong>Título:</strong> ${task.title}<br>
                <strong>Descrição:</strong> ${task.description}<br>
                <strong>Situação:</strong> ${statusBadge}<br>
                <strong>Data criação:</strong> ${formatDate(task.created_at)}<br>
                <strong>Data limite:</strong> ${formatDate(task.timeout)}<br>
                <strong>
                    <button type="button" class="btn btn-outline-secondary" onclick="editTask('${task.title}', '${task.description}', '${task.situation}', 'null', '${task.timeout}', '${task.idPublic}')">Editar</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="deleteTask('${task.title}', '${task.idPublic}')">Excluir</button>
                </strong>
            `;

      if (task.situation === 0) pendingList.appendChild(li);
      else completedList.appendChild(li);
    });

  } catch (err) {
    console.error("Erro ao carregar tarefas:", err);
  }


}

