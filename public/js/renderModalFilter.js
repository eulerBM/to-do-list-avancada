
export async function renderModalFilter(title, description, status, group, timeout, idTask) {
   
    const itemHTML = `
        <!-- Modal filter tarefa -->
    <div class="modal fade" id="modalFilter" tabindex="-1" aria-labelledby="modalTarefaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTarefaLabel">Filtros de Tarefas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <form id="formTaskCreator">
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
                            <label for="grupo" class="form-label">Grupo</label>
                            <input type="email" class="form-control form-control-sm" id="group" name="group[]" placeholder="E-mails dos usuários" multiple>
                            <small class="form-text text-muted">Separe os e-mails por vírgula.</small>
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

  const oldModal = document.getElementById("modalFiltrosTask");
  if (oldModal) oldModal.remove();

  
  document.body.insertAdjacentHTML("beforeend", itemHTML);

  const modalElement = document.getElementById("modalFiltrosTask");
  
 
  modalElement.addEventListener("hidden.bs.modal", () => {
    modalElement.remove();
    console.log("Modal removido do DOM ✅");
  });

}