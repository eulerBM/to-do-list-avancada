<?php
session_start();

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

    public function create($titulo, $descricao, $grupo, $dateLimit, $userCreatorId){

        try{

            $this->validade->requestTaskRegister($titulo, $descricao, $grupo, $dateLimit, $userCreatorId);

            $taskSave = $this->taskRepository->taskSave($titulo, $descricao, $grupo, $dateLimit, $userCreatorId);

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

    public function getTasks($idUser){

        try{

            $tasks = $this->taskRepository->getTasks($idUser);

            error_log("Tasks: " . print_r($tasks, true));

            if($tasks['isOk'] === false){

                $this->response->error(400, "Erro ao buscar as tarefas do usuario.");

            }

            $this->response->getAllTasks(200, $tasks['data']);

        }
        
        catch (Exception $e){

            $this->response->error(500, "Erro interno: " . $e->getMessage());
            
        }

    }

    public function delete($idTask){

        try{

            $this->response->taskCreate(201, "Tarefa criada.");

        } catch (ValidationException $e){

            $this->response->error($e->getStatus(), $e->getMessage());

        } catch (Exception $e){

            $this->response->error(500, "Erro interno: " . $e->getMessage());
            
        }

        
    }
}