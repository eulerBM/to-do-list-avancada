<?php

header("Content-Type: application/json");
require_once __DIR__ . '/../response/response.php';
require_once __DIR__ . '../../repository/taskRepository.php';
require_once __DIR__ . '../../utils/validade.php';

class taskService{

    private $response;
    private $taskRepository;
    private $validade;

    public function __construct(){
        
        $this->response = new Response();
        $this->taskRepository = new TaskRepository();
        $this->validade = new Validade();

    }

    public function create($title, $description, $dateLimit, $userCreatorId){

        try{

            $this->validade->requestTaskRegister($title, $description, $dateLimit, $userCreatorId);

            $taskSave = $this->taskRepository->taskSave($title, $description, $dateLimit, $userCreatorId);

            if(!$taskSave){

                $this->response->error(400, "Erro ao salvar a task no banco.");

            }

            $this->response->taskCreate(201, "Tarefa criada.");

        } catch (ValidationException $e){

            $this->response->error($e->getStatus(), $e->getMessage());

        } catch (Exception $e){

            $this->response->error(500, "Erro interno: " . $e->getMessage());
            
        }
    }

    public function edit($title, $description, $situation, $dateLimit, $idTask, $idPublicUser){

        try{

            $this->validade->requestTaskEdit($title, $description, $situation, $dateLimit, $idTask, $idPublicUser);

            $taskEdit = $this->taskRepository->editTask($title, $description, $situation, $dateLimit, $idTask, $idPublicUser);

            if(!$taskEdit){

                $this->response->error(400, "Erro ao editar a task no banco.");

            }

            $this->response->taskCreate(201, "Tarefa editada.");

        } catch (ValidationException $e){

            $this->response->error($e->getStatus(), $e->getMessage());

        } catch (Exception $e){

            $this->response->error(500, "Erro interno: " . $e->getMessage());
            
        }
    }

    public function getTasks($idUser, $page){

        try{

            $tasks = $this->taskRepository->getTasks($idUser, $page);

            if($tasks['isOk'] === false){

                $this->response->error(400, "Erro ao buscar as tarefas do usuario.");

            }

            $this->response->getAllTasks(200, $tasks['data'], $tasks['totalPages']);

        }
        
        catch (Exception $e){

            $this->response->error(500, "Erro interno: " . $e->getMessage());
            
        }

    }

    public function filterTask($page, $title, $description, $situation, $order, $dateStart, $endDate, $userCreatorId){

        try{

            $this->validade->requestTaskFilter($title, $description, $situation, $order, $dateStart, $endDate, $userCreatorId);

            $tasks = $this->taskRepository->filterTask($page, $title, $description, $situation, $order, $dateStart, $endDate, $userCreatorId);

            if($tasks['isOk'] === false){

                $this->response->error(400, "Erro ao buscar as tarefas filtradas.");

            }

            if(empty($tasks['data'])){

                $this->response->error(204, "Nenhuma Tarefa encontrada.");

            }

            $this->response->getFilterTasks(200, $tasks['data'], $tasks['message'], $tasks['totalPages']);

        } catch (ValidationException $e){

            $this->response->error($e->getStatus(), $e->getMessage());

        } catch (Exception $e){

            $this->response->error(500, "Erro interno: " . $e->getMessage());
            
        }

    }

    public function delete($idTask, $idPublicUser){

        try{

            $this->validade->requestTaskDelete($idTask, $idPublicUser);

            $isDelete = $this->taskRepository->deleteTaskById($idTask, $idPublicUser);

            if(!$isDelete){

                $this->response->error(404, "Tarefa não encontrada.");

            }

            $this->response->taskDelete(200, "Tarefa: " . $idTask .  " deletada com sucesso.");

        } catch (ValidationException $e){

            $this->response->error($e->getStatus(), $e->getMessage());

        } catch (Exception $e){

            $this->response->error(500, "Erro interno: " . $e->getMessage());
            
        }
    }
}