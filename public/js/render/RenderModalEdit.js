import Request from '../requests/taskRequest.js'
import AlertResponse from '../alerts/alertResponse.js';
import Validade from '../validade/task/edit.js'
import { ValidationException } from '../exceptions/ValidationException.js';
import RenderTasks from './RenderTasks.js';

export default class RenderModalEdit {


    render(title, description, situation, timeout, idTask) {

        this.htmlEditTask(title, description, situation, timeout, idTask);

        const $modalElement = $("#modalTaskEdit");
        const modal = new bootstrap.Modal($modalElement[0]);
        modal.show();

        $(document).off("submit", "#formTaskEdit").on("submit", "#formTaskEdit", async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const request = new Request();
            const validade = new Validade();
            const renderTasks = new RenderTasks();

            const data = Object.fromEntries(formData.entries());

            const taskData = {
                title: data.title === title ? null : data.title,
                description: data.description === description ? null : data.description,
                situation: data.situation === situation ? null : data.situation,
                dateLimit: data.timeout === timeout ? null : data.timeout,
                idTask: idTask,
            };

            try {

                validade.noChanges(data.title, title, data.description, description, data.situation, situation, data.timeout, timeout)
                validade.edit(data.title, data.description, data.situation, data.timeout)

                const response = await request.edit(taskData)

                modal.hide();
                $modalElement.remove();

                const alert = new AlertResponse(response);
                alert.normalShow()

                renderTasks.renderTasksWithPagination();

            } catch (error) {
                
                if (error instanceof ValidationException) {
                    return;
                }

                console.error("Erro ao editar tarefa:", error);

            }
        });
    }


    htmlEditTask(title, description, situation, timeout, idTask) {

        let situationHtml = situation === 0 ? `<option value="0" selected>pendente</option>
    <option value="1">concluída</option>` : `<option value="1" selected>concluída</option><option value="0">pendente</option>`

        const itemHTML = `
        <!-- Modal editar tarefa -->
    <div class="modal fade" id="modalTaskEdit" tabindex="-1" aria-labelledby="modalTarefaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTarefaLabel">Editar Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <form id="formTaskEdit" data-id="${idTask}">
                        <div class="mb-3 text-center">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="Digite o título" value="${title}">
                        </div>
                        <div class="mb-3 text-center">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea class="form-control form-control-sm" id="description" name="description" rows="3" placeholder="Descrição">${description}</textarea>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="situation" class="form-label">Situação</label>
                            <select class="form-control form-control-sm" id="situation" name="situation">
                                ` + situationHtml + `
                                
                            </select>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="dataHora" class="form-label">Data limite</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="timeout" name="timeout" value="${timeout}">
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Concluído</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
      `;

       const $modalElement = $("#modalTaskEdit");
        if ($modalElement.length) {
            $modalElement.remove();
        }

        $("body").append(itemHTML);


        $(document).on("hidden.bs.modal", "modalTaskEdit", function () {
            $(this).remove();
        });

    }
}