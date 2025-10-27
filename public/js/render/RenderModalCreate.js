import Request from '../requests/taskRequest.js'
import AlertResponse from '../alerts/alertResponse.js';
import Validade from '../validade/task/create.js'
import { ValidationException } from '../exceptions/ValidationException.js';
import RenderTasks from './RenderTasks.js';

export default class RenderModalCreate {

    render() {

        this.htmlCreateTask();

        const $modalElement = $("#modalCreateTask");
        const modal = new bootstrap.Modal($modalElement[0]);
        modal.show();

        $(document).off("submit", "#formTaskCreator").on("submit", "#formTaskCreator", async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const request = new Request();
            const validade = new Validade();
            const renderTasks = new RenderTasks();

            const data = Object.fromEntries(formData.entries());


            const taskData = {
                titulo: data.titulo,
                descricao: data.descricao,
                dateLimit: data.dateLimit
            };

            try {

                validade.create(data.titulo, data.descricao, data.dateLimit)

                const response = await request.create(taskData);
                modal.hide();
                $modalElement.remove();

                const alert = new AlertResponse(response);
                alert.normalShow()
                renderTasks.renderTasksWithPagination();


            } catch (error) {

                if (error instanceof ValidationException) {
                    return;
                }

                throw new Error("Erro ao tentar criar tarefa")

            }
        });

    }


    htmlCreateTask() {

        const itemHTML = `
        <!-- Modal criar tarefa -->
    <div class="modal fade" id="modalCreateTask" tabindex="-1" aria-labelledby="modalTarefaLabel" aria-hidden="true">
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
                            <label for="dataHora" class="form-label">Data limite</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="dateLimit" name="dateLimit" required>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Criar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div> 
      `;

        const $modalElement = $("#modalCreateTask");
        if ($modalElement.length) {
            $modalElement.remove();
        }

        $("body").append(itemHTML);


        $(document).on("hidden.bs.modal", "#modalCreateTask", function () {
            $(this).remove();
        });

    }
}