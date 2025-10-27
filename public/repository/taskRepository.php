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

    public function taskSave($title, $description, $dateLimit, $userCreatorId)
    {

        try {

            $stmt = $this->pdo->prepare("
                INSERT INTO task (idPublic, user_creator_id, title, description, timeout) 
                VALUES (UUID(), :user_creator_id, :title, :description, :timeout)
            ");

            $stmt->execute([
                ':user_creator_id' => $userCreatorId,
                ':title' => $title,
                ':description' => $description,
                ':timeout' => $dateLimit
            ]);

            return true;
            
        } catch (PDOException $e) {

            return false;

        }
    }

    public function getTasks($userId, $page)
    {

        try {

            $countStmt = $this->pdo->prepare("
            SELECT COUNT(*) as total
            FROM task
            WHERE user_creator_id = :userId
            ");

            $countStmt->bindValue(':userId', $userId, PDO::PARAM_STR);
            $countStmt->execute();
        
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM task WHERE user_creator_id = :userId AND situation = 0");
            $stmt->bindValue(':userId', $userId, PDO::PARAM_STR);
            $stmt->execute();
            $totalPendentes = (int) $stmt->fetchColumn();

            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM task WHERE user_creator_id = :userId AND situation = 1");
            $stmt->bindValue(':userId', $userId, PDO::PARAM_STR);
            $stmt->execute();
            $totalConcluidas = (int) $stmt->fetchColumn();

            $limitPerType = 2;
            $totalPages = max(ceil($totalPendentes / $limitPerType), ceil($totalConcluidas / $limitPerType));
    
            $limitPerType = 2;
            $offsetPerType = ($page - 1) * $limitPerType;

            $stmt = $this->pdo->prepare("
                (
                    SELECT idPublic, title, description, situation, timeout, created_at, NULL AS total_pending, NULL AS total_completed
                    FROM (
                        SELECT *
                        FROM task
                        WHERE user_creator_id = :userId AND situation = 0
                        ORDER BY created_at DESC
                        LIMIT $limitPerType OFFSET $offsetPerType
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
                        LIMIT $limitPerType OFFSET $offsetPerType
                    ) AS completed
                )

            ");
            $stmt->bindValue(':userId', $userId, PDO::PARAM_STR);
            $stmt->execute();
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $pending = array_filter($tasks, fn($t) => $t['situation'] == 0);
            $completed = array_filter($tasks, fn($t) => $t['situation'] == 1);

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

    public function filterTask($page, $title, $description, $situation, $order, $dateStart, $endDate, $userCreatorId)
    {
        $conditions = [];
        $params = [];
        $situationConverted = ($situation === 'pendente') ? 0 : (($situation === 'concluida') ? 1 : null);

        if (!empty($title)) {
            $conditions[] = "LOWER(title) LIKE :title";
            $params[':title'] = "%$title%";
        }

        if (!empty($description)) {
            $conditions[] = "LOWER(description) LIKE :description";
            $params[':description'] = "%$description%";
        }
        if ($situationConverted === 0 || $situationConverted === 1) {
            $conditions[] = "situation = :situation";
            $params[':situation'] = $situationConverted;
        }
        if (!empty($dateStart)) {
            $conditions[] = "timeout >= :dateStart";
            $params[':dateStart'] = $dateStart;
        }

        if (!empty($endDate)) {
            $conditions[] = "timeout <= :endDate";
            $params[':endDate'] = $endDate;
        }

        $conditions[] = "user_creator_id = :userCreatorId";
        $params[':userCreatorId'] = $userCreatorId;

        $where = "";
        if (count($conditions) > 0) {
            $where = "WHERE " . implode(" AND ", $conditions);
        }

        $orderBy = "";
        if (!empty($order)) {
            $order = strtolower($order);
            if ($order === 'asc') {
                $orderBy = "ORDER BY created_at ASC";
            } elseif ($order === 'desc') {
                $orderBy = "ORDER BY created_at DESC";
            }
        }

        $limitPerType = 2;
        $offsetPerType = ($page - 1) * $limitPerType;

        if ($situationConverted === 0 || $situationConverted === 1) {

            $limitTotal = $limitPerType;

            $sql = "
        (
            SELECT idPublic, title, description, situation, timeout, created_at
            FROM task
            $where
            $orderBy
            LIMIT $limitPerType OFFSET $offsetPerType
        )
    ";
        } else {

            $limitTotal = $limitPerType * 2;

            $sql = "
        (
            SELECT idPublic, title, description, situation, timeout, created_at
            FROM task
            $where
            AND situation = 0
            $orderBy
            LIMIT $limitPerType OFFSET $offsetPerType
        )
        UNION ALL
        (
            SELECT idPublic, title, description, situation, timeout, created_at
            FROM task
            $where
            AND situation = 1
            $orderBy
            LIMIT $limitPerType OFFSET $offsetPerType
        )
    ";
        }

        $countSql = "SELECT COUNT(*) AS total FROM task $where";
        $countStmt = $this->pdo->prepare($countSql);
        $countStmt->execute($params);
        $totalRows = (int)$countStmt->fetchColumn();


        $totalPages = ceil($totalRows / $limitTotal);

        try {

            $stmt = $this->pdo->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'isOk' => true,
                'data' => $tasks,
                'message' => 'Tarefas filtradas.',
                'totalPages' => $totalPages
            ];
        } catch (PDOException $e) {
            return [
                'isOk' => false,
                'message' => 'Erro ao buscar tarefas filtradas: ' . $e->getMessage()
            ];
        }
    }


    public function editTask($title, $description, $situation, $dateLimit, $idTask, $idPublicUser)
    {

        $fields = [];
        $params = [':idTask' => $idTask, ':idPublicUser' => $idPublicUser];

        if ($title !== null && $title !== '') {
            $fields[] = "title = :titulo";
            $params[':titulo'] = $title;
        }
        if ($description !== null && $description !== '') {
            $fields[] = "description = :descricao";
            $params[':descricao'] = $description;
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
