
export async function renderModalCreate(title, description, status, group, timeout, idTask) {
   
    const itemHTML = `
        <!-- Modal criar tarefa -->
    <div class="modal fade" id="modalTarefa" tabindex="-1" aria-labelledby="modalTarefaLabel" aria-hidden="true">
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
                            <label for="grupo" class="form-label">Grupo</label>
                            <input type="email" class="form-control form-control-sm" id="grupo" name="grupo[]" placeholder="Digite os e-mails dos usuários" multiple>
                            <small class="form-text text-muted">Separe os e-mails por vírgula.</small>
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

  const oldModal = document.getElementById("modalCreateTask");
  if (oldModal) oldModal.remove();

  
  document.body.insertAdjacentHTML("beforeend", itemHTML);

  const modalElement = document.getElementById("modalCreateTask");
  
 
  modalElement.addEventListener("hidden.bs.modal", () => {
    modalElement.remove();
    console.log("Modal removido do DOM ✅");
  });

}