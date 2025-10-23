
export async function renderModalEdit(title, description, status, group, timeout, idTask) {
    console.log("status da tarefa :" + timeout)

    let statusForNumber = status === "pendente" ? 0 : 1;

    let statusHtml = statusForNumber == 0 ? `<option value="0" selected>pendente</option>
    <option value="1">concluída</option>` : `<option value="1" selected>concluída</option><option value="0">pendente</option>`

    const itemHTML = `
        <!-- Modal editar tarefa -->
    <div class="modal fade" id="modalTarefaEditar" tabindex="-1" aria-labelledby="modalTarefaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTarefaLabel">Editar Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <form id="formTaskEdit" data-id="${idTask}">
                        <div class="mb-3 text-center">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control form-control-sm" id="titulo" name="titulo" placeholder="Digite o título" value="${title}">
                        </div>
                        <div class="mb-3 text-center">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control form-control-sm" id="descricao" name="descricao" rows="3" placeholder="Descrição">${description}</textarea>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="situacao" class="form-label">Situação</label>
                            <select class="form-control form-control-sm" id="situation" name="situation">
                                ` + statusHtml + `
                                
                            </select>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="grupo" class="form-label">Grupo</label>
                            <input type="text" class="form-control form-control-sm" id="grupo" name="grupo" placeholder="Digite o email de cada pessoa" value="${group}">
                        </div>
                        <div class="mb-3 text-center">
                            <label for="dataHora" class="form-label">Data limite</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="dataHora" name="dataHora" value="${timeout}">
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

  const oldModal = document.getElementById("modalTarefaEditar");
  if (oldModal) oldModal.remove();

  
  document.body.insertAdjacentHTML("beforeend", itemHTML);

  const modalElement = document.getElementById("modalTarefaEditar");
  
 
  modalElement.addEventListener("hidden.bs.modal", () => {
    modalElement.remove();
    console.log("Modal removido do DOM ✅");
  });

}