import { fetchAllTask } from "./api.js"; // importa a função que faz o fetch

document.addEventListener("DOMContentLoaded", async () => {
  try {
    const result = await fetchAllTask();

    console.log("Tarefas do usuário:", result);

    const list = document.getElementById("task-list");
    if (!list) {
      console.error("Elemento #task-list não encontrado!");
      return;
    }

    list.innerHTML = ""; // limpa lista anterior

    // Se não houver tarefas:
    if (!result.tasks || result.tasks.length === 0) {
      list.innerHTML = `
        <li class="list-group-item text-muted text-center">
          📋 Nenhuma tarefa encontrada.
        </li>
      `;
      return;
    }

    // Se houver tarefas, renderiza cada uma:
    result.tasks.forEach(task => {
      const statusBadge = task.situation == 0
        ? '<span class="badge text-bg-warning">Pendente</span>'
        : '<span class="badge text-bg-success">Concluída</span>';

      const itemHTML = `
        <li class="list-group-item">
          <strong>Título:</strong> ${task.title}<br>
          <strong>Descrição:</strong> ${task.description}<br>
          <strong>Situação:</strong> ${statusBadge}<br>
          <strong>Data criação:</strong> ${task.created_at}<br>
          <strong>Data limite:</strong> ${task.timeout}<br>
          <strong>
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalTarefaEditar">Editar</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalTarefaExcluir" data-id="${task.idPublic}">Excluir</button>
          </strong>
        </li>
      `;

      list.innerHTML += itemHTML;
    });

  } catch (error) {
    console.error("Erro ao buscar tarefas:", error);
    const list = document.getElementById("task-list");
    if (list) {
      list.innerHTML = `
        <li class="list-group-item text-danger text-center">
          ❌ Erro ao carregar tarefas.
        </li>
      `;
    }
  }
});
