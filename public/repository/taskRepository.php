<?php
require_once '../database/database.php';
require_once '../response/response.php';

class taskRepository
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function taskSave($titulo, $descricao, $grupo, $dateLimit, $userCreatorId)
    {

        try {

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
        } catch (PDOException $e) {

            return false;
        }
    }

    public function getTasks($userId, $page)
    {

        error_log("UUID do user" . $userId);
        $limite = 2;

        try {

            // 1️⃣ Conta total de tarefas do usuário
            $countStmt = $this->pdo->prepare("
            SELECT COUNT(*) as total
            FROM task
            WHERE user_creator_id = :userId
        ");
            $countStmt->bindValue(':userId', $userId, PDO::PARAM_STR);
            $countStmt->execute();
            $totalTasks = (int) $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

            $totalPages = ceil($totalTasks / $limite);

            // Calcula o offset (de onde começa)
            $offset = ($page - 1) * $limite;

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
                'data' => $tasks,
                'totalPages' =>  $totalPages
            ];
        } catch (PDOException $e) {
            return [
                'isOk' => false,
                'message' => 'Erro ao buscar tarefas: ' . $e->getMessage()
            ];
        }
    }

    public function editTask($titulo, $descricao, $situation, $dateLimit, $idTask, $idPublicUser)
    {
        
        $fields = [];
        $params = [':idTask' => $idTask, ':idPublicUser' => $idPublicUser];

        if ($titulo !== null && $titulo !== '') {
            $fields[] = "title = :titulo";
            $params[':titulo'] = $titulo;
        }
        if ($descricao !== null && $descricao !== '') {
            $fields[] = "description = :descricao";
            $params[':descricao'] = $descricao;
        }
        if ($situation !== null && $situation !== '') {
            $fields[] = "situation = :situation";
            $params[':situation'] = $situation;

        }

        if ($dateLimit !== null && $dateLimit !== '') {
            $fields[] = "timeout = :dateLimit";
            $params[':dateLimit'] = $dateLimit;
        }

        if (count($fields) === 0) {
            return false;
        }


        try {

            $sql = "UPDATE task SET " . implode(", ", $fields) . " WHERE idPublic = :idTask AND user_creator_id = :idPublicUser";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {

            return false;
        }
    }

    public function deleteTaskById($idTask, $idPublicUser)
    {

        try {

            $stmt = $this->pdo->prepare("
                DELETE FROM task WHERE idPublic = :idPublic AND user_creator_id = :userId
            ");

            $stmt->execute([
                ':idPublic' => $idTask,
                ':userId' => $idPublicUser

            ]);

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {

            return false;
        }
    }
}
