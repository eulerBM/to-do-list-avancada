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

        $limit = 2;

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

            $totalPages = ceil($totalTasks / 4);

            // Calcula o offset (de onde começa)
            $offset = ($page - 1) * $limit;

            // Query usando UNION ALL para pegar 2 pendentes + 2 concluídas
            $stmt = $this->pdo->prepare("
                (
                    SELECT idPublic, title, description, situation, timeout, created_at, NULL AS total_pending, NULL AS total_completed
                    FROM (
                        SELECT *
                        FROM task
                        WHERE user_creator_id = :userId AND situation = 0
                        ORDER BY created_at DESC
                        LIMIT $limit OFFSET $offset
                    ) AS pending
                )
                UNION ALL
                (
                    SELECT idPublic, title, description, situation, timeout, created_at, NULL AS total_pending, NULL AS total_completed
                    FROM (
                        SELECT *
                        FROM task
                        WHERE user_creator_id = :userId AND situation = 1
                        ORDER BY created_at DESC
                        LIMIT $limit OFFSET $offset
                    ) AS completed
                )

            ");
            $stmt->bindValue(':userId', $userId, PDO::PARAM_STR);
            $stmt->execute();
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Separar pendentes e concluídas no array de retorno
            $pending = array_filter($tasks, fn($t) => $t['situation'] == 0);
            $completed = array_filter($tasks, fn($t) => $t['situation'] == 1);


            // Juntando tudo em um array só
            $tasks = array_merge(
                array_values($pending),
                array_values($completed)
            );

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

    public function filterTask($title, $description, $situation, $order, $group, $dateStart, $endDate, $userCreatorId)
    {

        $conditions = [];
        $params = [];


        if (!empty($title)) {
            $conditions[] = "LOWER(title) LIKE :title";
            $params[':title'] = "%$title%";
        }

        if (!empty($description)) {
            $conditions[] = "LOWER(description) LIKE :description";
            $params[':description'] = "%$description%";
        }

        if ($situation !== null && $situation !== '') {
            $conditions[] = "situation = :situation";
            $params[':situation'] = $situation;
        }

        if (!empty($dateStart)) {
            $conditions[] = "timeout >= :dateStart";
            $params[':dateStart'] = $dateStart;
        }

        if (!empty($endDate)) {
            $conditions[] = "timeout <= :endDate";
            $params[':endDate'] = $endDate;
        }

        // Filtro obrigatório: ID do criador
        $conditions[] = "user_creator_id = :userCreatorId";
        $params[':userCreatorId'] = $userCreatorId;

        // Monta o SQL dinâmico
        $sql = "SELECT idPublic, title, description, situation, timeout, created_at FROM task";
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        // Verifica se veio o parâmetro $order
        if (!empty($order)) {
            // Normaliza o valor para minúsculo
            $order = strtolower($order);

            // Define o sentido da ordenação de forma segura
            if ($order === 'asc') {
                $sql .= " ORDER BY created_at ASC";
            } elseif ($order === 'desc') {
                $sql .= " ORDER BY created_at DESC";
            }
        }

        try {
            error_log($sql);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'isOk' => true,
                'data' => $tasks,
                'totalPages' => null
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
