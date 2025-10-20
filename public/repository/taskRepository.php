<?php
require_once '../database/database.php';
require_once '../response/response.php';

class taskRepository {

    private $pdo;

    public function __construct(){
        $this->pdo = Database::getConnection();
    }

    public function taskSave($titulo, $descricao, $grupo, $dateLimit, $userCreatorId){

        try{

            $stmt = $this->pdo->prepare("
                INSERT INTO task (idPublic, user_creator_id, title, description, timeout) 
                VALUES (UUID(), :user_creator_id, :title, :description, :timeout)
            ");

            $stmt->execute([
                ':user_creator_id' => $userCreatorId,
                ':title' => $titulo,
                ':description' => $descricao,
                ':timeout' => $dateLimit
            ]);

            return true;

        } catch (PDOException $e){
            
            return false;
            
        }
    }

    public function getTasks($userId, $pagina = 1, $limite = 10){

        error_log("UUID do user" . $userId);

        try {
        // Calcula o offset (de onde começa)
        $offset = ($pagina - 1) * $limite;

            // Prepara a query paginada
        $stmt = $this->pdo->prepare("
            SELECT 
                idPublic, title, description, situation, timeout, created_at
            FROM task
            WHERE user_creator_id = :userId
            ORDER BY created_at DESC
            LIMIT :limite OFFSET :offset
        ");

        // Faz o bind (atenção: LIMIT e OFFSET precisam ser inteiros)
        $stmt->bindValue(':userId', $userId, PDO::PARAM_STR);
        $stmt->bindValue(':limite', (int) $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();

        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

         error_log("Tasks: " . print_r($tasks, true));

        return [
            'isOk' => true,
            'data' => $tasks
        ];

    } catch (PDOException $e) {
        return [
            'isOk' => false,
            'message' => 'Erro ao buscar tarefas: ' . $e->getMessage()
        ];
    }


    }

    public function editTask($titulo, $descricao, $grupo, $dateLimit, $idTask){


    }

    public function deleteById($idTask){

        try{

            $stmt = $this->pdo->prepare("
                DELETE FROM task WHERE idPublic = :idPublic
            ");

            $stmt->execute([
                ':idPublic' => $idTask
    
            ]);

            return true;

        } catch (PDOException $e){
            
            return false;
            
        }

    }

}
