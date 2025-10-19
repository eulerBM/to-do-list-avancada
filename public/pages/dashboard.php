<?php include 'includes/header.php';
session_start();
?>

<link rel="stylesheet" href="../css/dashboard.css">

<div id="divMain" class="p-4">

    <div class="container">

    </div>

    <!-- Botão Criar Tarefa -->
    <button type="button" class="btn btn-outline-secondary mb-4" data-bs-toggle="modal" data-bs-target="#modalTarefa">
        Criar tarefa
    </button>

    <!-- 🔽 Seção de Tarefas -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Tarefas</h5>
        </div>

        <ul class="list-group list-group-flush">

            <li class="list-group-item">

                <strong>Título:</strong> Comprar leite<br>
                <strong>Descrição:</strong> Leite integral para o café da manhã<br>
                <strong>Situação:</strong> <span class="badge text-bg-warning">Pendente</span> <span class="badge text-bg-success">Concluida</span><br>
                <strong>Grupo:</strong> 4 pessoas<br>
                <strong>Data criação:</strong> 2025-10-20 08:00<br>
                <strong>Data limite:</strong> 2025-10-20 08:00<br>
                <strong>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalTarefaCriar">Editar</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalTarefaExcluir">Excluir</button>
                </strong>



            </li>
            <li class="list-group-item text-muted text-center">📋 Nenhuma tarefa encontrada.</li>
        </ul>
    </div>

    <!-- Modal para excluir -->
    <div class="modal fade" id="modalTarefaExcluir" tabindex="-1" aria-labelledby="modalTarefaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTarefaLabel">Excluir Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <form action="salvar_tarefa.php" method="POST">
                        <div class="mb-3 text-center">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control form-control-sm" id="titulo" name="titulo" placeholder="Digite o título" required>
                        </div>
                        
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Excluir</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal editar tarefa -->
    <div class="modal fade" id="modalTarefaCriar" tabindex="-1" aria-labelledby="modalTarefaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTarefaLabel">Editar Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <form action="salvar_tarefa.php" method="POST">
                        <div class="mb-3 text-center">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control form-control-sm" id="titulo" name="titulo" placeholder="Digite o título" required>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control form-control-sm" id="descricao" name="descricao" rows="3" placeholder="Descrição"></textarea>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="situacao" class="form-label">Situação</label>
                            <select class="form-control form-control-sm" id="situacao" name="situacao" required>
                                <option value="">Selecione...</option>
                                <option value="pendente">Pendente</option>
                                <option value="concluida">Concluída</option>
                            </select>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="grupo" class="form-label">Grupo</label>
                            <input type="text" class="form-control form-control-sm" id="grupo" name="grupo" placeholder="Digite o email de cada pessoa" required>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="dataHora" class="form-label">Data limite</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="dataHora" name="dataHora" required>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Criar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal criar tarefa -->
    <div class="modal fade" id="modalTarefa" tabindex="-1" aria-labelledby="modalTarefaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTarefaLabel">Nova Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <form action="salvar_tarefa.php" method="POST">
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
                            <input type="text" class="form-control form-control-sm" id="grupo" name="grupo" placeholder="Digite o email de cada pessoa" required>
                        </div>
                        <div class="mb-3 text-center">
                            <label for="dataHora" class="form-label">Data limite</label>
                            <input type="datetime-local" class="form-control form-control-sm" id="dataHora" name="dataHora" required>
                        </div>
                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Criar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

<?php include 'includes/footer.php'; ?>