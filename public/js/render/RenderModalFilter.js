import Request from '../requests/taskRequest.js'
import AlertResponse from '../alerts/alertResponse.js';
import Validade from '../validade/task/filter.js'
import { ValidationException } from '../exceptions/ValidationException.js';
import RenderTasks from './RenderTasks.js';

export default class RenderModalFilter {

    render() {

        this.htmlFilterTask();

        const $modalElement = $("#modalFilterTask");
        const modal = new bootstrap.Modal($modalElement[0]);
        modal.show();

        $(document).off("submit", "#formTaskFilter").on("submit", "#formTaskFilter", async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const request = new Request();
            const validade = new Validade();
            const renderTasks = new RenderTasks();

            const data = Object.fromEntries(formData.entries());

            const params = new URLSearchParams();

            const taskData = {
                title: data.title,
                description: data.description,
                situation: data.situation,
                order: data.order,
                dateStart: data.dateStart,
                endDate: data.endDate
            };

            try {

                validade.filter(data.title, data.description, data.situation, data.order, data.dateStart, data.endDate)

                params.set("filter", true);
                params.set("page", 1);
                params.set("title", data.title);
                params.set("description", data.description);
                params.set("situation", data.situation);
                params.set("order", data.order);
                params.set("dateStart", data.dateStart);
                params.set("endDate", data.endDate);

                const newUrl = `${window.location.pathname}?${params.toString()}`;
                window.history.replaceState({}, "", newUrl);

                const response = await request.filter(taskData)


                modal.hide();
                $modalElement.remove();

                console.log(response)

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

    htmlFilterTask() {

        const itemHTML = `
        <!-- Modal filter tarefa -->
    <div class="modal fade" id="modalFilterTask" tabindex="-1" aria-labelledby="modalTarefaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTarefaLabel">Filtros de Tarefas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <form id="formTaskFilter">
                        <div class="mb-3 text-center">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="Título">
                        </div>
                        <div class="mb-3 text-center">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control form-control-sm" id="description" name="description" rows="3" placeholder="Descrição"></textarea>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="situacao" class="form-label">Situação</label>
                            <select class="form-control form-control-sm" id="situation" name="situation">
                                <option value="" selected>selecione</option>
                                <option value="0">pendente</option>
                                <option value="1">concluída</option>
                            </select>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="situacao" class="form-label">Ordenar por</label>
                            <select class="form-control form-control-sm" id="order" name="order">
                                <option value="" selected>selecione</option>
                                <option value="ASC">Mais antigo</option>
                                <option value="DESC">Mais novo</option>
                            </select>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="dataHora" class="form-label">Data entre</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="dateStart" name="dateStart">
                            <small class="form-text text-muted">até</small>
                            <input type="datetime-local" class="form-control form-control-sm" id="endDate" name="endDate">
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div> 
      `;

        const $modalElement = $("#modalFilterTask");
        if ($modalElement.length) {
            $modalElement.remove();
        }

        $("body").append(itemHTML);

        $(document).on("hidden.bs.modal", "modalFilterTask", function () {
            $(this).remove();
        });

    }
}