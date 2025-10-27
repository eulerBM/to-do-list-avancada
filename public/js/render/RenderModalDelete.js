import Request from '../requests/taskRequest.js'
import AlertResponse from '../alerts/alertResponse.js';
import Validade from '../validade/task/delete.js'
import { ValidationException } from '../exceptions/ValidationException.js';
import RenderTasks from './RenderTasks.js';

export default class RenderModalDelete {

    render(title, idTask) {

        this.htmlDeleteTask(title, idTask);

        const $modalElement = $("#modalDeleteTask");
        const modal = new bootstrap.Modal($modalElement[0]);
        modal.show();

       
        $(document).off("submit", "#formDeletTask").on("submit", "#formDeletTask", async function (e) {
            e.preventDefault();

            const request = new Request();
            const validade = new Validade();
            const renderTasks = new RenderTasks();

            try {

                const idTask = $(this).data("id");

                validade.delete(idTask)

                const response = await request.delete(idTask)

                modal.hide();
                $modalElement.remove();

                const alert = new AlertResponse(response);
                alert.normalShow()
        
                renderTasks.renderTasksWithPagination();

            } catch (error) {

                if (error instanceof ValidationException) {
                    return;
                }
                console.error("Erro ao deletar tarefa:", error);
            }
        });

    }


    htmlDeleteTask(title, idTask) {

        const itemHTML = `
       <!-- Modal para excluir -->
    <div class="modal fade" id="modalDeleteTask" tabindex="-1" aria-labelledby="modalTarefaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTarefaLabel">Excluir Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">

                    <form id="formDeletTask" data-id="${idTask}">

                        <div class="mb-3 text-center">
                            <label for="titulo" class="form-label">Deseja excluir a tarefa ${title} ?</label>
                        </div>

                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-danger">Excluir</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
      `;

        const $modalElement = $("#modalDeleteTask");
        if ($modalElement.length) {
            $modalElement.remove();
        }

        $("body").append(itemHTML);


        $(document).on("hidden.bs.modal", "modalDeleteTask", function () {
            $(this).remove();
        });

    }
}
