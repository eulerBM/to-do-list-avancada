import Request from '../requests/taskRequest.js'
import { formatDate } from "../utils/formateDate.js";
import Validade from '../validade/task/filter.js'
import { ValidationException } from '../exceptions/ValidationException.js';

export default class RenderTasks {

    async renderTasksWithPagination(page = 1) {

        const request = new Request();
        const validade = new Validade();
        var response;

        try {

            const params = new URLSearchParams(window.location.search);

            if (params.get('filter') === "true") {

                const title = params.get("title")
                const description= params.get("description")
                const situation = params.get("situation")
                const order = params.get("order")
                const dateStart = params.get("dateStart")
                const endDate = params.get("endDate")

                validade.filter(title, description, situation, order, dateStart, endDate)

                const dataFilter = {
                    title: title,
                    description: description,
                    situation: situation,
                    order: order,
                    dateStart: dateStart,
                    endDate: endDate
                };

                response = await request.filter(dataFilter, page);

                this.#htmlPaginationButton(response.totalPages, page);
                this.#htmlTaskRendering(response)

            } else {

                response = await request.getTasksWithPagination(page);

                this.#htmlPaginationButton(response.totalPages, page);
                this.#htmlTaskRendering(response)
            }

        } catch(error){

            if (error instanceof ValidationException) {
                return;
            }

            console.error("Erro ao filtrar tarefa:", error);

        }
    }

    #htmlTaskRendering(response) {

        const pendingList = document.getElementById("pending-tasks");
        const completedList = document.getElementById("completed-tasks");

        pendingList.innerHTML = "";
        completedList.innerHTML = "";

        if (!response.tasks || response.tasks.length === 0) {
            pendingList.innerHTML = `<li class="list-group-item text-muted text-center">📋 Nenhuma tarefa pendente.</li>`;
            completedList.innerHTML = `<li class="list-group-item text-muted text-center">✅ Nenhuma tarefa concluída.</li>`;
            return;
        }

        response.tasks.forEach(task => {

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
              `;

            const buttonContainer = document.createElement("strong");

            const editButton = document.createElement("button");
            editButton.type = "button";
            editButton.className = "btn btn-outline-secondary me-2";
            editButton.textContent = "Editar";

            editButton.addEventListener("click", () => {
                editTask(
                    task.title,
                    task.description,
                    task.situation,
                    task.timeout,
                    task.idPublic
                );
            });

            const deleteButton = document.createElement("button");
            deleteButton.type = "button";
            deleteButton.className = "btn btn-outline-secondary";
            deleteButton.textContent = "Excluir";

            deleteButton.addEventListener("click", () => {
                deleteTask(task.title, task.idPublic);
            });


            buttonContainer.appendChild(editButton);
            buttonContainer.appendChild(deleteButton);
            li.appendChild(buttonContainer);


            if (task.situation === 0) {
                pendingList.appendChild(li);
            } else {
                completedList.appendChild(li);
            }

        });
    }

    #htmlPaginationButton(totalPages = 0, page) {

        const listPages = document.getElementById("list-total-pages")

        listPages.querySelectorAll(".page-item").forEach(li => li.remove());

        for (let i = 1; i <= totalPages; i++) {

            if (page === i) {

                const itemHTML = `
                    <li class="page-item"><a class="page-link" id="current" onclick="changePageTask(${i})">${i}</a></li>
                    `;
                listPages.innerHTML += itemHTML;
                continue;
            }

            const itemHTML = `
                    <li class="page-item"><a class="page-link" onclick="changePageTask(${i})">${i}</a></li>
                `;

            listPages.innerHTML += itemHTML;

        }
    }
}