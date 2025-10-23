
export async function renderModalDelete(title, idTask) {

    const itemHTML = `
       <!-- Modal para excluir -->
    <div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalTarefaLabel" aria-hidden="true">
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

    const oldModal = document.getElementById("modalExcluir");
    if (oldModal) oldModal.remove();

    document.body.insertAdjacentHTML("beforeend", itemHTML);

    const modalElement = document.getElementById("modalDeleteTask");


    modalElement.addEventListener("hidden.bs.modal", () => {
        modalElement.remove();
        console.log("Modal removido do DOM ✅");
    });

}

