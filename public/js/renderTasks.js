import { fetchAllTask } from "./api.js";
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

    for(let i = 1; i <= totalPages; i++){

      const itemHTML = `
        <li class="page-item"><a class="page-link" onclick="changePageTask(${i})">${i}</a></li>
      `;
    
      listPages.innerHTML += itemHTML;
      
    }


    //Listas de tarefas

    const list = document.getElementById(listId);
    if (!list) {
      console.error(`Elemento #${listId} não encontrado!`);
      return;
    }

    list.innerHTML = ""; // limpa a lista anterior

    // Se não houver tarefas
    if (!result.tasks || result.tasks.length === 0) {
      list.innerHTML = `
        <li class="list-group-item text-muted text-center">
          📋 Nenhuma tarefa encontrada.
        </li>
      `;
      return;
    }

    // Renderiza as tarefas
    result.tasks.forEach(task => {
      const statusForText =
        task.situation === 0
          ? "pendente"
          : "concluída";

      const statusBadge =
        task.situation === 0
          ? '<span class="badge text-bg-warning">Pendente</span>'
          : '<span class="badge text-bg-success">Concluída</span>';

      const itemHTML = `
        <li class="list-group-item">
          <strong>Título:</strong> ${task.title}<br>
          <strong>Descrição:</strong> ${task.description}<br>
          <strong>Situação:</strong> ${statusBadge}<br>
          <strong>Data criação:</strong> ${formatDate(task.created_at)}<br>
          <strong>Data limite:</strong> ${formatDate(task.timeout)}<br>
          <strong>
            <button type="button" class="btn btn-outline-secondary" onclick="editTask('${task.title}', '${task.description}', '${statusForText}', 'null', '${task.timeout}', '${task.idPublic}')">Editar</button>
            <button type="button" class="btn btn-outline-secondary" onclick="deleteTask('${task.title}', '${task.idPublic}')">Excluir</button>
          </strong>
        </li>
      `;

      list.innerHTML += itemHTML;
    });

  } catch (error) {
    console.error("Erro ao buscar tarefas:", error);
    const list = document.getElementById(listId);
    if (list) {
      list.innerHTML = `
        <li class="list-group-item text-danger text-center">
          ❌ Erro ao carregar tarefas.
        </li>
      `;
    }
  }
}
